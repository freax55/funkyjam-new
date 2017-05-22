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
				<?= $this->Form->create('Magazine', array('novalidate' => true,'type' => 'post', 'action' => 'confirm', 'url' => '/contact/confirm/')) ?>
				<table width=100% frame="box">
					<tbody>
						<tr>
							<td class="wd137">お名前</td>
							<td>
							<?= $this->Form->error("Magazine.name") ?>
							<?php
							print $this->Form->input('name', array(
								'required' => false,
								'error' => false,
								'label' => false,
								'style' => 'width: 224px;',
								'type' => 'text',
								'value' => isset($data['Magazine']['name'])? $data['Magazine']['name']:null,
							));
							?>
							<div class="contact-txt">記入例：久保田利伸</div>
							</td>
						</tr>
						<tr>
							<td>メールアドレス</td>
							<td>
							<?= $this->Form->error("Magazine.mail") ?>
							<?php
							print $this->Form->input('mail', array(
								'required' => false,
								'error' => false,
								'label' => false,
								'style' => 'width: 224px;',
								'type' => 'text',
								'value' => isset($data['Magazine']['mail'])? $data['Magazine']['mail']:null,
							));
							?>
							<div class="contact-txt">半角英数字でご記入ください。</div>
							</td>
						</tr>
						<tr>
							<td>メールアドレス再確認</td>
							<td>
							<?= $this->Form->error("Magazine.mail2") ?>
							<?php
							print $this->Form->input('mail2', array(
								'required' => false,
								'error' => false,
								'type' => 'text',
								'label' => false,
								'style' => 'width: 224px;',
								'value' => isset($data['Magazine']['mail2'])? $data['Magazine']['mail2']:null,
							));
							?>
							<div class="contact-txt">確認のため再度ご記入ください。半角英数字でご記入ください。</div>
							</td>
						</tr>
						<tr>
							<td>男女</td>
							<td>
							<?php
							print $this->Form->input('sex', array(
								'required' => false,
								'legend' => false,
								'type' => 'radio',
								'options' => $select_sex
							));
							?>
							</td>
						</tr>
						<tr>
							<td>年齢</td>
							<td>
							<?php
							print $this->Form->input('age', array(
								'required' => false,
								'type' => 'text',
								'label' => false,
								'after' => ' 歳',
								'value' => isset($data['Magazine']['age'])? $data['Magazine']['age']:null,
								'style' => 'width: 54px;',
							));
							?>
							<div class="contact-txt">半角数字でご記入ください。</div>
							</td>
						</tr>
						<tr>
							<td>職業</td>
							<td>
							<?php
							print $this->Form->input('job', array(
								'required' => false,
								'error' => false,
								'label' => false,
								'type' => 'text',
								'value' => isset($data['Magazine']['job'])? $data['Magazine']['job']:null,
								'style' => 'width: 224px;',
								'type' => 'text',
							));
							?>
							</td>
						</tr>
						<tr>
							<td>お問合わせ種別</td>
							<td>
							<?= $this->Form->error("Magazine.type") ?>
							<?php
							$type_contact[0] = "下記からお選びください";
							ksort($type_contact);
							$selected = isset($data['Magazine']['type']) ? $data['Magazine']['type'] : 0;
							print $this->Form->input('type', array(
								'required' => false,
								'label' => false,
								'type' => 'select',
								'options' => $type_contact,
								'selected' => $selected,
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
								'required' => false,
								'label' => false,
								'error' => false,
								'type' => 'textarea',
								'value' => isset($data['Magazine']['content'])? $data['Magazine']['content']:null,
								'style' => 'width: 100%;',
								'type' => 'textarea',
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
							<div class="contact-txt">ファンキー・ジャム所属アーティストの最新情報をお届けします。<br>不要な方はチェックをはずして下さい。</div>
							</td>
						</tr>
					</tbody>
				</table>
				<?= $this->Form->button('内容を確認する', array(
				'type' => 'submit',
				'class' => 'btn-fix',
				)); ?>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>
