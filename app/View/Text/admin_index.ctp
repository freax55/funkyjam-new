<div class="box">
	<h2><?= $pages_admin[$params['controller']]['title'] ?></h2>
	<?php
	// if (isset($result_caption)) {
	// 	$r_caption = $result_caption;
	// } else {
	// 	$r_caption = "キーワードを入力...";
	// }

	// if (isset($result_caption)) {
	// 	$buttons = array(
	// 		'view' => array(
	// 			'href' => '/admin/' .$params['controller']. '/'
	// 		),
	// 		'add' => array(
	// 			'href' => '/admin/' .$params['controller']. '/add/'
	// 		),
	// 	);
	// } else {
	// 	$buttons = array(
	// 		'add' => array(
	// 			'href' => '/admin/' .$params['controller']. '/add/'
	// 		),
	// 	);
	// }
	?>
	<table class="table table-striped table-bordered">
		<thead>
		<tr>
			<th>id</th>
			<th>タイプ</th>
			<th>表示先id</th>
			<th>ページ内表示順</th>
			<th>操作</th>
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
				<td><?= $text_type[$d['type_id']]?></td>
				<td><?= $d['original_id'] ?></td>
				<td><?= $d['sort_id'] ?></td>
				<td><?= $this->common->getActionEditDelete($params['controller'], $d['id']) ?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
	<?= View::element('pagination') ?>
</div>
