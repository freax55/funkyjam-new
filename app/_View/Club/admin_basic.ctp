<?php
$auth_user = $this->Session->read('User');
$disabled_text = '<span style="color:#999">[変更不可]</span> <a href="javascript:void(0);" class="tt" title="変更するには、担当営業マンにお問い合わせください。">変更するには？</a>';
?>
<div class="box">
	<h2><?= $pages_admin[$params['controller']]['title'] ?> -基本情報</h2>
	<h3><?= $data['Club']['name'] ?></h3>
	<?php
	$buttons = array(
		'view' => array(
			'href' => '/admin/' .$params['controller']. '/'
		),
	);
	if ($data[$controller_camel_case]['id'] != "") {
		$view_shop_detail = '<div class="pull-left"><a href="/shop/' . $data[$controller_camel_case]['id'] . '/" class="btn btn-success" target="_blank">掲載ページを確認</a></div>';
	} else {
		$view_shop_detail = "";
	}
	print $this->common->getContentHeader($view_shop_detail, $buttons);
	?>
	<?= $this->Form->create($controller_camel_case, array('novalidate' => true, 'name'=>'myForm', 'action'=>'basic', 'url'=>'/admin/' .$params['controller']. '/basic/', 'type' => 'file')) ?>
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
						'value' => isset($data[$controller_camel_case]['plan_id']) ? $data[$controller_camel_case]['plan_id'] : 2,
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
			<th>店舗名<?= $this->common->getMust() ?></th>
			<td>
				<?php
				if ($auth_user['User']['role_id'] <= 3) {
					print $this->Form->input('name', array(
						'label' => false,
						'type' => 'text',
						'value' => $data[$controller_camel_case]['name'],
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
			<th>掲載日</th>
			<td>
				<?php
				if ($auth_user['User']['role_id'] <= 2) {
					if (isset($data[$controller_camel_case]['created'])) {
						$date = substr($data[$controller_camel_case]['created'], 0, 10);
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
			<th>所在地<?= $this->common->getMust() ?></th>
			<td>
				<?php
				if ($auth_user['User']['role_id'] <= 3) {
					print $this->Form->input('address', array(
						'label' => false,
						'type' => 'text',
						'value' => $data[$controller_camel_case]['address'],
						'class' => 'form-control'
					));
				} else {
					print $disabled_text . $data[$controller_camel_case]['address'];
					print $this->Form->input('address', array(
						'type' => 'hidden',
						'value' => $data[$controller_camel_case]['address']
					));
				}
				?>
			</td>
			<th>電話番号</th>
			<td>
				<?php
				if ($auth_user['User']['role_id'] <= 3) {
					print $this->Form->input('tel', array(
						'label' => false,
						'type' => 'text',
						'value' => $data[$controller_camel_case]['tel'],
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
			<th>都道府県</th>
			<td>
				<?= $this->Form->input('pref_id', array(
					'label' => false,
					'div' => false,
					'type' => 'select',
					// 'value' => $time_start,
					'selected' => isset($data[$controller_camel_case]['pref_id']) ? $data[$controller_camel_case]['pref_id'] : 0,
					'class' => 'form-control',
					'options' => array(0 => '都道府県', '▼選択'=>$list_pref)
					// 'data-default-time' => $time_start,
					// 'readonly' => true
				));
				?>
			</td>
			<th>エリア</th>
			<td>
				<?= $this->Form->input('area_id', array(
					'label' => false,
					'div' => false,
					'type' => 'select',
					// 'value' => $time_start,
					'selected' => isset($data[$controller_camel_case]['area_id']) ? $data[$controller_camel_case]['area_id'] : 0,
					'class' => 'form-control',
					'options' => array(0 => 'エリア', '▼選択'=>$list_area)
					// 'data-default-time' => $time_start,
					// 'readonly' => true
				));
				?>		
			</td>
		</tr>
		<tr>
			<th>URL(PC)</th>
			<td>
				<div class="input-group">
					<span class="input-group-addon">PC</span>
					<?= $this->Form->input('url', array(
						'label' => false,
						'div' => false,
						'type' => 'text',
						'value' => $data[$controller_camel_case]['url'],
						'class' => 'form-control',
						'placeholder' => 'http://' . MYDOMAIN . '/'
					));
					?>
				</div>
			</td>
			<th>URL(SP)</th>
			<td>
				<div class="input-group">
					<span class="input-group-addon">スマホ</span>
					<?= $this->Form->input('url_sp', array(
						'label' => false,
						'div' => false,
						'type' => 'text',
						'value' => $data[$controller_camel_case]['url_sp'],
						'class' => 'form-control',
						'placeholder' => 'http://' . MYDOMAIN . '/sp/'
					));
					?>
				</div>
			</td>
		</tr>
		<tr>
			<th>メールアドレス</th>
			<td>
				<div>
					<?= $this->Form->input('mail', array(
						'label' => false,
						'div' => false,
						'type' => 'text',
						'value' => $data[$controller_camel_case]['mail'],
						'class' => 'form-control',
						'placeholder' => ''
					));
					?>
				</div>
			</td>
			<th>URL(mobile)</th>
			<td>
				<div class="input-group">
					<span class="input-group-addon">モバイル</span>
					<?= $this->Form->input('url_mb', array(
						'label' => false,
						'div' => false,
						'type' => 'text',
						'value' => $data[$controller_camel_case]['url_mb'],
						'class' => 'form-control',
						'placeholder' => 'http://' . MYDOMAIN . '/mobile/'
					));
					?>
				</div>
			</td>
		</tr>
		<tr>
			<th>営業時間<?= $this->common->getMust() ?></th>
			<td>
				<?php
				if ($auth_user['User']['role_id'] <= 3) {
					$time_start = $time_end = "00:00";
					if (isset($data[$controller_camel_case]['business_time_start'])) {
						$time_start = $data[$controller_camel_case]['business_time_start'];
					}
					if (isset($data[$controller_camel_case]['business_time_end'])) {
						$time_end = $data[$controller_camel_case]['business_time_end'];
					}
					?>
					<div class="input-group bootstrap-timepicker">
						<span class="input-group-addon"><i class="icon icon-time"></i>始</span>
						<?= $this->Form->input('open', array(
							'label' => false,
							'div' => false,
							'type' => 'select',
							// 'value' => $time_start,
							'selected' => isset($data[$controller_camel_case]['open']) ? $data[$controller_camel_case]['open'] : 0,
							'class' => 'form-control',
							'options' => array(0 => '開始時刻', '▼選択'=>$timezone['open'])
							// 'data-default-time' => $time_start,
							// 'readonly' => true
						));
						?>
						<span class="input-group-addon">〜</span>
						<span class="input-group-addon"><i class="icon icon-time"></i>終</span>
						<?= $this->Form->input('close', array(
							'label' => false,
							'div' => false,
							'type' => 'select',
							// 'value' => $time_start,
							'selected' => isset($data[$controller_camel_case]['close']) ? $data[$controller_camel_case]['close'] : 0,
							'class' => 'form-control',
							'options' => array(0 => '終了時刻', '▼選択'=>$timezone['close'])
							// 'data-default-time' => $time_start,
							// 'readonly' => true
						));
						?>
					<?php
				} //else {
					// 営業時間を組み立てる
					// $business_time = "";
					// if ($data[$controller_camel_case]['business_time_24'] == 1) {
					// 	$business_time.= '24時間営業';
					// } else {
					// 	if ($data[$controller_camel_case]['business_time_start_hinode'] == 1) {
					// 		$business_time.= '日の出〜';
					// 	} else {
					// 		$business_time.= $data[$controller_camel_case]['business_time_start'] . '&nbsp;〜&nbsp;';
					// 	}
					// 	if ($data[$controller_camel_case]['business_time_end_last'] == 1) {
					// 		$business_time.= 'LAST';
					// 	} else {
					// 		if (substr($data[$controller_camel_case]['business_time_end'], 0, 1) == 0) {
					// 			$business_time.= '翌' . $data[$controller_camel_case]['business_time_end'];
					// 		} else {
					// 			$business_time.= $data[$controller_camel_case]['business_time_end'];
					// 		}
					// 	}
					// }
					// print $business_time;

					// print $this->Form->input('business_time_start', array(
					// 	'type' => 'hidden',
					// 	'value' => $data[$controller_camel_case]['business_time_start']
					// ));
					// print $this->Form->input('business_time_end', array(
					// 	'type' => 'hidden',
					// 	'value' => $data[$controller_camel_case]['business_time_end']
					// ));
				// }
				?>
			</td>
			<th>定休日</th>
			<td>
			<?php
			print $this->Form->input('business_holiday', array(
				'label' => false,
				'type' => 'text',
				'value' => (isset($data[$controller_camel_case]['business_holiday'])) ? $data[$controller_camel_case]['business_holiday'] : '年中無休',
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
					'value' => $data[$controller_camel_case]['catch_copy'],
					'class' => 'form-control',
					'maxlength' => '60',
					'placeholder' => '60文字以内'
				));
				?>
			</td>
		</tr>
		<tr>
			<th>女性会員数</th>
			<td>
				<?php
					print $this->Form->input('cnt_women', array(
						'label' => false,
						'type' => 'text',
						'value' => $data[$controller_camel_case]['cnt_women'],
						'class' => 'form-control'
					));
				?>
			</td>
			<th>男性会員数</th>
			<td>
				<?php
					print $this->Form->input('cnt_men', array(
						'label' => false,
						'type' => 'text',
						'value' => $data[$controller_camel_case]['cnt_men'],
						'class' => 'form-control'
					));
				?>
			</td>

		</tr>
		<tr>
			<th>紹介文<?= $this->common->getMust() ?></th>
			<td colspan="3">
				<?php
				print $this->Form->input('introduction', array(
					'label' => false,
					'type' => 'textarea',
					'value' => $data[$controller_camel_case]['introduction'],
					'class' => 'form-control',
					'style' => 'height: 300px'
				));
				?>
			</td>
		</tr>
		<tr>
			<th>入会資格</th>
			<td colspan="3">
				<?php
				print $this->Form->input('add_condition', array(
					'label' => false,
					'type' => 'textarea',
					'value' => $data[$controller_camel_case]['add_condition'],
					'class' => 'form-control',
					'style' => 'height: 300px'
				));
				?>
			</td>
		</tr>
		<tr>
			<th>入会金</th>
			<td colspan="2">
				<div class="cf">
					<div class="col span-6">
					<?php
						$add_fee = json_decode($data[$controller_camel_case]['add_fee'], true);
						// pr($add_fee);
						for ($i=0; $i<=5; $i++) {
							print $this->Form->input('add_fee][fee][' . $i . '][course', array(
								'type' => 'text',
								'class' => 'form-control',
								'value' => isset($add_fee['fee'][$i]['course']) ? $add_fee['fee'][$i]['course'] : '',
								'div' => false,
								'label' => false,
								'style' => 'margin-bottom: 2px;',
								'placeholder' => 'コース名' . ($i+1),
							));
						}
					?>
					</div>
					<div class="col span-6">
					<?php
						for ($i=0; $i<=5; $i++) {
							print '<div class="input-group">';
							print $this->Form->input('add_fee][fee][' . $i . '][price', array(
								'type' => 'text',
								'class' => 'form-control',
								'value' => isset($add_fee['fee'][$i]['price']) ? $add_fee['fee'][$i]['price']:'',
								'div' => false,
								'label' => false,
								'style' => 'margin-bottom: 2px;',
								'placeholder' => '料金' . ($i+1),
							));
							print '<span class="input-group-addon">円</span></div>';
						}
					?>
					</div>
				</div>
			</td>
			<td>
			<?php
				print $this->Form->input('add_fee][comment', array(
					'label' => false,
					'type' => 'textarea',
					'value' => isset($add_fee['comment']) ? $add_fee['comment']:'',
					'class' => 'form-control',
					'rows' => 6,
					'style' => 'height: 200px'
				));
				?>
			</td>
		</tr>
		<tr>
			<th>年会費</th>
			<td colspan="2">
				<div class="cf">
					<div class="col span-6">
					<?php
						$annual_fee = json_decode($data[$controller_camel_case]['annual_fee'], true);
						for ($i=0; $i<=5; $i++) {
							print $this->Form->input('annual_fee][fee][' . $i . '][course', array(
								'type' => 'text',
								'class' => 'form-control',
								'value' => isset($annual_fee['fee'][$i]['course']) ? $annual_fee['fee'][$i]['course'] : '',
								'div' => false,
								'label' => false,
								'style' => 'margin-bottom: 2px;',
								'placeholder' => 'コース名' . ($i+1),
							));
						}
					?>
					</div>
					<div class="col span-6">
					<?php
						for ($i=0; $i<=5; $i++) {
							print '<div class="input-group">';
							print $this->Form->input('annual_fee][fee][' . $i . '][price', array(
								'type' => 'text',
								'class' => 'form-control',
								'value' => isset($annual_fee['fee'][$i]['price']) ? $annual_fee['fee'][$i]['price']:'',
								'div' => false,
								'label' => false,
								'style' => 'margin-bottom: 2px;',
								'placeholder' => '料金' . ($i+1),
							));
							print '<span class="input-group-addon">円</span></div>';
						}
					?>
					</div>
				</div>
			</td>
			<td>
			<?php
				print $this->Form->input('annual_fee][comment', array(
					'label' => false,
					'type' => 'textarea',
					'value' => isset($annual_fee['comment']) ? $annual_fee['comment']:'',
					'class' => 'form-control',
					'rows' => 6,
					'style' => 'height: 200px'
				));
				?>
			</td>
		</tr>
		<tr>
			<th>セッティング料</th>
			<td colspan="2">
				<div class="cf">
					<div class="col span-6">
					<?php
						$setting_fee = json_decode($data[$controller_camel_case]['setting_fee'], true);
						for ($i=0; $i<=5; $i++) {
							print $this->Form->input('setting_fee][fee][' . $i . '][course', array(
								'type' => 'text',
								'class' => 'form-control',
								'value' => isset($setting_fee['fee'][$i]['course']) ? $setting_fee['fee'][$i]['course'] : '',
								'div' => false,
								'label' => false,
								'style' => 'margin-bottom: 2px;',
								'placeholder' => 'コース名' . ($i+1),
							));
						}
					?>
					</div>
					<div class="col span-6">
						<?php
							for ($i=0; $i<=5; $i++) {
								print '<div class="input-group">';
								print $this->Form->input('setting_fee][fee][' . $i . '][price', array(
									'type' => 'text',
									'class' => 'form-control',
									'value' => isset($setting_fee['fee'][$i]['price']) ? $setting_fee['fee'][$i]['price']:'',
									'div' => false,
									'label' => false,
									'style' => 'margin-bottom: 2px;',
									'placeholder' => '料金' . ($i+1),
								));
								print '<span class="input-group-addon">円</span></div>';
							}
						?>
					</div>
				</div>
			</td>
			<td>
			<?php
				print $this->Form->input('setting_fee][comment', array(
					'label' => false,
					'type' => 'textarea',
					'value' => isset($setting_fee['comment']) ? $setting_fee['comment']:'',
					'class' => 'form-control',
					'rows' => 6,
					'style' => 'height: 200px'
				));
				?>
			</td>
		</tr>
		<tr>
			<th style="white-space:nowrap">セッティング料方式</th>
			<td colspan="3">
				<?= $this->Form->input('setting_system', array(
					'label' => false,
					'type' => 'text',
					'value' => $data[$controller_camel_case]['setting_system'],
					'class' => 'form-control',
					'maxlength' => '60',
					'placeholder' => '60文字以内'
				));
				?>
			</td>
		</tr>
		<tr>
			<th colspan="4" class="sep_row">画像</th>
		</tr>
		<tr>
			<th>一覧用画像<br><span class="badge">100 x 100</span></th>
			<td colspan="3">
				<?php
				if (isset($data[$controller_camel_case]['img_list']) && $data[$controller_camel_case]['img_list'] != "") {
					print '<figure class="img-shops-li">';
					print '<img src="/img/shop/' . $data[$controller_camel_case]['img_list'] . '" >';
					print '</figure>';
					print $this->Form->input('img_list', array('type'=>'hidden','value'=>$data[$controller_camel_case]['img_list']));
					print '<br>';
					print "<a href=\"/admin/shop/delete_image/";
					print $data[$controller_camel_case]['id'] . DS . 'img_list' . DS;
					print '" onclick="return confirm(\'画像を削除してもよろしいですか？\');" class="btn btn-danger" style="float:right">';
					print '<i class="icon icon-remove"></i> 画像を削除する</a>';
				}
				?>
				<input type="file" name="data[img_list]">
				<input type="hidden" name="data[img_list]">
			</td>
		</tr>
		<tr>
			<th>詳細ページメイン画像<br><span class="badge">980 x 311</span></th>
			<td colspan="3">
				<?php
				if (isset($data[$controller_camel_case]['img_main']) && $data[$controller_camel_case]['img_main'] != "") {
					// list($width, $height) = getimagesize(IMAGES. 'shop' .DS . $data[$controller_camel_case]['img_main']);
					print '<figure class="img-shops-main">';
					print '<img src="/img/shop/' . $data[$controller_camel_case]['img_main'] . '">';
					print '</figure>';
					print $this->Form->input('img_main', array('type'=>'hidden','value'=>$data[$controller_camel_case]['img_main']));
					print '<br>';
					print "<a href=\"/admin/shop/delete_image/";
					print $data[$controller_camel_case]['id'] . DS . 'img_main' . DS;
					print '" onclick="return confirm(\'画像を削除してもよろしいですか？\');" class="btn btn-danger" style="float:right">';
					print '<i class="icon icon-remove"></i> 画像を削除する</a>';
				}
				?>
				<input type="file" name="data[img_main]">
				<input type="hidden" name="data[img_main]">
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
								'value' => $data[$controller_camel_case]['admin_name'],
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
								'value' => $data[$controller_camel_case]['admin_tel'],
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
								'value' => $data[$controller_camel_case]['admin_email'],
								'class' => 'form-control',
								'placeholder' => 'info@' . MYDOMAIN
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
		<tr id="admin_comment">
			<th>管理者備考</th>
			<td colspan="3">
				<?php
				print $this->Form->input('admin_comment', array(
					'label' => false,
					'type' => 'textarea',
					'value' => $data[$controller_camel_case]['admin_comment'],
					'class' => 'form-control'
				));
				?>
			</td>
		</tr>
		<?php
		}
		?>
	</table>

	<div class="form-actions" style="text-align:center">
		<button class="btn btn-lg btn-primary" type="submit" onclick="allSelected()"><i class="icon icon-ok"></i>&nbsp;登録する</button>
	</div>
	<?= $this->Form->end() ?>
</div>
