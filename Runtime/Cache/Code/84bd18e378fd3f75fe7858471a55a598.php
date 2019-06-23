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
            <div class="col-sm-12">
            <form class="layui-form" action="" id="profile">
            <input type="hidden" name="userid" value="<?php echo ($u["id"]); ?>">
              <div class="layui-form-item">
                <label class="layui-form-label">用户名：</label>
                <div class="layui-input-inline">
                  <input type="text" name="u[username]" lay-verify="required" autocomplete="off"
                         value="<?php echo ($u["username"]); ?>"
                         placeholder="用户名"
                         class="layui-input"
                         <?php if($u["id"] > 0): ?>disabled="disabled"<?php endif; ?>
                         >
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">网站名称：</label>
                <div class="layui-input-inline">
                  <input type="text" name="u[realname]" lay-verify="required" autocomplete="off"
                         value="<?php echo ($u["realname"]); ?>"
                         placeholder="网站名称"
                         class="layui-input">
                </div>
              </div>
              <!--<div class="layui-form-item">
                <label class="layui-form-label">性别：</label>
                <div class="layui-input-inline">
                  <select name="u[sex]" lay-search="">
                    <option value=""></option>
                    <option <?php if($u['sex'] == 0): ?>selected<?php endif; ?> value="0">女</option>
                    <option <?php if($u['sex'] == 1): ?>selected<?php endif; ?> value="1">男</option>
                  </select>
                </div>
              </div>-->
              <div class="layui-form-item">
                <label class="layui-form-label">网站地址：</label>
                <div class="layui-input-inline">
                  <input type="text" name="u[sfznumber]" lay-verify="required" autocomplete="off" value="<?php echo ($u["sfznumber"]); ?>" placeholder="网站地址" class="layui-input">
                </div>
              </div>
              
              <!--<div class="layui-form-item">
                <label class="layui-form-label">出生日期：</label>
                <div class="layui-inline">
                  <input class="layui-input" name="u[birthday]" placeholder="出生日期" id="birthday" value="<?php echo (date("Y-m-d",$u[birthday])); ?>">
                </div>
              </div>-->
              
              <div class="layui-form-item">
                <label class="layui-form-label">手机号码：</label>
                <div class="layui-input-inline">
                  <input type="text" name="u[mobile]" lay-verify="required" autocomplete="off" value="<?php echo ($u["mobile"]); ?>" placeholder="手机号码" class="layui-input">
                </div>
              </div>
              
              <div class="layui-form-item">
                <label class="layui-form-label">联系QQ：</label>
                <div class="layui-input-inline">
                  <input type="text" name="u[qq]" autocomplete="off" value="<?php echo ($u["qq"]); ?>" placeholder="联系QQ"
                         class="layui-input">
                </div>
              </div>
              
              <div class="layui-form-item">
                <label class="layui-form-label">Email：</label>
                <div class="layui-input-inline">
                  <input type="text" name="u[email]" lay-verify="required" autocomplete="off" value="<?php echo ($u["email"]); ?>" placeholder="Email" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">用户级别：</label>
                <div class="layui-input-inline">
                  <select name="u[groupid]" lay-verify="required" lay-search="">
                    <option value=""></option>
                      <?php if(is_array($groupId)): foreach($groupId as $k=>$v): ?><option value="<?php echo ($k); ?>"><?php echo ($v); ?></option><?php endforeach; endif; ?>
                  </select>
                </div>
              </div>
              
              <div class="layui-form-item">
                <label class="layui-form-label">联系地址：</label>
                <div class="layui-inline">
                    <div class="layui-input-inline">
                      <input type="text" name="u[address]" lay-verify="required" autocomplete="off" value="<?php echo ($u["address"]); ?>" placeholder="联系地址" class="layui-input">
                    </div>
                </div>
            </div>
              <div class="layui-form-item">
                <label class="layui-form-label">登录密码：</label>
                <div class="layui-input-inline">
                  <input type="password" name="u[password]" lay-verify="required" autocomplete="off" value="" placeholder="登录密码" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <button class="layui-btn" lay-submit="submit" lay-filter="save">提交保存</button>
                </div>
              </div>
            </form>
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
layui.use(['layer', 'form','laydate'], function(){
  var form = layui.form
  ,laydate = layui.laydate
  ,layer = layui.layer;

    //常规用法
    laydate.render({
        elem: '#birthday'
    });
  //监听提交
  form.on('submit(save)', function(data){
    $.ajax({
        url:"<?php echo U('Agent/saveUser');?>",
        type:"post",
        data:$('#profile').serialize(),
        success:function(res){
            if(res.status){
                layer.alert("编辑成功", {icon: 6},function () {
                    parent.location.reload();
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                });
            }else{
                layer.alert("操作失败:" + res.msg, {icon: 5},function (index) {
                    layer.close(index)
                });
            }
        }
    });
    return false;
  });
});
</script>
<!--统计代码，可删除-->
</body>
</html>