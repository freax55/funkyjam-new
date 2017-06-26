<?php
class Discography extends AppModel {
	var $name = "Discography";
	var $useTable = 'discographies';
	var $useDbConfig = 'dbwp';
	// var $primaryKey = 'ID';

	// function getDiscTypes() {
	// 	return array(
	// 		'album',
	// 		'bestalbum',
	// 		'single',
	// 	);
	// }

	function getData($artist, $extend_options = null){
		$options = [
			'conditions' => [
				'artist' => $artist
			],
			'order' => [
				'release' => 'DESC'
			]
		];
		$data = $this->find('all', $options);
		return $data;
	}

	function getDataGroupbyType($artist, $extend_options = null){
		$ary = null;
		$options = [
			'conditions' => [
				'artist' => $artist
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
