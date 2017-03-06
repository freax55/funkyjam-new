<div class="box">
	<h2><?= $pages_admin[$params['controller']]['title'] ?></h2>

	<?php
	$buttons = array(
		'view' => array(
			'href' => '/admin/' .$params['controller']. '/'
		),
	);
	print $this->common->getContentHeader('<span class="px22">バナー並び替え</span>', $buttons);
	?>
	<div class="alert">
		<i class="icon icon-info-sign"></i> 画像をドラッグ&ドロップして表示順序を変更することが出来ます。完了後、"並び替え確定" ボタンで確定します。
	</div>
	<?= $this->Form->create($controller_camel_case, array('novalidate' => true, 'name'=>'myForm', 'action'=>'sort', 'url'=>'/admin/' .$params['controller']. '/sort/', 'type' => 'file')) ?>
    <input type="hidden" name="sort_id_area" id="sort_id_area" value="">
	<div class="box_sort cf">
		<div id="sort_area">
		<?php
		foreach ($data as $v) {
			$s = $v['Shop'];
			$v = $v['Banner'];
			$width  = $banner_types[$v['type_id']]['width'];
			$height = $banner_types[$v['type_id']]['height'];
		?>
			<div class="sort_item_banner" id="<?= $v["id"] ?>">
				<?php
				print '<img src="/img/banner/' .$v['img']. '" width="' . $width . '" height="' . $height . '">';
				?><br>
				<?= $s["name"] ?>
			</div>
		<?php
		}
		?>
		</div>
	</div>
	<?php
	print $this->Form->input('sort_id', array(
		'type' => 'hidden',
		'value' => '',
	));
	?>
	<div class="form-actions" style="text-align:center">
		<button class="btn btn-primary" type="submit"><i class="icon-white icon-ok"></i>&nbsp;並び替え確定</button>
	</div>
	<?= $this->Form->end() ?>
</div>
