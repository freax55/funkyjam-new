<?php
App::uses('Shell', 'Console');
App::uses('AppController', 'Controller');
App::uses('ComponentCollection', 'Controller');

class ImportShell extends Shell {

	public $uses = array(
		'Discography'
	);

	// function getUrlListFromSitemap() {
	// 	// サーバーで使わない。ローカルで使うには2行コメントアウト
	// 	$this->out('You must use this command in local machine!');
	// 	return;

	// 	// xmlからurlリスト作成
	// 	$xml = simplexml_load_string(file_get_contents(ASSETS . 'files/xml/dto_sitemap.xml'));
	// 	$json = json_encode($xml);
	// 	$ary = json_decode($json, true);
	// 	// $this->prd($ary);
	// 	foreach($ary['url'] as $data) {
	// 		$ary_url[] = $data['loc'];
	// 	}
	// 	// $this->prd($ary_url);
	// 	$json_url = json_encode($ary_url);
	// 	file_put_contents(ASSETS . 'files/json/dto_url_list.json', $json_url);

	// 	$this->out('サイトマップからurlリストを作成しました。');
	// 	return;
	// }

	// function getHtml() {
	// 	// サーバーで使わない。ローカルで使うには2行コメントアウト
	// 	$this->out('You must use this command in local machine!');
	// 	return;

	// 	$list = file_get_contents(ASSETS . 'files/json/dto_url_list.json');
	// 	$list = json_decode($list, true);
	// 	foreach($list as $k  => $url) {
	// 		$html = file_get_contents($url);
	// 		$path = ASSETS_SSD . 'files/html/import/dto/' . $k . '.html';
	// 		file_put_contents($path, $html);
	// 		$this->out('get' . $k . '.html');
	// 	}
	// 	$this->out('urlリストのhtmlファイルを保存しました。');
	// 	return;
	// }


	function get_json_from_html() {
		if (isset($this->args[0]) && $this->args[0] != "") {
			$html = fopen(ASSETS . 'files/html/' . $this->args[0] . '.html', 'r');
			if(!$html){
				$this->out('is not exist ' . $html);
			}
			$dom = new DOMDocument;
			$dom->preserveWhiteSpace = false; 
			// @$dom->loadHtml(file_get_contents($html));
			@$dom->loadHtml($string);

			$xpath = new DOMXPath($html);
			$p_entries = $p_queries = array();
			
		}
	}

