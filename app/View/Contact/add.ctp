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


			<h2>お問合わせ</h2>
				<?= $this->Form->create('Magazine', array('novalidate' => true,'type' => 'index', 'action' => 'index', 'url' => '/contact/')) ?>
				<table width=100%>
					<tbody>
						<tr>
							<td class="wd137">お名前</td>
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
							<td>メールアドレス</td>
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
							<td>男女</td>
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
							<td>年齢</td>
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
							<td>職業</td>
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
							<td>お問合わせ種別</td>
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
							<td>お問合わせ内容</td>
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
							<td>メールマガジン</td>
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
					</tbody>
				</table>
				<div style="display:inline-flex">

				<?php
				print $this->Form->submit('送信する', [
					'class' => 'btn-fix',
					'name' => 'complete'
				]);
				print $this->Form->submit('戻る', [
					'class' => 'btn-fix2',
					'name' => 'edit'
				]);	
				?>
				<?= $this->Form->end() ?>
				</div>
			</div>
		</div>
	</div>
</div>