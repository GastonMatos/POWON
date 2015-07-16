<div class="row">
<?php echo $this->Form->create('Group', array('enctype' => 'multipart/form-data')); ?>
    <fieldset>
        <legend><?php echo __('Edit My Group'); ?></legend>
        <?php 
        echo $this->Form->input('name');
        echo $this->Form->input('upload', array('label' => 'Change the group picture', 'type' => 'file'));
		echo $this->Form->input('category', array(
		    'options' => array('casual' => 'Casual', 'car' => 'Car','sports' => 'Sports', 'reading' => 'Reading',
								'pets' => 'Pets', 'music' => 'Music','programming' => 'Programming', 'religion' => 'Religion',
								'travelling' => 'Travelling', 'photograph' => 'Photograph','arts' => 'Arts', 'others' => 'Others') ));?><br>
        <?php echo $this->Form->input('description', array('label' => 'Description','type' => 'textarea'));
        echo $this->Form->hidden('user_id', array('value' => $this->Session->read('Auth.User.id')));
    
	
	
        echo $this->Form->submit('Edit Group', array('class' => 'button',  'title' => 'Click here to edit your group') ); 
?>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>