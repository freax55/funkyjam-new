<?php
class Station extends AppModel
{
	var $name = "Station";

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

	function getStation($station_id) {
		$data = $this->find('first', [
			'conditions' => [
				'Station.id' => $station_id,
				'Station.cnt != 0'
			],
			'fields' => [
				'Station.id',
				'Station.name',
				'Station.cnt'
			],
		]);
		return $data;
	}

	function getStationsForHotel($station_ids) {
		$data = $this->find('all', [
			'conditions' => [
				'Station.id' => $station_ids,
				'Station.cnt != 0'
			],
			'fields' => [
				'Station.id',
				'Station.name',
				'Station.cnt',
			],
			'order' => [
				'Station.cnt' => 'DESC',
			]
		]);
		return $data;
	}

	function getStations($pref_id) {
		$data = $this->find('all', [
			'conditions' => [
				'Station.pref_id' => $pref_id,
				'Station.cnt != 0'
			],
			'fields' => [
				'Station.id',
				'Station.name',
				'Station.cnt',
			],
			'order' => [
				'Station.cnt' => 'DESC',
			]
		]);
		return $data;
	}
	function getStationsByCities($ary_city_ids) {
		$ary_station_ids = array();
		foreach ($ary_city_ids as $city_id) {
			$station_ids = $this->find('list', [
				'conditions' => [
					'Station.city_id' => $city_id
				],
				'fields' => [
					'Station.id'
				]
			]);
			if ($station_ids) {
				foreach ($station_ids as $station_id) {
					$ary_station_ids[] = $station_id;
				}
			}
		}
		if (empty($ary_station_ids)) {
			return false;
		}
		return array_unique($ary_station_ids);
	}
	function convertArrayStations($ary_station_ids) {
		$delivery_stations = array();
		foreach ($ary_station_ids as $station_id) {
			$delivery_stations[$station_id] = $station_id;
		}
		return $delivery_stations;
	}
}
?>