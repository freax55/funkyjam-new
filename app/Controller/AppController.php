<?php
App::uses('Controller', 'Controller');
class AppController extends Controller {
	public $components = ['Cookie', 'Session'];
	public $helpers = ['Session', 'Common', 'BreadCrumb'];
	public $paginate = [];
	var $pages = [
		'root' => [
			'title' => "ホーム",
			'url' => "/",
			'submenu' => 0,
		],
		'artist' => [
			'title' => "アーティスト",
			'url' => "/artist/",
			'submenu' => [
				'news' => [
					'title' => "ニュース",
					'url' => "/news/",
					'submenu' => 0,
				],
				'profile' => [
					'title' => "プロフィール",
					'url' => "/profile/",
					'submenu' => 0,
				],
				'discography' => [
					'title' => "ディスコグラフィ",
					'url' => "fanclub/discography/",
					'submenu' => 0,
				],
				'performance' => [
					'title' => "出演情報",
					'url' => "/performance/",
					'submenu' => 0,
				],
				'fanclub' => [
					'title' => "オフィシャルファンクラブ",
					'url' => "/fanclub/",
					'submenu' => 0,
				],
			]
		],
		'company' => [
			'title' => "会社概要",
			'url' => "/company/",
			'submenu' => 0,
		],
		'recruit' => [
			'title' => "採用情報",
			'url' => "/recruit/",
			'submenu' => 0,
		],
		'scout' => [
			'title' => "新人募集",
			'url' => "/scout/",
			'submenu' => 0,
		],
		'studio' => [
			'title' => "スタジオ",
			'url' => "/studio/",
			'submenu' => 0,
		],
		'contact' => [
			'title' => "お問い合わせ",
			'url' => "/contact/",
			'submenu' => 0,
		],
	];

	// var $pages_admin = [
	// 	'login' => [
	// 		'url' => 'login',
	// 		'title' => 'ログイン',
	// 		'status' => false,
	// 	],
	// 	'text' => [
	// 		'url' => 'text',
	// 		'title' => '汎用テキスト管理',
	// 		'status' => true,
	// 		'submenu' => [
	// 			'view',
	// 			'add',
	// 		]
	// 	],
	// 	'area' => [
	// 		'url' => 'area',
	// 		'title' => 'エリア管理',
	// 		'status' => true,
	// 		'submenu' => [
	// 			'view',
	// 			'add',
	// 		]
	// 	],
	// 	'user' => [
	// 		'url' => 'user',
	// 		'title' => 'ユーザー管理',
	// 		'status' => true,
	// 		'submenu' => [
	// 			'view',
	// 			'add',
	// 		]
	// 	],
	// 	'role' => [
	// 		'url' => 'role',
	// 		'title' => 'アクセス権限管理',
	// 		'status' => true,
	// 		'submenu' => [
	// 			'view',
	// 			'add',
	// 		]
	// 	]
	// ];

	/*
	 * 認証不要に初期化
	 */
	var $needAuth = false;
	/*
	 * beforeFilter
	 */
	function beforeFilter() {
		parent::beforeFilter();
		/*
		 * 管理画面ログイン認証
		 * URLが管理画面だった場合にチェックを行い、直アクセス・認証なしPOSTでのDB操作を防止する。
		 */
		// if (strpos($this->params->url, 'admin') !== false) {
		// 	if ($this->params->params['controller'] != 'user') {
		// 		$this->needAuth = (bool)true;
		// 		if (!$this->getAuth()) {
		// 			$this->redirect('/admin/');
		// 		}
		// 	}
		// 	if ($this->needAuth === true) {
		// 		$auth_user = $this->Session->read('User');
		// 		if ($auth_user != null) {
		// 			if ($auth_user['Role'][$this->params->params['controller'] . '_status'] == 'n') {
		// 				$this->redirect('/admin/');
		// 			}
		// 		}
		// 	}
		// }
		// グローバル変数定義
		$this->set([
			'params'                => $this->params->params,
			'pages'                 => $this->pages,
			'controller_camel_case' => Inflector::camelize($this->params->params['controller']),
			// 'action_camel_case'     => Inflector::camelize($this->params->params['action']),			
			'body_css_class'        => null,
			'current'               => $this->params->params['controller'],
			'noindex'               => false,
			'canonical'             => false,
		]);
	}

