<?php
class TermRelationship extends AppModel {
	var $name = "TermRelationship";
	var $useTable = 'term_relationships';
	var $useDbConfig = 'dbwp';

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
