<header class="ttl ttl-main mb10 df df-jc-between df-ai-center">
	<h1 class="fwn"><?= $h ?>の交際クラブ</h1>
</header>
<div class="mb10">
	<span class="red"><?= $cnt ?>件</span>&nbsp;<span class="gray fs12">掲載中</span>
</div>
<?php
if($cnt != 0) {
	print View::element('part_club_list');
}
?>