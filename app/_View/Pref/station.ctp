<?php
if (strstr($this->here, 'dayuse')) {
	$dayuse = [
		'url'  => strtr($this->here, ['dayuse/'=>'']),
		'word' => 'デイユースがないホテルも表示'
	];
} else {
	$dayuse = [
		'url'  => strtr($this->here . DS . 'dayuse/', ['//'=>'/']),
		'word' => 'デイユースがあるホテルのみ表示'
	];
}
?>
<div class="container cf">
	<?php
	if($data_shops_a){
	?>
	<section>
		<h1 class="ttl mb10 bg-main-color white pl10"><?= $data_station['name'] ?>に派遣可能なおすすめデリヘル店</h1>
		<?php
		print view::element('part_shop_list_s');
		?>
	</section>
	<?php
	}
	?>
	<header class="cf">
		<?php
		if ($is_dayuse) {
		?>
		<h1 class="ttl mb10 col span-8 bg-gray pl10"><?= $data_station['name'] ?>のデリヘルを呼べるホテル</h1>
		<nav class="col span-4 box bg-gray-light box-fkds is-bottom mb30 tac">
			<a href="<?= $dayuse['url'] ?>" class="btn btn-orange db"><?= $dayuse['word'] ?></a>
		</nav>
		<?php
		} else {
		?>
		<h1 class="ttl mb10 bg-gray pl10"><?= $data_station['name'] ?>のデリヘルを呼べるホテル</h1>
		<?php
		}
		?>
	</header>
	<?php
	foreach ($data_hotels as $v) {
		$v = $v['Hotel'];
		$hotels[$v['type_id']][] = $v;
	}
	for ($i=1; $i<=3; $i++) {
		if (isset($hotels[$i])) {
			print '<h2>' . $hotel_type[$i] . '</h2>';
			print '<table class="table table-striped table-hotel-list">';
			print '<thead class="bg-gray-light">';
			print '<tr>';
			print '<th class="tac">ホテル名</th>';
			print '<th class="tac">住所</th>';
			print '<th class="tac">最寄り駅</th>';
			print '<th class="tac">最低料金</th>';
			print '<th class="tac">デイユース</th>';
			if ($this->common->isSP()){
				print '<th class="tac">道順</th>';
			}
			print '<th class="tac">口コミ</th>';
			print '</tr>';
			print '</thead>';
			print '<tbody>';
			foreach ($hotels[$i] as $v) {
				print '<tr>';
				print '<td><span class="i-building-o gray"></span>&nbsp;<a href="/hotel/' . $v['id'] . '/">' . $v['name'] . '</a></td>';
				print '<td><span class="i-location gray"></span>' . strtr($v['address'], [$pref_meta['ja'] => '']) . '</td>';
				if ($v['station_ids'] != "") {
					print '<td><span class="i-directions_subway gray"></span>&nbsp;' . implode('&nbsp;', $this->Common->getStations($pref_meta['id'], $pref_meta['en'], json_decode($v['station_ids'], true))) . '</td>';
				} else {
					print '<td>&nbsp;</td>';
				}
				print '<td class="tar"><span class="i-jpy gray"></span>&nbsp;' . number_format($v['min_charge']) . '円〜</td>';
				print '<td class="tac">' . $this->common->ifeReturn($v['dayuse'], ['y'=>'<span class="i-dayuse gray"></span>&nbsp;あり','n'=>'<span class="i-dayuse gray"></span>&nbsp;-']) . '</td>';
				if ($this->common->isSP()){
					print '<td class="tac"><a href="https://maps.google.com/maps?saddr=%E7%8F%BE%E5%9C%A8%E5%9C%B0&daddr=' . urlencode($v['address']) . '&dirflg=w" class="ls-none" target="_blank"><span class="i-michijun-rectangle fs30"></span></a></td>';
				}
				if($v['cnt'] != 0){
					print '<td class="tar"><span class="i-commenting fs16"></span>&nbsp;<span class="counter is-left">' . number_format($v['cnt']) . '</span></td>';
				} else {
					print '<td class="tar"><span class="i-commenting fs16"></span>&nbsp;<span class="counter is-left bg-gray">' . number_format($v['cnt']) . '</span></td>';
				}
				print '</tr>';
			}
			print '</tbody>';
			print '</table>';
		}
	}
	?>
	<?php
	if($data_shops){
	?>
	<section>
		<h2 class="ttl mb10 bg-main-color white pl10"><?= $data_station['name'] ?>に派遣可能なデリヘル店一覧</h2>
		<?php
		print view::element('part_shop_list');
		?>
	</section>
	<?php
	}
	?>
</div>