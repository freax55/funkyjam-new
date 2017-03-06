<?php
$auth_user = $this->Session->read('User');
?>
<div class="box">
	<h2><?= $pages_admin[$params['controller']]['title'] ?></h2>
	<?php
	if (isset($result_caption)) {
		$r_caption = $result_caption;
	} else {
		$r_caption = "キーワードを入力...";
	}

	if (isset($result_caption)) {
		$buttons = array(
			'view' => array(
				'href' => '/admin/' .$params['controller']. '/'
			),
			'add' => array(
				'href' => '/admin/' .$params['controller']. '/add/'
			),
		);
	} else {
		$buttons = array(
			'add' => array(
				'href' => '/admin/' .$params['controller']. '/add/'
			),
		);
	}
	?>
	<div class="row">
		<?= $this->Form->create('Hotel', array("action"=>"search", 'url'=>'/admin/' .$params['controller']. '/search/', "type"=>"get", 'style'=>'float: left; margin-bottom: 0;')); ?>
		<div class="col-md-6">
			<div class="input-group">
				<?= $this->Form->input('pref_id', array(
					'label' => false,
					'type' => 'select',
					'selected' => isset($query['pref_id']) ? $query['pref_id'] : 0,
					'options' => array(0 => "▼選択", "都道府県" => $prefs),
					'div' => false,
					'style' => 'width:140px',
					'class' => 'form-control',
					'error' => false
				));
				?>
				<?= $this->Form->input('q', array(
					'type' => 'text',
					'label' => false,
					'div' => false,
					'class' => 'form-control hotel_q',
					'style' => 'width:398px',
					'placeholder' => $r_caption
				)); ?>
				<span class="input-group-btn">
					<button class="btn btn-default" type="submit"><i class="icon icon-search"></i></button>
				</span>
			</div>
		</div>
		<div class="col-md-6"><?= $this->common->getButtons($buttons) ?></div>
		<?= $this->Form->end() ?>
	</div>

	<table class="table table-striped table-bordered table-hover">
		<thead>
		<tr>
			<th style="width:70px">ID</th>
			<th style="width:51px">状態</th>
			<th style="width:73px">都道府県</th>
			<th>ホテル名</th>
			<th class="action">操作</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$controller_camel_case = Inflector::camelize($params['controller']);
		foreach ($data as $k => $v) {
			$d = $v[$controller_camel_case];
			?>
			<tr>
				<td><?= $d['id'] ?></td>
				<td class="tac"><?= ($d['status'] == 'y') ? '<span class="label label-primary">公開</span>' : '<span class="label label-default">非公開</span>' ?></td>
				<td><?= $prefs[$d['pref_id']] ?></td>
				<td><a href="/hotel/<?= $d['id'] ?>/" target="_blank"><?= $d['name'] ?></a></td>
				<td>
				<?php
				if ($auth_user['User']['role_id'] <= 2) {
					print $this->common->getActionEditDelete($params['controller'], $d['id']);
				} else if ($auth_user['User']['role_id'] == 3) {
					print '<div class="action-edit-delete btn-group"><a href="/admin/hotel/agency/' . $d['id'] . '/" class="btn btn-sm btn-info"><i class="icon icon-edit"></i>&nbsp;カバーガール</a></div>';
				}
				?>
				</td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
	<?= View::element('pagination') ?>
</div>