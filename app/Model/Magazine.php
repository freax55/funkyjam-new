<?php
class Magazine extends AppModel {
	var $name = "Magazine";
	var $useDbConfig = 'pg';
	var $useTable = 'magazine';
	var $primaryKey = 'account_no';

	var $validate_contact = array(
		// 'contact' => array(
			'name' => array(
				'rule' => 'notBlank',
				'message' => '入力をお願いします。'
			),
			'mail' => array(
				'rule1' => array(
					'rule' => 'notBlank',
					'message' => '入力をお願いします。'
				),
				'rule2' => array(
					'rule' => 'isMail',
					'message' => '形式をご確認ください。'
				)
			),
			'mail2' => array(
				'rule1' => array(
					'rule' => 'notBlank',
					'message' => '入力をお願いします。'
				),
				'rule2' => array(
					'rule' => 'isMail',
					'message' => '形式をご確認ください。'
				),
				'rule3' => array(
					'rule' => 'matchMail',
					'message' => '確認入力と一致していません。入力をご確認ください。',
				),
			),
			'type' => array(
				'rule' => 'naturalNumber',
				'message' => '選択をお願いします。'
			),
			'content' => array(
				'rule' => 'notBlank',
				'message' => '入力をお願いします。'
			),
		// ),
	);

	function isMail($value){
		// debug(current($value));
		$result = preg_match('/^(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|"[^\\\x80-\xff\n\015"]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015"]*)*")(?:\.(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|"[^\\\x80-\xff\n\015"]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015"]*)*"))*@(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\])(?:\.(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\]))*$/', current($value));
		// debug($result);
		return $result;
	}


	function matchMail($value){
		if($this->data['Magazine']['mail'] == $value['mail2']){
			return true;
		}
		return false;
	}

}
?>