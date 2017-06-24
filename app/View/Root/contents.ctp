
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


