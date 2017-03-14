<div class="container cf">
	<h1 class="ttl ttl-bb2"><?= $pages['inquiry']['title'] ?></h1>
	<p class="p15">下記の項目を入力して「ご入力情報を確認する」ボタンをクリックしてください。</p>
</div>

<div class="container mb50">
	<?= $this->Form->create('Inquiry', array('novalidate' => true, 'name'=>'myForm', 'action'=>'post', 'url'=>'/inquiry/post/', 'onsubmit'=>'return jump2Inquiry()')) ?>
	<table class="table table-th-gray table-brdr mb30">
		<tr>
			<th style="width:200px"><?= $this->common->getMust() ?>&nbsp;ご連絡先</th>
			<td>
				<div class="cf">
					<div class="col span-6 mb10-sp">
						<div class="input-group">
							<span class="input-group-addon">お名前</span>
							<?= $this->Form->input('name', array(
								'type' => 'text',
								'label' => false,
								'div' => false,
								'error' => false,
								'class' => 'form-control',
								'placeholder' => 'スズキ'
							));
							?>
							<span class="input-group-addon">様</span>
						</div>
						<?= $this->Form->error("Inquiry.name") ?>
					</div>
					<div class="col span-6">
						<div class="input-group">
							<span class="input-group-addon">E-mail</span>
							<?= $this->Form->input('email', array(
								'type' => 'text',
								'label' => false,
								'div' => false,
								'error' => false,
								'class' => 'form-control',
								'placeholder' => 'info@kclub-rank.com'
							));
							?>
						</div>
						<?= $this->Form->error("Inquiry.email") ?>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<th><?= $this->common->getMust() ?>&nbsp;タイトル</th>
			<td>
				<?php
				print $this->Form->input('title', array(
					'label' => false,
					'type' => 'text',
					'value' => $data['Inquiry']['title'],
					'class' => 'form-control',
				));
				?>
			</td>
		</tr>
		<tr>
			<th><?= $this->common->getMust() ?>&nbsp;お問い合わせ内容</th>
			<td>
				<?php
				print $this->Form->input('comment', array(
					'label' => false,
					'type' => 'textarea',
					'value' => $data['Inquiry']['comment'],
					'class' => 'form-control',
					'rows' => 15,
				));
				?>
			</td>
		</tr>
	</table>
	<div class="form-actions tac">
		<button type="submit" class="btn btn-large btn-blue"><span class="i-check-square-o"></span>&nbsp;ご入力情報を確認する</button>
	</div>
	<?= $this->Form->end() ?>
</div>