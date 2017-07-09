<?php
App::uses('AppHelper', 'View/Helper');
class CommonHelper extends AppHelper {

	// 多次元配列から単配列へ変換
	function array_flatten($array){
		$result = array();
			foreach($array as $val){
				if(is_array($val)){
					$result = array_merge($result, $this->array_flatten($val));
				}else{
					$result[]=$val;
				}
			}
		return $result;
	}
	// datetime型をunix time stampに変換する
	function dateTime2UnixTime($datetime)
	{
		$regex = "/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/";
		if (preg_match($regex, $datetime, $m)) {
			array_walk($m, 'intval');
			return mktime($m[4],$m[5],$m[6],$m[2],$m[3],$m[1]);
		} else {
			return 0;
		}
	}

	// unix timestampをdatetime型に変換する
	function unixtime2datetime($timestamp) {
		if (is_int($timestamp)) {
			return date('Y-m-d H:i:s', $timestamp);
		} else {
			return '';
		}
	}

	/*
	 * 日付をフォーマットする関数
	 */
	function dateInit($date, $type=null)
	{
		if ($type != null) {
			$date = preg_replace('/([0-9]{2})([0-9]{2})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', $type, $date);
		} else {
			$date = preg_replace('/([0-9]{2})([0-9]{2})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', '$1$2-$3-$4 $5:$6:$7', $date);
		}
		return $date;
	}

	/*
	 * 日付をフォーマットする関数
	 * 汎用性高い
	 */
	function date4mat($elem, $format)
	{
		$set_year	= substr($elem, 0, 4);	//年
		$set_month	= substr($elem, 5, 2);	//月
		$set_day	= substr($elem, 8, 2);	//日
		$set_hour	= substr($elem, 11, 2);	//時
		$set_minute	= substr($elem, 14, 2);	//分
		$set_second	= substr($elem, 17, 2);	//秒
		return date($format, mktime($set_hour, $set_minute, $set_second, $set_month, $set_day, $set_year));
	}

	/*
	 * 年月日のオプション配列生成
	 */
	function dateOptions($type, $years=array())
	{
		switch ($type) {
			case "years":
				$years_option = array();
				for ($i=$years["minYear"]; $i<=$years["maxYear"]; $i++) {
					$years_option[$i] = $i;
				}
				arsort($years_option);
				return $years_option;
				break;
			case "months":
				$months_option = array();
				for ($i=1; $i<=12; $i++) {
					$months_option[sprintf("%02s", $i)] = strftime("%m", mktime(1,1,1,$i,1,1999));
				}
				return $months_option;
				break;
			case "days":
				$days_option = array();
				for ($i=1; $i<=31; $i++) {
					$days_option[sprintf('%02d', $i)] = sprintf('%02d', $i);
				}
				return $days_option;
			case "hours":
				$hours_option = array();
				for ($i=0; $i<=23; $i++) {
					$hours_option[sprintf('%02d', $i)] = sprintf('%02d', $i);
				}
				return $hours_option;
			case "minutes":
				$minutes_option = array();
				for ($i=1; $i<=59; $i++) {
					$minutes_option[sprintf('%02d', $i)] = sprintf('%02d', $i);
				}
				return $minutes_option;
			case "minutes30":
				$minutes_option = array("00" => "00", "30" => "30");
				return $minutes_option;
				break;
		}
	}

	/*
	 * 現在時刻を返す
	 */
	function now()
	{
		return date('Y-m-d H:i:s');
	}

	/*
	 * 現在の時間
	 */
	function getNow($i=0)
	{
		if (NOW_DATE_TIME < "23:59:59" && NOW_DATE_TIME < "04:59:59") {
			$today = mktime(0, 0, 0, date("m"), date("d") + $i, date("y")) - DELAY;
		} else {
			$today = mktime(0, 0, 0, date("m"), date("d") + $i, date("y"));
		}
		return $today;
	}

