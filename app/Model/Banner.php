<?php
class Banner extends AppModel
{
	var $name = 'Banner';

	var $belongsTo = array(
		"Shop" => array(
			"className" => "Shop",
			"foreignKey" => "shop_id",
			'fields' => [
				'id',
				'name'
			]
		)
	);

	var $validate = array(
		'shop_id' => [
			'rule1' => [
				'rule' => 'notEmpty',
				'message' => '店舗名を入力してください。'
			],
			'rule2' => [
				'rule' => ['validShopName', 'shop_id'],
				'message' => 'この店舗名は存在しません。'
			]
		],
		'type_id' => [
			'rule' => ['validSelectString'],
			'message' => 'バナータイプを選択してください。'
		],
		'caption' => [
			'rule' => ['between',5,20],
			'message' => 'キャプションは5文字以上20文字以内で入力してください。'
		]
		// 'pref_id' => [
		// 	'rule' => ['validSelectAreaPref'],
		// 	'message' => '都道府県を選択してください。',
		// 	'on' => 'update'
		// ],
		// 'pref_id' => [
		// 	'rule' => ['validSelectPrefId'],
		// 	'message' => 'エリア大バナーの場合は、都道府県を選択してください。'
		// ],
		// 'area_id1' => [
		// 	'rule' => ['validSelectAreaId'],
		// 	'message' => 'エリア大バナーの場合は、エリアを選択してください。'
		// ],
		// 'img' => [
		// 	'upload-file' => [
		// 		'rule' => ['uploadError'],
		// 		'message' => 'アップロードするファイルを選択してください。'
		// 	],
		// 	'mimetype' => [
		// 		'rule' => ['mimeType', ['image/jpeg', 'image/png', 'image/gif']],
		// 		'message' => 'このファイルはアップロード出来ません。'
		// 	],
		// 	'extension' => [
		// 		'rule' => ['extension', ['jpg', 'jpeg', 'png', 'gif']],
		// 		'message' => 'アップロード出来る拡張子は、jpg,jpeg,png,gif です。'
		// 	],
		// 	'size' => [
		// 		'maxFileSize' => [
		// 			'rule' => ['fileSize', '<=', '10MB'],
		// 			'message' => '10MBを超えるファイルはアップロード出来ません。'
		// 		],
		// 		'minFileSize' => [
		// 			'rule' => ['fileSize', '>',  0],
		// 			'message' => 'ファイルサイズが小さすぎます。',
		// 		],
		// 	]
		// ]
	);

	function validShopName(){
		$this->Shop = Classregistry::init('Shop');;

		$args = func_get_args();
		$field = $args[1];
		$model = $this->name;
		if ($this->data[$model][$field] == "0") {
			return true;
		} else {
			$options = array(
				'conditions' => array(
					'Shop.name' => $this->data[$model][$field]
				),
				'fields' => array(
					'Shop.name'
				),
				'recursive' => '-1'
			);
			$data_shop = $this->Shop->find('first', $options);
			if (!$data_shop) {
				return false;
			}
			return true;
		}
	}

	function validSelectAreaPref(){
		$args = func_get_args();
		// エリア大バナーの時に発動
		if ($this->data['Banner']['type_id'] == 5) {
			foreach ($args[0]['area_pref_id'] as $k => $v) {
				if ($v != 0) {
					return true;
				}
			}
			return false;
		} else {
			return true;
		}
	}

	function getBannerTypes($is_form=false){
		$types = [
			1 => [
				'name' => 'グリッド嬢バナー',
				'width' => 310,
				'height' => 190,
				'width_sp' => 710,
				'height_sp' => 380,
			],
			2 => [
				'name' => 'ブックマークバナー',
				'width' => 310,
				'height' => 190,
				'width_sp' => 710,
				'height_sp' => 380,
			],
			3 => [
				'name' => 'トップスクエアバナー',
				'width' => 300,
				'height' => 300,
				'width_sp' => 710,
				'height_sp' => 308,
			],
		];
		if ($is_form) {
			foreach ($types as $k => $v) {
				$types[$k] = $v['name'];
			}
		}
		return $types;
	}

	function getBanners($type){
		switch ($type) {
			case 'grid':
				$type_id = 1;
				break;
			case 'bookmark':
				$type_id = 2;
				break;
			case 'top_square':
				$type_id = 3;
				break;
			default:
				break;
		}
		$recursive = 1;
		$this->Shop->unbindModel([
			'hasMany' => [
				'Girl',
				'News',
				'Banner',
				'Schedule'
			]
		]);
		$options = [
			'conditions' => [
				'Shop.status' => 'y',
				'Banner.status' => 'y',
				'Banner.type_id' => $type_id,
				// 'Banner.img != "" OR Banner.img_sp != ""',
			],
			'fields' => [
				'Banner.id',
				'Banner.shop_id',
				'Banner.status',
				'Banner.type_id',
				'Banner.caption',
				'Banner.img_pc',
				'Banner.img_sp',
				'Shop.id',
				'Shop.name',
				'Shop.plan_id',
				'Shop.job_id',
				'Shop.detail_url',
				'Shop.url',
				'Shop.url_sp',
				'Shop.pref',
				'Shop.city',
				'Shop.pref_id',
				'Shop.city_id',
			],
			'recursive' => $recursive
		];

		if ($type_id == 1) {
			$options['order'] = 'rand()';
			$options['limit'] = 3;
		// } else if ($type_id == 2) {
		// 	$options['order'] = [
		// 		'Banner.sort_id' => 'ASC'
		// 	];
		} else if ($type_id == 2) {
			$options['order'] = 'rand()';
			$options['limit'] = 3;
		} else if ($type_id == 3) {
			$options['order'] = 'rand()';
			$options['limit'] = 1;
		}
		$data = $this->find('all', $options);
		return $data;
	}
}
?>