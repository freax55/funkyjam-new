<?php
$d = $data['Subscription'];
?>
<div class="box">
	<h2><?= $pages_admin[$params['controller']]['title'] ?></h2>
	<?php
	$buttons = array(
		'view' => array(
			'href' => '/admin/' .$params['controller']. '/'
		),
	);
	print $this->common->getContentHeader("", $buttons);
	?>

	<table class="table table-striped table-bordered">
		<tr>
			<th style="width:160px">貴店名</th>
			<td>
				<dl class="dl-horizontal">
					<dt>正式名称</dt>
					<dd><?= $d['name'] ?>&nbsp;様</dd>
					<dt>ふりがな</dt>
					<dd><?= $d['name_kana'] ?>&nbsp;様</dd>
				</dl>
			</td>
		</tr>
		<tr>
			<th>業種</th>
			<td>
				<?= $jobs[$d['job_id']] ?>
			</td>
		</tr>
		<tr>
			<th>出発地</th>
			<td>
				<?= (isset($d['pref_id'])) ? $prefs[$d['pref_id']] : "" ?>
				<?= (isset($d['city'])) ? $d['city'] : "" ?>
			</td>
		</tr>
		<tr>
			<th>ご連絡先</th>
			<td>
				<dl class="dl-horizontal">
					<dt>ご担当者</dt>
					<dd><?= $d['admin_name'] ?>&nbsp;様</dd>
					<dt>電話番号</dt>
					<dd><?= $d['admin_tel'] ?></dd>
					<dt>メール</dt>
					<dd><?= $d['admin_email'] ?></dd>
				</dl>
			</td>
		</tr>
		<tr>
			<th>管理画面パスワード</th>
			<td><?= $d['admin_password'] ?></td>
		</tr>
		<tr>
			<th>URL</th>
			<td>
				<dl class="dl-horizontal">
					<dt>PC版</dt>
					<dd><?= $d['url'] ?></dd>
					<dt>携帯版</dt>
					<dd><?= $d['url_mb'] ?></dd>
					<dt>スマホ版</dt>
					<dd><?= $d['url_sp'] ?></dd>
				</dl>
			</td>
		</tr>
		<tr>
			<th>イクリスト割引</th>
			<td colspan="3">
				<?= nl2br($d['discount']) ?>
				<br>
				<?php
				if ($d['discount_weather'] == 'y') {
					print '雨の日割引あり';
				} else {
					print '雨の日割引なし';
				}
				?>
			</td>
		</tr>
		<tr>
			<th>備考</th>
			<td colspan="3"><?= nl2br($d['comment']) ?></td>
		</tr>
	</table>
</div>
