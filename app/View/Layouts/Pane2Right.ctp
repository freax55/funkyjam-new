<?php require_once('Header.ctp') ?>

<div id="column-wrapper" class="container container-wrap df">
	<?php echo $this->Session->flash(); ?>
	<main id="column-main-pane2-right">
		<?php echo $this->fetch('content'); ?>
		<?php
		?>
	</main>
	<aside id="column-right">
		<?php
		// 受け取った配列をエレメントとして書き出す
		$cnt = count($right_column);
		if (!empty($right_column)) {
			for ($i=0; $i<$cnt; $i++) {
				print View::element($right_column[$i]);
			}
		} else {
			print "&nbsp;";
		}
		?>
	</aside>
</div>
<?php require_once('Footer.ctp') ?>
