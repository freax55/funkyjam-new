<?php
$d = $data_club['Club'];
?>
<header class="mb10">
	<h1 class="ttl ttl-main mb10"><?= $d['name'] ?></h1>
	<?php
	if(isset($d['catch_copy']) && $d['catch_copy'] != '') {
		print '<p class="gray">' . $d['catch_copy'] . '</p>';
	}
	?>
</header>
<div class="cf">
	<figure class="col span-4 mb10 tac">
	<?php
	if ($d['img_detail'] != "") {
		if(!$this->common->isSP()){
			print '<img data-src="/img/club/' . $d['img_detail'] . '" src="/img/loader.gif" class="ready-img" alt="' . $d['name'] . 'の画像">';
		} else {
			print '<img data-src="/img/club/' . $d['img_main_sp'] . '" src="/img/loader.gif" class="ready-img" alt="' . $d['name'] . 'の画像">';
		}
	} else {
		if(!$this->common->isSP()){
			print '<img data-src="/img/noimage-576-576.png" src="/img/loader.gif" class="ready-img" alt="' . $d['name'] . 'の画像">';
		} else {
			print '<img data-src="/img/noimage-576-192.png" src="/img/loader.gif" class="ready-img" alt="' . $d['name'] . 'の画像">';
		}
	}
	?>
	</figure>
	<div class="col span-8">
		<table class="table table-brdr table-th-gray mb10">
			<tbody>
				<tr>
					<th>クラブ名</th>
					<td><a href="<?= $d['url'] ?>" target="_blank" rel="nofollow"><?= $d['name'] ?></a></td>
				</tr>
				<tr>
					<th>住所</th>
					<td><?= $d['address'] ?></td>
				</tr>
				<tr>
					<th>エリア</th>
					<td><a href="/<?= $pref_name_en ?>/area/<?= $d['area_id'] ?>/"><?= $area_name ?></a></td>
				</tr>

				<tr>
					<th rowspan="2" class="vam">会員数</th>
					<td><span class="red i-woman"></span>女性：<?= $d['cnt_women'] ?></td>
				</tr>
				<tr>
					<td><span class="blue i-man"></span>男性：<?= ($d['cnt_men'] != "") ? $d['cnt_men'] : '非公開' ?></td>
				</tr>
				<tr>
					<th>営業時間</th>
					<td><time datetime="<?= $d['open'] ?>"><?= $d['open'] ?></time>〜<time datetime="<?= $d['close'] ?>"><?= $d['close'] ?></time>
						<?=  (isset($d['time_comment'])) ? '<p>' . $d['time_comment'] . '</p>' : '' ?>
					</td>
				</tr>
				<tr>
					<th>メール</th>
					<td><?= ($d['mail'] != "") ? $d['mail'] : '非公開' ?></td>
				</tr>
				<tr>
					<th>入会資格</th>
					<td><?= nl2br($d['add_condition']) ?></td>
				</tr>
			</tbody>
		</table>
		<?php
		$add_fee = json_decode($d['add_fee'],true);
		$annual_fee = json_decode($d['annual_fee'],true);
		$setting_fee = json_decode($d['setting_fee'],true);
		$setting_system = json_decode($d['setting_system'],true);
		// 入会金;
		if($add_fee['comment'] != '' || $add_fee['fee'][0]['comment'] != '' && $add_fee['fee'][0]['price']  != '') {
			print '<table class="table table-brdr table-th-gray mb10 table-price">';
			print '<thead><tr><th colspan="2" class="tac">入会金</th></tr></thead>';
			if($add_fee['fee'][0]['course'] != '' && $add_fee['fee'][0]['price'] != '') {
				print '<tbody>';
				foreach($add_fee['fee'] as $v) {
					if($v['course'] != '' || $v['price'] != '') {
						print '<tr><th>' . $v['course'] . '</th>';
						print '<td class="tar">' . $v['price'] . '円</td></tr>';
					}
				}
				print '</tbody>';
			}
			if($add_fee['comment'] != '') {
				print '<tfoot><tr><td colspan="2" class="tac">' . $add_fee['comment'] . '</td></tr></tfoot>';
			}
			print '</table>';
		}
		// annual_fee
		if($annual_fee['comment'] != '' || $annual_fee['fee'][0]['comment'] != '' && $annual_fee['fee'][0]['price']  != '') {
			print '<table class="table table-brdr table-th-gray mb10 table-price">';
			print '<thead><tr><th colspan="2" class="tac">年会費</th></tr></thead>';
			if($annual_fee['fee'][0]['course'] != '' && $annual_fee['fee'][0]['price'] != '') {
				print '<tbody>';
				foreach($annual_fee['fee'] as $v) {
					if($v['course'] != '' || $v['price'] != '') {
						print '<tr><th>' . $v['course'] . '</th>';
						print '<td class="tar">' . $v['price'] . '円</td></tr>';
					}
				}
				print '</tbody>';
			}
			if($annual_fee['comment'] != '') {
				print '<tfoot><tr><td colspan="2" class="tal">' . $annual_fee['comment'] . '</td></tr></tfoot>';
			}
			print '</table>';
		}
		// setting_fee
		if($setting_fee['comment'] != '' || $setting_fee['fee'][0]['comment'] != '' && $setting_fee['fee'][0]['price']  != '') {
			print '<table class="table table-brdr table-th-gray mb10 table-price">';
			print '<thead><tr><th colspan="2" class="tac">セッティング料</th></tr></thead>';
			if($setting_fee['fee'][0]['course'] != '' && $setting_fee['fee'][0]['price'] != '') {
				print '<tbody>';
				foreach($setting_fee['fee'] as $v) {
					if($v['course'] != '' || $v['price'] != '') {
						print '<tr><th>' . $v['course'] . '</th>';
						print '<td class="tar">' . $v['price'] . '円</td></tr>';
					}
				}
				print '</tbody>';
			}
			if($setting_fee['comment'] != '') {
				print '<tfoot><tr><td colspan="2" class="tal">' . $setting_fee['comment'] . '</td></tr></tfoot>';
			}
			print '</table>';
		}
		?>
		<table class="table table-brdr table-th-gray mb10 table-price">
			<thead>
				<tr>
					<th class="tac">セッティング料方式</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>ランク方式</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
