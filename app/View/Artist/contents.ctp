<!-- Header -->
<header class="text-center" name="home">
    <img class="other-banner" src="/img/artist-header-bg.jpg" alt="Funkyjam">
</header>


<div id="breadcrumb">
    <div class="container-txt">
        <div class="row resp"> 
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

</div>

<!-- Artist Section -->
<div id="artist-section-top">
    <div class="container">
        <h2>Artist</h2>
            <div class="row">
                <div class="col-sm-6 col-md-3 col-lg-3 web">
                    <article class="portfolio-item">
                        <div class="hover-bg">
                            <a href="/artist/kubota">
                            <div class="hover-text">
                                <h4>Toshinobu Kubota</h4>
                                <small>久保田利伸</small>
                            <div class="clearfix">
                            </div>
                            </div>
                            <img src="/img/portfolio/KubotaTop.jpg" class="img-responsive" alt="Toshinobu Kubota"></a> 
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 web">
                    <article class="portfolio-item">
                        <div class="hover-bg"> 
                            <a href="/artist/urashima">
                                <div class="hover-text">
                                <h4>Rinko Urashima</h4>
                                <small>浦嶋りんこ</small>
                            <div class="clearfix">
                            </div>
                            </div>
                            <img src="/img/portfolio/Urashima_Top.jpg" class="img-responsive" alt="Rinko Urashima"></a> 
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 web">
                    <article class="portfolio-item">
                        <div class="hover-bg"> 
                            <a href="/artist/mori">
                                <div class="hover-text">
                                <h4>Daisuke Mori</h4>
                                <small>森大輔</small>
                            <div class="clearfix">
                            </div>
                            </div>
                            <img src="/img/portfolio/MoriTop.jpg" class="img-responsive" alt="Daisuke Mori"></a> 
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 web">
                    <article class="portfolio-item">
                        <div class="hover-bg"> 
                            <a href="/artist/bes">
                                <div class="hover-text">
                                <h4>BROWN EYED SOUL</h4>
                                <small>ブラウン・アイド・ソウル</small>
                            <div class="clearfix">
                            </div>
                            </div>
                            <img src="/img/portfolio/BROWN-EYED-SOUL_Top.jpg" class="img-responsive" alt="BROWN EYED SOUL"> </a> 
                        </div>
                    </article> 
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Introduction Section -->
<div id="services-section">
    <div class="container"> 
        <div class="section-title">
            <h2>Introduction</h2>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <a class="home-introduction-item introduction" href="https://twitter.com/funky_manager" >
                    <i class="fa fa-twitter" aria-hidden="true"></i>
                    <h3 class="top-ten">Funky Managers Twitter</h4>
                    </a>
                    <p>久保田利伸、森大輔、浦嶋りんこ、ファンキー・ジャムアーティストの熱い最新情報をいち早くお届けします！Twitterでしか見れない写真も多数ありますので、是非フォローして下さい。</p>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a class="home-introduction-item" href="/mailmagazine" ><i class="fa fa-envelope-o" aria-hidden="true"></i>
                    <h3 class="top-ten">Mail Magazine</h4>
                    </a>
                    <p>ファンキー・ジャムのアーティストの最新情報を、いち早く皆様にメールマガジンでお届け致します。登録は無料で、簡単な質問にお答え頂くだけで、すぐに登録することが出来ます。</p>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a class="home-introduction-item" href="/art" ><i class="fa fa-pencil" aria-hidden="true"></i>
                    <h3 class="top-ten">Airt Master</h4>
                    </a>
                    <p>久保田利伸のFC会報表誌イラストでお馴染みの墨絵アーチストや、人形作家、さらに、政治＆スポーツ＆グルメから芸能まで、多彩な分野を広く浅く知る文筆系ラーメン屋をご紹介。</p>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a class="home-introduction-item" href="/fanletter" ><i class="fa fa-comment-o" aria-hidden="true"></i>
                    <h3 class="top-ten">Fan Letter</h4>
                    </a>
                    <p>ファンキー・ジャム所属の久保田利伸、浦嶋りんこ、森大輔、BROWN EYED SOULへのファンレターはこちらからお願いします。</p>
                </div>
            </div>
        </div>
    </div>
</div>




<div id="pageTop">
    <a class="topnav" href="menu">
        <i class="fa fa-angle-double-up" aria-hidden="true"></i>
    </a>
</div>





