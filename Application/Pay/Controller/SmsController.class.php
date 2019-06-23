<?php
namespace Pay\Controller;
use MoneyCheck;
require_once("redis_util.class.php");
class SmsController extends PayController
{
    public function __construct()
    {
        parent::__construct();
    }  
    public function Pay($array=null)
    {
		
        $orderid = I("request.pay_orderid");
        $body = I('request.pay_productname','vip');
        $notifyurl = $this->_site . 'Pay_Sms_notifyurl.html'; //异步通知
        $callbackurl = $this->_site . 'Pay_Sms_callbackurl.html'; //跳转通知
        $pay_amount = I("post.pay_amount", 0);
        $moneyCheck = new MoneyCheck();
        
        $parameter = array(
            'code' => 'Sms',       // 通道代码
            'title' => '支付宝转卡',   //通道名称
            'exchange' => 1,          // 金额比例
            'gateway' => '',            //网关地址
            'orderid' => '',            //平台订单号（有特殊需求的订单号接口使用）
            'out_trade_id'=>$orderid,   //外部商家订单号
            'body'=>$body,              //商品名称
            'channel'=>$array,          //通道信息
        );   
        $return = $this->orderadd($parameter);
        while (!$moneyCheck->checkAccountMoney($return['account_id'],$pay_amount)) {
           $pay_amount=$pay_amount-0.01;
           
        }
        $checkResult = $moneyCheck->setAccountKey($return['account_id'],$pay_amount);
        if($checkResult){
            if($pay_amount!=$return['amount']){
            	M('Order')->where(['pay_orderid'=>$return['orderid']])->setField(['pay_amount'=>$pay_amount]);
            }
        }else{
            $this->showmessage('账户:交易量过大，限制交易！');
        }
		
		$return['amount'] = $pay_amount;//收银页面显示实际付款金额
		$cardNo = $return['signkey'];
		$bankAccount = urlencode($return['mch_id']); $money = $pay_amount;     //支付金额
		$bankMark = $return['appid'];
		$bankName = $return['appsecret'];
		$index = $return['zfb_pid']; //cardIndex
		 //写入订单实际待支付金额
	
		$url1 = 'https://www.alipay.com/?appId=09999988&actionType=toCard&sourceId=bill&orderSource=from&cardNoHidden=true&cardChannel=HISTORY_CARD&orderSource=from&cardIndex=';
        $url1 .= $index.'&cardNo='.$cardNo.'&bankAccount='.$bankAccount.'&receiverName='.$bankAccount.'&money='.$money.'&amount='.$money.'&bankMark='.$bankMark;//.$bankName;
		$url =	"taobao://render.alipay.com/p/s/i?scheme=".urlencode("alipays://platformapi/startapp?appId=09999988&actionType=toCard&sourceId=bill&cardNo={$cardNo}&bankAccount={$bankAccount}&money={$money}&amount={$money}&bankMark={$bankMark}&cardIndex={$index}&cardNoHidden=true&cardChannel=HISTORY_CARD&orderSource=from");

		$url_direct = "alipays://platformapi/startapp?appId=09999988&actionType=toCard&sourceId=bill&cardNo={$cardNo}&bankAccount={$bankAccount}&money={$money}&amount={$money}&bankMark={$bankMark}&cardIndex={$index}&cardNoHidden=true&cardChannel=HISTORY_CARD&orderSource=from";





		if(101==$_POST['pay_type']){
			$arr = [
				'status'=>'success',
				'data'=>$url
			];
			exit(json_encode($arr));
		}


 		$url1 = $this->shortUrl($url1);
		$this->assign('payurl',$url);
		$this->assign('url_direct',$url1);
     	import("Vendor.phpqrcode.phpqrcode", '', ".php");
        $QR = "Uploads/codepay/" . $return["orderid"] . ".png"; //已经生成的原始二维码图
        \QRcode::png($url1, $QR, "L", 20);
        $return['qrurl']=$url;
        $this->assign("imgurl", $this->_site . $QR);
        $this->assign('params', $return);
        $this->assign('orderid', $return['orderid']);
        $this->assign('money', $pay_amount);
        if($this->isMobile2()){
            $this->display("WeiXin/alipayQ");
        }else{
            $this->display("WeiXin/alipayori");
        }
	
   }

