<?php
/**
 * Created by PhpStorm.
 * User: gaoxi
 * Date: 2017-05-18
 * Time: 11:33
 */
namespace Pay\Controller;

use MoneyCheck;
require_once("redis_util.class.php");
class AliNewZzController extends PayController
{
    public function __construct()
    {
        parent::__construct();

    }
    //Pay_Gaoji_notifyurl.html
    //支付
    public function Pay($array)
    {
        $orderid = I("request.pay_orderid");
        $body = I('request.pay_productname');
        $contentType = I("request.content_type");
        $returnType=I("request.return_type",1);
        $pay_amount = I("post.pay_amount", 0);
        $moneyCheck = new MoneyCheck();
        $parameter = array(
            'code' => 'AliNewZz', // 通道名称
            'title' => '支付宝转账(免签)',
            'exchange' => 1, // 金额比例
            'gateway' => '',
            'orderid' => '',
            'out_trade_id' => $orderid,
            'body'=>$body,
            'channel'=>$array
        );
        // 订单号，可以为空，如果为空，由系统统一生成
        $return = $this->orderadd($parameter);
        while (!$moneyCheck->checkAccountMoney($return['account_id'],$pay_amount)) {
           $pay_amount=$pay_amount+0.01;
           
        }
        $checkResult = $moneyCheck->setAccountKey($return['account_id'],$pay_amount);
        if($checkResult){
            if($pay_amount!=$return['amount']){
                M('Order')->where(['pay_orderid'=>$return['orderid']])->setField(['pay_amount'=>$pay_amount]);
            }
        }else{
            $this->showmessage('账户:交易量过大，限制交易！');
        }
        
        $qrcode=U('AliNewZz/skpay',array('id'=>$return['orderid']),true,true);
        $qrcode="alipays://platformapi/startapp?appId=09999988&actionType=toAccount&goBack=NO&amount=".$pay_amount."&userId=".$return['appid']."&memo=";
        // $encodeInfo = "alipays://platformapi/startapp?appId=20000691&url=".urlencode($qrcode); 
        M('Order')->where(['pay_orderid'=>$return['orderid']])->setField(['qrurl'=>$qrcode]);
        $this->assign('orderid',$return['orderid']);
        $this->assign('encodeInfo',$qrcode);
        $this->assign('success_url',$return['callbackurl']);
        $this->assign('money',sprintf('%.2f',$pay_amount));
        if($this->isMobile2()){
            $this->display("AliNewZz/alipayMobile");
        }else{
            $this->display("AliNewZz/alipayMobile");
        }
    }


    //订单查询
    public function automaticAlipayQuery(){
        $orderid = $_REQUEST['id'];
        $orderWhere['pay_orderid'] =$orderid;
        $order = M('Order')->where($orderWhere)->find();
        if (!is_array($order)){
            $return['code']=-1;
            $return['msg']='交易号不存在！';
            $this->ajaxReturn($return,'JSON');
        } 
        
        if ($order['pay_status'] == 0) {
            if (($order['pay_applydate'] + 299) < time()) {
                 M('Order')->where(['pay_orderid'=>$orderid])->setField(['pay_status'=>3]);
                $return['code']=-2;
                $return['msg']='当前订单已经过期,请重新发起支付！';
                $this->ajaxReturn($return,'JSON');
            }


            $appid="2019032263663021";//支付宝APPID
            $redirect_uri = $order['qrurl'];
            $data['url'] =$order['qrurl'];
            $data['h5'] = $order['qrurl'];
            $data['qrcode'] =$data['url'];
            $return['code']=100;
            $return['msg']='请扫码支付';
            $return['data']=$data;
            $this->ajaxReturn($return,'JSON');
        }
        if ($order['status'] == 3){
            $return['code']=-2;
                $return['msg']='当前订单已经过期,请重新发起支付！';
                $this->ajaxReturn($return,'JSON');
        }
        if ($order['pay_status'] == 2){
            $return['code']=200;
                $return['msg']='当前订单已经支付成功!';
                $this->ajaxReturn($return,'JSON');
            
        }
    }

