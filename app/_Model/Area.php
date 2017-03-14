<?php
class Area extends AppModel
{
	var $name = "Area";

	var $validate = array(
		'pref_id' => array(
			'rule' => array('validSelectString'),
			'message' => '都道府県を選択してください。'
		),
		'name' => array(
			'rule1' => array(
				'rule' => 'notBlank',
				'message' => 'エリア名を入力してください。'
			),
			'rule2' => array(
				'rule' => 'isUnique',
				'message' => 'このエリア名は既に使われています。'
			)
		),
	);

	function getArea($station_id) {
		$data = $this->find('first', [
			'conditions' => [
				'Area.id' => $station_id,
				'Area.cnt != 0'
			],
			'fields' => [
				'Area.id',
				'Area.name',
				'Area.cnt'
			],
		]);
		return $data;
	}

	function getAreas($pref_id=0) {
		$options = [
			'fields' => [
				'Area.id',
				'Area.pref_id',
				'Area.name',
				'Area.cnt',
			],
		];
		if ($pref_id != 0) {
			$options['conditions'][] = [
				'Shop.pref_id' => $pref_id
			];
		}
		$data = $this->find('all',$options);
		return $data;
	}

	function getAreaName($area_id = 0) {
		if($area_id != 0) {
			$data = $this->find('first', [
				'conditions' => [
					'Area.id' => $area_id,
				],
				'fields' => [
					'Area.name',
				],
			])['Area']['name'];
			if($data){
				return $data;
			}
			return null;
		}
		return null;
	}
}
?>