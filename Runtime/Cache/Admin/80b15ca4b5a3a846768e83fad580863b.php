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
    <div class="col-md-12">
        <div class="ibox float-e-margins">
            <!--条件查询-->
            <div class="ibox-title">
                <h5>商户代付申请管理（通过API提交）</h5>
                <div class="ibox-tools">
                    <i class="layui-icon" onclick="location.replace(location.href);" title="刷新"
                       style="cursor:pointer;">ဂ</i>
                </div>
            </div>
            <!--条件查询-->
            <div class="ibox-content">
                <form class="layui-form" action="" method="get" autocomplete="off" id="orderform">
                    <input type="hidden" name="m" value="User">
                    <input type="hidden" name="c" value="Withdrawal">
                    <input type="hidden" name="a" value="check">
                    <input type="hidden" name="p" value="1">
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <div class="layui-input-inline">
                                <input type="text" name="out_trade_no" autocomplete="off" placeholder="请输入订单号"
                                       class="layui-input" value="<?php echo ($out_trade_no); ?>">
                            </div>
                            <div class="layui-input-inline">
                                <input type="text" name="accountname" autocomplete="off" placeholder="请输入开户名"
                                       class="layui-input" value="<?php echo ($accountname); ?>">
                            </div>
                            <div class="layui-input-inline">
                                <input type="text" class="layui-input" name="create_time" id="create_time"
                                       placeholder="申请时间" value="<?php echo ($create_time); ?>">
                            </div>
                            <div class="layui-input-inline">
                                <input type="text" class="layui-input" name="check_time" id="check_time"
                                       placeholder="审核时间" value="<?php echo ($check_time); ?>">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline">
                                <select name="check_status">
                                    <option value="">全部审核状态</option>
                                    <option value="0" <?php if($check_status == 0): ?>selected<?php endif; ?>>待处理</option>
                                    <option value="1" <?php if($check_status == 1): ?>selected<?php endif; ?>>审核通过</option>
                                    <option value="2" <?php if($check_status == 2): ?>selected<?php endif; ?>>审核驳回</option>
                                </select>
                            </div>

                            <div class="layui-input-inline">
                                <select name="status">
                                    <option value="">全部代付状态</option>
                                    <option value="0" <?php if($status == 0): ?>selected<?php endif; ?>>待处理</option>
                                    <option value="1" <?php if($status == 1): ?>selected<?php endif; ?>>处理中</option>
                                    <option value="2" <?php if($status == 2): ?>selected<?php endif; ?>>成功</option>
                                    <option value="3" <?php if($status == 2): ?>selected<?php endif; ?>>失败</option>
                                </select>
                            </div>

                        <div class="layui-inline">
                            <button type="submit" class="layui-btn"><span
                                    class="glyphicon glyphicon-search"></span> 搜索
                            </button>
                        </div>
                    </div>
         
                </form>
                <!--交易列表-->
                <table class="layui-table" lay-data="{width:'100%',limit:<?php echo ($rows); ?>,id:'userData'}" id="tab">
                    <thead>
                    <tr>
                        <th lay-data="{field:'check' , width:60}"> </th>
                        <th lay-data="{field:'out_trade_no', width:150}">商户订单号</th>
                        <th lay-data="{field:'money', width:100,style:'color:#060;'}">金额</th>
                        <th lay-data="{field:'bankname', width:110}">银行名称</th>
                        <th lay-data="{field:'subbranch', width:100,style:'color:#060;'}">支行名称</th>
                        <th lay-data="{field:'accountname', width:110}">开户名</th>
                        <th lay-data="{field:'check_status', width:100}">审核状态</th>
                        <th lay-data="{field:'status', width:160}">代付状态</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                            <td><input type="checkbox"  title="" value="<?php echo ($vo["id"]); ?>" class='checkIds' lay-skin="primary" <?php if(($vo["check_status"]) != "0"): ?>disabled="disabled"<?php endif; ?>></td>
                            <td><?php echo ($vo["out_trade_no"]); ?></td>
                            <td><?php echo ($vo["money"]); ?> 元</td>
                            <td><?php echo ($vo["bankname"]); ?></td>
                            <td><?php echo ($vo["subbranch"]); ?></td>
                            <td><?php echo ($vo["accountname"]); ?></td>
                            <td><?php switch($vo[check_status]): case "0": ?><strong class="text-danger">待处理</strong><?php break;?>
                                <?php case "1": ?><strong class="text-success">审核通过</strong><?php break;?>
                                <?php case "2": ?><strong class="text-warning">审核驳回</strong><?php break; endswitch;?></td>
                            <td>
                                <?php switch($vo[status]): case "0": ?><strong class="text-warning">待处理</strong><?php break;?>
                                    <?php case "1": ?><strong class="text-warning">处理中</strong><?php break;?>
                                    <?php case "2": ?><strong class="text-success">成功</strong><?php break;?>
                                    <?php case "3": ?><strong class="text-danger">失败</strong><?php break;?>
                                    <?php default: endswitch;?>
                            </td>
            
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <!--交易列表-->
                <div class="page">  
                    <form class="layui-form" action="" method="get" id="pageForm"  autocomplete="off">
                        <?php echo ($page); ?>                 
                        <select name="rows" style="height: 29px;" id="pageList" lay-ignore >
                            <option value="">显示条数</option>
                            <option <?php if($rows != '' && $rows == 15): ?>selected<?php endif; ?> value="15">15条</option>
                            <option <?php if($rows == 30): ?>selected<?php endif; ?> value="30">30条</option>
                            <option <?php if($rows == 50): ?>selected<?php endif; ?> value="50">50条</option>
                            <option <?php if($rows == 80): ?>selected<?php endif; ?> value="80">80条</option>
                            <option <?php if($rows == 100): ?>selected<?php endif; ?> value="100">100条</option>
                            <option <?php if($rows == 1000): ?>selected<?php endif; ?> value="1000">1000条</option>
                        </select>
                    </form>
                </div>
            </div>
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
    layui.use(['laydate', 'laypage', 'layer', 'table', 'form'], function() {
        var laydate = layui.laydate //日期
            , laypage = layui.laypage //分页
            ,layer = layui.layer //弹层
            ,form = layui.form //表单
            , table = layui.table; //表格
        //日期时间范围
        laydate.render({
            elem: '#create_time'
            , type: 'datetime'
            ,theme: 'molv'
            , range: '|'
        });
        //日期时间范围
        laydate.render({
            elem: '#check_time'
            , type: 'datetime'
            ,theme: 'molv'
            , range: '|'
        });

    });
    /*订单-查看*/
    function order_view(title,url,w,h){
        x_admin_show(title,url,w,h);
    }
    function df_op(title,url,w,h){
        x_admin_show(title,url,w,h);
    }
    $('#checkAll').on('click', function(){
        var child = $('table').next().find('tbody input[type="checkbox"]');  ;
        child.each(function(){
            if($(this).prop("disabled")==false){
                $(this).attr('checked', true);
                $(this).next('.layui-form-checkbox').addClass('layui-form-checked');
            }
        });
    });
    $('#submitAllOrder').on('click', function(){
        var id = '';
        $('.checkIds').each(function(){
            var _this = $(this);
            if( _this.is(':checked')  ){
                id = id + _this.val() + '_';
            }
        });
        if(id != '') {
            id=id.substring(0,id.length-1);
        }
        if(id){
            var url = "<?php echo U('/User/Withdrawal/dfPassBatch');?>"+"?id="+id;
            x_admin_show('代付申请批量审核',url,600,200);
        }else{
            layer.msg('请选择代付申请', {icon: 2, time: 1000},function () {});
        }
    });
</script>
</body>
</html>