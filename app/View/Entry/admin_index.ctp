<div class="box">
	<h2><?= $pages_admin[$params['controller']]['title'] ?></h2>
	<table class="table table-striped table-bordered">
		<thead>
		<tr>
			<th>受付日</th>
			<th>都道府県</th>
			<th>市区町村</th>
			<th>店舗名</th>
			<th>メールアドレス</th>
			<th>パスワード</th>
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
				<td><?= $this->common->date4mat($d['created'], 'Y/m/d') ?></td>
				<td><?= $d['pref'] ?></td>
				<td><?= $d['city'] ?></td>
				<td><?= $d['name'] ?></td>
				<td><?= $d['admin_email'] ?></td>
				<td><?= $d['admin_password'] ?></td>
				<td><?= $this->common->getActionViewDelete($params['controller'], $d['id']) ?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
</div>