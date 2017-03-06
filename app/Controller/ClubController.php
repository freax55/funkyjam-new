<?php
App::uses('AppController', 'Controller');
App::uses('CommonHelper', 'View/Helper');
class ClubController extends AppController {
	public $name = 'Club';
	public $uses = array(
		'Club',
		'City',
		'Area',
		'User',
		'Pref',
		// 'Notice'
	);
	public $components = array('FileHandler');
	public $limit = 20;

	public function index() {
		throw new NotFoundException();
	}

	public function detail() {
		$this->CommonHelper = new CommonHelper(new View());
		$options = array(
			'conditions' => array(
				'Club.id' => $this->params['pass'][0]
			),
		);
		$data = $this->Club->find('first', $options);

		// 非公開設定された店舗は基本404、管理画面にログインされていれば表示する
		$show=0;
		if (!$data) {
			$show=0;
		} else if ($data['Club']['status'] == 'y') {
			$show=1;
		} else if ($this->Session->read('User')) {
			$show=1;
		} else {
			$show=0;
		}

		if ($show) {
			$d = $data['Club'];
			$prefs = $this->getPrefs();

			// パンくず生成のため、県名と市区町村名のローマ字を取得する
			$pref_name_en = $this->getPrefs('en')[$d['pref_id']];

			$area_name_ja = $this->Area->getAreaName($d['area_id']);
			$this->pageInit();
			$this->topicPath(
				[
					$prefs[$d['pref_id']],
					$area_name_ja . 'の交際クラブ',
					$d['name']
				],
				[
					'/' . $pref_name_en . '/',
					'/' . $pref_name_en . '/area/' . $d['area_id'] . '/',
				]
			);

			$set = [
				'scripts' => ['script_fixedbarbottom'],
				'data_club' => $data,
				// 'list_area' => $this->Area->find('list'),
				// 'business_time' => $business_time,
				'title' => $d['name'] . SEP . SITENAME,
				'pref_name_ja' => $prefs[$d['pref_id']],
				'pref_name_en' => $pref_name_en,
				'area_name' => $area_name_ja,
				'right_column' => [
					'side_ad'
				],
			];
			$this->layout = 'Pane2Right';
			$this->set($set);
		} else {
			throw new NotFoundException();
		}
	}

	public function admin_index() {
		// 店舗ユーザーだった場合、派遣実績登録を促す
		$user = $this->Session->read('User')['User'];
		if ($user['role_id'] == 4) {
			// ユーザーから店舗情報取得
			$data_club = $this->Club->find('first', [
				'conditions' => [
					'Club.user_id' => $user['id']
				],
				'fields' => [
					'Club.id',
					'Club.pref_id',
				],
				'recursive' => '-1'
			]);
		}

		// 掲載プランごとのtoTop残り回数を取得する
		// $this->getPlanToTopRemaining();
		// 代理店ユーザ or 店舗ユーザに応じた抽出をする
		$this->_getConditions((bool)true);
		$this->paginate['fields'] = [
			'Club.id',
			'Club.status',
			'Club.name',
			'Club.plan_id',
			'Club.pref_id',
			'Club.created',
			'Club.modified',
		];
		$this->paginate['order'] = [
			'Club.modified' => 'DESC'
		];
		$this->paginate['recursive'] = '-1';
		$this->paginate['limit'] = $this->limit;
		$data = $this->paginate();

		$cnt_total = $this->params['paging']['Club']['count'];
		$this->set(compact('data'));

		$this->adminInit();
		$this->set([
			'query' => false,
			'cnt_total' => $cnt_total,
			'javascript' => ['jquery.fancybox'],
			'scripts' => ['script_superbox', 'script_address_common', 'script_keyboard_shortcut'],
			'scripts_onload' => ['script_date_time_picker', 'script_tt_common']
		]);
	}

	function _getClub ($id) {
		$options = [
			'conditions' => [
				'Club.id' => $id,
				$this->_getConditions()
			],
			// 'recursive' => '-1'
		];
		return $this->Club->find('first', $options);
	}

