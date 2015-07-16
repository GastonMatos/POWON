
<br>

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


<h3> You can send friends request to these people</h3>
<br>

<div class="grid_entry row" id="posts-list">

	<?php foreach ($users as $user): ?>
	          <?php 
	            $sent = $this->requestAction(array(
	              'controller' => 'users',
	              'action' => 'requestsHasBeenSent',
	              $this->Session->read('Auth.User.id'),
	              $user['User']['id']
	              ));

	            $isFriend = $this->requestAction(array(
	              'controller' => 'users',
	              'action' => 'isFriend',
	              $this->Session->read('Auth.User.id'),
	              $user['User']['id']
	              ));
	          ?>
	    <?php if((!$isFriend) && (!$sent)): ?>
		<div class="large-12 columns panel post-item">
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

				<?php echo
							    $user['User']['first_name'] . " " . $user['User']['last_name'];?>
							 </h3>

				<?php echo $this->Html->link(
							    '<i class="fi-plus large"></i> Send Friend Request ',
							    array(
							        'controller' => 'users',
							        'action' => 'sendFriendRequest',
							        $user['User']['id'],
									$this->Session->read('Auth.User.id'),
							        'admin' => false,
							        'plugin' => false
							    ),
							    array(
							    	'escape' => false,
							    	'class' => 'button'
							    )
							); ?>
	           
		
			</div>
		<?php endif;?>
	<?php endforeach ?>




	<div class="large-12 columns text-center">
		<?php /*echo $this->Paginator->numbers(array(
		 		'before' => '<ul class="pagination">',
				'after' => '</ul>',
		 		'separator' => '',
		 		'tag' => 'li',
				'currentClass' => 'current',
		 		'first' => 'Première page',
		 		'last' => 'Dernière page',
		 		'currentTag' => 'a'
			)); */
	        echo $this->Paginator->next('Load More...');
		?>
	</div>
	<?php unset($users); ?>
</div>