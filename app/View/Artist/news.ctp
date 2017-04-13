
<!-- Header -->
<header class="text-center" name="home">
    <img class="other-banner" src="/img/artist-header-bg.jpg" alt="Funkyjam">
</header>


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
<div id="news-section">
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

    </div>
</div>

<!-- Artist Section -->
<div id="artist-section-top">
    <div class="container">
        <h2>Artist</h2>
            <div class="row">
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <article class="home-news-item sample5">
                    <a class="showf" href="/artist/kubota">
                    <img src="/img/portfolio/KubotaTop.jpg" class="img-responsive" alt="Toshinobu Kubota">
                    <div class="home-news-overlay blk-back f18">
                    <h3 class="en">Toshinobu Kubota</h3>
                        <div class="mask">
                        <h3 class="caption">久保田利伸</h3>
                        </div>
                    </div>
                    </a>
                    </article>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <article class="home-news-item sample5">
                    <a class="showf" href="/artist/urashima">
                    <img src="/img/portfolio/Urashima_Top.jpg" class="img-responsive" alt="Rinko Urashima">
                    <div class="home-news-overlay blk-back f18">
                    <h3 class="en">Rinko Urashima</h3>
                        <div class="mask">
                        <h3 class="caption">浦嶋りんこ</h3>
                        </div>
                    </div>
                    </a>
                    </article>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <article class="home-news-item sample5">
                    <a class="showf" href="/artist/mori">
                    <img src="/img/portfolio/MoriTop.jpg" class="img-responsive" alt="Daisuke Mori">
                    <div class="home-news-overlay blk-back f18">
                    <h3 class="en">Daisuke Mori</h3>
                        <div class="mask">
                        <h3 class="caption">森大輔</h3>
                        </div>
                    </div>
                    </a>
                    </article>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <article class="home-news-item sample5">
                    <a class="showf" href="/artist/bes">
                    <img src="/img/portfolio/BROWN-EYED-SOUL_Top.jpg" class="img-responsive" alt="BROWN EYED SOUL">
                    <div class="home-news-overlay blk-back f18">
                    <h3 class="en">BROWN EYED SOUL</h3>
                        <div class="mask">
                        <h3 class="caption">ブラウン・<br>アイド・ソウル</h3>
                        </div>
                    </div>
                    </a>
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
                    <a class="home-introduction-item" href="/magazine" ><i class="fa fa-envelope-o" aria-hidden="true"></i>
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