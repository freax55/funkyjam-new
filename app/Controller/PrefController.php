<?php
App::uses('AppController', 'Controller');
class PrefController extends AppController {
	public $name = 'Pref';
	public $uses = array(
		'Club',
		'Area',
	);

	public function index() {
		$params = $this->params['pass'];
		$ary_url = explode('/', $this->params->url);
		// エリア一覧取得
		$this->getAreas();
		$list_area_pref_id = $this->Area->find('list', [
			'fields' => [
				'Area.id',
				'Area.pref_id'
			]
		]);
		// 都道府県
		$pref = $this->getPrefMeta($ary_url[0]);
		$pref_id = $pref['id'];
		$pref_name_ja = $pref['ja'];
		$pref_name_en = $pref['en'];
		$sep = SEP . "&nbsp;";
		// {pref_name}/area/{id}の時
		if(isset($params[0]) && $params[0] == 'area' && isset($params[1])) {
			if(!isset($list_area_pref_id[$params[1]]) || $list_area_pref_id[$params[1]] != $pref_id) {
				throw new NotFoundException();
			}
			$area_name = $this->Area->getAreaName($params[1]);
			if ($area_name != null) {
				$area_condition = [
					'Club.area_id' => $params[1],
					'Club.pref_id' => $pref_id
				];
				$page_area_name = $area_name;
				$h = $area_name;
			} else {
				// $this->prd($ary_url);
				throw new NotFoundException();
			}
		} else {
			// {pref_name}/の時
			if(!isset($params[0])) {
				$area_condition = [
					'Club.pref_id' => $pref_id
				];
				$page_area_name = $pref_name_ja;
				$h = $pref_name_ja;
			} else {
				throw new NotFoundException();
			}
		}
		$clubs = $this->Club->find('all', [
			'conditions' => [
				$area_condition
			],
			'fields' => [
				'id',
				'pref_id',
				'area_id',
				'name',
				'address',
				'tel',
				'open',
				'close',
				'time_comment',
				'holiday',
				'img_list',
				'img_list_sp',
				'cnt_women',
			]
		]);
		$cnt = count($clubs);
		// $this->prd($area_name);
		$this->pageInit();
		// パンくず
		// {pref_name}/area/{id}の時
		if(isset($params[0]) && $params[0] == 'area' && isset($params[1])) {
			$this->topicPath(
				[
					$pref_name_ja,
					$area_name . 'の交際クラブ',
				],
				[
					'/' . $pref_name_en . '/'
				]
			);
		// {pref_name}/の時
		} else {
			$this->topicPath(
				[
					$pref_name_ja . 'の交際クラブ',
				],
				[]
			);
		}
		$this->getBudget();
		$this->set([
			'title' => $page_area_name . 'の交際クラブを検索' . SITENAMEMETA,
			'h' => $h,
			'clubs' => $clubs,
			'cnt' => $cnt,
			'description'   => $pref['ja'] . DESCRIPTION,
			'right_column' => [
				'side_ad'
			],
			'left_column' => [
				'side_area_nav'
			]
		]);
		$this->layout = 'Pane3';
	}

