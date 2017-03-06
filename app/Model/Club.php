<?php
class Club extends AppModel {
	var $name = "Club";

	var $validate_basic = [
		'user_id' => [
			'rule1' => [
				'rule' => 'notBlank',
				'message' => '店舗ユーザー名を入力してください。'
			],
			'rule2' => [
				'rule' => ['validUserName', 'user_id'],
				'message' => 'この店舗ユーザー名は存在しません。'
			]
		],
		'agency_id' => [
			'rule1' => [
				'rule' => 'notBlank',
				'message' => '代理店ユーザー名を入力してください。'
			],
			'rule2' => [
				'rule' => ['validUserName', 'agency_id'],
				'message' => 'この代理店ユーザー名は存在しません。'
			]
		],
		'name' => [
			'rule' => 'notBlank',
			'message' => '店名を入力してください。'
		],
		// 'tel' => [
		// 	'rule' => 'notBlank',
		// 	'message' => '電話番号を入力してください。',
		// ],
		'url' => [
			// 'rule1' => [
			// 	'rule' => 'notBlank',
			// 	'message' => 'URLを入力してください。'
			// ],
			'rule1' => [
				'rule' => ['url', true],
				'message' => 'URLを正しく入力してください。',
				'allowEmpty' => true
			],
			'rule2' => [
				'rule' => 'isUnique',
				'message' => 'URLは既に使われています。',
				'allowEmpty' => true
			]
		],
		// 'catch_copy' => [
		// 	'rule1' => [
		// 		'rule' => 'notBlank',
		// 		'message' => 'キャッチコピーを入力してください。',
		// 		// 'on' => 'update'
		// 	],
		// 	'rule2' => [
		// 		'rule' => ['maxLength', 60],
		// 		'message' => 'キャッチコピーは60文字以内で入力してください。'
		// 	],
		// ],
	];

	var $validate_area = [
		'pref_id' => [
			'rule' => ['validSelectString'],
			'message' => '都道府県を選択してください。',
			// 'on' => 'update'
		],
		'city_id' => [
			'rule' => ['validSelectString'],
			'message' => '市区町村を選択してください。',
			// 'on' => 'update'
		],
		'town_id' => [
			'rule' => ['validAddressTownId'],
			'message' => '町域を選択してください。',
			// 'on' => 'update'
		],
		'address_num' => [
			'rule' => ['validAddressNum'],
			'message' => '番地まで入力してください。',
			// 'on' => 'update'
		],
		// 'area_pref_id' => [
		// 	'rule' => ['validSelectAreaPref'],
		// 	'message' => '都道府県を選択してください。',
		// 	'on' => 'update'
		// ],
		// 'area_id' => [
		// 	'rule' => ['validSelectArea'],
		// 	'message' => 'エリアを選択してください。',
		// 	'on' => 'update'
		// ],
	];

	/**
	 * [validUserName description]
	 * @return [type] [description]
	 */
	function validUserName(){
		$this->User = Classregistry::init('User');

		$args = func_get_args();
		$field = $args[1];
		$model = $this->name;
		if ($this->data[$model][$field] == "0") {
			return true;
		} else {
			$options = array(
				'conditions' => array(
					'User.name' => $this->data[$model][$field]
				),
				'fields' => array(
					'User.name'
				),
				'recursive' => '-1'
			);
			$data_user = $this->User->find('first', $options);
			if (!$data_user) {
				return false;
			}
			return true;
		}
	}

	function validSelectAreaPref(){
		$args = func_get_args();
		// print '<pre>';
		// print_r($args[0]);
		// print '</pre>';
		foreach ($args[0]['area_pref_id'] as $k => $v) {
			if ($v != 0) {
				return true;
			}
		}
		return false;
	}

	function validSelectArea(){
		$args = func_get_args();
		// print '<pre>';
		// print_r($args[0]);
		// print '</pre>';
		foreach ($args[0]['area_id'] as $k => $v) {
			if ($v != 0) {
				return true;
			}
		}
		return false;
	}