	/**
	 * セッション有無を返す
	 * @return array
	 */
	function getAuth()
	{
		return $this->Session->check('User');
	}

	/*
	 * セッションから
	 * @return rold_id
	 */
	function getRoleId()
	{
		return $this->Session->read('User')['User']['role_id'];
	}
	/*
	 * セッションから
	 * @return user_id
	 */
	function getUserId()
	{
		return $this->Session->read('User')['User']['id'];
	}

	/*
	 * pr()をオーバーライド。
	 */
	function prd() {
		echo '<pre style="width:100%;margin:-8px;padding:8px;background:#2f2f30;color:#8ad50b;font-family:monospace;font-size:14px">';
		foreach (func_get_args() as $v) print_r($v);
		echo '</pre>';
		die;
	}

	/*
	 * 直前のクエリログを列挙する
	 */
	function prdq() {
		$sources = ConnectionManager::sourceList();
		$logs = array();
		foreach ($sources as $source) {
			$db = ConnectionManager::getDataSource($source);
			if (!method_exists($db, 'getLog')) {
				continue;
			}
			$logs[$source] = $db->getLog();
		}
		foreach ($logs['default']['log'] as $k => $v) {
			$query_log[] = $v['query'];
		}
		$this->prd($query_log);
	}

	/*
	 * スマートフォンからですか？ 関数
	 */
	function isSP() {
		$useragents = array(
			// 'Chrome',
			'iPhone',         // Apple iPhone
			'iPod',           // Apple iPod touch
			'Android',        // 1.5+ Android
			'Windows Mobile', // Windows Phone
			'dream',          // Pre 1.5 Android
			'CUPCAKE',        // 1.5+ Android
			'blackberry9500', // Storm
			'blackberry9530', // Storm
			'blackberry9520', // Storm v2
			'blackberry9550', // Storm v2
			'blackberry9800', // Torch
			'webOS',          // Palm Pre Experimental
			'incognito',      // Other iPhone browser
			'webmate'         // Other iPhone browser
		);
		$pattern = '/'.implode('|', $useragents).'/i';
		$ua = preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
		return $ua;
	}

	function explodeCase($string, $lower = true)
	{
		$array = [];
		$segment = '';
		foreach (str_split($string) as $char) {
			if (ctype_upper($char)) {
				if ($segment) {
					$array[] = $segment;
				}
				$segment = $lower ? strtolower($char) : $char;
			} else {
				$segment .= $char;
			}
		}
		if ($segment) {
			$array[] = $segment;
		}
		return $array;
	}

	/*
	 * ランダム文字列生成
	 * デフォルトは8文字
	 */
	function getRandStr($nLengthRequired = 8){
		$sCharList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_";
		mt_srand();
		$sRes = "";
		for ($i=0; $i<$nLengthRequired; $i++) {
			$sRes.= $sCharList{mt_rand(0, strlen($sCharList) - 1)};
		}
		return $sRes;
	}

	/*
	 * POST時のゴミ除去
	 */
	function preInsert($array, $option="aKVs", $html=0)
	{
		$encoding = "UTF8";
		if (is_array($array)){
			foreach($array as $k => $v){
				if (is_array($v)){
					// HTML削除
					if ($html != 1 && !is_array($array[$k])) {
						$array[$k] = strip_tags(html_entity_decode($array[$k]));
					}
					$array[$k] = $this->preInsert($array[$k], $option, $encoding);
				} else {
					// HTML削除
					if ($html != 1 && !is_array($v)) {
						$v = strip_tags(html_entity_decode($v));
					}
					$array[$k] = mb_convert_kana(trim($v), $option, $encoding);
				}
			}
		} else {
			// HTML削除
			if ($html != 1) {
				$array = strip_tags(html_entity_decode($array));
			}
			$array = mb_convert_kana(trim($array), $option, $encoding);
		}

		return $array;
	}

