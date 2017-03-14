<?php
class Role extends AppModel
{
	var $name = 'Role';

	public function find($type='first', $options = array()) {
		switch ($type) {
			case "list":
				return Set::combine(parent::find('all', array('order' => 'Role.id ASC')), '{n}.Role.id', '{n}.Role.name_ja');
				break;
			default:
				return parent::find($type, $options);
		}
	}

	var $hasMany = array(
		"User" => array(
			"className"   => "User",
			"foreignKey"  => "id",
			"conditions"  => "",
			"order"       => "",
			"limit"       => "",
			"dependent"   => false,
			"exclusive"   => false,
			"finderQuery" => ""
		),
	);

	var $validate = array(
		'name' => array(
			'rule' => array('notBlank'),
			'message' => '権限名を入力してください！'
		),
		'name_ja' => array(
			'rule' => array('notBlank'),
			'message' => '権限名（日本語）を入力してください！'
		),
	);
}
?>