<?php
class User extends AppModel
{
	var $name = "User";

	function find($type='first', $options = array()) {
		switch ($type) {
			case "list":
				return Set::combine(parent::find('all', array('order' => 'User.id ASC')), '{n}.User.id', '{n}.User.name');
				break;
			default:
				return parent::find($type, $options);
		}
	}

	var $belongsTo = array(
		"Role" => array(
			"className" => "Role",
			"foreignKey" => "role_id",
			"conditions" => "",
			"fields" => "",
			"order" => "",
			"counterCache" => ""
		)
	);

	var $validate = array(
		'mail' => array(
			'rule1' => array(
				'rule' => array('notBlank'),
				'message' => 'メールアドレスを入力してください。'
			),
			'rule2' => array(
				'rule' => array('email'),
				'message' => 'メールアドレスを正しく入力してください。'
			),
		),
		'password' => array(
			'rule1' => array(
				'rule' => array('notBlank'),
				'message' => 'パスワードを入力してください。'
			),
			'rule2' => array(
				'rule' => array('validUser'),
				'message' => 'パスワードが正しくありません。'
			),
		),
	);

	var $validate_admin = array(
		'role_id' => array(
			'rule' => array('validSelectString'),
			'message' => 'アクセス権限を選択してください。'
		),
		'name' => array(
			'rule' => array('notBlank'),
			'message' => 'ユーザ名を入力してください。'
		),
		'mail' => array(
			'rule1' => array(
				'rule' => array('notBlank'),
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
		),
		'password' => array(
			'rule' => array('notBlank'),
			'message' => 'パスワードを入力してください。'
		),
	);

	// 認証しよう
	function validUser(){
		$options = array(
			'conditions' => array(
				"User.mail"     => $this->data["User"]['mail'],
				"User.password" => md5($this->data["User"]['password'])
			)
		);
		return $this->find('first', $options);
	}
}
?>