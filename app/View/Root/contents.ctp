
<!-- Header -->
<header class="text-center" name="home">
    <img class="other-banner" src="/img/company-header-bg.jpg" alt="Funkyjam">
</header>

<div id="breadcrumb">
	<div class="container">
        <div class="row">
    		<div class="col-md-8 col-md-offset-2 leftzero">
    		<?= $this->BreadCrumb->show($path) ?>
    		</div>
        </div>
	</div>
</div>


<!-- Company Section -->
<?php
print $content['Post']['post_content'];
/*
?>

<div id="company-page-section">
    <div class="container"> 
         <div class="col-md-8 col-md-offset-2 leftzero">
            <h1 class="menu">会社概要</h1>
                <div class="row rowzero">
                    <table width=100% frame="box">
                    <tr>
                    <td>社名</td>
                    <td>株式会社ファンキー・ジャム</td>
                    <tr>
                        <td>所在地</td> 
                        <td>東京都港区西麻布1丁目14番2号疋田ビル302号</td> 
                        <tr>
                            <td>設立</td>  
                            <td>1992年11月10日</td>
                            <tr>
                                <td>連絡先</td> 
                                <td>TEL：03-3470-7707 FAX：03-3470-7708</td>
                                <tr>
                                    <td>事業内容</td>  
                                    <td>1.音楽、映像の原盤企画・制作及び販売<br>
                                        2.アーティスト、ミュージシャンのマネージメント全般<br>
                                        3.コンサートの企画、制作<br>
                                        4.音楽著作権の管理<br>
                                        5.アーティストグッズの販売<br>
                                        6.ファンクラブ経営<br>
                                        7.レンタルスタジオ運営・管理</td>
                                    </tr>
                                </table>
                                <br>
                                <br>
                                <div class="ggmap"><iframe width=100% src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3241.632080542986!2d139.72136595051725!3d35.66143533856816!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188b7aef836267%3A0xd4ae338b0064cf1a!2z77yI5qCq77yJ44OV44Kh44Oz44Kt44O844K444Oj44Og!5e0!3m2!1sja!2sjp!4v1487758304811" frameborder="0" style="border:0" allowfullscreen></iframe></div>


                            </div>
                        </div>
                    </div>
                </div>

<?php
*/
?>



<!-- Artist Section -->
<div id="artist-section-top">
    <div class="container">
        <h2>Artist</h2>
            <div class="row">
                <div class="col-sm-6 col-md-3 col-lg-3 web">
                    <article class="portfolio-item">
                        <div class="hover-bg">
                            <a href="http://funkyjam.dev/artist/kubota">
                            <div class="hover-text">
                                <h4>Toshinobu Kubota</h4>
                                <small>久保田利伸</small>
                            <div class="clearfix">
                            </div>
                            </div>
                            <img src="img/portfolio/KubotaTop.jpg" class="img-responsive" alt="Toshinobu Kubota"></a> 
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 web">
                    <article class="portfolio-item">
                        <div class="hover-bg"> 
                            <a href="http://funkyjam.dev/artist/urashima">
                                <div class="hover-text">
                                <h4>Rinko Urashima</h4>
                                <small>浦嶋りんこ</small>
                            <div class="clearfix">
                            </div>
                            </div>
                            <img src="img/portfolio/Urashima_Top.jpg" class="img-responsive" alt="Rinko Urashima"></a> 
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 web">
                    <article class="portfolio-item">
                        <div class="hover-bg"> 
                            <a href="http://funkyjam.dev/artist/mori">
                                <div class="hover-text">
                                <h4>Daisuke Mori</h4>
                                <small>森大輔</small>
                            <div class="clearfix">
                            </div>
                            </div>
                            <img src="img/portfolio/MoriTop.jpg" class="img-responsive" alt="Daisuke Mori"></a> 
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 web">
                    <article class="portfolio-item">
                        <div class="hover-bg"> 
                            <a href="http://funkyjam.dev/artist/bes">
                                <div class="hover-text">
                                <h4>BROWN EYED SOUL</h4>
                                <small>ブラウン・アイド・ソウル</small>
                            <div class="clearfix">
                            </div>
                            </div>
                            <img src="img/portfolio/BROWN-EYED-SOUL_Top.jpg" class="img-responsive" alt="BROWN EYED SOUL"> </a> 
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
    <a style="padding-top: 8px; padding-left: 0px;" href="menu">
    <i class="fa fa-angle-double-up" aria-hidden="true"></i>
    </a>
</div>
