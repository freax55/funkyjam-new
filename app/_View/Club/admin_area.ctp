<?php
$auth_user = $this->Session->read('User');
$disabled_text = '<span style="color:#999">[変更不可]</span> <a href="javascript:void(0);" class="tt" title="変更するには、担当営業マンにお問い合わせください。">変更するには？</a>';
?>
<div class="box">
	<h2><?= $pages_admin[$params['controller']]['title'] ?> -交通費</h2>
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
	<?= $this->Form->create($controller_camel_case, array('novalidate' => true, 'name'=>'myForm', 'action'=>'area', 'url'=>'/admin/' .$params['controller']. '/area/' . $data[$controller_camel_case]['id'] . '/', 'type' => 'file')) ?>
	<?php
	print $this->Form->input('id', array(
		'type' => 'hidden',
		'value' => $data[$controller_camel_case]['id']
	));
	print $this->Form->input('job_id', array(
		'type' => 'hidden',
		'value' => $data[$controller_camel_case]['job_id']
	));
	print $this->Form->input('name', array(
		'type' => 'hidden',
		'value' => $data[$controller_camel_case]['name']
	));
	print $this->Form->input('city_id', array(
		'type' => 'hidden',
		'value' => $data[$controller_camel_case]['city_id']
	));
	print $this->Form->input('station_ids', array(
		'type' => 'hidden',
		'value' => $data[$controller_camel_case]['station_ids']
	)); 
	?>
	<table class="table table-bordered">
		<tr>
			<th>派遣可能市区町村<?= $this->common->getMust() ?></th>
			<td colspan="3">
				<?= array_keys($prefs_regions)[0] . '地方' ?>
				<ul class="nav nav-tabs" role="tablist">
				<?php
				foreach ($prefs_regions as $k => $v) {
					foreach ($v as $pref_id => $pref_name) {
						if ($pref_id == $data['Shop']['pref_id']) {
							$active = ' class="active"';
						} else {
							$active = '';
						}
						print '<li role="presentation"' . $active . '><a href="#pref-' . $pref_id . '" aria-controls="pref-' . $pref_id . '" role="tab" data-toggle="tab">' . $pref_name . '</a></li>';
					}
				}
				?>
				</ul>
				<div class="tab-content">
				<?php
				$delivery = json_decode($data['Shop']['city_ids'], true);
				foreach ($prefs_regions as $k => $v) {
					foreach ($v as $pref_id => $pref_name) {
						if ($pref_id == $data['Shop']['pref_id']) {
							$active = ' active';
						} else {
							$active = '';
						}
						?>
					<div role="tabpanel" class="tab-pane<?= $active ?>" id="pref-<?= $pref_id ?>">
						<p class="red">交通費の欄にはカンマ無しの数字か「要確認」と入力すると該当市区郡ページに表示されます。</p>
						<table class="table table-brdr">
							<thead>
								<tr>
									<th class="tac w20p">市区町村</th>
									<th class="tac w20p">交通費</th>
									<th class="tac">備考</th>
								</tr>
							</thead>
							<tbody>
							<?php
							foreach ($prefs_cities[$pref_id] as $cities) {
								$city = $cities['City'];
								$v_price = $v_memo = "";
								if (isset($delivery[$pref_id])) {
									if (isset($delivery[$pref_id][$city['id']])) {
										if ($delivery[$pref_id][$city['id']]['price'] != "") {
											$v_price = $delivery[$pref_id][$city['id']]['price'];
										}
										if ($delivery[$pref_id][$city['id']]['memo'] != "") {
											$v_memo = $delivery[$pref_id][$city['id']]['memo'];
										}
									}
								}
								?>
								<tr>
									<td class="tar"><?= $city['name'] ?></td>
									<td>
										<div class="input-group">
											<?php
											print $this->Form->input('prefs_city][' . $pref_id . '][' . $city['id'] . '][price', array(
												'label' => false,
												'type' => 'text',
												'value' => $v_price,
												'class' => 'form-control',
												'placeholder' => 'カンマ無しor要確認',
											));
											?>
											<span class="input-group-addon">円</span>
										</div>
									</td>
									<td>
									<?php
									print $this->Form->input('prefs_city][' . $pref_id . '][' . $city['id'] . '][memo', array(
										'label' => false,
										'type' => 'text',
										'value' => $v_memo,
										'class' => 'form-control',
										'placeholder' => '1000円〜3000円の場合は、交通費に「1000」備考欄に「〜3,000円」と入力してください。',
									));
									?>
									</td>
								</tr>
								<?php
							}
							?>
							</tbody>
						</table>
					</div>
						<?php
						}
					}
					?>
				</div>
			</td>
		</tr>
		<tr>
			<th>交通費備考</th>
			<td colspan="3">
				<?php
				print $this->Form->input('fee_delivery_content', array(
					'label' => false,
					'type' => 'textarea',
					'value' => $data['Shop']['fee_delivery_content'],
					'class' => 'form-control',
					'rows' => 10
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
