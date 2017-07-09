<?php
App::uses('AppController', 'Controller');
class DiscographyDataController extends AppController {
	public $name = 'DiscographyData';
	public $uses = array('Discography');
	public $components = array('FileHandler');
	public $limit = 15;

	// public function admin_index()
	// {
	// 	$this->autoRender = false;
	// }
	// public function _index_data()

	public function index($artist,$type,$sort='DESC'){
		$this->_check_referer();
		$limit = 100;
		$extend = [
			'conditions' => [
				'type' => $type
			],
			'order' => [
				'relase' => $sort,
			],
			'limit' => $limit
		];
		$this->paginate = $this->Discography->getOptions($artist, $extend);
		$data = $this->paginate('Discography');
		$this->set([
			'data' => $data,
			'artist' => $artist,
			'type' => $type
		]);
		$this->layout = 'SuperBox';
		// $this->prd($data);




		// $data = $this->
	}

	function _check_referer(){
		$referer = $this->referer();
		$check = [
			strpos($referer, 'wp-admin/admin.php?page=fj_edit_and_add_discography.php'),
			strpos($referer, MYDOMAIN . '/discography_data/'),
			strpos($referer, MYDOMAIN_DEV . '/discography_data/'),

		];
		foreach($check as $v) {
			if($v !== false) {
				return;
			}
		}
		$this->redirect("/");
	}

	/*
	 * 新規登録
	 */
	public function add($artist,$type)
	{
		$this->_check_referer();
		$this->set('data', null);
		$this->adminInit();
		$this->layout = 'SuperBox';
		$this->set([
			// 'javascript' => ['jquery.autocomplete'],
			// 'scripts_onload' => [
			// 	'script_auto_complete_shop',
			// ],
			// 'scripts' => [
			// 	'script_banner_admin',
			// ],
			// 'banner_types' => $this->Banner->getBannerTypes(true)
		]);
	}

	/*
	 * 編集
	 */
	function edit($artist,$type,$id)
	{
		$this->_check_referer();
		$data = $this->Discography->findById($id);

		$this->set('data', $data);
		$this->adminInit();
		$this->layout = 'SuperBox';
		$this->set([
			'artist' => $artist,
			'type' => $type
			// 'javascript' => ['jquery.autocomplete'],
			// 'scripts_onload' => [
			// 	'script_auto_complete_shop',
			// ],
			// 'scripts' => [
			// 	'script_banner_admin',
			// ],
			// 'banner_types' => $this->Banner->getBannerTypes(true)
		]);
		$this->render('add');
	}

