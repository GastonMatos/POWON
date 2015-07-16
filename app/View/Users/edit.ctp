<div class="row">
<?php echo $this->Form->create('User', array('enctype' => 'multipart/form-data')); ?>
    <fieldset>
        <legend><?php echo __('Edit My Profile'); ?></legend>
        <?php 
        echo $this->Form->hidden('id', array('value' => $this->data['User']['id']));
        echo $this->Form->input('username', array( 'readonly' => 'readonly', 'label' => 'Usernames cannot be changed!'));
        echo $this->Form->input('upload', array('label' => 'Change your avatar', 'type' => 'file'));
        echo $this->Form->input('first_name');
        echo $this->Form->input('last_name');
        echo $this->Form->input('password_update', array( 'label' => 'New Password (leave empty if you do not want to change)', 'maxLength' => 255, 'type'=>'password','required' => 0));
        echo $this->Form->input('password_confirm_update', 
					array('label' => 'Confirm New Password *', 'maxLength' => 255, 
					'title' => 'Confirm New password',
					'type'=>'password','required' => 0));
					
  		echo $this->Form->input('status', array(
		    'options' => array('1' => 'Active', '0' => 'Inactive') ));
			
		echo $this->Form->create(false); 
	
        echo $this->Form->submit('Edit User', array('class' => 'button',  'title' => 'Click here to edit your profile') ); 
?>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>