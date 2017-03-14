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
			<th>権限名<?= $this->Common->getMust() ?></th>
			<td>
			<?php
			print $this->Form->input('name', array(
				'label' => false,
				'type' => 'text',
				'value' => $data['Role']['name'],
				'class' => 'text2'
			));
			?>
			</td>
		</tr>
		<tr>
			<th>権限名(日本語)<?= $this->Common->getMust() ?></th>
			<td>
			<?php
			print $this->Form->input('name_ja', array(
				'label' => false,
				'type' => 'text',
				'value' => $data['Role']['name_ja'],
				'class' => 'text2'
			));
			?>
			</td>
		</tr>
		<?php
		foreach($pages_admin as $k => $v){
			if ($k != 'login') {
		?>
		<tr>
			<th><?= $v['title'] ?></th>
			<td>
			<?= $this->Form->radio($k. '_status', array('y' => 'アクセス許可', 'n' => '不可'), array(
				'legend'=>false,
				'value' => isset($data['Role'][$k. '_status']) ? $data['Role'][$k. '_status'] : 'n'
			));
			?>
			</td>
		</tr>
		<?php
			}
		}
		?>
	</table>

	<?php
	$buttons = array(
		"submit" => array()
	);
	print $this->Common->getContentHeader('', $buttons);
	?>
	<?= $this->Form->end() ?>
</div>