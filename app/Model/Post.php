<?php
class Post extends AppModel {
	var $name = "Post";
	var $useTable = 'posts';
	var $useDbConfig = 'dbwp';
	var $primaryKey = 'ID';

	function getPostsById($ids, $fields=[]) {

		$_options = [
			'conditions' => [
				'ID' => $ids,
				'post_status' => 'publish',
				'post_type' => 'post'
			],
			'order' => [
				// 'ID' => 'ASC'
				'post_date' => 'DESC'
			],
			'recursive' => 2,
		];
		$options = array_merge($_options, $fields);
		// debug($options);
		$posts = $this->find('all', $options);
		if($posts) {
			return $posts;
		} else {
			return false;
		}
	}

	function getArtistHeader($id){
		$post_header = $this->find('first',[
			'conditions' => [
				'ID' => $id
			],
			'fields' => [
				'guid'
			]
		]);
		return strstr($post_header['Post']['guid'], '/img/');
	}

	function getNewsOptionsById($ids, $fields=null) {
		$options = array(
			'conditions' => [
				'ID' => $ids,
				'post_status' => 'publish',
				'post_type' => 'post'
			],
			'order' => [
				// 'ID' => 'ASC'
				'post_date' => 'DESC'
			],
			'limit' => 1
		);
		return $options;
	}

	// function 

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
