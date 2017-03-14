<?php
App::uses('AppController', 'Controller');
class ArtistController extends AppController {
	public $name = 'Artist';
	// public $uses = [
	// 	'Area',
	// 	'Shop',
	// 	'City'
	// ];

	public function index()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
	}


	public function profile()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}

	public function profile_detail()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}

	public function producing()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}

	public function media()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}

	public function discography()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}

	public function performance()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}

	public function fanclub()
	{
		$this->pageInit();
		$this->set([
			'title' => 'fankyjam',
			// 'description' => DESCRIPTION,
		]);
		$this->render('contents');
	}


}
