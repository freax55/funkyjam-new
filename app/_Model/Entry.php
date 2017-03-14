<?php
class Entry extends AppModel {
	var $name = 'Entry';

	var $validate = array(
		'name' => array(
			'rule' => 'notBlank',
			'message' => '貴店名を入力してください。'
		),
		'job_id' => array(
			'rule' => array('validSelect'),
			'message' => '業種を選択してください。'
		),
		'pref_id' => [
			'rule' => ['validSelectString'],
			'message' => '都道府県を選択してください。'
		],
		'city_id' => [
			'rule' => ['validSelectString'],
			'message' => '市区町村を選択してください。'
		],
		'admin_name' => array(
			'rule' => 'notBlank',
			'message' => 'ご担当者様名を入力してください。'
		),
		'admin_tel' => array(
			'rule' => 'notBlank',
			'message' => '電話番号を入力してください。'
		),
		'admin_email' => array(
			'rule1' => array(
				'rule' => 'notBlank',
				'message' => 'メールアドレスを入力してください。'
			),
			'rule2' => array(
				'rule' => array('email'),
				'message' => 'メールアドレスを正しく入力してください。'
			),
			'rule3' => array(
				'rule' => 'isUnique',
				'message' => 'このメールアドレスは既に使われています。'
			),
			// 'rule4' => array(
			// 	'rule' => ['validDuplicateEmail'],
			// 	'message' => 'このメールアドレスは既に使われています。'
			// ),
		),
		'admin_password' => array(
			'rule1' => array(
				'rule' => 'notBlank',
				'message' => '管理画面パスワードを入力してください。'
			),
			'rule2' => array(
				'rule' => ['validPassword'],
				'message' => '使用できない文字列が含まれています。'
			),
			'rule3' => array(
				'rule' => ['minLength', 8],
				'message' => '8文字以上32文字以内で入力してください。'
			),
			'rule4' => array(
				'rule' => ['maxLength', 32],
				'message' => '8文字以上32文字以内で入力してください。'
			),
		),
		'url' => array(
			'rule1' => array(
				'rule' => 'notBlank',
				'message' => 'URLを入力してください。'
			),
			'rule2' => array(
				'rule' => 'url',
				'message' => 'URLを正しく入力してください。'
			),
		),
		'url_sp' => array(
			'rule' => 'url',
			'message' => 'スマホ版URLを正しく入力してください。',
			'allowEmpty' => true
		),
		'discount' => array(
			'rule' => 'notBlank',
			'message' => 'デリヘルOK割引を入力してください。'
		),
	);

	function validSelect($field)
	{
		$field = array_keys($field);
		if ($this->data[$this->name][$field[0]] == 0) {
			return false;
		}
		return true;
	}

	/*
	 * パスワードチェック
	 */
	function validPassword($field)
	{
		$field = array_keys($field);
		if (!mb_ereg("^[a-zA-Z0-9][!-~]+$", $this->data[$this->name][$field[0]])) {
			return false;
		}
		return true;
	}

	function validDuplicateEmail(){
		$this->User = Classregistry::init('User');
		$options = array(
			'conditions' => array(
				'User.mail' => $this->data['Signup']['admin_email']
			)
		);
		return !$this->User->find('first', $options);
	}
}
?>