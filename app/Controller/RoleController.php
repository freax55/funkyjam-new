<?php
class RoleController extends AppController
{
	var $uses = array('UserAdmin', 'Role');

	/*
	 * 一覧画面
	 */
	function admin_index()
	{
		$options = array(
			'order' => array(
				'Role.id' => 'ASC'
			)
		);
		// Sessionからユーザ権限を取得し、
		// スーパーユーザのみスーパーユーザを表示する
		$auth_user = $this->Session->read('User');
		if ($auth_user['User']['role_id'] != 1) {
			$options['conditions'] = array(
				'Role.id != 1'
			);
		}
		$data = $this->Role->find('all', $options);
		$this->set('data', $data);
		$this->adminInit();
	}

	/*
	 * 新規登録
	 */
	function admin_add()
	{
		$this->adminInit();
		$this->set('data', null);
	}

	/*
	 * 編集
	 */
	function admin_edit($id)
	{
		$this->set('data', $this->Role->findById($id));
		$this->adminInit();
		$this->render('admin_add');
	}

	/*
	 * 登録＆編集処理
	 */
	function admin_post()
	{
		// バリデート
		if ($this->Role->create($this->data) && $this->Role->validates()) {
			// DB 格納
			$this->Role->save($this->data);
			$this->redirect('/admin/role/');
		} else {
			$this->set('data', $this->data);
			$this->adminInit();
			$this->render('admin_add');
		}
	}

	/*
	 * 削除
	 */
	function admin_delete($id)
	{
		if ($this->Role->delete($id, false)) {
			$this->redirect('/admin/role/');
		}
	}
}