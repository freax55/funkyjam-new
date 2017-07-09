<?php require_once('SuperBoxHeader.ctp') ?>
	<?php echo $this->Session->flash(); ?>
	<div id="contentcolumn">
		<?php echo $this->fetch('content'); ?>
	</div>
<?php require_once('SuperBoxFooter.ctp') ?>