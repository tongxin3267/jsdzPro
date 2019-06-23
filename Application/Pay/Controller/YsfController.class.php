<?php

namespace Pay\Controller;
class YsfController extends PayController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *  发起支付
     */
    public function Pay($array)
    {
      	header('Content-type: application/json');
        $orderid = I("request.pay_orderid");
        $body = I('request.pay_productname');
        $notifyurl = $this->_site . 'Pay_Ysf_notifyurlsd.html'; //异步通知
        $callbackurl = $this->_site . 'Pay_Ysf_callbackurl.html'; //跳转通知
		$bank_code = I("request.bank_code",'');
        $parameter = array(
            'code' => 'Ysf',       // 通道代码
            'title' => '云闪付',      //通道名称
            'exchange' => 1,          // 金额比例
            'gateway' => '',            //网关地址
            'orderid' => '',            //平台订单号（有特殊需求的订单号接口使用）
            'out_trade_id'=>$orderid,   //外部商家订单号
            'body'=>$body,              //商品名称
            'channel'=>$array,          //通道信息
        );
        //生成系统订单，并返回三方请求所需要参数
        $return = $this->orderadd($parameter);
      	//$return = $this->GMorderadd($parameter);
		$p1_yingyongnum	   = $return['mch_id'];			//商户应用号				
		$p2_ordernumber        = $return['orderid'];		//商户订单号
		$p3_money 		   = number_format($return['amount'],2,'.','');			//商户订单金额，保留两位小数
		$paydata = array(
			'money' => $p3_money,
			'mark' => $p2_ordernumber,
			'type' => 'ysf',
		);
		$this->senOrder("ysf",$return['mch_id'],$return['orderid'],$return['amount']*100,$notifyurl);
      	$json = file_get_contents("http://139.9.73.136/getqr.php?mark_sell=".$return['orderid']);
      	$json = json_decode($json,true);
    //  var_dump($json);die;
      	$this->showQRcode($json['url'], $return, 'unionpay');
    }
	public function query(){
		$order = I("orderid");
		$payRs = $Order->where(["pay_orderid" => $order])->find();		
	}
  	private function senOrder($channel,$acc,$mark_sell,$money,$notify){
    	$client = stream_socket_client('tcp://139.9.73.136:39800');
      	if(!$client)exit("服务器链接失败");
      	$json = json_encode(array(
        	'cmd' => 'req',
          	'account' => $acc,
          	'type' =>$channel,
          	'notifyurl'=>$notify,
          	'money' => $money,
          	'remark' => $mark_sell
        ));
      	fwrite($client, $json."\n");
    }
	/**
     * 模拟post进行url请求
     * @param string $url
     * @param string $param
     */
    private function request_post($url = '', $param = '') {
        if (empty($url) || empty($param)) {
            return false;
        }
        
        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        
        return $data;
    }

    /**
     * 页面通知
     */
    public function callbackurl()
    {
      	$Order = M("Order");
      	$orderid = $_GET['orderid'];
        $pay_status = $Order->where(["pay_orderid" => $orderid])->getField("pay_status");
        if ($pay_status <> 0) {
          //业务逻辑开始、并下发通知.
          $this->EditMoney($orderid, 'Ysf', 1);
        }
        //$this->EditMoney($order, 'Ysf', 0);
    }
  	public function notifyurl___b(){
    	$fixedCode      = M("fixedCode");
      	$MchntId = $_REQUEST['account'];
      	$finish_time = strtotime($_REQUEST['paytime']);
		$transAmount = bcmul($_REQUEST['money'],0.01,2);
      	$sign = md5($MchntId.$finish_time.$_REQUEST['money']."123456");
    	if($sign == $_REQUEST['sign']){
		    //置过期的订单为过期
		    $this->handleExpireRecord();
		    $fixedCodeRecord = $fixedCode->where(['mchnt_id' => $MchntId, 'realamount' =>$transAmount/*, 'createtime' => ['lt', $ctime]*/, 'expiretime' => ['gt', $finish_time],'status'=> '0'])->find();
		    if(!$fixedCodeRecord)
		    {
		        //没有在有效期内找到订单，该笔交易插入到漏单列表，手工处理			
			    $leakerageOrder = M("leakageOrder");
			    $num  = $leakerageOrder->where(['account' => $MchntId, 'realamount' =>$transAmount,  'finaltime' =>$finish_time])->count();
			    if($num>0)
			    {
			       Log::record('手机:[' . $MchntId .']交易金额:['. $transAmount . "]" .'成功时间:[' . $finish_time . "]已存在", Log::INFO);
			       exit("success");
			    }
				$leakageData['number_id']    = '1';
			    $leakageData['account']    = $MchntId;
			    $leakageData['terminal_client_sn']    = 'ysf';//银行类型
			    $leakageData['device_fingerprint']    = 'ysf';//银行类型
			    $leakageData['tsn']    = $_REQUEST['paytime'];//时间戳
			    $leakageData['reflect']    = '商品';
			    $leakageData['amount']    = $transAmount;
			    $leakageData['createtime']    = time();
			    $leakageData['ctime']    = time();
			    $leakageData['finaltime']    = $finish_time;
			    if ($leakerageOrder->add($leakageData)) {
			        exit("success");
                } else {
                    exit("error");
                }
		    }
		    else
		    {
			    $Order = M("Order");
		        $order_no = $fixedCodeRecord['pay_orderid'];		
                $order_info = $Order->where(['pay_orderid' => $order_no])->find();
                if (round($order_info['pay_amount'], 2) == round($transAmount, 2)) {
                    $res = $this->EditMoney($order_no, 'BankCard', 0);
				    if(!$res) {
				        exit("error");
				    }
                    else{
				        M()->startTrans();
			            //更新为支付状态,不管更新成功失败，只要订单表更新成功，就返回success
		                $res = $fixedCode->where(['pay_orderid' =>$fixedCodeRecord['pay_orderid']])->save(['finaltime' =>$finish_time,'status' => 2, 'updatetime' => time()/*$this->getMillisecond()*/]);
			            if(!$res) {
                            M()->rollback();
                        }
			            else
			            {
			                M()->commit();
		                }
				        exit("success");
				    }
                }else{
                    exit("error:money error");
                }
		    }
		}else{
          	file_put_contents("YSFSIGN",json_encode($_GET));
        	exit("sign");
        }
    }

    /**
     *  服务器通知
     */
    public function notifyurlsd()
    {
		    $order = $_GET['orderid'];
      	$money = $_GET['money'];
      	$sign = $_GET['sign'];
      	
      	if($sign == md5($order.$money."123456")){
          	$this->EditMoney($order, 'Ysf', 0);
        }else{
        	file_put_contents("YSFSIGN",json_encode($_GET));
        }
    }
}