	// 代理店ユーザ or 店舗ユーザに応じた抽出をする
	function _getConditions($isPaginate=null) {
		$role_id = $this->Session->read('User')['User']['role_id'];
		if ($isPaginate === true) {
			switch ($role_id) {
				case 3:
				case 4:
					return $this->paginate['conditions'] = [
						'OR' => [
							'Shop.agency_id' => $this->getUserId(),
							'Shop.user_id' => $this->getUserId()
						]
					];
					break;
			}
		} else {
			switch ($role_id) {
				case 3:
				case 4:
					return $conditions = [
						'OR' => [
							'Shop.agency_id' => $this->getUserId(),
							'Shop.user_id' => $this->getUserId()
						]
					];
					break;
			}
		}
	}

	/*
	 * 検索
	 */
	public function admin_search(){

		if (isset($this->params->query)) {
			$params = $this->params->query;
			// 権限に応じた抽出
			if (3 <= $this->getRoleId()) {
				$this->paginate['conditions'] = [
					'AND' => [
						'OR' => [
							'Club.agency_id' => $this->getUserId(),
							'Club.user_id' => $this->getUserId()
						]
					]
				];
			} else {
				$this->paginate['conditions']['AND'] = [];
			}

			// 都道府県
			if (isset($params['pref_id']) && $params['pref_id'] != 0) {
				$this->paginate['conditions']['AND'][] = ['Club.pref_id' => $params['pref_id']];
			}
			// 市区
			// if (isset($params['city_id']) && $params['city_id'] != 0) {
			// 	$this->paginate['conditions']['AND'][] = ['Club.city_id' => $params['city_id']];
			// }
			// フリーワード
			if (isset($params['q']) && $params['q'] != '') {
				$this->paginate['conditions']['AND'][] = "Club.id LIKE '%" .$params['q']. "%' OR Club.name LIKE '%" .$params['q']. "%' OR Club.url LIKE '%" .$params['q']. "%' OR Club.tel LIKE '%" .$params['q']. "%' OR Club.catch_copy LIKE '%" .$params['q']. "%' OR Club.introduction LIKE '%" .$params['q']. "%' OR Club.admin_comment LIKE '%" .$params['q']. "%' OR Club.admin_email LIKE '%" .$params['q']. "%'";
			}
			// 掲載開始日
			if (isset($params['start_date1']) && isset($params['start_date2']) && $params['start_date1'] != 0 && $params['start_date2'] != 0) {
				$this->paginate['conditions']['AND'][] = ['Club.created BETWEEN ? AND ?' => array($params['start_date1'] . ' 00:00:00', $params['start_date2'] . ' 23:59:59')];
			}
			// 公開
			if (isset($params['status']) && $params['status'] != 100) {
				$this->paginate['conditions']['AND'][] = ['Club.status' => $params['status']];
			}
			// 掲載プラン
			if (isset($params['plan_id']) && $params['plan_id'] != 100) {
				if ($params['plan_id'] == 99) {
					$this->paginate['conditions']['AND'][] = ['Club.plan_id != 0'];
				} else {
					$this->paginate['conditions']['AND'][] = ['Club.plan_id' => $params['plan_id']];
				}
			}
		} else {
			$this->redirect('/admin/club/');
		}

		$this->paginate['fields'] = [
			'Club.id',
			'Club.status',
			'Club.name',
			'Club.plan_id',
			'Club.pref_id',
			'Club.created',
			'Club.modified',
		];
		$this->paginate['order'] = [
			'Club.modified' => 'DESC'
		];
		$this->paginate['recursive'] = '-1';
		$this->paginate['limit'] = $this->limit;
		$data = $this->paginate();
		$cnt_total = $this->params['paging']['Club']['count'];

		// 業種取得
		$this->getJobs();
		// 掲載プランごとのtoTop残り回数を取得する
		$this->getPlanToTopRemaining();
		$this->set(compact('data'));
		$this->adminInit();
		$this->set([
			'query' => $params,
			'cnt_total' => $cnt_total,
			'javascript' => ['jquery.fancybox'],
			'scripts' => ['script_superbox', 'script_address_common', 'script_keyboard_shortcut'],
			'scripts_onload' => ['script_date_time_picker', 'script_shop_admin']
		]);
		$this->render("admin_index");
	}

