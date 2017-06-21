<?php
class Post extends AppModel {
	var $name = "Post";
	var $useTable = 'posts';
	var $useDbConfig = 'dbwp';
	var $primaryKey = 'ID';

	function getPostsById($ids) {
		$posts = $this->find('all', [
			'conditions' => [
				'ID' => $ids,
				'post_status' => 'publish',
				'post_type' => 'post'
			],
			'order' => [
				'ID' => 'ASC'
			],
			'recursive' => 2,
		]);
		if($posts) {
			return $posts;
		} else {
			return false;
		}
	}

	function getNewsOptionsById($ids) {
		$options = array(
			'conditions' => [
				'ID' => $ids,
				'post_status' => 'publish',
				'post_type' => 'post'
			],
			'order' => [
				'ID' => 'ASC'
			],
			'limit' => 1
		);
		return $options;
	}

	function bindThumbnail() {
		$this->bindModel([
			'hasOne' => [
				'Postmeta' => [
					'foreingKye' => 'post_id',
					'conditions' => [
						'meta_key' => '_thumbnail_id'
					],
				]
			]
		]);
		App::uses('Postmeta', 'Model');
		$Pm = new Postmeta();
		$Pm->bindModel([
			'belongsTo' => [
				'Post' => [
					"className" => "Post",
					"foreignKey" => "meta_value",
					'fields' => [
						'ID',
						'guid',
					]
				]
			]
		]);
	}

	// function getNewsList($aritst){
	// 	$this->bindThumbnail();
	// 	// if($artist != null) {
	// 	// 	$
	// 	// }


	// }

}
