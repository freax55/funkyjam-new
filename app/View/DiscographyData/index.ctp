<div class="box" style="margin: 10px;">
	<h2 style="margin-bottom:15px;">ディスコグラフィー管理 (<?= $artist ?>/<?= $type ?>)</h2>
	<div>
		<div style="margin-bottom:15px;">
		<a href="/discography_data/add/<?= $artist ?>/<?= $type ?>/" class="btn btn-sm btn-primary">新規登録</a>
		</div>
	</div>

	<table class="table table-striped table-bordered table-condensed">
		<thead>
		<tr>
			<th style="width:58px">ID</th>
			<th style="width:200px">タイトル</th>
			<th style="width:58px">状態</th>
			<th style="width:200px">操作</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach($data as $v){
		?>
		<tr>
			<td><?= $v['Discography']['discography_id'] ?></td>
			<td><?= $v['Discography']['title'] ?></td>
			<th><?= ($v['Discography']['publish'] == 'y')?'公開':'非公開' ?></th>
			<td><a href="/discography_data/edit/<?= $v['Discography']['artist'] ?>/<?= $v['Discography']['type'] ?>/<?= $v['Discography']['discography_id'] ?>/" class="btn btn-sm btn-primary">編集</a></td>
		</tr>
		<?php
		}
		?>
		</tbody>
	</table>
	<?php
	// }
	?>
</div>