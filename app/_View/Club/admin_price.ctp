<?php
$auth_user = $this->Session->read('User');
$disabled_text = '<span style="color:#999">[変更不可]</span> <a href="javascript:void(0);" class="tt" title="変更するには、担当営業マンにお問い合わせください。">変更するには？</a>';
?>
<div class="box">
	<h2><?= $pages_admin[$params['controller']]['title'] ?> -料金と基本プレイ</h2>
	<h3><?= $data['Shop']['name'] ?></h3>
	<?php
	$buttons = array(
		'view' => array(
			'href' => '/admin/' .$params['controller']. '/'
		),
	);
	if ($data[$controller_camel_case]['id'] != "") {
		$view_shop_detail = '<div class="pull-left"><a href="/shop/detail/' . $data[$controller_camel_case]['id'] . '/" class="btn btn-success" target="_blank">掲載ページを確認</a></div>';
	} else {
		$view_shop_detail = "";
	}
	print $this->common->getContentHeader($view_shop_detail, $buttons);
	?>
	<?= $this->Form->create($controller_camel_case, array('novalidate' => true, 'name'=>'myForm', 'action'=>'price', 'url'=>'/admin/' .$params['controller']. '/price/' . $data[$controller_camel_case]['id'] . '/', 'type' => 'file')) ?>
	<?php
	print $this->Form->input('id', array(
		'type' => 'hidden',
		'value' => $data[$controller_camel_case]['id']
	));
	print $this->Form->input('name', array(
		'type' => 'hidden',
		'value' => $data[$controller_camel_case]['name']
	));
	print $this->Form->input('total_min', array(
		'type' => 'hidden',
		'value' => $data[$controller_camel_case]['total_min']
	));
	?>
	<table class="table table-bordered">
		<tr>
			<th colspan="4" class="sep_row">料金情報</th>
		</tr>
		<tr>
			<th style="width:160px">各種料金</th>
			<td colspan="3">
				<div class="row">
					<div class="col-xs-3">
						<div class="input-group">
							<span class="input-group-addon">最低料金</span>
							<?= $this->Form->input('price_min', array(
								'label' => false,
								'div' => false,
								'type' => 'text',
								'error' => false,
								'value' => $data['Shop']['price_min'],
								'class' => 'form-control tar'
							));
							?>
							<span class="input-group-addon">円</span>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="input-group">
							<span class="input-group-addon">入会金</span><?php
							print $this->Form->input('fee_admission', array(
								'type' => 'text',
								'label' => false,
								'value' => $data[$controller_camel_case]['fee_admission'],
								'class' => 'form-control tar',
								'error' => false,
								'div' => false,
								'maxLength' => 5,
							));
							?><span class="input-group-addon">円</span>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="input-group">
							<span class="input-group-addon">指名料</span><?php
							print $this->Form->input('fee_nomination', array(
								'type' => 'text',
								'label' => false,
								'value' => $data[$controller_camel_case]['fee_nomination'],
								'class' => 'form-control tar',
								'error' => false,
								'div' => false,
								'maxLength' => 5,
							));
							?><span class="input-group-addon">円</span>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="input-group">
							<span class="input-group-addon">交通費</span>
							<?= $this->Form->input('fee_delivery_min', array(
								'label' => false,
								'div' => false,
								'type' => 'text',
								'error' => false,
								'value' => $data['Shop']['fee_delivery_min'],
								'class' => 'form-control tar',
							));
							?>
							<span class="input-group-addon">円〜</span>
						</div>
					</div>
				</div>
				<?= $this->Form->error("Shop.price_min") ?>
				<div class="row mt10">
					<div class="col-xs-4">
						<div class="input-group">
							<span class="input-group-addon">延長</span>
							<?= $this->Form->input('fee_extension_min', array(
								'type' => 'text',
								'label' => false,
								'value' => $data[$controller_camel_case]['fee_extension_min'],
								'class' => 'form-control tar',
								'error' => false,
								'div' => false,
								// 'maxLength' => 3,
							));
							?><span class="input-group-addon">分</span>
							<?= $this->Form->input('fee_extension', array(
								'type' => 'text',
								'label' => false,
								'value' => $data[$controller_camel_case]['fee_extension'],
								'class' => 'form-control tar',
								'error' => false,
								'div' => false,
								'maxLength' => 5,
							));
							?><span class="input-group-addon">円</span>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="input-group">
							<span class="input-group-addon">チェンジ</span>
							<?= $this->Form->input('fee_change', array(
								'label' => false,
								'div' => false,
								'type' => 'text',
								'error' => false,
								'value' => $data['Shop']['fee_change'],
								'class' => 'form-control tar',
							));
							?>
							<span class="input-group-addon">円</span>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="input-group">
							<span class="input-group-addon">キャンセル</span>
							<?= $this->Form->input('fee_cancel', array(
								'label' => false,
								'div' => false,
								'type' => 'text',
								'error' => false,
								'value' => $data['Shop']['fee_cancel'],
								'class' => 'form-control tar',
							));
							?>
							<span class="input-group-addon">円</span>
						</div>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<th>クレジットカード</th>
			<td>
				<?php
				print $this->Form->radio('card', array(1 => 'クレジットカード利用可', 0 => '不可'), array(
					'legend' => false,
					'value' => isset($data[$controller_camel_case]['card']) ? $data[$controller_camel_case]['card'] : 0,
				));
				?>
			</td>
			<th>領収書</th>
			<td>
				<?php
				print $this->Form->radio('receipt', array(1 => '領収書発行可', 0 => '不可'), array(
					'legend' => false,
					'value' => isset($data[$controller_camel_case]['receipt']) ? $data[$controller_camel_case]['receipt'] : 0,
				));
				?>
			</td>
		</tr>
		<tr>
			<th>割引</th>
			<td colspan="3">
				<p class="red">ユーザー様がスマホから電話する際に表示されます。<br>また、カバーガールに「限定割引ラベル」が表示されます。</p>
				<div class="input-group">
					<span class="input-group-addon">デリヘルＯＫ見た!で</span>
					<?= $this->Form->input('discount_bonus', array(
						'label' => false,
						'div' => false,
						'type' => 'text',
						'error' => false,
						'value' => $data['Shop']['discount_bonus'],
						'class' => 'form-control tar',
					));
					?>
					<span class="input-group-addon">円 割引き</span>
				</div>
				<?= $this->Form->error("Shop.discount_bonus") ?>
				<?php
				print $this->Form->input('status_discount', array(
					'type' => 'hidden',
					'value' => false
				));
				$checked  = ' checked';
				$checkedN = $checkedY = null;
				$checkedY = isset($data['Shop']['status_discount']) && $data['Shop']['status_discount'] == 'y' ? $checked : '';
				$checkedN = isset($data['Shop']['status_discount']) && $data['Shop']['status_discount'] == 'n' ? $checked : '';
				?>
				<div style="border-bottom:1px solid #ddd;">
					<input type="radio" name="data[Shop][status_discount]" id="ShopStatusDiscountY" value="y"<?= $checkedY ?>><label for="ShopStatusDiscountY">「デリヘルOK」見た！で</label>
					<?= $this->Form->input('discount_content', array(
						'label' => false,
						'div' => false,
						'type' => 'textarea',
						'value' => $data['Shop']['discount_content'],
						'class' => 'form-control',
						'placeholder' => '割引内容を自由入力',
						'rows' => 10
					));
					?>
				</div>
				<input type="radio" name="data[Shop][status_discount]" id="ShopStatusDiscountN" value="n"<?= $checkedN ?>><label for="ShopStatusDiscountN">割引なし</label>
				<?= $this->Form->error("Shop.status_discount") ?>
			</td>
		</tr>
		<tr>
			<td colspan="4" style="padding:0">
				<?php
				$price_board = unserialize($data['Shop']['price_board']);
				?>
				<table class="table-price-board table table-striped table-condensed" style="margin-bottom:0;">
					<tr>
						<th style="border-left:none;">料金表</th>
						<?php
						$alphabet = range('B', 'F');
						$i=0;
						foreach ($alphabet as $v) {
							print '<th>' . $this->Form->input('Shop.price_board.' . $v . '0', array(
								'type' => 'textarea',
								'label' => false,
								'value' => $price_board[$v . '0'],
								'class' => 'form-control tac',
								'style' => 'height: 50px',
								'error' => false,
								'div' => false,
								'placeholder' => 'コース名' . ($i+1),
								'tabindex' => ($i==0) ? 1 : ($i+10)
							)) . '</th>';
							$i++;
						}
						?>
					</tr>
					<?php
					$alphabet = range('A', 'F');
					for ($i=1; $i<=10; $i++) {
						print '<tr>';
						foreach ($alphabet as $v) {
							if ($v == 'A') {
								print '<td style="border-left:none;"><div class="input-group">' .$this->Form->input('Shop.price_board.' . $v . $i, array(
									'type' => 'text',
									'label' => false,
									'value' => $price_board[$v . $i],
									'class' => 'form-control tar',
									'error' => false,
									'div' => false,
									'maxLength' => 4,
									'placeholder' => ($i == 0) ? '60' : '',
									'tabindex' => $i
								)). '<span class="input-group-addon">分</span></div></td>';
							} else {
								print '<td><div class="input-group">' .$this->Form->input('Shop.price_board.' . $v . $i, array(
									'type' => 'text',
									'label' => false,
									'value' => $price_board[$v . $i],
									'class' => 'form-control tar',
									'error' => false,
									'div' => false,
									'maxLength' => 6,
									'placeholder' => ($i == 0) ? '17000' : '',
									'tabindex' => ($v == 'B') ? $i : ($i+10)
								)). '<span class="input-group-addon">円</span></div></td>';
							}
						}
					print '</tr>';
				}
					?>
				</table>
			</td>
		</tr>
		<tr>
			<th colspan="4" class="sep_row">プレイ情報</th>
		</tr>
		<tr>
			<th>基本プレイ</th>
			<td colspan="3">
				<?php
				print $this->Form->input('play_basic', array(
					'label' => false,
					'type' => 'textarea',
					'value' => $data['Shop']['play_basic'],
					'class' => 'form-control',
					'rows' => 20
				));
				?>
			</td>
		</tr>
		<tr>
			<th>オプション</th>
			<td colspan="3">
				<?php
				print $this->Form->input('play_option', array(
					'label' => false,
					'type' => 'textarea',
					'value' => $data['Shop']['play_option'],
					'class' => 'form-control',
					'rows' => 20
				));
				?>
			</td>
		</tr>
	</table>

	<div class="form-actions" style="text-align:center">
		<button class="btn btn-lg btn-primary" type="submit" onclick="allSelected()"><i class="icon icon-ok"></i>&nbsp;登録する</button>
	</div>
	<?= $this->Form->end() ?>
</div>