	/*
	 * パンくずリストの元を配列で作る
	 */
	function topicPath($path_title=[], $path_url=[]) {
		$path['title'] = $path_title;
		$path['url']   = $path_url;
		$this->set(compact('path'));
	}

	function pageInit($isSP = null) {

		$_name = strtolower(implode("_", $this->explodeCase($this->name)));
		// if ($isSP == 'sp') {
		// 	$this->set([
		// 		'title'        => $this->pages[$this->params->params['controller']]['title'] . SEP . SITENAME,
		// 		'keywords'     => false,
		// 		'description'  => '「' . $this->pages[$this->params->params['controller']]['title'] . '」' . DESCRIPTION,
		// 		'current'      => $_name,
		// 	]);
		// 	$this->layout = 'Sp';
		// } else {
		// 	$this->set([
		// 		'title'        => $this->pages[$this->params->params['controller']]['title'] . SEP . SITENAME,
		// 		'keywords'     => false,
		// 		'description'  => '「' . $this->pages[$this->params->params['controller']]['title'] . '」' . DESCRIPTION,
		// 		'h1'           => H1,
		// 		'current'      => $_name,
		// 		'right_column' => [
		// 			'side_common'
		// 		]
		// 	]);
			if ($_name != "root") {
				$this->topicPath(
					[$this->pages[$_name]['title']],
					[$this->pages[$_name]['url']]
				);
			}
			$this->layout = 'Pane1';
		// }
	}

	function adminInit() {
		// 都道府を取得する
		$this->getPrefs();
		$this->set('title', $this->pages_admin[$this->params->params['controller']]['title']);
		$this->layout = 'Admin';
	}

	function hasAuthority($model, $action, $shop_id=0, $girl_id=0, $news_id=0){
		// 管理者権限を有していない場合に処理する
		if (3 <= $this->getRoleId()) {
			switch ($model) {
				case 'Shop':
					// 無条件で排除
					if (
						$action == 'add' ||
						$action == 'delete' ||
						$action == 'blog'
					) {
						$this->getErrorExit();
						return false;
					} else {
						$data = $this->getShopId($shop_id);
					}
					break;
				default:
					$data = $this->getShopId($shop_id);
					break;
			}
			if (!$data) {
				$this->getErrorExit();
				return false;
			}
		}
		return true;
	}

	function getErrorExit(){
		echo '不正な画面遷移です。';
		exit;
	}

