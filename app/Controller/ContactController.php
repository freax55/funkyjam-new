<?php
App::uses('AppController', 'Controller');
class ContactController extends AppController {
	public $name = 'Contact';
	public $uses = [
		'Magazine'
	];

	private function _pageInit() {
		$this->pageInit();
		$this->layout = 'Pane1';
		$this->topicPath(
			[
				$this->pages['contact']['title'],
			],
			[]
		);
		$this->set([
			'title' => $this->pages['contact']['title'].SEP.SITENAME,
			// 'scripts' => array('script_entry'),
			'noindex' => true
		]);
	}

	public function index() {
		// echo 'contact';
		// phpinfo();
		// $m = $this->Magazine->find('all');
		// $this->prd($m);
		$this->_pageInit();
		$type_contact = $this->getContactType();
		// $this->prd($type_contact);
		$this->set([
			// compact('type_contact'),
			'type_contact' => $type_contact,
			// 'title' => 'fankyjam',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',
			'data' => null//DESCRIPTION,
		]);
	}

	public function confirm() {
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',//DESCRIPTION,
		]);

	}

	public function complete() {
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',//DESCRIPTION,
		]);

	}

}
?>