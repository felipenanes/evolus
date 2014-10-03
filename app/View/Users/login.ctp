<h3>Logando no Sistema</h3>
<?php echo $this->Form->create('User'); ?>
<?php echo $this->Form->input('username', array('label' => 'Usuário', 'type'=>'text')); ?>
<?php echo $this->Form->input('password', array('label' => 'Senha', 'type' => 'password')); ?>
<?php echo $this->Form->submit('Entrar'); ?>
<?php echo $this->Form->end(); ?>