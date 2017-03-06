<?php
class SitemapController extends AppController {
	public $name = 'Sitemap';
	public $uses = array(
		'Pref',
		'Area',
		'Club',
	);
	public $components = array('RequestHandler');

	function index(){
		$prefs_en = $this->getPrefs('en');

		foreach($prefs_en as $id => $pref){
			$data_prefs = $this->Pref->find('all',[
				'conditions' => [
					'Pref.cnt >' => 0
				],
				'fields' => [
					'Pref.id',
				]
			]);

			$data_area[$id] = $this->Area->find('all', [
				'conditions' => [
					'Area.cnt >' => 0,
					'Area.pref_id' => $id
				],
				'fields' => [
					'Area.id',
					'Area.pref_id',
				]
			]);
			$data_area[$id]['pref_name'] = $pref;
		}

		$club_options = [
			'conditions' => [
				'Club.status' => 'y'
			],
			'fields' => [
				'Club.id',
			],
			'recursive' => '-1',
			'order' => [
				'Club.id' => 'DESC'
			],
		];
		$clubs = $this->Club->find('all', $club_options);

		$this->set([
			'clubs' => $clubs,
			'data_prefs' => $data_prefs,
			'prefs_en' => $prefs_en,
			'data_area' => $data_area,
		]);
	}

}
