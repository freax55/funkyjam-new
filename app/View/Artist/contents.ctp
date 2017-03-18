<?php
$artist = 'kubota';
// pr($current);
?>

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
    <div class="container-txt">
    <?php
    // ワードプレスに該当する投稿がなければ予備のページを呼び出す
    if ($is_contents === true) {
        print $content['post_content'];
    } else {
        $file_term = str_replace('/', '_', $term_name);
        print view::element('content_' . $file_term);
    }
    
    /*
        <h2 class="artistnews4" >4月28日よりNHK-FMにてパーソナリティ番組スタート！</h2>
        <img src="img/portfolio/Kubota original.jpg" class="img-responsive">
        <h3 class="border-left-bottom">RADIO</h3>
        <p>4月28日(金)23:00から、久保田利伸がパーソナリティを務めるラジオ番組「久保田利伸 ファンキーフライデー」がスタート致します。4月28日(金)23:00から、久保田利伸がパーソナリティを務めるラジオ番組「久保田利伸 ファンキーフライデー」がスタート致します。
        <p>■放送日: 毎月末(金) 23:00〜24:00
        <p>■再放送: 翌週(木) 10:00〜11:00
        <p>■放送波: NHK-FM
        <p>どうぞお楽しみに！
        </p>

        <h3 class="border-left-bottom">TV</h3>
        <p>MUSIC ON!TVにてミュージックビデオ特集のリピート放送が決定！
        <p>放送日時：3/14(火)22:30〜23:00
        <p>放送局：MUSIC ON! TV
        <p>番組名：「久保田利伸特集」（ミュージックビデオ特集）
        <p>MUSIC ON! TV ホームページ：
        <a href="http://www.m-on.jp/program/detail/kubota-sp-1612/" target="_blank">http://www.m-on.jp/program/detail/kubota-sp-1612/</a>

        <h3 class="border-left-bottom">WEB</h3>
        <p>Yahoo! 音楽＆エンタメアナリストページにてインタビュー掲載<p>
            <a href="http://bylines.news.yahoo.co.jp/tanakahisakatsu/20161201-00065019/" target="_blank">http://bylines.news.yahoo.co.jp/tanakahisakatsu/20161201-00065019/</a>
        <p>bmrインタビュー掲載
            <a href="http://bmr.jp/feature/168192" target="_blank">http://bmr.jp/feature/168192</a><p>
         <p>Wax Poetics Japanインタビュー掲載
            <a href="http://www.waxpoetics.jp/inte…/toshinobu-kubota-interview-1/" target="_blank">http://www.waxpoetics.jp/inte…/toshinobu-kubota-interview-1/</a>
        <p>Rolling Stone(ローリングストーン)日本版WEBでインタビュー掲載
        <p>11/22（火）〜 「THE BADDEST 〜Collaboration〜」
        <p>11/23（水）〜 「ジョージ・クリントン、ブーツィ・コリンズ、メイシオ・パーカーとの共演秘話」
        <p>11/24（木）〜 「プリンスが天才と言われる理由」
        <p>11/25（金）〜 「久保田利伸が選ぶプリンスの楽曲ベスト５」
        <p>※オフィシャルHPはこちら！
        <p>J:COMウェブサイト「MY J:COM」インタビュー掲載
            <a href="http://www2.myjcom.jp/special/column/kubotatoshinobu/" target="_blank">http://www2.myjcom.jp/special/column/kubotatoshinobu/</a>
        <p>小学館「Woman Insight」インタビュー掲載（前編・後編）
            <a href="http://www.womaninsight.jp/summary/archives/241827" target="_blank">http://www.womaninsight.jp/summary/archives/241827</a>
        <p>エンタメ特化型メディア情報「SPICE」インタビュー掲載
            <a href="http://spice.eplus.jp/articles/89332" target="_blank">http://spice.eplus.jp/articles/89332</a>
        <p>-----------------------------------
        <p>楽曲提供
        <p>2016年10月12日（水）発売、関ジャニ∞ニューシングル「パノラマ」（通常盤）に楽曲。
        <p>「王様クリニック by TAKATSU-KING」を提供。是非お聴きください！
        <p>詳しくはこちら
            <a href="http://www.infinity-r.jp/pages/news/20160912_184.html" target="_blank">http://www.infinity-r.jp/pages/news/20160912_184.html</a>
        <p>-----------------------------------
        <p>動画配信
        <p>会員数・作品数No.1の動画・映像配信サービスdTVにて
        <p>「TOSHINOBU KUBOTA CONCERT TOUR 2015 L.O.K Supa Dupa Digest」が配信中!!
        <p>4K対応端末では、4KでLIVE映像が楽しめます!!
        <p>■「TOSHINOBU KUBOTA CONCERT TOUR 2015 L.O.K Supa Dupa Digest」視聴ページ
            <a href="http://video.dmkt-sp.jp/ep/10185516" target="_blank">http://video.dmkt-sp.jp/ep/10185516</a>
        <p>■dTV公式サイト
            <a href="http://video.dmkt-sp.jp/ft/p0004001?campaign=gui10000001" target="_blank">http://video.dmkt-sp.jp/ft/p0004001?campaign=gui10000001</a>
        <p>「TOSHINOBU KUBOTA CONCERT TOUR 2015 L.O.K Supa Dupa Digest」の4K映像はYouTubeでもお楽しみ頂けます。
            <a href="https://youtu.be/nb5g09_VLMA" target="_blank">https://youtu.be/nb5g09_VLMA</a>
        </p>
    </div>
    */


?>
<!-- Pagination Section -->
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




