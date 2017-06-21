<!-- News Section -->
<div id="news-section-top">
    <div class="container">
        <h2>News</h2>
        <div class="row bottomsixty">
            <section>
			<?php
			foreach($news_list as $k => $v) {
			?>
				<div class="col-sm-6 col-md-3 col-lg-3">
					<article class="home-news-item">
						<?php
						if($this->common->checkWithinWeek($v['Post']['post_date'], 7)) {
							print '<span class="bg-red p3-5 white blink blink-left box-shadow">NEW</span>';
						}
						?>
						<a href="/artist/<?= $current ?>/news/<?= ($k==0)?'':('page:' . ($k+1) . '/') ?>">
							<img src="<?= (isset($v['Postmeta']['Post']))?$v['Postmeta']['Post']['guid']:'/img/portfolio/no-image.jpg' ?>" alt="" class="img-responsive news-sam" />   
							<div class="home-news-overlay blk-back">
							<h3><?= $v['Post']['post_title'] ?></h3>
							</div>
						</a>
					</article>
				</div>

			<?php
			}
			?>
            </section>  
        </div>
    </div>
</div>