<div class="large-4 columns">
	<?php echo $this->Html->image($to['User']['image'], array("alt" => "Powon"));?>
	<h3 class="text-center"><?php echo $to['User']['first_name']. ' ' . $to['User']['last_name'];?>	</h3>
</div>

<div class="large-8 columns">
	<h5>How do you know <?php echo $to['User']['first_name'].'?'; ?></h5>
	<?php echo $this->Form->create(false);
		echo $this->Form->input('Choose Relationship', array(
		    'options' => array('friend' => 'Friend', 'family' => 'Family', 'colleagues' => 'Colleague')
		)); ?><br/>
		<?php echo $this->Form->submit('Send Friend Request', array('class' => 'button',  'title' => 'Click here to send friend request') ); 
 	echo $this->Form->end();

 	?>
</div>
