<?php
$artist = 'kubota';
?>


<!-- Header -->
<header class="text-center" name="home">
    <img class="other-banner" src="/img/artist-header-bg.jpg" alt="Funkyjam">
</header>


<div id="breadcrumb">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Toshinobu Kubota</a></li>
					<li class="active">News</li>
				</ol>
			</div>


<?= view::element('part_artist_nav') ?>


				<div id="news-section">
				    <div class="row">
						<div class="col-xs-12">
							<p>2017.04.07</p>

							<h1>久保田利伸 2017年夏フェス出演情報</h1>

							<p>SPACE SHOWER SWEET LOVE SHOWER 2017 出演決定！！</p>

							<p>7年振りとなる夏フェスへの出演が決定しました！</p>

							<li>◆日程：8/25（金）、8/26（土）、8/27（日）</li>
							<li>◆時間：開場9:00 / 開演10:30 （予定）</li>
							<li>◆場所：山梨県 山中湖交流プラザ きらら</li>
							<li>山梨県南都留郡山中湖村 平野479-2</li>
							<li>◆チケット：3日通し券28,000円(税込) </li>
							<li>2日通し券 各19,000円(税込)「8/25・26券」「8/26・27券」 </li>
							<li>1日券 各10,000円(税込) 「8/25券」「8/26券」「8/27券」</li><br>
							<p>オフィシャルサイト：<a href='https://www.sweetloveshower.com/' target="_blank">www.sweetloveshower.com</a></p>
							<li>お問い合わせ：DISK GARAGE 050-5533-0888(平日12:00〜19:00)</li>
							<li>※0180-99-3875（24時間自動音声受付）</li>
							<br>
							<p>どうぞお楽しみに！</p>
						</div>
					</div>
				</div>
			</div>


<?= view::element('part_side_artist') ?>

<?= view::element('part_artist_news') ?>


