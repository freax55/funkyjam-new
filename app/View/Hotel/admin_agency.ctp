<?php
$auth_user = $this->Session->read('User');
?>
<?= View::element('part_agency_header') ?>
<div class="box">
	<h2><?= $pages_admin[$params['controller']]['title'] ?></h2>
	<?php
	$buttons = array(
		'view' => array(
			'href' => '/admin/' .$params['controller']. '/'
		),
	);
	?>
	<div class="row mb10">
		<div class="col-md-6">
			<div>

			</div>
			<div>

			</div>
		</div>
		<div class="col-md-6"><?= $this->common->getButtons($buttons) ?></div>
	</div>

	<?= $this->Form->create($controller_camel_case, array('novalidate' => true, 'name'=>'myForm', 'action'=>'post', 'url'=>'/admin/' .$params['controller']. '/post/', 'type' => 'file')) ?>
	<?php
	print $this->Form->input('id', array(
		'type' => 'hidden',
		'value' => $data[$controller_camel_case]['id']
	));
	print $this->Form->input('isAgency', array(
		'type' => 'hidden',
		'value' => 1
	));
	?>

	<table class="table table-striped table-bordered">
		<tr>
			<th>ホテル名</th>
			<td><a href="/hotel/detail/<?= $data[$controller_camel_case]['id'] ?>/" target="_blank"><?= $data[$controller_camel_case]['name'] ?></a></td>
		</tr>
		<tr>
			<th>ピックアップガール</th>
			<td>
				<ul>
				<?php
				// pr($cg_girls);
				foreach ($cg_girls as $v) {
					$g = $v['Girl'];
					$s = $v['Shop'];
					print '<li class="cf">';
					print '<div class="col span-2">';
					print $this->Form->input('pickup_girl_ids][', array(
						'label' => false,
						'value' => $g['id'],
						'class' => 'form-control',
						'div' => false
					));
					print '</div>';
					print '<div class="col span-10" style="padding:7px 0;">';
					print $g['name'] . '@' . $s['name'];
					print '</div>';
					print '</li>';
				}
				?>
				</ul>
			</td>
		</tr>
	</table>

	<?php
	// hidden 生成
	foreach ($data[$controller_camel_case] as $k => $v) {
		if (!is_array($v)) {
			print $this->Form->input($k, array(
				'type' => 'hidden',
				'value' => $v
			))."\n";
		}
	}
	?>
	<div class="form-actions tac">
		<button class="btn btn-lg btn-primary" type="submit" onclick="allSelected()"><i class="icon icon-ok"></i>&nbsp;登録する</button>
	</div>
	<?= $this->Form->end() ?>
</div>
