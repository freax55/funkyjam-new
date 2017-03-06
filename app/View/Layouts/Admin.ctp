<?php require_once('AdminHeader.ctp') ?>

<?php
$auth_user = $this->Session->read('User');
if ($auth_user['Role']['id'] <= 2) {
?>
<div class="row">
	<div class="col-md-2" id="sidebar">
		<?php require_once('AdminNavigation.ctp') ?>
	</div>
	<div class="col-md-10" id="main">
		<?php
		print $content_for_layout;
		?>
	</div>
</div>
<?php
} else {
?>
<div style="margin: 10px 30px 100px 30px">
	<?php
	print $content_for_layout;
	?>
</div>
<?php
}
?>
<?php require_once('AdminFooter.ctp') ?>