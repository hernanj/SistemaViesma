<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $this->lang->line("forgot_pw"). " | " . SITE_NAME; ?></title>
<link rel="shortcut icon" href="<?php echo $this->config->base_url(); ?>assets/img/icon.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link href="<?php echo $this->config->base_url(); ?>assets/css/bootstrap-<?php echo THEME; ?>.css" rel="stylesheet">
<style type="text/css">
body {
	padding-top: 40px;
	padding-bottom: 40px;
	background-color: #FFF;
}
.graybg { 
  background-color: #FAFAFA;
  background-image: linear-gradient(to bottom, #FFFFFF, #F2F2F2);
  background-repeat: repeat-x;
}
.shadow {
	-webkit-box-shadow: 0 8px 6px -6px #666;
	-moz-box-shadow: 0 8px 6px -6px #666;
	box-shadow: 0 8px 6px -6px #666;
}
.login{ max-width: 500px; }
.title {
	border: 1px solid #D4D4D4;
	color: #666;
	font-size: 18px;
	margin: 0;
	padding: 15px 30px;
	text-align:center;
	font-weight:bold;
}
.actions {
	border: 1px solid #D4D4D4;
	color: #444444;
	margin: 0;
	padding: 15px;
}
.form-horizontal .control-label {
	width: 80px;
}
.form-horizontal .controls {
	margin-left: 100px;
}
</style>
<link href="<?php echo $this->config->base_url(); ?>assets/css/bootstrap-responsive.css" rel="stylesheet">

<!--[if lt IE 9]>
      <script src="<?php echo $this->config->base_url(); ?>assets/js/html5shiv.js"></script>
    <![endif]-->

</head>

<body>
<div class="container">
  <div class="row">
    <div class="span12" style="text-align:center; margin-bottom:10px;"><img src="<?php echo $this->config->base_url(); ?>assets/img/<?php echo LOGO2; ?>" alt="<?php echo SITE_NAME; ?>"/></div>
  </div>
  <div class="login shadow" style="margin:15px auto; float:none; padding:0;">
    <?php $attib = array('class' => 'form-horizontal'); echo form_open("module=auth&view=forgot_password", $attib); ?>
    <div class="title graybg"><?php echo $this->lang->line("forgot_pw"); ?></div>
    <div style="padding:20px; background:#FFF; border-left: 1px solid #D4D4D4; border-right: 1px solid #D4D4D4;">
      <?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>
      <?php if($success_message) { echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $success_message . "</div>"; } ?>
      <p><?php echo $this->lang->line("email_to_reset_pw"); ?></p>
      <?php echo form_input($email, '', 'class="input-block-level" placeholder="'.$this->lang->line("email_address").'" autofocus="autofocus"');?> </div>
    <div class="actions graybg"> <?php echo form_submit('submit', $this->lang->line("submit"), 'class="btn btn-primary" style="padding: 6px 15px;"');?> <a href="index.php?module=auth&view=login" style="margin-left:15px;"><?php echo $this->lang->line("back_to_login"); ?></a> </div>
    <?php echo form_close();?> </div>
</div>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script> 
<script src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap-alert.js"></script> 
<script src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap-button.js"></script>
</body>
</html>