	/*
	 * 都道府配列取得
	 */
	function getPrefs($lang='ja', $set=true)
	{
		$arr_ja = [
			// 北海道
			1 => "北海道",
			// 東北
			2 => "青森県",
			3 => "岩手県",
			4 => "宮城県",
			5 => "秋田県",
			6 => "山形県",
			7 => "福島県",
			// 北関東
			8 => "茨城県",
			9 => "栃木県",
			10 => "群馬県",
			// 関東
			11 => "埼玉県",
			12 => "千葉県",
			13 => "東京都",
			14 => "神奈川県",
			// 甲信越・北陸
			15 => "新潟県",
			16 => "富山県",
			17 => "石川県",
			18 => "福井県",
			19 => "山梨県",
			20 => "長野県",
			// 東海
			21 => "岐阜県",
			22 => "静岡県",
			23 => "愛知県",
			24 => "三重県",
			// 関西
			25 => "滋賀県",
			26 => "京都府",
			27 => "大阪府",
			28 => "兵庫県",
			29 => "奈良県",
			30 => "和歌山県",
			// 中国
			31 => "鳥取県",
			32 => "島根県",
			33 => "岡山県",
			34 => "広島県",
			35 => "山口県",
			// 四国
			36 => "徳島県",
			37 => "香川県",
			38 => "愛媛県",
			39 => "高知県",
			// 九州・沖縄
			40 => "福岡県",
			41 => "佐賀県",
			42 => "長崎県",
			43 => "熊本県",
			44 => "大分県",
			45 => "宮崎県",
			46 => "鹿児島県",
			47 => "沖縄県"
		];
		$arr_en = [
			1 => "hokkaido",
			2 => "aomori",
			3 => "iwate",
			4 => "miyagi",
			5 => "akita",
			6 => "yamagata",
			7 => "fukushima",
			8 => "ibaraki",
			9 => "tochigi",
			10 => "gunma",
			11 => "saitama",
			12 => "chiba",
			13 => "tokyo",
			14 => "kanagawa",
			15 => "niigata",
			16 => "toyama",
			17 => "ishikawa",
			18 => "fukui",
			19 => "yamanashi",
			20 => "nagano",
			21 => "gifu",
			22 => "shizuoka",
			23 => "aichi",
			24 => "mie",
			25 => "shiga",
			26 => "kyoto",
			27 => "osaka",
			28 => "hyougo",
			29 => "nara",
			30 => "wakayama",
			31 => "tottori",
			32 => "shimane",
			33 => "okayama",
			34 => "hiroshima",
			35 => "yamaguchi",
			36 => "tokushima",
			37 => "kagawa",
			38 => "ehime",
			39 => "kouchi",
			40 => "fukuoka",
			41 => "saga",
			42 => "nagasaki",
			43 => "kumamoto",
			44 => "oita",
			45 => "miyazaki",
			46 => "kagoshima",
			47 => "okinawa"
		];
		if ($set) {
			$this->set([
				"prefs"    => $arr_ja,
				"prefs_en" => $arr_en
			]);
		}
		if ($lang == 'ja') {
			return $arr_ja;
		} else if ($lang == 'en') {
			return $arr_en;
		}
	}

	/* こういう配列を作る
      [1] => Array
        (
            [ja] => 北海道
            [en] => hokkaido
        )
	 */
	function getPrefsMerged($set=true) {
		$prefs_ja = $this->getPrefs();
		$prefs_en = $this->getPrefs('en');
		$prefs = [];
		foreach ($prefs_ja as $k => $v) {
			$prefs[$k] = [
				'ja' => $v,
				'en' => $prefs_en[$k]
			];
		}
		if ($set) {
			$this->set(compact('prefs'));
		}
		return $prefs;
	}

	function getPrefMeta($pref_name_en, $set=true){
		$pref_id      = $this->getPrefNameJaEnId($pref_name_en)['pref_id'];
		$pref_name_ja = $this->getPrefs('ja', false)[$pref_id];
		$pref_meta = [
			'id' => $pref_id,
			'ja' => $pref_name_ja,
			'en' => $pref_name_en,
		];
		if ($set) {
			$this->set(compact('pref_meta'));
		}
		return $pref_meta;
	}

	/*
	 * @return 都道府ID
	 * @return 都道府名JA
	 * @return 都道府名EN
	 */
	function getPrefNameJaEnId($pref_name_en, $set=true) {
		$pref_id  = array_flip($this->getPrefs('en'))[$pref_name_en];
		$pref_set = [
			'pref_id'      => $pref_id,
			'pref_name_en' => $pref_name_en,
			'pref_name_ja' => $this->getPrefs()[$pref_id]
		];
		if ($set) {
			$this->set($pref_set);
		}
		return $pref_set;
	}