	function _getJsonFromHtml() {
		// サーバーで使わない。ローカルで使うには2行コメントアウト
		// $this->out('You must use this command in local machine!');
		// return;

		// $list = scandir(ASSETS_SSD . 'files/html/import/_dto/');
		$dir = ASSETS_SSD . 'files/html/import/dto/';
		$list = scandir(ASSETS_SSD . 'files/html/import/dto/');

		unset($list[0]);
		unset($list[1]);
		// $this->prd($list);
		// $i = 0;

		foreach($list as $file) {
			// $i++;
			$html = $dir . $file;
			$string = file_get_contents($html);
			$string = str_replace('<meta charset="UTF-8">', '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />', $string);
			$string = mb_convert_encoding($string, "UTF-8");

			$dom = new DOMDocument;
			$dom->preserveWhiteSpace = false; 
			// @$dom->loadHtml(file_get_contents($html));
			@$dom->loadHtml($string);

			$xpath = new DOMXPath($dom);
			$p_entries = $p_queries = array();

			$p_entries = $xpath->query('//body//div[@class="com_td style2"]');
			foreach($p_entries as $p_entry) {
				$p_queries[] = preg_replace("[\n|\r|\nr|\t]","",$p_entry->nodeValue);
			}

			$f_entries = $f_queries = array();
			$f_entries = $xpath->query('//body//div[@class="list"]/table[@class="style1"]//td');
			foreach($f_entries as $k => $f_entry) {
				if($k%2 != 0) {
					$f_queries[$f_entries[$k-1]->nodeValue] = $f_entry->nodeValue;
				} else {
					continue;
				}
			}

			$pb_entries = $trs = $tds = $pb_tables = array();
			$th_q = null;
			$pb_entries = $xpath->query('//body//div[@class="contents price com_margin"]//table[@class="style2"]');
			foreach($pb_entries as $table) {
				$trs = $xpath->query('.//tr', $table);
				$th_k = '';
				$r = 0;
				foreach ($trs as $tr) {
					$tds = array();
					$th_q = $xpath->query('./th', $tr)->item(0);
					if($th_q) {
						$th_k = $th_q->nodeValue;
					} else {
						$tds = $xpath->query('.//td', $tr);
						foreach($tds as $k4 => $td) {
							$pb[$r][$k4] = $td->nodeValue;
							if($r%2 != 0){
								$pb_tables[$th_k][$pb[$r-1][$k4]] = $pb[$r][$k4];
							} else {
								continue;
							}
						}
						$r++;
					}
					$th_q = null;
				}
			}

			$credit = $cr_queries = array();
			$credit = $xpath->query('//body//div[@class="contents price com_margin"]//div[@class="note"]/span');
			foreach($credit as $v) {
				$cr_queries[] = $v->nodeValue;
			}

			$entries = $query = $ary_t = array();
			$entries = $xpath->query('//body//div[@class="contents price com_margin"]//*');
			foreach($entries as $k => $entry) {
				if($entry->nodeValue == '交通費') {
					$query = $xpath->query('.//td', $entries[$k+1]);
					foreach($query as $kt => $q){
						if($kt%2 != 0) {
							$ary_t[$query[$kt-1]->nodeValue] = $q->nodeValue;
						} else {
							continue;
						}
					}
				}
			}
			
			$options = null;
			$ary_options = array();
			$options = $xpath->query('//body//div[@class="contents price com_margin"]//table[@class="style4"]//td');
			foreach ($options as $vo) {
				$ary_options[] = $vo->nodeValue;
			}
			// $o = implode("\n", $ary_options);
			// $this->prd($o);
			// $this->prd($ary_options);
			$value = $xpath->query('//body//div[@class="com_td style3"]')->item(0)->nodeValue;
			// $this->prd($value);
			// $this->prd(preg_replace("[\n|\r|\nr|\t]","",$value));

			$official = $xpath->query('//body//a[@class="official_site"]')->item(0);
			if($official) {
				$o_url = $official->getAttribute('href');
			} else {
				$o_url = '';
			}
			// $value = $query->getAttribute('href');
			// $this->prd($value);
			// jsonにして保存
			$data = array();
			$data = [
				'name' => $xpath->query('//body//h2')->item(0)->nodeValue, //店名h1などから
				'tel' => $xpath->query('//body//*[@class="tel"]')->item(0)->nodeValue, //電話番号
				'url' => $o_url,//$xpath->query('//body//a[@class="official_site"]')->item(0)->getAttribute('href'), // ;
				'job' => $xpath->query('//body//*[@class="com_title"]//span')->item(0)->nodeValue, //インサート時に文字からid参照
				// 以下4つ配列でまとめて記録
				// 'start_area' => ,// 都道府県>市区町村で取得。インサート時に分解
				// 'business_holiday' => ,
				// 'place' => , // 出張可能場所。自宅派遣可否判定に使用
				// 'time' => , // 営業時間。分解して使用
				// 'table_1' => json_encode($p_queries),
				'table_1' => $p_queries,
				'area' => preg_replace("[\n|\r|\nr|\t]","",$xpath->query('//body//div[@class="com_td style3"]')->item(0)->nodeValue),// インサート時に分解、照合
				// 以下2つ配列
				// 'fee_admission' => ,
				// 'fee_nomination' => ,
				// 'table_2' => json_encode($f_queries),
				'table_2' => $f_queries,
				// 'prices' => json_encode($pb_tables), //jsonにして後で分解
				'prices' => $pb_tables, //jsonにして後で分解
				// 'status_credit_cart' => json_encode($cr_queries), // ◯クレジットカードと◯領収書、後で分解
				'status_credit_card' => $cr_queries, // ◯クレジットカードと◯領収書、後で分解
				// 'delivery_fee' => json_encode($ary_t), // 交通費、後で調整
				'delivery_fee' => $ary_t, // 交通費、後で調整
				'play_option' => $ary_options
			];
			$num = preg_replace("/\D/", '', $file);
			header('content-type: application/json; charset=utf-8');
			// $json = json_encode($data, JSON_UNESCAPED_UNICODE);
			file_put_contents(ASSETS_SSD . 'files/json/import/dto/' . $num . '.json' , json_encode($data, JSON_UNESCAPED_UNICODE));
			// file_put_contents(ASSETS_SSD . 'files/json/import/dto/' . $num . '.json' , json_encode($data));

			// file_put_contents(ASSETS . 'files/json/import/dto/' . $num . '.json' , json_encode($data, JSON_UNESCAPED_UNICODE));
			// file_put_contents(ASSETS_SSD . 'files/json/import/dto/' . $num . '.txt' , serialize($data));
			$this->out('make json_file ' . $num . '.json');

		}
		$this->out('json出力が完了しました。');
		return;
	}

