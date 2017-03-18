<?php
class TermRelationship extends AppModel {
	var $name = "TermRelationship";
	var $useTable = 'term_relationships';
	var $useDbConfig = 'dbwp';

	var $belongsTo = array(
		"Term" => array(
			"className" => "Term",
			"foreignKey" => "term_taxonomy_id",
			// 'fields' => [
			// 	'id',
			// 	'name',
			// ]
		)
	);


	function getObjectIds($term_name) {
		$data = $this->find('all', [
			'conditions' => [
				'Term.name' => $term_name
			],
			'fields' => [
				'TermRelationship.object_id',
				'Term.name'
			],
			'recursive' => 0
		]);
		return $data;
	}

	function getPostIds($term_id) {
		$ids = $this->find('all', [
			'conditions' => [
				'term_taxonomy_id' => $term_id
			] 
		]);
		if($ids) {
			return $ids;
		} else {
			return false;
		}
	}

}