	function _getTags(){
		$shop_tags = $this->ShopTag->find('list');
		return $shop_tags;
	}

	/*
	 * 新規登録
	 */
	public function admin_add() {
		$this->admin_basic();
	}

	/*
	 * 基本情報
	 */
	public function admin_basic() {
		$this->getPlans();
		$list_area = $this->Area->find('list');
		$list_pref = $this->getPrefs();
		// $this->prd($list_pref);

		// $this->prd($list);

		if (isset($this->data) && !empty($this->data)) {
			// 権限チェック
			$this->hasAuthority($this->name, 'post', $this->request->data['Club']['id']);
			// プリインサート処理
			$this->request->data['Club'] = $this->preInsert($this->request->data['Club']);
			// バリデート
			$this->Club->set($this->data);
			$this->Club->validate = $this->Club->validate_basic;
			if ($this->Club->validates()) {
				// DB 格納
				// Shop.user_id 日本語名からUser.idを取得する
				if ($this->request->data['Club']['user_id'] != "" && $this->request->data['Club']['user_id'] != "0") {
					$user_id = $this->User->find('first', [
						'conditions' => [
							'User.name' => $this->request->data['Club']['user_id']
						],
						'recursive' => '-1'
					]);
					if ($user_id) {
						$this->request->data['Club']['user_id'] = $user_id['User']['id'];
					}
				} else {
					$this->request->data['Club']['user_id'] = 0;
				}
				// 画像アップロード
				// if (isset($this->request->data['img_list']) && $this->request->data['img_list']['error'] == 0) {
				// 	$this->FileHandler->uploadImage('Club', $this->request->data['img_list'], 'img_list');
				// }
				// if (isset($this->request->data['img_main']) && $this->request->data['img_main']['error'] == 0) {
				// 	$this->FileHandler->uploadImage('Club', $this->request->data['img_main'], 'img_main');
				// }
				// Shop.agency_id 日本語名からUser.idを取得する
				if ($this->request->data['Club']['agency_id'] != "" && $this->request->data['Club']['agency_id'] != "0") {
					$agency_id = $this->User->find('first', [
						'conditions' => [
							'User.name' => $this->request->data['Club']['agency_id']
						],
						'recursive' => '-1'
					]);
					if ($agency_id) {
						$this->request->data['Club']['agency_id'] = $agency_id['User']['id'];
					}
				} else {
					$this->request->data['Club']['agency_id'] = 0;
				}
				$this->request->data['Club']['add_fee'] = json_encode($this->request->data['Club']['add_fee']);
				$this->request->data['Club']['annual_fee'] = json_encode($this->request->data['Club']['annual_fee']);
				$this->request->data['Club']['setting_fee'] = json_encode($this->request->data['Club']['setting_fee']);
				$this->request->data['Club']['url'] = rtrim($this->request->data['Club']['url'], "/");
				$this->Club->save($this->data, false);

				if($this->request->data['Club']['pref_id'] != 0) {
					$pref_cnt = $this->Club->find('count', [
						'conditions' => [
							'Club.pref_id' => $this->request->data['Club']['pref_id'],
							'Club.status' => 'y'
						]
					]);
					$update_pref = [
						'Pref' => [
							'id' => $this->request->data['Club']['pref_id'],
							'cnt' => $pref_cnt
						]
					];
					$this->Pref->save($update_pref);
				}

				if($this->request->data['Club']['area_id'] != 0) {
					$area_cnt = $this->Club->find('count', [
						'conditions' => [
							'Club.area_id' => $this->request->data['Club']['area_id'],
							'Club.status' => 'y'
						]
					]);
					$update_area = [
						'Area' => [
							'id' => $this->request->data['Club']['area_id'],
							'cnt' => $area_cnt
						]
					];
					$this->Area->save($update_area);
				}


				$this->redirect('/admin/club/');
				return;
			} else {
				$data = $this->data;
			}
		} else {
			$data = null;
			$this->params->data[$this->name]['created'] = date('Y-m-d H:i:s');
		}
		// 基本情報の編集
		if (isset($this->params['pass'][0])) {
			$id = $this->params['pass'][0];
			$data = $this->_getClub($id);
			if ($data) {
				// Shop.user_id 日本語名からUser.idを取得する
				if ($data['Club']['user_id'] != 0) {
					$user_id = $this->User->find('first', [
						'conditions' => [
							'User.id' => $data['Club']['user_id']
						]
					]);
					if ($user_id) {
						$data['Club']['user_id'] = $user_id['User']['name'];
					}
				}
				// Shop.agency_id 日本語名からUser.idを取得する
				if ($data['Club']['agency_id'] != 0) {
					$agency_id = $this->User->find('first', [
						'conditions' => [
							'User.id' => $data['Club']['agency_id']
						]
					]);
					if ($agency_id) {
						$data['Club']['agency_id'] = $agency_id['User']['name'];
					}
				}
			} else {
				throw new NotFoundException();
			}
		}
		$this->set('data', $data);
		$this->adminInit();
		$this->set([
			'timezone' => $this->Club->getTimeZone(),
			'list_area' => $list_area,
			'list_pref' => $list_pref,
			'javascript' => ['jquery.autocomplete'],
			'scripts_onload' => [
				'script_date_time_picker',
				'script_auto_complete_user',
			],
			'scripts' => [
				'script_shop_admin',
			],
		]);
		$this->render('admin_basic');
	}

