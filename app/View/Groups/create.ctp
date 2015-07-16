<div class="row">
 
<?php echo $this->Form->create('Group', array('enctype' => 'multipart/form-data'));?>
    <fieldset>
        <legend><?php echo __('Create Group'); ?></legend>
        <?php echo $this->Form->input('name');
		  	 
			 
		echo $this->Form->input('category', array(
		    'options' => array('casual' => 'Casual', 'car' => 'Car','sports' => 'Sports', 'reading' => 'Reading',
								'pets' => 'Pets', 'music' => 'Music','programming' => 'Programming', 'religion' => 'Religion',
								'travelling' => 'Traveling', 'photograph' => 'Photograph','arts' => 'Arts', 'others' => 'Others') ));
        
        echo $this->Form->input('upload', array('label' => 'Upload your Group image', 'type' => 'file'));

        echo $this->Form->input('description', array('label' => 'Description', 'type' => 'textarea'));

        echo $this->Form->hidden('user_id', array('value' => $this->Session->read('Auth.User.id')));
         
        echo $this->Form->submit('Create Group', array('class' => 'button',  'title' => 'Click here to add the user') ); 
?>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>
