<?php
App::uses('AppController', 'Controller');
class ContactController extends AppController {
	public $name = 'Contact';
	public $uses = [
		'Magazine'
	];

	public function index() {
		// echo 'contact';
		// phpinfo();
		$m = $this->Magazine->find('all');
		$this->prd($m);

	}

	public function confirm() {

	}

	public function complete() {

	}

}
?>