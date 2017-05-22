<!-- Company Section -->
<div id="company-page-section">
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
            <h1 class="artist-title2">ファンレター</h1>

                <article id="contentArea">
                    <div id="contentBox">
                        <p><span class="indispensability">*</span>は必ずお書きください。</p>
                        <form action="index.php" method="post">
                            <table class="table">
                                <tr>
                                    <th style="width: 166px;" >お名前<span class="indispensability">*</span></th>
                                    <td>
                                    <input type="text" name="form[name]" value="" style="width: 250px" />
                                    <p class="attn">記入例：久保田利伸</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>メールアドレス<span class="indispensability">*</span></th>
                                    <td>
                                    <input name="form[mail]" type="text" value="" style="width: 250px" />
                                    <p class="attn">半角英数字でご記入ください。</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>メールアドレス再確認<span class="indispensability">*</span></th>
                                    <td>
                                    <input name="form[mail2]" type="text" value="" style="width: 250px" />
                                    <p class="attn">確認のため再度ご記入ください。半角英数字でご記入ください。</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>宛先<span class="indispensability">*</span></th>
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
                                    <th>ファンレター内容<span class="indispensability">*</span></th>
                                    <td> 
                                        <textarea name="form[content]" cols="75" rows="15"  style="width:100%; height:150px;"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>メールマガジン<span class="indispensability">*</span></th>
                                    <td>
                                        <input name="form[magazine]" type="hidden" value="" />
                                        <label><input name="form[magazine]" type="checkbox" value="1" checked='checked' />&nbsp;メルマガを購読する</label><br />
                                        <p class="attn">ファンキー・ジャム所属アーティストの最新情報をお届けします。<br />不要な方はチェックをはずして下さい。</p>
                                    </td>
                                </tr>
                            </table>
                            <p class="btn"><input type="submit" value="内容を確認する" /></p>
                            <input type="hidden" name="action" value="confirm" />
                        </form>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>

