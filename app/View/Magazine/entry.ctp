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
            <h1 class="artist-title2">メールマガジン登録</h1>

                <article id="contentArea">
                    <div id="contentBox">
                        <p class="attn">*は必ずお書きください。</p>
                        <form action="index.php" method="post">
                            <table width=100% frame="box">
                                <tr>
                                    <td style="width: 150px;">メールアドレス *</td>
                                    <td>
                                        <input name="form[mail]" style="width: 200px" type="text" value="" class="w420" />
                                        <p class="attn">半角英数字でご記入ください。</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>メールアドレス再確認 *</td>
                                    <td>
                                    <input name="form[mail2]" style="width: 200px" type="text" value="" class="w420" />
                                    <p class="attn">確認のため再度ご記入ください。</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>性別 *</td>
                                    <td>
                                    <input type="radio" name="form[sex]" value="男性" id="formSexMale" /><label style="float: none;" for="formSexMale">男性</label>
                                    <input type="radio" name="form[sex]" value="女性" id="formSexFemale" /><label style="float: none;" for="formSexFemale">女性</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>生年月日 *</td>
                                    <td>
                                    西暦<input name="form[birthday_year]" style="width: 80px" type="text" value="" >年
                                    <input name="form[birthday_month]" style="width: 50px" type="text" value="" >月
                                    <input name="form[birthday_day]" style="width: 50px" type="text" value="" />日
                                    </td>
                                </tr>
                                <tr>
                                    <td>都道府県 *</td>
                                    <td>
                                        <select name="form[pref]">
                                        <option value="北海道">北海道</option>

                                        <option value="青森県">青森県</option>
                                        <option value="岩手県">岩手県</option>
                                        <option value="宮城県">宮城県</option>
                                        <option value="秋田県">秋田県</option>
                                        <option value="山形県">山形県</option>
                                        <option value="福島県">福島県</option>

                                        <option value="茨城県">茨城県</option>
                                        <option value="栃木県">栃木県</option>
                                        <option value="群馬県">群馬県</option>
                                        <option value="埼玉県">埼玉県</option>
                                        <option value="千葉県">千葉県</option>
                                        <option value="東京都">東京都</option>
                                        <option value="神奈川県">神奈川県</option>

                                        <option value="新潟県">新潟県</option>
                                        <option value="富山県">富山県</option>
                                        <option value="石川県">石川県</option>
                                        <option value="福井県">福井県</option>
                                        <option value="山梨県">山梨県</option>
                                        <option value="長野県">長野県</option>

                                        <option value="岐阜県">岐阜県</option>
                                        <option value="静岡県">静岡県</option>
                                        <option value="愛知県">愛知県</option>
                                        <option value="三重県">三重県</option>

                                        <option value="滋賀県">滋賀県</option>
                                        <option value="京都府">京都府</option>
                                        <option value="大阪府">大阪府</option>
                                        <option value="兵庫県">兵庫県</option>
                                        <option value="奈良県">奈良県</option>
                                        <option value="和歌山県">和歌山県</option>

                                        <option value="鳥取県">鳥取県</option>
                                        <option value="島根県">島根県</option>
                                        <option value="岡山県">岡山県</option>
                                        <option value="広島県">広島県</option>
                                        <option value="山口県">山口県</option>

                                        <option value="徳島県">徳島県</option>
                                        <option value="香川県">香川県</option>
                                        <option value="愛媛県">愛媛県</option>
                                        <option value="高知県">高知県</option>

                                        <option value="福岡県">福岡県</option>
                                        <option value="佐賀県">佐賀県</option>
                                        <option value="長崎県">長崎県</option>
                                        <option value="熊本県">熊本県</option>
                                        <option value="大分県">大分県</option>
                                        <option value="宮崎県">宮崎県</option>
                                        <option value="鹿児島県">鹿児島県</option>
                                        <option value="沖縄県">沖縄県</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>気になっているアーティスト *</td>
                                    <td>
                                        <input type="hidden" name="form[fav_kubota]" value="" />
                                        <input type="checkbox" name="form[fav_kubota]" value="久保田利伸" id="formKubota" /><label style="float: none;" for="formKubota">久保田利伸</label>
                                        <input type="hidden" name="form[fav_urashima]" value="" />
                                        <input type="checkbox" name="form[fav_urashima]" value="浦嶋りんこ" id="formUrashima" /><label style="float: none;" for="formUrashima">浦嶋りんこ</label>
                                        <input type="hidden" name="form[fav_mori]" value="" />
                                        <input type="checkbox" name="form[fav_mori]" value="森大輔" id="formMori" /><label style="float: none;" for="formMori">森大輔</label>
                                        <input type="hidden" name="form[fav_bes]" value="" />
                                        <input type="checkbox" name="form[fav_bes]" value="BROWN EYED SOUL" id="formBes" /><label style="float: none;" for="formBes">BROWN EYED SOUL</label>
                                        <br />
                                        <input type="hidden" name="form[fav_shigemoto]" value="" />
                                        <input type="checkbox" name="form[fav_shigemoto]" value="茂本ヒデキチ" id="formShigemoto" /><label style="float: none;" for="formShigemoto">茂本ヒデキチ</label>
                                        <input type="hidden" name="form[fav_shima]" value="" />
                                        <input type="checkbox" name="form[fav_shima]" value="島かおり" id="formShima" /><label style="float: none;" for="formShima">島かおり</label>
                                        <input type="hidden" name="form[fav_wataru]" value="" />
                                        <input type="checkbox" name="form[fav_wataru]" value="ワタル" id="formWataru" /><label style="float: none;" for="formWataru">ワタル</label>
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


