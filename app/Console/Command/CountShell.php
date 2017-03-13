<?php
App::uses('Shell', 'Console');
class CountShell extends Shell {
	public $uses = array(
		'Shop',
		'City',
		'Area',
		'Station',
		'Hotel',
	);

	/*
	 * 上位表示ボタンのリミットをリセットする
	 */
	function reset_to_top_limit() {
		/*
		 * 掲載プラン・継続掲載に応じたボーナス回数をセットする
		 *
		 */
		App::uses('AppController', 'Controller');
		$App = new AppController();
		$today = mktime(0, 0, 0, date("m"), date("d"), date("y"));
		foreach ($App->getPlans() as $k => $v) {
			// 無料プラン以外
			if ($k != 0) {
				$options = [
					'conditions' => [
						'Shop.plan_id' => $k,
					],
					'fields' => [
						'Shop.id',
						'Shop.created'
					],
					'order' => [
						'Shop.created' => 'ASC'
					],
					'recursive' => '-1'
				];
				$data = $this->Shop->find('all', $options);
				foreach ($data as $k2 => $v2) {
					$v2 = $v2['Shop'];
					$published  = strtotime($v2['created']);
					$date_range = ($today - $published) / 86400;
					if ($date_range >= 180) {
						$limit = -5;
					} else if ($date_range >= 150 && $date_range < 180) {
						$limit = -5;
					} else if ($date_range >= 120 && $date_range < 150) {
						$limit = -4;
					} else if ($date_range >= 90 && $date_range < 120) {
						$limit = -3;
					} else if ($date_range >= 60 && $date_range < 90) {
						$limit = -2;
					} else if ($date_range >= 30 && $date_range < 60) {
						$limit = -1;
					} else {
						$limit = 0;
					}
					// $this->out($v2['id'] . DS . substr($v2['created'], 0, 10) . DS . $date_range . DS . $limit);
					$this->Shop->id = $v2['id'];
					$this->Shop->saveField('cnt_to_top', $limit);
				}
			}
		}
		return;
	}

	/*
	 * 市区町村に何件のホテルがあるかカウントして、cities.cnt をアップデートする
	 */
	function hotels_city() {
		for ($i=1; $i<=47; $i++) {
			$options = [
				'conditions' => [
					'City.pref_id' => $i
				],
				'fields' => [
					'City.id'
				],
				'recursive' => '-1'
			];
			$data_cities = $this->City->find('all', $options);

			foreach ($data_cities as $v) {
				$v = $v['City'];
				$options = [
					'conditions' => [
						"Hotel.status" => "y",
						"Hotel.city_id" => $v['id']
					],
					'fields' => [
						'Hotel.id'
					],
					'recursive' => '-1'
				];
				$cnt_hotels = $this->Hotel->find('count', $options);

				$this->City->id = $v['id'];
				$this->City->saveField('cnt', $cnt_hotels);
			}
		}
	}

	/*
	 * 駅に何件のホテルがあるかカウントして、stations.cnt をアップデートする
	 */
	function hotels_station() {
		for ($i=1; $i<=47; $i++) {
			$options = [
				'conditions' => [
					'Station.pref_id' => $i
				],
				'fields' => [
					'Station.id',
				],
				'recursive' => '-1'
			];
			$data_stations = $this->Station->find('all', $options);

			foreach ($data_stations as $v) {
				$v = $v['Station'];
				$options = [
					'conditions' => [
						"Hotel.status" => "y",
						"Hotel.station_ids LIKE '%\"" .$v['id']. "\"%'"
					],
					'fields' => [
						'Hotel.id'
					],
					'recursive' => '-1'
				];
				$cnt_hotels = $this->Hotel->find('count', $options);

				$this->Station->id = $v['id'];
				$this->Station->saveField('cnt', $cnt_hotels);
			}
		}
	}

	/*
	 * エリアに何件のホテルがあるかカウントして、areas.cnt をアップデートする
	 */
	function hotels_area() {
		for ($i=1; $i<=47; $i++) {
			$options = [
				'conditions' => [
					'Area.pref_id' => $i
				],
				'fields' => [
					'Area.id'
				],
				'recursive' => '-1'
			];
			$data_areas = $this->Area->find('all', $options);

			foreach ($data_areas as $v) {
				$v = $v['Area'];
				$options = [
					'conditions' => [
						"Hotel.status" => "y",
						"Hotel.area_id" => $v['id']
					],
					'fields' => [
						'Hotel.id'
					],
					'recursive' => '-1'
				];
				$cnt_hotels = $this->Hotel->find('count', $options);

				$this->Area->id = $v['id'];
				$this->Area->saveField('cnt', $cnt_hotels);
			}
		}
	}

