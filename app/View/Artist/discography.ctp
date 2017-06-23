<!-- Header -->
<header class="text-center" name="home">
    <img class="other-banner" src="/img/artist-header-bg-<?= $current ?>.jpg" alt="Funkyjam">
</header>


<div id="breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            <?= $this->BreadCrumb->show($path) ?>
            </div>


<?= view::element('part_artist_nav') ?>


<?php
/*
<!-- Name Navigation -->
<div id="namenav">
    <div class="container-txt">
        <div class="name">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">     
            <h1>Toshinobu Kubota</h1>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 snsbar">
                <a href="https://www.facebook.com/toshinobukubota" target="_blank">
                <i class="fa fa-facebook-official snsicon" aria-hidden="true"></i></a>
                <a href="https://twitter.com/kubota_4_real" target="_blank">
                <i class="fa fa-twitter-square snsicon" aria-hidden="true"></i></a>
                <a href="https://www.youtube.com/user/toshinobukubotaSMEJ" target="_blank">
                <i class="fa fa-youtube-square snsicon" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</div>

<div id="otherartist">
    <div class="container-txt">
        <div class="artistnav">
            <div class="btn btn-on5 col-xs-6 col-sm-3 col-md-3 col-lg-3"><a href="profile.html">Toshinobu Kubota</a></div>
            <div class="btn btn-on4 col-xs-6 col-sm-3 col-md-3 col-lg-3"><a href="profile.html">Rinko Urashima</a></div>
            <div class="btn btn-on4 col-xs-6 col-sm-3 col-md-3 col-lg-3"><a href="discography.html">Daisuke Mori</a></div>
            <div class="btn btn-on4 col-xs-6 col-sm-3 col-md-3 col-lg-3"><a href="performance.html">Brown Eyed Soul</a></div>
        </div>
    </div>
</div>


<div id="artistnav">
    <div class="container-txt">
        <div class="artistnav">
            <div class="btn btn-on col-xs-6 col-sm-6 col-md-2 col-lg-2"><a href="/artist/<?= $artist ?>">News</a></div>
            <div class="btn btn-artist col-xs-6 col-sm-6 col-md-2 col-lg-2"><a href="/artist/<?= $artist ?>/profile">Profile</a></div>
            <div class="btn btn-artist col-xs-6 col-sm-6 col-md-2 col-lg-2"><a href="/artist/<?= $artist ?>/discography">Discography</a></div>
            <div class="btn btn-artist col-xs-6 col-sm-6 col-md-2 col-lg-2"><a href="/artist/<?= $artist ?>/performance">Performance</a></div>
            <div class="btn btn-artist col-xs-6 col-sm-6 col-md-2 col-lg-2"><a href="/artist/<?= $artist ?>/otherwork">Other Work</a></div>
            <div class="btn btn-baribari col-xs-6 col-sm-6 col-md-2 col-lg-2 bottomthirty"><a href="/artist/<?= $artist ?>/baribaricrew">Bari Bari Crew</a></div>
        </div>
    </div>
</div>
*/
?>
<!-- text Section -->
<div id="text-section">
    <?php
    // foreach($data_discs as $v) {
    //     case 'variable':
    //         # code...
    //         break;
    // }
    ?>


</div>
</div>

<?= view::element('part_side_artist') ?>

<?= view::element('part_artist_news') ?>



<div id="pageTop">
    <a class="topnav" href="menu">
        <i class="fa fa-angle-double-up" aria-hidden="true"></i>
    </a>
</div>





