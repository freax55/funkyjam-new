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
<div id="company-page-section">
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
            <h1 class="artist-title2">ファンレター</h1>

                <article id="contentArea">
                    <div id="contentBox">
                        <form action="index.php" method="post">
                            <table width=100% frame="box">
                                <tr>
                                    <td style="width: 200px;" >お名前</td>
                                    <td>
                                    <input type="text" name="form[name]" value="" style="width: 250px" />
                                    <p class="attn">記入例：久保田利伸</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>メールアドレス</td>
                                    <td>
                                    <input name="form[mail]" type="text" value="" style="width: 250px" />
                                    <p class="attn">半角英数字でご記入ください。</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>メールアドレス再確認</td>
                                    <td>
                                    <input name="form[mail2]" type="text" value="" style="width: 250px" />
                                    <p class="attn">確認のため再度ご記入ください。半角英数字でご記入ください。</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>宛先</td>
                                    <td>
                                        <ul class="clearfix">
                                        <li style="float: left; padding-right: 15px;" ><input name="form[to]" type="radio" value="kubota"  id="fromToArtist01" />&nbsp;<label style="float: none;" for="fromToArtist01">久保田利伸</label><br />
                                        <img src="img/portfolio/artist_01.jpg" alt="" /></li>
                                        <li style="float: left; padding-right: 15px;"><input name="form[to]" type="radio" value="urashima"  id="fromToArtist02" />&nbsp;<label for="fromToArtist02">浦嶋りんこ</label><br />
                                        <img src="img/portfolio/artist_02.jpg" alt="" /></li>
                                        <li style="float: left; padding-right: 15px;"><input name="form[to]" type="radio" value="mori"  id="fromToArtist03" />&nbsp;<label for="fromToArtist03">森大輔</label><br />
                                        <img src="img/portfolio/artist_03.jpg" alt="" /></li>
                                        <li style="float: left; padding-right: 15px;"><input name="form[to]" type="radio" value="bes"  id="fromToArtist04" />&nbsp;<label for="fromToArtist04">BROWN EYED SOUL</label><br />
                                        <img src="img/portfolio/artist_04.jpg" alt="" /></li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>ファンレター内容</td>
                                    <td> 
                                        <textarea name="form[content]" cols="75" rows="15"  style="width:100%; height:150px;"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>メールマガジン</td>
                                    <td>
                                        <input name="form[magazine]" type="hidden" value="" />
                                        <label><input name="form[magazine]" type="checkbox" value="1" checked='checked' />&nbsp;メルマガを購読する</label><br />
                                        <p class="attn">ファンキー・ジャム所属アーティストの最新情報をお届けします。<br />不要な方はチェックをはずして下さい。</p>
                                    </td>
                                </tr>
                            </table>
                            <input class="btn-fix" type="submit" value="内容を確認する" />
                            <input type="hidden" name="action" value="confirm" />
                        </form>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>

