<?php
App::uses('AppController', 'Controller');
class HotelController extends AppController {
	public $name = 'Hotel';
	public $uses = array(
		'Hotel',
		'City',
		'Station',
		'ReviewUser',
		'IineUser',
		'Shop',
	);
	public $limit = 20;

	public function detail() {
		if (empty($this->data)) {
			$this->set('data', null);
		} else {
			$this->data = $this->preInsert($this->data);
			$this->ReviewUser->set($this->data);
			if ($this->ReviewUser->validates()) {
				$this->ReviewUser->save($this->data, false);
				$this->redirect($this->params->here . '#review');
			} else {
				$this->set('data', $this->data);
			}
		}
		// ホテル取得
		$hotel_type = $this->Hotel->getHotelTypes();
		$data_hotel = $this->Hotel->getHotel($this->params['pass'][0])['Hotel'];
		if (!$data_hotel) {
			throw new NotFoundException();
		}

		// ユーザーレビュー取得
		$data_reviews_user = $this->ReviewUser->getReviewsFromHotel($data_hotel['id']);
		// 都道府県
		$pref = $this->getPrefMeta($this->getPrefs('en')[$data_hotel['pref_id']]);
		// 市区町村
		$city_id = $data_hotel['city_id'];
		$data_city = $this->City->getCity($city_id)['City'];
		// 店舗取得
		$this->getJobs();
		$data_shops = $this->Shop->find('all', [
			'conditions' => [
				"Shop.status = 'y'",
				// "Shop.city_ids LIKE '%\"" .$city_id. "\":\"" .$city_id. "\"%'",
				"Shop.city_id =" .$data_city['id'] . " OR ". "Shop.city_ids LIKE '%\"" .$data_city['id']. "\"%'"
			],
			'fields' => [
				'Shop.id',
				'Shop.job_id',
				'Shop.name',
				'Shop.pref_id',
				'Shop.plan_id',
				'Shop.city',
				'Shop.tel',
				'Shop.catch_copy',
				'Shop.status_discount',
				'Shop.discount_bonus',
				'Shop.business_time_24',
				'Shop.business_time_start_hinode',
				'Shop.business_time_start',
				'Shop.business_time_end_last',
				'Shop.business_time_end',
				'Shop.business_holiday',
				'Shop.fee_delivery_min',
				'Shop.total_min',
				'Shop.img_list',
				'Shop.created',
			],
			'order' => [
				'Shop.to_top_datetime' => 'DESC'
			],
			'limit' => 30,
		]);
		$condition = [
				"Shop.status = 'y'",
				"Shop.city_id =" .$data_city['id'] . " OR ". "Shop.city_ids LIKE '%\"" .$data_city['id']. "\"%'"
		];
		$data_shops_s = $this->getShopsByPlan(3,$condition);
		$data_shops_a = $this->getShopsByPlan(2,$condition);
		// $data_shops = $this->paginate('Shop');
		// $this->prd($data_shops);
		// $data_shops = [];
		$cnt_shops = count($data_shops);
		// 駅取得
		$data_stations = Hash::combine($this->Station->getStationsForHotel(json_decode($data_hotel['station_ids'], true)), '{n}.Station.id', '{n}.Station.name');

		$this->pageInit();
		// パンくず
		$this->topicPath(
			[
				$pref['ja'],
				$data_city['name'] . 'のデリヘルを呼べるホテル',
				$data_hotel['name']
			],
			[
				DS . $pref['en'] . DS,
				DS . $pref['en'] . DS . 'city' . DS . $city_id . DS,
			]
		);
		$this->getBudget();
		$this->getStars();
		$this->getCall();
		$this->set([
			'data_shops_a' => $data_shops_a,
			'title' => $data_hotel['name'] . 'はデリヘルを呼べるか',
			'description' => $data_hotel['name'] . 'にデリヘルは呼べるのか？ユーザーの口コミと店舗からの派遣実績を元に総合評価。' . $data_hotel['address'],
			'hotel_type' => $hotel_type,
			'data_hotel' => $data_hotel,
			'data_city' => $data_city,
			'data_stations' => $data_stations,
			'data_reviews_user' => $data_reviews_user,
			'data_shops' => $data_shops,
			'cnt_shops' => $cnt_shops,
			'javascript' => []
		]);
		// $this->prd($data_shops);
	}

