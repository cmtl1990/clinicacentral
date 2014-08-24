<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->Html->css(array('bootstrap.min', 'bootstrap-theme.min', 'message'), 'stylesheet', array('media'=>'all')); 
		echo $this->Html->script(array('jquery.min.js','bootstrap.min.js', 'message.js'),array('inline'=>true));
	?>
</head>
<body>
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->fetch('content'); ?>
</body>