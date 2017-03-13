<?php
App::uses('Shell', 'Console');
App::uses('AppController', 'Controller');
class AwesomeShell extends Shell {
	public $uses = array(
		'City',
		'Shop'
	);

    public function startup() {
		parent::startup();
    }

	function gen_json() {
		for ($i=1; $i<=47; $i++) {
			$options = array(
				'conditions' => array(
					'City.pref_id' => $i
				),
				'fields' => array(
					'City.id',
					'City.pref_id',
					'City.name',
					'City.name_rome',
				),
				'order' => array(
					'City.pref_id' => 'ASC'
				),
			);
			$data = $this->City->find('all', $options);

			$cities = array();
			foreach ($data as $v) {
				$d = $v['City'];
				$cities[] = '{"city_id":' . $d['id'] . ',"name":"' . $d['name'] . '","name_en":"' . $d['name_rome'] . '"}';
			}
			$file_json = fopen(JSON_DIR_CITY . $i . '.json', 'w+');
			fputs($file_json, '[' .implode(',', $cities). ']');
			fclose($file_json);
		}
	}

	function arrayToJson() {
		$data_shops = $this->Shop->find('all', [
			// 'conditions' => [
			// 	'Shop.id' => [182,217,337]
			// ],
			'fields' => [
				'Shop.id',
				'Shop.price_board'
			],
			// 'limit' => 5
		]);
		foreach ($data_shops as $v) {
			$v = $v['Shop'];
			$target = unserialize($v['price_board']);
			// $this->out(pr($target));
			// return;
			// $target = json_decode($v['target'], true);
			if (!empty($target)) {
				$target = json_encode($target);
				// $target = serialize($target);
			} else {
				$target = NULL;
			}

			$this->Shop->id = $v['id'];
			$this->Shop->saveField('price_board', $target);
		}
		return;
	}

	function convertIdToIds() {
		$data_shops = $this->Shop->find('all', [
			'fields' => [
				'Shop.id',
				'Shop.city_id',
			],
		]);
		foreach ($data_shops as $v) {
			$v = $v['Shop'];
			$city_ids = json_encode([$v['city_id']=>$v['city_id']]);
			$this->Shop->id = $v['id'];
			$this->Shop->saveField('city_ids', $city_ids);
		}
		return;
	}
}
