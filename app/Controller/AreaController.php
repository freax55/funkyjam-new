<?php
App::uses('AppController', 'Controller');
class AreaController extends AppController {
	public $name = 'Area';
	public $uses = [
		'Area',
		'Shop',
		'City'
	];
	public $limit = 20;

	public function index()
	{

	}

	public function admin_index()
	{
		$data = $this->paginate();
		$this->set(compact('data'));
		$this->adminInit();
		$this->set([
			'scripts' => ['script_auto_complete_area', 'script_keyboard_shortcut'],
			'javascript' => ['jquery.autocomplete']
		]);
	}

	/*
	 * 新規登録
	 */
	public function admin_add() {
		$this->adminInit();
		$this->set('data', null);
		$this->set([
			'scripts' => [
				'script_area_admin',
			],
		]);
	}

	/*
	 * 編集
	 */
	function admin_edit($id) {
		$data = $this->Area->findById($id);
		$this->set('data', $data);
		if (!empty($data['Area']['city_ids'])) {
			$city_ids = json_decode($data['Area']['city_ids'], true);
			if (!empty($city_ids)) {
				foreach ($city_ids as $k => $v) {
					$data_city = $this->City->find('first', [
						'conditions' => [
							'City.id' => $k
						],
						'fields' => [
							'City.id',
							'City.name'
						]
					]);
					$data_cities[$k] = $data_city['City']['name'];
				}
			}
		}
		$this->adminInit();
		$this->set([
			'data_cities' => $data_cities,
			'scripts' => [
				'script_area_admin',
			],
		]);
		$this->render('admin_add');
	}

	/*
	 * 検索
	 */
	function admin_search()
	{
		// パラメータ調節(GET or POST)
		if (isset($this->data['Area']['q'])) {
			$q = $this->data['Area']['q'];
		} else if (isset($this->params['url']['q'])) {
			$q = urldecode($this->params['url']['q']);
		}
		$this->params->params['url']['q'] = urlencode($q);

		$this->paginate['conditions'] = array(
			"Area.name LIKE '%" .$q. "%'"
		);
		$this->paginate['limit'] = $this->limit;
		$data = $this->paginate();

		if ($data) {
			$this->set(compact('data'));
			$this->set("result_caption", "検索結果：" .$q);
			$this->adminInit();
			$this->set(array(
				'scripts' => array('script_auto_complete_area_admin_index', 'script_keyboard_shortcut'),
				'javascript' => array('jquery.autocomplete')
			));
			$this->render("admin_index");
		} else {
			$this->redirect("/admin/area/");
		}
	}

	/*
	 * 登録＆編集処理
	 */
	function admin_post() {
		if (isset($this->data)) {
			// バリデート
			$this->Area->set($this->data);
			if ($this->Area->validates()) {
				// 市区町村
				if (is_array($this->request->data['Area']['city_ids'])) {
					$city_ids = array_unique($this->request->data['Area']['city_ids']);
					foreach ($city_ids as $v) {
						$city_ids_insert[$v] = $v;
					}
					$this->request->data['Area']['city_ids'] = json_encode($city_ids_insert);
				} else {
					$this->request->data['Area']['city_ids'] = json_encode(array());
				}
				// 都道府県を変更した場合を考慮して、現在のpref_idを取得しておく
				if ($this->data['Area']['id'] != "") {
					$pref_id = $this->Area->find('first', [
						'conditions' => [
							'Area.id' => $this->data['Area']['id']
						],
						'fields' => [
							'Area.pref_id'
						]
					])['Area']['pref_id'];
				} else {
					$pref_id = "";
				}
				// DB 格納
				$this->Area->save($this->data, false);
				// JSONアップデート
				$this->_create_json($this->data['Area']['pref_id']);
				// 都道府県を変更した場合を考慮して、現在のpref_idでJSONを更新する
				if ($pref_id != "") {
					$this->_create_json($pref_id);
				}
				$this->redirect('/admin/area/');
			} else {
				$this->adminInit();
				$this->set('data', $this->data);
				$this->set([
					'scripts' => [
						'script_area_admin',
					],
				]);
				$this->render('admin_add');
			}
		} else {
			$this->redirect("/admin/");
		}
	}

	/*
	 * 削除
	 */
	function admin_delete($id) {
		$pref_id = $this->Area->find('first', [
			'conditions' => [
				'Area.id' => $id
			],
			'fields' => [
				'Area.pref_id'
			]
		])['Area']['pref_id'];
		// レコード削除
		$this->Area->delete($id, true);
		// JSONアップデート
		$this->_create_json($pref_id);
		$this->redirect($this->referer());
	}

	function _create_json($pref_id){
		$this->needAuth = true;
		$this->autoRender = false;

		$options = array(
			'conditions' => array(
				'Area.pref_id' => $pref_id
			),
			'fields' => array(
				'Area.id',
				'Area.pref_id',
				'Area.name',
			),
			'order' => array(
				'Area.pref_id' => 'ASC'
			)
		);
		$data = $this->Area->find('all', $options);
		$cnt = count($data);

		$areas = array();
		for ($i=0; $i<$cnt; $i++) {
			$d = $data[$i]['Area'];
			$areas[] = '{"area_id":' . $d['id'] . ',"name":"' . $d['name'] . '"}';
			$file_json = fopen(JSON_DIR_AREA .$pref_id. '.json', 'w+');
			fputs($file_json, '[' .implode(',', $areas). ']');
			fclose($file_json);
		}
	}

	function auto_complete() {
		$this->autoRender = false;

		$q = $this->params['url']['q'];
		$options = array(
			'conditions' => array(
				"Area.name LIKE '%" .$q. "%'",
			),
			'fields' => array(
				'Area.id',
				'Area.name',
				'Area.pref_id'
			),
			'order' => array(
				'Area.name' => 'ASC'
			)
		);
		$data = $this->Area->find('all', $options);

		if (count($data) != 0) {
			$prefs = $this->getPrefs();
			foreach ($data as $v) {
				$v = $v['Area'];
				$result[] = $v['name'] . '|' . $v['id'] . '|' . $prefs[$v['pref_id']] . '|' . $v['name'];
			}
			return implode(PHP_EOL, $result);
		} else {
			return false;
		}
	}
}
