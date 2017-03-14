<?php require_once('Header.ctp') ?>

<div id="column-wrapper" class="container container-wrap df">
	<?php echo $this->Session->flash(); ?>
	<main id="column-main-pane2-right">
		<?php echo $this->fetch('content'); ?>
		<?php
		if (isset($params['named']['tag'])) {
			$tags = explode(',', $params['named']['tag']);
			if (
				in_array('av', $tags) ||
				in_array('av_joyuu', $tags)
			) {
				print View::element('part_special_av');
			}
		}
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
