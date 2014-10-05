<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
        <?= "Evolus"; ?>
	</title>
	<?php
		echo $this->Html->css('style');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<?php echo  $this->Html->link($this->Html->image('evolus.png', array('width' => '150')), array(''), array('escape' => false)); ?>
            <div class="menu">
                <?php echo $this->element('menu'); ?>
            </div>
            <?php if(AuthComponent::user('id')) {; ?>
                <?php echo $this->element('menuLogado'); ?>
            <?php } ?>
            <div class="login">
                <?php echo $this->element('login'); ?>
            </div>
		</div>
		<div id="content">
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
		</div>
	</div>
</body>
</html>