    public function skpay()
    {
        if (!$this->isAliClient()) {
            exit("订单号错误");
        }
        $orderId = $_GET['id'];
        $orderWhere['pay_orderid'] = $_GET['id'];
        $order = M('Order')->where($orderWhere)->find();
        $amount =  sprintf('%.2f', $order['pay_amount']);
        if(empty($order)){
            exit("订单失效");
        }
        if($order['pay_status']!=0){
            exit("订单已支付");
        }
        $mark=$order['account_id'] . '|' . $order['id'];
        $order['mark'] = $mark;
        $a = array("空调"=>"空调","点卡"=>"点卡","灯泡"=>"灯泡","玩具"=>"玩具","灯泡"=>"灯泡","内衣"=>"内衣","灯泡"=>"灯泡","窗帘"=>"窗帘","键盘"=>"键盘","点卡"=>"点卡","鼠标"=>"鼠标","发夹"=>"发夹","门铃"=>"门铃","定时器"=>"定时器","钟表"=>"钟表","游戏机"=>"游戏机","发圈"=>"发圈","指南针"=>"指南针","防盗器"=>"防盗器","随身听"=>"随身听","复读机"=>"复读机","收音机"=>"收音机","手套"=>"手套","皮带"=>"皮带","毛巾"=>"毛巾","帽子"=>"帽子","钱包"=>"钱包");
        $b = array_rand($a);
        
        $this->assign('user_id',$order['account']);
        $this->assign('name',$order['memberid']);
        $this->assign('amount',sprintf('%.2f',$order['pay_amount']));
        $this->assign('b',$b);
        $this->assign('mark',$order['mark']);
        $this->display("AliNewZz/skpay");

    }
    // {"dt":"1555511830004","no":"20190417200040011100320039284910","money":"1.00","id":"\u73a9\u5177","order":"319|1280","key":"12345678","today_money":"","today_pens":""}
    public function notify(){
        $data = $_POST;
        file_put_contents('./Data/AliNewZz.txt', "【".date('Y-m-d H:i:s')."】\r\n".json_encode($data)."\r\n\r\n",FILE_APPEND);
        if($data['key']!='12345678'){
            exit("签名错误");
        }
        $paytime=time()-300;
        // $ac=explode('|',$data['order']);
        // $orderid=$ac[1];
        $pay_amount = str_replace("￥", '', $data['money']);
        $orderWhere['pay_amount'] =str_replace("￥", '', $data['money']);
        $orderWhere['pay_status'] = 0;
        $orderWhere['pay_applydate'] = array('gt',$paytime);
        $orderInfo = M('Order')->where($orderWhere)->find();
        if(empty($orderInfo)){
            exit("ok");
        }
        $pay_amount = str_replace("￥", '', $data['money']);
        
        $moneyCheck = new moneyCheck();
        $isSystemOrder = $moneyCheck->checkAccountMoney('AliNewZz',$pay_amount);
        if($isSystemOrder){
            //不是系统订单
            file_put_contents('./Data/AliNewZz.txt', "【".date('Y-m-d H:i:s')."】回调结果：\r\n".json_encode($_REQUEST)."\r\n\r\n",FILE_APPEND);
            echo "非系统订单";die;
        }
        $result = $this->EditMoney($orderInfo['pay_orderid'], 'AliNewZz', 0);
        $moneyCheck->deletAccountKey($return['account_id'],$pay_amount);
        exit(json_encode(array("code" => 200, "msg" => '回调成功')));        

    }

    public function shortUrl($url)
    {
        $res = file_get_contents('https://soso.bz/api/?key=fKPN4dWHMeT3&url='.urlencode($url));
        //dump($res);
        return $res;
    }

    public function skf2(){
        $orderId = $_GET['id'];
        $urltemp = U('AliNewZz/skf',array('id'=> $orderId),true,true);
        $sk = new \authorize();
        $url = $sk->geturl($urltemp);
        header("Location:".$url);
        // echo 111;
    }

    public function check(){

      $orderid = $_REQUEST['orderid'];
        $orderWhere['pay_orderid'] =$orderid;
        $orderInfo = M('Order')->where($orderWhere)->find();
      $amount =  sprintf('%.2f', $orderInfo['pay_amount']);
    if($_REQUEST['type']==1){
    $this->send($orderInfo['key'],$amount,$orderid,$orderInfo['pay_channel_account'],$orderInfo['pay_channel_account']);die;}
      if(!empty($orderInfo['memberid'])){
         header('Content-type: application/json');
        exit(json_encode(array("state" => 1, "callback" => $orderInfo['memberid'])));
      }
      else{
        if($_REQUEST['type']%4==0&&$_REQUEST['type']>=4){
		   $this->send($orderInfo['key'],$amount,$orderid,$orderInfo['pay_channel_account'],$orderInfo['pay_channel_account']);}
      	echo "no";
      }
    }
  
