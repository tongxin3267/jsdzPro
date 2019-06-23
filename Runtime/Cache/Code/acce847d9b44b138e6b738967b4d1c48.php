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
<div class="row">
    <div class="col-md-12">
        <div class="ibox float-e-margins">
            <!--条件查询-->
            <div class="ibox-title">
                <h5>提款管理</h5>
                <div class="ibox-tools">
                    <i class="layui-icon" onclick="location.replace(location.href);" title="刷新"
                       style="cursor:pointer;">ဂ</i>
                </div>
            </div>
            <!--条件查询-->
            <div class="ibox-content">
                <form class="layui-form" action="" method="get" autocomplete="off" id="withdrawalform">
                    <input type="hidden" name="m" value="User">
                    <input type="hidden" name="c" value="Withdrawal">
                    <input type="hidden" name="a" value="index">
                    <input type="hidden" name="p" value="1">
                    <input type="hidden" name="rows" id="rows" value="<?php echo ($rows); ?>">
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <div class="layui-input-inline">
                                <input type="text" name="bankfullname" autocomplete="off" placeholder="请输入开户名"
                                       class="layui-input" value="<?php echo ($bankfullname); ?>">
                            </div>
                            <div class="layui-input-inline">
                                <input type="text" class="layui-input" name="createtime" id="createtime"
                                       placeholder="申请起始时间" value="<?php echo ($createtime); ?>">
                            </div>
                            <div class="layui-input-inline">
                                <input type="text" class="layui-input" name="successtime" id="successtime"
                                       placeholder="打款起始时间" value="<?php echo ($successtime); ?>">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline">
                                <select name="status">
                                    <option value="">全部状态</option>
                                    <option <?php if($status != '' && $status == 0): ?>selected<?php endif; ?> value="0">未处理</option>
                                    <option <?php if($status == 1): ?>selected<?php endif; ?> value="1">处理中</option>
                                    <option <?php if($status == 2): ?>selected<?php endif; ?> value="2">已打款</option>
                                    <option <?php if($status == 3): ?>selected<?php endif; ?> value="3">已驳回</option>
                                </select>
                            </div>
                            <div class="layui-input-inline">
                                <select name="T">
                                    <option value="">全部类型</option>
                                    <option <?php if($T == '0'): ?>selected<?php endif; ?> value="0">T + 0</option>
                                    <option <?php if($T == '1'): ?>selected<?php endif; ?> value="1">T + 1</option>
                                </select>
                            </div>

                        </div>

                        <div class="layui-inline">
                            <button type="submit" class="layui-btn"><span
                                    class="glyphicon glyphicon-search"></span> 搜索
                            </button>
                            <a href="javascript:;" id="export" class="layui-btn layui-btn-danger"><span class="glyphicon glyphicon-export"></span> 导出数据</a>
                        </div>
                    </div>
                </form>
                <blockquote class="layui-elem-quote" style="font-size:14px;padding;8px;">今日成功结算金额：<span class="label label-info"><?php echo ($stat["totay_total"]); ?>元</span> 今日待结算：<span class="label label-warning"><?php echo ($stat["totay_wait"]); ?>元</span> 今日成功笔数：<span class="label label-info"><?php echo ($stat["totay_success_count"]); ?></span> 今日失败笔数：<span class="label label-danger"><?php echo ($stat["totay_fail_count"]); ?></span></blockquote>
                <blockquote class="layui-elem-quote" style="font-size:14px;padding;8px;">总成功结算金额：<span class="label label-info"><?php echo ($stat["total"]); ?>元</span> 总待结算：<span class="label label-warning"><?php echo ($stat["total_wait"]); ?>元</span> 总成功笔数：<span class="label label-info"><?php echo ($stat["total_success_count"]); ?></span> 总失败笔数：<span class="label label-danger"><?php echo ($stat["total_fail_count"]); ?></span></blockquote>
                <!--交易列表-->
                <table class="layui-table" lay-data="{width:'100%',limit:<?php echo ($rows); ?>,id:'userData'}">
                    <thead>
                    <tr>
                        <th lay-data="{field:'key',width:60}"></th>
                        <th lay-data="{field:'t', width:60}">类型</th>
                        <th lay-data="{field:'userid', width:100,style:'color:#060;'}">商户编号</th>
                        <th lay-data="{field:'tkmoney', width:110}">结算金额</th>
                        <th lay-data="{field:'sxfmoney', width:100,style:'color:#060;'}">手续费</th>
                        <th lay-data="{field:'money', width:110}">到账金额</th>
                        <th lay-data="{field:'bankname', width:120,style:'color:#C00;'}">银行名称</th>
                        <th lay-data="{field:'bankzhiname', width:160}">支行名称</th>
                        <th lay-data="{field:'banknumber', width:198}">银行卡号/开户名</th>
                        <th lay-data="{field:'sheng', width:100}">所属省</th>
                        <th lay-data="{field:'shi', width:120}">所属市</th>
                        <th lay-data="{field:'sqdatetime', width:170}">申请时间</th>
                        <th lay-data="{field:'cldatetime', width:170}">处理时间</th>
                        <th lay-data="{field:'status', width:100}">状态</th>
                        <th lay-data="{field:'memo', width:180}">状态</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo ($vo["id"]); ?></td>
                            <td>T+<?php echo ($vo["t"]); ?></td>
                            <td><?php echo ($vo["userid"]+10000); ?></td>
                            <td><?php echo ($vo["tkmoney"]); ?> 元</td>
                            <td><?php echo ($vo["sxfmoney"]); ?> 元</td>
                            <td><?php echo ($vo["money"]); ?> 元</td>
                            <td><?php echo ($vo["bankname"]); ?></td>
                            <td><?php echo ($vo["bankzhiname"]); ?></td>
                            <td><?php echo ($vo["banknumber"]); ?> | <?php echo ($vo["bankfullname"]); ?></td>
                            <td><?php echo ($vo["sheng"]); ?></td>
                            <td><?php echo ($vo["shi"]); ?></td>
                            <td><?php echo ($vo["sqdatetime"]); ?></td>
                            <td><?php echo ($vo["cldatetime"]); ?></td>
                            <td>
                                <?php switch($vo["status"]): case "0": ?><span style="color:#F00;">未处理</span><?php break;?>
                                    <?php case "1": ?><span style="color:#06F;">处理中</span><?php break;?>
                                    <?php case "2": ?><span style="color:#060;">已打款</span><?php break;?>
                                    <?php case "3": ?><span class="text-danger">已驳回</span><?php break;?>
                                    <?php default: endswitch;?>
                            </td>
                            <td><?php echo ($vo["memo"]); ?></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <!--交易列表-->
                <div class="page">
                    
                    <form class="layui-form" action="" method="get" id="pageForm" autocomplete="off">     
                        <?php echo ($page); ?>                            
                        <select name="rows" style="height: 32px;" id="pageList" lay-ignore >
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
<script src="/Public/Front/js/Util.js" charset="utf-8"></script>
<script>
    layui.use(['laydate', 'laypage', 'layer', 'table', 'form'], function() {
        var laydate = layui.laydate //日期
            , laypage = layui.laypage //分页
            ,layer = layui.layer //弹层
            ,form = layui.form //表单
            , table = layui.table; //表格
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
    });
    $('#export').on('click',function(){
        window.location.href
            ="<?php echo U('User/Withdrawal/exportorder',array('T'=>$T,'createtime'=>$createtime,'successtime'=>$successtime,'tongdao'=>$tongdao,'status'=>$status));?>";
    });

    $('#pageList').change(function(){
        $('#rows').val($(this).val());
        $('#withdrawalform').submit();
    });
</script>
</body>
</html>