	/*
	 * 日本語の曜日を返す
	 * $dateは、date型 or datetime型で渡すこと
	 */
	function getWeekDay($date, $html = true)
	{
		$weekday = array("日", "月", "火", "水", "木", "金", "土");
		$date_week_num = date("w", mktime(0, 0, 0, substr($date, 5, 2), substr($date, 8, 2), substr($date, 0, 4)));
		if ($date_week_num == 6) {
			if ($html) {
				$date_week = "<span class=\"saturday\">".$weekday[$date_week_num]."</span>";
			} else {
				$date_week = $weekday[$date_week_num];
			}
		} else if ($date_week_num == 0) {
			if ($html) {
				$date_week = "<span class=\"sunday\">".$weekday[$date_week_num]."</span>";
			} else {
				$date_week = $weekday[$date_week_num];
			}
		} else {
			$date_week = $weekday[$date_week_num];
		}
		return $date_week;
	}

	/*
	 * 誕生日から年齢を計算して返す
	 */
	function getAge($birthday){
		$now = date('Ymd');
		$birthday = strtr($birthday, ['-'=>'']);
		return floor(($now - $birthday) / 10000);
	}

	/*
	 * 文字列を切り詰める関数
	 * $num は偶数で指定すること！
	 * タグの削除も同時に行う
	 */
	function strCut($str, $num)
	{
		$str = mb_strimwidth(strip_tags($str), 0, $num, "..", "UTF-8");
		return $str;
	}

	/*
	 * 文字列中の url & mailaddress に自動リンク関数
	 */
	function addAutoLinkTag($content)
	{
		$res = "";
		$s = preg_split("/\n/",$content);

		foreach ($s as $line) {
			$pat = array("/(https?:\/\/[\w\.\~\-\/\?\&\+\=\:\;\@\%\,]+)/", "/([\w\.\-_]+@[\w\-_]{2,}\.[\w\.\-_]{2,})/");
			$rep = array("<a href=\"\${1}\" target=\"_blank\">\${1}</a>", "<a href=\"mailto:\${1}\">\${1}</a>");
			$res.= preg_replace($pat, $rep, $line);
		}
		return($res);
	}

	/*
	 * 完了メッセージ生成
	 */
	function getMessage($type, $str)
	{
		$message = "<div class=\"messages\">\n";
		switch ($type) {
			case "complete":
				$message.= $str;
				break;
		}
		$message.= "</div>\n";
		return $message;
	}

	/*
	 * 必須メッセージ生成
	 */
	function getMust($str='必須')
	{
		$message = '&nbsp;<span class="label label-red">' .$str. '</span>';
		return $message;
	}

	/*
	 * エラーメッセージ生成
	 */
	function getError($str)
	{
		$message = " <div class=\"error-message\">" .$str. "</div>\n";
		return $message;
	}

	/*
	 * Content Header 生成
	 */
	function getContentHeader($content=null, $buttons=null)
	{
		$contents = '<div class="form-actions tac">';
		if ($content != "") {
			$contents.= $content;
		}
		if ($buttons != "") {
			$contents.= $this->getButtons($buttons);
		}
		$contents.= "</div>\n";
		return $contents;
	}

	function getActionEditDelete($controller, $id)
	{
		$element = '<div class="action-edit-delete btn-group">';
		$element.= '<a href="/admin/' .$controller. '/edit/' .$id. '/" class="btn btn-sm btn-info"><i class="icon icon-edit"></i>&nbsp;編集</a>';
		$element.= '<a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="javascript:deleteRecord(\'/admin/' .$controller. '/delete/' .$id. '/\');"><i class="icon icon-remove"></i>&nbsp;削除</a>';
		$element.= '</div>';
		return $element;
	}

	function getActionEdit($controller, $id)
	{
		$element = '<div class="action-edit">';
		$element.= '<a href="/admin/' .$controller. '/edit/' .$id. '/" class="btn btn-info"><i class="icon  icon-edit"></i>&nbsp;編集</a>';
		$element.= '</div>';
		return $element;
	}

	function getActionViewDelete($controller, $id)
	{
		$element = '<div class="btn-group">';
		$element.= '<a href="/admin/' .$controller. '/view/' .$id. '/" class="btn btn-sm btn-info"><i class="icon  icon-eye-open"></i>&nbsp;閲覧</a>';
		$element.= '<a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="javascript:deleteRecord(\'/admin/' .$controller. '/delete/' .$id. '/\');"><i class="icon icon-remove"></i>&nbsp;削除</a>';
		$element.= '</div>';
		return $element;
	}

