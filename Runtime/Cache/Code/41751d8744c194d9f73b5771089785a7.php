<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>文章页面</title>
<link rel="shortcut icon" href="favicon.ico">
<link href="<?php echo ($siteurl); ?>Public/Front/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/font-awesome.css?v=4.4.0" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/animate.css" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/style.css?v=4.1.0" rel="stylesheet">
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content  animated fadeInRight article">
  <div class="row">
    <div class="col-lg-12  ">
      <div class="ibox">
        <div class="ibox-content">
          <div class="text-center article-title">
            <h2> <?php echo ($find["title"]); ?> </h2>
          </div>
          <?php echo (HTMLHTML($find["content"])); ?>
          <hr>
           <div style="float:right">发布时间：<?php echo (time_format($find["createtime"])); ?></div> <a href="javascript:window.history.go(-1);" class="layui-btn" type="button">返回</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- 全局js -->
<script src="<?php echo ($siteurl); ?>Public/Front/js/jquery.min.js?v=2.1.4"></script>
<script src="<?php echo ($siteurl); ?>Public/Front/js/bootstrap.min.js?v=3.3.6"></script>
<!-- 自定义js -->
<script src="<?php echo ($siteurl); ?>Public/Front/js/content.js?v=1.0.0"></script>
</body>
</html>