<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title><?php echo ($sitename); ?>---用户管理中心</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/Public/Front/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/Front/css/font-awesome.min.css" rel="stylesheet">
    <link href="/Public/Front/css/animate.css" rel="stylesheet">
    <link href="/Public/Front/css/style.css" rel="stylesheet">
    <link href="/Public/Front/css/zuy.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/Public/Front/iconfont/iconfont.css"/>
    <link rel="stylesheet" href="/Public/Front/js/plugins/layui/css/layui.css">
    <style>
        .layui-form-label {width:110px;padding:4px}
        .layui-form-item .layui-form-checkbox[lay-skin="primary"]{margin-top:0;}
        .layui-form-switch {width:54px;margin-top:0px;}
    </style>
<body class="gray-bg">
<div class="wrapper wrapper-content animated">
<body class="gray-bg">
<div class="wrapper wrapper-content" style="padding:0 20px;">
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">

            <div class="ibox-title">
                <h5>下级<span class="text-danger">[商户号:<?php echo (htmlspecialchars($_GET['userid']+10000)); ?>]</span>的交易记录</h5>
            </div>
            
            <div class="ibox-content">
                <form class="layui-form" action="<?php echo U('Agent/childord', ['userid'=>$_GET['userid']]);?>" method="get" autocomplete="off" id="orderform">
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <div class="layui-input-inline">
                                <input type="text" name="memberid" autocomplete="off" placeholder="商户编号"
                                       class="layui-input" value="<?php echo (htmlspecialchars($_GET['memberid'])); ?>">
                            </div>
                            <div class="layui-input-inline">
                                <input type="text" class="layui-input" name="createtime" id="createtime"
                                       placeholder="提交时间" value="<?php echo (urldecode($_GET['createtime'])); ?>">
                            </div>
                            <div class="layui-input-inline">
                                <input type="text" class="layui-input" name="successtime" id="successtime"
                                       placeholder="成功时间" value="<?php echo (urldecode($_GET['successtime'])); ?>">
                            </div>
                        </div>

                        <div class="layui-inline">
                            <button type="submit" class="layui-btn"><span
                                    class="glyphicon glyphicon-search"></span> 搜索
                            </button>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered table-hover table-condensed table-responsive">
                    <thead>
                    <th>交易总金额</th>
                    <th>实际金额</th>
                    <td>代理分润</td>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo ((isset($pay_amount) && ($pay_amount !== ""))?($pay_amount):"0.00"); ?></td>
                            <td><?php echo ((isset($pay_actualamount) && ($pay_actualamount !== ""))?($pay_actualamount):"0.00"); ?></td>
                            <td><?php echo ((isset($pay_poundage) && ($pay_poundage !== ""))?($pay_poundage):"0.00"); ?></td>
                        </tr>
                    </tbody>
                </table>
        <div class="table-responsive">

        <table class="table table-bordered table-hover table-condensed table-responsive">
            <thead>
            <th>订单号</th>
            <td>商户编号</td>
            <td>商户名</td>
            <th>交易金额</th>
            <th>手续费</th>
            <th>实际金额</th>
            <th>提交时间</th>
            <th>成功时间</th>
            <th>通道</th>
            <th>状态</th>
            </thead>
            <tbody>
            <?php if($list): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($vo["out_trade_id"]); ?></td>
                    <td><?php echo ($vo["pay_memberid"]); ?></td>
                    <td><?php echo ($vo["username"]); ?></td>
                    <td><?php echo ($vo["pay_amount"]); ?></td>
                    <td><?php echo ($vo["pay_poundage"]); ?></td>
                    <td><?php echo ($vo["pay_actualamount"]); ?></td>
                    <td><?php echo (date('Y-m-d H:i:s',$vo["pay_applydate"])); ?></td>
                    <td><?php if($vo[pay_successdate]): echo (date('Y-m-d H:i:s',$vo["pay_successdate"])); else: ?> ---<?php endif; ?></td>
                    <td><?php echo ($vo["pay_yzh_tongdao"]); ?></td>
                    <td><?php echo (status($vo['pay_status'])); ?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php else: ?>
                <tr><td colspan="9">没有找到任何数据.</td></tr><?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>
        </div>
    </div>
</div>
<div class="Page pagination"><?php echo ($page); ?></div>
</div>
</div>
<script src="/Public/Front/js/jquery.min.js"></script>
<script src="/Public/Front/js/bootstrap.min.js"></script>
<script src="/Public/Front/js/plugins/peity/jquery.peity.min.js"></script>
<script src="/Public/Front/js/content.js"></script>
<script src="/Public/Front/js/plugins/layui/layui.js" charset="utf-8"></script>
<script src="/Public/Front/js/x-layui.js" charset="utf-8"></script>
<script src="/Public/Front/js/Util.js" charset="utf-8"></script>
<script>
    layui.use(['form','table',  'laydate', 'layer'], function () {
        var form = layui.form
            ,table = layui.table
            , layer = layui.layer
            , laydate = layui.laydate;

        //日期时间范围
        laydate.render({
            elem: '#createtime'
            , type: 'datetime'
            ,theme: 'molv'
            , range: '|'
        });
        //日期时间范围
        laydate.render({
            elem: '#successtime'
            , type: 'datetime'
            ,theme: 'molv'
            , range: '|'
        });
        //监听表格复选框选择
        table.on('checkbox(userData)', function(obj){
            var child = $(data.elem).parents('table').find('tbody input[lay-filter="ids"]');
            child.each(function(index, item){
                item.checked = data.elem.checked;
            });
            form.render('checkbox');
        });

        //监听用户状态
        form.on('switch(switchStatus)', function (data) {
            var isopen = this.checked ? 1 : 0,
                uid = $(this).attr('data-uid');
            $.ajax({
                url: "<?php echo U('Agent/editStatus');?>",
                type: 'post',
                data: "uid=" + uid + "&isopen=" + isopen,
                success: function (res) {
                    if (res.status) {
                        layer.tips('温馨提示：开启成功', data.othis);
                    } else {
                        layer.tips('温馨提示：关闭成功', data.othis);
                    }
                }
            });
        });
    });
</script>