	function importShopsFromJson() {

		$this->out('You must use this command in local machine!');
		return;

		App::uses('AppController', 'Controller');
		// App::uses('ShopController', 'Controller');
		$App = new AppController();
		// $Shop = new ShopController();

		$dir = ASSETS_SSD . 'files/json/import/dto_error/';
		$list = scandir(ASSETS_SSD . 'files/json/import/dto_error/');
		// $dir = ASSETS . 'files/json/import/dto/';
		// $list = scandir(ASSETS . 'files/json/import/dto/');
		unset($list[0]);
		unset($list[1]);
		$tel_list = $this->Shop->getShopList('tel');
		$tel_list = array_unique($tel_list);
		$check = array_flip($tel_list);
		$prefs = $App->getPrefs();
		$pref_ids = array_flip($prefs);
		$file_name = ASSETS_SSD . 'files/text/import_log_' . date('ymdHi') . '.txt';
		// $text = '';
		foreach ($list as $json) {
			$num = preg_replace("/\D/", '', $json);
			// $i = 0;
			$res = @file_get_contents('http://ikulist.dev/shop/gen/' . $num . DS);
			if(empty($res)){
				$res = @file_get_contents('http://ikulist.dev/shop/gen/' . $num . DS);
				if(empty($res)){
					$res = $num . ' no respons?';
					copy($dir . $json, ASSETS_SSD . 'files/json/import/dto_error/' . $json);
				}
			}

			// try {
			// 	ob_start();
			// 	$res = file_get_contents('http://ikulist.dev/shop/gen/' . $num . DS);
			// 	$warning = ob_get_contents();
			// 	ob_end_clean();
			// 	if ($warning) {
			// 		throw new Exception($warning);
			// 	}
			// } catch (Exception $e) {
			// 	echo 'request error! ' . $num;
			// 	$this->out($e->getMessage());
			// 	$res = $num . ' no respons?';
			// }
			// try {
			// 	$res = file_get_contents('http://ikulist.dev/shop/gen/' . $num . DS);
			// } catch (Exception $e) {
			// 	echo 'request error! ' . $num;
			// 	try {
			// 		$res = file_get_contents('http://ikulist.dev/shop/gen/' . $num . DS);
			// 	} catch (Exception $e) {
			// 		echo 'request error! ' . $num;
			// 		try {
			// 			$res = file_get_contents('http://ikulist.dev/shop/gen/' . $num . DS);
			// 		} catch (Exception $e) {
			// 			echo 'request error! ' . $num;
			// 			$res = $num . ' no respons?';
			// 			copy($dir . $json, ASSETS_SSD . 'files/json/import/dto_error/' . $json);
			// 		}
			// 	}
			// }

			// try{
			// 	file_get_contents('http://ikulist.dev/shop/gen/' . $num . DS);
			// } catch (PDOException $e) {
			// // 	// syslog(7, 'CSV for GoogleAnalytics import EXCEPTION ' . $e->getMessage());
			// // 	// $this->error('Error!', $e->getMessage());
			// 	$this->out('no data!');
			// 	continue;
			// // 	return ['res' => false, 'm' =>''];
			// }
			// // if($ary == '') {
			// // 	$this->out('no data!');
			// // } else {
			// 	$this->out($num);
			// }

			// $res = $Shop->import_d($num);
			$this->out($res);
			
			$fp = fopen($file_name, 'a');
			fputs($fp, $res . "\n");
			fclose($fp);
			// $text = $res . "\n";
		}
		$this->out('finished');
		return;
	}
}
