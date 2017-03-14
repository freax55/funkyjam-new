<div id="footer" style="padding-bottom: 20px;">
	<div class="container" style="text-align: center;">
		<p style="margin-bottom: 0px;">Copyright &copy; Funky Jam All rights reserved.</p>
		<a href="privacy">Privacy Policy</a>
	</div>
</div>



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
<script type="text/javascript" src="/js/jquery.1.11.1.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script type="text/javascript" src="/js/bootstrap.js"></script> 
<script type="text/javascript" src="/js/SmoothScroll.js"></script> 
<script type="text/javascript" src="/js/jquery.prettyPhoto.js"></script> 
<script type="text/javascript" src="/js/jquery.isotope.js"></script> 
<script type="text/javascript" src="/js/jqBootstrapValidation.js"></script> 
<script type="text/javascript" src="/js/contact_me.js"></script> 

<!-- Javascripts
    ================================================== --> 
<script type="text/javascript" src="/js/main.js"></script>




<script src="/js/jquery.min.js"></script>
<script src="/js/common.js?v=<?= VERSION_JS ?>"></script>
<script src="/js/jquery.tada.js"></script>
<script>
	$(".ready-img").tada();
	Tada.setup({
		delay: 100,
		callback: function( i_element ) {
			$( i_element ).addClass( "loaded-img" );
		}
	});
	$(".ready-img").tada();
</script>
<?php
if (isset($javascript) || !empty($scripts)) {
?>

<?php
}
if (isset($coordinate)) { print '<script src="//maps.google.com/maps/api/js?sensor=true"></script>'; }
if (isset($javascript)) {
	if (!empty($javascript)) {
		foreach ($javascript as $v) {
			print '<script src="/js/' .$v. '.js"></script>';
		}
	}
}
?>
<?php
// 受け取った配列をエレメントとして書き出す
if (!empty($scripts)) {
	print '<script>';
	for ($i=0; $i<count($scripts); $i++) {
		print View::element($scripts[$i]);
	}
	print '</script>';
}
?>
<script>
	$('.toggle-sp').click( function(){
	$('.toggle-content-sp').slideToggle();
	});
</script>
<?= View::element('part_analytics'); ?>
<?php
// print $this->element('sql_dump');
// <script src="/js/responsive-sidemenu.js"></script>
?>

</body>
</html>