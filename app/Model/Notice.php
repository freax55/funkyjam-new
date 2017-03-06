<?php
class Notice extends AppModel
{
	var $name = 'Notice';

	var $validate = array(
		'title' => array(
			'rule' => 'notBlank',
			'message' => 'タイトルを入力してください。'
		),
		'content' => array(
			'rule' => 'notBlank',
			'message' => '本文を入力してください。'
		),
	);
}
?>