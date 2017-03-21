
<!-- Header -->
<div class="news">
    <header class="text-center">
        <div class="artist-intro-text">
        <div class="clearfix">
        </div>
    </header>
</div>


<div id="breadcrumb">
    <div class="container">
        <div class="col-md-8 col-md-offset-2 leftzero">
        <?= $this->BreadCrumb->show($path) ?>
        </div>
    </div>
</div>

<?= view::element('part_artist_nav') ?>
<?php
?>
<!-- text Section -->
<div id="text-section">
    <div class="container-txt">
    <?php
    // ワードプレスに該当する投稿がなければ予備のページを呼び出す
    if ($is_contents === true) {
        print $content[0]['Post']['post_content'];
    } else {
        $file_term = str_replace('/', '_', $term_name);
        print view::element('content_' . $file_term);
    }
    ?>

<!-- Pagination Section -->
<?= View::element('pagination'); ?>
<!-- label Section -->
<div id="label-section">
    <div class="container-txt"> 
        <div class="col-sm-12 col-md-6 col-lg-6">
            <a href="http://www.sonymusic.co.jp/artist/ToshinobuKubota/" target="_blank">
            <img src="img/portfolio/Sony-Logo.jpg" class="img-responsive" alt="Project Title"> </a> </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <a href="http://cooljapanmusic.com/toshi-kubota-update/" target="_blank">
            <img src="img/portfolio/Englis-Kubota.jpg" class="img-responsive" alt="Project Title"> </a> </div>
        </div>
    </div>
</div>



<div id="pageTop">
    <a class="topnav" href="menu">
        <i class="fa fa-angle-double-up" aria-hidden="true"></i>
    </a>
</div>