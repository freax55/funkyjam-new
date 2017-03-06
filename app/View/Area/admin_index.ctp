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
		<?= $this->Form->create('Area', array("action"=>"search", 'url'=>'/admin/' .$params['controller']. '/search/', "type"=>"get", 'style'=>'float: left; margin-bottom: 0;')); ?>
		<div class="col-md-6">
			<div class="input-group">
				<?= $this->Form->input('q', array(
					'type' => 'text',
					'label' => false,
					'div' => false,
					'class' => 'form-control area_q',
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
	<table class="table table-striped table-bordered">
		<thead>
		<tr>
			<th style="width:100px">都道府県</th>
			<th>エリア名</th>
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
				<td><?= $prefs[$d['pref_id']] ?></td>
				<td><?= $d['name'] ?></td>
				<td><?= $this->common->getActionEditDelete($params['controller'], $d['id']) ?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
	<?= View::element('pagination') ?>
</div>
