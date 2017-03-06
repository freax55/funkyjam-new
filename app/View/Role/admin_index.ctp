<div class="box">
	<h2><?= $pages_admin[$params['controller']]['title'] ?></h2>
	<?php
	$buttons = array(
		'add' => array(
			'href' => '/admin/' .$params['controller']. '/add/'
		),
	);
	echo $this->Common->getContentHeader("", $buttons);
	?>
	<table class="table table-striped table-bordered">
		<thead>
		<tr>
			<th class="id">#</th>
			<th>権限名(英語)</th>
			<th>権限名(日本語)</th>
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
				<td><?= $d['name'] ?></td>
				<td><?= $d['name_ja'] ?></td>
				<td><?= $this->Common->getActionEditDelete($params['controller'], $d['id']) ?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
</div>