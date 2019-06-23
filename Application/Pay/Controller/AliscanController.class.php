<?php

    namespace Pay\Controller;

    class AliscanController extends PayController{

        protected $at;

        public function __construct()
        {
          parent::__construct();
          $this->at = C('ZFB');//获取支付宝的数组数据
        }

        public function pay($array){
          
            Vendor("AlipayF2F.f2fpay.model.builder.AlipayTradePrecreateContentBuilder");
            Vendor("AlipayF2F.f2fpay.service.AlipayTradeService");
            $gateWay = $this->at['gatewayUrl'];//获取网关 (可配置可从数据里面获取)
            $orderid     = I("request.pay_orderid");
            $body        = I('request.pay_productname');
            $parameter = array(
                'code'         => "Aliscan", // 通道名称
                'title'        => '支付宝当面付',
                'exchange'     => 1, // 金额比例
                'gateway'      => $gateWay,
                'orderid'      => $orderid,
                'out_trade_id' => $orderid,
                'body'         => $body,
                'channel'      => $array,
            );
            
            $return = $this->orderadd($parameter);//生成系统订单
            $config = array (
                'sign_type' => "RSA2",
                'alipay_public_key' => $return['signkey'],
                'merchant_private_key' => $return['appsecret'],
                'charset' => "UTF-8",
                'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
                'app_id' => $return['appid'],
                'notify_url' => "http://www.baidu.com",
                'MaxQueryRetry' => "10",
                'QueryDuration' => "3"
            );
            $outTradeNo = $orderid;

            // (必填) 订单标题，粗略描述用户的支付目的。如“xxx品牌xxx门店当面付扫码消费”
            $subject = $body;

            // (必填) 订单总金额，单位为元，不能超过1亿元
            // 如果同时传入了【打折金额】,【不可打折金额】,【订单总金额】三者,则必须满足如下条件:【订单总金额】=【打折金额】+【不可打折金额】
            $totalAmount = $return['pay_amount'];
            $undiscountableAmount = "0.01";

            // 订单描述，可以对交易或商品进行一个详细地描述，比如填写"购买商品2件共15.00元"
            $body = "购买商品2件共15.00元";

            //商户操作员编号，添加此参数可以为商户操作员做销售统计
            $operatorId = "test_operator_id";
            $storeId = "test_store_id";
            // 支付宝的店铺编号
            $alipayStoreId= "test_alipay_store_id";

            // 业务扩展参数，目前可添加由支付宝分配的系统商编号(通过setSysServiceProviderId方法)，系统商开发使用,详情请咨询支付宝技术支持
            $providerId = $return['zfb_pid']; //系统商pid,作为系统商返佣数据提取的依据
            $extendParams = new \ExtendParams();
            $extendParams->setSysServiceProviderId($providerId);
            $extendParamsArr = $extendParams->getExtendParams();

            // 支付超时，线下扫码交易定义为5分钟
            $timeExpress = "5m";

            // 商品明细列表，需填写购买商品详细信息，
            $goodsDetailList = array();

            // 创建一个商品信息，参数含义分别为商品id（使用国标）、名称、单价（单位为分）、数量，如果需要添加商品类别，详见GoodsDetail
            $goods1 = new \GoodsDetail();
            $goods1->setGoodsId("apple-01");
            $goods1->setGoodsName("iphone");
            $goods1->setPrice(3000);
            $goods1->setQuantity(1);
            //得到商品1明细数组
            $goods1Arr = $goods1->getGoodsDetail();

            // 继续创建并添加第一条商品信息，用户购买的产品为“xx牙刷”，单价为5.05元，购买了两件
            $goods2 = new \GoodsDetail();
            $goods2->setGoodsId("apple-02");
            $goods2->setGoodsName("ipad");
            $goods2->setPrice(1000);
            $goods2->setQuantity(1);
            //得到商品1明细数组
            $goods2Arr = $goods2->getGoodsDetail();

            $goodsDetailList = array($goods1Arr,$goods2Arr);

            //第三方应用授权令牌,商户授权系统商开发模式下使用
            // $appAuthToken = "";//根据真实值填写

            // 创建请求builder，设置请求参数
            $qrPayRequestBuilder = new \AlipayTradePrecreateContentBuilder();
            $qrPayRequestBuilder->setOutTradeNo($outTradeNo);
            $qrPayRequestBuilder->setTotalAmount($totalAmount);
            $qrPayRequestBuilder->setTimeExpress($timeExpress);
            $qrPayRequestBuilder->setSubject($subject);
            $qrPayRequestBuilder->setBody($body);
            $qrPayRequestBuilder->setUndiscountableAmount($undiscountableAmount);
            $qrPayRequestBuilder->setExtendParams($extendParamsArr);
            $qrPayRequestBuilder->setGoodsDetailList($goodsDetailList);
            $qrPayRequestBuilder->setStoreId($storeId);
            $qrPayRequestBuilder->setOperatorId($operatorId);
            $qrPayRequestBuilder->setAlipayStoreId($alipayStoreId);

            // $qrPayRequestBuilder->setAppAuthToken($appAuthToken);


            // 调用qrPay方法获取当面付应答
            $qrPay = new \AlipayTradeService($config);
            $qrPayResult = $qrPay->qrPay($qrPayRequestBuilder);

            //  根据状态值进行业务处理
            switch ($qrPayResult->getTradeStatus()){
                case "SUCCESS":
                    echo "支付宝创建订单二维码成功:"."<br>---------------------------------------<br>";
                    $response = $qrPayResult->getResponse();
                    $qrcode = $qrPay->create_erweima($response->qr_code);
                    echo $qrcode;
                    print_r($response);
                    
                    break;
                case "FAILED":
                    echo "支付宝创建订单二维码失败!!!"."<br>--------------------------<br>";
                    if(!empty($qrPayResult->getResponse())){
                        print_r($qrPayResult->getResponse());
                    }
                    break;
                case "UNKNOWN":
                    echo "系统异常，状态未知!!!"."<br>--------------------------<br>";
                    if(!empty($qrPayResult->getResponse())){
                        print_r($qrPayResult->getResponse());
                    }
                    break;
                default:
                    echo "不支持的返回状态，创建订单二维码返回异常!!!";
                    break;
            }
            $aop = new \AopClient();
            $aop->gatewayUrl = $this->at['gatewayUrl'];
            $aop->appId = $return['appid'];
            $aop->rsaPrivateKey = $return['appsecret'];
            $aop->alipayrsaPublicKey = $return['signkey'];
            $aop->signType = $this->at['sign_type'];
          
            $request = new \AlipayTradePrecreateRequest ();

            $data['out_trade_no'] = $orderid;
            $data['total_amount'] = $return['amount'];
            $data['subject'] = $body;

            $param = json_encode($data);
            
            $request->setNotifyUrl($this->at['notify_url']);
          

            $request->setBizContent($param);

            $result = $aop->execute ($request);


            // 得到返回参数
            $resultCode = $result->alipay_trade_precreate_response->code;
            $resultMsg = $result->alipay_trade_precreate_response->msg;
            $erweima = $result->alipay_trade_precreate_response->qr_code;
          
            if(!empty($resultCode)&&$resultCode == 10000){
                $getres = $this->getFormat($array['format'],'success','success',$orderid,$erweima);
                echo $getres;
            }else{
                $getres = $this->getFormat($array['format'],'error',$resultMsg);
                echo $getres;
            }
           
            //if(!empty($resultCode)&&$resultCode == 10000){
                //if(isMobile()) {
                //    header("location:".$erweima);
                //} else {
                    //$this->assign('qrcode',$erweima);
                    //$this->display("Charges/qrcode");
                //}
            //} else {
                //echo $result->alipay_trade_precreate_response->sub_code."-".$result->alipay_trade_precreate_response->sub_msg;
            //}
        }

      
      
         // 获得提交数据的类型
        public function getFormat($format,$code='error',$msg='error data',$orderid='',$qr_code=''){
            // json 格式
            if($format=="json"){
                $data = [
                    'code' => $code,
                    'msg' => $msg,
                    'orderid' => $orderid,
                    'qr_code' => $qr_code,
                ];
                return json_encode($data);

            }else{ // html 格式
                if($code=='success'){
                    $this->assign('qrcode',$qr_code);
                    $this->display("Charges/qrcode");
                }else{
                    return $msg;
                }
            }
        }

//        public function test(){
//            $param = $_GET;
//            $data=[
//                'transfer_orderid'=>$param['out_trade_no'],
//            ];
//            R("Transfer/index",[$data]);
//
//        }
      
        // 异步通知
        public function notify(){

            $param = $_POST;

            Vendor("AlipaySdk.aop.AopClient");

            $aop = new \AopClient();

            $order_info = M("Order")->where(['pay_orderid' => $param['out_trade_no']])->field('key,account_id')->find();

            $account = M('ChannelAccount')->where(['id'=>$order_info['account_id']])->field('fenzhuanzhang')->find();
                  
            $aop->alipayrsaPublicKey = $order_info['key'];

            $verify = $aop->rsaCheckV1($param,null,$this->at['sign_type']);

            if ($verify)//签名正确
            {

                if($param['trade_status']=="TRADE_SUCCESS"){
                    //  判断支付返回结果
                    // 必须返回 success 字符 系统下发状态才显示正常
                    $this->EditMoney($param['out_trade_no'], '', 0);
                  
                    if($account['fenzhuanzhang'] == 1) {
                        // 分账控制器
                        $data = [
                            'separate_orderid'=>$param['out_trade_no'],
                            'separate_trade_no'=>$param['trade_no'],
                        ];
                        R("Separate/index",[$data]);
                    }  elseif ($account['fenzhuanzhang']==2) {
                        $data=[
                            'transfer_orderid'=>$param['out_trade_no'],
                        ];
//                          log_separate("进入转账：","","","","","",$param['out_trade_no']);
                        R("Transfer/index",[$data]);

                    }
                    
                }
                echo "success";
            }else{
                exit("验证失败");
            }
        }

    }

?>