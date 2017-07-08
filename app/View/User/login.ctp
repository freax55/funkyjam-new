<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex,nofollow">
	<title>管理画面 -ログイン</title>
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/admin.css" type="text/css">
	<style>
	body{
		background: #343434;
	}
	h1{
		margin: 20px auto;
	}
	.container{
		text-align: center;
	}
	form{ margin: 0 !important; }
	dl {
		margin: 0 20px 0 0;
	}
	dt{

	}
	dd{
		margin:0 auto 10px auto;
	}
	.box{
		margin:0 auto;
		padding: 20px 0;
		width: 500px;
		background: #fff;
		border: 1px solid #dddddd;
		border-collapse: separate;
		*border-collapse: collapse;
		border-left: 0;
		border-bottom: 0;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		-ms-border-radius: 4px;
		-o-border-radius: 4px;
		border-radius: 4px;
		box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
	}
	button{
		margin-top: 10px;
	}
	</style>
</head>

<body>

<div class="container">
	<h1><img src="/img/logo.png" width="102" height="32" alt="<?= SITENAME ?>"></h1>
	<?= $this->Form->create('User', array('novalidate' => true, 'name'=>'myForm', 'action'=>'post', 'url'=>'/user/post/', 'encoding'=>null)) ?>
	<?php
	$data = $data['User'];
	?>
	<div class="box">
		<h2>管理画面ログイン</h2>
		<dl class="dl-horizontal">
			<dt>メールアドレス</dt>
			<dd>
				<div class="input-group">
					<span class="input-group-addon"><i class="icon icon-envelope"></i></span>
					<?= $this->Form->input('mail', array(
						'value' => $data["mail"],
						'type' => 'text',
						'class' => 'form-control',
						'div' => false,
						'label' => false,
						'error' => false
					)) ?>
				</div>
				<?= $this->Form->error("User.mail") ?>
			</dd>
			<dt>パスワード</dt>
			<dd>
				<div class="input-group">
					<span class="input-group-addon"><i class="icon icon-lock"></i></span>
					<?= $this->Form->input('password', array(
						'value' => $data["password"],
						'type' => 'password',
						'class' => 'form-control',
						'div' => false,
						'label' => false,
						'error' => false
					)) ?>
				</div>
				<?= $this->Form->error("User.password") ?>
			</dd>
		</dl>
		<button class="btn btn-primary" type="submit"><i class="fa fa-sign-in"></i> ログイン</button>
	</div>
	<?= $this->Form->end() ?>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>
$(function(){
	$('.error-message').prepend('<i class="icon icon-exclamation-sign"></i> ');
});
</script>
</body>
</html>