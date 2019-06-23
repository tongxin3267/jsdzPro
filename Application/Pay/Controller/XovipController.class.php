<?php
/**
 * Created by PhpStorm.
 * Date: 2018-12-26
 * Time: 15:06
 */

namespace Pay\Controller;
class XovipController extends PayController
{
    public function __construct()
    {
        parent::__construct();
    }

    //支付
    public function Pay($array)
    {
		$orderid = I("request.pay_orderid");
        $body = I('request.pay_productname');
        $notifyurl = $this->_site . 'Pay_Xovip_notifyurl.html'; //异步通知
        $callbackurl = $this->_site . 'Pay_Xovip_callbackurl.html'; //返回通知

        $orderid = I("request.pay_orderid", '');

        $body = I('request.pay_productname', '');

        $parameter = [
            'code'         => 'Xovip',
            'title'        => 'Xovip支付宝',
            'exchange'     => 1, // 金额比例
            'gateway'      => '',
            'orderid'      => '',
            'out_trade_id' => $orderid, //外部订单号
            'channel'      => $array,
            'body'         => $body,
        ];

        //支付金额
        $pay_amount = I("request.pay_amount", 0);

        // 订单号，可以为空，如果为空，由系统统一的生成
        $return = $this->orderadd($parameter);
        //如果生成错误，自动跳转错误页面
        $return["status"] == "error" && $this->showmessage($return["errorcontent"]);
        //跳转页面，优先取数据库中的跳转页面
        $return["notifyurl"] || $return["notifyurl"] = $this->_site . 'Pay_Xovip_notifyurl.html';
        $return['callbackurl'] || $return['callbackurl'] = $this->_site . 'Pay_Xovip_callbackurl.html';
        error_reporting(0);
        $content_type = 'text';
        //商户ID->到平台首页自行复制粘贴
        $account_id = $return["mch_id"];
        //S_KEY->商户KEY，到平台首页自行复制粘贴，该参数无需上传，用来做签名验证和回调验证，请勿泄露
        $s_key =  $return['signkey']; //密钥 
        //订单号码->这个是四方网站发起订单时带的订单信息，一般为用户名，交易号，等字段信息
        $out_trade_no = $return['orderid'];
        //支付通道：支付宝（公开版）：alipay_auto、微信（公开版）：wechat_auto、服务版（免登陆/免APP）：service_auto
        $thoroughfare = 'alipay_auto';
        //支付金额
        $amount = number_format($return['amount'],2,'.',''); 
        //生成签名
        $sign = $this->xovipsign($s_key, ['amount'=>$amount,'out_trade_no'=>$out_trade_no]);
        //轮训状态，是否开启轮训，状态 1 为关闭   2为开启
        $robin = 2;
        //微信设备KEY，新增加一条支付通道，会自动生成一个device Key，可在平台的公开版下看见，如果为轮训状态无需附带此参数，如果$robin参数为1的话，就必须附带设备KEY，进行单通道支付
        $device_key = '';
        //异步通知接口url->用作于接收成功支付后回调请求
        $callback_url = $return["notifyurl"];
        //支付成功后自动跳转url
        $success_url = $return['callbackurl'];
        //支付失败或者超时后跳转url
        $error_url = $return['callbackurl'];
        //支付类型->类型参数是服务版使用，公开版无需传参也可以
        $type = 2;
        $native = array(
            "account_id"      => $account_id,
            "content_type"        => $content_type,
            "thoroughfare"      => $thoroughfare,
            "out_trade_no"      => $out_trade_no,
            "sign"    => $sign,
            "robin"    => $robin,
            "callback_url"    => $callback_url,
            "success_url"        => $success_url,
            "error_url"          => $error_url,
            "amount"          => $amount,
            "type"          => $type,
            "keyId"          => $keyId,
        );
        $tjurl='http://xovip.cn/gateway/index/checkpoint.do';

        $str = '<form id="Form1" name="Form1" method="post" action="' .$tjurl. '">';
        $str = $str . '<input type="text" name="authcode" value="">';
        foreach ($native as $key => $val) {
            $str = $str . '<input type="hidden" name="' . $key . '" value="' . $val . '">';
        }
        //$str = $str . '<input type="submit" value="提交">';
        $str = $str . '</form>';
        $str = $str . '<script>';
        $str = $str . 'document.Form1.submit();';
        $str = $str . '</script>';
        echo $str;
        return;
    }

    public function xovipsign ($key_id, $array)
    {
        $data = md5(number_format($array['amount'],2) . $array['out_trade_no']);
        $key[] ="";
        $box[] ="";
        $pwd_length = strlen($key_id);
        $data_length = strlen($data);
        for ($i = 0; $i < 256; $i++)
        {
            $key[$i] = ord($key_id[$i % $pwd_length]);
            $box[$i] = $i;
        }
        for ($j = $i = 0; $i < 256; $i++)
        {
            $j = ($j + $box[$i] + $key[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $data_length; $i++)
        {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            
            $k = $box[(($box[$a] + $box[$j]) % 256)];
            $cipher .= chr(ord($data[$i]) ^ $k);
        }
        return md5($cipher);
    }




    //同步通知
    public function callbackurl()
    {
        $Order = M("Order");
        $pay_status = $Order->where(['pay_orderid' => $_GET["orderid"]])->getField("pay_status");
        if($pay_status <> 0){
            $this->EditMoney($_GET["orderid"], 'Jmalipay', 1);
        }else{
            exit("交易成功");
        }

    }

    //异步通知
    public function notifyurl(){
       
        //商户名称
        $account_name  = $_POST['account_name'];
        //支付时间戳
        $pay_time  = $_POST['pay_time'];
        //支付状态
        $status  = $_POST['status'];
        //支付金额
        $amount  = $_POST['amount'];
        //支付时提交的订单信息
        $out_trade_no  = $_POST['out_trade_no'];
        //平台订单交易流水号
        $trade_no  = $_POST['trade_no'];
        //该笔交易手续费用
        $fees  = $_POST['fees'];
        //签名算法
        $sign  = $_POST['sign'];
        //回调时间戳
        $callback_time  = $_POST['callback_time'];
        //支付类型
        $type = $_POST['type'];
        //商户KEY（S_KEY）
        $account_key = $_POST['account_key'];
        $md5key = getKey($out_trade_no);

        //第一步，检测商户KEY是否一致
        if ($account_key != $md5key) exit('error:key');
        //第二步，验证签名是否一致
        if ($this->xovipsign($md5key, ['amount'=>$amount,'out_trade_no'=>$out_trade_no]) != $sign) exit('error:sign');

        //下面就可以安全的使用上面的信息给贵公司平台进行入款操作
        //成功逻辑处理
             $this->EditMoney($out_trade_no, '', 0);
            exit("回调成功");

        //测试时，将来源请求写入到txt文件，方便分析查看
      


    }



   }