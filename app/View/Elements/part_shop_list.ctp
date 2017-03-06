<?php
$data_shops_s = $data_shops_a = $data_shops_b = [];
foreach ($data_shops as $v) {
	switch ($v['Shop']['plan_id']) {
		case 3:
		case 2:
		$data_shops_a[] = $v;
			break;
		case 1:
			$data_shops_b[] = $v;
			break;
		case 0:
			break;
	}
	$i=1;
	$j=0;
}
?>

	<ol class="li-shops-sa df">
		<?php
		if (!empty($data_shops_a)) {
			foreach ($data_shops_a as $v) {
				$s  = $v['Shop'];
				$bonus = 0;
				if ($s['discount_bonus'] != null && $s['discount_bonus'] != 0){
					$bonus = $s['discount_bonus'];
				}
				$business_time = "";
				if ($s['business_time_24'] == 1) {
					$business_time.= '24時間営業';
				} else {
					if ($s['business_time_start_hinode'] == 1) {
						$business_time.= '日の出〜';
					} else {
						$business_time.= '<time datetime="' . $s['business_time_start'] . '">' . $s['business_time_start'] . '</time>&nbsp;〜&nbsp;';
					}
					if ($s['business_time_end_last'] == 1) {
						$business_time.= 'LAST';
					} else {
						if (substr($s['business_time_end'], 0, 2) == "00") {
							$business_time.= '<time datetime="24:00">24:00</time>';
						}elseif(substr($s['business_time_end'], 0, 1) == 0) {
							$business_time.= '翌<time datetime="' . $s['business_time_end'] . '">' . $s['business_time_end'] . '</time>';
						} else {
							$business_time.= '<time datetime="' . $s['business_time_end'] . '">' . $s['business_time_end'] . '</time>';
						}
					}
				}
			?>
				<li>
					<header class="pl15 pr15 pt5 pb5 bg-gray-light"><a href="/shop/<?= $s['id'] ?>/"><?= $s['name'] ?></a></header>
					<div class="p15 df">
						<?php
						if($s['img_list'] != ""){
						?>
						<a href="/shop/<?= $s['id'] ?>/" class="db ">
							<figure class="img-shops-li mr10">
								<img src="/img/shop/<?= $s['img_list'] ?>" alt="<?= $s['name'] ?>一覧用画像">
							</figure>
						</a>
						<?php
						}
						?>
						<ul>
							<li><span class="i-drive_eta gray"></span>&nbsp;<?= $s['city'] ?>発</li>
							<li><span class="i-price-tag gray"></span>&nbsp;<?= $jobs[$s['job_id']] ?></li>
							<li><span class="i-query_builder gray"></span>&nbsp;<?= $business_time ?></li>
							<?php
							if(!$this->common->isSP()){
							?>
								<li><span class="i-local_phone gray"></span>&nbsp;<?= $s['tel'] ?></li>
							<?php
							}
							?>
						</ul>
					</div>
					<?php
					if($this->common->isSP()){
					?>
					<div class="pl15 pr15 pb15">
						<a href="tel:<?= $s['tel'] ?>" onclick="javascript:callShop('<?= $s['status_discount'] ?>','<?= $s['id'] ?>','<?= $bonus ?>');ga('send', 'event', {'eventCategory':'click', 'eventAction':'Call', 'eventLabel':'[<?= $prefs[$s['pref_id']] ?>][<?= $s['plan_id'] ?>][<?= $s['id'] ?>]<?= $s['name'] ?>'})" class="btn btn-light-blue btn-call db"><span class="i-local_phone"></span>&nbsp;<?= $s['tel'] ?></a>
					</div>
					<?php
					}
					?>
				</li>
			<?php
			}
		}
		?>
	</ol>

	<?php
	// if (!empty($data_shops_b)) {
		print '<ol class="li-shops">';
		// Aプランのリスト
		foreach ($data_shops_a as $v) {
			$s  = $v['Shop'];
			$bonus = 0;
			if ($s['discount_bonus'] != null && $s['discount_bonus'] != 0){
				$bonus = $s['discount_bonus'];
			}
			$business_time = "";
			if ($s['business_time_24'] == 1) {
				$business_time.= '24時間営業';
			} else {
				if ($s['business_time_start_hinode'] == 1) {
					$business_time.= '日の出〜';
				} else {
					$business_time.= '<time datetime="' . $s['business_time_start'] . '">' . $s['business_time_start'] . '</time>&nbsp;〜&nbsp;';
				}
				if ($s['business_time_end_last'] == 1) {
					$business_time.= 'LAST';
				} else {
					if (substr($s['business_time_end'], 0, 2) == "00") {
						$business_time.= '<time datetime="24:00">24:00</time>';
					}elseif(substr($s['business_time_end'], 0, 1) == 0) {
						$business_time.= '翌<time datetime="' . $s['business_time_end'] . '">' . $s['business_time_end'] . '</time>';
					} else {
						$business_time.= '<time datetime="' . $s['business_time_end'] . '">' . $s['business_time_end'] . '</time>';
					}
				}
			}
			?>
				<li class="df">
					<div class="name"><a href="/shop/<?= $s['id'] ?>"><?= $s['name'] ?></a></div>
					<ul class="df w60p">
						<li class="fee"><?= number_format($s['total_min']) ?>円〜</li>
						<li class="city"><span class="i-drive_eta gray"></span>&nbsp;<?= $s['city'] ?>発<?= $jobs[$s['job_id']] ?></li>
						<li class="time"><span class="i-query_builder gray"></span>&nbsp;<?= $business_time ?></li>
						<?php
						if(!$this->common->isSP()){
						?>
							<li class="tar tel"><span class="i-local_phone gray"></span>&nbsp;<?= $s['tel'] ?></li>
						<?php
						} else {
						?>
							<li class="tac tel mt10"><a href="tel:<?= $s['tel'] ?>" onclick="javascript:callShop('<?= $s['status_discount'] ?>','<?= $s['id'] ?>','<?= $bonus ?>');ga('send', 'event', {'eventCategory':'click', 'eventAction':'Call', 'eventLabel':'[<?= $prefs[$s['pref_id']] ?>][<?= $s['plan_id'] ?>][<?= $s['id'] ?>]<?= $s['name'] ?>'})" class="btn btn-light-blue btn-call w100p"><span class="i-local_phone"></span>&nbsp;<?= $s['tel'] ?></a></li>
						<?php
						}
						?>
					</ul>
				</li>
			<?php
			}
			foreach ($data_shops_b as $v) {
				// Bプランのリスト
				$s  = $v['Shop'];
				$bonus = 0;
				if ($s['discount_bonus'] != null && $s['discount_bonus'] != 0){
					$bonus = $s['discount_bonus'];
				}
				$business_time = "";
				if ($s['business_time_24'] == 1) {
					$business_time.= '24時間営業';
				} else {
					if ($s['business_time_start_hinode'] == 1) {
						$business_time.= '日の出〜';
					} else {
						$business_time.= '<time datetime="' . $s['business_time_start'] . '">' . $s['business_time_start'] . '</time>&nbsp;〜&nbsp;';
					}
					if ($s['business_time_end_last'] == 1) {
						$business_time.= 'LAST';
					} else {
						if (substr($s['business_time_end'], 0, 2) == "00") {
							$business_time.= '<time datetime="24:00">24:00</time>';
						}elseif(substr($s['business_time_end'], 0, 1) == 0) {
							$business_time.= '翌<time datetime="' . $s['business_time_end'] . '">' . $s['business_time_end'] . '</time>';
						} else {
							$business_time.= '<time datetime="' . $s['business_time_end'] . '">' . $s['business_time_end'] . '</time>';
						}
					}
				}
			?>
				<li class="df">
					<div class="name"><a href="/shop/<?= $s['id'] ?>"><?= $s['name'] ?></a></div>
					<ul class="df w60p">
						<li class="fee"><?= number_format($s['total_min']) ?>円〜</li>
						<li class="city"><span class="i-drive_eta gray"></span>&nbsp;<?= $s['city'] ?>発<?= $jobs[$s['job_id']] ?></li>
						<li class="time"><span class="i-query_builder gray"></span>&nbsp;<?= $business_time ?></li>
						<?php
						if(!$this->common->isSP()){
						?>
							<li class="tar tel"><span class="i-local_phone gray"></span>&nbsp;<?= $s['tel'] ?></li>
						<?php
						} else {
						?>
							<li class="tac tel mt10"><a href="tel:<?= $s['tel'] ?>" onclick="javascript:callShop('<?= $s['status_discount'] ?>','<?= $s['id'] ?>','<?= $bonus ?>');ga('send', 'event', {'eventCategory':'click', 'eventAction':'Call', 'eventLabel':'[<?= $prefs[$s['pref_id']] ?>][<?= $s['plan_id'] ?>][<?= $s['id'] ?>]<?= $s['name'] ?>'})" class="btn btn-light-blue btn-call w100p"><span class="i-local_phone"></span>&nbsp;<?= $s['tel'] ?></a></li>
						<?php
						}
						?>
					</ul>
				</li>
			<?php
		}
		print '</ol>';
	?>

<?php
if (isset($cnt_total) && $cnt_total > LIMIT_SHOPS) {
	print View::element('pagination');
}
?>