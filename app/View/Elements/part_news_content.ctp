<?php
// $content[0]['Post']['post_content'];
// $content = $content[0]['Post']
$date = $content[0]['Post']['post_date'];
$title = $content[0]['Post']['post_title'];
// $date_string = 
?>


<p><?= $this->common->date4mat($date, 'Y.m.d') ?></p>
<h1><?= $title ?></h1>
<?= $this->WpView->wpautop($content[0]['Post']['post_content']) ?>
