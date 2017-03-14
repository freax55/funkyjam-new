<div class="box">
	<h2><?= $pages_admin[$params['controller']]['title'] ?></h2>
	<?php
	if (isset($result_caption)) {
		$r_caption = $result_caption;
	} else {
		$r_caption = "ID、店名、URL、電話番号、キャッチコピー、紹介文、管理者コメント・メアドから";
	}

	$search_box = $this->Form->create('Banner', array("action"=>"search", 'url'=>'/admin/' .$params['controller']. '/search/', "type"=>"get", 'style'=>'float: left; margin-bottom: 0;'));
	$search_box.= '<div class="input-append">';
	$search_box.= $this->Form->input('q', array(
		'type' => 'text',
		'label' => false,
		'div' => false,
		'style' => 'width:600px !important',
		'placeholder' => $r_caption
	));
	$search_box.= '<button class="btn" type="submit" style="margin-left:-1px"><i class="icon icon-search"></i></button>';
	$search_box.= '</div>';
	$search_box.= $this->Form->end();
	// $search_box = null;
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
			'sort' => array(
				'href' => '/admin/' .$params['controller']. '/sort/'
			),
			'add' => array(
				'href' => '/admin/' .$params['controller']. '/add/'
			),
		);
	}
	print $this->common->getContentHeader($search_box, $buttons);
	?>
	<table class="table table-striped table-bordered">
		<thead>
		<tr>
			<!-- <th>投稿日</th> -->
			<th>ID</th>
			<th style="width:58px">状態</th>
			<th>バナータイプ</th>
			<th>店名</th>
			<th class="action">操作</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$controller_camel_case = Inflector::camelize($params['controller']);
		foreach ($data as $k => $v) {
			$d = $v[$controller_camel_case];
			$s = $v['Shop'];
			?>
			<tr>
				<!-- <td><?= $this->common->date4mat($d['created'], 'Y/m/d') ?></td> -->
				<td><?= $d['id'] ?></td>
				<td style="text-align:center"><?= ($d['status'] == 'y') ? '<span class="label label-primary">公開</span>' : '<span class="label label-default">非公開</span>' ?></td>
				<td><?= $banner_types[$d['type_id']] ?></td>
				<td><?= $s['name'] ?></td>
				<td><?= $this->common->getActionEditDelete($params['controller'], $d['id']) ?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
	<?= View::element('pagination') ?>
</div>
