<?php
App::uses('AppController', 'Controller');
class RootController extends AppController {
	public $name = 'Root';
	// public $uses = array(
	// 	'Area',
	// 	'Pref',
	// 	'Club',
	// 	'City'
	// );

	public function index() {
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
	}

	public function company() {
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
	}

	public function recruit() {
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
	}

	public function scout() {
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
	}

	public function studio() {
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
	}

}
