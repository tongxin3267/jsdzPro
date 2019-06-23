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
            <div class="ibox-title">
                <h5>下属用户列表</h5>
            </div>
            <div class="ibox-content">
                <form class="layui-form" action="" method="get" autocomplete="off">
                    <input type="hidden" name="m" value="<?php echo ($model); ?>">
                    <input type="hidden" name="c" value="User">
                    <input type="hidden" name="a" value="index">
                    <input type="hidden" name="p" value="1">
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <div class="layui-input-inline">
                                <input type="text" name="username" autocomplete="off" placeholder="商户号或用户名"
                                       class="layui-input" value="<?php echo (htmlspecialchars($_GET['username'])); ?>">
                            </div>
                        </div>

                        <div class="layui-inline">
                            <div class="layui-input-inline">
                                <select name="status">
                                    <option value="">状态</option>
                                    <option value="1">已激活</option>
                                    <option value="0">未激活</option>
                                    <option value="2">禁用</option>
                                </select>
                            </div>
                            <div class="layui-input-inline">
                                <select name="authorized">
                                    <option value="">认证</option>
                                    <option value="0">未认证</option>
                                    <option value="2">等待审核</option>
                                    <option value="1">认证用户</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <div class="layui-input-inline">
                                <input type="text" class="layui-input" name="regdatetime" id="regtime"
                                       placeholder="起始时间">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <button type="submit" class="layui-btn"><span
                                    class="glyphicon glyphicon-search"></span> 搜索
                            </button>
                            <a href="javascript:;" id="export"
                               class="layui-btn layui-btn-danger"><span
                                    class="glyphicon glyphicon-export"></span> 导出数据</a>
                            <button onclick="member_add('添加用户', '<?php echo U('Agent/addUser');?>');return false;" class="layui-btn"><span
                                    class="glyphicon glyphicon-user"></span> 添加用户
                            </button>
                        </div>
                    </div>
                </form>

                <!--用户列表-->
                <table class="layui-table" lay-data="{width:'100%',id:'userData'}">
                    <thead>
                    <tr>
                        <th lay-data="{field:'id',fixed: true,width:60}"></th>
                        <th lay-data="{field:'memberid', width:80, sort: true, fixed: true}">商户号</th>
                        <th lay-data="{field:'username', width:120}">用户名</th>
                        <th lay-data="{field:'groupid', width:110}">用户类型</th>
                        <th lay-data="{field:'status', width:80}">状态</th>
                        <th lay-data="{field:'authorized', width:100}">认证</th>
                        <th lay-data="{field:'money', width:240,style:'background-color: #5FB878; color: #fff;'}">账户总额</th>
                        <th lay-data="{field:'regdatetime', width:180}">注册时间</th>
                        <th lay-data="{field:'op',width:300}">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo ($vo["id"]); ?></td>
                            <td><?php echo (shanghubianhao($vo['id'])); ?></td>
                            <td><?php echo ($vo["username"]); ?></td>
                            <td><?php echo (membertype($vo['groupid'])); ?></td>
                            <td>
                                <input type="checkbox"
                                       data-uid="<?php echo ($vo["id"]); ?>"
                                <?php if($vo['status']): ?>checked<?php endif; ?>
                                name="open"
                                lay-skin="switch"
                                lay-filter="switchStatus"
                                lay-text="正常|禁用">
                            </td>
                            <td>
                                <?php switch($vo[authorized]): case "0": ?><span class="label label-default">未认证</span><?php break;?>
                                    <?php case "1": ?><span class="label label-success">已认证</span><?php break;?>
                                    <?php case "2": ?><span class="label label-warning">等待审核</span><?php break;?>
                                    <?php default: endswitch;?>
                            </td>
                            <td>
                                <div title="用户资金管理" >
                                    <?php if(($vo[groupid]) != "8"): ?>预存款：<?php echo ($vo["yckbalance"]); endif; ?>
                                    可提现余额:<?php echo ($vo["balance"]); ?>
                                    <?php if(($vo[groupid]) == "8"): ?>冻结：<?php echo ($vo["codeblockedbalance"]); endif; ?>  </div>
                            </td>
                            <td><strong><?php echo (date('Y-m-d H:i:s',$vo["regdatetime"])); ?></strong>
                            </td>
                            <td>
                                <button class="layui-btn layui-btn-small"
                                        onclick="member_rate('编辑费率','<?php echo U('Agent/userRateEdit',['uid'=>$vo[id]]);?>',640,480)">费率</button>
                                <button class="layui-btn layui-btn-small"
                                        onclick="member_show('查看下级流水','<?php echo U('Agent/childord',array('userid'=>$vo['id']));?>',800,600)">查看
                                </button>
                              	<button class="layui-btn layui-btn-small"
                                        onclick="member_show('指定子账号','<?php echo U('Agent/appoint',array('userid'=>$vo['id']));?>',800,600)">指定子账号
                                </button>
                            </td>

                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
            </table>
            <!--用户列表-->
            <div class="page"><?php echo ($page); ?></div>
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
    layui.use(['form','table',  'laydate', 'layer'], function () {
        var form = layui.form
            ,table = layui.table
            , layer = layui.layer
            , laydate = layui.laydate;

        //日期时间范围
        laydate.render({
            elem: '#regtime'
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
     /*添加*/
    function member_add(title, url, w, h) {
        x_admin_show(title, url, w, h);
    } 
    /*用户-费率*/
    function member_rate(title, url, w, h) {
        x_admin_show(title, url, w, h);
    }
    function member_show(title, url, w, h) {
        x_admin_show(title, url, w, h);
    }
     // 用户-提现
    function member_money(title, url, id, w, h) {
        x_admin_show(title, url, w, h);
    }
    $('#export').on('click',function(){
        window.location.href
            ="<?php echo U('User/Agent/exportuser',array('username'=>$_GET[username],'parentid'=>$_GET[parentid],'status'=>$_GET[status],'authorized'=>$_GET[authorized],'groupid'=>$_GET[groupid],'regdatetime'=>$_GET[regdatetime]));?>";
    });
</script>
</body>
</html>