	/*
	 * タグ設定
	 */
	// public function admin_tag($id) {
	// 	// 店タグカテゴリ取得
	// 	$this->getShopTagCategories();
	// 	// 嬢タグカテゴリ取得
	// 	$this->getGirlTagCategories();

	// 	if (isset($this->data) && !empty($this->data)) {
	// 		// 権限チェック
	// 		$this->hasAuthority($this->name, 'post', $this->request->data['Shop']['id']);
	// 		// プリインサート処理
	// 		$this->request->data['Shop'] = $this->preInsert($this->request->data['Shop']);

	// 		$shop_id = $this->request->data['Shop']['id'];

	// 		// 店舗タグ
	// 		if (is_array($this->request->data['Shop']['tags'])) {
	// 			$this->request->data['Shop']['tags'] = json_encode($this->request->data['Shop']['tags']);
	// 		} else {
	// 			$this->request->data['Shop']['tags'] = json_encode(array());
	// 		}
	// 		// 女の子タグ
	// 		if (is_array($this->request->data['Shop']['tags_girl'])) {
	// 			$this->request->data['Shop']['tags_girl'] = json_encode($this->request->data['Shop']['tags_girl']);
	// 		} else {
	// 			$this->request->data['Shop']['tags_girl'] = json_encode(array());
	// 		}

	// 		// バリデート
	// 		$this->Shop->set($this->data);
	// 		$this->Shop->validate = $this->Shop->validate_tag;
	// 		if ($this->Shop->validates()) {
	// 			// 店舗タグ
	// 			// $this->Shop->manageTags('shop', $this->request->data['Shop']['tags'], $shop_id);
	// 			// 女の子タグ
	// 			// $this->Shop->manageTags('girl', $this->request->data['Shop']['tags_girl'], $shop_id);
	// 			$this->Shop->save($this->data, false);

	// 			$this->redirect('/admin/shop/');
	// 			return;
	// 		} else {
	// 			$data = $this->data;
	// 		}
	// 	} else {
	// 		$data = $this->_getShop($id);
	// 	}
	// 	$this->set('data', $data);
	// 	$this->adminInit();
	// 	$this->set([
	// 		'data_shop_tags' => $this->ShopTag->find('tooltip'),
	// 		'data_girl_tags' => $this->GirlTag->find('tooltip'),
	// 	]);
	// }

