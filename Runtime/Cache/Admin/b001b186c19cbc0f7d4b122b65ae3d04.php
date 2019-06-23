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
    <div class="col-lg-12">
      <!--条件查询-->
      <div class="ibox-title">
        <h5>用户管理</h5>
        <div class="ibox-tools">
          <i class="layui-icon" onclick="location.replace(location.href);" title="刷新"
             style="cursor:pointer;">ဂ</i>
        </div>
      </div>
      <!--条件查询-->
      <!--邀请码-->
      <div class="ibox-content">
      <form class="layui-form" action="" method="get" autocomplete="off">
        <input type="hidden" name="m" value="<?php echo ($model); ?>">
        <input type="hidden" name="c" value="User">
        <input type="hidden" name="a" value="invitecode">
        <input type="hidden" name="p" value="1">
        <div class="layui-form-item">
          <div class="layui-inline">
            <div class="layui-input-inline">
              <input type="text" name="invitecode" autocomplete="off" placeholder="邀请码"
                     class="layui-input" value="<?php echo ($invitecode); ?>">
            </div>
          </div>
          <div class="layui-inline">
            <div class="layui-input-inline">
              <input type="text" name="fbusername" autocomplete="off" placeholder="发布者用户名"
                     class="layui-input" value="<?php echo ($fbusername); ?>">
            </div>
          </div>
          <div class="layui-inline">
            <div class="layui-input-inline">
              <input type="text" name="syusername" autocomplete="off" placeholder="使用者用户名"
                     class="layui-input" value="<?php echo ($syusername); ?>">
            </div>
          </div>
          <div class="layui-inline">
            <div class="layui-input-inline">
              <select name="groupid">
                <option value="">用户类型</option>
                    <?php if(is_array($groupId)): foreach($groupId as $k=>$v): ?><option value="<?php echo ($k); ?>" <?php if($groupid == $k): ?>selected<?php endif; ?>><?php echo ($v); ?></option><?php endforeach; endif; ?>
              </select>
            </div>
            <div class="layui-input-inline">
              <select name="status">
                <option value="">状态</option>
                <option value="1" <?php if($status == 1): ?>selected<?php endif; ?>>未使用</option>
                <option value="2" <?php if($status == 2): ?>selected<?php endif; ?>>已使用</option>
                <option value="0" <?php if($status != '' && $status == 0): ?>selected<?php endif; ?>>禁用</option>
              </select>
            </div>
            <div class="layui-input-inline">
              <input type="text" class="layui-input" name="regdatetime" id="regtime"
                     placeholder="起始时间" value="<?php echo ($regdatetime); ?>">
            </div>
          </div>
          <div class="layui-inline">
            <button type="submit" class="layui-btn"> <span class="glyphicon glyphicon-search"></span> 搜索 </button>
            <button type="button" class="layui-btn" onclick="javarscript:location.reload();"><span
                    class="glyphicon glyphicon-refresh"></span> 刷新数据 </button>
            <button type="button" class="layui-btn"
                    onclick="invite_set('邀请码设置','<?php echo U('Admin/User/setInvite');?>',510,380)"><span
                    class="glyphicon glyphicon-wrench"></span>
              设 置 </button>
            <button type="button" class="layui-btn layui-btn-danger" onclick="invite_set('创建邀请码','<?php echo U('Admin/User/addInvite');?>',510,380)"><span class="glyphicon glyphicon-plus"></span> 添加邀请码 </button>
          </div>
        </div>
      </form>
      <table class="layui-table" lay-data="{id:'userData'}">
        <thead>
        <tr>
          <th lay-data="{field:'invitecode', width:100, style:'background-color: #e2e2e2;'}">邀请码</th>
          <th lay-data="{field:'url', width:90}">注册地址</th>
          <th lay-data="{field:'fmusernameid', width:100}">发布者</th>
          <th lay-data="{field:'is_admin', width:100}">发布者联系</th>
          <th lay-data="{field:'syusernameid', width:100}">使用者</th>
          <th lay-data="{field:'fbdatetime', width:110}">生成时间</th>
          <th lay-data="{field:'yxdatetime', width:110}">过期时间</th>
          <th lay-data="{field:'sydatetime', width:110}">使用时间</th>
          <th lay-data="{field:'regtype', width:110}">注册类型</th>
          <th lay-data="{field:'status', width:100, sort: true}">状态</th>
          <th lay-data="{field:'op',width:100, align:'center',}">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($vo["invitecode"]); ?></td>
            <td><a href="#" onClick="javascript:window.open('<?php echo ($siteurl); echo U("User/Login/register","invitecode=".$vo["invitecode"]);?>');">注册地址</a></td>
            <td><?php echo ($vo["fmusernameid"]); ?></td>
            <td><?php echo ($vo["is_admin"]); ?></td>
            <td><?php echo (getusername($vo["syusernameid"])); ?></td>
            <td><?php echo date('Y-m-d',$vo["fbdatetime"]);?></td>
            <td><?php echo date("Y-m-d",$vo["yxdatetime"]);?></td>
            <td><?php echo ($vo["sydatetime"]? date('Y-m-d',$vo["sydatetime"]):"-"); ?></td>
            <td>
              <?php echo ($vo["groupname"]); ?>
            </td>
            <td>
              <?php switch($vo["status"]): case "1": ?>未使用<?php break;?>
                <?php case "2": ?>已使用<?php break;?>
                <?php case "0": ?>禁用<?php break; endswitch;?>
            </td>
            <td>
              <div class="layui-btn-group">
                <?php if($vo[status] < 2): ?><button class="layui-btn layui-btn-small" onclick="invite_del(this,'<?php echo ($vo["id"]); ?>')">删除</button>
                <?php else: ?>
                  -<?php endif; ?>
              </div>
            </td>
          </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
      </table>
      <!--邀请码-->
      <div class="page"><?php echo ($page); ?> 
          <div class="layui-input-inline">
          <form class="layui-form" action="" method="get" id="pageForm" autocomplete="off">                                
              
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
<script src="/Public/Front/js/jquery.min.js"></script>
<script src="/Public/Front/js/bootstrap.min.js"></script>
<script src="/Public/Front/js/plugins/peity/jquery.peity.min.js"></script>
<script src="/Public/Front/js/content.js"></script>
<script src="/Public/Front/js/plugins/layui/layui.js" charset="utf-8"></script>
<script src="/Public/Front/js/x-layui.js" charset="utf-8"></script>
<script>
    layui.use(['form','table',  'laydate', 'layer'], function () {
        var form = layui.form
            , table = layui.table
            , layer = layui.layer
            , laydate = layui.laydate;
        //日期时间范围
        laydate.render({
            elem: '#regtime'
            , type: 'datetime'
            ,theme: 'molv'
            , range: '|'
        });
    });
    /* 邀请码-设置 */
    function invite_set(title, url, w, h) {
        x_admin_show(title, url, w, h);
    }

    /* 邀请码-添加 */
    function invite_add(title, url, w, h) {
        x_admin_show(title, url, w, h);
    }

    /*邀请码-删除*/
    function invite_del(obj, id) {
        layer.confirm('确认要删除吗？', function (index) {
            $.ajax({
                url:"<?php echo U('User/delInvitecode');?>",
                type:'post',
                data:'id='+id,
                success:function(res){
                    if(res.status){
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    }
                }
            });
        });
    }
    $('#pageList').change(function(){
        $('#pageForm').submit();
    });
</script>
</body>
</html>