<?php
App::uses('AppController', 'Controller');
class RootController extends AppController {
	public $name = 'Root';
	public $uses = array(
		'Post',
		'Postmeta'
	);

	public function index() {
		$this->pageInit();
		// $pst = $this->Postmeta->find('all');

$this->prd($_POST);

		// $this->prd($pst);
		$this->set([
			'title' => 'fankyjam',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',//DESCRIPTION,
		]);
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
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。弊社ではシンガー・ソングライター、ヴォーカリスト、作曲家、作詞家への志望者を募集しております。真剣にプロを目指す方であればどなたでも応募下さい。',
		]);
		$this->render('contents');
	}

	public function studio() {
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。弊社アーティストが使用するレコーディングスタジオ、THE BASEMENT of Funky Jamですが、プロユースのスタジオとして、レンタルのお申込みを承っております。',
		]);
		$this->render('contents');
	}

}
