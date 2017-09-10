<?php
App::uses('AppController', 'Controller');
class DiscographyDataController extends AppController {
	public $name = 'DiscographyData';
	public $uses = array('Discography');
	public $components = array('FileHandler');
	public $limit = 15;

	public function index($artist,$type,$sort='DESC'){
		$this->_check_referer();
		$limit = 100;
		$extend = [
			'conditions' => [
				'type' => $type
			],
			'order' => [
				'release' => $sort,
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
		if(empty($artist) || empty($type)){
			$this->redirect("/");
		}
		$this->_check_referer();
		$this->set('data', null);
		$this->adminInit();
		$this->layout = 'SuperBox';
		$this->set([
			'artist' => $artist,
			'type' => $type,
			'artist_name' => $this->getArtistNames(),
		]);
	}

	/*
	 * 編集
	 */
	function edit($artist,$type,$id)
	{
		if(empty($artist) || empty($type)){
			$this->redirect("/");
		}
		$this->_check_referer();
		$data = $this->Discography->findById($id);

		$this->set('data', $data);
		$this->adminInit();
		$this->layout = 'SuperBox';
		$this->set([
			'artist' => $artist,
			'type' => $type,
			'artist_name' => $this->getArtistNames(),
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
			if (!$this->validImage($this->data['img'], ['size'=>500])) {
				$this->Discography->invalidate('img', '容量オーバー');
				$valid = 0;
			}
			if ($valid) {
				// 画像アップロード
				if ($this->request->data['img']['error'] == 0) {
					// $this->request->data['Banner']['img'] = $this->FileHandler->uploadImage('Banner', $this->request->data['img'], 'img');
					$this->FileHandler->uploadImage('Discography', $this->request->data['img'], 'img',$this->data['Discography']['artist'].'_'.$this->data['Discography']['type']);
				}
				$relase_date = substr($this->data['Discography']['release_multi1'], 0,4).'-'.substr($this->data['Discography']['release_multi1'], 5,2).'-'.substr($this->data['Discography']['release_multi1'], 8,2);
				$this->request->data['Discography']['release'] = $relase_date;
				// $this->prd($relase_date);
				if(empty($this->data['Discography']['old_id'])){
					$this->request->data['Discography']['old_id'] = $this->data['Discography']['type'].date('ynjHis');
				}
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
				if(empty($this->data['Discography']['discography_id'])){
					// $this->prd($this->data['Discography']['discography_id']);
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
	 * 画像削除
	 */
	function delete_image($id)
	{

		$dir = ASSETS. 'img/portfolio' .DS;//IMG_DIR . strtolower(implode("_", $this->explodeCase($this->name))) . DS;
		$data = $this->Discography->findByDiscographyId($id);
		$data = $data['Discography'];
		$this->Discography->id = $id;
		if ($data['img'] != "") {
			unlink($dir . $data['img']);
		}
		$this->Discography->saveField('img', "", false);

		$this->redirect('/discography_data/edit/'.$data['artist'].'/'.$data['type'].'/'.$data['discography_id'].'/');
	}

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