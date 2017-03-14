<?php
$d = $data['Inquiry'];
?>
<div class="container">
	<h1 class="ttl ttl-bb2"><?= $pages['inquiry']['title'] ?> 確認画面</h1>
	<p class="p15">下記の項目でお間違いなければ「送信する」ボタンをクリックしてください。</p>
</div>

<div class="container mb50">
	<?= $this->Form->create('Inquiry', array('novalidate' => true, 'name'=>'myForm', 'action'=>'post', 'url'=>'/inquiry/post/')) ?>
	<?php
	print $this->Form->input('send', array(
		'type' => 'hidden',
		'value' => true
	));
	?>
	<table class="table table-th-gray table-brdr mb30">
		<tr>
			<th style="width:200px">ご連絡先</th>
			<td>
				<div class="mb5">お名前:<span class="b"><?= $d['name'] ?></span>&nbsp;様</div>
				<div>E-mail:<span class="b"><?= $d['email'] ?></span></div>
			</td>
		</tr>
		<tr>
			<th>お問い合わせ内容</th>
			<td>
				<div class="mb5">タイトル:<span class="b"><?= $d['title'] ?></span></div>
				<div>本文:<span class="b"><?= nl2br($d['comment']) ?></span></div>
			</td>
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
	<div class="tac">
		<a href="javascript:history.back();">入力画面へ戻る</a>
		<button type="submit" class="btn btn-large btn-blue ml10"><span class="i-envelope"></span>&nbsp;送信する</button>
	</div>
	<?= $this->Form->end() ?>
</div>