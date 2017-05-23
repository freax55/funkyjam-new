
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


<div id="company-page-section">
    <div class="container"> 
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
            <h1 class="artist-title2">メールマガジン登録情報変更</h1>

                <article id="contentArea">
                <div id="contentBox">
                    <p>登録情報変更のお手続きについてメールをお送りいたします。<br />
                    <form action="index.php" method="post">
                        <table width=100% frame="box">
                            <tr>
                                <th style="width: 136px;">メールアドレス</th>
                                <td>
                                    <input name="form[mail]" type="text" style="width: 250px" value="" />
                                    <p class="attn">半角英数字でご記入ください。</p>
                                </td>
                            </tr>
                        </table>
                        <input class="btn-fix" type="submit" value="案内メールを送信" />
                        <input type="hidden" name="action" value="process" />
                    </form>
                </div>
                </article>
            </div>
        </div>
    </div>
</div>


