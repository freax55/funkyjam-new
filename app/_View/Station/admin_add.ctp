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
			<td>
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
			<th>駅名<?= $this->common->getMust() ?></th>
			<td>
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
			<th>ふりがな<?= $this->common->getMust() ?></th>
			<td>
				<?php
				print $this->Form->input('name_ruby', array(
					'label' => false,
					'value' => $data[$controller_camel_case]['name_ruby'],
					'class' => 'form-control',
					'maxLength' => 50,
				));
				?>
			</td>
		</tr>
	</table>

	<?php
	$buttons = array(
		"submit" => array()
	);
	print $this->common->getContentHeader("", $buttons);
	?>
	<?= $this->Form->end() ?>
</div>