	public function shortUrl2($url)
	{
		$res = file_get_contents('https://soso.bz/api/?key=fKPN4dWHMeT3&url='.urlencode($url));
		//dump($res);
		return $res;
	}

    public function shortUrl($url){
        $source = '355369797';
        $sorturl = getSinaShortUrl($source, $url);
        return $sorturl[0]['url_short'];
    }

    //订单金额随机 
    public function money($x,$id=null)
    {
		$rand = mt_rand(1,50);  //表示正负 1-50分钱随机  50 可以自己修改 范围
		$map['pay_status'] = ['EQ','0'];
		$map['pay_channel_account'] = ['EQ',$id]; 
		$map['pay_applydate'] = ['GT',time()-600];
		$arr =	M('Order')->where($map)->field('pay_money')->select();  //状态未支付  时间5分钟内  入金渠道内的子账号相同  的金额 集合
		$new = [];
		foreach($arr as $k => $v){
			$new[] = $v['pay_money'];
		}
		for($i=1;$i<20;$i++)
		{	$m = $x;
			$m =  ($m-$rand*0.01);
			if(!in_array($m,$new)){
				return $m;
				break;
			}
		}
		exit('通道繁忙，请稍后再试');
    }
	
    public function callbackurl()
    {
        $this->display('WeiXin/success');
    }


        //{"command":"bank","payUser":"","money":"0.10","bankNo":"7114","createTime":"1548643637678","balance":"2.17","receiveUser":"","userid":"10018","sign":"eaa376199ddeab14cf28ce4f713782ff","PHPSESSID":"0rojv57u2s7naa02832uj6qkd3"}
    //异步通知
    public function notifyurl()
    {
        $data = $_REQUEST;
        file_put_contents('./Data/smsnotify.txt', "【".date('Y-m-d H:i:s')."】\r\n".json_encode($data)."\r\n\r\n",FILE_APPEND);

        $money = $data['money'];
        $userId  = $data['userid'];
      	if($userId!="abcdef"){
        	exit("key");
        }  
      	$lastFour  = $data['bankNo'];
        //$orderWhere['appsecret'] = $lastFour;
       // $orderWhere['pay_memberid'] = $userId;
        $orderWhere['pay_amount'] = $money;
        $orderWhere['pay_status'] = 0;
        $orderWhere['pay_bankcode'] = 903;
        $orderWhere['pay_applydate'] = ['GT',time()-300]; 
        $orderInfo = M('Order')->where($orderWhere)->select();
        $orderCount = count($orderInfo);
        if($orderCount<1){
            file_put_contents('./Data/smsorderfail.txt', "【".date('Y-m-d H:i:s')."】找不到订单：\r\n".json_encode($_REQUEST)."\r\n\r\n",FILE_APPEND);
            exit("order not found ");
        }
        if($orderCount==1){
            //正常订单该订单则为正常的
            $orderData = $orderInfo[0];
            $moneyCheck = new moneyCheck();
            $isSystemOrder = $moneyCheck->checkAccountMoney($orderData['account_id'],$money);
            if($isSystemOrder){
                //不是系统订单
                file_put_contents('./Data/smssystemfail.txt', "【".date('Y-m-d H:i:s')."】回调结果：\r\n".json_encode($_REQUEST)."\r\n\r\n",FILE_APPEND);
            	echo "非系统订单";die;
            }

            $result = $this->EditMoney($orderData['pay_orderid'], 'Sms', 0);
            $moneyCheck->deletAccountKey($orderData['account_id'],$money);
            echo "success";

        }

        if($orderCount>1){
            //匹配到多个订单
            file_put_contents('./Data/smserror.txt', "【".date('Y-m-d H:i:s')."】多个订单回调参数：\r\n".json_encode($_POST)."\r\n\r\n",FILE_APPEND);
            file_put_contents('./Data/smserror.txt', "【".date('Y-m-d H:i:s')."】多个订单列表：\r\n".json_encode($orderInfo)."\r\n\r\n",FILE_APPEND);
            $this->error("紧急错误！请联系管理员！");
        }


    }

