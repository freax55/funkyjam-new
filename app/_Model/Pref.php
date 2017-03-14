<?php
class Pref extends AppModel
{
	var $name = 'Pref';
	var $useTable = 'prefectures';

	function getPreflist() {
		return $this->find('list');
	}
}