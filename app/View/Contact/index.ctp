<h2>お問合わせ</h2>
	<?= $this->Form->create('Magazine', array('type' => 'post')) ?>
	<table>
		<tbody>
			<tr>
				<th>お名前</th>
				<td>
				<?= $this->Form->error("Magazine.name") ?>
				<?php
				print $this->Form->input('name', array(
					'error' => false,
					'label' => false,
					'type' => 'text',
					'value' => isset($data['Magazine']['name'])? $data['Magazine']['name']:null,
				));
				?>
				記入例：久保田利伸
				</td>
			</tr>
			<tr>
				<th>メールアドレス</th>
				<td>
				<?= $this->Form->error("Magazine.mail") ?>
				<?php
				print $this->Form->input('mail', array(
					'error' => false,
					'label' => false,
					'type' => 'text',
					'value' => isset($data['Magazine']['mail'])? $data['Magazine']['mail']:null,
				));
				?>
				半角英数字でご記入ください。
				</td>
			</tr>
			<tr>
				<th>メールアドレス再確認</th>
				<td>
				<?= $this->Form->error("Magazine.mail2") ?>
				<?php
				print $this->Form->input('mail2', array(
					'error' => false,
					'type' => 'text',
					'label' => false,
					'value' => isset($data['Magazine']['mail2'])? $data['Magazine']['mail2']:null,
				));
				?>
				確認のため再度ご記入ください。半角英数字でご記入ください。
				</td>
			</tr>
			<tr>
				<th>男女</th>
				<td>
				<?php
				print $this->Form->input('sex', array(
					// 'label' => false,
					'legend' => false,
					'type' => 'radio',
					'options' => [
						'女性',
						'男性'
					],
				));
				?>
				</td>
			</tr>
			<tr>
				<th>年齢</th>
				<td>
				<?php
				print $this->Form->input('age', array(
					'type' => 'text',
					'label' => false,
					'after' => '歳',
					'options' => [
						'女性',
						'男性'
					],
					'value' => isset($data['Magazine']['age'])? $data['Magazine']['age']:null,
				));
				?>
				半角数字でご記入ください。
				</td>
			</tr>
			<tr>
				<th>職業</th>
				<td>
				<?php
				print $this->Form->input('job', array(
					'error' => false,
					'label' => false,
					'type' => 'text',
					'value' => isset($data['Magazine']['job'])? $data['Magazine']['job']:null,
				));
				?>
				</td>
			</tr>
			<tr>
				<th>お問合わせ種別</th>
				<td>
				<?= $this->Form->error("Magazine.type") ?>
				<?php
				print $this->Form->input('type', array(
						'label' => false,
						'type' => 'select',
						'selected' => isset($data['Magazine']['type']) ? $data['Magazine']['type'] : 0,
						'options' => array(0 => "下記からお選びください",  "" => $type_contact),
						'div' => false,
						'error' => false,
					));
				?>
				</td>
			</tr>
			<tr>
				<th>お問合わせ内容</th>
				<td>
				<?= $this->Form->error("Magazine.content") ?>
				<?php
				print $this->Form->input('content', array(
					'label' => false,
					'error' => false,
					'type' => 'textarea',
					'value' => isset($data['Magazine']['content'])? $data['Magazine']['content']:null,
				));
				?>
				</td>
			</tr>
			<tr>
				<th>メールマガジン</th>
				<td>
				<?php
				print $this->Form->input('magazine', array(
					'error' => false,
					'type' => 'checkbox',
					'label' => '&nbsp;メルマガを購読する',
					'value' => isset($data['Magazine']['magazine'])? $data['Magazine']['magazine']:'1',
				));
				?>
				ファンキー・ジャム所属アーティストの最新情報をお届けします。<br>不要な方はチェックをはずして下さい。</p>
				</td>
			</tr>
			<tr>
		</tbody>
	</table>
	<?= $this->Form->button('内容を確認する', array('type' => 'submit')); ?>
	<?= $this->Form->end() ?>
