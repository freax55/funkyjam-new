<?php
App::uses('AppController', 'Controller');
class RootController extends AppController {
	public $name = 'Root';
	public $uses = array(
		'Area',
		'Pref',
		'Club',
		'City'
	);

	public function index() {
		// エリア一覧取得
		$this->getAreas();
		$this->pageInit();
		$this->set([
			'title' => '交際クラブを徹底比較',
			'description' => DESCRIPTION,
			// 'data_area' => $data_areas,
			'right_column' => [
				'side_ad'
			],
			'left_column' => [
				'side_area_nav'
			]
		]);
		$this->layout = 'Pane3';
	}
}