	function validTags() {
		$args = func_get_args();
		// debug($args[0][key($args[0])]);
		// exit;
		// $tags = $args[0][key($args[0])];
		$tags = json_decode($args[0][key($args[0])], true);
		if (in_array(1, $tags)) {
			return true;
		}
		return false;
	}

	function validAddressTownId() {
		if (($this->data['Shop']['job_id'] != 1) && $this->data['Shop']['town_id'] == '0') {
			return false;
		}
		return true;
	}

	function validAddressNum() {
		if (($this->data['Shop']['job_id'] != 1) && $this->data['Shop']['address_num'] == "") {
			return false;
		}
		return true;
	}

	/**
	 * [unbindModelShop description]
	 * @return [type] [description]
	 */
	function unbindModelShop($options=['limit'=>1]){
		$this->unbindModel([
			'hasMany' => [
				'News',
				'Schedule'
			]
		]);
		$this->Girl->unbindModel([
			'belongsTo' => [
				'Shop',
			],
			'hasMany' => [
				'Schedule'
			]
		]);
		$this->hasMany['Girl']['conditions'] = [
			'Girl.status' => 'y'
		];
		$this->hasMany['Girl']['fields'] = [
			'Girl.id',
			'Girl.name',
			'Girl.age',
			'Girl.size_t',
			'Girl.size_b',
			'Girl.size_c',
			'Girl.size_w',
			'Girl.size_h',
			'Girl.tags'
		];
		$this->hasMany['Girl']['order'] = [
			'Girl.sort_id' => 'ASC',
			'Girl.id' => 'ASC'
		];
		$this->hasMany['Girl']['limit'] = $options['limit'];

		$this->Girl->hasMany['GirlImage']['fields'] = [
			'GirlImage.name'
		];
		$this->Girl->hasMany['GirlImage']['order'] = [
			'GirlImage.sort_id' => 'ASC',
			'GirlImage.id' => 'ASC'
		];
		$this->Girl->hasMany['GirlImage']['limit'] = 1;
	}

	/**
	 * [getShops description]
	 * @param  [type] $options [description]
	 * @param  [type] $plan_id [description]
	 * @return [type]          [description]
	 */
	function getShops($options, $plan_id){
		$this->unbindModelShop(['limit'=>3]);
		$data = $this->find('all', array_merge([
				'fields' => [
					'Shop.id',
					'Shop.job_id',
					'Shop.pref_id',
					'Shop.city_id',
					'Shop.plan_id',
					'Shop.name',
					'Shop.tel',
					'Shop.url',
					'Shop.pref',
					'Shop.city',
					'Shop.fee_admission',
					'Shop.fee_nomination',
					'Shop.fee_extension',
					'Shop.fee_delivery_min',
					'Shop.total_min',
					'Shop.price_min',
					'Shop.discount_price',
					'Shop.discount_bonus',
					'Shop.status_discount',
					'Shop.catch_copy',
					'Shop.tags',
					'Shop.description',
					'Shop.created',
					'Shop.business_time_24',
					'Shop.business_time_start_hinode',
					'Shop.business_time_end_last',
					'Shop.business_time_start',
					'Shop.business_time_end',
				],
				// 'contain' => $this->Girl->getFieldsGirlWithOneImage(),
				'recursive' => '2'
			], $options
		));
		return $data;
	}

