<?php
App::uses('AppController', 'Controller');

class StationController extends AppController {
	public $name = 'Station';
	public $uses = array('Station', 'Shop');
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
			'scripts' => ['script_auto_complete_station_admin_index', 'script_keyboard_shortcut'],
			'javascript' => ['jquery.autocomplete']
		]);
	}

	/*
	 * 新規登録
	 */
	public function admin_add()
	{
		$this->set('data', null);
		$this->adminInit();
	}

	/*
	 * 編集
	 */
	function admin_edit($id)
	{
		$this->set('data', $this->Station->findById($id));
		$this->adminInit();
		$this->render('admin_add');
	}

	/*
	 * 検索
	 */
	function admin_search()
	{
		// パラメータ調節(GET or POST)
		if (isset($this->data['Station']['q'])) {
			$q = $this->data['Station']['q'];
		} else if (isset($this->params['url']['q'])) {
			$q = urldecode($this->params['url']['q']);
		}
		$this->params->params['url']['q'] = urlencode($q);

		$this->paginate['conditions'] = array(
			"Station.name LIKE '%" .$q. "%' OR Station.name_rome LIKE '%" .$q. "%'"
		);
		$this->paginate['limit'] = $this->limit;
		$data = $this->paginate();

		if ($data) {
			$this->set(compact('data'));
			$this->set("result_caption", "検索結果：" .$q);
			$this->adminInit();
			$this->set(array(
				'scripts' => array('script_auto_complete_station_admin_index', 'script_keyboard_shortcut'),
				'javascript' => array('jquery.autocomplete')
			));
			$this->render("admin_index");
		} else {
			$this->redirect("/admin/station/");
		}
	}

	/*
	 * 登録＆編集処理
	 */
	function admin_post()
	{
		if (isset($this->data)) {
			// バリデート
			if ($this->Station->create($this->data) && $this->Station->validates()) {
				// 都道府県を変更した場合を考慮して、現在のpref_idを取得しておく
				if ($this->data['Station']['id'] != "") {
					$pref_id = $this->Station->find('first', [
						'conditions' => [
							'Station.id' => $this->data['Station']['id']
						],
						'fields' => [
							'Station.pref_id'
						]
					])['Station']['pref_id'];
				} else {
					$pref_id = "";
				}
				// DB 格納
				$this->Station->save($this->data, false);
				// JSONアップデート
				$this->_create_json($this->data['Station']['pref_id']);
				// 都道府県を変更した場合を考慮して、現在のpref_idでJSONを更新する
				if ($pref_id != "") {
					$this->_create_json($pref_id);
				}
				$this->redirect('/admin/station/');
			} else {
				$this->set('data', $this->data);
				$this->adminInit();
				$this->render('admin_add');
			}
		} else {
			$this->redirect("/admin/");
		}
	}

	/*
	 * 削除
	 */
	function admin_delete($id)
	{
		$pref_id = $this->Station->find('first', [
			'conditions' => [
				'Station.id' => $id
			],
			'fields' => [
				'Station.pref_id'
			]
		])['Station']['pref_id'];
		$options = [
			'fields' => [
				'Shop.id',
				'Shop.delivery_stations'
			],
			'recursive' => '-1'
		];
		$data_shops = $this->Shop->find('all', $options);
		// 店舗から駅を削除
		foreach ($data_shops as $v) {
			$v = $v['Shop'];
			$delivery_stations = unserialize($v['delivery_stations']);
			if (isset($delivery_stations[$id]) && !empty($delivery_stations)) {
				unset($delivery_stations[$id]);
				$this->Shop->save([
					'Shop' => [
						'id' => $v['id'],
						'delivery_stations' => serialize($delivery_stations),
						'modified' => false
					]
				], false, ['delivery_stations']);
			}
		}
		// レコード削除
		$this->Station->delete($id, true);
		// JSONアップデート
		$this->_create_json($pref_id);
		$this->redirect($this->referer());
	}

	function _admin_name_rome(){
		App::import('Vendor', 'xml_to_array');

		$options = [
			'order' => [
				'Station.id' => 'ASC'
			],
			'fields' => [
				'Station.id',
				'Station.name_ruby'
			],
			'limit' => '2310,5'
		];
		$data = $this->Station->find('all', $options);

		$string = "";
		foreach ($data as $v) {
			$v = $v['Station'];
			// Yahoo!の自動ルビ振りAPIを呼び出す
			$url = 'http://jlp.yahooapis.jp/FuriganaService/V1/furigana?appid=dj0zaiZpPXRTcHgwN09hWXNQaiZkPVlXazlSMmRyVm1sa05tOG1jR285TUEtLSZzPWNvbnN1bWVyc2VjcmV0Jng9MDM-&sentence=' . urlencode($v['name_ruby']);

			$xml_data = file_get_contents($url);
			$xmlObj = new XmlToArray($xml_data);
			$arrayData = $xmlObj->createArray();

			$string = "";
			foreach ($arrayData['ResultSet']['Result'][0]['WordList'][0]['Word'] as $v2) {
				if (isset($v2['Roman'])) {
					$string.= $v2['Roman'];
				} else {
					$string.= $v2['Surface'];
				}
			}

			// DB 格納
			$this->Station->id = $v['id'];
			$this->Station->saveField('name_rome', $string);
		}
	}

	function _create_json($pref_id){
		$this->needAuth = true;
		$this->autoRender = false;

		$options = array(
			'conditions' => array(
				'Station.pref_id' => $pref_id
			),
			'fields' => array(
				'Station.id',
				'Station.pref_id',
				'Station.name',
				'Station.name_rome',
			),
			'order' => array(
				'Station.pref_id' => 'ASC'
			)
		);
		$data = $this->Station->find('all', $options);
		$cnt = count($data);

		$stations = array();
		for ($i=0; $i<$cnt; $i++) {
			$d = $data[$i]['Station'];
			$stations[] = '{"station_id":' . $d['id'] . ',"name":"' . $d['name'] . '","name_rome":"' . $d['name_rome'] . '"}';
			$file_json = fopen(JSON_DIR_STATION .$pref_id. '.json', 'w+');
			fputs($file_json, '[' .implode(',', $stations). ']');
			fclose($file_json);
		}
	}

	function auto_complete() {
		$this->autoRender = false;

		$q = $this->params['url']['q'];
		$options = array(
			'conditions' => array(
				"Station.name LIKE '%" .$q. "%' OR Station.name_ruby LIKE '%" .$q. "%' OR Station.name_rome LIKE '%" .$q. "%'",
			),
			'fields' => array(
				'Station.id',
				'Station.name',
				'Station.pref_id'
			),
			'order' => array(
				'Station.name' => 'ASC'
			)
		);
		$data = $this->Station->find('all', $options);

		if (count($data) != 0) {
			$prefs = $this->getPrefs();
			foreach ($data as $v) {
				$v = $v['Station'];
				$result[] = $v['name'] . '|' . $v['id'] . '|' . $prefs[$v['pref_id']] . '|' . $v['name'];
			}
			return implode(PHP_EOL, $result);
		} else {
			return false;
		}
	}
}
