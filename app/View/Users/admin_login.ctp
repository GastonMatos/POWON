<div class="row">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
        <legend><?php echo __('Please enter your username and password'); ?></legend>
        <?php echo $this->Form->input('username');
        echo $this->Form->input('password');
    ?>
    
<?php echo $this->Form->end(__('Login')); ?>
</div>
<?php
 echo $this->Html->link( "Add A New User",   array('action'=>'add') ); 
?>