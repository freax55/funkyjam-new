<?php
App::uses('Shell', 'Console');
class InportShell extends Shell {
	public $uses = array(
		'Club',
		'City',
		'Area',
		'Pref'
	);

	function check_exist($data) {
		if(isset($data) && !empty($data)) {
			return true;
		}
		return false;
	}

	/*
	 * スクレイピングデータから店舗データをimport
	 */
	function inport_clubs_from_json() {
		if (isset($this->args[0]) && $this->args[0] != "") {
			$file = JSON_DIR . 'club/' . $this->args[0] . '.txt';
			$note = '';
			if(file_exists($file)) {
				$json = file_get_contents($file);
				// jsonを配列にする前に改行を'++'に置き換え
				// $json = str_replace("\n", '++', $json);
				$ary_sc_clubs = json_decode($json, true);
				try {
					foreach($ary_sc_clubs as $club) {
						// 重複していればfalse
						$check_dup = true;
						// 名前が空=空データと判断してスキップ
						if ($club['name'] == '' || $club['name'] == null) {
							continue;
						} else {
							$check = $this->Club->find('first', [
								'conditions' => [
									'Club.name' => $club['name'],
								],
								'fields' => [
									'Club.id'
								]
							]);
							if($check) {
								$check_dup = false;
							}
						}
						// 重複チェック
						if($club['tel'] != '非公開') {
							$check = $this->Club->find('first', [
								'conditions' => [
									'Club.tel' => $club['tel'],
								],
								'fields' => [
									'Club.id'
								]
							]);
							if($check) {
								$check_dup = false;
							}
						} else {
							if($club['url'] != '非公開') {
								$check = $this->Club->find('first', [
									'conditions' => [
										'Club.url' => $club['url'],
									],
									'fields' => [
										'Club.id'
									]
								]);
								if($check) {
									$check_dup = false;
								}
							} else {
								// 電話番号も公式サイトも非公開=例外として記録してスキップ

								$note .= $club['name'] . "\n";
								continue;
							}
						}
						// 重複していなければインサート
						if($check_dup) {
							$insert = array();
							$admin_comment = '';
							if(preg_match('/^(\n|.)*[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}(\n|.)*$/', $club['tel']) === 0) {
								$club['tel'] = '';
								// 例外データとして記録
								$admin_comment .= '*tel* ' . $club['tel'] . "\n";
							}
							$club['url_mb'] = '';
							$club['url'] = trim($club['url']);
							$club['url_sp'] = trim($club['url_sp']);
							if($club['url'] != ' ' && !empty($club['url']) && $club['url'] != '非公開') {
								if($club['url_sp'] == $club['url']) {
									$club['url_sp'] = '';
									$club['url_mb'] = '';
								} else {
									if ($club['url_sp'] != ' ' && !empty($club['url_sp']) && $club['url_sp'] != '非公開'){
										if (strpos($club['url_sp'], '/mobile/') !== false || strpos($club['url_sp'], '/m/') !== false || strpos($club['url_sp'], '/i/') !== false) {
											$club['url_mb'] = $club['url_sp'];
											$club['url_sp'] = '';
											// リンク切れチェック
											$check_url_mb = @get_headers($club['url_mb']);
											if (empty($check_url_mb[0]) || strpos($check_url_mb[0], '200') === false || strpos($check_url_mb[0], 'OK') === false) {
												$admin_comment .= '*url_mb* *要リンクチェック* ' . $check_url_mb[0] . ' ' . $club['url_mb'] . "\n";
											}
										} else {
											$club['url_mb'] = '';
											// リンク切れチェック
											$check_url_sp = @get_headers($club['url_sp']);
											if (empty($check_url_sp[0]) || strpos($check_url_sp[0], '200') === false || strpos($check_url_sp[0], 'OK') === false) {
												$admin_comment .= '*url_sp* *要リンクチェック* ' . $check_url_sp[0] . ' ' . $club['url_sp'] . "\n";
											}
										}
									} else {
										$club['url_sp'] = '';
										$club['url_mb'] = '';
									}
								}
								// リンク切れチェック
								$check_url = @get_headers($club['url']);
								if (empty($check_url[0]) || strpos($check_url[0], '200') === false || strpos($check_url[0], 'OK') === false) {
									$admin_comment .= '*url* *要リンクチェック* ' . $check_url[0] . ' ' . $club['url'] . "\n";
								}
							} else {
								$club['url'] = '';
							}
							// 住所
							$pref_id = $city_id = 0;
							$club['address'] = trim($club['address']);
							if ($club['address'] == '') {
								if(isset($club['area'])) {
										$club['address'] = $club['area']; 
									}
								$admin_comment .= '*address* *住所要確認* ' . "\n";
							} else {
								if(strpos($club['address'], '市') === false && strpos($club['address'], '区') === false && strpos($club['address'], '都') === false && strpos($club['address'], '道') === false && strpos($club['address'], '府') === false && strpos($club['address'], '県') === false && strpos($club['address'], '郡') === false){
									$admin_comment .= '*address* *住所要確認* ' . $club['address'] . "\n";
									if(isset($club['area'])) {
										$club['address'] = $club['area']; 
									}
								} else {
									foreach($this->Pref->getPreflist() as $k_pref => $pref) {
										if(strpos($club['address'], $pref) !== false) {
											$pref_id = $k_pref;
											foreach($this->City->getCitieslist($pref_id) as $k_city => $city) {
												if(strpos($club['address'], $city) !== false) {
													$city_id = $k_city;
													break 2;
												}
											}
										} else {
											foreach($this->City->getCitieslist($k_pref) as $k_city => $city) {
												if(strpos($club['address'], $city) !== false) {
													$city_id = $k_city;
													$pref_id = $k_pref;
													break 2;
												}
											}
										}
									}
								}
							}
							// 営業時間
							if($this->check_exist($club['time'])) {
								$club['time'] = str_replace('：', ':', $club['time']);
								$ary_time = explode('～', $club['time']);
								if(count($ary_time) != 2) {
									$ary_time = ['', ''];
									$admin_comment .= '*time* *営業時間要確認* ' . $club['time'] . "\n";
								} else {
									if(mb_strlen($ary_time[0]) > 5) {
										$admin_comment .= '*time* *開始時刻要確認*' . $ary_time[0] . "\n";
										$ary_time[0] = '';
									}
									if(mb_strlen($ary_time[1]) > 5) {
										$admin_comment .= '*time* *終了時刻要確認*' . $ary_time[1] . "\n";
										$ary_time[1] = '';
									}
								}
							} else {
								$ary_time = ['', ''];
								$admin_comment .= '*time* *営業時間要確認* \n';
							}
							// 定休日
							if($this->check_exist($club['holiday'])) {
								if($club['holiday'] == '非公開' || $club['holiday'] == ' ') {
									$admin_comment .= '*holiday* *定休日要確認* ' . $club['holiday'] . "\n";	
									$club['holiday'] = '';
								}
							} else {
								$club['holiday'] = '';
								$admin_comment .= '*holiday* *定休日要確認* ' . "\n";
							}
							// 代表
							if(isset($club['manager'])) {
								if($this->check_exist($club['manager'])) {
									if($club['manager'] == '非公開' || $club['manager'] == ' ') {
										$admin_comment .= '*manager* ' . $club['manager'] . "\n";	
										$club['manager'] = '';
									}
								} else {
									$club['manager'] = '';
									$admin_comment .= '*manager* ' . "\n";
								}
							} else {
								$club['manager'] = '';
							}
							// メール
							if(!isset($club['mail'])){
								$club['mail'] = null;
							}
							if($this->check_exist($club['mail'])) {
								if($club['mail'] == '非公開' || $club['mail'] == ' ') {
									$admin_comment .= '*mail* ' . $club['mail'] . "\n";	
									$club['mail'] = '';
								}
							} else {
								$club['mail'] = '';
								$admin_comment .= '*mail* ' . "\n";
							}
							// 女性会員数
							if($this->check_exist($club['cnt_women'])) {
								if($club['cnt_women'] == '非公開' || $club['cnt_women'] == ' ') {
									$admin_comment .= '*cnt_women* ' . $club['cnt_women'] . "\n";	
									$club['cnt_women'] = '';
								}
							} else {
								$club['cnt_women'] = '';
								$admin_comment .= '*cnt_women* ' . "\n";
							}
							// 男性会員数
							if(!isset($club['cnt_men'])){
								$club['cnt_men'] = null;
							}
							if($this->check_exist($club['cnt_men'])) {
								if($club['cnt_men'] == '非公開' || $club['cnt_men'] == ' ') {
									$admin_comment .= '*cnt_men* ' . $club['cnt_men'] . "\n";	
									$club['cnt_men'] = '';
								}
							} else {
								$club['cnt_men'] = '';
								$admin_comment .= '*cnt_men* \n';
							}
							// 入会資格
							if($this->check_exist($club['add_condition'])) {
								if($club['add_condition'] == '非公開' || $club['add_condition'] == ' ') {
									$admin_comment .= '*add_condition* ' . $club['add_condition'] . "\n";	
									$club['add_condition'] = '';
								}
							} else {
								$club['add_condition'] = '';
								$admin_comment .= '*add_condition* ' . "\n";
							}
							// セッティング料方式
							if(!isset($club['setting_system'])){
								$club['setting_system'] = null;
							}
							if($this->check_exist($club['setting_system'])) {
								$club['setting_system'] = str_replace('セッティング料方式', '', $club['setting_system']);
								if($club['setting_system'] == '非公開' || $club['setting_system'] == ' ') {
									$club['setting_system'] = '';
								}
							} else {
								$club['setting_system'] = '';
								$admin_comment .= '*setting_system* ' . "\n";
							}
							// 入会金 各種料金は配列で記録
							if($this->check_exist($club['add_fee'])) {
								$ary_add_fee = array();
								$ary_add_fee = [
									'comment' => $club['add_fee'],
									'fee' => [
										0 => ['course' => '', 'price' => ''],
										1 => ['course' => '', 'price' => ''],
										2 => ['course' => '', 'price' => '']
									]
								];
							} else {
								$ary_add_fee = [
									'comment' => '',
									'fee' => [
										0 => ['course' => '', 'price' => ''],
										1 => ['course' => '', 'price' => ''],
										2 => ['course' => '', 'price' => '']
									]
								];
							}
							// 年会費
							if($this->check_exist($club['annual_fee'])) {
								$ary_annual_fee = array();
								$ary_annual_fee = [
									'comment' => $club['annual_fee'],
									'fee' => [
										0 => ['course' => '', 'price' => ''],
										1 => ['course' => '', 'price' => ''],
										2 => ['course' => '', 'price' => '']
									]
								];
							} else {
								$ary_annual_fee = [
									'comment' => '',
									'fee' => [
										0 => ['course' => '', 'price' => ''],
										1 => ['course' => '', 'price' => ''],
										2 => ['course' => '', 'price' => '']
									]
								];
							}
							// セッティング料
							if($this->check_exist($club['setting_fee'])) {
								$ary_setting_fee = array();
								$ary_setting_fee = [
									'comment' => $club['setting_fee'],
									'fee' => [
										0 => ['course' => '', 'price' => ''],
										1 => ['course' => '', 'price' => ''],
										2 => ['course' => '', 'price' => '']
									]
								];
							} else {
								$ary_setting_fee = [
									'comment' => '',
									'fee' => [
										0 => ['course' => '', 'price' => ''],
										1 => ['course' => '', 'price' => ''],
										2 => ['course' => '', 'price' => '']
									]
								];
							}
							$insert['Club'] = [
								'name' => $club['name'],
								'tel' => $club['tel'],
								'url' => $this->check_exist($club['url']) ? trim($club['url']) : '',
								'url_sp' => $this->check_exist($club['url_sp']) ? trim($club['url_sp']) : '',
								'url_mb' => $this->check_exist($club['url_mb']) ? trim($club['url_mb']) : '',
								'address' => $this->check_exist($club['address']) ? trim($club['address']) : '',
								'pref_id' => $pref_id,
								'city_id' => $city_id,
								'open' => $this->check_exist($ary_time[0]) ? $ary_time[0] : '',
								'close' => $this->check_exist($ary_time[1]) ? $ary_time[1] : '',
								'holiday' => trim($club['holiday']),
								'manager' => trim($club['manager']),
								'mail' => trim($club['mail']),
								'cnt_women' => trim($club['cnt_women']),
								'cnt_men' => trim($club['cnt_men']),
								'add_condition' => trim($club['add_condition']),
								'setting_system' => trim($club['setting_system']),
								'add_fee' => json_encode($ary_add_fee),
								'annual_fee' => json_encode($ary_annual_fee),
								'setting_fee' => json_encode($ary_setting_fee),
								'admin_comment' => $admin_comment
							];
							$this->Club->create();
							$this->Club->save($insert);
						}

					}//endforeach
					$this->out('JSONインポートが完了しました！');
					file_put_contents(JSON_DIR . 'club/' . date("m-d_H:i:s") . '.txt', $note);
					return;
				} catch (PDOException $e) {
					syslog(7, 'JSON import EXCEPTION ' . $e->getMessage());
					$this->error('Error!', $e->getMessage());
					return;
				}

			} else {
				// error jsonファイル無し
				$this->error('指定したファイルが存在しません。');
			}

		} else {
			// error 引数なし
			$this->error('ファイルを指定してください。');
		}



		// $dir =  JSON_DIR . 'club/';
		// $cnt_json = new Globlterator::count($dir);
		// if($cnt_json != 0) {
		// 	for ($i=1; $i<=$cnt_json; $i++) {
		// 		$json = file_get_contents($dir . $i . 'json');

		// 	}
		// }
		// $file = JSON_DIR . 'club/' . date('Ymd') . '.json';
		// if (file_exists($file)) {
		// 	$json = file_get_contents($file);
		// 	$ary_new_shops = json_decode($json, TRUE);
		// 	try{
		// 	foreach ($ary_new_shops as $shop) {
		// 		$check = $this->Shop->find('first', [
		// 			'conditions' => [
		// 				'Shop.tel' => $shop['Shop']['tel'],
		// 				'Shop.url' => $shop['Shop']['url']
		// 			]
		// 		]);
		// 		if (!$check) {
		// 			$data_shop = array();
		// 			$data_shop = [
		// 				'Shop' => [
		// 					'status' => $shop['Shop']['status'],
		// 					'status_discount' => $shop['Shop']['status_discount'],
		// 					'status_credit_card' => $shop['Shop']['status_credit_card'],
		// 					'plan_id' => 1,
		// 					'user_id' => $shop['Shop']['user_id'],
		// 					'agency_id' => $shop['Shop']['agency_id'],
		// 					'job_id' => $shop['Shop']['job_id'],
		// 					'name' => $shop['Shop']['name'],
		// 					'pref_id' => $shop['Shop']['pref_id'],
		// 					'city_id' => $shop['Shop']['city_id'],
		// 					'city_ids' => $shop['Shop']['delivery'],
		// 					'stations_ids' => $shop['Shop']['delivery_stations'],
		// 					'delivery_fee' => $shop['Shop']['delivery_fee'],
		// 					'pref' => $shop['Shop']['pref'],
		// 					'city' => $shop['Shop']['city'],
		// 					'tel' => $shop['Shop']['tel'],
		// 					'business_time_start' => $shop['Shop']['business_time_start'],
		// 					'business_time_end' => $shop['Shop']['business_time_end'],
		// 					'business_time_start_hinode' => $shop['Shop']['business_time_start_hinode'],
		// 					'business_time_end_last' => $shop['Shop']['business_time_end_last'],
		// 					'business_time_24' => $shop['Shop']['business_time_24'],
		// 					'business_holiday' => $shop['Shop']['business_holiday'],
		// 					'total_min' => $shop['Shop']['total_min'],
		// 					'price_min' => $shop['Shop']['price_min'],
		// 					'price_board' => $shop['Shop']['price_board'],
		// 					'fee_admission' => $shop['Shop']['fee_admission'],
		// 					'fee_nomination' => $shop['Shop']['fee_nomination'],
		// 					'fee_extension' => $shop['Shop']['fee_extension'],
		// 					'fee_extension_min' => $shop['Shop']['fee_extension_min'],
		// 					'fee_change' => $shop['Shop']['fee_change'],
		// 					'fee_cancel' => $shop['Shop']['fee_cancel'],
		// 					'fee_delivery_min' => $shop['Shop']['fee_delivery_min'],
		// 					'fee_delivery_content' => $shop['Shop']['fee_delivery_content'],
		// 					'play_basic' => $shop['Shop']['play_basic'],
		// 					'play_option' => $shop['Shop']['play_option'],
		// 					'url' => $shop['Shop']['url'],
		// 					'url_sp' => $shop['Shop']['url_sp'],
		// 					'discount_price' => $shop['Shop']['discount_price'],
		// 					// 'discount_content' => $shop['Shop'][''],
		// 					'coupon_content' => $shop['Shop']['coupon_content'],
		// 					'comment' => $shop['Shop']['comment'],
		// 					'catch_copy' => $shop['Shop']['catch_copy'],
		// 					'description' => $shop['Shop']['description'],
		// 					'card' => 0,
		// 					'receipt' => 0,
		// 					// 'status_credit_card' => $shop['Shop'][''],
		// 					'cnt_pv' => $shop['Shop']['cnt_pv'],
		// 					'cnt_to_top' => $shop['Shop']['cnt_to_top'],
		// 					'to_top_datetime' => $shop['Shop']['to_top_datetime'],
		// 					'admin_name' => $shop['Shop']['admin_name'],
		// 					'admin_tel' => $shop['Shop']['admin_tel'],
		// 					'admin_email' => $shop['Shop']['admin_email']
		// 				]
		// 			];
		// 			$this->Shop->create();
		// 			$this->Shop->save($data_shop);
		// 		}
		// 	}
		// 	$this->out('インポートが完了しました！');
		// 	unlink($file);
		// 	return;
		// } else{
		// 	$this->out('ファイルがありません。');
		// 	return;
		// }
	}

}
