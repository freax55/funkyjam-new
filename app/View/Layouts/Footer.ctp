
<div id="footer">
	<div class="container">
		<p class="footer-text">Copyright &copy; Funky Jam All rights reserved.</p>
	</div>
	<div class="footer-text2">
		<a href="/privacy">Privacy Policy</a>
	</div>
</div>


<p class="pagetop"><a href="#wrap">▲</a></p>

<script>
$(document).ready(function() {
  var pagetop = $('.pagetop');
    $(window).scroll(function () {
       if ($(this).scrollTop() > 100) {
            pagetop.fadeIn();
       } else {
            pagetop.fadeOut();
            }
       });
       pagetop.click(function () {
           $('body, html').animate({ scrollTop: 0 }, 500);
              return false;
   });
});
</script>
<script>
  objectFitImages('img.object-fit-img');
</script>
<?php
if($this->name == 'Root' && $this->action == 'index'){
  print View::element('script_slider_top');
}
?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
<script type="text/javascript" src="/js/jquery.1.11.1.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script type="text/javascript" src="/js/bootstrap.js"></script> 
<script type="text/javascript" src="/js/jquery.prettyPhoto.js"></script> 
<script type="text/javascript" src="/js/jquery.isotope.js"></script> 
<script type="text/javascript" src="/js/jqBootstrapValidation.js"></script> 

<!-- Javascripts
    ================================================== --> 
<script type="text/javascript" src="/js/main2.js"></script>

<script src="/js/jquery.min.js"></script>
<script src="/js/common.js?v=<?= VERSION_JS ?>"></script>
<script src="/js/jquery.tada.js"></script>
<script type="text/javascript" src="/js/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="/js/ofi.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('#lightgallery').lightGallery();
});
</script>
<script src="/js/lightgallery.js"></script>
<script src="/js/lg-fullscreen.js"></script>
<script src="/js/lg-thumbnail.js"></script>
<script src="/js/lg-zoom.js"></script>

</body>
</html>