<div class="users form">
 
<?php echo $this->Form->create('User', array('enctype' => 'multipart/form-data')); ?>
    <fieldset>
        <legend><?php echo __('Register User'); ?></legend>
        <?php 
        echo $this->Form->input('username', array('label' => 'Email', 'placeholder' => 'name@email.com'));
        echo $this->Form->input('password');
        echo $this->Form->input('password_confirm', array('label' => 'Confirm Password *', 'maxLength' => 255, 'title' => 'Confirm password', 'type'=>'password'));
        echo $this->Form->input('first_name');
        echo $this->Form->input('last_name');
        echo $this->Form->input('upload', array('label' => 'Upload your avatar', 'type' => 'file'));
        echo $this->Form->input('refered', array('label' => 'Refered by' ,'placeholder' => 'First name of registered user'));
        echo $this->Form->hidden('status', array('value' => 1));  
        echo $this->Form->submit('Register User', array('class' => 'button',  'title' => 'Click here to add the user') ); 
?>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>