	/*
	 * 料金設定
	 */
	// public function admin_price($id) {

	// 	if (isset($this->data) && !empty($this->data)) {
	// 		// 権限チェック
	// 		$this->hasAuthority($this->name, 'post', $this->request->data['Shop']['id']);
	// 		// プリインサート処理
	// 		$this->request->data['Shop'] = $this->preInsert($this->request->data['Shop']);

	// 		// 料金表
	// 		if (is_array($this->request->data['Shop']['price_board'])) {
	// 			$this->request->data['Shop']['price_board'] = serialize($this->request->data['Shop']['price_board']);
	// 		} else {
	// 			$this->request->data['Shop']['price_board'] = serialize(array());
	// 		}
	// 		// バリデート
	// 		$this->Shop->set($this->data);
	// 		$this->Shop->validate = $this->Shop->validate_price;
	// 		if ($this->Shop->validates()) {
	// 			// 総額計算
	// 			$this->request->data['Shop']['total_min'] = $this->request->data['Shop']['fee_admission'] + $this->request->data['Shop']['fee_nomination'] + $this->request->data['Shop']['fee_delivery_min'] + $this->request->data['Shop']['price_min'];
	// 			$this->Shop->save($this->data, false);
	// 			$this->redirect('/admin/shop/');
	// 			return;
	// 		} else {
	// 			$data = $this->data;
	// 		}
	// 	} else {
	// 		$data = $this->_getShop($id);
	// 	}
	// 	$this->set('data', $data);
	// 	$this->adminInit();
	// }

