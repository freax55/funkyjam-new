<?php
$auth_user = $this->Session->read('User');
?>
<div class="box">
	<h2><?= $pages_admin[$params['controller']]['title'] ?></h2>
	<?php
	$buttons = array(
		'view' => array(
			'href' => '/admin/' .$params['controller']. '/'
		),
	);
	?>
	<div class="row mb10">
		<div class="col-md-6">

		</div>
		<div class="col-md-6"><?= $this->common->getButtons($buttons) ?></div>
	</div>

	<?= $this->Form->create($controller_camel_case, array('novalidate' => true, 'name'=>'myForm', 'action'=>'post', 'url'=>'/admin/' .$params['controller']. '/post/', 'type' => 'file')) ?>
	<?php
	print $this->Form->input('referer', array(
		'type' => 'hidden',
		'value' => $referer
	));
	print $this->Form->input('id', array(
		'type' => 'hidden',
		'value' => $data[$controller_camel_case]['id']
	));
	print $this->Form->input('isAgency', array(
		'type' => 'hidden',
		'value' => 0
	));
	?>

	<table class="table table-striped table-bordered">
		<tr>
			<th style="width: 160px">公開設定</td>
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
			<th>ホテル名<?= $this->common->getMust() ?></th>
			<td>
				<?php
				print $this->Form->input('name', array(
					'label' => false,
					'value' => $data[$controller_camel_case]['name'],
					'class' => 'form-control',
				));
				?>
			</td>
		</tr>
		<tr>
			<th>ホテルの種類<?= $this->common->getMust() ?></th>
			<td>
				<?= $this->Form->input('type_id', array(
					'label' => false,
					'type' => 'select',
					'selected' => isset($data[$controller_camel_case]['type_id']) ? $data[$controller_camel_case]['type_id'] : 0,
					'options' => array(0 => "▼選択", "ホテルタイプ" => $hotel_types),
					'div' => false,
					'style' => 'width:200px',
					'class' => 'form-control',
					'error' => false
				));
				?>
			</td>
		</tr>
		<tr>
			<th>URL</th>
			<td>
				<?php
				print $this->Form->input('url', array(
					'label' => false,
					'value' => $data[$controller_camel_case]['url'],
					'class' => 'form-control',
					'placeholder' => 'http://www.hnt.co.jp/'
				));
				?>
			</td>
		</tr>
		<tr>
			<th>電話番号<?= $this->common->getMust() ?></th>
			<td>
				<?php
				print $this->Form->input('tel', array(
					'label' => false,
					'value' => $data[$controller_camel_case]['tel'],
					'class' => 'form-control input-size-de',
				));
				?>
			</td>
		</tr>
		<tr>
			<th>住所<?= $this->common->getMust() ?></th>
			<td>
				<?php
				print $this->Form->input('pref_id', array(
					'label' => false,
					'type' => 'select',
					'selected' => isset($data[$controller_camel_case]['pref_id']) ? $data[$controller_camel_case]['pref_id'] : 0,
					'options' => array(0 => "▼選択", "都道府県" => $prefs),
					'div' => false,
					'error' => false,
					'style' => 'width:140px',
					'class' => 'form-control',
				));
				print $this->Form->input('city_id', array(
					'label' => false,
					'type' => 'select',
					'selected' => isset($data[$controller_camel_case]['city_id']) ? $data[$controller_camel_case]['city_id'] : 0,
					'options' => array(0 => "▼選択"),
					'div' => false,
					'error' => false,
					'style' => 'width:140px',
					'class' => 'form-control',
				));
				print $this->Form->input('area_id', array(
					'label' => false,
					'type' => 'select',
					'selected' => isset($data[$controller_camel_case]['area_id']) ? $data[$controller_camel_case]['area_id'] : 0,
					'options' => array(0 => "▼選択"),
					'div' => false,
					'error' => false,
					'style' => 'width:300px',
					'class' => 'form-control',
				));
				?>
				<hr style="margin:5px 0">
				<?php
				print $this->Form->input('address', array(
					'label' => false,
					'div' => false,
					'value' => trim($data[$controller_camel_case]['address']),
					'class' => 'form-control input-size-lg',
					'style' => 'width:494px',
					'error' => false,
					'placeholder' => '番地まで入力'
				));
				?>
				<a href="javascript:void(0);" onclick="showTheLatLng()" class="btn btn-primary">座標取得</a>
				<?= $this->Form->error("Hotel.pref_id") ?>
				<?= $this->Form->error("Hotel.city_id") ?>
				<?= $this->Form->error("Hotel.address") ?>
				<div id="gmap" style="width:100%;height:300px;margin:10px auto;"></div>
				<div class="input-prepend input-append">
					<span class="add-on">緯度</span>
					<?= $this->Form->input('lat', array(
						'type' => 'text',
						'label' => false,
						'div' => false,
						'value' => isset($data[$controller_camel_case]['lat']) ? $data[$controller_camel_case]['lat'] : LAT,
						'readonly' => true,
					)) ?>
					<span class="add-on">経度</span>
					<?= $this->Form->input('lon', array(
						'type' => 'text',
						'label' => false,
						'div' => false,
						'value' => isset($data[$controller_camel_case]['lon']) ? $data[$controller_camel_case]['lon'] : LON,
						'readonly' => true,
					)) ?>
				</div>
			</td>
		</tr>
		<tr>
			<th>最安値<?= $this->common->getMust() ?></th>
			<td>
				<div class="input-group" style="width:120px">
					<?php
					print $this->Form->input('min_charge', array(
						'label' => false,
						'value' => $data[$controller_camel_case]['min_charge'],
						'class' => 'form-control',
						'error' => false,
						'placeholder' => '2000'
					));
					?>
					<span class="input-group-addon">円〜</span>
				</div>
				<?= $this->Form->error("Hotel.min_charge") ?>
			</td>
		</tr>
		<tr>
			<th>平米<?= $this->common->getMust() ?></th>
			<td>
				<div class="input-group" style="width:120px">
					<!-- <span class="input-group-addon">担当</span> -->
					<?= $this->Form->input('square_meter', array(
						'type' => 'text',
						'label' => false,
						'div' => false,
						'value' => $data[$controller_camel_case]['square_meter'],
						'class' => 'form-control',
						'placeholder' => '30'
					));
					?>
					<span class="input-group-addon">m&sup2;〜</span>
				</div>
			</td>
		</tr>
		<tr>
			<th>デイユース</td>
			<td>
				<?php
				print $this->Form->radio('dayuse', array('y' => 'あり', 'n' => 'なし'), array(
					'legend' => false,
					'value' => isset($data[$controller_camel_case]['dayuse']) ? $data[$controller_camel_case]['dayuse'] : 'n',
				));
				?>
			</td>
		</tr>
		<tr>
			<th>最寄り駅</th>
			<td>
				<?php
				if (isset($data[$controller_camel_case]['nearest_station'])) {
					print '<span class="badge">' . $data[$controller_camel_case]['nearest_station'] . '</span>';
				}
				?>
				<?= $this->Form->input('station_q', array(
					'label' => false,
					'type' => 'text',
					'class' => 'form-control station_q',
					'placeholder' => '最寄り駅を入力'
				));
				?>
				<?php
				print $this->Form->input('station_ids', array(
					'label' => false,
					'div' => false,
					'type' => 'select',
					'multiple' => true,
					'class' => 'form-control stations',
					'style' => 'min-height:100px;margin:10px auto',
					'options' => $stations_options
				));
				?>
				<button type="button" class="btn btn-sm btn-danger" onclick="del_row('station'); return false;"><i class="icon icon-minus-sign"></i> 選択行削除</button>
			</td>
		</tr>
		<tr>
			<th>備考</th>
			<td>
				<?php
				print $this->Form->input('comment', array(
					'label' => false,
					'type' => 'textarea',
					'value' => $data[$controller_camel_case]['comment'],
					'class' => 'form-control',
					'style' => 'height: 300px'
				));
				?>
			</td>
		</tr>
	</table>

	<div class="form-actions tac">
		<button class="btn btn-lg btn-primary" type="submit" onclick="allSelected()"><i class="icon icon-ok"></i>&nbsp;登録する</button>
	</div>
	<?= $this->Form->end() ?>
</div>
