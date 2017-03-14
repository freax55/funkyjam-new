<?php
class IineUser extends AppModel {
	var $name = "IineUser";

	var $belongsTo = array(
		'ReviewUser' => array(
			'className' => 'ReviewUser',
			'foreignKey' => 'review_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => ''
		)
	);

	var $validate = array(
		'pref_id' => array(
			'rule' => array('validSelectString'),
			'message' => '都道府県を選択してください。'
		),
		'name' => array(
			'rule1' => array(
				'rule' => 'notBlank',
				'message' => '市区町村を入力してください。'
			),
			'rule2' => array(
				'rule' => 'isUnique',
				'message' => '市区町村名は既に使われています。'
			)
		),
	);
}
?>