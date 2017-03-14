<ol class="li-mb20">
<?php
foreach ($clubs as $c){
	$c = $c['Club'];
?>
	<li class="brdr radius2 mb10">
		<h3 class="ph15 pv5 bg-gray-light df fs18"><a href="/club/<?= $c['id'] ?>/"><?= $c['name'] ?></a></h3>
		<div class="p15 cf">
			<a href="/club/<?= $c['id'] ?>/">
				<figure class="col span-6 mb10-sp">
				<?php
				if(!$this->common->isSP()){
					if($c['img_list'] != ''){
					// PCで$img_listがある場合
					print '<img data-src="/img/'. $c['img_list'] .'" src="/img/loader.gif" class="ready-img" alt="'. $c['name'] .'の一覧画像">';
					} else {
					// PCで$img_listが無い場合
					print '<img data-src="/img/noimage-656-374.png" src="/img/loader.gif" class="ready-img" alt="'. $c['name'] .'の一覧画像">';
					}
				} else {
					if($c['img_list_sp'] != ''){
					// スマホで$img_list_spがある場合
					print '<img data-src="/img/'. $c['img_list_sp'] .'" src="/img/loader.gif" class="ready-img" alt="'. $c['name'] .'の一覧画像">';
					} else {
					// スマホで$img_list_spが無い場合
					print '<img data-src="/img/noimage-656-374.png" src="/img/loader.gif" class="ready-img" alt="'. $c['name'] .'の一覧画像">';
					}
				}
				?>
				</figure>
			</a>
			<div class="col span-6">
				<table class="table table-condensed table-brdr">
					<tbody>
						<tr>
							<th class="fwn gray w90"><span class="gray i-location"></span>&nbsp;住所</th>
							<?php
							if($c['address'] != null){
								$address = $c['address'];
							} else {
								$address = '非公開';
							}
							?>
							<td><span><?= $address ?></span></td>
						</tr>
						<tr>
							<th class="fwn gray"><span class="gray i-map"></span>&nbsp;エリア</th>
							<?php
							if($c['area_id'] != 0){
								$area_id = $c['area_id'];
							} else {
								$area_id = '';
							}
							?>
							<td><a href="/<?= $pref_name_en ?>/area/<?= $area_id ?>"><?= ($c['area_id'] != 0) ? $areas[$pref_id][$area_id]['ja']:'' ?></a></td>
						</tr>
						<tr>
							<th class="fwn gray"><span class="gray i-phone"></span>&nbsp;電話番号</th>
							<?php
							if($c['tel'] != null){
								$tel = $c['tel'];
							} else {
								$tel = '非公開';
							}
							?>
							<td><span><?= $tel ?></span></td>
						</tr>
						<tr>
							<th class="fwn gray"><span class="gray i-clock"></span>&nbsp;営業時間</th>
							<?php
							if($c['open'] != null && $c['close'] != null){
								$time = '<time datetime="' . $c['open'] . '">' . $c['open'] . '</time>〜<time datetime="' . $c['close'] . '">' . $c['close'] . '</time>';
							} else {
								$time = '<span>要確認</span>';
							}
							?>
							<td><?= $time ?></td>
						</tr>
						<tr>
							<th class="fwn gray"><span class="i-calendar"></span>&nbsp;定休日</th>
							<?php
							if($c['holiday'] != null){
								$holiday = $c['holiday'];
							} else {
								$holiday = '<span>要確認</span>';
							}
							?>
							<td><?= $holiday ?></td>
						</tr>
						<tr>
							<th class="fwn gray"><span class="red i-woman"></span>&nbsp;会員数</th>
							<?php
							if($c['cnt_women'] != null){
								$cnt_women = $c['cnt_women'];
							} else {
								$cnt_women = '非公開';
							}
							?>
							<td><span><?= $cnt_women ?></span></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</li>
<?php
}
?>
</ol>