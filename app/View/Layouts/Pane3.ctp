<?php require_once('Header.ctp') ?>
<div class="container container-wrap df">
	<?php echo $this->Session->flash(); ?>
	<?php
	if (isset($pref_name_ja)) {
		$location_name = $pref_name_ja;
		$location_href = '/' . $pref_name_en . '/';
	} else {
		$location_name = '全国';
		$location_href = '';
	}
	?>

	<main role="main" id="column-main-pane3">
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
	<nav role="navigation" id="column-left">
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
	</nav>
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