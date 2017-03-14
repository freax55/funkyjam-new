<div id="footer">
	<address>&copy; <?= date("Y") ?> <?= SITENAME ?></address>
</div>

<script src="/js/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/common.js"></script>
<script src="/js/admin.js"></script>
<?php
if (isset($coordinate)) { print '<script src="//maps.google.com/maps/api/js"></script>'; }
if (isset($javascript)) {
	foreach ($javascript as $v) {
		print '<script src="/js/' .$v. '.js"></script>';
	}
}
?>
<script>
$(function(){
	$('.error-message').prepend('<i class="icon icon-exclamation-sign"></i> ');
	$("#submenu h4").click(function(){
		$(this).next("ul").slideDown('fast', 'linear')
		.siblings("ul:visible").slideUp('fast', 'linear');
		$(this).toggleClass("active");
		$(this).siblings("h4").removeClass("active");
	});
	<?php
	// 受け取った配列をエレメントとして書き出す（onload）
	if (!empty($scripts_onload)) {
		for ($i=0; $i<count($scripts_onload); $i++) {
			print View::element($scripts_onload[$i]);
		}
	}
	// 二重サブミット防止
	print View::element("script_disable_on_submit");
	?>
});
<?php
// 受け取った配列をエレメントとして書き出す
if (!empty($scripts)) {
	for ($i=0; $i<count($scripts); $i++) {
		print View::element($scripts[$i]);
	}
}
?>
</script>

</body>
</html>