	/*
	 * 登録＆編集処理
	 */
	function post() {
		$this->_check_referer();
		if (isset($this->data) && !empty($this->data)) {
			// $this->prd($this->data);
			// // バリデート
			$this->Discography->set($this->data);
			$valid = $this->Discography->validates();
			// 画像バリデート
			// $error_msg = unserialize(ERROR_MSG);
			// switch ($this->data['Banner']['type_id']) {
			// 	case 1:
			// 	case 2:
			// 	case 3:
			// 		if (!$this->validImage($this->data['img_pc'], ['size'=>500])) {
			// 			$this->Banner->invalidate('img_pc', $error_msg['SIZE']);
			// 			$valid = 0;
			// 		}
			// 		break;
			// }
			if ($valid) {
				// 画像アップロード
				// if ($this->request->data['img_pc']['error'] == 0) {
				// 	// $this->request->data['Banner']['img'] = $this->FileHandler->uploadImage('Banner', $this->request->data['img'], 'img');
				// 	$this->FileHandler->uploadImage('Banner', $this->request->data['img_pc'], 'img_pc');
				// }
				// if ($this->request->data['img_sp']['error'] == 0) {
				// 	// $this->request->data['Banner']['img_sp'] = $this->FileHandler->uploadImage('Banner', $this->request->data['img_sp'], 'img_sp');
				// 	$this->FileHandler->uploadImage('Banner', $this->request->data['img_sp'], 'img_sp');
				// }
				// // Banner.shop_id 日本語名からShop.idを取得する
				// if ($this->request->data['Banner']['shop_id'] != "" && $this->request->data['Banner']['shop_id'] != "0") {
				// 	$shop_id = $this->Shop->find('first', [
				// 		'conditions' => [
				// 			'Shop.name' => $this->request->data['Banner']['shop_id']
				// 		],
				// 		'recursive' => '-1'
				// 	]);
				// 	if ($shop_id) {
				// 		$this->request->data['Banner']['shop_id'] = $shop_id['Shop']['id'];
				// 	}
				// } else {
				// 	$this->request->data['Banner']['shop_id'] = 0;
				// }
				// $this->request->data['Banner']['pref_id'] = $shop_id['Shop']['pref_id'];
				// $this->request->data['Banner']['area_ids'] = $shop_id['Shop']['area_ids'];
				// // pref_idsは後々店舗所在都道府県以外のページに表示させたい要望に対応する(現在は1店舗につき1つ)
				// for ($i = 1; $i <= 47; $i++) {
				// 	if ($i == $shop_id['Shop']['pref_id']) {
				// 		$pref_ids[$i] = "1";
				// 	} else {
				// 		$pref_ids[$i] = "0";
				// 	}
				// }
				// if()
				$release_string = $this->data['Discography']['release_multi1'] . ((!empty($this->data['Discography']['release_multi2']))?("\n" . $this->data['Discography']['release_multi2']):'');
				$this->request->data['Discography']['release_multi'] = json_encode(explode("\n", $release_string));
				$this->request->data['Discography']['link'] = json_encode(explode("\n", $this->data['Discography']['link']));
				if(!empty($this->data['Discography']['tracks'])){
					$ary_tracks = explode("\n", $this->data['Discography']['tracks']);
					$tracks = [];
					foreach($ary_tracks as $v) {
						$tag = 'li';
						$tt = $v;
						if(substr($v, 0, 4) == 'sh::'){
							$tag = 'p';
							$tt = substr($tt,4);
						}
						$tracks[] = ['tag' => $tag, 'tt' => $tt];
					}
					$this->request->data['Discography']['tracks'] = json_encode($tracks);
				}
				// DB 格納
				// $saveField = [
				// 	'discograpy_id',
				// 	'status',
				// 	'title',
				// 	'label',
				// 	'release_multi',
				// 	'link',
				// 	'tracks',
				// 	'',
				// 	'',
				// 	'',
				// 	'',
				// 	'',
				// ];
				if(empty($this->data['Discography']['discography_id'])){
					$this->prd($this->data['Discography']['discography_id']);
					$this->Discography->create();
				} else {
					$this->Discography->id = $this->data['Discography']['discography_id'];
				}
				$this->Discography->save($this->request->data['Discography'], false);
				$this->redirect('/discography_data/index/' . $this->data['Discography']['artist'] . '/' . $this->data['Discography']['type'] . '/');
			} else {
				$this->set('data', $this->data);
				$this->adminInit();
				$this->set([
				]);
				$this->render('add');
			}
		} else {
			$this->redirect("/discography_data/error/");
		}
	}

	function error() {
		$this->autoRender = false;
		$this->layout = 'SuperBox';
		print '不正な操作です。';
	}

	/*
	 * 並び替え
	 */
	// function admin_sort()
	// {
	// 	if (isset($this->request->data['Banner'])) {
	// 		if ($this->request->data['Banner']['sort_id'] != '') {
	// 			$sort_ids = explode(',', $this->request->data['Banner']['sort_id']);
	// 			// updateデータ作成
	// 			$banners['Banner'] = array();
	// 			foreach ($sort_ids as $k => $v) {
	// 				$banners['Banner'][] = array(
	// 					'id' => $v,
	// 					'sort_id' => $k+1
	// 				);
	// 			}
	// 			// sort_idをアップデート
	// 			$cnt = count($banners['Banner']);
	// 			for ($i=0; $i<$cnt; $i++) {
	// 				$this->Banner->id = $banners['Banner'][$i]['id'];
	// 				$this->Banner->saveField('sort_id', $banners['Banner'][$i]['sort_id']);
	// 			}
	// 		}
	// 		$this->redirect('/admin/banner/');
	// 	} else {
	// 		$data = $this->Banner->getBanners('root_top');
	// 		$this->set(compact('data'));
	// 		$this->set([
	// 			'banner_types' => $this->Banner->getBannerTypes(),
	// 			'scripts' => array('script_sort_banner')
	// 		]);
	// 		$this->adminInit();
	// 	}
	// }

