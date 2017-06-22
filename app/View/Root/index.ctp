
<!-- Header -->
<script>
 $( document ).ready(function( $ ) {
  $('#thumb-h').sliderPro({
    width:1140,//横幅
    height: 420,
    buttons: false,//ナビゲーションボタン
    shuffle: true,//スライドのシャッフル
    thumbnailWidth: 225,//サムネイルの横幅
    thumbnailHeight: 80,//サムネイルの縦幅
    slideDistance:0,//スライド同士の距離
    breakpoints: {
      480: {//表示方法を変えるサイズ
    thumbnailWidth: 110,
    thumbnailHeight: 40
      }
    }
  });
});
</script>

<div id="slider-section-top">
    <header class="text-center" name="home">
        <div id="thumb-h" class="slider-pro">
            <div class="sp-slides">
                <div class="sp-slide">
                <a href="artist/kubota">
                <img class="sp-image" src="/img/portfolio/header-bg.jpg" /></a>
                </div>
                <div class="sp-slide">
                <a href="artist/kubota">
                <img class="sp-image" src="/img/portfolio/header-bg2.jpg" /></a>
                </div>
                <div class="sp-slide">
                <a href="artist/kubota">
                <img class="sp-image" src="/img/portfolio/header-bg3.jpg" /></a>
                </div>
                <div class="sp-slide">
                <a href="artist/kubota">
                <img class="sp-image" src="/img/portfolio/header-bg4.jpg" /></a>
                </div>
                <div class="sp-slide">
                <a href="artist/kubota">
                <img class="sp-image" src="/img/portfolio/header-bg5.jpg" /></a>
                </div>
            </div>
            <div class="sp-thumbnails">
                <img class="sp-thumbnail" src="/img/portfolio/header-bg.jpg"/>
                <img class="sp-thumbnail" src="/img/portfolio/header-bg2.jpg"/>
                <img class="sp-thumbnail" src="/img/portfolio/header-bg3.jpg"/>
                <img class="sp-thumbnail" src="/img/portfolio/header-bg4.jpg"/>
                <img class="sp-thumbnail" src="/img/portfolio/header-bg5.jpg"/>
            </div>
        </div>
    </header>
</div>

<!-- Artist Section -->

<?= view::element('part_artist_menu') ?>

<!-- News Section -->
<div id="news-section-top">
    <div class="container">
        <h2>News</h2>
        <div class="row">
            <section>
            <?php
            $i = 0;
            foreach($news_list as $v) {
                if($i>11){
                    break;
                }
            ?>
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <article class="home-news-item">
                        <?php
                        if($this->common->checkWithinWeek($v['Post']['post_date'], 7)) {
                            print '<span class="bg-red p3-5 white blink blink-left box-shadow">NEW</span>';
                        }
                        ?>
                        <a href="/artist/<?= $v['Post']['aritist_name'] ?>/news/<?= ($v['Post']['order']==1)?'':('page:' . ($v['Post']['order']) . '/') ?>">
                            <img src="<?= (isset($v['Postmeta']['Post']))?$v['Postmeta']['Post']['guid']:'/img/portfolio/no-image.jpg' ?>" alt="" class="img-responsive" />   
                            <div class="home-news-overlay blk-back">
                            <h3><?= $v['Post']['post_title'] ?></h3>
                            </div>
                        </a>
                    </article>
                </div>
            <?php
            $i++;
            }
            ?>
            </section>  
        </div>
    </div>
</div>

<!-- SNS Section -->
<div id="SNS-section">
    <div class="container"> 
        <div class="section-title">
            <h2>Facebook & Fanclub</h2>
            <div class="row">
                <div class="col-xs-6 col-md-3 col-lg-3 leftbar">
                    <div class="portfolio-item">
                    <a href="https://www.facebook.com/toshinobukubota" target="_blank" >
                    <img src="/img/portfolio/TKFacebook.png" class="img-responsive" alt="Toshinobu Kubota Facebook"> 
                    </a> 
                    </div>
                </div>
                <div class="col-xs-6 col-md-3 col-lg-3 rightbar">
                    <div class="portfolio-item">
                    <a href="https://www.facebook.com/urashimarinko" target="_blank" >
                    <img src="/img/portfolio/RUFacebook.png" class="img-responsive" alt="Rinko Urashima Facebook"> 
                    </a> 
                    </div>
                </div>
                <div class="col-xs-6 col-md-3 col-lg-3 leftbar">
                    <div class="portfolio-item">
                    <a href="https://www.facebook.com/moridaisukeofficial" target="_blank" >
                    <img src="/img/portfolio/DMFacebook.png" class="img-responsive" alt="Daisuke Mori Facebook"> 
                    </a> 
                    </div>
                </div>
                <div class="col-xs-6 col-md-3 col-lg-3 rightbar">
                    <div class="portfolio-item">
                    <a href="https://www.facebook.com/BESofficial" target="_blank" >
                    <img src="/img/portfolio/BESFacebook.png" class="img-responsive" alt="BSE Facebook"> 
                    </a> 
                    </div>
                </div>
            </div>
            <div class="row banner-pad">
                <div class="col-sm-6 col-md-6 col-lg-6 portfolio-item">
                    <a href="/artist/kubota/fanclub.html">
                    <img src="/img/portfolio/Baribari-top.jpg" class="img-responsive" alt="Bari Bari Crew"> </a> 
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 portfolio-item">
                    <a href="/mori/">
                    <img src="/img/portfolio/morinobanner.jpg" class="img-responsive" alt="Mori no Nakama"> </a> 
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Banner Section -->
<div id="bar-section">
    <div class="container">
        <div class="section-title topthirty">
            <h2>Official Contents</h2>
            <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-4 portfolio-item">
                    <a href="/shop">
                    <img src="/img/portfolio/FJ-Banner.jpg" class="img-responsive" alt="FJ Shop"> </a> 
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 portfolio-item">
                    <a href="/studio">
                    <img src="/img/portfolio/studio-top.jpg" class="img-responsive" alt="Studio"></a> 
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 portfolio-item">
                    <a href="http://cooljapanmusic.com/jammin/">
                    <img src="/img/portfolio/Jammin.jpg" class="img-responsive" alt="Studio"> </a> 
                </div>
            </div>
            <div class="row banner-pad">
                <div class="col-sm-4 col-md-4 col-lg-4 portfolio-item">
                    <a href="https://twitter.com/funky_manager">
                    <img src="/img/portfolio/Twitter-Banner.png" class="img-responsive" alt="Twitter"> </a> 
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 portfolio-item">
                    <a href="/art">
                    <img src="/img/portfolio/Art-Banner.png" class="img-responsive" alt="Art"> </a> 
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 portfolio-item">
                    <a href="/premium/">
                    <img src="/img/portfolio/Premium-Banner.jpg" class="img-responsive" alt="FJ Premium"> </a> 
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Introduction Section -->
<?= view::element('part_introduction') ?>
