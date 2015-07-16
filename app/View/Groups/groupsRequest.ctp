
<?php foreach ($friends as $friend): ?>
	<div class="large-12 columns panel">
		<div class=" large-4 medium-4 columns">
			<?php
						echo $this->Html->link(
						    $this->Html->image($friend['User']['image'], 
							array("alt" => "Powon", 'class' => 'thumbnail')),
						    array(
						        'controller' => 'profiles',
						        'action' => 'view',
						        $friend['User']['id'],
						        'admin' => false,
						        'plugin' => false
						    ),
						    array(
						    	'escape' => false,
						    	'class' => 'th'
						    )
						);
					?></div>
					
					
	
		<h3 class="large-8 medium-4 columns">

			<?php echo $this->Html->link(
						    $friend['User']['first_name'] . " " . $friend['User']['last_name'],
						    array(
						        'controller' => 'profiles',
						        'action' => 'view',
						        $friend['User']['id'],
						        'admin' => false,
						        'plugin' => false
						    ),
						    array(
						    	'escape' => false
						    )
						); ?> sent you a Friend Request</h3>

			<?php echo $this->Html->link(
						    '<i class="fi-check large"></i> Accept',
						    array(
						        'controller' => 'profiles',
						        'action' => 'accept',
						        $friend['User']['id'],
						        'admin' => false,
						        'plugin' => false
						    ),
						    array(
						    	'escape' => false,
						    	'class' => 'button success'
						    )
						); ?>

			<?php echo $this->Html->link(
						    '<i class="fi-x large"></i> Deny',
						    array(
						        'controller' => 'profiles',
						        'action' => 'deny',
						        $friend['User']['id'],
						        'admin' => false,
						        'plugin' => false
						    ),
						    array(
						    	'escape' => false,
						    	'class' => 'button alert'
						    )
						); ?>
	
	</div>

<?php endforeach ?>