	// public function admin_search(){

	// 	if (isset($this->params->query)) {
	// 		$params = $this->params->query;
	// 		// フリーワード
	// 		if (isset($params['q']) && $params['q'] != '') {
	// 			$this->paginate['conditions']['AND'][] = "Shop.id LIKE '%" .$params['q']. "%' OR Shop.name LIKE '%" .$params['q']. "%' OR Shop.url LIKE '%" .$params['q']. "%' OR Shop.tel LIKE '%" .$params['q']. "%' OR Shop.catch_copy LIKE '%" .$params['q']. "%' OR Shop.description LIKE '%" .$params['q']. "%' OR Shop.comment LIKE '%" .$params['q']. "%' OR Shop.admin_email LIKE '%" .$params['q']. "%'";
	// 		}
	// 	} else {
	// 		$this->redirect('/admin/banner/');
	// 	}

	// 	$this->paginate['fields'] = [
	// 		'Banner.id',
	// 		'Banner.status',
	// 		'Banner.type_id',
	// 		'Banner.img_pc',
	// 		'Shop.name'
	// 	];
	// 	$this->paginate['order'] = [
	// 		'Banner.created' => 'DESC'
	// 	];
	// 	// $this->paginate['recursive'] = '-1';
	// 	// $this->paginate['recursive'] = '-1';
	// 	$this->paginate['limit'] = 50;
	// 	// $this->prd($this->paginate);

	// 	$data = $this->paginate();
	// 	// $this->prd($data);
	// 	$this->set(compact('data'));
	// 	$this->adminInit();
	// 	$this->set([
	// 		'result_caption' => $params['q'],
	// 		'banner_types' => $this->Banner->getBannerTypes(true)
	// 	]);
	// 	$this->render("admin_index");
	// }

	/*
	 * 画像削除
	 */
	// function admin_delete_image($id)
	// {
	// 	// 権限チェック
	// 	$this->hasAuthority($this->name, 'delete_image', $this->Banner->findById($id)['Banner']['shop_id']);

	// 	$dir = IMG_DIR . strtolower(implode("_", $this->explodeCase($this->name))) . DS;
	// 	$data = $this->Banner->findById($id);
	// 	$data = $data[$this->name];
	// 	$this->Banner->id = $id;
	// 	for ($i=1; $i<count($this->params['pass']); $i++) {
	// 		if ($data[$this->params['pass'][$i]] != "") {
	// 			unlink($dir . $data[$this->params['pass'][$i]]);
	// 		}
	// 		$this->Banner->saveField($this->params['pass'][$i], "", false);
	// 	}

	// 	$this->redirect('/admin/' .strtolower(implode("_", $this->explodeCase($this->name))). '/edit/' .$id);
	// }

	// /*
	//  * 削除
	//  */
	// function admin_delete($id)
	// {
	// 	// 画像削除
	// 	$data = $this->Banner->findById($id);
	// 	$data = $data['Banner'];
	// 	$dir = IMG_DIR . strtolower(implode("_", $this->explodeCase($this->name))) . DS;
	// 	($data['img_pc'] != "") ? unlink($dir . $data['img_pc']) : "";
	// 	($data['img_sp'] != "") ? unlink($dir . $data['img_sp']) : "";
	// 	// レコード削除
	// 	$this->Banner->delete($id, true);
	// 	$this->redirect($this->referer());
	// }

}