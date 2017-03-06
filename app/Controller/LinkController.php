<?php
class LinkController extends AppController
{
	var $name = 'Link';

	function index()
	{
		$this->pageInit();
		$this->layout = 'Pane1';
		$this->set([
			'scripts' => ['script_link']
		]);
	}
}
?>