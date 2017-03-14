<section class="container cf">
	<header class="mb10">
		<span class="label label-gray"><?= $hotel_type[$data_hotel['type_id']] ?></span>
		<h1 class="ttl bg-gray pl10"><span itemprop="name"><?= $data_hotel['name'] ?></span>にデリヘルは呼べるか？</h1>
	</header>
	<table class="table table-brdr table-th-color table-rsp-thead-fl meta-info">
		<thead>
			<tr>
				<?php if ($data_hotel['address'] != ""): ?>
				<th>住所</th>
				<?php endif; ?>
				<?php if ($data_hotel['tel'] != ""): ?>
				<th>電話番号</th>
				<?php endif; ?>
				<?php if (!empty($data_stations)): ?>
				<th>最寄り駅</th>
				<?php endif; ?>
				<?php if ($data_hotel['square_meter'] != ""): ?>
				<th>平米数</th>
				<?php endif; ?>
				<?php if ($data_hotel['min_charge'] != ""): ?>
				<th>料金</th>
				<?php endif; ?>
				<?php if ($data_hotel['dayuse'] == "y"): ?>
				<th>デイユース</th>
				<?php endif; ?>
				<?php if ($data_hotel['url'] != "") {
					$url = parse_url($data_hotel['url']);
				?>
				<th>公式サイト</th>
				<?php
				}
				?>
			</tr>
		</thead>
		<tbody>
			<tr>
				<?php if ($data_hotel['address'] != ""): ?>
				<td><?= $data_hotel['address'] ?>&nbsp;
				<?php
				if(!$this->common->isSP()){
				?>
				<a href="https://maps.google.co.jp/maps?ll=<?= $data_hotel['lat'] ?>,<?= $data_hotel['lon'] ?>&q=<?= urlencode($data_hotel['name']) ?>&iwloc=A" target="_blank" rel="nofollow"><span class="i-location red"></span>地図</a>
				<?php
				}
				?>
				</td>
				<?php endif; ?>
				<?php if ($data_hotel['tel'] != ""): ?>
				<td><?= $data_hotel['tel'] ?></td>
				<?php endif; ?>
				<?php if (!empty($data_stations)): ?>
				<?php
				print '<td>';
				print '<ul>';
				foreach ($data_stations as $k => $v) {
					print '<li><a href="/' . $pref_meta['en'] . '/station/' . $k . '/">' . $v . '</a></li>';
				}
				print '</ul>';
				print '</td>';
				?>
				<?php endif; ?>
				<?php if ($data_hotel['square_meter'] != ""): ?>
				<td><?= $data_hotel['square_meter'] ?>m&sup2;〜</td>
				<?php endif; ?>
				<?php if ($data_hotel['min_charge'] != ""): ?>
				<td><?= number_format($data_hotel['min_charge']) ?>円〜</td>
				<?php endif; ?>
				<?php if ($data_hotel['dayuse'] == "y"): ?>
				<td>あり</td>
				<?php endif; ?>
				<?php if ($data_hotel['url'] != "") {
					$url = parse_url($data_hotel['url']);
				?>
				<td><a href="<?= $data_hotel['url'] ?>" target="_blank" rel="nofollow"><?= $url['host'] ?></a></td>
				<?php
				}
				?>
			</tr>
		</tbody>
	</table>
	<?php
	if ($this->common->isSP()){
	?>
	<div class="tac">
		<a href="https://maps.google.com/maps?saddr=%E7%8F%BE%E5%9C%A8%E5%9C%B0&daddr=<?= urlencode($data_hotel['address']) ?>&dirflg=w" class="ls-none"><i class="i-michijun-rectangle fs44"></i></a>
	</div>
	<?php
	}
	?>
</section>

<?php
if($data_shops_a){
?>
<section class="container">
	<h2 class="ttl mb10 bg-main-color white pl10"><?= $data_city['name'] ?>に派遣可能なおすすめデリヘル店</h2>
	<?php
	print view::element('part_shop_list_s');
	?>
</section>
<?php
}
?>

