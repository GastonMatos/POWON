<div class="row">
<?php echo $this->Form->create('Event', array('enctype' => 'multipart/form-data')); ?>
    <fieldset>
        <legend><?php echo __('Edit Event'); ?></legend>
        <?php echo $this->Form->input('name');?><br>
		<?php echo $this->Form->input('date', array('label' => 'Date', 'class' => 'fdatepicker', 'type' => 'text'));
		
		echo $this->Form->input('time', array('label' => 'Time', 'type' => 'text'));
		
		echo $this->Form->input('place');
        echo $this->Form->input('description', array('label' => 'Description','type' => 'textarea'));
        echo $this->Form->hidden('user_id', array('value' => $this->Session->read('Auth.User.id')));
        echo $this->Form->hidden('group_id', array('value' => $this->request->params['pass'][1]));
    
	
	
        echo $this->Form->submit('Edit Events', array('class' => 'button',  'title' => 'Click here to edit your event') ); 
?>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>