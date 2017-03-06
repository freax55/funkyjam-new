<?php
class City extends AppModel
{
	var $name = "City";

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

	function getCityName($city_id) {
		$data = $this->find('first', [
			'conditions' => [
				'City.id' => $city_id,
			],
			'fields' => [
				'City.name',
			],
		])['City']['name'];
		return $data;
	}

	function getCity($city_id) {
		$data = $this->find('first', [
			'conditions' => [
				'City.id' => $city_id,
				'City.cnt != 0'
			],
			'fields' => [
				'City.id',
				'City.name',
				'City.cnt'
			],
		]);
		return $data;
	}

	function getCities($pref_id) {
		$data = $this->find('all', [
			'conditions' => [
				'City.pref_id' => $pref_id,
				'City.cnt != 0'
			],
			'fields' => [
				'City.id',
				'City.name',
				'City.cnt'
			],
			'order' => [
				'City.cnt' => 'DESC',
			]
		]);
		return $data;
	}

	function getCitieslist($pref_id) {
		return $this->find('list', [
			'conditions' => [
				'City.pref_id' => $pref_id
			]
		]);
	}
}
?>