     public function notify()
    {
        $res = I('post.');
        //file_put_contents('./Data/sms.txt', "【".date('Y-m-d H:i:s')."】回调结果：\r\n".json_encode($res)."\r\n\r\n",FILE_APPEND);
        $time = strtotime($res['time']);  //到账时间戳
        $machine = $res['machine_num']; //设备号
        $content = $res['content'];  
        $amount = $this->checkCard($content);
        file_put_contents('./Data/sms.txt', "【".date('Y-m-d H:i:s')."】回调结果：\r\n".$amount."\r\n\r\n",FILE_APPEND);
        $map['pay_applydate'] = ['GT',time()-300];  //查询条件1  当前时间到过去5分钟内的订单
        $map['pay_amount'] = ['EQ',$amount];    //查询条件2   金额一致     
        $map['pay_status'] = ['EQ','0'];     //查询条件3   状态为未支付
        $map['account_id'] = ['EQ',$machine]; //查询条件4 渠道账号 
        $query = M('Order')->where($map)->find();
        if($query){
            $moneyCheck = new moneyCheck();
            $isSystemOrder = $moneyCheck->checkAccountMoney($query['account_id'],$amount);
            if($isSystemOrder){
                //不是系统订单
                file_put_contents('./Data/smssystemfail.txt', "【".date('Y-m-d H:i:s')."】回调结果：\r\n".json_encode($_REQUEST)."\r\n\r\n",FILE_APPEND);
                echo "非系统订单";die;
            }
            $this->EditMoney($query['pay_orderid'],'Sms',0); 
            $moneyCheck->deletAccountKey($query['account_id'],$amount);
            echo 'success';
        }   
    }

    public function checkCard($content=null)
    {  
    	$bankType = [
    		'EMS'  => '邮储银行',
    		'ABC'  => '中国农业银行',
    		'CCB'  => '建设银行',
    		'CEB'  => '光大银行',
    		'ICBC' => '工商银行',
    		'CMB'  => '招商银行',
    		'CMBC' => '民生银行',
            'PingAn'=>'平安银行',
    		'BOC'=>'中国银行',
            'CIB'=>'兴业银行'
    	];
    	$check = '';
    	foreach($bankType as $k => $v){
    	   if(strpos($content,$v)) {
    	     $check =  $k;
    	     break;
    	   }
    	}
    	$amount = '';
    	switch($check){
    		case 'CEB':
    			$amount =  strstr(substr(strstr($content,'存入'),6),'元，余额',true);
    			break;
    		case 'ABC':
    			$amount = strstr(substr(strstr($content,'交易人民币'),15),'，余额',true);
    			break;
    		case 'CCB':
    			$amount = substr(strstr($content,'收入人民币'),15,strpos(strstr($content,'收入人民币'),'元,活')-15);
    			break;
    		case 'EMS':
    			$amount = strstr(substr(strstr($content,'金额'),6),'元，余额',true);
    			break;
    		case 'ICBC':
    			$amount = strstr(substr(strstr($content,')'),1),'元，余额',true);
    			break;
    		case 'CMB':
    			$amount = strstr(substr(strstr($content,'人民币'),9),'，备注',true);
    			break;
    		case 'CMBC':
    		    $amount = strstr(substr(strstr($content,'￥'),3),'元，',true);
    		    break;
    		case 'PingAn':
    			$amount = strstr(substr(strstr($content,'入人民币'),12),'元',true);
    			break;
            case 'BOC':
                $amount = strstr(substr(strstr($content,'入人民币'),12),'元',true);
                break;
            case 'CIB':
                $amount = strstr(substr(strstr($content,'付款收入'),12),'元',true);
                break;
    		default :
    			file_put_contents('./Data/SmsFail.txt',$content.PHP_EOL,FILE_APPEND);

    	}

    	return $amount;
    	
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

}
