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
			<form class="layui-form" action="" id="profile">
			<input type="hidden" name="userid" value="<?php echo ($u["id"]); ?>">
			  <div class="layui-form-item">
				<label class="layui-form-label">用户名：</label>
				<div class="layui-input-inline">
				  <input type="text" name="u[username]" lay-verify="required" autocomplete="off"
						 value="<?php echo (htmlentities($u["username"])); ?>"
						 placeholder="用户名"
						 class="layui-input"
						 <?php if($u["id"] > 0): ?>disabled="disabled"<?php endif; ?>
						 >
				</div>
			  </div>
               <div class="layui-form-item">
				<label class="layui-form-label">上级代理ID：</label>
				<div class="layui-input-inline">
				  <input type="text" name="u[parentid]" lay-verify="required" autocomplete="off"
						 value="<?php echo (htmlentities($u["parentid"])); ?>"
						 placeholder="无代理请填0"
						 class="layui-input">
				</div>
			  </div>
              
              
			  <div class="layui-form-item">
				<label class="layui-form-label">姓名：</label>
				<div class="layui-input-inline">
				  <input type="text" name="u[realname]" lay-verify="required" autocomplete="off"
						 value="<?php echo (htmlentities($u["realname"])); ?>"
						 placeholder="姓名"
						 class="layui-input">
				</div>
			  </div>
			  <div class="layui-form-item">
				<label class="layui-form-label">性别：</label>
				<div class="layui-input-inline">
				  <select name="u[sex]" lay-search="">
					<option value=""></option>
					<option <?php if($u['sex'] == 0): ?>selected<?php endif; ?> value="0">女</option>
					<option <?php if($u['sex'] == 1): ?>selected<?php endif; ?> value="1">男</option>
				  </select>
				</div>
			  </div>
			  
			  <div class="layui-form-item">
				<label class="layui-form-label">身份证号：</label>
				<div class="layui-input-inline">
				  <input type="text" name="u[sfznumber]" lay-verify="required" autocomplete="off" value="<?php echo (htmlentities($u["sfznumber"])); ?>" placeholder="身份证号" class="layui-input">
				</div>
			  </div>
			  <div class="layui-form-item">
				<label class="layui-form-label">出生日期：</label>
				<div class="layui-input-inline">
				  <input class="layui-input" name="u[birthday]" placeholder="出生日期" id="birthday" value="<?php echo (date("Y-m-d",$u[birthday])); ?>">
				</div>
			  </div>
			  
			  <div class="layui-form-item">
				<label class="layui-form-label">手机号码：</label>
				<div class="layui-input-inline">
				  <input type="text" name="u[mobile]"  autocomplete="off" value="<?php echo (htmlentities($u["mobile"])); ?>" placeholder="手机号码" class="layui-input">
				</div>
			  </div>
			  
			  <div class="layui-form-item">
				<label class="layui-form-label">联系QQ：</label>
				<div class="layui-input-inline">
				  <input type="text" name="u[qq]" autocomplete="off" value="<?php echo (htmlentities($u["qq"])); ?>" placeholder="联系QQ"
						 class="layui-input">
				</div>
			  </div>
			  
			  <div class="layui-form-item">
				<label class="layui-form-label">Email：</label>
				<div class="layui-input-inline">
				  <input type="text" name="u[email]" lay-verify="required" autocomplete="off" value="<?php echo (htmlentities($u["email"])); ?>" placeholder="Email" class="layui-input">
				</div>
			  </div>
			  
			  <div class="layui-form-item">
				<label class="layui-form-label">用户级别：</label>
				<div class="layui-input-inline">
				  <select name="u[groupid]" lay-verify="required" lay-search="">
					<option value=""></option>
						<?php if(is_array($groupId)): foreach($groupId as $k=>$v): ?><option <?php if($u['groupid'] == $k): ?>selected<?php endif; ?>
							  value="<?php echo ($k); ?>"><?php echo ($v); ?></option><?php endforeach; endif; ?>

				  </select>
				</div>
			  </div>
			  
			  <div class="layui-form-item">
				<label class="layui-form-label">联系地址：</label>
				<div class="layui-input-inline">
					  <input type="text" name="u[address]" lay-verify="required" autocomplete="off" value="<?php echo (htmlentities($u["address"])); ?>" placeholder="联系地址" readonly onfocus="this.removeAttribute('readonly');" class="layui-input">
					</div>
				
			</div>

			<!-- <div class="layui-form-item">
				<label class="layui-form-label">登录密码：</label>
				<div class="layui-input-inline">
					<input type="password" name="u[password]" autocomplete="off" value="<?php echo (htmlentities($u["password"])); ?>"  readonly onfocus="this.removeAttribute('readonly');" class="layui-input"><div class="layui-form-mid layui-word-aux">若不修改登陆密码，请留空</div>
				</div>
			</div> -->
			<div class="layui-form-item">
				<label class="layui-form-label">登录密码：</label>
				<div class="layui-input-inline">
					<input type="password" name="u[password]" autocomplete="off" value="" placeholder="登录密码" class="layui-input">
					<div class="layui-form-mid layui-word-aux">若不修改登陆密码，请留空</div>
				</div>
			</div>

  			<div class="layui-form-item layui-form-text">
    			<label class="layui-form-label">登录IP白名单：</label>
    			<div class="layui-input-block">
      				<textarea name="u[login_ip]" placeholder="请输入内容" class="layui-textarea"><?php echo ($u[login_ip]); ?></textarea>
    			</div>
  			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">代付API接口状态：</label>
				<div class="layui-input-block">
					<input type="radio" name="u[df_api]" lay-filter="df_api" value="1" title="开启" <?php if($u['df_api'] == 1): ?>checked<?php endif; ?>>
					<input type="radio" name="u[df_api]" lay-filter="df_api" value="0" title="关闭" <?php if($u['df_api'] == 0): ?>checked<?php endif; ?>>
				</div>
			</div>
			<div class="layui-form-item" id="df_auto_check" <?php if($u['df_api'] == 0): ?>style="display: none;"<?php endif; ?>>
			<label class="layui-form-label">代付API自动审核：</label>
			<div class="layui-input-block">
				<input type="radio" name="u[df_auto_check]" lay-filter="df_auto_check" value="1" title="开启" <?php if($u['df_auto_check'] == 1): ?>checked<?php endif; ?>>
				<input type="radio" name="u[df_auto_check]" lay-filter="df_auto_check" value="0" title="关闭" <?php if($u['df_auto_check'] == 0): ?>checked<?php endif; ?>>
			</div>
		</div>
		<div class="layui-form-item" id="df_domain" <?php if($u['df_api'] == 0): ?>style="display: none;"<?php endif; ?>>
			<label class="layui-form-label">代付域名报备：</label>
			<div class="layui-input-block">
				<textarea name="u[df_domain]" placeholder="如：www.baidu.com，多个域名请换行，一行一个域名" class="layui-textarea"><?php echo ($u[df_domain]); ?></textarea>
			</div>
			<label class="layui-form-label"></label><div class="layui-form-mid layui-word-aux">注意：无需填写http://或https://，也不需要填写具体路径，结尾不加 /，一行一个域名。下级商户只能从这些域名发起代付请求！</div>
		</div>
		<div class="layui-form-item" id="df_ip" <?php if($u['df_api'] == 0): ?>style="display: none;"<?php endif; ?>>
			<label class="layui-form-label">代付IP报备：</label>
		<div class="layui-input-block">
			<textarea name="u[df_ip]" placeholder="如：127.0.0.1，多个IP请换行，一行一个IP" class="layui-textarea"><?php echo ($u[df_ip]); ?></textarea>
		</div>
		<label class="layui-form-label"></label><div class="layui-form-mid layui-word-aux">注意：请填写发起代付请求的服务器公网IP一行一个IP地址。</div>
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
<script>
layui.use(['layer', 'form','laydate'], function(){
  var form = layui.form
  ,laydate = layui.laydate
  ,layer = layui.layer;

    //常规用法
    laydate.render({
        elem: '#birthday'
    });
    form.on('radio(df_api)',function(data){
        if(data.value == 1) {
            $('#df_auto_check').show();
            $('#df_domain').show();
            $('#df_ip').show();
        } else {
            $('#df_auto_check').hide();
            $('#df_domain').hide();
            $('#df_ip').hide();
        }
    });
  //监听提交
  form.on('submit(save)', function(data){
    $.ajax({
		url:"<?php echo U('User/saveUser');?>",
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