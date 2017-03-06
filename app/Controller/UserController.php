<?php
class UserController extends AppController
{
	var $name = 'User';
	var $uses = array('User', 'Role');

	function login()
	{
		if ($this->getAuth()) {
			$this->layout = "Admin";
			$this->set('title', '管理画面トップ' . SITENAMEADMIN);
			$this->adminInit();
			$this->redirect('/admin/club/');
		} else {
			$this->set("data", null);
			if (strpos($this->params->url, 'admin') !== false) {
				$this->layout = 'Null';
			}
		}
	}

	/*
	 * ログイン処理
	 */
	function post() {
		// バリデート
		if ($this->User->create($this->params->data) && $this->User->validates()) {
			// 認証成功
			$options = array(
				'conditions' => array(
					"User.mail" => $this->params->data['User']['mail'],
					"User.password" => md5($this->params->data['User']['password'])
				)
			);
			$data = $this->User->find('first', $options);
			$this->Session->renew();
			$this->Session->write('User', $data);
			$this->redirect("/admin/");
		} else {
			$this->set("data", $this->params->data);
			$this->layout = 'Null';
			$this->render('login');
		}
	}

	function logout()
	{
		if ($this->Session->check('User')) {
			$this->Session->delete('User');
		}
		// ログイン状態クッキー管理
		CakeLog::write('debug', 'logout');
		$this->Cookie->delete('admin');
		$this->redirect('/admin/');
	}

	/*
	 * 一覧画面
	 */
	function admin_index()
	{
		if (!$this->getAuth()) {
			$this->redirect('/admin/');
		}
		if ($this->getRoleId() <= 2) {
			$this->paginate['order'] = [
				'Role.id' => 'ASC',
				'User.id' => 'ASC'
			];
			$data = $this->paginate();
			$this->set(compact('data'));
			$this->_getRoles();
			$this->adminInit();
			$this->set(array(
				'scripts' => array('script_auto_complete_user', 'script_keyboard_shortcut'),
				'javascript' => array('jquery.autocomplete')
			));
		} else {
			$this->redirect('/admin/');
		}
	}

	/*
	 * 新規登録
	 */
	function admin_add()
	{
		$this->set('data', null);
		$this->_getRoles();
		$this->adminInit();
	}

	/*
	 * 編集
	 */
	function admin_edit($id)
	{
		$this->set('data', $this->User->findById($id));
		$this->adminInit();
		$this->_getRoles();
		$this->render('admin_add');
	}

	/*
	 * 登録＆編集処理
	 */
	function admin_post()
	{
		if (isset($this->params->data)) {
			// バリデート
			$this->User->validate = $this->User->validate_admin;
			if ($this->User->create($this->data) && $this->User->validates()) {
				$data = $this->params->data["User"];
				// 新規ユーザか否か
				if ($data["id"] != "") {
					// 既存ユーザのパスワードに変更がないか調べて、変更があれば、暗号化する。
					$options = array(
						"conditions" => array(
							"User.id" => $data["id"]
						),
						"fields" => array(
							"User.password"
						),
						"recursive" => "-1"
					);
					$user_admin = $this->User->find("first", $options);
					if ($user_admin["User"]["password"] != $data["password"]) {
						$data["password"] = md5($data["password"]);
					}
				} else {
					// 新規ユーザの場合は、POSTされたパスワードを無条件に暗号化する。
					$data["password"] = md5($data["password"]);
				}
				// DB 格納
				$this->User->save($data);
				$this->redirect('/admin/user/');
			} else {
				$this->set('data', $this->params->data);
				$this->_getRoles();
				$this->adminInit();
				$this->render('admin_add');
			}
		} else {
			$this->redirect("/admin/");
		}
	}

	/*
	 * 削除
	 */
	function admin_delete($id)
	{
		if ($this->User->delete($id, false)) {
			$this->redirect('/admin/user/');
		}
	}

	/*
	 * ユーザロールリスト
	 */
	function _getRoles()
	{
		$roles = $this->Role->find('list');
		// Sessionからユーザ権限を取得し、
		// スーパーユーザのみスーパーユーザを表示する
		$auth_user = $this->Session->read('User');
		if ($auth_user['User']['role_id'] != 1) {
			unset($roles[1]);
		}
		$this->set(compact('roles'));
	}

	/*
	 * 検索
	 */
	function admin_search()
	{
		// パラメータ調節(GET or POST)
		if (isset($this->data['User']['q'])) {
			$q = $this->data['User']['q'];
		} else if (isset($this->params['url']['q'])) {
			$q = urldecode($this->params['url']['q']);
		}
		$this->params->params['url']['q'] = urlencode($q);

		$this->paginate['conditions'] = array(
			"User.name LIKE '%" .$q. "%' OR User.mail LIKE '%" .$q. "%'"
		);
		// $this->paginate['limit'] = $this->limit;
		$this->paginate['recursive'] = '-1';
		$data = $this->paginate();

		if ($data) {
			$this->set(compact('data'));
			$this->set("result_caption", "検索結果：" .$q);
			$this->adminInit();
			$this->_getRoles();
			$this->set(array(
				'scripts' => array('script_auto_complete_user', 'script_keyboard_shortcut'),
				'javascript' => array('jquery.autocomplete')
			));
			$this->render("admin_index");
		} else {
			$this->redirect("/admin/user/");
		}
	}

	function admin_auto_complete($user_role_id)
	{
		$this->needAuth = true;
		$this->autoRender = false;

		$q = $this->params['url']['q'];
		$options = array(
			'conditions' => array(
				"User.role_id = " . $user_role_id . " AND User.name LIKE '%" .$q. "%' OR User.role_id = " . $user_role_id . " AND User.mail LIKE '%" .$q. "%'",
			),
			'fields' => array(
				'User.id',
				'User.name',
				'User.mail'
			),
		);
		$data = $this->User->find('all', $options);

		if (count($data) != 0) {
			foreach ($data as $v) {
				$v = $v['User'];
				$result[] = $v['name'] . '|' . $v['id'] . '|' . $v['mail'];
			}
			return implode(PHP_EOL, $result);
		} else {
			return false;
		}
	}
}
?>
