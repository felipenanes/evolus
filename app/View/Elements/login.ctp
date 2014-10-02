<?php echo $this->Form->create('User', array('action' => 'login', 'class' => 'login')); ?>
<?php echo $this->Form->input('name', array('label' => false, 'placeholder' => 'username')); ?>
<?php echo $this->Form->input('password', array('label' => false, 'placeholder' => 'senha', 'type' => 'password')); ?>
<?php echo $this->Form->submit('Entrar'); ?>
<?php echo $this->Form->end(); ?>