<?php
App::uses('AppController', 'Controller');
class ArtistController extends AppController {
	public $name = 'Artist';
	public $uses = [
		'Post',
		'Postmeta',
		'Term',
		'TermRelationship'
	];

	public function index()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
	}

	public function contents()
	{
		// 各種変数取得
		$data = $this->_artistsData();
		$action = $data['action'];
		$term_name = $data['current'] . '/' . (($action == 'index')?'news':$action);
		$is_contents = true;
		$content = null;

		// 該当記事取得
		$ob_ids = $this->TermRelationship->getObjectIds($term_name);
		if($ob_ids) {
			foreach($ob_ids as $id) {
				$ids[] = $id['TermRelationship']['object_id'];
			}
			$posts = $this->Post->getPostsById($ids);
			if($posts) {
				$content = $posts[0]['Post'];
			} else {
				$is_contents = false;
			}
		} else {
			$is_contents = false;
		}

		// ページ表示データ
		$this->pageInit();
		$_action = Inflector::camelize(($action == 'index')?'news':$action);
		$this->topicPath(
			[
				$data['names'][$data['current']]['en'],//$ary_name['en'],
				$_action
			],
			[
				'/',
				'/'
			]
		);
		
		$this->set([
			'content' => $content,
			'title' => 'fankyjam',
			'term_name' => $term_name,
			'is_contents' => $is_contents,
			// 'ary_name' => $ary_name,
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}

	// public function profile()
	// {
	// 	$this->prd($this->params);
	// 	$data = $this->_artistsData();
	// 	$term_id = null;
	// 	$ary_artists = $data[1];
	// 	$action = $this->action;
	// 	$artist = $data[2];
	// 	$ary_name = $ary_artists[$artist];
	// 	$term = $this->Term->getTerm($artist . '/' . $data[3]);
	// 	if($term){
	// 		$term_id = $term['Term']['term_id'];
	// 	} else {
	// 		throw new NotFoundException();
	// 	}
	// 	$post_ids = $this->TermRelationship->getPostIds($term_id);

	// 	if($post_ids) {
	// 		foreach($post_ids as $id) {
	// 			$ids[] = $id['TermRelationship']['object_id'];
	// 		}
	// 		$posts = $this->Post->getPostsById($ids);
	// 		if($posts) {
	// 			$content = $posts[0]['Post'];
	// 		} else {
	// 			throw new NotFoundException();
	// 		}			
	// 	} else {
	// 		throw new NotFoundException();
	// 	}

	// 	// $posts = $this->Post->getPostsById($ids);
	// 	// if($posts) {
	// 	// 	$content = $posts[0]['Post'];
	// 	// } else {
	// 	// 	throw new NotFoundException();
	// 	// }
	// 	$this->pageInit();
	// 	$_action = Inflector::camelize($this->params->params['action']);
	// 	$this->topicPath(
	// 		[
	// 			$ary_name['en'],
	// 			$_action
	// 		],
	// 		[
	// 			'/',
	// 			'/'
	// 		]
	// 	);
		
	// 	$this->set([
	// 		'content' => $content,
	// 		'title' => 'fankyjam',
	// 		// 'ary_name' => $ary_name,
	// 		// 'description' => DESCRIPTION,
	// 	]);
	// 	$this->render('contents');
	// }

	public function profile_detail()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}

	public function producing()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}

	public function media()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}

	public function discography()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}

	// public function performance()
	// {
	// 	$data = $this->_artistsData();
	// 	$term_id = null;
	// 	$ary_artists = $data[1];
	// 	$action = $this->action;
	// 	$artist = $data[2];
	// 	$ary_name = $ary_artists[$artist];
	// 	$term = $this->Term->getTerm($artist . '/' . $data[3]);
	// 	if($term){
	// 		$term_id = $term['Term']['term_id'];
	// 	} else {
	// 		throw new NotFoundException();
	// 	}
	// 	$post_ids = $this->TermRelationship->getPostIds($term_id);

	// 	if($post_ids) {
	// 		foreach($post_ids as $id) {
	// 			$ids[] = $id['TermRelationship']['object_id'];
	// 		}
	// 	} else {
	// 		throw new NotFoundException();
	// 	}

	// 	$posts = $this->Post->getPostsById($ids);
	// 	if($posts) {
	// 		$content = $posts[0]['Post'];
	// 	} else {
	// 		throw new NotFoundException();
	// 	}
	// 	$this->pageInit();
	// 	$_action = Inflector::camelize($this->params->params['action']);
	// 	$this->topicPath(
	// 		[
	// 			$ary_name['en'],
	// 			$_action
	// 		],
	// 		[
	// 			'/',
	// 			'/'
	// 		]
	// 	);
		
	// 	$this->set([
	// 		'content' => $content,
	// 		'title' => 'fankyjam',
	// 		// 'ary_name' => $ary_name,
	// 		// 'description' => DESCRIPTION,
	// 	]);
	// 	$this->render('contents');
	// }

	public function fanclub()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}

	public function _artistsData(){
		$url = $this->params->url;
		$ary_params = $this->getArtistParams();
		$ary_names = $this->getArtistNames();
		$path = explode('/', $url);
		$controll = $path[0];
		if(isset($path[1]) && isset(array_flip($ary_params)[$path[1]])) {

			$action = isset($path[2])?$path[2]:'index';//str_replace(array_merge($ary_path,[$controller, '/']), ['', '', '', '', '', ''], $url);
			$this->set([
				'ary_params' => $ary_params,
				'ary_names' => $ary_names,
				'current' => $path[1],
			]);
			return array('params' => $ary_params, 'names' => $ary_names, 'controller' => $path[0], 'current' => $path[1], 'action' => $path[2]);
		} else {
			throw new NotFoundException();
		}
	}

	function makefile(){
		$terms = $this->Term->find('list', [
			'conditions' => [
				'Term.name LIKE ' => '%' . '/' . '%',
			],
			'fields' => [
				'name'
			],
			'recursive' => -1
		]);

		foreach($terms as $k => $v) {
			$terms[$k] = str_replace('/', '_', $v);
			exec('touch /Users/yasushi/Projects/funkyjam-new/app/View/Elements/content_' . str_replace('/', '_', $v) . '.ctp');
			exec("echo 'fix contents' | tee /Users/yasushi/Projects/funkyjam-new/app/View/Elements/content_" . str_replace('/', '_', $v) . '.ctp');
		}
	}


}
