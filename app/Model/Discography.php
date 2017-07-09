<?php
class Discography extends AppModel {
	var $name = "Discography";
	var $useTable = 'discographies';
	var $useDbConfig = 'dbwp';
	var $primaryKey = 'discography_id';

	// function getDiscTypes() {
	// 	return array(
	// 		'album',
	// 		'bestalbum',
	// 		'single',
	// 	);
	// }

	function findById($id){
		$options = [
			'conditions' => [
				'discography_id' => $id
			]
		];
		$data = $this->find('first', $options);
		return $data;
	}

	function getData($artist, $extend_options = null){
		$options = [
			'conditions' => [
				'artist' => $artist,
			],
			'order' => [
				'release' => 'DESC'
			]
		];
		$data = $this->find('all', $options);
		return $data;
	}

	function getOptions($artist, $extend_options = null){
		$_options = [
			'conditions' => [
				'artist' => $artist
			],
			// 'order' => [
			// 	'release' => 'DESC'
			// ]
		];
		$options = array_merge_recursive($_options, $extend_options);
		// $options = $_options + $extend_options;
		// $data = $this->find('all', $options);
		return $options;
	}

	function getDataGroupbyType($artist, $extend_options = null){
		$ary = null;
		$options = [
			'conditions' => [
				'artist' => $artist,
				'publish' => 'y'
			],
			'order' => [
				'release' => 'DESC'
			]
		];
		$data = $this->find('all', $options);
		foreach($data as $v) {
			$ary[$v['Discography']['type']][] = $v;
		}
		return $ary;
	}

}
