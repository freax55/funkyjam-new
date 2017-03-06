<?php
$auth_user = $this->Session->read('User');
?><!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex,nofollow">
	<title>[管理画面] <?= $title ?></title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" media="all">
	<link rel="stylesheet" href="/css/admin.css?v=<?= VERSION_CSS ?>" type="text/css">
	<?php
	if (isset($css)) {
		foreach ($css as $v) {
			echo "<link rel=\"stylesheet\" href=\"/css/" .$v. ".css\" type=\"text/css\">\n";
		}
	}
	?>
</head>

<body>

<div class="row">
	<div class="col-md-12" id="topsection">
		<div class="col-md-6">
			<h1><a href="/admin/" class="logo navbar-brand" id="header-logo"><img src="/img/logo.svg" width="200" alt="<?= SITENAMEMETA ?>"></a></h1>
			<?php
			if (strpos(MYHOST, 'localhost') !== false) {
				print '<span class="label label-default">ローカル開発環境</span>';
			} else if (strpos(MYHOST, 'dev') !== false) {
				print '<span class="label label-default">開発環境</span>';
			} else if (strpos(MYHOST, 'stage') !== false) {
				print '<span class="label label-red">ステージング環境</span>';
			}
			?>
			</h1>
		</div>
		<div class="col-md-6">
			<?php
			if (!empty($auth_user)) {
				print '<p><i class="icon icon-user"></i>&nbsp;' .$auth_user['User']['name']. '@' .$auth_user['Role']['name_ja']. '　';
				print '<a href="/admin/logout/" class="btn btn-sm btn-default"><i class="icon icon-off"></i> ログアウト</a></p>';
			}
			?>
		</div>
	</div>
</div>
