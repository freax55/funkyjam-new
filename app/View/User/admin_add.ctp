<div class="box">
	<h2><?= $pages_admin[$params['controller']]['title'] ?></h2>
	<?php
	$buttons = array(
		'view' => array(
			'href' => '/admin/' .$params['controller']. '/'
		),
	);
	print $this->Common->getContentHeader("", $buttons);
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
			<th style="width:20%">アクセス権限<?= $this->Common->getMust() ?></th>
			<td>
			<?php
			print $this->Form->input('role_id', array(
				'label' => false,
				'type' => 'select',
				'selected' => isset($data['User']['role_id']) ? $data['User']['role_id'] : 4,
				'options' => array(0 => "▼選択", "アクセス権限" => $roles),
				'class' => 'form-control',
			));
			?>
			</td>
		</tr>
		<tr>
			<th>ユーザ名<?= $this->Common->getMust() ?></th>
			<td>
			<?php
			print $this->Form->input('name', array(
				'label' => false,
				'type' => 'text',
				'value' => $data['User']['name'],
				'class' => 'form-control',
			));
			?>
			</td>
		</tr>

		<tr>
			<th>メールアドレス<?= $this->Common->getMust() ?></th>
			<td>
			<?php
			print $this->Form->input('mail', array(
				'label' => false,
				'type' => 'text',
				'value' => $data['User']['mail'],
				'class' => 'form-control',
			));
			?><span class="NOTES">※ログイン時に必要になります</span>
			</td>
		</tr>

		<tr>
			<th>パスワード<?= $this->Common->getMust() ?></th>
			<td>
			<?php
			print $this->Form->input('password', array(
				'label' => false,
				'type' => 'password',
				'value' => $data['User']['password'],
				'class' => 'form-control',
			));
			?>
			</td>
		</tr>

	</table>

	<?php
	$buttons = array(
		"submit" => array()
	);
	print $this->Common->getContentHeader("", $buttons);
	?>
	<?= $this->Form->end() ?>
</div>