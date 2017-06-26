<?php
App::uses('Shell', 'Console');
App::uses('AppController', 'Controller');
App::uses('ComponentCollection', 'Controller');

class ImportShell extends Shell {

	public $uses = array(
		'Discography'
	);

	function import_descography_from_html() {
		if (isset($this->args[0]) && $this->args[0] != "") {
			$name = $this->args[0];
			if(!in_array($name, array('kubota','urashima','mori','bes'))){
				$this->out("it's inbalid name.");
				return;
			}

			$file = ASSETS . 'files/html/' . $name . '.html';
			$html = file_get_contents($file);
			// $thml = preg_replace('/[\n\r\t]/', '', $html);
			$html = mb_convert_encoding($html, "UTF-8");
			if(!$html){
				$this->out('is not exist ' . $html);
			}
			$dom = new DOMDocument;
			$dom->preserveWhiteSpace = false; 
			// @$dom->loadHtml(file_get_contents($html));
			@$dom->loadHtml($html);

			$xpath = new DOMXPath($dom);
			$sections = $entries = $queries = array();

			$sections = $xpath->query('//body//article/div[@id="contentBox"]//section');

			$ei = 0;
			foreach($sections as $section) {
				$ei++;
				// $h2 = $xpath->query('.//h2', $section);
				$type = $section->getAttribute('id');//ディスクタイプ
				$d_entries = $xpath->query('.//div[@class="entry clearfix"]', $section);
				foreach($d_entries as $entry) {
					// 画像
					$image_name = '';
					$image = $xpath->query('.//p[@class="image"]/img', $entry)->item(0);
					if($image){
						$image_path = $image->getAttribute('src');
						$image_name = substr(strrchr($image_path, '/'),1);
					}
					// 旧id
					$old_id = @$entry->getAttribute('id');
					// タイトル上
					$label = @$xpath->query('.//p[@class="label"]',$entry)->item(0)->nodeValue;
					// タイトル
					$title = $xpath->query('.//h3', $entry)->item(0)->nodeValue;
					// リリース(配列)
					@$_release = $xpath->query('.//*[@class="release"]', $entry)->item(0)->nodeValue;
					$release = explode("\n", str_replace('.', '/', $_release));
					foreach($release as $k => $v) {
						$release[$k] = preg_replace('/[\n\r\t]/', '', $v);
					}
					$explode_release = @explode('/', $release[0]);
					// リリース(ソート用)
					if($_release){
						$release_date = @$explode_release[0] . '-' . sprintf('%02d', @$explode_release[1]) . '-' . sprintf('%02d', preg_replace('/[^0-9\.]/','',@$explode_release[2]));
					} else {
						$release_date = null;
					}

					// トラックリスト
					$data = $xpath->query('.//div[@class="txt"]/*', $entry);
					$ary = array();
					foreach($data as $row) {
						$rowhtml = $this->getInnerHtml($row);
						$ary[] = $rowhtml;//str_replace(['<','>'], ['**', '**'], $rowhtml);//nodeValue;
					}
					$ary_contents = [];
					foreach($ary as $v) {
						if($v == $title || $v == $release || $v == $label || @strpos($v, $release[0]) !== false) {
							continue;
						}
						$v = preg_replace('/[\n\r\t]/', '', $v);
						if(strpos($v, '<li>') !== false) {
							$list = [];
							$list = explode('</li>', $v);
							foreach($list as $v1) {
								if(empty($v1)) {
									continue;
								}
								$ary_contents[] = [
									'tag' => 'li',
									'tt' => str_replace('<li>', '', $v1),
								];
							}
						} else {
							$ary_contents[$v] = [
								'tag' => 'p',
								'tt' => $v
							];
						}
					}
					// 外部リンク
					$links = $xpath->query('.//div[@class="btns"]//li', $entry);
					$ary_links = [];
					foreach($links as $li) {
						$href = $xpath->query('.//a', $li)->item(0);
						$ary_links[] = $href->getAttribute('href');
					}

					$insert = [
						'artist' => $name,
						'img' => $image_name,
						'type' => $type,
						'old_id' => $old_id,
						'label' => $label,
						'title' => $title,
						'release' => $release_date,
						'release_multi' => json_encode($release),
						'tracks' => json_encode($ary_contents),
						'link' => json_encode($ary_links),
					];
					$this->Discography->create();
					$this->Discography->save($insert);
					// $datas[] = $insert;
				}
			}
			$this->out('finish!');

		} else {
			$this->out('it needs artist name.');
			return;
		}

	}

	// HTMLとして取り出す
	function getInnerHtml($node){
	    $children = $node->childNodes;
	    $html = '';
	    foreach($children as $child){
	        $html .= $node->ownerDocument->saveHTML($child);
	    }
	    return $html;
	}

}
