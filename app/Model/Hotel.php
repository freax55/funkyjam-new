<?php
class Hotel extends AppModel
{
	public $name = "Hotel";

	public $hasMany = [
		'ReviewUser' => [
			'className'   => 'ReviewUser',
			'foreignKey'  => 'hotel_id',
			'dependent'   => true,
			'exclusive'   => false,
			'order' => [
				'created' => 'DESC'
			]
		],
	];

	var $validate = array(
		'type_id' => array(
			'rule' => array('validSelectString'),
			'message' => 'ホテルの種類を選択してください。'
		),
		'pref_id' => array(
			'rule' => array('validSelectString'),
			'message' => '都道府県を選択してください。'
		),
		'city_id' => array(
			'rule' => array('validSelectString'),
			'message' => '市区町村を選択してください。'
		),
		// 'area_id' => array(
		// 	'rule' => array('validSelectString'),
		// 	'message' => 'エリアを選択してください。'
		// ),
		'name' => array(
			'rule' => 'notBlank',
			'message' => 'ホテル名を入力してください。'
		),
		'address' => array(
			'rule' => 'notBlank',
			'message' => '住所を入力してください。'
		),
		// 'url' => array(
		// 	'rule1' => array(
		// 		'rule' => 'notBlank',
		// 		'message' => 'URLを入力してください。'
		// 	),
		// 	'rule2' => array(
		// 		'rule' => 'isUnique',
		// 		'message' => 'URLは既に使われています。'
		// 	)
		// ),
		'tel' => array(
			'rule' => 'notBlank',
			'message' => '電話番号を入力してください。'
		),
		'min_charge' => array(
			'rule' => 'notBlank',
			'message' => '最安値を入力してください。'
		),
	);

	function getHotelTypes() {
		return [
			1 => 'シティホテル',
			2 => 'ビジネスホテル',
			3 => 'サードウェーブホテル',
		];
	}

	function getPvRanking($limit=30, $pref_id=0){
		$options = [
			'conditions' => [
				'Hotel.per >=' => 99
			],
			'fields' => [
				'Hotel.id',
				'Hotel.name',
				'Hotel.pref',
				'Hotel.city',
				'Hotel.pref_id',
				'Hotel.city_id',
				'Hotel.catch_copy',
			],
			'order' => [
				'Hotel.cnt_pv' => 'DESC'
			],
			'limit' => $limit,
			'recursive' => '-1'
		];
		if ($pref_id != 0) {
			$options['conditions'][] = [
				'Hotel.pref_id' => $pref_id
			];
		}
		$data = $this->find('all', $options);
		return $data;
	}

	function getHotel($hotel_id) {
		$data = $this->find('first', [
			'conditions' => [
				'Hotel.id' => $hotel_id,
				'Hotel.status' => 'y',
			],
			'fields' => [
				'Hotel.id',
				'Hotel.dayuse',
				'Hotel.type_id',
				'Hotel.pref_id',
				'Hotel.city_id',
				'Hotel.name',
				'Hotel.tel',
				'Hotel.url',
				'Hotel.square_meter',
				'Hotel.min_charge',
				'Hotel.dayuse',
				'Hotel.address',
				'Hotel.lat',
				'Hotel.lon',
				'Hotel.station_ids',
			],
		]);
		if ($data) {
			return $data;
		} else {
			return false;
		}
	}

	function getHotels($pref_id, $place_id, $type) {
		$this->hasMany['ReviewUser']['fields'] = [
			'ReviewUser.call',
		];
		$options = [
			'conditions' => [
				'Hotel.pref_id' => $pref_id,
				'Hotel.status' => 'y',
			],
			'fields' => [
				'Hotel.id',
				'Hotel.dayuse',
				'Hotel.type_id',
				'Hotel.pref_id',
				'Hotel.city_id',
				'Hotel.station_ids',
				'Hotel.name',
				'Hotel.address',
				'Hotel.min_charge',
			],
			'order' => [
				'Hotel.cnt_pv' => 'DESC',
			],
		];
		switch ($type) {
			case 'city':
				$options['conditions']['Hotel.city_id'] = $place_id;
				break;
			case 'station':
				$options['conditions'][] = "Hotel.station_ids LIKE '%\"" .$place_id. "\"%'";
				break;
		}
		$data = $this->find('all', $options);
		return $data;
	}
}
?>