	public function admin_index()
	{
		if ($this->Session->read('User')['User']['id'] == 338) {
			$this->paginate['conditions'] = [
				'Hotel.status' => 'y',
				'Hotel.area_id IS NULL',
				'Hotel.type_id != 8'
			];
		}
		$this->paginate['order'] = [
			'Hotel.modified' => 'DESC'
		];
		$this->paginate['recursive'] = '-1';
		$data = $this->paginate();
		$this->set(compact('data'));
		$this->adminInit();
		$this->set([
			'scripts' => ['script_auto_complete_hotel_admin_index', 'script_keyboard_shortcut'],
			'javascript' => ['jquery.autocomplete'],
			'pg_num' => 24
		]);
	}

	/*
	 * 新規登録
	 */
	public function admin_add()
	{
		$this->set('data', null);
		$this->adminInit();
		$this->set([
			'hotel_types' => $this->Hotel->getHotelTypes(),
			'coordinate' => true,
			'stations_options' => null,
			'tags_options' => null,
			'javascript' => ['jquery.autocomplete'],
			'scripts_onload' => [
				'script_auto_complete_station',
			],
			'scripts' => [
				'script_hotel_admin',
			],
			'pickup_girl_ids' => [],
			'referer' => $this->referer()
		]);
	}

	/*
	 * 編集
	 */
	function admin_edit($id)
	{
		$data = $this->Hotel->find('first', [
			'conditions' => [
				'Hotel.id' => $id
			],
		]);

		$stations_options = [];
		if (!empty($data['Hotel']['station_ids'])) {
			$stations = json_decode($data['Hotel']['station_ids']);
			if ($stations != "") {
				foreach ($stations as $v) {
					$data_station = $this->Station->find('first', [
						'conditions' => [
							'Station.id' => $v
						],
						'fields' => [
							'Station.id',
							'Station.name'
						]
					]);
					$stations_options[$v] = $data_station['Station']['name'];
				}
			}
		}

		$this->set(compact('data', 'stations_options'));

		$this->adminInit();
		$this->set([
			'hotel_types' => $this->Hotel->getHotelTypes(),
			'coordinate' => true,
			'javascript' => ['jquery.autocomplete'],
			'scripts_onload' => [
				'script_auto_complete_station',
			],
			'scripts' => [
				'script_hotel_admin',
			],
			'referer' => $this->referer()
		]);
		$this->render('admin_add');
	}

	/*
	 * 代理店用
	 */
	function admin_agency($id) {
		$data = $this->Hotel->find('first', [
			'conditions' => [
				'Hotel.id' => $id
			],
			'recursive' => '-1'
		]);

		// CoverGirlHotelの取得。
		$pickup_girl_rows = $this->CoverGirlHotel->find('all', [
			'conditions' => [
				'CoverGirlHotel.hotel_id' => $data['Hotel']['id']
			],
			'recursive' => '-1'
		]);
		$pickup_girl_ids=array_map(function($r) { return $r['CoverGirlHotel']['girl_id']; }, $pickup_girl_rows);

		// 店舗名と嬢名を取得する
		$this->Girl->unbindModel([
			'hasMany' => [
				'GirlImage',
				'Schedule'
			]
		]);
		$cg_girls = $this->Girl->find('all', [
			'conditions' => [
				'Girl.id' => $pickup_girl_ids
			],
			'fields' => [
				'DISTINCT Girl.id',
				'Girl.shop_id',
				'Girl.name',
				'Shop.name',
			],
		]);

		$this->adminInit();
		$this->set(compact('data', 'cg_girls'));
	}

	/*
	 * 検索
	 */
	function admin_search() {
		$params = $this->params->query;
		// パラメータ調節(GET or POST)
		if (isset($this->data['Hotel']['q'])) {
			$q = $this->data['Hotel']['q'];
		} else if (isset($this->params['url']['q'])) {
			$q = urldecode($this->params['url']['q']);
		}
		$this->params->params['url']['q'] = urlencode($q);
		$this->paginate['conditions']['AND'] = [];

		// 都道府県
		if (isset($params['pref_id']) && $params['pref_id'] != 0) {
			$this->paginate['conditions']['AND'][] = ['Hotel.pref_id' => $params['pref_id']];
		}
		// フリーワード
		if (isset($params['q']) && $params['q'] != '') {
			$this->paginate['conditions']['AND'][] = "Hotel.id LIKE '%" .$q. "%' OR Hotel.name LIKE '%" .$q. "%'";
		}
		$this->paginate['limit'] = $this->limit;
		$this->paginate['recursive'] = '-1';
		$data = $this->paginate();

		if ($data) {
			$this->set(compact('data'));
			$this->set("result_caption", "検索結果：" .$q);
			$this->adminInit();
			$this->set(array(
				'query' => $this->params->query,
				'scripts' => array('script_auto_complete_hotel_admin_index', 'script_keyboard_shortcut'),
				'javascript' => array('jquery.autocomplete')
			));
			$this->render("admin_index");
		} else {
			$this->redirect("/admin/hotel/");
		}
	}