	function getSubmitButton(){
		return '<div class="form-actions tac"><button class="btn btn-lg btn-primary" type="submit"><i class="icon icon-ok"></i>&nbsp;登録する</button></div>';
	}

	/*
	 * ボタン生成
	 */
	function getButtons($buttons)
	{
		$button = "<div class=\"buttons\">\n";
		foreach ($buttons as $k => $v) {
			if (!isset($v["str"])) {
				$v["str"] = "";
			}
			switch ($k) {
				case "submit":
					$button.= '<button class="btn btn-lg btn-primary" type="submit"><i class="icon icon-ok"></i>&nbsp;';
					$button.= $v['str'] != '' ? $v['str'] : '登録する';
					$button.= '</button>';
					break;
				case "view":
					$button.= '<button class="btn fr" type="button" onclick="javascript:location=\'' .$v['href']. '\'"><i class="icon icon-th-list"></i>&nbsp;一覧に戻る</button>';
					break;
				case "add":
					$button.= "<button class=\"btn btn-primary\" type=\"button\" onclick=\"javascript:location='" .$v['href']. "'\"><i class=\"icon icon-plus-sign\"></i>&nbsp;新規登録</button>\n";
					break;
				case "sort":
					$button.= "<button class=\"btn btn-success\" type=\"button\" onclick=\"javascript:location='" .$v['href']. "'\"><i class=\"icon icon-th\"></i>&nbsp;並び替え</button>\n";
					break;
				case "csv":
					$button.= "<button type=\"button\" onclick=\"openWindow('" .$v['href']. "', 735, 120);\" return: false;><span class=\"csv\">CSVダウンロード</span></button>\n";
					break;
				case "login":
					$button.= "<button class=\"btn\" type=\"submit\"><i class=\"icon-off\"></i>" .ife($v["str"] != "", $v["str"], "ログイン"). "</button>\n";
					break;
				case "close":
					$button.= "<button type=\"button\" onclick=\"windowClose();\"><span class=\"close\">閉じる</span></button>\n";
					break;
			}
		}
		$button.= "</div>\n";
		return $button;
	}

	/*
	 * 上へ戻るリンク生成
	 */
	function back2top()
	{
		return '<div id="back2top"><a href="#top"><span class="icon-triangle-up"></span></a></div>';
	}

	 /*
	  * 都道府県IDからエリア情報を取得する
	  */
	 function getAreas($pref_id)
	 {
		// JSONファイルからエリア情報を取得する
		$json = file_get_contents(JSON_DIR_AREA . $pref_id . '.json');
		$obj = json_decode($json, true);

		$areas = array();
		foreach ($obj as $v) {
                        $name_en = (isset($v['name_en'])) ? $v['name_en'] : '';
			$areas[] = array('area_id' => $v['area_id'], 'name_en' => $name_en, 'name' => $v['name']);
		}
		return $areas;
	 }

         /*
	  * 都道府県IDからエリア情報を取得する
          * option用途
          */
         function getAreasOption($pref_id){
                 $json = file_get_contents(JSON_DIR_AREA . $pref_id . '.json');
                 $obj = json_decode($json, true);
                 $areas = array();
                 foreach ($obj as $v) {
                         $areas[$v['area_id']] = $v['name'];
                 }
                 return $areas;
         }

	/*
	 * 市区町村IDから市区町村名を取得する
	 */
	function getCityNameFromJson($pref_id, $city_id, $lang='ja') {
		$city_name = "";
		if ($city_id != "" && $city_id != 0) {
			$json = file_get_contents(JSON_DIR_CITY . $pref_id . '.json');
			$obj = json_decode($json, true);

			foreach ($obj as $v) {
				if ($v['city_id'] == $city_id) {
					if ($lang == 'ja') {
						$city_name = $v['name'];
					} else {
						$city_name = $v['name_en'];
					}
					break;
				}
			}
		}
		return $city_name;
	}

