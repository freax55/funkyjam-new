<?php
class Inquiry extends AppModel
{
	var $name = 'Inquiry';

	var $validate = array(
		'name' => array(
			'rule' => 'notBlank',
			'message' => 'お名前を入力してください。'
		),
		'email' => array(
			'rule1' => array(
				'rule' => 'notBlank',
				'message' => 'メールアドレスを入力してください。'
			),
			'rule2' => array(
				'rule' => array('email'),
				'message' => 'メールアドレスを正しく入力してください。'
			),
		),
		'title' => array(
			'rule' => 'notBlank',
			'message' => 'タイトルを入力してください。'
		),
		'comment' => array(
			'rule' => 'notBlank',
			'message' => 'お問い合わせ内容を入力してください。'
		),
	);
}
?>