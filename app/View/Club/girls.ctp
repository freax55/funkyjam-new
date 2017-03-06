<?php
	$d = $data_shop['Shop'];
	$n = $data_shop['News'];
	$tags = json_decode($d['tags'], true);
	if ($d['plan_id'] == 0) {
	?>

	<?php
	}
	?>

	<?php //pr($this->params); ?>
<h2 class="ttl ttl-black"><?= $d['name'] ?>の在籍の女の子一覧</h2>
<?php
/*
<ul class="tabs-type tabs-type-col4 cf mt20">
	<li><a href="/shop/detail/<?= $d['id'] ?>/girls/"><span class="icon-woman"></span>在籍女の子一覧</a></li>
	<li><a href=""><span class="icon-clock"></span>出勤情報</a></li>
	<li><a href=""><span class="icon-wakaba"></span>新人</a></li>
	<li><a href=""><span class="icon-crown"></span>ランキング</a></li>
</ul>
*/
?>
<ul class="girls-list girls-list-col5 cf mt20">
	<?php
	foreach ($data_girls as $v) {
		print '<li><div class="p3">';
		$g = $v['Girl'];
		if (isset($v['GirlImage'][0])) {
			$img = '/img/girl/' .$v['GirlImage'][0]['name']. '.jpg';
		} else {
			$img = '/img/noimage-girl.png';
		}
		print '<a href="/girl/detail/' .$g['id']. '/" girl_id="' .$g['id']. '" class="img-wrapper g-img">';
		print '<figure class="img-inner"><img src="' . $img . '" alt="' . $g['name'] . '">';
		print '<figcaption class="girl-prof">' . $g['name']. '(' .$g['age']. ')<br>';
		$size_c = ($g['size_c'] != "0") ? '(' . $g['size_c'] . ')' : '';
		print $g['size_t'] . '-' . $g['size_b'] . $size_c . '-' . $g['size_w'] . '-' . $g['size_h'] . '</figcaption>';
		print '</figure></a>';
		if (!empty($v['Schedule'])) {
			print $this->common->getRibbon2('danger', '出勤中');
		}
		print '</div></li>';
	}
	?>
</ul>