<?php
class Term extends AppModel {
	var $name = "Term";
	var $useTable = 'terms';
	var $useDbConfig = 'dbwp';
	var $primaryKey = 'term_id';

	function getTerm($name) {
		$term = $this->find('first', [
			'conditions' => [
				'Term.name' => $name,//$artist . '/' . $action
			],
			// 'fileds' => [
			// 	'Term.name',
			// 	'Term.term_id'
			// ]
		]);
		if($term) {
			return $term;
		} else {
			return false;
		}
	}

}
