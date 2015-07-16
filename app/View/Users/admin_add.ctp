<div class="users form">
 
<?php echo $this->Form->create('User');?>
    <fieldset>
        <legend><?php echo __('Add Member'); ?></legend>
        <?php echo $this->Form->input('username');
        echo $this->Form->input('password');
        echo $this->Form->input('password_confirm', array('label' => 'Confirm Password *', 'maxLength' => 255, 'title' => 'Confirm password', 'type'=>'password'));
        echo $this->Form->input('first_name');
        echo $this->Form->input('last_name');
        echo $this->Form->input('upload', array('label' => 'Upload your avatar', 'type' => 'file'));


        echo $this->Form->input('refered',array('label' => 'Referred By', 'value' => $this->Session->read('Auth.User.first_name'), 'readonly' => 'readonly'));
        echo $this->Form->input('role', array(
            'options' => array('admin' => 'Admin', 'user' => 'Regular User')
        )); ?><br><?php
         
        echo $this->Form->submit('Add Member', array('class' => 'button',  'title' => 'Click here to add the user') ); 
?>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>
