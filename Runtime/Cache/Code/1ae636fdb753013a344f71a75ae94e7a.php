<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>通知公告</title>
<link rel="shortcut icon" href="favicon.ico">
<link href="<?php echo ($siteurl); ?>Public/Front/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/font-awesome.css?v=4.4.0" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/animate.css" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/style.css?v=4.1.0" rel="stylesheet">
<link rel="stylesheet" href="/Public/Front/js/plugins/layui/css/layui.css">
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content  animated fadeInRight blog">
  <div class="row">
     <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="col-lg-12">
      <div class="ibox">
        <div class="ibox-content">
          <a href="<?php echo U("Index/showcontent","id=".$vo["id"]);?>" class="btn-link"><h4> <?php echo (browserecord($vo["id"])); ?> <?php echo ($vo["title"]); ?> </h4></a>
          <div class="row">
            <div class="col-md-6">
              <a href="<?php echo U("Index/showcontent","id=".$vo["id"]);?>">查看</a>
            </div>
            <div class="col-md-6">
              <div class="small text-right"><i class="fa fa-time"> </i><?php echo ($vo["datetime"]); ?></div>
            </div>
          </div>
        </div>
      </div>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
  </div>
  <div class="text-center"><?php echo ($page); ?></div>
</div>
<!-- 全局js -->
<script src="<?php echo ($siteurl); ?>Public/Front/js/jquery.min.js?v=2.1.4"></script>
<script src="<?php echo ($siteurl); ?>Public/Front/js/bootstrap.min.js?v=3.3.6"></script>
<!-- 自定义js -->
<script src="<?php echo ($siteurl); ?>Public/Front/js/content.js?v=1.0.0"></script>
<!--统计代码，可删除-->
</body>
</html>