	/*
	 * 都道府県配列取得
	 */
	function getPrefsWithRegion($set=true){
		$prefs = array(
			"北海道・東北" => array(
				1 => "北海道",
				2 => "青森",
				3 => "岩手",
				4 => "宮城",
				5 => "秋田",
				6 => "山形",
				7 => "福島",
			),
			"関東" => array(
				13 => "東京",
				14 => "神奈川",
				11 => "埼玉",
				12 => "千葉",
				8 => "茨城",
				9 => "栃木",
				10 => "群馬",
			),
			"北陸・甲信越" => array(
				15 => "新潟",
				16 => "富山",
				17 => "石川",
				18 => "福井",
				19 => "山梨",
				20 => "長野",
			),
			"東海" => array(
				21 => "岐阜",
				22 => "静岡",
				23 => "愛知",
				24 => "三重",
			),
			"関西" => array(
				25 => "滋賀",
				26 => "京都",
				27 => "大阪",
				28 => "兵庫",
				29 => "奈良",
				30 => "和歌山",
			),
			"中国・四国" => array(
				31 => "鳥取",
				32 => "島根",
				33 => "岡山",
				34 => "広島",
				35 => "山口",
				36 => "徳島",
				37 => "香川",
				38 => "愛媛",
				39 => "高知",
			),
			"九州・沖縄" => array(
				40 => "福岡",
				41 => "佐賀",
				42 => "長崎",
				43 => "熊本",
				44 => "大分",
				45 => "宮崎",
				46 => "鹿児島",
				47 => "沖縄",
			),
		);
		if ($set) {
			$this->set("prefs_region", $prefs);
		}
		return $prefs;
	}

	function getAreas($pref_id=0)
	{
		$options['fields'] = [
			'Area.id',
			'Area.pref_id',
			'Area.name',
			'Area.cnt'
		];

		// 都道府県ごとのエリア一覧
		if ($pref_id != 0) {
			$options['conditions'] = [
				'Area.pref_id' => $pref_id
			];
		// 全県のエリア一覧
		} else {

		}
		$data_areas = $this->Area->find('all', $options);

		// エリアを都道府県IDごとにまとめる
		for ($i=1; $i<=47; $i++) {
			foreach ($data_areas as $v) {
				$v = $v['Area'];
				if ($i == $v['pref_id']) {
					$areas[$i][$v['id']] = [
						'ja' => $v['name'],
						'cnt' => $v['cnt']
					];
				} else {
					continue;
				}
			}
		}
		// $shop_count_area = $this->getShopCountArea();
		// $this->set(compact('areas'));
		$this->set(array('areas' => $areas));
		// return $data_areas;
	}


	/*
	 * 政令指定都市配列取得
	 */
	function getGovCity($set=true){
		$gov_cities = [
			"北海道・東北" => [
				1 => [
					1 => '札幌市',
				],
				4 => [
					262 => '仙台市'
				]
			],
			"関東" => [
				11 => [
					529 => 'さいたま市',
				],
				12 => [
					597 => '千葉市',
				],
				14 => [
					718 => '横浜市',
					736 => '川崎市',
					743 => '相模原市',
				]
			],
			"北陸・甲信越" => [
				15 => [
					776 => '新潟市',
				],
			],
			"東海" => [
				22 => [
					1010 => '静岡市',
					1013 => '浜松市',
				],
				23 => [
					1053 => '名古屋市',
				],
			],
			"関西" => [
				26 => [
					1170 => '京都市',
				],
				27 => [
					1206 => '大阪市',
					1230 => '堺市',
				],
				28 => [
					1278 => '神戸市',
				],
			],
			"中国・四国" => [
				33 => [
					1434 => '岡山市',
				],
				34 => [
					1464 => '広島市',
				]
			],
			"九州・沖縄" => [
				40 => [
					1608 => '北九州市',
					1615 => '福岡市',
				],
				43 => [
					1721 => '熊本市',
				]
			],
		];
		if ($set) {
			$this->set("gov_cities", $gov_cities);
		}
		return $gov_cities;
	}

	function getBudget($set=true) {
		$budget = [
			"18000" => "18,000円",
			"21000" => "21,000円",
			"24000" => "24,000円",
			"27000" => "27,000円",
			"30000" => "30,000円",
			"33000" => "33,000円",
			"36000" => "36,000円",
			"39000" => "39,000円",
			"42000" => "42,000円",
			"45000" => "45,000円",
			"48000" => "48,000円",
			"xxx"   => "▼上限なし",
		];
		if ($set) {
			$this->set(compact('budget'));
		}
		return $budget;
	}

}
