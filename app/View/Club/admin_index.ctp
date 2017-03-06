<?php
if (!empty($data_notice)) {
?>
<div class="box">
	<h2>お知らせ</h2>
	<ul style="margin-top: -20px; margin-bottom: 20px">
	<?php
	foreach ($data_notice as $v) {
		$v = $v['Notice'];
		print '<li>';
		print '<span class="label label-warning">' . $this->common->date4mat($v['created'], 'Y/m/d') . '</span> <a href="javascript:toggle(\'#notice_' . $v['id'] . '\');">' . $v['title'] . '</a>';
		print '<div class="well" id="notice_' . $v['id'] . '" style="display:none">' . nl2br($v['content']) . '</div>';
		print '</li>';
	}
	?>
	</ul>
</div>
<?php
}

$auth_user = $this->Session->read('User');
if ($auth_user['Role']['id'] <= 3) {
?>
<?php
if($auth_user['Role']['id'] <= 2){
echo 
'<div class="box">
	<h2>要修正データ検索方法</h2>
	<p>*tel*</p>
	<p>*url*</p>
	<p>*url_sp*</p>
	<p>*address*</p>
	<p>*mail*</p>
	<p>等で検索すると修正が必要な店舗がピックアップされます。</p>	
</div>';
}

?>

<div class="box">
	<h2 style="overflow:hidden">
		<div style="float:left"><?= $pages_admin[$params['controller']]['title']; ?></div>
		<div style="float:right"><span style="color:#c44123"><?= number_format($cnt_total) ?> 件</span></div>
	</h2>
	<?= $this->Form->create('Shop', array("action"=>"search", 'url'=>'/admin/club/search/', "type"=>"get")) ?>
	<table class="table table-bordered table-hover">
		<tr>
			<th style="width:65%">フリーワード</th>
			<th style="width:35%">都道府県</th>
		</tr>
		<tr>
			<td>
				<?= $this->Form->input('q', array(
					'type' => 'text',
					'label' => false,
					'div' => false,
					'placeholder' => 'ID、店名、URL、電話番号、キャッチコピー、紹介文、管理者コメント・メアドから',
					'class' => 'form-control',
					'style' => 'width:100% !important',
					'value' => (isset($query['q'])) ? $query['q'] : ''
				)) ?>
			</td>
			<td>
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
			</td>
		</tr>
	</table>
	<table class="table table-bordered">
		<tr>
			<th>掲載開始日</th>
			<th style="width:25%">公開</th>
			<th style="width:25%">掲載プラン</th>
		</tr>
		<tr>
			<td>
				<div class="input-group">
					<span class="input-group-addon"><i class="icon icon-calendar"></i></span>
					<?= $this->Form->input('start_date1', array(
						'label' => false,
						'type' => 'text',
						'div' => false,
						'class' => 'dtp form-control',
						'style' => 'min-width:110px;',
						'data-date-format' => 'yyyy-mm-dd',
						'readonly' => true,
						'value' => (isset($query['start_date1'])) ? $query['start_date1'] : ''
					));
					?>
					<span class="input-group-addon">〜</span>
					<span class="input-group-addon"><i class="icon icon-calendar"></i></span>
					<?= $this->Form->input('start_date2', array(
						'label' => false,
						'type' => 'text',
						'div' => false,
						'class' => 'dtp form-control',
						'style' => 'min-width:110px;',
						'data-date-format' => 'yyyy-mm-dd',
						'readonly' => true,
						'value' => (isset($query['start_date2'])) ? $query['start_date2'] : ''
					));
					?>
				</div>
			</td>
			<td>
				<?= $this->Form->input('status', array(
					'label' => false,
					'div' => false,
					'type' => 'select',
					'class' => 'form-control',
					'selected' => isset($query['status']) ? $query['status'] : 100,
					'options' => array('y' => '公開', 'n' => '非公開', 100=>'両方')
				));
				?>
			</td>
			<td>
				<?= $this->Form->input('plan_id', array(
					'label' => false,
					'div' => false,
					'type' => 'select',
					'class' => 'form-control',
					'selected' => isset($query['plan_id']) ? $query['plan_id'] : 100,
					'options' => array(0=>'無料', 1=>'Bプラン', 2=>'Aプラン', 3=>'Sプラン', 99=>'有料プラン', 100=>'すべて')
				));
				?>
			</td>
		</tr>
	</table>
	<div class="form-actions tac">
		<button type="submit" class="btn btn-primary"><i class="icon icon-filter"></i>&nbsp;集計</button>
	</div>
	<?= $this->Form->end() ?>
</div>
<?php
}
if ($cnt_total != 0) {
?>
<div class="box">
	<table class="table table-striped table-bordered table-hover">
		<thead>
		<tr>
			<th style="width:49px">ID</th>
			<th style="width:62px">公開</th>
			<th style="width:45px">掲載</th>
			<th style="width:73px">都道府県</th>
			<th>店舗名</th>
			<th style="width:259px">掲載情報の更新</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$controller_camel_case = Inflector::camelize($params['controller']);
		foreach ($data as $k => $v) {
			$d = $v[$controller_camel_case];
			$plan = '';
			if ($d['plan_id'] == 3) {
				$plan = '<span class="label label-red">S</span>&nbsp;';
			} else if ($d['plan_id'] == 2) {
				$plan = '<span class="label label-red">A</span>&nbsp;';
			} else if ($d['plan_id'] == 1) {
				$plan = '<span class="label label-warning">B</span>&nbsp;';
			} else {
				$plan = '<span class="label label-default">無料</span>&nbsp;';
			}
			?>
			<tr>
				<td style="text-align:center"><?= $d['id'] ?></td>
				<td style="text-align:center"><?= ($d['status'] == 'y') ? '<span class="label label-primary">公開</span>' : '<span class="label label-default">非公開</span>' ?></td>
				<td style="text-align:center"><?= $plan ?></td>
				<td style="text-align:center"><?= ($d['pref_id'] != 0) ? $prefs[$d['pref_id']] : '未設定' ?></td>
				<td><a href="/club/<?= $d['id'] ?>/" target="_blank"><?= $this->common->strCut($d['name'], 60) ?></td>
				<td>
					<div class="action-edit-delete">
						<?php
							if(isset($this->params->query['q']) && strpos($this->params->query['q'], '*') !== false) {
								$search_ad_c = '#admin_comment';
							} else {
								$search_ad_c = '/';
							}
						?>
						<a href="/admin/club/basic/<?= $d['id'] . $search_ad_c ?>"  class="btn btn-primary dropdown-toggle"><i class="icon icon-cog"></i>&nbsp;店舗情報</a>
						<?php
						if ($auth_user['Role']['id'] <= 2) {
						?>
						<a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="javascript:deleteRecord('/admin/club/delete/<?= $d['id'] ?>/');"><i class="icon icon-remove"></i>&nbsp;削除</a>
						<?php
						}
						?>
					</div>
				</td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
	<?php
	if ($auth_user['Role']['id'] <= 3) {
	?>
	<?= View::element('pagination') ?>
	<?php
	}
	?>
</div>
<?php
} else {
	print '<div class="alert alert_error"><h4>該当するデータが見つかりませんでした。</h4><p>条件を変えて再度お試しください。</p></div>';
}
?>