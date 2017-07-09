<?php
// print $this->element('sql_dump');
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/js/jquery.1.8.3.min.js"><\/script>')</script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
<!-- <script src="/js/bootstrap.min.js"></script> -->
<!-- <script src="/js/common.js"></script> -->
<script src="/js/admin.js?v=<?= VERSION_JS ?>"></script>
<?php
// if (isset($coordinate)) { print '<script src="//maps.google.com/maps/api/js?sensor=false"></script>'; }
if (isset($javascript)) {
	foreach ($javascript as $v) {
		print '<script src="/js/' .$v. '.js"></script>';
	}
}
?>
<script>
$(function(){
	$('.error-message').prepend('<i class="icon icon-exclamation-sign"></i> ');
	<?php
	// 受け取った配列をエレメントとして書き出す（onload）
	if (!empty($scripts_onload)) {
		for ($i=0; $i<count($scripts_onload); $i++) {
			print View::element($scripts_onload[$i]);
		}
	}
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
<script type="text/javascript">
    $(function () {
      $('[data-toggle="tt"]').tooltip();
    })
</script>
</body>
</html>