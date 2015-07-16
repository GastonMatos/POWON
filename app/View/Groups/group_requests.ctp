<?php if (empty($requests)): ?> 
<h3><?php echo 'You have no group requests.'; ?></h3>
<?php endif; ?>

<?php foreach ($requests as $request): ?>
	<?php $user_id = $request['users_groups']['user_id']; 
		$group_id = $request['users_groups']['group_id']; 
		$user = $this->requestAction(array(
				'controller' => 'users',
				'action' => 'findUser',
				$user_id));
		$group = $this->requestAction(array(
				'controller' => 'groups',
				'action' => 'findGroup',
				$group_id));
	?>
	<div class="large-12 columns panel">
		<div class=" large-4 medium-4 columns">
			<?php
						echo $this->Html->link(
						    $this->Html->image($user['User']['image'], array("alt" => "Powon", 'class' => 'thumbnail')),
						    array(
						        'controller' => 'profiles',
						        'action' => 'view',
						        $user['User']['id'],
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
						    $user['User']['first_name'] . " " . $user['User']['last_name'],
						    array(
						        'controller' => 'profiles',
						        'action' => 'view',
						        $user['User']['id'],
						        'admin' => false,
						        'plugin' => false
						    ),
						    array(
						    	'escape' => false
						    )
						); ?> wants to join your group "<?php echo $group['Group']['name']; ?>"</h3>

			<?php echo $this->Html->link(
						    '<i class="fi-check large"></i> Accept',
						    array(
						        'controller' => 'groups',
						        'action' => 'accept',
						        $user_id,
						        $group_id,
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
						        'controller' => 'groups',
						        'action' => 'deny',
						        $user_id,
						        $group_id,
						        'admin' => false,
						        'plugin' => false
						    ),
						    array(
						    	'escape' => false,
						    	'class' => 'button alert'
						    )
						); ?>
	
	</div>

<?php endforeach; ?>