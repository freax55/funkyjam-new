<?php
class Option extends AppModel {
	var $name = "Option";
	var $useTable = 'options';
	var $useDbConfig = 'dbwp';
	var $primaryKey = 'option_id';

	// function getTerm($name) {
	// 	$term = $this->find('first', [
	// 		'conditions' => [
	// 			'Term.name' => $name,//$artist . '/' . $action
	// 		],
	// 		// 'fileds' => [
	// 		// 	'Term.name',
	// 		// 	'Term.term_id'
	// 		// ]
	// 	]);
	// 	if($term) {
	// 		return $term;
	// 	} else {
	// 		return false;
	// 	}
	// }

}
