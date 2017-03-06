<?php
App::uses('CakeEmail', 'Network/Email');
class EntryController extends AppController {
	var $name = 'Entry';
	var $uses = array('Entry', 'City');

	private function _pageInit() {
		$this->pageInit();
		$this->layout = 'Pane1';
		$this->topicPath(
			[
				$this->pages['entry']['title'],
			],
			[]
		);
		$this->set([
			'jobs' => $this->getJobs(),
			'title' => $this->pages['entry']['title'].SEP.SITENAME,
			'scripts' => array('script_entry'),
			'noindex' => true
		]);
	}

	public function index() {
		$this->_pageInit();
		$this->set([
			'data' => null,
			'noindex' => false
		]);
	}

	public function post() {
		if (isset($this->data) && !empty($this->data)) {
			if (isset($this->data['Entry']['send'])) {
				$d = $this->request->data['Entry'];
				// DB保存
				// メールの送信に失敗した場合、最悪DBから確認出来るように早めに保存しておく
				$this->Entry->save($d, false);

				// メールの組立
				$email = new CakeEmail('default');
				$email->from(MAIL_INFO);
				$email->to($d['admin_email']);
				$email->subject('[自動返信][' .SITENAME. '][無料掲載] ありがとうございます。');

				$body = $footer = [];
				$body[] = $d['name'] . "様\r\n";
				$body[] = "この度は、無料掲載のお申し込みをいただき、誠にありがとうございます。\r\n\r\n";
				$body[] = "「年齢認証ページからのリンクはお済みですか？」\r\n";
				$body[] = "貴店年齢認証ページからのリンクが確認出来た段階で、無料掲載審査開始とさせていただきます。\r\n";
				$body[] = "デリヘルOKの掲載基準に沿わない場合は、掲載を見送ります。予めご了承ください。\r\n\r\n";
				$body[] = "引き続き届出確認書をメール添付にてお送りいただき、申し込み完了となります。\r\n";
				$body[] = "■届出確認書送り先";
				$body[] = "送付先：" . MAIL_INFO . "\r\n";
				$body[] = '■貴店名：' . $d['name'] . ' 様';
				$body[] = '■業種：' . $this->getJobs()[$d['job_id']];
				$pref = (isset($d['pref'])) ? $d['pref'] : "";
				$city = (isset($d['city'])) ? $d['city'] : "";
				$body[] = '■出発地：' . $pref . $city;
				$body[] = '■ご担当：' . $d['admin_name'] . '様';
				$body[] = '■TEL：' . $d['admin_tel'];
				$body[] = '■Email：' . $d['admin_email'];
				$body[] = '■URL(PC版)：' . $d['url'];
				$body[] = '■URL(スマホ版)：' . $d['url_sp'];
				$body[] = '■割引：' . $d['discount'];
				$body[] = '■備考：' . $d['comment'];

				$footer[] = "\r\n\r\n--";
				$footer[] = '「呼べるホテル検索エンジン」' . SITENAME;
				$footer[] = MAIL_INFO;
				$footer[] = 'http://' . MYHOST . '/';

				if ($email->send(implode("\r\n", $body) . implode("\r\n", $footer))) {
					// 管理へ
					$email->from($d['admin_email']);
					$email->to(MAIL_INFO);
					$email->subject('[無料掲載]');
					$email->send("※" . date('Y-m-d H:i:s') . " に送信されました。\r\n\r\n" . implode("\r\n", $body));
					// 完了画面へリダイレクト
					$this->redirect('/entry/complete/');
				} else {
					$this->prd('送信に失敗しました。');
				}

			} else {
				// データ整形一括処理
				$this->request->data['Entry'] = $this->preInsert($this->request->data['Entry']);
				if ($this->Entry->create($this->data) && $this->Entry->validates()) {
					// 確認画面
					$this->request->data['Entry']['pref'] = $this->getPrefs()[$this->request->data['Entry']['pref_id']];
					// City.idからローマ字表記の市区町村名を取得する
					$city_name = $this->City->find('first', ['conditions' => ['City.id' => $this->request->data['Entry']['city_id']]])['City']['name'];
					$this->request->data['Entry']['city'] = $city_name;
					$this->set('data', $this->data);
					$this->_pageInit();
					$this->render('confirm');
				} else {
					$this->set([
						'data' => $this->data,
						'scripts_onload' => ['script_prepend_error_message']
					]);
					$this->_pageInit();
					$this->render('index');
				}
			}
		} else {
			$this->redirect('/entry/');
		}
	}

	public function complete() {
		$this->_pageInit();
	}

	/*
	 * 一覧画面
	 */
	function admin_index()
	{
		$options = array(
			'order' => array(
				'Entry.created' => 'DESC'
			)
		);
		$data = $this->Entry->find('all', $options);
		$this->set(compact('data'));
		$this->adminInit();
	}

	/*
	 * 新規登録
	 */
	function admin_add()
	{
		$this->set('data', null);
		$this->adminInit();
	}

	/*
	 * 閲覧
	 */
	function admin_view($id)
	{
		$this->set([
			'jobs' => $this->Job->find('list'),
			'data' => $this->Entry->findById($id)
		]);
		$this->adminInit();
	}

	/*
	 * 削除
	 */
	function admin_delete($id)
	{
		$data = $this->Entry->findById($id);
		// レコード削除
		$this->Entry->delete($id, true);
		$this->redirect(DS . 'admin' . DS .strtolower(implode("_", $this->explodeCase($this->name))) . DS);
	}
}