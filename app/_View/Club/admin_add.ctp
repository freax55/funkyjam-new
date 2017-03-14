<?php
$auth_user = $this->Session->read('User');
$disabled_text = '<span style="color:#999">[変更不可]</span> <a href="javascript:void(0);" class="tt" title="変更するには、担当営業マンにお問い合わせください。">変更するには？</a>';
?>
<div class="box">
	<h2><?= $pages_admin[$params['controller']]['title'] ?></h2>
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
	<?= $this->Form->create($controller_camel_case, array('novalidate' => true, 'name'=>'myForm', 'action'=>'post', 'url'=>'/admin/' .$params['controller']. '/post/', 'type' => 'file')) ?>
	<?php
	print $this->Form->input('id', array(
		'type' => 'hidden',
		'value' => $data[$controller_camel_case]['id']
	));
	?>
	<table class="table table-bordered">
		<?php
		if ($auth_user['User']['role_id'] <= 2) {
		?>
		<tr>
			<th colspan="4" class="sep_row">ユーザー設定</th>
		</tr>
		<tr>
			<th style="width: 15%">店舗ユーザー名</th>
			<td style="width: 35%">
				<?php
				print $this->Form->input('user_id', array(
					'label' => false,
					'type' => 'text',
					'value' => isset($data[$controller_camel_case]['user_id']) ? $data[$controller_camel_case]['user_id'] : 0,
					'class' => 'form-control'
				));
				?>
			</td>
			<th style="width: 15%">代理店ユーザー名</th>
			<td style="width: 35%">
				<?php
				print $this->Form->input('agency_id', array(
					'label' => false,
					'type' => 'text',
					'value' => isset($data[$controller_camel_case]['agency_id']) ? $data[$controller_camel_case]['agency_id'] : 0,
					'class' => 'form-control'
				));
				?>
			</td>
		</tr>
		<?php
		} else {
			print $this->Form->input('agency_id', array(
				'type' => 'hidden',
				'value' => isset($data[$controller_camel_case]['agency_id']) ? $data[$controller_camel_case]['agency_id'] : 0
			));
			print $this->Form->input('user_id', array(
				'type' => 'hidden',
				'value' => isset($data[$controller_camel_case]['user_id']) ? $data[$controller_camel_case]['user_id'] : 0
			));
		}
		?>
		<tr>
			<th colspan="4" class="sep_row">基本情報</th>
		</tr>
		<tr>
			<th style="width: 15%">公開設定</th>
			<td style="width: 35%">
				<?php
				$array_status = array('y' => '公開', 'n' => '非公開');
				if ($auth_user['User']['role_id'] <= 3) {
					print $this->Form->radio('status', $array_status, array(
						'legend' => false,
						'value' => isset($data[$controller_camel_case]['status']) ? $data[$controller_camel_case]['status'] : 'n',
					));
				} else {
					print $disabled_text . $array_status[$data[$controller_camel_case]['status']];
					print $this->Form->input('status', array(
						'type' => 'hidden',
						'value' => $data[$controller_camel_case]['status']
					));
				}
				?>
			</td>
			<th style="width: 15%">掲載プラン</th>
			<td style="width: 35%">
				<?php
				if ($auth_user['User']['role_id'] <= 3) {
					print $this->Form->radio('plan_id', $data_plans, array(
						'legend' => false,
						'value' => isset($data['Shop']['plan_id']) ? $data['Shop']['plan_id'] : 2
					));
				} else {
					print $disabled_text . $data_plans[$data[$controller_camel_case]['plan_id']];
					print $this->Form->input('plan_id', array(
						'type' => 'hidden',
						'value' => $data[$controller_camel_case]['plan_id']
					));
				}
				?>
			</td>
		</tr>
		<tr>
			<th>業種<?= $this->common->getMust() ?></th>
			<td>
				<?php
				if ($auth_user['User']['role_id'] <= 3) {
					print $this->Form->radio('job_id', $data_jobs, array(
						'legend' => false,
						'value' => isset($data['Shop']['job_id']) ? $data['Shop']['job_id'] : 1,
					));
				} else {
					print $disabled_text . $jobs[$data[$controller_camel_case]['job_id']];
					print $this->Form->radio('job_id', array(
						'type' => 'hidden',
						'value' => $data[$controller_camel_case]['job_id']
					));
				}
				?>
			</td>
			<th>掲載日</th>
			<td>
				<?php
				if ($auth_user['User']['role_id'] <= 2) {
					if (isset($data['Shop']['created'])) {
						$date = substr($data['Shop']['created'], 0, 10);
					} else {
						$date = date('Y-m-d');
					}
					?>
					<div class="input-group">
						<span class="input-group-addon"><i class="icon icon-calendar"></i></span>
						<?= $this->Form->input('created', array(
							'label' => false,
							'type' => 'text',
							'value' => $date,
							'div' => false,
							'class' => 'dtp form-control',
							'data-date-format' => 'yyyy-mm-dd',
							'readonly' => true
						));
						?>
					</div>
					<?php
				} else {
					print $disabled_text . $this->common->date4mat($data[$controller_camel_case]['created'], 'Y/m/d');
					print $this->Form->input('created', array(
						'type' => 'hidden',
						'value' => $data[$controller_camel_case]['created']
					));
				}
				?>
			</td>
		</tr>
		<tr>
			<th>店舗名<?= $this->common->getMust() ?></th>
			<td>
				<?php
				if ($auth_user['User']['role_id'] <= 3) {
					print $this->Form->input('name', array(
						'label' => false,
						'type' => 'text',
						'value' => $data['Shop']['name'],
						'class' => 'form-control'
					));
				} else {
					print $disabled_text . $data[$controller_camel_case]['name'];
					print $this->Form->input('name', array(
						'type' => 'hidden',
						'value' => $data[$controller_camel_case]['name']
					));
				}
				?>
			</td>
			<th>電話番号<?= $this->common->getMust() ?></th>
			<td>
				<?php
				if ($auth_user['User']['role_id'] <= 3) {
					print $this->Form->input('tel', array(
						'label' => false,
						'type' => 'text',
						'value' => $data['Shop']['tel'],
						'class' => 'form-control'
					));
				} else {
					print $disabled_text . $data[$controller_camel_case]['tel'];
					print $this->Form->input('tel', array(
						'type' => 'hidden',
						'value' => $data[$controller_camel_case]['tel']
					));
				}
				?>
			</td>
		</tr>
		<tr>
			<th>URL<?= $this->common->getMust() ?></th>
			<td>
				<?= $this->Form->input('url', array(
					'label' => false,
					'type' => 'text',
					'value' => $data['Shop']['url'],
					'class' => 'form-control',
					'placeholder' => 'http://' . MYDOMAIN . '/'
				));
				?>
			</td>
			<th>URL(スマホ)</th>
			<td>
				<?= $this->Form->input('url_sp', array(
					'label' => false,
					'type' => 'text',
					'value' => $data['Shop']['url_sp'],
					'class' => 'form-control',
					'placeholder' => 'http://' . MYDOMAIN . '/sp/'
				));
				?>
			</td>
		</tr>
		<tr>
			<th>営業時間<?= $this->common->getMust() ?></th>
			<td>
				<?php
				if ($auth_user['User']['role_id'] <= 3) {
					$time_start = $time_end = "00:00";
					if (isset($data['Shop']['business_time_start'])) {
						$time_start = $data['Shop']['business_time_start'];
					}
					if (isset($data['Shop']['business_time_end'])) {
						$time_end = $data['Shop']['business_time_end'];
					}
					?>
					<div class="input-group bootstrap-timepicker">
						<span class="input-group-addon"><i class="icon icon-time"></i>始</span>
						<?= $this->Form->input('business_time_start', array(
							'label' => false,
							'div' => false,
							'type' => 'text',
							'value' => $time_start,
							'class' => 'form-control',
							'data-default-time' => $time_start,
							'readonly' => true
						));
						?>
						<span class="input-group-addon">〜</span>
						<span class="input-group-addon"><i class="icon icon-time"></i>終</span>
						<?= $this->Form->input('business_time_end', array(
							'label' => false,
							'div' => false,
							'type' => 'text',
							'value' => $time_end,
							'class' => 'form-control',
							'data-default-time' => $time_end,
							'readonly' => true
						));
						?>
					</div>
					<hr style="margin: 8px 0 0 0">
					<div>
						<?= $this->Form->input('business_time_start_hinode', array(
							'type' => 'checkbox',
							'div' => false,
							'label' => '始：日の出',
							'checked' => (isset($data['Shop']['business_time_start_hinode'])) ? $data['Shop']['business_time_start_hinode'] : false
						));
						?>
						<?= $this->Form->input('business_time_end_last', array(
							'type' => 'checkbox',
							'div' => false,
							'label' => '終：ラスト',
							'checked' => (isset($data['Shop']['business_time_end_last'])) ? $data['Shop']['business_time_end_last'] : false
						));
						?>
						<?= $this->Form->input('business_time_24', array(
							'type' => 'checkbox',
							'div' => false,
							'label' => '24時間',
							'checked' => (isset($data['Shop']['business_time_24'])) ? $data['Shop']['business_time_24'] : false
						));
						?>
					</div>
					<?php
				} else {
					// 営業時間を組み立てる
					$business_time = "";
					if ($data[$controller_camel_case]['business_time_24'] == 1) {
						$business_time.= '24時間営業';
					} else {
						if ($data[$controller_camel_case]['business_time_start_hinode'] == 1) {
							$business_time.= '日の出〜';
						} else {
							$business_time.= $data[$controller_camel_case]['business_time_start'] . '&nbsp;〜&nbsp;';
						}
						if ($data[$controller_camel_case]['business_time_end_last'] == 1) {
							$business_time.= 'LAST';
						} else {
							if (substr($data[$controller_camel_case]['business_time_end'], 0, 1) == 0) {
								$business_time.= '翌' . $data[$controller_camel_case]['business_time_end'];
							} else {
								$business_time.= $data[$controller_camel_case]['business_time_end'];
							}
						}
					}
					print $business_time;

					print $this->Form->input('business_time_start', array(
						'type' => 'hidden',
						'value' => $data[$controller_camel_case]['business_time_start']
					));
					print $this->Form->input('business_time_end', array(
						'type' => 'hidden',
						'value' => $data[$controller_camel_case]['business_time_end']
					));
				}
				?>
			</td>
			<th>定休日</th>
			<td>
			<?php
			print $this->Form->input('business_holiday', array(
				'label' => false,
				'type' => 'text',
				'value' => (isset($data['Shop']['business_holiday'])) ? $data['Shop']['business_holiday'] : '年中無休',
				'class' => 'form-control'
			));
			?>
			</td>
		</tr>
		<tr>
			<th style="white-space:nowrap">キャッチコピー<?= $this->common->getMust() ?></th>
			<td colspan="3">
				<?= $this->Form->input('catch_copy', array(
					'label' => false,
					'type' => 'text',
					'value' => $data['Shop']['catch_copy'],
					'class' => 'form-control',
					'maxlength' => '60',
					'placeholder' => '60文字以内'
				));
				?>
			</td>
		</tr>
		<tr>
			<th>紹介文<?= $this->common->getMust() ?></th>
			<td colspan="3">
				<?php
				print $this->Form->input('description', array(
					'label' => false,
					'type' => 'textarea',
					'value' => $data['Shop']['description'],
					'class' => 'form-control',
					'style' => 'height: 300px'
				));
				?>
			</td>
		</tr>
		<tr>
			<th>タグ<?= $this->common->getMust() ?></th>
			<td colspan="3">
				<?php
				if ($auth_user['User']['role_id'] <= 3) {
					$tags = json_decode($data[$controller_camel_case]['tags'], true);
					foreach ($data_shop_tag_categories as $k2 => $v2) {
						print '<fieldset>';
						print '<legend>' . $v2 . '</legend>';
						foreach ($data_shop_tags as $k => $v) {
							$v = $v['ShopTag'];
							if ($v['category_id'] == $k2) {
								print '<div style="float: left; margin: 0 0 10px 0; width: 200px;">';
								print $this->Form->input('tags]['.$v['id'], array(
									'type' => 'checkbox',
									'value' => 1,
									'label' => false,
									'checked' => @($tags[$v['id']] == 1) ? true : false,
									'div' => false,
								));
								print $this->Form->label('tags]['.$v['id'], $v['name'], ['class'=>'tt','title'=>$v['content']]);
								print "</div>\n\n";
							}
						}
						print '</fieldset>';
					}
				?>
				<?= $this->Form->error("Shop.tags") ?>
				<?php
				} else {
					foreach ($data_shop_tags as $k => $v) {
						$v = $v['ShopTag'];
						if (@$tags[$v['id']] == 1) {
							$shop_tags[] = $v['name'];
						}
						print $this->Form->input('tags][' . $v['id'], array(
							'type' => 'hidden',
							'value' => @($tags[$v['id']] == 1) ? true : 0
						));
					}
					if (!empty($shop_tags)) {
						print $disabled_text . implode('、', $shop_tags);
					} else {
						print $disabled_text . 'タグが付けられていません。';
					}
				}
				?>
				<?php
				if ($auth_user['User']['role_id'] <= 3) {
					$tags_girl = json_decode($data[$controller_camel_case]['tags_girl'], true);
					foreach ($data_girl_tag_categories as $k2 => $v2) {
						// バストカップは自動で処理するので表示しない
						if ($k2 != 4) {
							print '<fieldset>';
							print '<legend>' . $v2 . '</legend>';
							foreach ($data_girl_tags as $k => $v) {
								$v = $v['GirlTag'];
								if ($v['category_id'] == $k2) {
									print '<div style="float: left; margin: 0 0 10px 0; width: 200px;">';
									print $this->Form->input('tags_girl]['.$v['id'], array(
										'type' => 'checkbox',
										'value' => 1,
										'label' => false,
										'checked' => @($tags_girl[$v['id']] == 1) ? true : false,
										'div' => false,
									));
									print $this->Form->label('tags_girl]['.$v['id'], $v['name'], ['class'=>'tt','title'=>$v['content']]);
									print "</div>\n\n";
								}
							}
							print '</fieldset>';
						}
					}
				?>
				<?php
				} else {
					foreach ($data_girl_tags as $k => $v) {
						$v = $v['GirlTag'];
						if (@$tags_girl[$v['id']] == 1) {
							$girl_tags[] = $v['name'];
						}
						print $this->Form->input('tags_girl][' . $v['id'], array(
							'type' => 'hidden',
							'value' => @($tags_girl[$v['id']] == 1) ? true : 0
						));
					}
					if (!empty($girl_tags)) {
						print $disabled_text . implode('、', $girl_tags);
					} else {
						print $disabled_text . 'タグが付けられていません。';
					}
				}
				?>
			</td>
		</tr>
		<tr>
			<th colspan="4" class="sep_row">料金情報</th>
		</tr>
		<tr>
			<th>各種料金</th>
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
			<th>割引</th>
			<td colspan="3">
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
					<input type="radio" name="data[Shop][status_discount]" id="ShopStatusDiscountY" value="y"<?= $checkedY ?>><label for="ShopStatusDiscountY"><?= SITENAME ?>見た！で</label>
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
				<br>
				<?php
				print $this->Form->radio('discount_weather', array('y' => '雨の日割引あり', 'n' => 'なし'), array(
					'legend' => false,
					'value' => isset($data[$controller_camel_case]['discount_weather']) ? $data[$controller_camel_case]['discount_weather'] : 'n',
				));
				?>
			</td>
		</tr>
		<tr>
			<td colspan="4" style="padding:0">
				<?php
				$price_board = json_decode($data['Shop']['price_board'], true);
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
			<th>料金備考</th>
			<td colspan="3">
				<?php
				print $this->Form->input('price_option', array(
					'label' => false,
					'type' => 'textarea',
					'value' => $data['Shop']['price_option'],
					'class' => 'form-control',
					'style' => 'height: 300px'
				));
				?>
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
		<tr>
			<th colspan="4" class="sep_row">エリア</th>
		</tr>
		<tr>
			<th>出発地 or 所在地<?= $this->common->getMust() ?></th>
			<td colspan="3">
				<?php
				if ($auth_user['User']['role_id'] <= 3) {
					print $this->Form->input('pref_id', array(
						'label' => false,
						'type' => 'select',
						'selected' => isset($data['Shop']['pref_id']) ? $data['Shop']['pref_id'] : 0,
						'options' => array(0 => "▼選択", "都道府県" => $prefs),
						'div' => false,
						'style' => 'width:120px',
						'error' => false,
						'class' => 'form-control',
						'disabled' => ($auth_user['User']['role_id'] <= 3) ? false : true
					));
					print $this->Form->input('city_id', array(
						'label' => false,
						'type' => 'select',
						'selected' => isset($data['Shop']['city_id']) ? $data['Shop']['city_id'] : 0,
						'options' => array(0 => "▼選択"),
						'div' => false,
						'style' => 'width:200px',
						'error' => false,
						'class' => 'form-control',
						'disabled' => ($auth_user['User']['role_id'] <= 3) ? false : true
					));
					print $this->Form->input('town_id', array(
						'label' => false,
						'type' => 'select',
						'selected' => isset($data['Shop']['town_id']) ? $data['Shop']['town_id'] : 0,
						'options' => array(0 => "▼選択"),
						'div' => false,
						'style' => 'width:200px',
						'error' => false,
						'class' => 'form-control',
						'disabled' => ($auth_user['User']['role_id'] <= 3) ? false : true
					));
					print $this->Form->input('address_num', array(
						'label' => false,
						'type' => 'text',
						'value' => isset($data[$controller_camel_case]['address_num']) ? $data[$controller_camel_case]['address_num'] : "",
						'div' => false,
						'style' => 'width:280px',
						'class' => 'form-control',
						'placeholder' => '番地 ※店舗型のお店は入力必須',
					));
				} else {
					print $disabled_text . $data[$controller_camel_case]['pref'] . ' ' . $data[$controller_camel_case]['city'];
					print $this->Form->input('pref', array(
						'type' => 'hidden',
						'value' => $data[$controller_camel_case]['pref']
					));
					print $this->Form->input('city', array(
						'type' => 'hidden',
						'value' => $data[$controller_camel_case]['city']
					));
					print $this->Form->input('pref_id', array(
						'type' => 'hidden',
						'value' => $data[$controller_camel_case]['pref_id']
					));
					print $this->Form->input('city_id', array(
						'type' => 'hidden',
						'value' => $data[$controller_camel_case]['city_id']
					));
				}
				?>
				<?= $this->Form->error("Shop.pref_id") ?>
				<?= $this->Form->error("Shop.city_id") ?>
			</td>
		</tr>
		<tr>
			<th>出張エリア・駅<?= $this->common->getMust() ?></th>
			<td colspan="3">
				<div class="pull-left" style="width:50%">
					<?php
					$display_area_select = '';
					$cnt = MAX_COUNT_AREA;
					if ($auth_user['User']['role_id'] == 4) {
						$display_area_select = 'display:none;';
						print $disabled_text . '<ul>';
						if (isset($data['Shop']['area_ids'])) {
							$area_ids = json_decode($data['Shop']['area_ids'], true);
							foreach ($area_ids as $k => $v) {
								print '<input type="hidden" name="data[Shop][area_pref_id][]" value="' . array_keys($v)[0] . '">';
								print '<input type="hidden" name="data[Shop][area_id][]" value="' . array_values($v)[0] . '">';
								$areas = $this->Common->getAreasOption(array_keys($v)[0]);
								print '<li>' . $prefs[array_keys($v)[0]] . ' ' . $areas[array_values($v)[0]] . '</li>';
							}
							$cnt = MAX_COUNT_AREA-count($area_ids);
						}
						print '</ul>';
					} else {
						if (isset($data['Shop']['area_ids'])) {
							$area_ids = json_decode($data['Shop']['area_ids'], true);
							foreach ($area_ids as $k => $v) {
								print '<div class="mb5">';
								print $this->Form->input('area_pref_id][', array(
									 'label' => false,
									 'type' => 'select',
									 'selected' => array_keys($v)[0],
									 'options' => array(0 => "都道府県", "▼選択" => $prefs),
									 'div' => false,
									 'style' => 'width:120px',
									 'error' => false,
									 'class' => 'form-control area-config',
								 ));
								print $this->Form->input('area_id][', array(
									'label' => false,
									'type' => 'select',
									'data-selected' => array_values($v)[0],
									'options' => array(0 => "出張可能エリア"),
									'div' => false,
									'error' => false,
									'style' => 'width:300px',
									'class' => 'form-control area',
								));
								print '</div>';
							}
							$cnt = MAX_COUNT_AREA-count($area_ids);
						}
					}
					for ($i=1; $i<=$cnt; $i++) {
						print $this->Form->input('area_pref_id][', array(
							 'label' => false,
							 'type' => 'select',
							 'options' => array(0 => "都道府県", "▼選択" => $prefs),
							 'div' => false,
							 'style' => 'width:120px;' . $display_area_select,
							 'error' => false,
							 'class' => 'form-control area-config',
						 ));
						print $this->Form->input('area_id][', array(
							'label' => false,
							'type' => 'select',
							'options' => array(0 => "出張可能エリア"),
							'div' => false,
							'error' => false,
							'style' => 'width:300px;' . $display_area_select,
							'class' => 'form-control area',
						));
					}
					?>
					<?= $this->Form->error("Shop.area_pref_id") ?>
					<?= $this->Form->error("Shop.area_id") ?>
				</div>
				<div class="pull-right" style="width:50%">
					<?php
					$station_ids_options = [];
					?>
					<div class="alert alert-warning">
						<ul>
							<li>※都道府県に合った、出張可能な駅名を選択してください。</li>
							<li>※10駅まで登録出来ます。11個目からは削除されます。</li>
						</ul>
					</div>
					<?= $this->Form->input('station_q', array(
						'label' => false,
						'type' => 'text',
						'class' => 'form-control station_q',
						'placeholder' => '駅名を入力して候補から選択してください。',
						'style' => 'margin:5px auto;'
					));
					?>
					<?php
					if (isset($data['Shop']['station_ids'])) {
						$station_ids = json_decode($data['Shop']['station_ids'], true);
						if (!empty($station_ids)) {
							foreach ($station_ids as $k => $v) {
								$station_ids_options[$k] = $data_stations[$k];
							}
						}
					}
					print $this->Form->input('station_ids', array(
						'label' => false,
						'div' => false,
						'type' => 'select',
						'multiple' => true,
						'class' => 'form-control stations',
						'style' => 'min-height:295px;height:100%',
						'options' => $station_ids_options
					));
					?>
					<div class="form-actions" style="text-align:center;margin:0">
						<button type="button" class="btn btn-sm btn-danger" onclick="del_row('station'); return false;"><i class="icon icon-minus-sign"></i> 選択行削除</button>
					</div>
					<select name="data[Shop][deli_station_town]" id="ShopDeliStationTown" style="display:none"></select>
				</div>

				<table class="table table-bordered">
					<?php
					if ($auth_user['User']['role_id'] <= 3) {
						print '<tr>';
						print '<th>都道府県選択</th>';
						print '<td style="border-left:none">';
						print $this->Form->input('deli_city_pref_id', array(
							'label' => false,
							'type' => 'select',
							'options' => array(0 => "▼選択", "都道府県" => $prefs),
							'div' => false,
							'style' => 'width:140px'
						));
						print '</td></tr>';
					}
					?>
					<tr>
						<th style="border-left:none;height:100%;width:100px">市区町村</th>
						<?php
						$city_ids_options = [];
						if ($auth_user['User']['role_id'] <= 3) {
						?>
						<td style="height:100%;width:286px">
							<select name="data[Shop][deli_city_city]" id="ShopDeliCityCity" class="input-block-level" style="min-height:300px;height:100%" multiple></select>
							<div class="form-actions" style="text-align:center;margin:0">
								<button type="button" class="btn btn-mini btn-info" onclick="add_row('city'); return false;"><i class="icon icon-plus-sign"></i> 選択行追加</button>
							</div>
						</td>
						<td style="height:100%;width:286px">
							<?php
							if (isset($data['Shop']['city_ids'])) {
								$city_ids = json_decode($data['Shop']['city_ids'], true);
								foreach ($city_ids as $k => $v) {
									$city_ids_options[$k] = $data_cities[$k];
								}
							}
							print $this->Form->input('city_ids', array(
								'label' => false,
								'div' => false,
								'type' => 'select',
								'multiple' => true,
								'class' => 'input-block-level',
								'style' => 'min-height:300px;height:100%',
								'options' => $city_ids_options
							));
							?>
							<div class="form-actions" style="text-align:center;margin:0">
								<button type="button" class="btn btn-mini btn-danger" onclick="del_row('city'); return false;"><i class="icon icon-minus-sign"></i> 選択行削除</button>
							</div>
						</td>
						<?php
						} else {
							print '<td colspan="2">';
							if (isset($data['Shop']['city_ids'])) {
								$city_ids = json_decode($data['Shop']['city_ids'], true);
								foreach ($city_ids as $k => $v) {
									$cities[] = $data_cities[$k];
									$city_ids_options[$k] = $data_cities[$k];
								}
							}
							if (!empty($cities)) {
								print $disabled_text . '<br>' . implode('、', $cities);
							}
							print $this->Form->input('city_ids', array(
								'label' => false,
								'div' => false,
								'type' => 'select',
								'multiple' => true,
								'class' => 'input-block-level',
								'style' => 'min-height:300px;height:100%',
								'options' => $city_ids_options,
								'style' => 'display:none'
							));
							print '</td>';
						}
						?>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<th>交通費</th>
			<td colspan="3" style="padding:0">
				<table class="table table-borderd" style="margin:0; border-left:none" id="tr_delivery_fee">
					<?php
					if (isset($data['Shop']['delivery_fee'])) {
						$delivery_fee = json_decode($data['Shop']['delivery_fee'], true);
						foreach ($delivery_fee as $v) {
						?>
						<tr>
							<th style="border-left:none;width:121px !important">
								<?= $this->Form->input('delivery_fee][' . $v['price'], array(
									'label' => false,
									'div' => false,
									'type' => 'text',
									'value' => $v['price'],
									'class' => 'form-control'
								));
								?>
							</th>
							<td>
								<?php
								print $this->Form->input('delivery_fee_body][', array(
									'label' => false,
									'type' => 'textarea',
									'value' => $v['body'],
									'class' => 'form-control',
									'rows' => 6
								));
								?>
							</td>
						</tr>
						<?php
						}
					} else {
					?>
					<tr>
						<th style="border-left:none;width:121px !important">
							<?= $this->Form->input('delivery_fee][', array(
								'label' => false,
								'div' => false,
								'type' => 'text',
								'class' => 'form-control'
							));
							?>
						</th>
						<td>
							<?php
							print $this->Form->input('delivery_fee_body][', array(
								'label' => false,
								'type' => 'textarea',
								'class' => 'form-control',
								'rows' => 6
							));
							?>
						</td>
					</tr>
					<?php
					}
					?>
					<tr id="skel" style="display:none">
						<th style="border-left:none;width:121px !important">
							<input name="data[Shop][delivery_fee][]" class="form-control" type="text" id="ShopDeliveryFee][">
						</th>
						<td>
							<div class="input textarea"><textarea name="data[Shop][delivery_fee_body][]" class="form-control" cols="30" rows="6" id="ShopDeriveryFeeBody]["></textarea></div>
						</td>
					</tr>
				</table>
				<div class="form-actions" style="text-align:center;margin:0">
					<button class="btn btn-sm btn-info" onclick="add_row_delivery_fee(); return false;"><i class="icon icon-plus-sign"></i> 行追加</button>
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
		<tr>
			<th colspan="4" class="sep_row">管理者入力欄</th>
		</tr>
		<tr>
			<th>連絡先</th>
			<td colspan="3">
				<div class="row">
					<div class="col-xs-3">
						<div class="input-group">
							<span class="input-group-addon">担当</span>
							<?= $this->Form->input('admin_name', array(
								'type' => 'text',
								'label' => false,
								'div' => false,
								'value' => $data['Shop']['admin_name'],
								'class' => 'form-control',
								'placeholder' => 'スズキ'
							));
							?>
							<span class="input-group-addon">様</span>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="input-group">
							<span class="input-group-addon">TEL</span>
							<?= $this->Form->input('admin_tel', array(
								'type' => 'text',
								'label' => false,
								'div' => false,
								'value' => $data['Shop']['admin_tel'],
								'class' => 'form-control',
								'placeholder' => '03-0000-1111'
							));
							?>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="input-group">
							<span class="input-group-addon">メール</span>
							<?= $this->Form->input('admin_email', array(
								'type' => 'text',
								'label' => false,
								'div' => false,
								'value' => $data['Shop']['admin_email'],
								'class' => 'form-control',
								'placeholder' => 'info@ikulist.me'
							));
							?>
						</div>
					</div>
				</div>
			</td>
		</tr>
		<?php
		if ($auth_user['User']['role_id'] <= 2) {
		?>
		<tr>
			<th>管理者備考</th>
			<td colspan="3">
				<?php
				print $this->Form->input('comment', array(
					'label' => false,
					'type' => 'textarea',
					'value' => $data['Shop']['comment'],
					'class' => 'form-control'
				));
				?>
			</td>
		</tr>
		<?php
		}
		?>
		<?php
		if ($auth_user['User']['role_id'] <= 3) {
		?>
		<tr>
			<th colspan="4" class="sep_row">画像</th>
		</tr>
		<tr>
			<th>右バナー<br><span class="badge">300 x 100</span></th>
			<td colspan="3">
				<?php
				if (isset($data[$controller_camel_case]['img_rectangle']) && $data[$controller_camel_case]['img_rectangle'] != "") {
					list($width, $height) = getimagesize(IMAGES. 'shop' .DS . $data[$controller_camel_case]['img_rectangle']);
					print '<img src="/img/shop/' . $data[$controller_camel_case]['img_rectangle'] . '" width="' . $width . '" height="' . $height . '">';
					print $this->Form->input('img_rectangle', array('type'=>'hidden','value'=>$data[$controller_camel_case]['img_rectangle']));
					print '<br>';
					print "<a href=\"/admin/shop/delete_image/";
					print $data[$controller_camel_case]['id'] . DS . 'img_rectangle' . DS;
					print '" onclick="return confirm(\'画像を削除してもよろしいですか？\');" class="btn btn-danger" style="float:right">';
					print '<i class="icon icon-remove"></i> 画像を削除する</a>';
				}
				?>
				<input type="file" name="data[img_rectangle]">
				<input type="hidden" name="data[img_rectangle]">
			</td>
		</tr>
		<tr>
			<th>大バナー<br><span class="badge">655 x 84</span></th>
			<td colspan="3">
				<?php
				if (isset($data[$controller_camel_case]['img_banner_full']) && $data[$controller_camel_case]['img_banner_full'] != "") {
					list($width, $height) = getimagesize(IMAGES. 'shop' .DS . $data[$controller_camel_case]['img_banner_full']);
					print '<img src="/img/shop/' . $data[$controller_camel_case]['img_banner_full'] . '" width="' . $width . '" height="' . $height . '">';
					print $this->Form->input('img_banner_full', array('type'=>'hidden','value'=>$data[$controller_camel_case]['img_banner_full']));
					print '<br>';
					print "<a href=\"/admin/shop/delete_image/";
					print $data[$controller_camel_case]['id'] . DS . 'img_banner_full' . DS;
					print '" onclick="return confirm(\'画像を削除してもよろしいですか？\');" class="btn btn-danger" style="float:right">';
					print '<i class="icon icon-remove"></i> 画像を削除する</a>';
				}
				?>
				<input type="file" name="data[img_banner_full]">
				<input type="hidden" name="data[img_banner_full]">
			</td>
		</tr>
		<tr>
			<th>トップ地図背景画像<br><span class="badge">655 x 436</span></th>
			<td colspan="3">
				<?php
				if (isset($data[$controller_camel_case]['img_root']) && $data[$controller_camel_case]['img_root'] != "") {
					list($width, $height) = getimagesize(IMAGES. 'shop' .DS . $data[$controller_camel_case]['img_root']);
					print '<img src="/img/shop/' . $data[$controller_camel_case]['img_root'] . '" width="' . $width . '" height="' . $height . '">';
					print $this->Form->input('img_root', array('type'=>'hidden','value'=>$data[$controller_camel_case]['img_root']));
					print '<br>';
					print "<a href=\"/admin/shop/delete_image/";
					print $data[$controller_camel_case]['id'] . DS . 'img_root' . DS;
					print '" onclick="return confirm(\'画像を削除してもよろしいですか？\');" class="btn btn-danger" style="float:right">';
					print '<i class="icon icon-remove"></i> 画像を削除する</a>';
				}
				?>
				<input type="file" name="data[img_root]">
				<input type="hidden" name="data[img_root]">
			</td>
		</tr>
		<?php
		} else {
			print $this->Form->input('img_rectangle', array(
				'type' => 'hidden',
				'value' => $data[$controller_camel_case]['img_rectangle']
			));
			print $this->Form->input('img_banner_full', array(
				'type' => 'hidden',
				'value' => $data[$controller_camel_case]['img_banner_full']
			));
			print $this->Form->input('img_root', array(
				'type' => 'hidden',
				'value' => $data[$controller_camel_case]['img_root']
			));
		}
		?>
	</table>

	<div class="form-actions" style="text-align:center">
		<button class="btn btn-lg btn-primary" type="submit" onclick="allSelected()"><i class="icon icon-ok"></i>&nbsp;登録する</button>
	</div>
	<?= $this->Form->end() ?>
</div>