    public function skf(){

        if (!$this->isAliClient()) {
            exit("订单号错误");
        }
        $orderId = $_GET['id'];
        $orderWhere['pay_orderid'] = $_GET['id'];
        $order = M('Order')->where($orderWhere)->find();
        $amount =  sprintf('%.2f', $order['pay_amount']);
        if(empty($order)){
            exit("订单失效");
        }
        if($order['pay_status']!=0){
            exit("订单已支付");
        }
        $url = U('Gao/skf',array('id'=>$orderId),true,true);
        $url = $url."?one=1";


        $one = $_GET['one']?$_GET['one']:0;
        if($one){
            $this->assign('orderid',$_GET['id']);
            $this->assign('url',$url);
            $this->assign('userid',$order['account']);
            $this->assign('account',$order['pay_channel_account']);
            $this->assign('amount',sprintf('%.2f', $order['pay_amount']));
            $this->display('WeiXin/b');die;
        }
        else{
            $this->assign('orderid',$_GET['id']);
            $this->assign('url',$url);
            $this->assign('userid',$order['account']);
            $this->assign('account',$order['pay_channel_account']);
            $this->assign('amount',sprintf('%.2f', $order['pay_amount']));
            
            $sk = new \authorize();
            $data = $sk->getToken();
            M('Order')->where($orderWhere)->save(['key'=>$uid]);
            $uid = $data['alipay_system_oauth_token_response']['user_id'];
            file_put_contents('./Data/number.txt', "【".date('Y-m-d H:i:s')."】\r\n".json_encode($data)."\r\n\r\n",FILE_APPEND);

            if(empty($uid)||is_null($uid)){
                exit("非法来源，请从手机支付宝内付款");
            }
            else{
                M('Order')->where($orderWhere)->save(['key'=>$uid]);
            }
            $this->display('WeiXin/AliNewZz');

        }


    }
    /**
     * 判断是否支付宝内置浏览器访问
     * @return bool
     */
    private function isAliClient() {
        $isAli = strpos($_SERVER['HTTP_USER_AGENT'], 'Alipay') !== false;
        //$isAli_1 = empty($_SERVER['HTTP_SPDY_H5_UUID']) !== true;
        $result = $isAli; // && $isAli_1;
        return $result;
    }





    public function isInAlipayClient()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false) {
            return true;
        }
        return false;
    }
    //检测是否手机访问
    static public function isMobile(){
        $useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';
        function CheckSubstrs($substrs,$text){
            foreach($substrs as $substr)
                if(false!==strpos($text,$substr)){
                    return true;
                }
            return false;
        }
        $mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');
        $mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');

        $found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) ||
            CheckSubstrs($mobile_token_list,$useragent);

        if ($found_mobile){
            return true;
        }else{
            return false;
        }
    }


    public function isMobile2(){
        $useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';
        function CheckSubstrs($substrs,$text){
            foreach($substrs as $substr)
                if(false!==strpos($text,$substr)){
                    return true;
                }
            return false;
        }
        $mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');
        $mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');

        $found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) ||
            CheckSubstrs($mobile_token_list,$useragent);

        if ($found_mobile){
            return true;
        }else{
            return false;
        }
    }





    public function callbackurl()
    {
        $Order      = M("Order");       
        $pay_status = $Order->where(['pay_orderid' => $_REQUEST["orderid"]])->getField("pay_status");
        if ($pay_status <> 0) {
            $this->EditMoney($_REQUEST["orderid"], '', 1);
        } else {
            exit("交易成功！");
        }
    }

    //异步通知
    public function notifyurl()
    {
       // {"sUserId":"2088432628402085","userId":"2088302839252325","price":"1.10","outOrderNo":"20190331200040011100320025813946","agencyId":"190391622","time":"1554035708206","sign":"c2f4b345551bf96a6ca13f4dfc432b90"}
        $data = $_POST;
        file_put_contents('./Data/AliNewZz.txt', "【".date('Y-m-d H:i:s')."】\r\n".json_encode($data)."\r\n\r\n",FILE_APPEND);

        $where['pay_amount'] = $data['price'];
        $where['account']=$data['sUserId'];
        $where['key']=$data['userId'];
        // $where['pay_memberid']=$data['agencyId'];
        $where['pay_status']=0;
        $orderInfo = M('Order')->where($where)->order('id desc')->find();

        if(empty($orderInfo)){
            exit("ok");
        }
        // $m=intval($where['pay_memberid'])-10000;
        // $key=M('member')->where(['id'=>$m])->getField('apikey');
        $key='1561236';

        $signStr = $data['sUserId'].$data['userId'].$data['price'].$data['outOrderNo'].$data['agencyId'].$data['time'].$key;
        $sign = md5($signStr);
        // file_put_contents('./Data/AliNewZz.txt', "【".date('Y-m-d H:i:s')."】\r\n".$sign."\r\n\r\n",FILE_APPEND);
        if($sign!=$data['sign']){
            file_put_contents('./Data/AliNewZz.txt', "【".date('Y-m-d H:i:s')."】\r\n".$sign."\r\n\r\n",FILE_APPEND);
            exit("签名错误");
        }

        $this->EditMoney($orderInfo['pay_orderid'], 'AliNewZz', 0);
		$this->showmessage("处理成功");
       
    }
    protected function showmessage($msg = '', $fields = array())
    {
        header('Content-Type:application/json; charset=utf-8');
        $data = array('result' => '200', 'msg' => $msg, 'data' => $fields);
        echo json_encode($data, 320);
        exit;
    }


    function getIP() {
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")) {
                $realip = getenv( "HTTP_X_FORWARDED_FOR");
            } elseif (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        }
        return $realip;
    }
}