	// /*
	//  * 市区町村と交通費設定(イクリストからコピー)
	//  */
	// public function admin_area($id) {
	// 	$pref_ids = $area_ids = [];
	// 	$data_stations = $station_ids_insert = [];
	// 	$prefs_region = $this->getPrefsWithRegion();
	// 	$prefs_regions = [];
	// 	$prefs_cities  = [];
	// 	if (isset($this->data) && !empty($this->data)) {
	// 		// 権限チェック
	// 		$this->hasAuthority($this->name, 'post', $this->request->data['Shop']['id']);
	// 		// プリインサート処理
	// 		$this->request->data['Shop'] = $this->preInsert($this->request->data['Shop']);
	// 		// バリデート
	// 		$this->Shop->set($this->data);
	// 		$this->Shop->validate = $this->Shop->validate_area;
	// 		if ($this->Shop->validates()) {
	// 			// 派遣可能エリア
	// 			$prefs_cities = $this->data['Shop']['prefs_city'];
	// 			foreach ($prefs_cities as $pref_id => $city) {
	// 				foreach ($city as $city_id => $data) {
	// 					if ($data['price'] == "" && $data['memo'] == "") {
	// 						unset($prefs_cities[$pref_id][$city_id]);
	// 					}
	// 				}
	// 				if (empty($prefs_cities[$pref_id])) {
	// 					unset($prefs_cities[$pref_id]);
	// 				}
	// 			}
	// 			$this->request->data['Shop']['city_ids'] = json_encode($prefs_cities);
	// 			if ($this->request->data['Shop']['city_id'] != null) {
	// 				$ary_city_ids = [ 0 => $this->request->data['Shop']['city_id']];
	// 				if ($this->request->data['Shop']['city_ids'] != null && $this->request->data['Shop']['city_ids'] != '[]' && !empty($this->request->data['Shop']['city_ids'])) {
	// 					$ary_city_ids = array_unique(array_merge($ary_city_ids, $this->Shop->getCitiesByDelivery($this->request->data['Shop']['city_ids'])));
	// 				}
	// 			}
	// 			$ary_station_ids = $this->Station->getStationsByCities($ary_city_ids);
	// 			$data_shop = $this->data;
	// 			if ($ary_station_ids != false) {
	// 				$delivery_stations = $this->Station->convertArrayStations($ary_station_ids);
	// 				$data_shop['Shop']['station_ids'] = serialize($delivery_stations);
	// 			}
	// 			$this->Shop->save($data_shop, false);
	// 			$this->redirect('/admin/shop/');
	// 			return;
	// 		} else {
	// 			$data = $this->data;
	// 		}
	// 	} else {
	// 		$data = $this->_getShop($id);
	// 		// 地方取得
	// 		foreach ($prefs_region as $k => $v) {
	// 			if (in_array($data['Shop']['pref_id'], array_flip($v))) {
	// 				//エリア追加不可の場合は、出発地の県のみ設定可とする
	// 				// if ( $data['Shop']['status_add_area'] == 'n' ) {
	// 					foreach ($v as $pref_k => $pref_v) {
	// 						if ( $data['Shop']['pref_id'] != $pref_k ) {
	// 							unset($v[$pref_k]);
	// 						}
	// 					}
	// 				// }
	// 				$prefs_regions[$k] = $v;
	// 			}
	// 		}
	// 		// 市区町村取得
	// 		foreach (array_values($prefs_regions)[0] as $k => $v) {
	// 			$prefs_cities[$k] = $this->City->find('all', [
	// 				'conditions' => [
	// 					'City.pref_id' => $k
	// 				],
	// 				'fields' => [
	// 					'City.id',
	// 					'City.name'
	// 				],
	// 				'order' => [
	// 					'City.id' => 'ASC'
	// 				],
	// 				'recursive' => '-1'
	// 			]);
	// 		}
	// 		// if (!empty($data['Shop']['station_ids'])) {
	// 		// 	$station_ids = json_decode($data['Shop']['station_ids'], true);
	// 		// 	if (!empty($station_ids)) {
	// 		// 		foreach ($station_ids as $k => $v) {
	// 		// 			$data_station = $this->Station->find('first', [
	// 		// 				'conditions' => [
	// 		// 					'Station.id' => $k
	// 		// 				],
	// 		// 				'fields' => [
	// 		// 					'Station.id',
	// 		// 					'Station.name'
	// 		// 				]
	// 		// 			]);
	// 		// 			$data_stations[$k] = $data_station['Station']['name'];
	// 		// 		}
	// 		// 	}
	// 		// }
	// 	}
	// 	$this->set('data', $data);
	// 	$this->adminInit();
	// 	$set = [
	// 		'data_stations' => $data_stations,
	// 		'prefs_regions' => $prefs_regions,
	// 		'prefs_cities' => $prefs_cities,
	// 		'scripts' => ['script_shop_admin'],
	// 	];
	// 	$this->set($set);
	// }

	/*
	 * 画像削除
	 */
	public function admin_delete_image($id)
	{
		$dir = IMG_DIR . strtolower(implode("_", $this->explodeCase($this->name))) . DS;

		$data = $this->Shop->findById($id);
		$data = $data[$this->name];
		$this->Shop->id = $id;
		for ($i=1; $i<count($this->params['pass']); $i++) {
			if ($data[$this->params['pass'][$i]] != "") {
				unlink($dir . $data[$this->params['pass'][$i]]);
			}
			$this->Shop->saveField($this->params['pass'][$i], "");
		}
		$this->redirect('/admin/' .strtolower(implode("_", $this->explodeCase($this->name))). '/basic/' .$id);
	}

