<header class="container mb30">
	<h1 class="mb10 ttl ttl-bb2"><?= $pages[$current]['title'] ?></h1>
	<p class="p15 bg-sub-color-light radius4"><strong><?= SITENAME ?></strong><span class="gray">（以下「当サイト」）</span>に広告掲載をお申込み頂くにあたりまして、当サイトへのリンクが<span class="red b">必須</span>となります。<br>
	リンクの貼り方に依って、<span class="red b">掲載方法に優劣</span>が付きますので、予め下記内容をご確認いただきましてリンクの設置をお願い致します。</p>
</header>
<div class="container mb50">
	<section class="mb50">
		<header class="df mb10 df-ai-center ttl ttl-bb2">
			<span class="i-star-full sub-color"></span>&nbsp;<h2>必須バナー</h2>
		</header>
		<p class="red mb10 p15">下記サイズいずれかのバナーリンク、もしくはテキストリンクは必須となります。</p>
		<div class="p15 bg-gray-light radius4">
			<section>
				<h3 class="fs30">468×60</h3>
				<div>
					<figure class="mw468">
						<img src="/img/kc-bnr-468-60.png" alt="468x60バナー">
					</figure>
					<p class="mt10">以下のHTMLソースをコピーしてHTMLファイルに貼り付けてください。</p>
					<textarea class="form-control">&lt;a href="https://kclub-rank.com" target="_blank"&gt;&lt;img src="https://cdn.kclub-rank.com/img/kc-bnr-468-60.png" alt="<?= SITENAME ?>" width="468" height="60" border="0"&gt;&lt;/a&gt;</textarea>
				</div>
			</section>
			<section>
				<h3 class="fs30 mt30">88×31</h3>
				<div>
					<figure class="mw88">
						<img src="/img/kc-bnr-88-31.png" alt="88x31バナー">
					</figure>
					<p class="mt10">以下のHTMLソースをコピーしてHTMLファイルに貼り付けてください。</p>
					<textarea class="form-control">&lt;a href="https://kclub-rank.com" target="_blank"&gt;&lt;img src="https://cdn.kclub-rank.com/img/kc-bnr-88-31.png" alt="<?= SITENAME ?>" width="88" height="31" border="0"&gt;&lt;/a&gt;</textarea>
				</div>
			</section>
			<section>
				<h3 class="fs30 mt30">テキストリンク</h3>
				<a href="https://kclub-rank.com">交際クラブランキング</a>
				<p class="mt10">以下のHTMLソースをコピーしてHTMLファイルに貼り付けてください。</p>
				<textarea class="form-control">&lt;a href="https://kclub-rank.com" target="_blank"&gt;交際クラブランキング&lt;/a&gt;</textarea>
			</section>
		</div>
	</section>
	<section class="mb50">
		<header class="df mb10 df-ai-center ttl ttl-bb2">
			<span class="i-star-full sub-color"></span>&nbsp;<h2>オプションバナー</h2>
		</header>
		<p class="mb10 p15">ライバルの交際クラブより<span class="red">目立つ掲載</span>をする為には、必須バナーの他に下記のオプションバナーを設置していただく必要があります。<br>リンクはトップページに設置していただかないと上位に表示されません。</p>
		<div class="p15 bg-sub-color-light radius4 arrow-bottom is-sub-color-light">
			<ol class="fs20">
				<li><span class="fs20">1</span>.&nbsp;クラブの所在地の都道府県を選択を選択してください。</li>
				<li><span class="fs20">2</span>.&nbsp;表示されたバナー、もしくはテキストリンクからお好きなタイプのHTMLソースをコピーしてください。</li>
				<li><span class="fs20">3</span>.&nbsp;コピーしたソースコードをクラブのトップページに貼り付けてください。</li>
			</ol>
			<select class="select-pref" name="pref">
				<optgroup label="東北">
					<option value="1">北海道</option>
					<option value="2">青森県</option>
					<option value="3">岩手県</option>
					<option value="4">宮城県</option>
					<option value="5">秋田県</option>
					<option value="6">山形県</option>
					<option value="7">福島県</option>
				</optgroup>
				<optgroup label="関東">
					<option value="13" selected>東京都</option>
					<option value="14">神奈川県</option>
					<option value="11">埼玉県</option>
					<option value="12">千葉県</option>
					<option value="8">茨城県</option>
					<option value="9">栃木県</option>
					<option value="10">群馬県</option>
				</optgroup>
				<optgroup label="中部">
					<option value="15">新潟県</option>
					<option value="16">富山県</option>
					<option value="17">石川県</option>
					<option value="18">福井県</option>
					<option value="19">山梨県</option>
					<option value="20">長野県</option>
					<option value="21">岐阜県</option>
					<option value="22">静岡県</option>
					<option value="23">愛知県</option>
				</optgroup>
				<optgroup label="近畿">
					<option value="27">大阪府</option>
					<option value="26">京都府</option>
					<option value="25">滋賀県</option>
					<option value="24">三重県</option>
					<option value="28">兵庫県</option>
					<option value="29">奈良県</option>
					<option value="30">和歌山県</option>
				</optgroup>
				<optgroup label="中国">
					<option value="31">鳥取県</option>
					<option value="32">島根県</option>
					<option value="33">岡山県</option>
					<option value="34">広島県</option>
					<option value="35">山口県</option>
				</optgroup>
				<optgroup label="四国">
					<option value="36">徳島県</option>
					<option value="37">香川県</option>
					<option value="38">愛媛県</option>
					<option value="39">高知県</option>
				</optgroup>
				<optgroup label="九州">
					<option value="40">福岡県</option>
					<option value="41">佐賀県</option>
					<option value="42">長崎県</option>
					<option value="43">熊本県</option>
					<option value="44">大分県</option>
					<option value="45">宮崎県</option>
					<option value="46">鹿児島県</option>
					<option value="47">沖縄県</option>
				</optgroup>
			</select>
		</div>
	</section>
	<section class="bnr-change p15 bg-sub-color-light mb30">
		<header>
			<h2>バナーサイズ一覧</h2>
			<p>下記バナーサイズ一覧からお好きなバナーのソースコードをコピーして、ご自身のホームページに設置してご利用ください。</p>
		</header>
		<section>
			<h3 class="fs30 mt30">468×60</h3>
			<div>
				<figure class="mw468">
					<img src="/img/kc-bnr-468-60.png" alt="468-60バナー">
				</figure>
				<p class="mt10">以下のHTMLソースをコピーしてHTMLファイルに貼り付けてください。</p>
				<textarea class="form-control">&lt;a href="https://kclub-rank.com/tokyo/" target="_blank"&gt;&lt;img src="https://cdn.kclub-rank.com/img/banner/468-60.png" alt="東京<?= SITENAME ?>" width="468" height="60" border="0"&gt;&lt;/a&gt;</textarea>
			</div>
		</section>
		<section>
			<h3 class="fs30 mt30">88×31</h3>
			<div>
				<figure class="mw88">
					<img src="/img/kc-bnr-88-31.png" alt="88-31バナー">
				</figure>
				<p class="mt10">以下のHTMLソースをコピーしてHTMLファイルに貼り付けてください。</p>
				<textarea class="form-control">&lt;a href="https://kclub-rank.com/tokyo/" target="_blank"&gt;&lt;img src="https://cdn.kclub-rank.com/img/banner/88-31.png" alt="東京<?= SITENAME ?>" width="88" height="31" border="0"&gt;&lt;/a&gt;</textarea>
			</div>
		</section>
		<section>
			<h3 class="fs30 mt30">テキストリンク</h3>
			<a href="https://kclub-rank.com">東京交際クラブランキング</a>
			<p class="mt10">以下のHTMLソースをコピーしてHTMLファイルに貼り付けてください。</p>
			<textarea class="form-control">&lt;a href="https://kclub-rank.com/tokyo/" target="_blank"&gt;東京交際クラブランキング&lt;/a&gt;</textarea>
		</section>
	</section>
	<div class="tac">
		<a href="/inquiry/" class="btn btn-large btn-blue"><span class="i-envelope"></span>&nbsp;お気軽にお問い合わせください</a>
	</div>
</div>
