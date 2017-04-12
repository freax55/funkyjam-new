<h2>お問合わせ</h2>
	<?= $this->Form->create('Magazine', array('novalidate' => true,'type' => 'index', 'action' => 'index', 'url' => '/contact/')) ?>
	<table>
		<tbody>
			<tr>
				<th>お名前</th>
				<td>
				<?php
				print $this->Form->input('name', array(
					'type' => 'hidden',
					'value' => $data['Magazine']['name'],
				));
				print $data['Magazine']['name'];
				?>
				</td>
			</tr>
			<tr>
				<th>メールアドレス</th>
				<td>
				<?php
				print $this->Form->input('mail', array(
					'type' => 'hidden',
					'value' => $data['Magazine']['mail'],
				));
				print $data['Magazine']['mail'];
				print $this->Form->input('mail2', array(
					'type' => 'hidden',
					'value' => $data['Magazine']['mail2'],
				));				
				?>
				</td>
			</tr>
			<tr>
				<th>男女</th>
				<td>
				<?php
				print $this->Form->input('sex', array(
					'type' => 'hidden',
					'value' => $data['Magazine']['sex'],
				));
				print ($data['Magazine']['sex'] != '')?$select_sex[$data['Magazine']['sex']]:'';
				?>
				</td>
			</tr>
			<tr>
				<th>年齢</th>
				<td>
				<?php
				print $this->Form->input('age', array(
					'type' => 'hidden',
					'value' => $data['Magazine']['age'],
				));
				print $data['Magazine']['age'];
				?>
				</td>
			</tr>
			<tr>
				<th>職業</th>
				<td>
				<?php
				print $this->Form->input('job', array(
					'type' => 'hidden',
					'value' => $data['Magazine']['job'],
				));
				print $data['Magazine']['job'];
				?>
				</td>
			</tr>
			<tr>
				<th>お問合わせ種別</th>
				<td>
				<?php
				print $this->Form->input('type', array(
					'type' => 'hidden',
					'value' => $data['Magazine']['type'],
				));
				print $type_contact[$data['Magazine']['type']];
				?>
				</td>
			</tr>
			<tr>
				<th>お問合わせ内容</th>
				<td>
				<?php
				print $this->Form->input('content', array(
					'type' => 'hidden',
					'value' => $data['Magazine']['content'],
				));
				print $data['Magazine']['content'];
				?>
				</td>
			</tr>
			<tr>
				<th>メールマガジン</th>
				<td>
				<?php
				print $this->Form->input('magazine', array(
					'type' => 'hidden',
					'value' => $data['Magazine']['magazine'],
				));
				print 'メルマガを購読' . $wish_magazine[$data['Magazine']['magazine']];
				?>
				</td>
			</tr>
			<tr>
		</tbody>
	</table>
	<?php
	print $this->Form->submit('上記の内容で送信する', [
		'name' => 'complete'
	]);
	print $this->Form->submit('戻る', [
		'name' => 'edit'
	]);	
	?>
	<?= $this->Form->end() ?>