	/*
	 * 削除
	 */
	public function admin_delete($id)
	{
		// 権限チェック
		$this->hasAuthority($this->name, 'delete');

		$club = $this->Club->find('first', [
			'conditions' => [
				'Club.id'  => $id
			],
			'fields' => [
				 'Club.pref_id',
				 'Club.area_id'
			]
		])['Club'];
		// レコード削除
		$this->Club->delete($id, true);

		if($club['pref_id'] != 0) {
			$pref_cnt = $this->Club->find('count', [
				'conditions' => [
					'Club.pref_id' => $club['pref_id'],
					'Club.status' => 'y'
				]
			]);
			$update_pref = [
				'Pref' => [
					'id' => $club['pref_id'],
					'cnt' => $pref_cnt
				]
			];
			$this->Pref->save($update_pref);
		}

		if($club['area_id'] != 0) {
			$area_cnt = $this->Club->find('count', [
				'conditions' => [
					'Club.area_id' => $club['area_id'],
					'Club.status' => 'y'
				]
			]);
			$update_area = [
				'Area' => [
					'id' => $club['area_id'],
					'cnt' => $area_cnt
				]
			];
			$this->Area->save($update_area);
		}

		$this->redirect(DS . 'admin' . DS .strtolower(implode("_", $this->explodeCase($this->name))) . DS);
	}

	function _admin_total_min(){
		$options = [
			'conditions' => [
				'Shop.pref_id' => 13,
				'Shop.total_min' => NULL
			],
			'fields' => [
				'Shop.id',
				'Shop.fee_admission',
				'Shop.fee_nomination',
				'Shop.fee_delivery_min',
				'Shop.price_min',
				'Shop.discount_price',
			],
			'recursive' => '-1',
		];
		$data = $this->Shop->find('all', $options);
		foreach ($data as $v) {
			$v = $v['Shop'];
			$this->Shop->id = $v['id'];
			$total_min = $v['fee_admission'] + $v['fee_nomination'] + $v['fee_delivery_min'] + $v['price_min'] + $v['discount_price'];
			$this->Shop->saveField('total_min', $total_min);
		}
	}

	function _admin_sum_girls(){
		$this->Shop->hasMany['Girl']['fields'] = [
			'Girl.id'
		];
		$options = [
			'conditions' => [
				'Shop.pref_id' => 13,
			],
			'fields' => [
				'Shop.id',
				'Shop.fee_admission',
				'Shop.fee_nomination',
				'Shop.fee_delivery_min',
				'Shop.price_min',
				'Shop.discount_price',
			],
//			'limit' => 10,
		];
		$data = $this->Shop->find('all', $options);
		foreach ($data as $v) {
			$this->Shop->id = $v['Shop']['id'];
			$this->Shop->saveField('cnt_girls', count($v['Girl']));
		}
	}

	function _admin_business_time(){
		$options = [
			// 'conditions' => [
			// ]
			'fields' => [
				'Shop.id',
				'Shop.name',
				'Shop.business_time'
			],
			'recursive' => '-1',
			'order' => [
				'Shop.id' => 'ASC'
			],
//			'limit' => '10, 100'
		];
		$data = $this->Shop->find('all', $options);
//		$this->prd($data);

		foreach ($data as $v) {
			$this->Shop->id = $v['Shop']['id'];
			if ($v['Shop']['business_time'] == '〜' && $v['Shop']['business_time'] == '') {

			} else {
				if (strpos($v['Shop']['business_time'], '24時間') !== false) {
					$this->Shop->saveField('business_time_24', true);
				} else {
					$arr = explode('〜', $v['Shop']['business_time']);

					if (strpos($v['Shop']['business_time'], '日の出') !== false) {
						$this->Shop->saveField('business_time_start_hinode', true);
					} else {
						$this->Shop->saveField('business_time_start', sprintf("%02d", mb_substr($arr[0], 0, 2)) . ':' . substr(explode(":", $v['Shop']['business_time'])[1], 0, 2));
					}
					if (strpos($v['Shop']['business_time'], 'LAST') !== false) {
						$this->Shop->saveField('business_time_end_last', true);
					} else {
						if (strpos($v['Shop']['business_time'], '翌') !== false) {
							$this->Shop->saveField('business_time_end', sprintf("%02d", mb_substr($arr[1], 1, 1)) . ':' . substr(explode(":", $v['Shop']['business_time'])[2], 0, 2));
						} else {
							$this->Shop->saveField('business_time_end', sprintf("%02d", mb_substr($arr[1], 0, 2)) . ':' . substr(explode(":", $v['Shop']['business_time'])[2], 0, 2));
						}
					}
				}
			}
		}
		$this->prd($data);
	}

