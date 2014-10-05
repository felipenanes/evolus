
<ul class="logado">
    <h4>Ações do Aluno:</h4>
    <li><?php echo $this->Html->link('Registrar Aula', array('escape' => false)); ?></li>
    <li><?php echo $this->Html->link('Minhas Turmas', array('escape' => false)); ?></li>
    <li><?php echo $this->Html->link('Meus Dados', array('escape' => false)); ?></li>
    <li><?php echo $this->Html->link('Sair', array('controller' => 'users', 'action' => 'logout'), array('escape' => false)); ?></li>
</ul>