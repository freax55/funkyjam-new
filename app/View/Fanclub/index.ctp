
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
            <h1 class="artist-title2">久保田利伸ファンクラブ登録</h1>

            <!-- ここからcontentエリア -->
            <article id="contentArea">
                <div id="contentBox">
                    <form action="index.php" method="post">
                    <p>久保田利伸ファンクラブBARI BARI CREWにご興味お持ちいただき、ありがとうございます。<br>
                    以下必要事項にご記入の上、「送信内容を確認する」ボタンを押してください。<br>
                    *は必ずお書きください。</p>

                    <form action="index.php" method="post">
                        <table width=100% frame="box">
                            <tr>
                                <td style="width: 150px;">お名前 *
                                </td>
                                <td><input type="text" name="form[name]" value="" class="w300" />
                                </td>
                                </tr>
                                <tr>
                                <td>お名前カナ *
                                </td>
                                <td><input type="text" name="form[kana]" value="" class="w300" />
                                </td>
                            </tr>
                            <tr>
                                <td>ご住所 *
                                </td>
                            <td>
                                <input type="text" name="form[zip1]" value="" style="width: 50px;"/>&nbsp;-&nbsp;<input type="text" name="form[zip2]" value="" style="width: 92px;"/>
                                <p class="attn">半角英数字でご記入ください。</p>
                                <select name="form[pref]">
                                <option value="">都道府県を選んでください</option>
                                    <option >北海道</option>
                                    <option >青森県</option>
                                    <option >岩手県</option>
                                    <option >宮城県</option>
                                    <option >秋田県</option>
                                    <option >山形県</option>
                                    <option >福島県</option>
                                    <option >茨城県</option>
                                    <option >栃木県</option>
                                    <option >群馬県</option>
                                    <option >埼玉県</option>
                                    <option >千葉県</option>
                                    <option >東京都</option>
                                    <option >神奈川県</option>
                                    <option >新潟県</option>
                                    <option >富山県</option>
                                    <option >石川県</option>
                                    <option >福井県</option>
                                    <option >山梨県</option>
                                    <option >長野県</option>
                                    <option >岐阜県</option>
                                    <option >静岡県</option>
                                    <option >愛知県</option>
                                    <option >三重県</option>
                                    <option >滋賀県</option>
                                    <option >京都府</option>
                                    <option >大阪府</option>
                                    <option >兵庫県</option>
                                    <option >奈良県</option>
                                    <option >和歌山県</option>
                                    <option >鳥取県</option>
                                    <option >島根県</option>
                                    <option >岡山県</option>
                                    <option >広島県</option>
                                    <option >山口県</option>
                                    <option >徳島県</option>
                                    <option >香川県</option>
                                    <option >愛媛県</option>
                                    <option >高知県</option>
                                    <option >福岡県</option>
                                    <option >佐賀県</option>
                                    <option >長崎県</option>
                                    <option >熊本県</option>
                                    <option >大分県</option>
                                    <option >宮崎県</option>
                                    <option >鹿児島県</option>
                                    <option >沖縄県</option>
                                </select><br />
                                    <div class="detail" style="padding-top: 15px;">
                                    <input type="text" name="form[address1]" value="" style="width: 80%;" />
                                    <p class="attn">記入例：港区西麻布</p>
                                    <input type="text" name="form[address2]" value="" style="width: 80%;" />
                                    <p class="attn">記入例：1丁目14番2号疋田ビル302号</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>お電話番号 *
                            </td>
                            <td>
                            <input name="form[tel_1]" type="text" value="" maxlength="4" style="width: 60px;" />&nbsp;-&nbsp;<input name="form[tel_2]" type="text" value="" maxlength="4" style="width: 70px;" />&nbsp;-&nbsp;<input name="form[tel_3]" type="text" value="" maxlength="4" style="width: 70px;" />
                            <p class="attn">日中連絡が取れる番号をお願いします。</p>
                            </td>
                        </tr>
                        <tr>
                            <td>メールアドレス *
                            </td>
                            <td>
                            <input name="form[mail]" type="text" value="" style="width: 280px;" />
                            <p class="attn">半角英数字でご記入ください。<br>
                            メールが届かない場合はバリバリクルーまでお問い合わせください。</p>
                            </td>
                        </tr>
                        <tr>
                            <td>メールアドレス再確認 *</td>
                            <td>
                            <input name="form[mail2]" type="text" value="" style="width: 280px;" />
                            <p class="attn">確認のため再度ご記入ください。半角英数字でご記入ください。</p>
                            </td>
                        </tr>
                        <tr>
                            <td>性別 *</td>
                            <td>
                            <span><input name="form[sex]" type="radio" value="男性" />&nbsp;男性</span><span><input name="form[sex]" type="radio" value="女性"  />&nbsp;女性</span>
                            </td>
                        </tr>
                        <tr>
                            <td>生年月日 *</td>
                            <td>
                            <span>西暦&nbsp;<input type="text" maxlength="4" name="form[birth_year]" value="" style="width: 50px;" />&nbsp;年</span>
                            <span><select name="form[birth_month]">
                                <option value="">▼</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>&nbsp;月</span>
                            <span><select name="form[birth_day]">
                                <option value="">▼</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                            </select>&nbsp;日</span>
                            <p class="attn">半角英数字でご記入ください。</p>
                            </td>
                        </tr>
                        <tr>
                            <td>会員番号</td>
                            <td>
                            <strong>※既存会員の方は会員番号をお願いします。</strong><br />
                            No.&nbsp;<input name="form[member_no]" maxlength="8" type="text" value="" />
                            <p class="attn">半角数字でご記入ください。(8桁)</p>
                            </td>
                        </tr>
                        <tr>
                            <td>Bari Bari Crewを<br>
                            どこでお知りになりましたか？ *</td>
                            <td>
                                <input name="form[know]" type="radio" value="ファンキージャムホームページ" />&nbsp;ファンキー・ジャムホームページ<br />
                                <input name="form[know]" type="radio" value="友人、知人" />&nbsp;友人、知人<br />
                                <input name="form[know]" type="radio" value="OMC" />&nbsp;OMC<br />
                                <input name="form[know]" type="radio" value="雑誌" />&nbsp;雑誌<br />
                                <input name="form[know]" type="radio" value="その他" />&nbsp;その他<br />
                            </td>
                        </tr>
                        <tr>
                            <td>ご希望の申込み書類 *</td>
                            <td>
                            <input name="form[doc]" type="radio" value="Bari Bari Crew CARD （クレジット機能付き）入会案内書" />&nbsp;Bari Bari Crew CARD&nbsp;（クレジット機能付き）入会案内書<br />
                            <input name="form[doc]" type="radio" value="郵便振込入会案内書" />&nbsp;郵便振込入会案内書<br />
                            <input name="form[doc]" type="radio" value="両方" />&nbsp;両方<br />
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
            </div>
        <div id="bottomBorder"></div>
        </article>
        </div>
    </div>
</div>