	function _admin_get_pref(){
		$prefs = $this->getPrefs();
		echo '<pre>';
		foreach ($prefs as $k => $v) {
			echo "UPDATE shops SET shops.pref = '" .$v. "' WHERE shops.pref_id = " .$k. " AND shops.pref IS NULL;\r\n";
		}
		echo '</pre>';
		exit;
	}

	// 上位表示
	function to_top() {
		$this->autoRender = false;
		$options = array(
			'conditions' => array(
				'Shop.id' => $this->params['pass'][0]
			),
			'fields' => array(
				'Shop.id',
				'Shop.plan_id',
				'Shop.cnt_to_top'
			)
		);
		$data = $this->Shop->find('first', $options);
		$d = $data['Shop'];
		if ($d) {
			if ($this->getPlanToTopRemaining()[$d['plan_id']] > $d['cnt_to_top']) {
				$this->Shop->save(array(
					'Shop' => array(
						'id' => $d['id'],
						'cnt_to_top' => $d['cnt_to_top'] + 1,
						'to_top_datetime' => date('Y-m-d H:i:s'),
						'modified' => false
					)
				), false, array(
					'cnt_to_top',
					'to_top_datetime'
				));
			}
		}
		return true;
	}

	function get_to_top_count() {
		$this->autoRender = false;
		$options = array(
			'conditions' => array(
				'Shop.id' => $this->params['pass'][0]
			),
			'fields' => array(
				'Shop.id',
				'Shop.plan_id',
				'Shop.cnt_to_top'
			)
		);
		$data = $this->Shop->find('first', $options);
		$d = $data['Shop'];
		if ($d) {
			// if ($d['plan_id'] == 3) {
			// 	$to_top_remaining = '無制限';
			// } else {
			// 	$to_top_remaining = '残' . ($this->getPlanToTopRemaining()[$d['plan_id']] - $d['cnt_to_top']) . '回';
			// }
			$to_top_remaining = '残' . ($this->getPlanToTopRemaining()[$d['plan_id']] - $d['cnt_to_top']) . '回';
			// 上限に達したか否か
			if ($this->getPlanToTopRemaining()[$d['plan_id']] <= $d['cnt_to_top']) {
				return (int)0;
			} else {
				return $to_top_remaining;
			}
		}
	}

	function convertToJson(){
		$this->autoRender = false;
		$options = [
			'fields' => [
				'Shop.id',
				'Shop.city_ids',
				'Shop.station_ids',
				'Shop.area_ids',
				'Shop.tags',
				'Shop.tags_girl_default',
				'Shop.delivery_fee',
				'Shop.price_board',
			],
			'order' => [
				'Shop.id' => 'ASC'
			],
			// 'limit' => 20,
			'recursive' => '-1'
		];
		$data = $this->Shop->find('all', $options);

		foreach ($data as $v) {
			$v = $v['Shop'];
			$this->Shop->id = $v['id'];

			$this->Shop->saveField('price_board', json_encode(unserialize($v['price_board'])));
			// $this->Shop->saveField('delivery_fee', json_encode(unserialize($v['delivery_fee'])));
			// $this->Shop->saveField('tags_girl_default', json_encode(unserialize($v['tags_girl_default'])));
			// $this->Shop->saveField('tags', json_encode(unserialize($v['tags'])));

			// $city_ids = json_encode(unserialize($v['city_ids']));
			// $this->Shop->saveField('city_ids', $city_ids);

			// $area_ids = json_encode(json_decode($v['area_ids'], true));
			// $this->Shop->saveField('area_ids', $area_ids);

			// $station_ids = json_encode(unserialize($v['station_ids']));
			// $this->Shop->saveField('station_ids', $station_ids);

			// $this->prd($v);
		}
	}
}
