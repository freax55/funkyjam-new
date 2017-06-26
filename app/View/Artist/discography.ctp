<!-- Header -->
<header class="text-center" name="home">
	<img class="other-banner" src="/img/artist-header-bg-<?= $current ?>.jpg" alt="Funkyjam">
</header>


<div id="breadcrumb">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
			<?= $this->BreadCrumb->show($path) ?>
			</div>
		
			<?= view::element('part_artist_nav') ?>

			<div id="discography-page-section">
				<p class="artist-tit">Discography</p>
			</div>
			<?php
			// links in this page
			$disctypes  = $this->common->get_disc_types($current);
			print '<ol class="breadcrumb discocenter">';
			foreach($disctypes[$current] as $k => $v) {
				print '<li class="clearfix2"><a href="#' . $k . '">'. $v .'</a></li>';
			}
			print '</ol>';
			?>

			<?php
			foreach ($disctypes[$current] as $k => $v) {
				print '<p class="DiscographyTitle2 line" id="' . $k . '">' . $v . '</p>';
                $d = $data_discs[$k];
				foreach($d as $v1) {
					$v1 = $v1['Discography'];
					if(!empty($v1['img'])){
                        print '<div class="row topthirty">';
						print '<div class="col-sm-3 release">';
						print '<img src="/img/portfolio/' . $v1['img'] . '" alt="">';
						print '</div>';
					}
					$release = null;
					print '<div class="col-sm-9">';
					if(!empty($v1['label'])) {
						print '<p class="mfive">' . $v1['label'] . '</p>';
					}
					print '<p class="DiscographyTitle" id="' . $v1['old_id'] . '">' . $v1['title'] . '</p>';
					if(!empty(json_decode($v1['release_multi']))){
						$release = implode("\n", json_decode($v1['release_multi'], true));
						print '<p class="release">' . $release . '</p>';
					}
					if(!empty(json_decode($v1['tracks']))) {
						$tracks = json_decode($v1['tracks'], true);
						$tracks_string = '';
						foreach($tracks as $kt => $vt) {
							if($vt['tag'] == 'li'){
								if($kt == 0){
									$tracks_string .= '<ol>' . "\n";//print '<ol>';
								} else {
									if($tracks[($kt-1)]['tag'] != 'li'){
										$tracks_string .= '<ol>' . "\n";//print '<ol>';
									}	
								}
							}
							$class = ($vt['tag'] == 'p')?'class="bold mfive"':null;
							$tracks_string .= $this->common->get_code_tracklist($vt['tt'], $vt['tag'], $class) . "\n";//print $this->common->get_code_tracklist($vt['tt'], $vt['tag'], $class);

							if(isset($tracks[$kt+1])){
								if($tracks[$kt+1]['tag'] != 'li'){
									$tracks_string .= '</ol>' . "\n";//print '</ol>';
								}
							}
						}
						if($vt['tag'] == 'li'){
							$tracks_string .= '</ol>' . "\n";//print '</ol>';
						}
						print $tracks_string;
					}
					if(!empty(json_decode($v1['link']))){
						print '<ul class="disco-topten">';
						$this->common->get_code_links($v1['link']);
						print '</ul>';
					}
					print '</div></div>';
				}
			}
			?>
		</div>
		<?= view::element('part_side_artist') ?>
	</div>
</div>
<?= view::element('part_artist_news') ?>

