
<!-- Header -->
<header class="text-center" name="home">
    <img class="other-banner" src="/img/company-header-bg.jpg" alt="Funkyjam">
</header>

<div id="breadcrumb">
	<div class="container">
        <div class="row">
    		<div class="col-md-8 col-md-offset-2 leftzero">
    		<?= $this->BreadCrumb->show($path) ?>
    		</div>
        </div>
	</div>
</div>


<div id="company-page-section">
    <div class="container">
        <div class="row"> 
            <div class="col-md-8 col-md-offset-2">

			<h1 class="artist-title2">お問合わせ</h1>
				<?= $this->Form->create('Magazine', array('type' => 'post')) ?>
				<table width=100% frame="box">
					<tbody>
						<tr>
							<td class="wd137">お名前</td>
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
							<td>メールアドレス</td>
							<td>
							<?= $this->Form->error("Magazine.mail") ?>
							<?php
							print $this->Form->input('mail', array(
								'error' => false,
								'label' => false,
								'class' => '',
								'div' =>'',
								'type' => 'text',
								'value' => isset($data['Magazine']['mail'])? $data['Magazine']['mail']:null,
							));
							?>
							半角英数字でご記入ください。
							</td>
						</tr>
						<tr>
							<td>メールアドレス再確認</td>
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
							<td>男女</td>
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
							<td>年齢</td>
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
							<td>職業</td>
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
							<td>お問合わせ種別</td>
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
							<td>お問合わせ内容</td>
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
							<td>メールマガジン</td>
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
					</tbody>
				</table>
				<?= $this->Form->button('内容を確認する', array('type' => 'submit')); ?>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>