	/*
	 * タグクラウドの下準備
	 * キーワードとカウントから、カウントに応じて0.0～1.0の値を取得する
	 */
	function getWordRate($countList){
		$max = max($countList);
		$min = min($countList);

		if($max - $min == 0){
			foreach($countList as &$count){
				$count = 0.5;
			}
			return $countList;
		}

		$sqrtMax = sqrt($max);
		$sqrtMin = sqrt($min);

		foreach($countList as &$count){
			$sqrtCount = sqrt($count);
			$count = ($sqrtCount - $sqrtMin) / ($sqrtMax - $sqrtMin);
		}

		return $countList;
	}

	function calendar($year='', $month='', $day='', $path=null) {
		if (empty($year) && empty($month)) {
			$year = date('Y');
			$month = date('n');
		}
		//月末の取得
		$l_day = date('j', mktime(0, 0, 0, $month + 1, 0, $year));
		$prev_month = date('Y/n', strtotime("{$year}-{$month} -1 month"));
		$next_month = date('Y/n', strtotime("{$year}-{$month} +1 month"));
		//初期出力
		$html = <<<EOM
<table class="table calendar">
	<caption>
		<a href="{$path}/{$prev_month}" class="btn btn-info"><i class="icon icon-chevron-left"></i> 前の月</a>
		{$year}年{$month}月
		<a href="{$path}/{$next_month}" class="btn btn-info">次の月 <i class="icon icon-chevron-right"></i></a>
	</caption>
	<tr>
		<th class="sunday">日</th>
		<th>月</th>
		<th>火</th>
		<th>水</th>
		<th>木</th>
		<th>金</th>
		<th class="saturday">土</th>
	</tr>\n
EOM;
		$lc = 0;
		//月末分繰り返す
		for ($i = 1; $i < $l_day + 1;$i++) {
			//曜日の取得
			$week = date('w', mktime(0, 0, 0, $month, $i, $year));
			//曜日が日曜日の場合
			if ($week == 0) {
				$html .= "\t<tr>\n";
				$lc++;
			}
			//1日の場合
			if ($i == 1) {
				if($week != 0) {
					$html .= "\t<tr>\n";
					$lc++;
				}
				$html .= $this->repeatEmptyTd($week);
			}
			if ($day != "" && $day == $i) {
				$html .= "\t\t<td><div><a href=\"{$path}/{$year}/{$month}/{$i}/\" class=\"current\">{$i}</a></div></td>\n";
			} else if ($day == "" && $i == date('j') && $year == date('Y') && $month == date('n')) {
				//現在の日付の場合
				$html .= "\t\t<td><div><a href=\"{$path}/{$year}/{$month}/{$i}/\" class=\"current\">{$i}</a></div></td>\n";
			} else {
				//現在の日付ではない場合
				$html .= "\t\t<td><div><a href=\"{$path}/{$year}/{$month}/{$i}/\">{$i}</a></div></td>\n";
			}
			//月末の場合
			if ($i == $l_day) {
				$html .= $this->repeatEmptyTd(6 - $week);
			}
			//土曜日の場合
			if ($week == 6) {
				$html .= "\t</tr>\n";
			}
		}
		// if ($lc < 6) {
		// 	$html .= "\t<tr>\n";
		// 	$html .= $this->repeatEmptyTd(7);
		// 	$html .= "\t</tr>\n";
		// }
		// if ($lc == 4) {
		// 	$html .= "\t<tr>\n";
		// 	$html .= $this->repeatEmptyTd(7);
		// 	$html .= "\t</tr>\n";
		// }
		$html .= "</table>\n";
		return $html;
	}

	function repeatEmptyTd($n = 0) {
		return str_repeat("\t\t<td> </td>\n", $n);
	}

