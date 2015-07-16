<div class="row">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Edit Member'); ?></legend>
        <?php 
        echo $this->Form->hidden('id', array('value' => $this->data['User']['id']));
        echo $this->Form->input('username', array( 'readonly' => 'readonly', 'label' => 'Usernames cannot be changed!'));
        echo $this->Form->input('first_name');
        echo $this->Form->input('last_name');
        echo $this->Form->input('password_update', array( 'label' => 'New Password (leave empty if you do not want to change)', 'maxLength' => 255, 'type'=>'password','required' => 0));
        echo $this->Form->input('password_confirm_update', array('label' => 'Confirm New Password *', 'maxLength' => 255, 'title' => 'Confirm New password', 'type'=>'password','required' => 0));
        echo $this->Form->input('role', array(
            'options' => array('admin' => 'Admin', 'user' => 'Regular User')
        )); ?><br><?php
        echo $this->Form->submit('Edit User', array('class' => 'button',  'title' => 'Click here to add the user') ); 
?> 
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>