<?php
// $auth_user = $this->Session->read('User');
// $case = 0;
?>
<div class="box" style="margin: 10px;">
	<h2>ディスコグラフィー管理 (<?= $artist ?>/<?= $type ?>)</h2>
	<div style="margin-bottom:10px;">
		<div>
		<?php
			// $buttons = array(
			// 	'add' => array(
			// 		'href' => $params['controller']. '/add/' . 'id' . '/'
			// 	)
			// );
			// print $this->common->getButtons($buttons);
		?>
		</div>
	</div>

	<?php
	// if (count($data_girl) != 0) {
	?>
	<table class="table table-striped table-bordered table-condensed">
		<thead>
		<tr>
			<th style="width:58px">ID</th>
			<th style="width:200px">タイトル</th>
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
			<td><a href="/discography_data/edit/<?= $v['Discography']['artist'] ?>/<?= $v['Discography']['type'] ?>/<?= $v['Discography']['discography_id'] ?>/" class="btn btn-sm btn-primary"><i class="icon icon-edit"></i>&nbsp;編集</a></td>
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