	/*
	 * スマートフォンからですか？ 関数
	 */
	function isSP()
	{
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

	// タグを受け取ったら各リンクの末尾に追加するタグリンクURLを取得する
	function namedToTagUrl ($params) {
		$named = '';
		$tags  = [];
		if (!empty($params['named'])) {
			foreach ($params['named'] as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $v2) {
						$tags[] = $k . ':' . $v2;
					}
				} else {
					$tags[] = $k . ':' . $v;
				}
			}
			$named = implode(DS, $tags) . DS;
		}
		$named = $this->genUrl($named);
		if ($this->isInQuery('girls')) {
			$named.= '?view=girls';
		}
		return $named;
	}

	// 都道府県ごとのcntを返す
	function getShopCountPrefecture ($pref_cnt, $pref_id) {
		foreach ($pref_cnt as $v) {
			$v = $v['Prefecture'];
			if ($pref_id == $v['id']) {
				return $v['cnt'];
			}
		}
	}

	function ifnotBlankReturn ($element) {
		return ($element != '') ? $element : '';
	}

	// URLに$elementを突っ込む
	function interruptUrl($action, $element) {
		$url = explode('/', $this->params->url);
		if ($action == 'add') {
			foreach ($url as $k => $v) {
				if ($k == 1 && $v != $element) {
					$p[] = $element;
				}
				$p[] = $v;
			}
			$uri = DS . implode('/', $p);
		} else if ($action == 'del') {
			foreach ($url as $k => $v) {
				if ($v == $element) {
					unset($url[$k]);
				}
			}
			$uri = DS . implode('/', $url);
		}
		return $uri;
	}

	function isInQuery($element){
		if (isset($this->params->query['view']) && $this->params->query['view'] == $element) {
			$r = true;
		} else {
			$r = false;
		}
		return $r;
	}

	// パーツ生成メソッド
	function getCurrent($id){
		if (isset($this->params['pass'][0]) && $this->params['pass'][0] == $id) {
			$current = true;
		} else {
			$current = false;
		}
		return $current;
	}
	function getItem($type, $name, $id, $pref, $cnt){
		$params = $this->namedToTagUrl($this->params);
		if ($this->getCurrent($id)) {
			return '<li><a href="/' . $pref . $params . '" class="dib active">' . $name. ' <span class="badge">' .$cnt. '</span></a></li>';
		} else {
			return '<li><a href="/' . $pref . '/' . $type . '/' .$id . $params . '">' .$name. ' <span class="badge">' .$cnt. '</span></a></li>';
		}
	}
	function getRow($items, $rubies, $ruby_first_char){
		if (!empty($items)) {
			array_multisort($rubies, SORT_ASC, $items);
			print '<li data-submenu-id="submenu-"><span>' .$ruby_first_char. '行</span>';
			print '<ul class="menu-third-level ul-search-refine cf popover-content">' .implode('', array_values($items)). '</ul></li>';
		}
		return false;
	}

	// SEOフレンドリーなURLを生成する
	function genUrl($url=null) {
		// この順番でソートする by bootstrap.php
		$order = unserialize(TAG_ORDER);
		$uri = explode(DS, $url);
		$tags = $params = $path = [];
		// タグソート用に受け取ったURLを配列にする
		foreach ($uri as $k => $v) {
			if ($v != null) {
				if (substr($v, 2, 1) == ':') {
					$tags[substr($v, 0, 2)][] = strtr(strstr($v, ':'), [':'=>'']);
				} else if (strstr($v, '?') || strstr($v, 'page:')) {
					// page:削除
					if (strpos('page', $v) !== FALSE) {
						$params[$k] = $v;
					}
				} else {
					$path[$k] = $v;
				}
			}
		}
		// $tags = $this->params->params['named'];
		// まずタグ単体をID:ASCでソートする
		foreach ($tags as $k => $v) {
			sort($v);
			$tags[$k] = $v;
		}
		// 任意のタグ種別でソートする
		$sorted_tags = [];
		foreach ($order as $v) {
			if (isset($tags[$v])) {
				$sorted_tags[$v] = $tags[$v];
			}
		}
		// URLを組み立てる
		$sorted_url=[];
		foreach ($sorted_tags as $k => $v) {
			foreach ($v as $v2) {
				$sorted_url[] = $k . ':' . $v2;
			}
		}
		$uri = strtr(implode(DS, $path) . DS . implode(DS, $sorted_url) . DS . implode(DS, $params), ['//'=>'/']);
		return $uri;
	}

	function remove_named_page($uri) {
		$uri = explode(DS, $uri);
		foreach ($uri as $k => $v) {
			if (!empty($v) && strstr($v, 'page:')) {
				unset($uri[$k]);
			}
		}
		return implode(DS, $uri);
	}

	function ifeReturn($field, $words=[]) {
		if ($field == 'y') {
			return $words['y'];
		} else {
			return $words['n'];
		}
	}

	/*
	** fj method
	*/

	function getContentList() {
		$contents = array(
			'news' => 'News',
			'profile' => 'Profile',
			'discography' => 'Discography',
			'performance' => 'Performance',
		);
		return $contents;
	}

	function checkWithinWeek($datetime, $days) {
		$date = $this->date4mat($datetime, 'Y-m-d');
		$timestamp = $this->dateTime2UnixTime($date . ' 00:00:00');
		if((strtotime('tomorrow') - $timestamp) < (60*60*24*$days)){
			return true;
		} else {
			return false;
		}
	}

	function get_disc_types() {
		return array(
			'kubota' => [
				'album' => 'Album',
				'bestalbum' => 'Best Album',
				'usalbum' => 'U.S. Album',
				'single' => 'Single',
				'dvd' => 'DVD/Videos',
				'book' => 'Book'
			],
			'urashima' => [
				'album' => 'Album'
			],
			'mori' => [
				'album' => 'Album',
				'single' => 'Single',
				'dom' => 'Digital only Movie'
			],
			'bes' => [
				'album' => 'Album'
			],
		);
	}

	function get_code_tracklist($track_title, $tag, $class=null){
		switch ($tag) {
			case 'li':
				$code = '<li' . (($class == null)?'':' ' . $class) . '>' . $track_title . '</li>';
				break;
			case 'p':
				$code = '<p' . (($class == null)?'':' ' . $class) . '>' . $track_title . '</p>';
				break;
			default:
				$code = null;
				break;
		}
		return $code;
	}

	function get_code_links($json){
		$ary = json_decode($json, true);
		foreach($ary as $v) {
			if(strpos($v, 'amazon.co.jp') !== false){
				echo '<li class="clearfix2"><a href="' . str_replace('http:', '', $v) . '" target="_blank"><img src="/img/portfolio/btn_amazon.jpg" alt="amazon.co.jpで買う" class="shoplink shoplink2"></a></li>';
			} elseif(strpos($v, '.sonymusic') !== false){
				echo '<li class="clearfix2"><a href="' . $v . '" target="_blank"><img src="/img/portfolio/btn_sony.jpg" alt="CD/DVD Sop Sony Music Shopで買う" class="shoplink"></a></li>';
			} elseif(strpos($v, 'itunes.apple.com/') !== false){
				echo '<li class="clearfix2"><a href="' . $v . '" target="_blank"><img src="/img/portfolio/btn_itunes.jpg" alt="iTunesで入手" class="shoplink"></a></li>';
			} elseif(strpos($v, 'tower.jp/') !== false){
				echo '<li class="clearfix2"><a href="' . $v . '" target="_blank"><img src="/img/portfolio/btn_tower.jpg" alt="TOWER RECORDS ONLINE" class="shoplink"></a></li>';
			} elseif(strpos($v, 'tsutaya.co.jp/') !== false){
				echo '<li class="clearfix2"><a href="' . $v . '" target="_blank"><img src="/img/portfolio/btn_tsutaya.jpg" class="shoplink"></a></li>';
			} elseif(strpos($v, 'https://www.funkyjam.com/shop/') !== false){
				echo '<li class="clearfix2"><a href="' . $v . '" target="_blank"><img src="/img/portfolio/btn_fjshop.jpg" class="shoplink"></a></li>';
			} else {
				$host = parse_url($v, PHP_URL_HOST);
				$host = str_replace(['www.', 'shop.'], ['', ''], str_replace(strrchr($host, '.'), '', $host));
				// $host = strrchr(str_replace('www.', '', $host), '.');
				echo '<li class="clearfix2"><a href="' . $v . '" target="_blank">' . $host .'で買う</a></li>';
			}
		}
		return;
	}

}