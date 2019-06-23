<?php
/**
 * Creater 51聚合支付平台需求参数
 * User: zhangjie
 * Date: 2018-12-3
 * Time: 11:33
 */
namespace Pay\Controller;

class ASController extends PayController
{

    //支付
    public function Pay($array)
    {
        //$partner =  $this->at['partner'];//平台商户ID
        //$Md5key = $this->at['key']; //接口密钥
        //$gateWay = $this->at['gateWay'];//获取网关 (可配置可从数据里面获取)
        //$notifyurl   = $this->_site . 'Pay_AS_notifyurl.html'; //异步通知
        //$callbackurl = $this->_site . 'Pay_AS_callbackurl.html'; //同步

        $orderid     = I("request.pay_orderid");
        $body        = I('request.pay_productname');

        $parameter = array(
            'code'         => "AS", // 通道名称
            'title'        => '爱商付',
            'exchange'     => 1, // 金额比例
            //'gateway'      => $gateWay,
            'orderid'      => $orderid,
            'out_trade_id' => $orderid,
            'body'         => $body,
            'channel'      => $array,
        );

        $return = $this->orderadd($parameter);//生成系统订单
      
      //$pay_bankcode = '931';   //银行编码 上游通道类型
        $pay_bankcode = $return['appid'];
        $Md5key = $return['signkey'];
        
        $native = array(
            "pay_memberid" => $return['mch_id'],
            "pay_orderid" => $orderid,
            "pay_amount" => $return['amount'],
            "pay_applydate" => date("Y-m-d H:i:s"),
            "pay_bankcode" => $pay_bankcode,
            "pay_notifyurl" => $return['notifyurl'],
            "pay_callbackurl" => $return['mch_callbackurl'],
        );

        ksort($native);
        $md5str = "";
        foreach ($native as $key => $val) {
            $md5str = $md5str . $key . "=" . $val . "&";
        }
        
        //echo($md5str . "key=" . $Md5key);
        $sign = strtoupper(md5($md5str . "key=" . $Md5key));
        $native["pay_md5sign"] = $sign;
        $native['pay_attach'] = "1234|456";
        $native['pay_productname'] ='VIP基础服务';
        $this->setHtml($return['gateway'], $native);

    }



   
 //异步通知
    public function notifyurl()
    {
       $returnArray = array( // 返回字段
            "memberid" => $_REQUEST["memberid"], // 商户ID
            "orderid" =>  $_REQUEST["orderid"], // 订单号
            "amount" =>  $_REQUEST["amount"], // 交易金额
            "datetime" =>  $_REQUEST["datetime"], // 交易时间
            "transaction_id" =>  $_REQUEST["transaction_id"], // 支付流水号
            "returncode" => $_REQUEST["returncode"],
        );
      
        $md5key = M("Order")->where(['pay_orderid' => $_REQUEST["orderid"]])->field('key')->find();
        ksort($returnArray);
        reset($returnArray);
        $md5str = "";
        foreach ($returnArray as $key => $val) {
            $md5str = $md5str . $key . "=" . $val . "&";
        }
        $sign = strtoupper(md5($md5str . "key=" . $md5key['key']));
        if ($sign == $_REQUEST["sign"]) {
            if ($_REQUEST["returncode"] == "00") {
              	$this->EditMoney($_REQUEST["orderid"], '', 0);
                exit("ok");
            }else{
            	exit("支付失败");
            }
        }else{
        	exit("验证失败");
        }
    }




}
