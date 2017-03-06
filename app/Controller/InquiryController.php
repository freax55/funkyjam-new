<?php
App::uses('CakeEmail', 'Network/Email');
class InquiryController extends AppController
{
	var $name = 'Inquiry';
	var $uses = array('Inquiry');

	private function _pageInit(){
		$this->pageInit();
		$this->layout = 'Pane1';
		$this->topicPath(
			[
				$this->pages['inquiry']['title'],
			],
			[]
		);
		$this->set([
			'title' => $this->pages['inquiry']['title'].SEP.SITENAME,
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
			if (isset($this->data['Inquiry']['send'])) {
				$d = $this->request->data['Inquiry'];
				// DB保存
				// メールの送信に失敗した場合、最悪DBから確認出来るように早めに保存しておく
				$this->Inquiry->save($d, false);

				// メールの組立
				$email = new CakeEmail();
				$email->config('default');
				//$email->transport('Mail');
				$email->from(MAIL_INFO);
				$email->to($d['email']);
				$email->subject('[自動返信][' .SITENAME. '][お問い合わせ] ありがとうございます。');

				$body = $footer = [];
				$body[] = $d['name'] . "様\r\n";
				$body[] = "この度は、お問い合わせいただき、誠にありがとうございます。\r\n";
				$body[] = '■お名前：' . $d['name'] . '様';
				$body[] = '■Email：' . $d['email'];
				$body[] = '■タイトル：' . $d['title'];
				$body[] = '■お問い合わせ内容：' . $d['comment'];

				$footer[] = "\r\n\r\n--";
				$footer[] = SITENAME;
				$footer[] = MAIL_INFO;
				$footer[] = 'https://' . MYHOST . '/';

				if ($email->send(implode("\r\n", $body) . implode("\r\n", $footer))) {
					// 管理へ
					$email->from($d['email']);
					$email->to(MAIL_INFO);
					$email->subject('[お問い合わせ]');
					$email->send("※" . date('Y-m-d H:i:s') . " に送信されました。\r\n\r\n" . implode("\r\n", $body));
					// 完了画面へリダイレクト
					$this->redirect('/inquiry/complete/');
				} else {
					$this->prd('送信に失敗しました。');
				}

			} else {
				// データ整形一括処理
				$this->request->data['Inquiry'] = $this->preInsert($this->request->data['Inquiry']);
				if ($this->Inquiry->create($this->data) && $this->Inquiry->validates()) {
					// 確認画面
					$this->set('data', $this->data);
					$this->_pageInit();
					$this->render('confirm');
				} else {
					$this->set([
						'data' => $this->data,
					]);
					$this->_pageInit();
					$this->render('index');
				}
			}
		} else {
			$this->redirect('/inquiry/');
		}
	}

	public function complete() {
		$this->_pageInit();
	}
}
