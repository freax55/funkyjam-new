<div class="box">
	<h2>ディスコグラフィー編集</h2>
	<div style="text-align:right;"><a href="/discography_data/index/<?= $artist ?>/<?= $type ?>/">一覧に戻る</a></div>
	<?= $this->Form->create('Discography', array('novalidate' => true, 'name'=>'myForm', 'action'=>'post', 'url'=>'/discography_data/post/', 'type' => 'file')) ?>
	<?php
	print $this->Form->input('discography_id', array(
		'type' => 'hidden',
		'value' => $data['Discography']['discography_id']
	));
	print $this->Form->input('artist', array(
		'type' => 'hidden',
		'value' => $artist
	));
	print $this->Form->input('type', array(
		'type' => 'hidden',
		'value' => $type
	));
	// print $this->Form->input('old_id', array(
	// 	'type' => 'hidden',
	// 	'value' => $data['Discography']['old_id']
	// ));
	?>

	<table class="table table-bordered" style="padding-top:10px;">
		<tr>
			<th style="width:24%;">公開設定</th>
			<td>
				<?php
					print $this->Form->radio('publish', array('y' => '公開', 'n' => '非公開'), array(
						'legend' => false,
						'value' => isset($data['Discography']['publish']) ? $data['Discography']['publish'] : 'y'
					));
				?>
			</td>
		</tr>
		<tr>
			<th>タイトル</th>
			<td>
				<div>
					<?php
					print $this->Form->input('title', array(
						'label' => false,
						'error' => false,
						'div' => false,
						'value' => $data['Discography']['title'],
						'class' => 'form-control'
					));
					?>
				</div>
			</td>
		</tr>
		<tr>
			<th>タイトルの上に付くテキスト(任意)</th>
			<td>
				<div>
					<?php
					print $this->Form->input('label', array(
						'label' => false,
						'error' => false,
						'div' => false,
						'value' => $data['Discography']['label'],
						'class' => 'form-control'
					));
					?>
				</div>
			</td>
		</tr>
		<?php
		$release = $release_other = '';
		if(!empty($data['Discography']['release_multi'])){
			$ary_release = json_decode($data['Discography']['release_multi'], true);
			if(isset($ary_release[0])){
				$release = $ary_release[0];
			}
			if(isset($ary_release[1])){
				unset($ary_release[0]);
				$release_other = implode("\n", $ary_release);
			}
		}
		?>
		<tr>
			<th>発売日テキスト<br><span style="font-size:12px; color:#e00;">・入力したテキストがそのまま表示されます。日付部分はデータ化しますので必ず「20xx/xx/xx」の書式で統一してください</span></th>
			<td>

				<div>
					<?php
					print $this->Form->input('release_multi1', array(
						'label' => false,
						'error' => false,
						'div' => false,
						'value' => $release,
						'class' => 'form-control'
					));
					?>
				</div>
			</td>
		</tr>
		<tr>
			<th>発売日(追加入力)<br><span style="font-size:12px; color:#e00;">・リリースが複数ある場合は、この欄に追加してください</span></th>
			<td>
				<div>
					<?php
					print $this->Form->input('release_multi2', array(
						'label' => false,
						'type' => 'textarea',
						'error' => false,
						'div' => false,
						'value' => $release_other,
						'rows' => 2,
						'class' => 'form-control'
					));
					?>
				</div>
			</td>
		</tr>
		<tr>
			<th>外部リンク<br><span style="font-size:12px; color:#e00;">・リンク先が複数ある場合は、必ず改行してください</span></th>
			<td>
				<?php
				print $this->Form->input('link', array(
					'label' => false,
					'type' => 'textarea',
					'value' => empty($data['Discography']['link'])?'':implode("\n", json_decode($data['Discography']['link'],true)),
					'class' => 'form-control',
					'rows' => 2
				));
				?>
			</td>
		</tr>
		<?php
		/*
		<tr>
			<th>画像</th>
			<td>
				<?php
				// if (isset($data['Discography']['img_pc']) && $data['Discography']['img_pc'] != "") {
				// 	// list($width, $height) = getimagesize(IMAGES. 'banner' .DS . $data['Discography']['img']);
				// 	print '<img src="/img/banner/' . $data['Discography']['img_pc'] /*. '" width="' . $width . '" height="' . $height . '">';
				// 	print $this->Form->input('img_pc', array('type'=>'hidden','value'=>$data['Discography']['img_pc']));
				// 	print '<br>';
				// 	print "<a href=\"/admin/banner/delete_image/";
				// 	print $data['Discography']['id'] . DS . 'img_pc' . DS;
				// 	print '" onclick="return confirm(\'画像を削除してもよろしいですか？\');" class="btn btn-danger" style="float:right">';
				// 	print '<i class="icon icon-remove"></i> 画像を削除する</a>';
				// }
		// 		<input type="file" name="data[img_pc]">
		// 		<input type="hidden" name="data[img_pc]">
		// 	</td>
		// </tr>
		// */
		// print $this->Form->input('img', array(
		// 	'type' => 'hidden',
		// 	'value' => $data['Discography']['img']
		// ));

		?>


		<?php
		$tracks = '';
		if(!empty($data['Discography']['tracks'])){
			$ary_tracks = json_decode($data['Discography']['tracks'], true);
			foreach($ary_tracks as $t) {
				if($t['tag'] == 'p'){
					$tracks .= 'sh::';
				}
				$tracks .= $t['tt'] . "\n";
			}
			// pr($ary_tracks);
		}

		?>
		<tr>
			<th>トラックリスト<br><span style="font-size:12px; color:#e00;">・トラック名ごとに改行してください<br>・小見出し(「Disc2」「ボーナストラック」等)を使う時は行頭に"sh::"を付けてください(例、sh::Disc2)<br>・不等号(&lt;,&gt;)を括弧として使う場合、それぞれ"&amp;gt;","&amp;rt;"に置き換えてください</span></th>
			<td>
				<?php
				print $this->Form->input('tracks', array(
					'label' => false,
					'type' => 'textarea',
					'value' => $tracks,
					'class' => 'form-control',
					// 'placeholder' => 'トラック名ごとに改行。小見出し(「Disc2」「ボーナストラック」等)を使う時は行頭に"sh::"を付けてください(例、sh::Disc2)',
					'rows' => 15
				));
				?>
			</td>
		</tr>
	</table>

	<?= $this->common->getSubmitButton() ?>
	<?= $this->Form->end() ?>
</div>
