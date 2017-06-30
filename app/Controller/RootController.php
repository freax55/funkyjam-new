<?php
App::uses('AppController', 'Controller');
class RootController extends AppController {
	public $name = 'Root';
	public $uses = array(
		'Post',
		'Postmeta',
		'TermRelationship',
		'Term',
		'Option'
	);

	public function index() {
		//header
		$header_option = $this->Option->getIdArtistHeader('top');
		$ary_header = json_decode($header_option['Option']['option_value'],true);
		// $news
		$artists = $this->getArtistParams();
		$artists[] = 'extend';
		foreach ($artists as $v) {
			$term_name[] = $v . '/news';
		}

		$object_ids = $this->TermRelationship->getObjectIds($term_name);
		foreach($object_ids as $id) {
			$ids[] = $id['TermRelationship']['object_id'];
			$idsbyartist[$id['TermRelationship']['object_id']] = strstr($id['Term']['name'], '/', true);
		}
		$fields = [
			'fields' => [
				'ID',
				'post_title',
				'post_date',
				'post_name'
			]
		];
		$this->Post->bindThumbnail();
		$posts = $this->Post->getPostsById($ids, $fields);
		// $this->prd($posts);
		foreach($posts as $post){
			$artist_name = $idsbyartist[$post['Post']['ID']];
			$count[$artist_name][] = 1;
			$_posts[$post['Post']['ID']] = $post;
			$_posts[$post['Post']['ID']]['Post']['order'] = count($count[$artist_name]);
			$_posts[$post['Post']['ID']]['Post']['aritist_name'] = $artist_name;
		}
		$custom_order_ids = $this->Option->find('first', [
			'conditions' => [
				'option_name' => 'custom_order'
			],
			'fileds' => [
				'option_value'
			] 
		]);
		$ary_custom_order = json_decode($custom_order_ids['Option']['option_value'], true);
		// $this->prd($_posts);
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',//DESCRIPTION,
			'news_list' => $_posts,
			'ary_custom_order' => $ary_custom_order,
			'ary_header' => $ary_header,
		]);
	}

	// DOM method
	function getInnerHtml($node){
	    $children = $node->childNodes;
	    $html = '';
	    foreach($children as $child){
	        $html .= $node->ownerDocument->saveHTML($child);
	    }
	    return $html;
	}


	function get_news_list() {
		$artists = $this->getArtistParams();

		foreach($artists as $v) {
			$ids = [];
			$ids = $this->TermRelationship->getObjectIds($term);
		}
		$term = $artist . '/news';
		$ids = $this->TermRelationship->getObjectIds($term);
		foreach($ids as $v) {
			$ary[] = $v['TermRelationship']['object_id'];
		}
		$this->Post->bindThumbnail();
		$list = $this->Post->getPostsById($ary);
		$this->set(['news_list' => $list]);
	}


	public function company() {
		$action = $this->params->params['action'];
		$content_company = $this->Postmeta->getPostPages($action);
		$this->pageInit();
		$this->_getHeader();
		$_action = Inflector::camelize($this->params->params['action']);
		$this->topicPath(
			[
				$_action
			],
			[
				'/'
			]
		);
		
		$this->set([
			'content' => isset($content_company[0]) ? $content_company[0]:null,
			'title' => 'fankyjam',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',
		]);
		$this->render('contents');
	}

	public function recruit() {
		$action = $this->params->params['action'];
		$content_company = $this->Postmeta->getPostPages($action);
		$this->pageInit();
		$this->_getHeader();
		$_action = Inflector::camelize($this->params->params['action']);
		$this->topicPath(
			[
				$_action
			],
			[
				'/'
			]
		);
		
		$this->set([
			'content' => isset($content_company[0]) ? $content_company[0]:null,
			'title' => 'fankyjam',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。アーティストのマネージメント、プロモーションを担当して頂ける人材を探しております。応募される方は履歴書(3カ月以内に撮影した顔写真貼付)と職務経歴書をご郵送下さい。',
		]);
		$this->render('contents');
	}

	public function scout() {
		// $this->pageInit();
		// $this->set([
		// 	'title' => 'fankyjam',
		// 	'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。弊社ではシンガー・ソングライター、ヴォーカリスト、作曲家、作詞家への志望者を募集しております。真剣にプロを目指す方であればどなたでも応募下さい。',
		// ]);
		// $this->render('contents');
		$action = $this->params->params['action'];
		$content_company = $this->Postmeta->getPostPages($action);
		$this->pageInit();
		$this->_getHeader();
		$_action = Inflector::camelize($this->params->params['action']);
		$this->topicPath(
			[
				$_action
			],
			[
				'/'
			]
		);
		
		$this->set([
			'content' => isset($content_company[0]) ? $content_company[0]:null,
			'title' => 'fankyjam',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。アーティストのマネージメント、プロモーションを担当して頂ける人材を探しております。応募される方は履歴書(3カ月以内に撮影した顔写真貼付)と職務経歴書をご郵送下さい。',
		]);
		$this->render('contents');
	}

	public function studio() {
		// $this->pageInit();
		// $this->set([
		// 	'title' => 'fankyjam',
		// 	'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。弊社アーティストが使用するレコーディングスタジオ、THE BASEMENT of Funky Jamですが、プロユースのスタジオとして、レンタルのお申込みを承っております。',
		// ]);
		// $this->render('contents');
		$action = $this->params->params['action'];
		$content_company = $this->Postmeta->getPostPages($action);
		$this->pageInit();
		$this->_getHeader();
		$_action = Inflector::camelize($this->params->params['action']);
		$this->topicPath(
			[
				$_action
			],
			[
				'/'
			]
		);
		
		$this->set([
			'content' => isset($content_company[0]) ? $content_company[0]:null,
			'title' => 'fankyjam',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。アーティストのマネージメント、プロモーションを担当して頂ける人材を探しております。応募される方は履歴書(3カ月以内に撮影した顔写真貼付)と職務経歴書をご郵送下さい。',
		]);
		$this->render('contents');
	}
	public function privacy() {
		// $this->pageInit();
		// $this->set([
		// 	'title' => 'fankyjam',
		// 	'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。弊社アーティストが使用するレコーディングスタジオ、THE BASEMENT of Funky Jamですが、プロユースのスタジオとして、レンタルのお申込みを承っております。',
		// ]);
		// $this->render('contents');
		$action = $this->params->params['action'];
		$content_company = $this->Postmeta->getPostPages($action);
		$this->pageInit();
		$this->_getHeader();
		$_action = Inflector::camelize($this->params->params['action']);
		$this->topicPath(
			[
				$_action
			],
			[
				'/'
			]
		);
		
		$this->set([
			'content' => isset($content_company[0]) ? $content_company[0]:null,
			'title' => 'fankyjam',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。アーティストのマネージメント、プロモーションを担当して頂ける人材を探しております。応募される方は履歴書(3カ月以内に撮影した顔写真貼付)と職務経歴書をご郵送下さい。',
		]);
		$this->render('contents');
	}
	public function art() {
		// $this->pageInit();
		// $this->set([
		// 	'title' => 'fankyjam',
		// 	'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。弊社アーティストが使用するレコーディングスタジオ、THE BASEMENT of Funky Jamですが、プロユースのスタジオとして、レンタルのお申込みを承っております。',
		// ]);
		// $this->render('contents');
		$action = $this->params->params['action'];
		$content_company = $this->Postmeta->getPostPages($action);
		$this->pageInit();
		$this->_getHeader();
		$_action = Inflector::camelize($this->params->params['action']);
		$this->topicPath(
			[
				$_action
			],
			[
				'/'
			]
		);
		
		$this->set([
			'content' => isset($content_company[0]) ? $content_company[0]:null,
			'title' => 'fankyjam',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。アーティストのマネージメント、プロモーションを担当して頂ける人材を探しております。応募される方は履歴書(3カ月以内に撮影した顔写真貼付)と職務経歴書をご郵送下さい。',
		]);
		$this->render('contents');
	}
	public function baribaricrew() {
		// $this->pageInit();
		// $this->set([
		// 	'title' => 'fankyjam',
		// 	'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。弊社アーティストが使用するレコーディングスタジオ、THE BASEMENT of Funky Jamですが、プロユースのスタジオとして、レンタルのお申込みを承っております。',
		// ]);
		// $this->render('contents');
		$action = $this->params->params['action'];
		$content_company = $this->Postmeta->getPostPages($action);
		$this->pageInit();
		$this->_getHeader();
		$_action = Inflector::camelize($this->params->params['action']);
		$this->topicPath(
			[
				$_action
			],
			[
				'/'
			]
		);
		
		$this->set([
			'content' => isset($content_company[0]) ? $content_company[0]:null,
			'title' => 'fankyjam',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。アーティストのマネージメント、プロモーションを担当して頂ける人材を探しております。応募される方は履歴書(3カ月以内に撮影した顔写真貼付)と職務経歴書をご郵送下さい。',
		]);
		$this->render('contents');
	}
	public function fanletter() {
		// $this->pageInit();
		// $this->set([
		// 	'title' => 'fankyjam',
		// 	'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。弊社アーティストが使用するレコーディングスタジオ、THE BASEMENT of Funky Jamですが、プロユースのスタジオとして、レンタルのお申込みを承っております。',
		// ]);
		// $this->render('contents');
		// $action = $this->params->params['action'];
		// $content_company = $this->Postmeta->getPostPages($action);
		$this->pageInit();
		$this->_getHeader();
		$_action = Inflector::camelize($this->params->params['action']);
		$this->topicPath(
			[
				$_action
			],
			[
				'/'
			]
		);
		
		$this->set([
			'content' => isset($content_company[0]) ? $content_company[0]:null,
			'title' => 'fankyjam',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。アーティストのマネージメント、プロモーションを担当して頂ける人材を探しております。応募される方は履歴書(3カ月以内に撮影した顔写真貼付)と職務経歴書をご郵送下さい。',
		]);
		// $this->render('contents');
	}

	public function _getHeader(){
		$header_id = $this->Option->getIdArtistHeader('pages')['Option']['option_value'];
		$header = $this->Post->getArtistHeader($header_id);
		$this->set([
			'header_image_path' => $header,
		]);
		return;
	}

}
