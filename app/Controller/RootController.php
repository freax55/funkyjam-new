<?php
App::uses('AppController', 'Controller');
class RootController extends AppController {
	public $name = 'Root';
	public $uses = array(
		'Post',
		'Postmeta',
		'TermRelationship',
		'Term'
	);

	// function getInnerHtml($node){
	// 	$children = $node->childNodes;
	// 	$html = '';
	// 	foreach($children as $child){
	// 		$html .= $node->ownerDocument->saveHTML($child);
	// 	}
	// 	return $html;
	// }

	public function index() {
		// $this->args[0] = 'kubota';
		// $this->prd($this->args);
		// 	$name = 'kubota';
		// // if (isset($this->args[0]) && $this->args[0] != "") {
		// 	// $html = fopen(ASSETS . 'files/html/' . $this->args[0] . '.html', 'r');
		// 	// $html = fopen(ASSETS . 'files/html/' . $name . '.html', 'r');
		// 	$file = ASSETS . 'files/html/' . $name . '.html';
		// 	$html = file_get_contents($file);
		// 	$html = mb_convert_encoding($html, "UTF-8");
		// 	// $this->prd($html);
		// 	if(!$html){
		// 		$this->out('is not exist ' . $html);
		// 	}
		// 	// $this->prd($html);
		// 	$dom = new DOMDocument;
		// 	$dom->preserveWhiteSpace = false; 
		// 	// @$dom->loadHtml(file_get_contents($html));
		// 	@$dom->loadHtml($html);

		// 	$xpath = new DOMXPath($dom);
		// 	$sections = $entries = $queries = array();

		// 	$sections = $xpath->query('//body//article/div[@id="contentBox"]//section');
		// 	// $sections = $xpath->query('//body//article/div//section');

		// 	foreach($sections as $sk => $section_path) {
		// 		// sectionタグからディスクタイプ取得
		// 		$type = $section_path->getAttribute('id');
		// 		$entries = $xpath->query('.//div[@class="entry clearfix"]', $section_path);
		// 		// $entries = $xpath->query('[' . $sk . ']', $sections);

		// 		// $this->prd($section_path->nodeValue);

				
		// 	}
		// 	$this->prd($ary);


			// $ei = 0;
			// foreach($sections as $section) {
			// 	$ei++;
			// 	// $h2 = $xpath->query('.//h2', $section);
			// 	$type = $section->getAttribute('id');//ディスクタイプ
			// 	$d_entries = $xpath->query('.//div[@class="entry clearfix"][' . $ei . ']', $section);
			// 	$di = 0;
			// 	foreach($d_entries as $entry) {
			// 		$old_id = $entry->getAttribute('id');// 旧id
			// 		$title = $xpath->query('.//h3', $entry)->item(0)->nodeValue;
			// 		$release = $xpath->query('.//p[@class="release"]', $entry)->item(0)->nodeValue;
			// 		// $this->prd($release);
			// 		$r[] = $release;

			// 		// $data = $xpath->query('.//div[@class="txt"]', $entry);
			// 		// $ary = array();
			// 		// foreach($data as $row) {
			// 		// 	$rowhtml = $this->getInnerHtml($row);
						
			// 		// 	$ary[] = str_replace(['<','>'], ['****', '****'], $rowhtml);//nodeValue;
			// 		// }
			// 		// $this->prd($ary);
			// 		// $title = $entry->
			// 		// $this->prd($old_id);
			// 	}
			// 	// foreach()

			// 	// $this->prd($type);
			// }
			// $this->prd($r);



			// $this->prd($entries->item(0));











			
		// }


























		// ↑　kokomade

		// $news
		$artists = $this->getArtistParams();
		foreach ($artists as $v) {
			$term_name[] = $v . '/news';
		}

		$object_ids = $this->TermRelationship->getObjectIds($term_name);
		// $this->prd($object_ids);
		foreach($object_ids as $id) {
			$ids[] = $id['TermRelationship']['object_id'];
			$idsbyartist[$id['TermRelationship']['object_id']] = strstr($id['Term']['name'], '/', true);
		}
		// $this->prd($idsbyartist);
		$fields = [
			'fields' => [
				'ID',
				'post_title',
				'post_date'
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
		// $this->prd($_posts);
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',//DESCRIPTION,
			'news_list' => $_posts
		]);
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

}
