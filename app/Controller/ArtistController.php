<?php
App::uses('AppController', 'Controller');
class ArtistController extends AppController {
	public $name = 'Artist';
	public $uses = [
		'Post',
		'Postmeta',
		'Term',
		'TermRelationship',
		'Discography',
		'Option'
	];

	public function index()
	{
		$data = $this->_artistsData();
		// $action = $data['action'];
		$term_name = $data['current'] . '/news';
		// indexはニュースにリダイレクト
		$this->redirect('/artist/' . $term_name . '/');
		$is_contents = true;
		$content = null;
		$ob_ids = $this->TermRelationship->getObjectIds($term_name);
		if($ob_ids){
			foreach($ob_ids as $id) {
				$ids[] = $id['TermRelationship']['object_id'];
			}
		} else {
			$is_contents = false;
		}

		$this->set([
			'title' => 'Funky Jam',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',
		]);
	}

	public function news_contents()
	{
		if(isset($this->params->named['sort']) || isset($this->params->named['direction'])) {
			$here = str_replace(['/sort:' . $this->params->named['sort'], '/direction:' . $this->params->named['direction']], ['', ''], $this->params->here);
			$this->redirect($here);
		}
		// 各種変数取得
		$data = $this->_artistsData();

		$action = $data['action'];
		if(!isset(array_flip($data['params'])[$this->params->pass[0]]) || $this->params->pass[1] != 'news'){
			throw new NotFoundException();
		}
		$term_name = $data['current'] . '/' . $action;
		$is_contents = true;
		$content = null;


		// 記事取得
		$this->paginate = $this->Post->getCustomPostOptions($data['current'],[],[],1);
		$content = $this->paginate('Post');
		if($this->params['paging']['Post']['count'] == 0) {
			$is_contents = false;
		}
		$title = $content[0]['Post']['post_title'];
		$this->pageInit();
		$this->topicPath(
			[
				$data['names'][$data['current']]['en'],
				$title
			],
			[
				'/artist/' . $data['current'] . '/news/'
			]
		);

		

		$this->set([
			'title' => $title . ' - Funky Jam ファンキー・ジャム',
			'content' => $content,
			'term_name' => $term_name,
			'is_contents' => $is_contents,
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',
		]);
		$this->render('news');
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
				'/artist/' . $data['current'] . '/news/'
			]
		);
		
		$this->set([
			'content' => $content,
			'title' =>  $data['names'][$data['current']]['jp'] . ' ' . strtoupper($action) . ' - Funky Jam ファンキー・ジャム',
			'term_name' => $term_name,
			'is_contents' => $is_contents,
			// 'ary_name' => $ary_name,
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',
		]);
		$this->render('contents');
	}

	public function discography()
	{
		// 各種変数取得
		$data = $this->_artistsData();
		$action = $data['action'];
		$term_name = $data['current'] . '/' . (($action == 'index')?'news':$action);
		$is_contents = true;
		$content = null;

		$data_discs = $this->Discography->getDataGroupbyType($data['current']);
		
		$this->pageInit();
		$_action = Inflector::camelize(($action == 'index')?'news':$action);
		$this->topicPath(
			[
				$data['names'][$data['current']]['en'],//$ary_name['en'],
				$_action
			],
			[
				'/artist/' . $data['current'] . '/news/'
			]
		);
		$this->set([
			'data_discs' => $data_discs,
			'title' => $data['names'][$data['current']]['jp'] . ' ' . strtoupper($action) . ' - Funky Jam ファンキー・ジャム',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',
		]);
	}


	function get_news_list($artist) {
		$this->Post->bindThumbnail();
		$list = $this->Post->getCustomPost($artist);
		$this->set(['news_list' => $list]);
	}

	// public function profile_detail()
	// {
	// 	$this->pageInit();
	// 	$this->set([
	// 		'title' => 'Funky Jam',
	// 		'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',
	// 	]);
	// 	$this->render('contents');
	// }

	// public function producing()
	// {
	// 	$this->pageInit();
	// 	$this->set([
	// 		'title' => 'Funky Jam',
	// 		'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',
	// 	]);
	// 	$this->render('contents');
	// }

	// public function media()
	// {
	// 	$this->pageInit();
	// 	$this->set([
	// 		'title' => 'Funky Jam',
	// 		'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',
	// 	]);
	// 	$this->render('contents');
	// }


	// public function fanclub()
	// {
	// 	$this->pageInit();
	// 	$this->set([
	// 		'title' => 'Funky Jam',
	// 		'description' => 'Funky Jam（ファンキージャム）のファンクラブページになります。Funky Jamは久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',
	// 	]);
	// 	$this->render('contents');
	// }

	public function _artistsData(){
		$url = $this->params->url;
		$ary_params = $this->getArtistParams();
		$ary_names = $this->getArtistNames();
		$path = explode('/', $url);
		$this->get_news_list($path[1]);
		$controll = $path[0];
		$header_id = $this->Option->getIdArtistHeader($path[1])['Option']['option_value'];
		$header = $this->Post->getArtistHeader($header_id);
		if(isset($path[1]) && isset(array_flip($ary_params)[$path[1]])) {
			$action = !empty($path[2])?$path[2]:'index';//str_replace(array_merge($ary_path,[$controller, '/']), ['', '', '', '', '', ''], $url);
			$this->set([
				'ary_sns' => $this->getArtistSNS(),
				'ary_params' => $ary_params,
				'ary_names' => $ary_names,
				'current' => $path[1],
				'action' => $action,
				'header_image_path' => $header,
			]);
			return array('params' => $ary_params, 'names' => $ary_names, 'controller' => $path[0], 'current' => $path[1], 'action' => $action);
		} else {
			throw new NotFoundException();
		}
	}

	// function makefile(){
	// 	$terms = $this->Term->find('list', [
	// 		'conditions' => [
	// 			'Term.name LIKE ' => '%' . '/' . '%',
	// 		],
	// 		'fields' => [
	// 			'name'
	// 		],
	// 		'recursive' => -1
	// 	]);

	// 	foreach($terms as $k => $v) {
	// 		$terms[$k] = str_replace('/', '_', $v);
	// 		exec('touch /Users/yasushi/Projects/funkyjam-new/app/View/Elements/content_' . str_replace('/', '_', $v) . '.ctp');
	// 		exec("echo 'fix contents' | tee /Users/yasushi/Projects/funkyjam-new/app/View/Elements/content_" . str_replace('/', '_', $v) . '.ctp');
	// 	}
	// }


}
