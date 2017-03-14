<div class="box">
	<h2><?= $pages_admin[$params['controller']]['title'] ?></h2>
	<?php
	$buttons = array(
		'view' => array(
			'href' => '/admin/' .$params['controller']. '/'
		),
	);
	print $this->common->getContentHeader("", $buttons);
	?>
	<?= $this->Form->create($controller_camel_case, array('novalidate' => true, 'name'=>'myForm', 'action'=>'post', 'url'=>'/admin/' .$params['controller']. '/post/', 'type' => 'file')) ?>
	<?php
	print $this->Form->input('id', array(
		'type' => 'hidden',
		'value' => $data[$controller_camel_case]['id']
	));
	?>
	<table class="table table-striped table-bordered">
		<tr>
			<th>公開設定</td>
			<td>
				<?php
				print $this->Form->radio('status', array('y' => '公開する', 'n' => 'しない'), array(
					'legend' => false,
					'value' => isset($data[$controller_camel_case]['status']) ? $data[$controller_camel_case]['status'] : 'y',
				));
				?>
			</td>
		</tr>
		<tr>
			<th>店舗名<?= $this->common->getMust() ?></th>
			<td>
				<?php
				print $this->Form->input('shop_id', array(
					'label' => false,
					'type' => 'text',
					'value' => isset($data[$controller_camel_case]['shop_id']) ? $data[$controller_camel_case]['shop_id'] : null,
					'class' => 'form-control'
				));
				?>
			</td>
		</tr>
		<tr>
			<th>キャプション<?= $this->common->getMust() ?></th>
			<td>
				<p class="red">20文字以内で入れてください。ここの文言でクリック率が決まると言っても過言じゃない！</p>
				<?php
				print $this->Form->input('caption', array(
					'label' => false,
					'type' => 'text',
					'value' => $data[$controller_camel_case]['caption'],
					'class' => 'form-control'
				));
				?>
			</td>
		</tr>
		<tr>
			<th>バナータイプ<?= $this->common->getMust() ?></th>
			<td>
				<?php
				$banner_types2 = [
					0 => '▼選択'
				];
				foreach ($banner_types as $k => $v) {
					$banner_types2['バナータイプ'][$k] = $v;
				}
				print $this->Form->input('type_id', array(
					'label' => false,
					'type' => 'select',
					'selected' => isset($data[$controller_camel_case]['type_id']) ? $data[$controller_camel_case]['type_id'] : 0,
					// 'options' => array(0 => "▼選択", "バナータイプ" => $banner_types2),
					'options' => $banner_types2,
					'div' => false,
					'class' => 'form-control'
				));
				?>
			</td>
		</tr>
		<?php

		/*
		<tr>
			<th>エリアバナー用エリア設定<br><?= $this->common->getMust('「エリア大バナー」「スマホエリア一覧バナー」「求人エリア大バナー」の場合は、<br>必ず設定してください。') ?></th>
			<td>
				<?php
				$display_area_select = '';
				$cnt = 10;
				if (isset($data['Banner']['area_ids'])) {
					$area_ids = json_decode($data['Banner']['area_ids'], true);
					foreach ($area_ids as $k => $v) {
						print '<div style="margin:3px 0">';
						print $this->Form->input('area_pref_id][', array(
							'label' => false,
							'type' => 'select',
							'selected' => array_keys($v)[0],
							'options' => array(0 => "都道府県", "▼選択" => $prefs),
							'div' => false,
							'style' => 'width:120px',
							'error' => false,
							'class' => 'form-control area-config',
						));
						print $this->Form->input('area_id][', array(
							'label' => false,
							'type' => 'select',
							'data-selected' => array_values($v)[0],
							'options' => array(0 => "出張可能エリア"),
							'div' => false,
							'error' => false,
							'style' => 'width:360px',
							'class' => 'form-control area',
						));
						print '</div>';
					}
					$cnt = MAX_COUNT_AREA-count($area_ids);
				}
				for ($i=1; $i<=$cnt; $i++) {
					print '<div style="margin:3px 0">';
					print $this->Form->input('area_pref_id][', array(
						'label' => false,
						'type' => 'select',
						'options' => array(0 => "都道府県", "▼選択" => $prefs),
						'div' => false,
						'style' => 'width:120px;' . $display_area_select,
						'error' => false,
						'class' => 'form-control area-config',
					));
					print $this->Form->input('area_id][', array(
						'label' => false,
						'type' => 'select',
						'options' => array(0 => "出張可能エリア"),
						'div' => false,
						'error' => false,
						'style' => 'width:360px;' . $display_area_select,
						'class' => 'form-control area',
					));
					print '</div>';
				}
				?>
				<?= $this->Form->error("Banner.area_pref_id") ?>
				<?= $this->Form->error("Banner.area_id") ?>
			</td>
		</tr>
		*/
		?>
		<tr>
			<th>バナー画像<?= $this->common->getMust() ?><br>
			-グリッド嬢バナー&nbsp;310&nbsp;x&nbsp;190<br>
			-ブックマークバナー&nbsp;310&nbsp;x&nbsp;190<br>
			-トップサイドバナー&nbsp;300&nbsp;x&nbsp;300</th>
			<td>
				<?php
				if (isset($data[$controller_camel_case]['img_pc']) && $data[$controller_camel_case]['img_pc'] != "") {
					// list($width, $height) = getimagesize(IMAGES. 'banner' .DS . $data[$controller_camel_case]['img']);
					print '<img src="/img/banner/' . $data[$controller_camel_case]['img_pc'] /*. '" width="' . $width . '" height="' . $height */. '">';
					print $this->Form->input('img_pc', array('type'=>'hidden','value'=>$data[$controller_camel_case]['img_pc']));
					print '<br>';
					print "<a href=\"/admin/banner/delete_image/";
					print $data[$controller_camel_case]['id'] . DS . 'img_pc' . DS;
					print '" onclick="return confirm(\'画像を削除してもよろしいですか？\');" class="btn btn-danger" style="float:right">';
					print '<i class="icon icon-remove"></i> 画像を削除する</a>';
				}
				?>

				<?php
				/*
				input type="file" name="data[img]" class="file"
				*/
				?>
				<input type="file" name="data[img_pc]">
				<input type="hidden" name="data[img_pc]">
				<?php
				// print $this->Form->input('img', array(
				// 	'type' => 'file',
				// 	'label' => false,
				// 	'div' => false,
				// ));
				?>
			</td>
		</tr>
		<tr>
			<th>バナー画像（スマホ用）<?= $this->common->getMust() ?><br>
			-グリッド嬢バナー&nbsp;710&nbsp;x&nbsp;380<br>
			-ブックマークバナー&nbsp;710&nbsp;x&nbsp;380<br>
			-トップサイドバナー&nbsp;710&nbsp;x&nbsp;308
			</th>
			<td>
				<?php
				if (isset($data[$controller_camel_case]['img_sp']) && $data[$controller_camel_case]['img_sp'] != "") {
					// list($width, $height) = getimagesize(IMAGES. 'banner' .DS . $data[$controller_camel_case]['img_sp']);
					print '<img src="/img/banner/' . $data[$controller_camel_case]['img_sp'] /*. '" width="' . $width . '" height="' . $height */. '">';
					print $this->Form->input('img_sp', array('type'=>'hidden','value'=>$data[$controller_camel_case]['img_sp']));
					print '<br>';
					print "<a href=\"/admin/banner/delete_image/";
					print $data[$controller_camel_case]['id'] . DS . 'img_sp' . DS;
					print '" onclick="return confirm(\'画像を削除してもよろしいですか？\');" class="btn btn-danger" style="float:right">';
					print '<i class="icon icon-remove"></i> 画像を削除する</a>';
				}
				?>
				<input type="file" name="data[img_sp]" class="file">
				<input type="hidden" name="data[img_sp]">
				<?php
				// print $this->Form->input('img', array(
				// 	'type' => 'file',
				// 	'label' => false,
				// 	'div' => false,
				// ));
				?>
			</td>
		</tr>
	</table>

	<div class="form-actions" style="text-align:center">
		<button class="btn btn-primary" type="submit" onclick="allSelected()"><i class="icon icon-ok"></i>&nbsp;登録する</button>
	</div>
	<?= $this->Form->end() ?>
</div>
