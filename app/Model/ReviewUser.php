<?php
class ReviewUser extends AppModel {
	public $name = "ReviewUser";

	var $hasMany = [
		'IineUser' => [
			'className'  => 'IineUser',
			'foreignKey' => 'review_id',
			'dependent'  => true,
			'exclusive'  => false,
			'order' => [
				'created' => 'DESC'
			]
		],
	];
	var $belongsTo = array(
		'Hotel' => array(
			'className' => 'Hotel',
			'foreignKey' => 'hotel_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => ''
		)
	);

	var $validate = array(
		'star' => array(
			'rule' => array('validSelectString'),
			'message' => '星の数を選択してください。'
		),
		'comment' => array(
			'rule' => 'notBlank',
			'message' => '口コミを入力してください。'
		),
	);

	function getReviewsFromHotel($hotel_id) {
		$this->hasMany['IineUser']['fields'] = [
			'IineUser.id'
		];
		$data = $this->find('all', [
			'conditions' => [
				'ReviewUser.hotel_id' => $hotel_id,
			],
			'fields' => [
				'ReviewUser.id',
				'ReviewUser.hotel_id',
				'ReviewUser.name',
				'ReviewUser.call',
				'ReviewUser.star',
				'ReviewUser.comment',
				'ReviewUser.created'
			],
			'order' => [
				'ReviewUser.created' => 'DESC',
			],
		]);
		return $data;
	}
}
?>