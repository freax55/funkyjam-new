<header class="ttl-wrapper ttl ttl-sub mb10 toggle-sp">
	<span class="i-location"></span><h2>エリアから探す</h2>
</header>
<?php
if($this->common->isSP()){
	$toggle_content = ' toggle-content-sp';
} else {
	$toggle_content = '';
}
?>
<dl class="brdr bg-gray-light p15 radius2 mb30<?= $toggle_content ?>">
	<dt class="b fs16"><a href="/<?= $prefs_en[1] ?>/">北海道</a></dt>
	<dd class="mb10">
		<ul class="li-mb5">
			<?php
			foreach ($areas[1] as $k => $v) {
				print '<li><span class="i-play3 fs10 gray"></span>&nbsp;<a href="/' . $prefs_en[1] . '/area/' . $k . '/">' . $v['ja'] . '</a></li>';
			}
			?>
		</ul>
	</dd>
	<dt class="b fs16"><a href="/<?= $prefs_en[13] ?>/">東京</a></dt>
	<dd class="mb10">
		<ul class="li-mb5">
			<?php
			foreach ($areas[13] as $k => $v) {
				print '<li><span class="i-play3 fs10 gray"></span>&nbsp;<a href="/' . $prefs_en[13] . '/area/' . $k . '/">' . $v['ja'] . '</a></li>';
			}
			?>
		</ul>
	</dd>
	<dt class="b fs16"><a href="/<?= $prefs_en[14] ?>/">神奈川</a></dt>
	<dd class="mb10">
		<ul class="li-mb5">
			<?php
			foreach ($areas[14] as $k => $v) {
				print '<li><span class="i-play3 fs10 gray"></span>&nbsp;<a href="/' . $prefs_en[14] . '/area/' . $k . '/">' . $v['ja'] . '</a></li>';
			}
			?>
		</ul>
	</dd>
	<dt class="b fs16"><a href="/<?= $prefs_en[15] ?>/">新潟</a></dt>
	<dd class="mb10">
		<ul class="li-mb5">
			<?php
			foreach ($areas[15] as $k => $v) {
				print '<li><span class="i-play3 fs10 gray"></span>&nbsp;<a href="/' . $prefs_en[15] . '/area/' . $k . '/">' . $v['ja'] . '</a></li>';
			}
			?>
		</ul>
	</dd>
	<dt class="b fs16"><a href="/<?= $prefs_en[23] ?>/">愛知</a></dt>
	<dd class="mb10">
		<ul class="li-mb5">
			<?php
			foreach ($areas[23] as $k => $v) {
				print '<li><span class="i-play3 fs10 gray"></span>&nbsp;<a href="/' . $prefs_en[23] . '/area/' . $k . '/">' . $v['ja'] . '</a></li>';
			}
			?>
		</ul>
	</dd>
	<dt class="b fs16"><a href="/<?= $prefs_en[27] ?>/">大阪</a></dt>
	<dd class="mb10">
		<ul class="li-mb5">
			<?php
			foreach ($areas[27] as $k => $v) {
				print '<li><span class="i-play3 fs10 gray"></span>&nbsp;<a href="/' . $prefs_en[27] . '/area/' . $k . '/">' . $v['ja'] . '</a></li>';
			}
			?>
		</ul>
	</dd>
	<dt class="b fs16"><a href="/<?= $prefs_en[28] ?>/">兵庫</a></dt>
	<dd class="mb10">
		<ul class="li-mb5">
			<?php
			foreach ($areas[28] as $k => $v) {
				print '<li><span class="i-play3 fs10 gray"></span>&nbsp;<a href="/' . $prefs_en[28] . '/area/' . $k . '/">' . $v['ja'] . '</a></li>';
			}
			?>
		</ul>
	</dd>
	<dt class="b fs16"><a href="/<?= $prefs_en[40] ?>/">福岡</a></dt>
	<dd class="mb10">
		<ul class="li-mb5">
			<?php
			foreach ($areas[40] as $k => $v) {
				print '<li><span class="i-play3 fs10 gray"></span>&nbsp;<a href="/' . $prefs_en[40] . '/area/' . $k . '/">' . $v['ja'] . '</a></li>';
			}
			?>
		</ul>
	</dd>
</dl>