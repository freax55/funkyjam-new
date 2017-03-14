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
		<?= $this->Form->create('User', array("action"=>"search", 'url'=>'/admin/' .$params['controller']. '/search/', "type"=>"get", 'style'=>'float: left; margin-bottom: 0;')); ?>
		<div class="col-md-6">
			<div class="input-group">
				<?= $this->Form->input('q', array(
					'type' => 'text',
					'label' => false,
					'div' => false,
					'class' => 'form-control user_q',
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
			<th>権限</th>
			<th>ユーザ名</th>
			<th>メールアドレス(PC)</th>
			<th class="action">操作</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$a = array();
		$cnt = count($data);
		for ($i=0; $i<$cnt; $i++) {
			$d = $data[$i]['User'];
			$p = "";
			$p.= "<tr>\n";
			$p.= "<td>" .@$roles[$d['role_id']]."</td>";
			$p.= "<td>" .$d['name']. "</td>";
			$p.= "<td>" .$d['mail']. "</td>";
			$p.= "<td>" .$this->Common->getActionEditDelete($params['controller'], $d['id']). "</td>\n";
			$p.= "</tr>";

			if ($d['role_id'] == 1) {
				$a['super'][] = $p;
			} else {
				$a['other'][] = $p;
			}
		}
		if ($auth_user['User']['role_id'] != 1) {
			unset($a['super']);
		}
		foreach ($a as $k => $v) {
			for ($i=0; $i<count($v); $i++) {
				print $v[$i];
			}
		}
		?>
		</tbody>
	</table>
	<?= View::element('pagination') ?>
</div>
