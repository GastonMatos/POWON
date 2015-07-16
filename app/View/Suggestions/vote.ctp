

<div class="large-8 columns">
	<h3>Are you sure to choose this option?></h3>
	 	<?php echo $this->Form->create('Suggestion');?>

		<?php echo $this->Form->submit('vote', array('class' => 'button',  'title' => 'Click here to vote') ); 
 	echo $this->Form->end();

 	?>
</div>