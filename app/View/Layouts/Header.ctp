<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title><?= $title ?></title>
<meta name="description" content="<?= $description ?>">
<?php
if ($noindex) {
	print '<meta name="robots" content="noindex">';
}
?>
<?php
if ($canonical){
	$link = preg_replace('/page:[0-9]+/', '', $this->here);
	if (isset($this->params->query) && !empty($this->params->query)) {
		$link.= '?' . http_build_query($this->params->query, '', '&');
	}
        $link = strtr($link, ['//'=>'/']);
?>
<link rel="canonical" href="https://kclub-rank.com<?= $link ?>">
<?php
} else {
	$link = $this->here;
}
?>
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<link href="/css/common.css?v=<?= VERSION_CSS ?>" rel="stylesheet">
<link rel="stylesheet" href="https://i.icomoon.io/public/d959538b88/kclub-rank/style.css">
</head>
<body>
<header id="header" class="container df mb30">
	<a href="/" class="logo-box">
		<figure class="tac">
			<img src="/img/logo.svg" alt="<?= SITENAMEMETA ?>" class="mb10">
		</figure>
	</a>
	<a href="" class="db">
		<figure class="bnr-header tac">
			<img data-src="/img/bnr-ad-936-120.png" alt="スポンサー募集" src="/img/loader.gif" class="ready-img">
			<figcaption class="mt5">スポンサー募集</figcaption>
		</figure>
	</a>
</header>
<?php if (isset($path)) : ?>
<section class="breadcrumb breadcrumb-global mb10">
	<?= $this->BreadCrumb->show($path) ?>
</section>
<?php endif; ?>