	public function city() {
		// $options = [
		// 	'conditions' => [
		// 		'Shop.status' => 'y',
		// 		// 'Shop.created >=' => ONE_WEEK_AGO
		// 	],
		// 	'fields' => [
		// 		'Shop.id',
		// 		'Shop.name',
		// 		'Shop.plan_id',
		// 		'Shop.job_id',
		// 		'Shop.pref',
		// 		'Shop.city',
		// 		'Shop.pref_id',
		// 		'Shop.city_id',
		// 		'Shop.catch_copy',
		// 		'Shop.description',
		// 		'Shop.created',
		// 	],
		// 	'order' => [
		// 		'Shop.plan_id' => 'DESC',
		// 		'Shop.modified' => 'DESC',
		// 		'Shop.created' => 'DESC'
		// 	],
		// 	'recursive' => '-1'
		// ];
		//$data_shops = $this->Shop->find('first');

		// $this->prd($data_shops);
		// $this->prd($data_shops);
		// 都道府県
		$pref = $this->getPrefMeta(explode('/', $this->params->url)[0]);
		// 市区町村
		$city_id = $this->params['pass'][0];
		$data_city = $this->City->getCity($city_id)['City'];

		// ホテル
		$hotel_type = $this->Hotel->getHotelTypes();
		$data_hotels = $this->Hotel->getHotels($pref['id'], $city_id, 'city');

		$this->paginate['conditions']['AND'][] = [
			"Shop.status = 'y'",
			];
		// 市区
		$this->paginate['conditions']['AND'][] = " ( Shop.city_id =" .$data_city['id'] . " OR ". "Shop.city_ids LIKE '%\"" .$data_city['id'] . "\":{\"price%')";

		$this->paginate['fields'] = [
			'Shop.id',
			'Shop.name',
			'Shop.plan_id',
			'Shop.job_id',
			'Shop.pref_id',
			'Shop.city_id',
			'Shop.city_ids',
			'Shop.city',
			'Shop.img_list',
			'Shop.total_min',
			'Shop.tel',
			'Shop.created',
			'Shop.modified',
			'Shop.status_discount',
			'Shop.discount_bonus',
			'Shop.business_time_start',
			'Shop.business_time_end',
			'Shop.business_time_start_hinode',
			'Shop.business_time_end_last',
			'Shop.business_time_24',
			'Shop.business_holiday',
		];
		$this->paginate['order'] = [
		 		'Shop.plan_id' => 'DESC',
		 		'Shop.to_top_datetime' => 'DESC',
		];
		$this->paginate['recursive'] = '-1';
		$this->paginate['limit'] = LIMIT_SHOPS;
		$data_shops = $this->paginate('Shop');
		$data_shops_b = $this->paginate('Shop');
		$data_shops_a = $this->paginate('Shop');
		$data_shops_s = $this->paginate('Shop');
		$jobs = $this->getJobs();
		$cnt_total = $this->params['paging']['Shop']['count'];

		$dayuse = $is_dayuse = false;
		// 口コミ数でソートする
		foreach ($data_hotels as $v) {
			$h = $v['Hotel'];
			$hotels[$h['id']] = [
				'Hotel' => [
					'id' => $h['id'],
					'dayuse' => $h['dayuse'],
					'type_id' => $h['type_id'],
					'pref_id' => $h['pref_id'],
					'station_ids' => $h['station_ids'],
					'name' => $h['name'],
					'address' => $h['address'],
					'min_charge' => $h['min_charge'],
					'cnt' => count($v['ReviewUser'])
				]
			];
			// dayuse
			if (isset($this->params['pass'][1]) && $this->params['pass'][1] == 'dayuse') {
				if ($hotels[$h['id']]['Hotel']['dayuse'] == 'n') {
					unset($hotels[$h['id']]);
					$dayuse = true;
				}
			}
		}
		$data_hotels = Hash::sort($hotels, '{n}.Hotel.cnt', 'DESC');

		if (!empty(Hash::extract($hotels, '{n}.Hotel[dayuse=y]'))) {
			$is_dayuse = true;
		}

		// dayuse
		if ($dayuse) {
			$title = $data_city['name'] . 'のデイユースのあるデリヘルを呼べるホテル ' . SEP . SITENAMESHORT;
			$description = $pref['ja'] . $data_city['name'] . 'のデイユースのある' . DESCRIPTION;
		} else {
			$title = $data_city['name'] . 'のデリヘルを呼べるホテル ' . SEP . SITENAMESHORT;
			$description = $pref['ja'] . $data_city['name'] . 'の' . DESCRIPTION;
		}

		$this->pageInit();
		// パンくず
		$this->topicPath(
			[
				$pref['ja'] . 'のデリヘルを呼べるホテル',
				$data_city['name']
			],
			[
				DS . $pref['en'] . DS
			]
		);
		$this->getBudget();
		$condition = [
				"Shop.status = 'y'",
				"( Shop.city_id =" .$data_city['id'] . " OR ". "Shop.city_ids LIKE '%\"" .$data_city['id'] . "\":{\"price%' )"
		];
		$data_shops_s = $this->getShopsByPlan(3,$condition);
		$data_shops_a = $this->getShopsByPlan(2,$condition);
		$this->set([
			'data_shops_a' => $data_shops_a,
			'cnt_total' => $cnt_total,
			'jobs' => $jobs,
			'data_shops' => $data_shops,
			'title' => $title,
			'description' => $description,
			'hotel_type' => $hotel_type,
			'data_city' => $data_city,
			'data_hotels' => $data_hotels,
			'is_dayuse' => $is_dayuse,

		]);
	}

