<?php
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
?>

<?php
foreach ($data_area as $pref_id => $areas){
	foreach($areas as $area){
		if (isset($area['Area'])) {
			?>
			<url>
				<loc>https://<?= MYHOST ?>/<?= $areas['pref_name'] ?>/area/<?= $area['Area']['id'] ?>/</loc>
				<changefreq>daily</changefreq>
				<priority>0.8</priority>
			</url>
			<?php
		}
	}
}
?>

<?php
foreach ($data_prefs as $k => $v) {
?>
<url>
    <loc>https://<?= MYHOST ?>/<?= $prefs_en[$v['Pref']['id']] ?>/</loc>
    <changefreq>daily</changefreq>
    <priority>0.5</priority>
</url>
<?php
}
?>

<?php
foreach ($clubs as $v) {
	$v = $v['Club'];
?>
<url>
	<loc>https://<?= MYHOST ?>/club/<?= $v['id'] ?>/</loc>
	<changefreq>monthly</changefreq>
	<priority>0.2</priority>
</url>
<?php
}
?>

<?php
echo '</urlset>';
?>