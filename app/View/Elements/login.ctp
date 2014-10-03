<?php echo $this->Form->create('User', array('action' => 'login', 'class' => 'login')); ?>
<?php echo $this->Form->input('username', array('label' => false, 'placeholder' => 'username')); ?>
<?php echo $this->Form->input('password', array('label' => false, 'placeholder' => 'senha', 'type' => 'password')); ?>
<?php echo $this->Form->submit('Entrar'); ?>
<?php echo $this->Form->end(); ?>
<?php echo "Não é Cadastrado?" ."\n". $this->Html->link('Registrar', array('controller' => 'users', 'action' => 'add')); ?>