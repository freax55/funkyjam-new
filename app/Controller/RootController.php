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
		// // $this->args[0] = 'kubota';
		// // $this->prd($this->args);
		// 	$name = 'bes';
		// // if (isset($this->args[0]) && $this->args[0] != "") {
		// 	// $html = fopen(ASSETS . 'files/html/' . $this->args[0] . '.html', 'r');
		// 	// $html = fopen(ASSETS . 'files/html/' . $name . '.html', 'r');
		// 	$file = ASSETS . 'files/html/' . $name . '.html';
		// 	$html = file_get_contents($file);
		// 	// $thml = preg_replace('/[\n\r\t]/', '', $html);
		// 	$html = mb_convert_encoding($html, "UTF-8");
		// 	if(!$html){
		// 		$this->out('is not exist ' . $html);
		// 	}
		// 	$dom = new DOMDocument;
		// 	$dom->preserveWhiteSpace = false; 
		// 	// @$dom->loadHtml(file_get_contents($html));
		// 	@$dom->loadHtml($html);

		// 	$xpath = new DOMXPath($dom);
		// 	$sections = $entries = $queries = array();

		// 	$sections = $xpath->query('//body//article/div[@id="contentBox"]//section');

		// 	$ei = 0;
		// 	foreach($sections as $section) {
		// 		$ei++;
		// 		// $h2 = $xpath->query('.//h2', $section);
		// 		$type = $section->getAttribute('id');//ディスクタイプ
		// 		$d_entries = $xpath->query('.//div[@class="entry clearfix"]', $section);
		// 		foreach($d_entries as $entry) {
		// 			// 画像
		// 			$image_name = '';
		// 			$image = $xpath->query('.//p[@class="image"]/img', $entry)->item(0);
		// 			if($image){
		// 				$image_path = $image->getAttribute('src');
		// 				$image_name = substr(strrchr($image_path, '/'),1);
		// 			}
		// 			// 旧id
		// 			$old_id = @$entry->getAttribute('id');
		// 			// タイトル上
		// 			$label = @$xpath->query('.//p[@class="label"]',$entry)->item(0)->nodeValue;
		// 			// タイトル
		// 			$title = $xpath->query('.//h3', $entry)->item(0)->nodeValue;
		// 			// リリース(配列)
		// 			@$_release = $xpath->query('.//*[@class="release"]', $entry)->item(0)->nodeValue;
		// 			$release = explode("\n", str_replace('.', '/', $_release));
		// 			foreach($release as $k => $v) {
		// 				$release[$k] = preg_replace('/[\n\r\t]/', '', $v);
		// 			}
		// 			$explode_release = @explode('/', $release[0]);
		// 			// リリース(ソート用)
		// 			$release_date = @$explode_release[0] . '-' . sprintf('%02d', @$explode_release[1]) . '-' . sprintf('%02d', preg_replace('/[^0-9\.]/','',@$explode_release[2]));

		// 			// トラックリスト
		// 			$data = $xpath->query('.//div[@class="txt"]/*', $entry);
		// 			$ary = array();
		// 			foreach($data as $row) {
		// 				$rowhtml = $this->getInnerHtml($row);
		// 				$ary[] = $rowhtml;//str_replace(['<','>'], ['**', '**'], $rowhtml);//nodeValue;
		// 			}
		// 			$ary_contents = [];
		// 			foreach($ary as $v) {
		// 				if($v == $title || $v == $release || $v == $label || @strpos($v, $release[0]) !== false) {
		// 					continue;
		// 				}
		// 				$v = preg_replace('/[\n\r\t]/', '', $v);
		// 				if(strpos($v, '<li>') !== false) {
		// 					$list = [];
		// 					$list = explode('</li>', $v);
		// 					foreach($list as $v1) {
		// 						if(empty($v1)) {
		// 							continue;
		// 						}
		// 						$ary_contents[str_replace('<li>', '', $v1)] = 'li';
		// 					}
		// 				} else {
		// 					$ary_contents[$v] = 'p';
		// 				}
		// 			}
		// 			// 外部リンク
		// 			$links = $xpath->query('.//div[@class="btns"]//li', $entry);
		// 			$ary_links = [];
		// 			foreach($links as $li) {
		// 				$href = $xpath->query('.//a', $li)->item(0);
		// 				$ary_links[] = $href->getAttribute('href');
		// 			}

		// 			$insert = [
		// 				'artist' => $name,
		// 				'img' => $image_name,
		// 				'type' => $type,
		// 				'old_id' => $old_id,
		// 				'label' => $label,
		// 				'title' => $title,
		// 				'release' => $release_date,
		// 				'release_multi' => json_encode($release),
		// 				'tracks' => json_encode($ary_contents),
		// 				'link' => json_encode($ary_links),
		// 			];
		// 			// $this->prd($insert);
		// 			$datas[] = $insert;
		// 		}
		// 	}
		// 	$this->prd($datas);
		// // ↑　kokomade

		// $news
		$artists = $this->getArtistParams();
		$artists[] = 'extend';
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
		// $this->prd($ary_custom_order);
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',//DESCRIPTION,
			'news_list' => $_posts,
			'ary_custom_order' => $ary_custom_order
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
