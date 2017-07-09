<?php
// $auth_user = $this->Session->read('User');
?><!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex,nofollow">
	<title>[管理画面]</title>
	<link rel="stylesheet" href="/css/admin.css?v=<?= VERSION_CSS ?>" type="text/css">
	<link rel="stylesheet" href="/css/bootstrap.css" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>	<?php
	if (isset($css)) {
		foreach ($css as $v) {
			echo "<link rel=\"stylesheet\" href=\"/css/" .$v. ".css\" type=\"text/css\">\n";
		}
	}
	?>
</head>


<body id="body_superbox">
<div id="wrapper">
