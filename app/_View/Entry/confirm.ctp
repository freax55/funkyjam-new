<?php
$d = $data['Entry'];
?>
<div class="container">
	<h1><?= $pages['entry']['title'] ?> 確認画面</h1>
	<p>下記の項目でお間違いなければ「送信する」ボタンをクリックしてください。</p>
</div>

<div class="container box mt15">
	<?= $this->Form->create('Entry', array('novalidate' => true, 'name'=>'myForm', 'action'=>'post', 'url'=>'/entry/post/')) ?>
	<?php
	print $this->Form->input('send', array(
		'type' => 'hidden',
		'value' => true
	));
	?>
	<table class="table table-striped">
		<tr>
			<th style="width:200px">貴店名</th>
			<td><?= $d['name'] ?>&nbsp;様</td>
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
					<dt>スマホ版</dt>
					<dd><?= $d['url_sp'] ?></dd>
				</dl>
			</td>
		</tr>
		<tr>
			<th>デリヘルOK割引</th>
			<td colspan="3">
				<?= nl2br($d['discount']) ?>
			</td>
		</tr>
		<tr>
			<th>備考</th>
			<td colspan="3"><?= nl2br($d['comment']) ?></td>
		</tr>
	</table>
	<?php
	// hidden 生成
	foreach ($d as $k => $v) {
		if (!is_array($v)) {
			print $this->Form->input($k, array(
				'type' => 'hidden',
				'value' => $v
			))."\n";
		}
	}
	?>
	<div class="form-actions tac">
		<a href="javascript:history.back();" class="btn btn-link"><i class="icon icon-chevron-left"></i>&nbsp;入力画面へ戻る</a>
		<button type="submit" class="btn btn-lg btn-primary">送信する&nbsp;<i class="fa fa-envelope"></i></button>
	</div>
	<?= $this->Form->end() ?>
</div>