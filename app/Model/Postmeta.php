<?php
class Postmeta extends AppModel {
	var $name = "Postmeta";
	var $useTable = 'postmeta';
	var $useDbConfig = 'dbwp';
	var $primaryKey = 'meta_id';

	// var $belongsTo = array(
	// 	"Post" => array(
	// 		"className" => "Post",
	// 		"foreignKey" => "post_id",
	// 		// 'fields' => [
	// 		// 	'id',
	// 		// 	'name',
	// 		// ]
	// 	)
	// );

	function getPostPages($type) {
		$this->bindModel([
			'belongsTo' => [
				"Post" => array(
					"className" => "Post",
					"foreignKey" => "post_id",
					// 'fields' => [
					// 	'id',
					// 	'name',
					// ]
				)			
			]
		]);
		return $this->find('all', [
			'conditions' => [
				'Postmeta.meta_value' => $type,
				'Post.post_status' => 'publish',
			],
			// 'fields' => [
			// 	'meta_id',
			// 	'post_id'
			// ],
			'order' => [
				'Postmeta.post_id' => 'DESC'
			],
			'recursive' => 2
		]);
	}
}
