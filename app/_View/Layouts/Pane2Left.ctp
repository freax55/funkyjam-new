<?php require_once('Header.ctp') ?>

<?php echo $this->Session->flash(); ?>
<h1><?= (isset($h1) ? $h1 : $pages[$current]['title']) ?></h1>

<section class="breadcrumb breadcrumb-global">
	<div class="container cf">
		<?php
		if (isset($path)) {
			print $this->BreadCrumb->show($path);
		} else {
		?>
		<p><i class="fa fa-warning"></i> イクリストは18才未満の方には不適切な内容が含まれています。速やかにご退出ください。</p>
		<?php
		}
		?>
	</div>
</section>

<?php
// pr($this->params);
if (
	$this->params['controller'] == 'shop' &&
	$this->params['action'] == 'detail'
) {
	$d = $data_shop['Shop'];
	// 店舗スクリーンショットが存在するか否か
	if ($d['img_list'] != "") {
		print '<div class="shop-main-img img-wrapper"><figure class="inner img-inner"><img src="/img/shop/' . $d['img_list'] . '" alt="' . $d['name'] . '"></figure></div>';
	} else if(file_exists(IMG_DIR . 'shop/ss/' . $d['id'] . '.png')) {
		print '<div class="shop-main-img img-wrapper"><figure class="inner img-inner"><img src="/img/shop/ss/' . $d['id'] . '.png" alt="' . $d['name'] . '"></figure></div>';
	} else {
		print '<div class="shop-main-img img-wrapper"><figure class="inner img-inner"><img src="/img/noimage-shop.jpg" alt="' . $d['name'] . '"></figure></div>';
	}
}
?>
<article id="pane2left" class="container cf relative shop-detail">
	<main id="column-main" class="mt30">
		<?php echo $this->fetch('content'); ?>
	</main>
	<aside id="column-left" class="mt30">
		<?php
		// 受け取った配列をエレメントとして書き出す
		$cnt = count($left_column);
		if (!empty($left_column)) {
			for ($i=0; $i<$cnt; $i++) {
				print View::element($left_column[$i]);
			}
		} else {
			print "&nbsp;";
		}
		?>
	</aside>
</article>

<?php require_once('Footer.ctp') ?>
