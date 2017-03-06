<?php
class Blog extends AppModel {
	public $name = "Blog";
	// var $useTable = 'wp_posts';
	// var $useDbConfig = 'wp';

	// function getBlogFeed($limit=10){
	// 	$feed = $this->find('all', [
	// 		'conditions' => [
	// 			'post_status' => 'publish',
	// 			'post_type'   => 'post'
	// 		],
	// 		'fields' => [
	// 			'post_title',
	// 			'post_date',
	// 			'guid'
	// 		],
	// 		'order' => [
	// 			'post_date' => 'DESC'
	// 		],
	// 		'limit' => $limit
	// 	]);
	// 	return $feed;
	// }
}