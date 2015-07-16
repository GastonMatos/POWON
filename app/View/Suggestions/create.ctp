
<div class="row">
 
<?php echo $this->Form->create('Suggestion', array('enctype' => 'multipart/form-data'));?>
    <fieldset>
        <legend><?php echo __('Create Suggestion for Event'); ?></legend>

       <?php echo $this->Form->input('option', array('label' => 'Option'));

        echo $this->Form->hidden('event_id', array('value' => $this->request->params['pass'][0]));
		
        echo $this->Form->submit('Add Option', array('class' => 'button',  'title' => 'Click here to vote') ); 
?>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>