	/*
	 * イクリストのshopテーブルから新規登録店舗をインサート
	 */
	function insert_shops_from_ikulist() {
		$file = JSON_DIR . 'shop/' . date('Ymd') . '.json';
		if (file_exists($file)) {
			$json = file_get_contents($file);
			$ary_new_shops = json_decode($json, TRUE);
			foreach ($ary_new_shops as $shop) {
				$check = $this->Shop->find('first', [
					'conditions' => [
						'Shop.tel' => $shop['Shop']['tel'],
						'Shop.url' => $shop['Shop']['url']
					]
				]);
				if (!$check) {
					$data_shop = array();
					$data_shop = [
						'Shop' => [
							'status' => $shop['Shop']['status'],
							'status_discount' => $shop['Shop']['status_discount'],
							'status_credit_card' => $shop['Shop']['status_credit_card'],
							'plan_id' => 1,
							'user_id' => $shop['Shop']['user_id'],
							'agency_id' => $shop['Shop']['agency_id'],
							'job_id' => $shop['Shop']['job_id'],
							'name' => $shop['Shop']['name'],
							'pref_id' => $shop['Shop']['pref_id'],
							'city_id' => $shop['Shop']['city_id'],
							'city_ids' => $shop['Shop']['delivery'],
							'stations_ids' => $shop['Shop']['delivery_stations'],
							'delivery_fee' => $shop['Shop']['delivery_fee'],
							'pref' => $shop['Shop']['pref'],
							'city' => $shop['Shop']['city'],
							'tel' => $shop['Shop']['tel'],
							'business_time_start' => $shop['Shop']['business_time_start'],
							'business_time_end' => $shop['Shop']['business_time_end'],
							'business_time_start_hinode' => $shop['Shop']['business_time_start_hinode'],
							'business_time_end_last' => $shop['Shop']['business_time_end_last'],
							'business_time_24' => $shop['Shop']['business_time_24'],
							'business_holiday' => $shop['Shop']['business_holiday'],
							'total_min' => $shop['Shop']['total_min'],
							'price_min' => $shop['Shop']['price_min'],
							'price_board' => $shop['Shop']['price_board'],
							'fee_admission' => $shop['Shop']['fee_admission'],
							'fee_nomination' => $shop['Shop']['fee_nomination'],
							'fee_extension' => $shop['Shop']['fee_extension'],
							'fee_extension_min' => $shop['Shop']['fee_extension_min'],
							'fee_change' => $shop['Shop']['fee_change'],
							'fee_cancel' => $shop['Shop']['fee_cancel'],
							'fee_delivery_min' => $shop['Shop']['fee_delivery_min'],
							'fee_delivery_content' => $shop['Shop']['fee_delivery_content'],
							'play_basic' => $shop['Shop']['play_basic'],
							'play_option' => $shop['Shop']['play_option'],
							'url' => $shop['Shop']['url'],
							'url_sp' => $shop['Shop']['url_sp'],
							'discount_price' => $shop['Shop']['discount_price'],
							// 'discount_content' => $shop['Shop'][''],
							'coupon_content' => $shop['Shop']['coupon_content'],
							'comment' => $shop['Shop']['comment'],
							'catch_copy' => $shop['Shop']['catch_copy'],
							'description' => $shop['Shop']['description'],
							'card' => 0,
							'receipt' => 0,
							// 'status_credit_card' => $shop['Shop'][''],
							'cnt_pv' => $shop['Shop']['cnt_pv'],
							'cnt_to_top' => $shop['Shop']['cnt_to_top'],
							'to_top_datetime' => $shop['Shop']['to_top_datetime'],
							'admin_name' => $shop['Shop']['admin_name'],
							'admin_tel' => $shop['Shop']['admin_tel'],
							'admin_email' => $shop['Shop']['admin_email']
						]
					];
					$this->Shop->create();
					$this->Shop->save($data_shop);
				}
			}
			$this->out('インポートが完了しました！');
			unlink($file);
			return;
		} else{
			$this->out('ファイルがありません。');
			return;
		}
	}

}
