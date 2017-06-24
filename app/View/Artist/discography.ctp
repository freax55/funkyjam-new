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



<div id="discography-page-section">
    <p class="artist-tit">Discography</p>
</div>


<ol class="breadcrumb discocenter">
    <li class="clearfix2"><a href="#album">Album</a></li>
    <li class="clearfix2"><a href="#bestalbum">Best Album</a></li>
    <li class="clearfix2"><a href="#usalbum">U.S. Album</a></li>
    <li class="clearfix2"><a href="#single">Single</a></li>
    <li class="clearfix2"><a href="#dvd">DVD/Video</a></li>
    <li class="clearfix2"><a href="#book">Book</a></li>
</ol>


<div class="row topthirty">
    <div class="col-sm-3 release">
        <img src="/img/portfolio/album_21.jpg" alt="">
    </div>

    <div class="col-sm-9">
        <p class="DiscographyTitle">L.O.K</p>
        <p class="release">2015/3/18 Release</p>
        <ol>
            <li>1 L.O.K 〜Foreplay〜</li>
            <li>2 Cosmic Ride feat. AKLO</li>
            <li>3 Free Style 【2014年「シュウェップス」CMソング】</li>
            <li>4 majo ?</li>
            <li>5 Squeeze U</li>
            <li>6 Honey Trap</li>
            <li>7 Loving Power 【2015年 ヨコハマタイヤBluEarthブルーアース CMソング】</li>
            <li>8 L.O.K 〜The play〜</li>
            <li>9 Upside Down 【2014年「フォルクスワーゲン”up!”」TVCMイメージソング】</li>
            <li>10 Da Slow Jam</li>
            <li>11 Tiny Space</li>
            <li>12 Peaceful Sky</li>
            <li>13 Bring me up! 【2012-13年「フォルクスワーゲン”up!”」TVCMイメージソング】</li>
        </ol>
        <p class="bold">&lt;初回限定盤特典DVD&gt;</p>
        <ol>
            <li>1 Bring me up! (Music Video)</li>
            <li>2 Upside Down (Music Video)</li>
            <li>2 Free Style (Music Video)</li>
            <li>4 TOSHINOBU KUBOTA 2013-14 ドキュメント "Kissing for my people"</li>
        </ol>
        <ul>
            <li class="clearfix2"><a href="http://www.amazon.co.jp/L-O-K-初回生産限定盤-DVD付-久保田-利伸/dp/B00RNI9LFC/ref=ntt_mus_ep_dpi_1" target="_blank"><img src="/img/portfolio/btn_amazon.jpg" alt="amazon.co.jpで買う"></a></li>
            <li class="clearfix2"><a href="http://www.sonymusicshop.jp/m/item/itemShw.php?site=S&amp;ima=1519&amp;cd=SECL000001654" target="_blank"><img src="/img/portfolio/btn_sony.jpg" alt="CD/DVD Sop Sony Music Shopで買う"></a></li>
        </ul>
    </div>
</div>



<?= view::element('part_side_artist') ?>

<?= view::element('part_artist_news') ?>

