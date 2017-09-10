<?php
// App::uses('Component', 'Controller');
class FileHandlerComponent extends Component{


	public function initialize(Controller $controller) {
		$this->Controller = $controller;
	}

	var $image_extension = array(
		IMAGETYPE_GIF     => 'gif',
		IMAGETYPE_JPEG    => 'jpg',
		IMAGETYPE_PNG     => 'png',
		IMAGETYPE_SWF     => 'swf',
		IMAGETYPE_PSD     => 'psd',
		IMAGETYPE_BMP     => 'bmp',
		IMAGETYPE_TIFF_II => 'tiff',
		IMAGETYPE_TIFF_MM => 'tiff',
		IMAGETYPE_JPC     => 'jpc',
		IMAGETYPE_JP2     => 'jp2',
		IMAGETYPE_JPX     => 'jpf',
		IMAGETYPE_JB2     => 'jb2',
		IMAGETYPE_SWC     => 'swc',
		IMAGETYPE_IFF     => 'aiff',
		IMAGETYPE_WBMP    => 'wbmp',
		IMAGETYPE_XBM     => 'xbm',
	);

	/**
	 * 画像形式からファイルの拡張子を取得する
	 *
	 * PHP5から実装されている関数を再現
	 */
	function imageTypeToExtension($imagetype, $include_dot = true)
	{
		if (array_key_exists($imagetype, $this->image_extension)) {
			return ($include_dot ? '.'.$this->image_extension[$imagetype] : $this->image_extension[$imagetype]);
		}
		return false;
	}

	/**
	 * 画像アップロード＆リサイズ
	 */
	function upload($model, $files=array())
	{
		$upload_dir  = IMG_DIR . strtolower(implode("_", $this->Controller->explodeCase($model))). DS;
		$upload_file = $this->Controller->data['userfile'];
		$img_id = $this->Controller->getRandStr(16);

		$cnt = count($upload_file);
		for($i=0; $i<$cnt; $i++){
			if($upload_file[$i]['tmp_name'] != ""){

				$file_tmp = $upload_file[$i]['tmp_name'];
				$file_ext = $this->imageTypeToExtension(exif_imagetype($file_tmp));

				// 許容ファイル形式: JPG/GIF/PNG
				if ($file_ext != ".jpg" && $file_ext != ".jpeg" && $file_ext != ".gif" && $file_ext != ".png") {
					$this->Controller->flash("このファイル形式はサポートしていません。", "/admin/");
					exit;
				}

				// 作業用一時ファイル作成
				$tmp_src = $img_id . $file_ext;
				move_uploaded_file($file_tmp, $upload_dir . $tmp_src);
				chmod($upload_dir . $tmp_src, 0666);

				for ($j=0; $j<count($files[$i]); $j++) {

					$field = $files[$i][$j]['name'] . $files[$i][$j]['suffix'];
					if (isset($this->Controller->data[$model][$field])) {
						unlink($upload_dir . $this->Controller->data[$model][$field]);
					}
					${"src_" . $i} = $img_id . "_" . $files[$i][$j]['name'] . $files[$i][$j]['suffix'] . $file_ext;

					// 横幅が指定されていなければリサイズする
					if ($files[$i][$j]['w'] == "") {
						list($files[$i][$j]['w']) = @getimagesize($upload_dir . ${"src_" . $i});
					}
					$this->resize($upload_dir, $tmp_src, ${"src_" . $i},  $files[$i][$j]['w'], $files[$i][$j]['h'], array(255,255,255));

					// DBインサート用データ生成
					$this->Controller->request->data[$model][$field] = ${"src_" . $i};

				}
				// 作業用一時ファイル削除
				unlink($upload_dir . $tmp_src);
			}
		}
		// 画像が1枚でもアップロードされたら真を返す
		for($i=0; $i<$cnt; $i++){
			if($upload_file[$i]['tmp_name'] != ""){
				return true;
			}
		}
	}

