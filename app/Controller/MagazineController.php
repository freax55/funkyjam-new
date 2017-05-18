<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('AppController', 'Controller');
class MagazineController extends AppController {
	public $name = 'Magazine';
	public $uses = [
		'Magazine'
	];

	private function _pageInit() {
		$this->pageInit();
		// $this->layout = 'Pane1';
		$select_sex = ['女性', '男性'];
		$wish_magazine = ['しない', 'する'];
		$this->topicPath(
			[
				$this->pages['contact']['title'],
			],
			[]
		);
		$this->set([
			'title' => $this->pages['magazine']['title'].SEP.SITENAME,
			'noindex' => true,
			'select_sex' => $select_sex,
			'wish_magazine' => $wish_magazine,
			'type_contact' => $this->getContactType(),
			'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',
		]);
	}

	public function index() {
		$this->_pageInit();
		// if (!isset($this->data) && empty($this->data)) {
		// 	$this->set([
		// 		'data' => null,
		// 	]);
		// } else {
		// 	if(isset($this->data['complete'])){
		// 		$this->_contact_action($this->data);
		// 	} else {
		// 		$this->set([
		// 			'data' => $this->data,
		// 		]);
		// 	}
		// }
	}

	// 登録
	public function entyr() {
		$this->_pageInit();
	}

	// 登録情報変更
	public function change() {
		$this->_pageInit();
	}

	// 退会
	public function drop() {
		$this->_pageInit();
	}

	public function confirm() {
		$this->_pageInit();
		if (isset($this->data) && !empty($this->data)) {

			$this->request->data['Magazine'] = $this->preInsert($this->request->data['Magazine']);
			$this->Magazine->set($this->data);
			$this->Magazine->validate = $this->Magazine->validate_contact;
			if($this->Magazine->validates()){
				$this->set([
					'data' => $this->data,
					// 'title' => 'fankyjam',
					// 'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',//DESCRIPTION,
				]);
				$this->render('add');
			} else {
				$this->set([
					'data' => $this->data,
					// 'title' => 'fankyjam',
					// 'description' => 'Funky Jam（ファンキージャム）は久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULが所属する芸能プロダクション。オフィシャルサイトとして、最新情報の配信や各アーティストのプロフィール＆ディスコグラフィーの紹介、グッズ＆チケット販売等を行っております。',//DESCRIPTION,
				]);

				$this->render('index');				
			}
		} else {			
			$this->redirect('/contact/');
			// $this->render('add');
		}
	}

	public function complete() {
		$this->_pageInit();
	}

	public function _contact_action($value) {
		$this->outRender = false;
		$select_sex = ['女性', '男性'];
		$type_contact = $this->getContactType();
		$wish_magazine = ['しない', 'する'];
		$now = $this->getTimeMill();
		if (isset($value) && !empty($value)) {
			$d = $value['Magazine'];
			if($d['magazine'] == 1) {
				$check = $this->Magazine->find('first', [
					'conditions' => [
						'Magazine.mail' => $d['mail']
					],
					'fields' => [
						'Magazine.mail'
					]
				]);
				if(!$check) {

					$an_max = $this->Magazine->find('first', [
						'fields' => [
							'max(account_no) as an_max'
						]
					]);
					$account_no = $an_max[0]['an_max'];
					$insert = array(
						'account_no' => $account_no,
						'mail' => $d['mail'],
						'sex' => $select_sex[$d['sex']],
						'fav_kubota' => null,
						'fav_urashima' => null,
						'fav_mori' => null,
						'fav_takahashi' => null,
						'fav_shigemoto' => null,
						'fav_shima' => null,
						'fav_wataru' => null,
						'fav_08' => null,
						'fav_09' => null,
						'fav_10' => null,
						'fav_bes' => null,
						'c_stamp' => $now,
						'u_stamp' => $now
					);
					$this->Magazine->create();
					$this->Magazine->save($insert);
				}
			}
			// メール送信
			// ユーザー宛
			$email = new CakeEmail();
			$email->config('default');
			$email->from(MAIL_INFO);
			$email->to($d['mail']);
			$email->subject('FunkyJam Contact');

			$body = [];
			$body[] = $d['name'] . " さま\r\n\r\n";
			$body[] = "お問い合わせ誠にありがとうございます。\r\n";
			$body[] = "下記の通り、お問い合せを承りましたのでご確認ください。\r\n\r\n";
			$body[] = "▼お問い合せ内容\r\n";
			$body[] = "-------------------------------------\r\n\r\n";
			$body[] = "[お問い合わせ種別]\r\n";
			$body[] = $type_contact[$d['type']] . "\r\n\r\n";
			$body[] = "[お問い合わせ内容]\r\n";
			$body[] = $d['content'] . "\r\n\r\n";
			$body[] = "[お名前]\r\n";
			$body[] = $d['name'] . "\r\n\r\n";
			$body[] = "[メールアドレス]\r\n";
			$body[] = $d['mail'] . "\r\n\r\n";
			if($d['sex'] != '' && $d['sex'] != null) {
				$body[] = "[男女]\r\n";
				$body[] = $select_sex[$d['sex']] . "\r\n\r\n";
			}
			if($d['age'] != '' && $d['age'] != null) {
				$body[] = "[年齢]\r\n";
				$body[] = $d['age'] . "\r\n\r\n";
			}
			if($d['job'] != '' && $d['job'] != null) {
				$body[] = "[職業]\r\n";
				$body[] = $d['job'] . "\r\n\r\n";
			}
			$body[] = "[メールマガジン]\r\n";
			$body[] = "メルマガを購読" . $wish_magazine[$d['magazine']] . "\r\n\r\n\r\n";
			$body[] = "-------------------------------------";

			if ($email->send(implode("\r\n", $body))) {
				// 管理へ
				$email->from([$d['mail'] => 'FunkyJam']);
				$email->to([MAIL_INFO => 'FunkyJam']);
				$email->subject('ホームページからの問い合わせが届いています（会社）');
				$email->send(implode("\r\n", $body));
				// 完了画面へリダイレクト
				$this->redirect('complete');
			} else {
				$this->prd('送信に失敗しました。');
			}
		} else {
			throw new NotFoundException();
		}
	}
}
?>