	public function station() {
		// 都道府県
		$pref = $this->getPrefMeta(explode('/', $this->params->url)[0]);
		// 駅
		$station_id = $this->params['pass'][0];
		$data_station = $this->Station->getStation($station_id)['Station'];
		// paginateで店舗呼び出す
		$this->paginate['conditions']['AND'][] = ["Shop.status = 'y'"];
		// 市区
		$this->paginate['conditions']['AND'][] = "Shop.station_ids LIKE '%\"" .$data_station['id']. "\"%'";

		$this->paginate['fields'] = [
			'Shop.id',
			'Shop.name',
			'Shop.plan_id',
			'Shop.job_id',
			'Shop.pref_id',
			'Shop.city_id',
			// 'Shop.city_ids',
			'Shop.city',
			'Shop.img_list',
			'Shop.total_min',
			'Shop.tel',
			// 'Shop.created',
			// 'Shop.modified',
			'Shop.status_discount',
			'Shop.discount_bonus',
			'Shop.business_time_start',
			'Shop.business_time_end',
			'Shop.business_time_start_hinode',
			'Shop.business_time_end_last',
			'Shop.business_time_24',
			// 'Shop.business_holiday',
		];
		$this->paginate['order'] = [
		 		'Shop.plan_id' => 'DESC',
		 		'Shop.to_top_datetime' => 'DESC',
		];
		$this->paginate['recursive'] = '-1';
		$this->paginate['limit'] = LIMIT_SHOPS;
		$data_shops = $this->paginate('Shop');
		$jobs = $this->getJobs();
		// ホテル
		$hotel_type = $this->Hotel->getHotelTypes();
		$data_hotels = $this->Hotel->getHotels($pref['id'], $station_id, 'station');

		$dayuse = $is_dayuse = false;
		// 口コミ数でソートする
		foreach ($data_hotels as $v) {
			$h = $v['Hotel'];
			$hotels[$h['id']] = [
				'Hotel' => [
					'id' => $h['id'],
					'dayuse' => $h['dayuse'],
					'type_id' => $h['type_id'],
					'pref_id' => $h['pref_id'],
					'station_ids' => $h['station_ids'],
					'name' => $h['name'],
					'address' => $h['address'],
					'min_charge' => $h['min_charge'],
					'cnt' => count($v['ReviewUser'])
				]
			];
			// dayuse
			if (isset($this->params['pass'][1]) && $this->params['pass'][1] == 'dayuse') {
				if ($hotels[$h['id']]['Hotel']['dayuse'] == 'n') {
					unset($hotels[$h['id']]);
					$dayuse = true;
				}
			}
		}
		$data_hotels = Hash::sort($hotels, '{n}.Hotel.cnt', 'DESC');

		if (!empty(Hash::extract($hotels, '{n}.Hotel[dayuse=y]'))) {
			$is_dayuse = true;
		}

		// dayuse
		if ($dayuse) {
			$title = $data_station['name'] . 'のデイユースのあるデリヘルを呼べるホテル' . SEP . SITENAMESHORT;
			$description = $pref['ja'] . $data_station['name'] . 'のデイユースのある' . DESCRIPTION;
		} else {
			$title = $data_station['name'] . 'のデリヘルを呼べるホテル' . SEP . SITENAMESHORT;
			$description = $pref['ja'] . $data_station['name'] . 'の' . DESCRIPTION;
		}

		$this->pageInit();
		// パンくず
		$this->topicPath(
			[
				$pref['ja'] . 'のデリヘルを呼べるホテル',
				$data_station['name']
			],
			[
				DS . $pref['en'] . DS
			]
		);
		$this->getBudget();
		$condition = [
				"Shop.status = 'y'",
				"Shop.station_ids LIKE '%\"" .$data_station['id']. "\"%'"
		];
		$data_shops_s = $this->getShopsByPlan(3,$condition);
		$data_shops_a = $this->getShopsByPlan(2,$condition);
		// $this->prd($data_station['id']);
		$this->set([
			'data_shops_a'=> $data_shops_a,
			'data_shops' => $data_shops,
			'title' => $title,
			'description' => $description,
			'hotel_type' => $hotel_type,
			'data_station' => $data_station,
			'data_hotels' => $data_hotels,
			'is_dayuse' => $is_dayuse
		]);
	}

}
