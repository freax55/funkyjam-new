<?php
class Discography extends AppModel {
	var $name = "Discography";
	var $useTable = 'discographies';
	var $useDbConfig = 'dbwp';
	// var $primaryKey = 'ID';

	function getDiscTypes() {
		return array(
			'album',
			'bestalbum',
			'single',
		);
	}




}
