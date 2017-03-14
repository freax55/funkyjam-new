<?php
$auth_user = $this->Session->read('User');
if ($auth_user['Role']['id'] <= 3) {
	$last_month = strtotime(date('Y-m-1').' -1 month');
	$month_ja   = date('Y年m月', $last_month);
	$month_url  = date('Y-m', $last_month);
?>
<div class="box box-gray">
	<h2 style="overflow:hidden">
		<div style="float:left">ダッシュボード</div>
		<div style="float:right"></div>
	</h2>
	<ul class="cf">
		<li class="fl mr10"><a href="/admin/shop/" class="btn btn-success">店舗一覧</a></li>
		<li class="fl mr10"><a href="/admin/aggregate/pv_hotel/date:<?= $month_url ?>/" class="btn btn-warning" onclick="openWindow(this.href, 830, 800); return false;"><?= $month_ja ?>度主要県ホテル別PVランキング</a></li>
		<li class="fl"><a href="/admin/hotel/" class="btn btn-primary">ホテル一覧</a></li>
	</ul>
</div>
<hr>
<?php
}
?>