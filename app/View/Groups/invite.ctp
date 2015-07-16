<div class="large-4 columns">
	<?php echo $this->Html->image($group['Group']['image'], array("alt" => "Powon"));?>
	<h3 class="text-center"><?php echo $group['Group']['name'];?>	</h3>
</div>

<div class="large-8 columns">
	<h5>Invite an existing powon member</h5>
	<?php echo $this->Form->create('User', array('enctype' => 'multipart/form-data'));
		
		echo $this->Form->input('id', array('label' => 'Powon ID', 'type' => 'number', 'required'));
		echo $this->Form->input('first_name', array('label' => 'First Name', 'type' => 'text', 'required')); 
		echo $this->Form->input('email_invite', array('label' => 'Email Address', 'type' => 'email', 'required')); ?><br/>
		
		<?php echo $this->Form->submit('Invite Member', array('class' => 'button',  'title' => 'Click here to send invite member') ); 
 	echo $this->Form->end();

 	?>
</div>