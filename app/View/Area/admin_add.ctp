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
			<th style="width:20%">都道府県<?= $this->common->getMust() ?></th>
			<td colspan="2">
				<?php
				print $this->Form->input('pref_id', array(
					'type' => 'select',
					'selected' => isset($data[$controller_camel_case]['pref_id']) ? $data[$controller_camel_case]['pref_id'] : 0,
					'options' => array(0 => "▼選択", "都道府県" => $prefs),
					'label' => false,
					'error' => false,
					'div' => false,
					'style' => 'width:120px',
					'class' => 'form-control',
				));
				?>
				<?= $this->Form->error('Area.pref_id') ?>
			</td>
		</tr>
		<tr>
			<th>エリア名<?= $this->common->getMust() ?></th>
			<td colspan="2">
				<?php
				print $this->Form->input('name', array(
					'label' => false,
					'value' => $data[$controller_camel_case]['name'],
					'class' => 'form-control',
					'maxLength' => 50,
				));
				?>
			</td>
		</tr>
		<tr>
			<th>市区町村<?= $this->common->getMust() ?></th>
			<td style="height:100%;width:286px">
				<select name="data[Area][city]" id="AreaCity" class="input-block-level form-control" style="min-height:500px;height:100%" multiple></select>
				<div class="form-actions" style="text-align:center;margin:0">
					<button type="button" class="btn btn-mini btn-info" onclick="add_row('city'); return false;"><i class="icon icon-plus-sign"></i> 選択行追加</button>
				</div>
			</td>
			<td style="height:100%;width:286px">
				<?php
				$city_ids_options = [];
				if (isset($data['Area']['city_ids']) && !empty($data['Area']['city_ids'])) {
					$city_ids = json_decode($data['Area']['city_ids'], true);
					foreach ($city_ids as $k => $v) {
						$city_ids_options[$k] = $data_cities[$k];
					}
				}
				print $this->Form->input('city_ids', array(
					'label' => false,
					'div' => false,
					'type' => 'select',
					'multiple' => true,
					'class' => 'input-block-level form-control',
					'style' => 'min-height:500px;height:100%',
					'options' => $city_ids_options
				));
				?>
				<div class="form-actions" style="text-align:center;margin:0">
					<button type="button" class="btn btn-mini btn-danger" onclick="del_row('city'); return false;"><i class="icon icon-minus-sign"></i> 選択行削除</button>
				</div>
			</td>
		</tr>
	</table>

	<div class="form-actions" style="text-align:center">
		<button class="btn btn-lg btn-primary" type="submit" onclick="allSelected()"><i class="icon icon-ok"></i>&nbsp;登録する</button>
	</div>
	<?= $this->Form->end() ?>
</div>