<div class="container">
	<h2 id="review" class="ttl pl10 bg-gray mb10"><?= $data_hotel['name'] ?>の口コミ</h2>
	<div class="cf review-box">
		<div class="fl">
			<h3 class="gray">このホテルを利用したユーザーの口コミ</h3>
			<?php
			if (!empty($data_reviews_user)) {
				print '<ul class="review-list mb20">';
				foreach ($data_reviews_user as $v) {
					$ru = $v['ReviewUser'];
					$iu = $v['IineUser'];
					$name = ($ru['name'] != "") ? $ru['name'] : ANONYMOUSE;
					?>
					<li itemscope itemtype="http://schema.org/LocalBusiness" class="entry-review cf">
						<div itemprop="review" itemscope itemtype="http://schema.org/Review">
							<?php
							if(!$this->common->isSP()){
							?>
							<figure itemprop="author" itemscope itemtype="http://schema.org/Person" class="avatar tac col span-2">
								<img src="/img/icon_nouser-big.gif" alt="<?= $ru['name'] ?>" class="face">
								<figcaption itemprop="name" class="fs12"><?= $name ?>さん</figcaption>
							</figure>
							<?php
							}
							?>
							<div class="col span-10">
								<header class="df">
									<div><?= $this->Common->getCallStatus($ru['call']) ?></div>
									<div class="ml5"><?= $this->Common->getReviewStarts($ru['star']) ?></div>
									<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="ml5 fs12">
										<span itemprop="bestRating">5</span>点中<span itemprop="ratingValue" class="red b"><?= $ru['star'] ?></span>点<span itemprop="worstRating" class="dn">1</span>
									</div>
								</header>
								<p itemprop="reviewBody" class="txt mb5 box-fkds is-left bg-gray-light box"><?= $ru['comment'] ?></p>
								<footer class="df flex-jc-between flex-evenness">
									<div class="fs12">
										<span class="i-thumb_up blue"></span>
										<a href="javascript:void(0);" id="btn<?= $ru['id'] ?>" onclick="iine(<?= $ru['id'] ?>, 'user'); return false;" autocomplete="off">参考になった</a>
										<?php
										if(!empty($iu)){
										?>
											<span id="cnt<?= $ru['id'] ?>" class="counter is-left"><?= count($iu) ?></span>
										<?php
										} else {
										?>
											<span id="cnt<?= $ru['id'] ?>" class="counter is-left bg-gray"><?= count($iu) ?></span>
										<?php
										}
										?>
									</div>
									<div class="date">利用日：<date itemprop="datePublished" content="<?= $this->Common->date4mat($ru['created'], 'Y/m/d') ?>" datetime="<?= $this->Common->date4mat($ru['created'], 'Y/m/d') ?>"><?= $this->Common->date4mat($ru['created'], 'Y/m/d') ?></date></div>
								</footer>
							</div>
						</div>
					</li>
					<?php
				}
				// if ($this->common->isSP()){
				// print '<div class="tac mt20">';
				// print '<a href="" class="ls-none"><i class="i-michijun-rectangle fs44"></i></a>';
				// print '</div>';
				// }
				print '</ul>';
			} else {
			?>
			<div class="entry-review no-entry cf">
				<figure class="avatar tac col span-2">
					<img src="/img/logo-icon.svg" alt="デリヘルOKロゴ">
				</figure>
				<div class="info col span-10">
					<p class="txt mb5 box-fkds is-left bg-gray-light box">口コミがまだ投稿されていません！<br>参考のために是非、情報提供をお願いします。</p>
				</div>
			</div>
			<?php
			}
			?>
			<h3 id="review-form-user">口コミ投稿フォーム</h3>
			<?= $this->Form->create('ReviewUser', array('novalidate' => true, 'name'=>'myForm', 'action'=>'post', 'url'=>$this->params->here . '#review-form-user')) ?>
			<?php
			print $this->Form->input('hotel_id', array(
				'type' => 'hidden',
				'value' => $data_hotel['id']
			));
			?>
			<table class="table table-brdr table-th-color mb0 table-w-fixed table-responsive-block">
				<tbody>
					<tr class="rr_form_row">
						<th class="w30p">ニックネーム</th>
						<td>
							<?php
							print $this->Form->input('name', array(
								'label' => false,
								'type' => 'text',
								'value' => $data['ReviewUser']['name'],
								'placeholder' => 'OK太郎',
								'class' => 'form-control'
							));
							?>
						</td>
					</tr>
					<tr>
						<th rowspan="2">評価<?= $this->common->getMust() ?></th>
						<td>
							<?php
							print $this->Form->radio('call', $call, array(
								'legend' => false,
								'value' => isset($data['ReviewUser']['call']) ? $data['ReviewUser']['call'] : 1,
							));
							?>
						</td>
					</tr>
					<tr>
						<td>
							<?php
							print $this->Form->input('star', array(
								'label' => false,
								'type' => 'select',
								'selected' => isset($data['ReviewUser']['star']) ? $data['ReviewUser']['star'] : 5,
								'options' => array(0 => "▼選択", "5段階評価" => $stars),
								'div' => false,
								'class' => 'form-control',
							));
							?>
						</td>
					</tr>

					<tr>
						<th>利用日</th>
						<td>
						<?= $this->Form->input('created', array(
							'label' => false,
							'type' => 'text',
							'value' => date('Y-m-d H:i:s'),
							'div' => false,
							'class' => 'form-control',
						));
						?>
						</td>
					</tr>
					<tr>
						<th>口コミ<?= $this->common->getMust() ?></th>
						<td>
							<?php
								print $this->Form->input('comment', array(
								'label' => false,
								'type' => 'textarea',
								'value' => $data['ReviewUser']['comment'],
								'class' => 'form-control',
								'placeholder' => '利用した際の状況を詳しくお書きください。',
							));
							?>
						</td>
					</tr>

				</tbody>
			</table>
			<div class="form-actions tac">
				<button class="btn" type="submit" onclick="allSelected()">書き込む</button>
			</div>
			<?= $this->Form->end() ?>
		</div>
		<div class="fr">
			<h3 class="gray"><?= $data_city['name'] ?>のホテルに出張可能なデリヘル店の口コミ</h3>
			<div class="entry-review no-entry cf">
				<figure class="avatar tac col span-2">
					<img src="/img/logo-icon.svg" alt="デリヘルOKロゴ">
				</figure>
				<div class="info col span-10">
					<p class="txt mb5 box-fkds is-left bg-gray-light box">お店だけが知っているホテル情報を投稿しませんか？<br><a href="/entry/">無料掲載審査</a>からお申し込みください。</p>
				</div>
			</div>
		</div>
	</div>
</div>

	<?php
	if($data_shops){
	?>
	<section class="container">
		<h2 class="ttl mb10 bg-main-color white pl10"><?= $data_city['name'] ?>に派遣可能なデリヘル店厳選30</h2>
		<?php
			print view::element('part_shop_list');
		?>
	</section>
	<?php
	}
	?>