	/**
	 * [getNewShops description]
	 * @param  integer $limit   [description]
	 * @param  integer $pref_id [description]
	 * @return [type]           [description]
	 */
	function getNewShops($pref_id=0, $plan=null){
		$this->unbindModelShop();
		$options = [
			'conditions' => [
				'Shop.status' => 'y',
				'Shop.created >=' => ONE_WEEK_AGO
			],
			'fields' => [
				'Shop.id',
				'Shop.name',
				'Shop.plan_id',
				'Shop.job_id',
				'Shop.pref',
				'Shop.city',
				'Shop.pref_id',
				'Shop.city_id',
				'Shop.catch_copy',
				'Shop.description',
				'Shop.created',
			],
			'order' => [
				'Shop.plan_id' => 'DESC',
				'Shop.modified' => 'DESC',
				'Shop.created' => 'DESC'
			],
			'recursive' => '2'
		];
		if ($pref_id != 0) {
			$options['conditions'][] = [
				'Shop.pref_id' => $pref_id
			];
		}
		if ($plan != null) {
			if ($plan == 'pay') {
				$options['conditions'][] = [
					'Shop.plan_id !=' => 0
				];
			} else {
				$options['conditions'][] = [
					'Shop.plan_id' => 0
				];
			}
		}
		$data = $this->find('all', $options);
		return $data;
	}

	/**
	 * [getPvRanking description]
	 * @param  integer $limit   [description]
	 * @param  integer $pref_id [description]
	 * @return [type]           [description]
	 */
	function getPvRanking($limit=5, $pref_id=0){
		$this->unbindModelShop();
		$options = [
			'conditions' => [
				'Shop.plan_id != 0',
				'Shop.status' => 'y'
			],
			'fields' => [
				'Shop.id',
				'Shop.name',
				'Shop.job_id',
				'Shop.pref',
				'Shop.city',
				'Shop.pref_id',
				'Shop.city_id',
				'Shop.catch_copy',
			],
			'order' => [
				'Shop.cnt_pv' => 'DESC'
			],
			'limit' => $limit,
			'recursive' => 2
		];
		if ($pref_id != 0) {
			$options['conditions'][] = [
				'Shop.pref_id' => $pref_id
			];
		}
		$data = $this->find('all', $options);
		return $data;
	}

	function getSideBanners($pref_id=0,$conditions=[]){
		$this->unbindModelShop();
		$this->unbindModel([
			'hasMany' => [
				'Girl',
			]
		]);
		$options = [
			'conditions' => [
				'Shop.plan_id != 0',
				'Shop.img_rectangle != ""',
				'Shop.status' => 'y'
			],
			'fields' => [
				'Shop.id',
				'Shop.name',
				'Shop.job_id',
				'Shop.url',
				'Shop.pref',
				'Shop.city',
				'Shop.pref_id',
				'Shop.city_id',
				'Shop.img_rectangle',
			],
			'order' => [
				'Shop.to_top_datetime' => 'DESC'
			],
			'limit' => 15,
			'recursive' => 2
		];
		if ($pref_id != 0) {
			$options['conditions'][] = [
				'Shop.pref_id' => $pref_id
			];
		}
		if (!empty($conditions)) {
			if (array_key_exists("area", $conditions)) {
				$options['conditions'][] = [
					"Shop.area_ids LIKE '%\"" .$conditions['area']. "\"}%'"
				];
			}
			if (array_key_exists("station", $conditions)) {
				$options['conditions'][] = [
					"Shop.station_ids LIKE '%\"" .$conditions['station']. "\"%'"
				];
			}
			if (array_key_exists("city", $conditions)) {
				$options['conditions'][] = [
					"Shop.city_id = " . $conditions['city']
				];
			}
		}
		$data = $this->find('all', $options);
		return $data;
	}

	function getFieldsCommon() {
		return [
			'Shop.id',
			'Shop.plan_id',
			'Shop.name',
			'Shop.description',
			'Shop.total_min',
			'Shop.catch_copy',
			'Shop.job_id',
			'Shop.pref_id',
			'Shop.city_id',
			'Shop.pref',
			'Shop.city',
			'Shop.tel',
			'Shop.tags',
			'Shop.business_time_start',
			'Shop.business_time_end',
			'Shop.business_time_start_hinode',
			'Shop.business_time_end_last',
			'Shop.business_time_24',
			'Shop.to_top_datetime',
			'Shop.created',
			'Shop.modified',
			'Shop.status_discount'
		];

	}

