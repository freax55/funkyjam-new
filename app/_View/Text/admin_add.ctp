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
			<th>公開設定<?= $this->common->getMust() ?></th>
			<td>
				<?php
				$array_status = array('y' => '公開', 'n' => '非公開');
				// if ($auth_user['User']['role_id'] <= 3) {
					print $this->Form->radio('status', $array_status, array(
						'legend' => false,
						'value' => isset($data[$controller_camel_case]['status']) ? $data[$controller_camel_case]['status'] : 'n',
					));
				?>
			</td>
		</tr>
		<tr>
			<th style="width:20%">テキストタイプ<?= $this->common->getMust() ?></th>
			<td colspan="2">
				<?php
				print $this->Form->input('type_id', array(
					'type' => 'select',
					'selected' => isset($data[$controller_camel_case]['type_id']) ? $data[$controller_camel_case]['type_id'] : 0,
					'options' => array(0 => "▼選択", "タイプ" => $text_type),
					'label' => false,
					'error' => false,
					'div' => false,
					'style' => 'width:120px',
					'class' => 'form-control',
				));
				?>
				<?= $this->Form->error('Text.type_id') ?>
			</td>
		</tr>
		<tr>
			<th>表示先ID<?= $this->common->getMust() ?></th>
			<td colspan="2">
				<?php
				print $this->Form->input('original_id', array(
					'label' => false,
					'type' => 'text',
					'value' => $data[$controller_camel_case]['original_id'],
					'class' => 'form-control',
					'maxLength' => 2,
				));
				?>
			</td>
		</tr>
		<tr>
			<th>並び順</th>
			<td colspan="2">
				<?php
				print $this->Form->input('sort_id', array(
					'label' => false,
					'type' => 'text',
					'value' => $data[$controller_camel_case]['sort_id'],
					// 'defalut' => 0,
					'class' => 'form-control',
					'maxLength' => 2,
				));
				?>
			</td>
		</tr>
		<tr>
			<th style="white-space:nowrap">タイトル</th>
			<td>
				<?= $this->Form->input('title', array(
					'label' => false,
					'type' => 'text',
					'value' => $data[$controller_camel_case]['title'],
					'class' => 'form-control',
					'maxlength' => '60',
				));
				?>
			</td>
		</tr>
		<tr>
		<th>本文</th>
			<td>
				<?php
				print $this->Form->input('content', array(
					'label' => false,
					'type' => 'textarea',
					'value' => $data[$controller_camel_case]['content'],
					'class' => 'form-control',
					'style' => 'height: 300px'
				));
				?>
			</td>
		</tr>
	</table>

	<div class="form-actions" style="text-align:center">
		<button class="btn btn-lg btn-primary" type="submit" onclick="allSelected()"><i class="icon icon-ok"></i>&nbsp;登録する</button>
	</div>
	<?= $this->Form->end() ?>
</div>
