<div class="row">
 
<?php echo $this->Form->create('Event', array('enctype' => 'multipart/form-data'));?>
    <fieldset>
        <legend><?php echo __('Create Event'); ?></legend>
        <?php echo $this->Form->input('name');
		
		echo $this->Form->input('date', array('label' => 'Date', 'class' => 'fdatepicker', 'type' => 'text', 'placeholder' => 'YYYY-MM-DD'));
		
		echo $this->Form->input('time', array('label' => 'Time', 'type' => 'text', 'placeholder' => 'HH:MM:SS'));
		
		echo $this->Form->input('place');

        echo $this->Form->input('description', array('label' => 'Description', 'type' => 'textarea'));

        echo $this->Form->hidden('group_id', array('value' => $this->request->params['pass'][0]));
         
        echo $this->Form->submit('Create Event', array('class' => 'button',  'title' => 'Click here to add an event') ); 
?>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>