	/**
	 * JPEG GIF画像の縮小リサイズを行う
	 */
	function resize($path, $file, $name, $new_width, $new_height, $rgb = array(255,255,255))
	{
		$imagesize = getimagesize($path.$file);
		$type      = $imagesize['mime'];
		list($width, $height) = $imagesize;

		// 変更するサイズの計算
		$reduce_w = 1;
		$reduce_h = 1;

		if ($new_width != 0) {
			$reduce_w = $new_width / $width;
		}

		if ($new_height != 0) {
			$reduce_h = $new_height / $height;
		}

		$reduce = min($reduce_w, $reduce_h);

		/**
		 * 拡大か縮小を判断。
		 * 1より大きい場合は拡大なのでそのままのサイズにする
		 */
		if ($reduce > 1) {
			$reduce = 1;
		}

		// 作成される画像のサイズ
		$resize_width  = round($width * $reduce);
		$resize_height = round($height * $reduce);

		if ($new_height != "") {
			// 指定されたサイズで画像を作る
			$img = imagecreatetruecolor($new_width, $new_height);

			// 指定された色で塗りつぶす
			$color = imagecolorallocate($img, $rgb[0], $rgb[1], $rgb[2]);
			imagefill($img, 0, 0, $color);
			imagecolordeallocate($img, $color);

			// 画像位置をセンターにする
			$x = ($new_width - $resize_width)/2;
			$y = ($new_height - $resize_height)/2;

		} else {
			$img = imagecreatetruecolor($resize_width, $resize_height);
			$x = 0;
			$y = 0;
		}

		if ($type == "image/jpeg" || $type == "image/pjpeg") {
			$image_from = imagecreatefromjpeg($path.$file);
		} else if ($type == "image/png") {
			$image_from = imagecreatefrompng($path.$file);
			// 背景の透過処理
			imagealphablending($img,false);
			imageSaveAlpha($img,true);
			$fillcolor = imagecolorallocatealpha($img,0,0,0,127);
			imagefill($img,0,0,$fillcolor);
		} else if ($type == "image/gif") {
			$image_from = imagecreatefromgif($path.$file);
		}

		imagecopyresampled($img, $image_from, $x, $y, 0, 0, $resize_width, $resize_height, $width, $height);

		if ($type == "image/jpeg" || $type == "image/pjpeg") {
			// JPG は画質100
			$result = imagejpeg($img, $path.$name, 100);
		} else if ($type == "image/png") {
			$result = imagepng($img, $path.$name);
		} else if ($type == "image/gif") {
			$result = imagegif($img, $path.$name);
		}

		imagedestroy($image_from);
		imagedestroy($img);

		chmod($path.$name, 0666);

		return $result;
	}

	// function uploadImage($model, $file, $field)
	// {
	// 	$upload_dir = IMG_DIR . strtolower(implode("_", $this->Controller->explodeCase($model))) . DS;
	// 	$img_id = $this->Controller->getRandStr(16);
	// 	$file_name = $file["name"];
	// 	$file_type = $file["type"];
	// 	$file_tmp  = $file["tmp_name"];
	// 	$file_ext  = '.' . substr($file_name, strrpos($file_name, '.') + 1);

	// 	if (!strstr($file_name, ".gif") || !strstr($file_name, ".jpg") || !strstr($file_name, ".jpeg") || !strstr($file_name, ".png")) {
	// 		$this->Controller->flash("このファイル形式はサポートしていません。", "/admin/");
	// 	}
	// 	$new_name = $img_id. "_".$field.$file_ext;
	// 	if (move_uploaded_file($file_tmp, $upload_dir . $new_name)) {
	// 		if (isset($this->Controller->data[$model][$field])) {
	// 			unlink($upload_dir . $this->Controller->data[$model][$field]);
	// 		}
	// 		// DBインサート用データ生成
	// 		$this->Controller->request->data[$model][$field] = $new_name;
	// 		return true;
	// 	} else {
	// 		$this->Controller->flash("Error!!", false);
	// 		exit;
	// 	}
	// }

	function uploadImage($model, $file, $field, $name)
	{
		$upload_dir = ASSETS. 'img/portfolio' .DS;
		// $img_id = $this->Controller->getRandStr(16);
		$file_name = $file["name"];
		$file_type = $file["type"];
		$file_tmp  = $file["tmp_name"];
		$file_ext  = '.' . substr($file_name, strrpos($file_name, '.') + 1);

		// if (!strstr($file_name, ".gif") || !strstr($file_name, ".jpg") || !strstr($file_name, ".jpeg") || !strstr($file_name, ".png")) {
		// 	$this->Controller->flash("このファイル形式はサポートしていません。", "/admin/");
		// }
		$img_id = $name.'_'.date('ynjHis');
		$new_name = $img_id.$file_ext;
		if (move_uploaded_file($file_tmp, $upload_dir . $new_name)) {
			chmod($upload_dir . $new_name, 0666);
			// if (isset($this->Controller->data[$model][$field])) {
			// 	unlink($upload_dir . $this->Controller->data[$model][$field]);
			// }
			// DBインサート用データ生成
			$this->Controller->request->data[$model][$field] = $new_name;
			return true;
		} else {
			$this->Controller->flash("Error!!", false);
			exit;
		}
	}

}
?>