	/*
	 * 登録＆編集処理
	 */
	function admin_post() {
		if (isset($this->data)) {
			// バリデート
			$this->Hotel->set($this->data);
			if ($this->Hotel->validates()) {
				// DB 格納
				// 最寄り駅
				if ($this->request->data['Hotel']['isAgency'] == 0 && !empty($this->request->data['Hotel']['station_ids'])) {
					$this->request->data['Hotel']['station_ids'] = json_encode($this->request->data['Hotel']['station_ids']);
				}
				$this->Hotel->isNewInsert($this->data['Hotel']);
				$this->Hotel->save($this->data, false);
				// $this->redirect('/admin/hotel/');
				$this->redirect($this->data['Hotel']['referer']);
			} else {
				$stations_options = [];
				if (!empty($this->data['Hotel']['station_ids'])) {
					$stations = $this->data['Hotel']['station_ids'];
					foreach ($stations as $v) {
						$data_station = $this->Station->find('first', [
							'conditions' => [
								'Station.id' => $v
							],
							'fields' => [
								'Station.id',
								'Station.name'
							]
						]);
						$stations_options[$v] = $data_station['Station']['name'];
					}
				}
				$this->set(compact('stations_options'));

				$this->set('data', $this->data);
				$this->adminInit();
				$this->set([
					'hotel_types' => $this->Hotel->getHotelTypes(),
					'coordinate' => true,
					'javascript' => ['jquery.autocomplete'],
					'scripts_onload' => [
						'script_auto_complete_station',
					],
					'scripts' => [
						'script_hotel_admin',
					],
					'referer' => $this->data['Hotel']['referer']
				]);
				$this->render('admin_add');
			}
		} else {
			$this->redirect("/admin/");
		}
	}

	/*
	 * 画像削除
	 */
	public function admin_delete_image($id)
	{
		$dir = IMG_DIR . strtolower(implode("_", $this->explodeCase($this->name))) . DS;

		$data = $this->Hotel->findById($id);
		$data = $data[$this->name];
		$this->Hotel->id = $id;
		for ($i=1; $i<count($this->params['pass']); $i++) {
			if ($data[$this->params['pass'][$i]] != "") {
				unlink($dir . $data[$this->params['pass'][$i]]);
			}
			$this->Hotel->saveField($this->params['pass'][$i], "");
		}
		$this->Hotel->saveField('has_img', 0);
		$this->redirect('/admin/' .strtolower(implode("_", $this->explodeCase($this->name))). '/edit/' .$id);
	}

	/*
	 * 削除
	 */
	function admin_delete($id)
	{
		$data = $this->Hotel->findById($id);
		// レコード削除
		$this->Hotel->delete($id, true);
		$this->redirect(DS . 'admin' . DS .strtolower(implode("_", $this->explodeCase($this->name))) . DS);
	}

	function admin_auto_complete()
	{
		$this->needAuth = true;
		$this->autoRender = false;

		$q = $this->params['url']['q'];
		$options = array(
			'conditions' => array(
				"Hotel.name LIKE '%" .$q. "%'",
			),
			'fields' => array(
				'Hotel.id',
				'Hotel.name',
				'Hotel.pref_id'
			),
			'order' => array(
				'Hotel.name' => 'ASC'
			),
			'recursive' => '-1'
		);
		$data = $this->Hotel->find('all', $options);

		if (count($data) != 0) {
			$prefs = $this->getPrefs();
			foreach ($data as $v) {
				$v = $v['Hotel'];
				$result[] = $v['name'] . '|' . $v['id'] . '|' . $prefs[$v['pref_id']] . '|' . $v['name'];
			}
			return implode(PHP_EOL, $result);
		} else {
			return false;
		}
	}

	// 参考になった！
	function iine() {
		$this->autoRender = false;
		$p = $this->params['pass'];
		switch ($p[0]) {
			case 'user':
				$this->IineUser->save([
					'IineUser' => [
						'review_id' => $p[1],
						'ip' => $this->request->clientIP()
					]
				], false);
				$r = $this->IineUser->find('count', [
					'conditions' => [
						'review_id' => $p[1]
					]
				]);
				break;
			case 'shop':

				break;
			default:
				$r = false;
				break;
		}
		return $r;
	}
}
