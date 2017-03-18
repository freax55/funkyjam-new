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
			]
		]);
		if($posts) {
			return $posts;
		} else {
			return false;
		}
	}

}
