<div class="row">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
        <legend><?php echo __('Please enter your username and password'); ?></legend>
        <?php echo $this->Form->input('username',array('label' => 'Email'));
        echo $this->Form->input('password');
    	echo $this->Form->submit('Login', array('class' => 'button',  'title' => 'Click here to Login') ); 
    ?>
    
<?php echo $this->Form->end(); ?>
</div>