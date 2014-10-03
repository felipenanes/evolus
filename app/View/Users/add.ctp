<h3>Registro de Usuário</h3>
<?php echo $this->Form->create('User', array('action' => 'add', 'class' => 'login')); ?>
<?php echo $this->Form->input('username', array('label' => false, 'placeholder' => 'username')); ?>
<?php echo $this->Form->input('email', array('label' => false, 'placeholder' => 'email', 'type' => 'text')); ?>
<?php echo $this->Form->input('password', array('label' => false, 'placeholder' => 'senha', 'type' => 'password')); ?>
<?php echo $this->Form->submit('Registrar'); ?>
<?php echo $this->Form->end(); ?>