<?php
$bonus = 0;
$d = $data_shop['Shop'];

?>
<section id="fixedbarbottom">
	<div class="white container">
		<div class="pt7 pb7 df flex-jc-between">
			<?php
			if ($this->common->isSP()) {
			?>
			<div><i class="icon-time"></i><?php
			// 営業時間を組み立てる
			$business_time = $this->common->getBusinessTime([
				'business_time_24' => $d['business_time_24'],
				'business_time_start_hinode' => $d['business_time_start_hinode'],
				'business_time_end_last' => $d['business_time_end_last'],
				'business_time_start' => $d['business_time_start'],
				'business_time_end' => $d['business_time_end']
			]);
			print $business_time;
			?></div>
			<div>
				<a href="tel:<?= $d['tel'] ?>" class="btn btn-flat" onclick="javascript:callShop('<?= $d['status_discount'] ?>','<?= $d['id'] ?>','<?= $bonus ?>');ga('send', 'event', {'eventCategory':'click', 'eventAction':'Call', 'eventLabel':'[<?= $d['pref'] ?>][<?= $d['plan_id'] ?>][<?= $d['id'] ?>]<?= $d['name'] ?>'})"><i class="fa fa-phone"></i>&nbsp;お店に電話する</a>
			</div>
			<?php
			} else {
			?>
				<div class="fs25"><?= $d['name'] ?></div>
				<div class="tar fs25">
					<i class="fa fa-phone"></i>&nbsp;<span class="b"><?= $d['tel'] ?></span>
				</div>

			<?php
			}
			?>
		</div>
	</div>
</section>