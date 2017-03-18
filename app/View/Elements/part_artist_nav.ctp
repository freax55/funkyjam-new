<?php

?>

<div id="namenav">
    <div class="container-txt">
        <div class="name">
            <div class="">     
            <h1><?= $ary_names[$current]['en'] ?></h1>
            </div>
            <div class="">
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
        <?php
        foreach($ary_params as $v) {
            $color = ($v == $current)?'btn-on5':'btn-on4';
            print '<div class="btn ' . $color . ' col-xs-6 col-sm-3 col-md-3 col-lg-3">';
            print '<a href="/artist/' . $v . '">';
            print $ary_names[$v]['en'];
            print '</a></div>';
        }
            // <div class="btn btn-on5 col-xs-6 col-sm-3 col-md-3 col-lg-3"><a href="profile.html">Toshinobu Kubota</a></div>
            // <div class="btn btn-on4 col-xs-6 col-sm-3 col-md-3 col-lg-3"><a href="profile.html">Rinko Urashima</a></div>
            // <div class="btn btn-on4 col-xs-6 col-sm-3 col-md-3 col-lg-3"><a href="discography.html">Daisuke Mori</a></div>
            // <div class="btn btn-on4 col-xs-6 col-sm-3 col-md-3 col-lg-3"><a href="performance.html">Brown Eyed Soul</a></div>
            ?>
        </div>
    </div>
</div>


<div id="artistnav">
    <div class="container-txt">
        <div class="artistnav">
            <div class="btn btn-on col-xs-6 col-sm-6 col-md-2 col-lg-2"><a href="/artist/<?= $current ?>">News</a></div>
            <div class="btn btn-artist col-xs-6 col-sm-6 col-md-2 col-lg-2"><a href="/artist/<?= $current ?>/profile">Profile</a></div>
            <div class="btn btn-artist col-xs-6 col-sm-6 col-md-2 col-lg-2"><a href="/artist/<?= $current ?>/discography">Discography</a></div>
            <div class="btn btn-artist col-xs-6 col-sm-6 col-md-2 col-lg-2"><a href="/artist/<?= $current ?>/performance">Performance</a></div>
            <div class="btn btn-artist col-xs-6 col-sm-6 col-md-2 col-lg-2"><a href="/artist/<?= $current ?>/otherwork">Other Work</a></div>
            <div class="btn btn-baribari col-xs-6 col-sm-6 col-md-2 col-lg-2 bottomthirty"><a href="/artist/kubota/fanclub">Bari Bari Crew</a></div>
        </div>
    </div>
</div>
