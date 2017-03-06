<?php
class TextController extends AppController
{
	var $name = 'Text';
	var $uses = array(
		'Text',
		'Role',
		'Pref',
		'Area',
	);

	function index() {
		throw new NotFoundException();
	}

	public function admin_index()
	{
		$data = $this->paginate();
		$this->getTextType();
		$this->set(compact('data'));
		$this->adminInit();
		$this->set([
			// 'scripts' => ['script_auto_complete_area', 'script_keyboard_shortcut'],
			// 'javascript' => ['jquery.autocomplete']
		]);
	}

	/*
	 * 新規登録
	 */
	public function admin_add() {
		$this->adminInit();
		$this->getTextType();
		$this->set('data', null);
		$this->set([
			'scripts' => [
				// 'script_area_admin',
			],
		]);
	}

	/*
	 * 編集
	 */
	function admin_edit($id) {
		$data = $this->Text->findById($id);
		$this->getTextType();
		$this->set('data', $data);
		$this->adminInit();
		// $this->set([
			// 'data_cities' => $data_cities,
			// 'scripts' => [
			// 	'script_area_admin',
			// ],
		// ]);
		$this->render('admin_add');
	}

	/*
	 * 登録＆編集処理
	 */
	function admin_post() {
		if (isset($this->data)) {
			// $this->prd($this->data);
			// バリデート
			$this->Text->set($this->data);
			if ($this->Text->validates()) {
				$same_topics = $this->Text->find('all', [
					'conditions' => [
						'Text.type_id' => $this->data['Text']['type_id'],
						'Text.original_id' => $this->data['Text']['original_id']
					],
					'fields' => [
						'id',
						'sort_id'
					],
					'sort' => [
						'sort_id' => 'ASC',
						'id' => 'ASC'
					]
				]);
				// $this->prd($same_topics);
				if($this->data['Text']['sort_id'] == '') {
					if($same_topics) {
						$this->request->data['Text']['sort_id'] = count($same_topics) + 1;
					} else {
						$this->request->data['Text']['sort_id'] = 1;
					}	
				}
				
				// $this->prd($this->data['Text']);
				// 市区町村
				// if (is_array($this->request->data['Area']['city_ids'])) {
				// 	$city_ids = array_unique($this->request->data['Area']['city_ids']);
				// 	foreach ($city_ids as $v) {
				// 		$city_ids_insert[$v] = $v;
				// 	}
				// 	$this->request->data['Area']['city_ids'] = json_encode($city_ids_insert);
				// } else {
				// 	$this->request->data['Area']['city_ids'] = json_encode(array());
				// }
				// // 都道府県を変更した場合を考慮して、現在のpref_idを取得しておく
				// if ($this->data['Area']['id'] != "") {
				// 	$pref_id = $this->Area->find('first', [
				// 		'conditions' => [
				// 			'Area.id' => $this->data['Area']['id']
				// 		],
				// 		'fields' => [
				// 			'Area.pref_id'
				// 		]
				// 	])['Area']['pref_id'];
				// } else {
				// 	$pref_id = "";
				// }
				// DB 格納
				$this->Text->save($this->data, false);
				$this->redirect('/admin/text/');
			} else {
				$this->adminInit();
				$this->set('data', $this->data);
				// $this->set([
				// 	'scripts' => [
				// 		'script_area_admin',
				// 	],
				// ]);
				$this->render('admin_add');
			}
		} else {
			$this->redirect("/admin/");
		}
	}


}