	// Shop.deliveryからcity_idを配列で取得
	function getCitiesByDelivery($delivery){
		if ($delivery != null) {
			$ary_delivery = json_decode($delivery, true);
			if ($ary_delivery != null) {
				$ary_city_ids = array();
				foreach($ary_delivery as $pref_id => $ary_contents) {
					foreach ($ary_contents as $city_id => $contents) {
						$ary_city_ids[] = $city_id;
					}
				}
				return $ary_city_ids;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	// ↓ここから交際クラブ新規関数
	function getTimeZone(){
		$timezone['open'] = array(
			"09:00" => "09:00",
			"09:30" => "09:30",
			"10:00" => "10:00",
			"10:30" => "10:30",
			"11:00" => "11:00",
			"11:30" => "11:30",
			"12:00" => "12:00",
			"12:30" => "12:30",
			"13:00" => "13:00",
			"13:30" => "13:30",
			"14:00" => "14:00",
			"14:30" => "14:30",
			"15:00" => "15:00",
			"15:30" => "15:30",
			"16:00" => "16:00",
			"16:30" => "16:30",
			"17:00" => "17:00",
			"17:30" => "17:30",
			"18:00" => "18:00",
			"18:30" => "18:30",
			"19:00" => "19:00",
			"19:30" => "19:30",
			"20:00" => "20:00",
			"20:30" => "20:30",
			"21:00" => "21:00",
			"21:30" => "21:30",
			"22:00" => "22:00",
			"22:30" => "22:30",
			"23:00" => "23:00",
			"23:30" => "23:30",
			"00:00" => "00:00",
			"00:30" => "00:30",
			"01:00" => "01:00",
			"01:30" => "01:30",
			"02:00" => "02:00",
			"02:30" => "02:30",
			"03:00" => "03:00",
			"03:30" => "03:30",
			"04:00" => "04:00",
			"04:30" => "04:30",
			"05:00" => "05:00",
			"05:30" => "05:30",
			"06:00" => "06:00",
			"06:30" => "06:30",
			"07:00" => "07:00",
			"07:30" => "07:30",
			"08:00" => "08:00",
			"08:30" => "08:30",
		);
		$timezone['close'] = array(
			"19:00" => "19:00",
			"19:30" => "19:30",
			"20:00" => "20:00",
			"20:30" => "20:30",
			"21:00" => "21:00",
			"21:30" => "21:30",
			"22:00" => "22:00",
			"22:30" => "22:30",
			"23:00" => "23:00",
			"23:30" => "23:30",
			"00:00" => "00:00",
			"00:30" => "00:30",
			"01:00" => "01:00",
			"01:30" => "01:30",
			"02:00" => "02:00",
			"02:30" => "02:30",
			"03:00" => "03:00",
			"03:30" => "03:30",
			"04:00" => "04:00",
			"04:30" => "04:30",
			"05:00" => "05:00",
			"05:30" => "05:30",
			"06:00" => "06:00",
			"06:30" => "06:30",
			"07:00" => "07:00",
			"07:30" => "07:30",
			"08:00" => "08:00",
			"08:30" => "08:30",
			"09:00" => "09:00",
			"09:30" => "09:30",
			"10:00" => "10:00",
			"10:30" => "10:30",
			"11:00" => "11:00",
			"11:30" => "11:30",
			"12:00" => "12:00",
			"12:30" => "12:30",
			"13:00" => "13:00",
			"13:30" => "13:30",
			"14:00" => "14:00",
			"14:30" => "14:30",
			"15:00" => "15:00",
			"15:30" => "15:30",
			"16:00" => "16:00",
			"16:30" => "16:30",
			"17:00" => "17:00",
			"17:30" => "17:30",
			"18:00" => "18:00",
			"18:30" => "18:30",
		);
		return $timezone;
	}
}
?>