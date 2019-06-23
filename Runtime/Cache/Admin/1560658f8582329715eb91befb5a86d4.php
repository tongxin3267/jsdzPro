<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
 <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title><?php echo ($sitename); ?>---管理</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/Public/Front/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/Front/css/font-awesome.min.css" rel="stylesheet">
    <link href="/Public/Front/css/animate.css" rel="stylesheet">
    <link href="/Public/Front/css/style.css" rel="stylesheet">
      <link href="/Public/Front/css/zuy.css" rel="stylesheet">
    <link rel="stylesheet" href="/Public/Front/js/plugins/layui/css/layui.css">
    <link rel="stylesheet" type="text/css" href="/Public/Front/iconfont/iconfont.css"/>
<style>
        .layui-form-label {width:110px;padding:4px}
        .layui-form-item .layui-form-checkbox[lay-skin="primary"]{margin-top:0;}
        .layui-form-switch {width:54px;margin-top:0px;}
    </style>
<body class="gray-bg">
<div class="wrapper wrapper-content animated">


    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <!-- Content -->
                <div class="ibox-content">
					<blockquote class="layui-elem-quote layui-quote-nm">
                    <p>可用余额：<span class="text-danger"><?php echo ($info["balance"]); ?></span>元</p>
					<p>预存款：<span class="text-danger"><?php echo ($info["yckbalance"]); ?></span>元</p>
                    <!-- <p>冻结余额：<span class="text-danger"><?php echo ($info["blockedbalance"]); ?></span>元</p> -->
					<p>码商冻结余额：<span class="text-danger"><?php echo ($info["codeblockedbalance"]); ?></span>元</p>
                    <p>投诉保证金：<span class="text-danger"><?php echo ($info["complaintsDeposit"]); ?></span>元</p>
					</blockquote>
                    <button class="layui-btn layui-btn-danger"
                            onclick="money_incr('增加/减少资金','<?php echo U('User/incrMoney',['uid'=>$info[id]]);?>',640,480)">
                        加/减余额</button>
                    <button class="layui-btn layui-btn-danger"
                        onclick="money_incr('增加/减少预存款','<?php echo U('User/incrYckMoney',['uid'=>$info[id]]);?>',640,480)">
                    增加/减少预存款</button>
                    <button class="layui-btn layui-btn-danger"
                        onclick="money_incr('增加/减少码商冻结余额','<?php echo U('User/incrCodeMoney',['uid'=>$info[id]]);?>',640,480)">
                    增加/减少码商冻结余额</button>
                    <button class="layui-btn layui-btn-danger "
                            onclick="money_frozen('T1冻结资金管理','<?php echo U('User/frozenTiming',['uid'=>$info[id]]);?>',640,480)"
                    >T1冻结资金管理</button><br><br>
                    <button class="layui-btn layui-btn-danger "
                            onclick="money_frozen('手动冻结余额','<?php echo U('User/frozenMoney',['uid'=>$info[id]]);?>',640,550)"
                    >手动冻结余额</button>
                    <button class="layui-btn layui-btn-danger "
                            onclick="money_frozen('手动冻结余额管理','<?php echo U('User/frozenOrder',['uid'=>$info[id]]);?>',800,550)"
                    >手动冻结余额管理</button>
                </div>
                <!-- Content -->
            </div>
        </div>
    </div>
</div>
<script src="/Public/Front/js/jquery.min.js"></script>
<script src="/Public/Front/js/bootstrap.min.js"></script>
<script src="/Public/Front/js/plugins/peity/jquery.peity.min.js"></script>
<script src="/Public/Front/js/content.js"></script>
<script src="/Public/Front/js/plugins/layui/layui.js" charset="utf-8"></script>
<script src="/Public/Front/js/x-layui.js" charset="utf-8"></script>
    <script>
        layui.use(['form','laydate','layer'], function(){
                var form = layui.form
                    ,layer = layui.layer
                    ,laydate = layui.laydate;
        });

        /*用户-加减余额*/
        function money_incr(title,url,w,h){
            if (title == null || title == '') {
                title=false;
            };
            if (url == null || url == '') {
                url="404.html";
            };
            if (w == null || w == '') {
                w=800;
            };
            if (h == null || h == '') {
                h=($(window).height() - 50);
            };
            parent.layer.open({
                type: 2,
                area: [w+'px', h +'px'],
                fix: false, //不固定
                maxmin: true,
                shadeClose: true,
                shade:0.4,
                title: title,
                content: url
            });
        }
        /*用户-冻结、解冻余额*/
        function money_frozen(title,url,w,h){
            if (title == null || title == '') {
                title=false;
            };
            if (url == null || url == '') {
                url="404.html";
            };
            if (w == null || w == '') {
                w=800;
            };
            if (h == null || h == '') {
                h=($(window).height() - 50);
            };
            parent.layer.open({
                type: 2,
                area: [w+'px', h +'px'],
                fix: false, //不固定
                maxmin: true,
                shadeClose: true,
                shade:0.4,
                title: title,
                content: url
            });
        }

        function pauseUnfreezing(userId) {
            $.ajax({
                url:"<?php echo U('User/pauseUnfreezingDeposit');?>",
                type:"post",
                data:{"userid": userId},
                success:function(res){
                    if(res.status){
                        layer.alert("编辑成功", {icon: 6},function () {
                            parent.location.reload();
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                        });
                    }
                }
            });
            return false;
        }
        function unpauseUnfreezing(userId) {
            $.ajax({
                url:"<?php echo U('User/unpauseUnfreezingDeposit');?>",
                type:"post",
                data:{"userid": userId},
                success:function(res){
                    if(res.status){
                        layer.alert("编辑成功", {icon: 6},function () {
                            parent.location.reload();
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                        });
                    }
                }
            });
            return false;
        }
    </script>
</body>
</html>