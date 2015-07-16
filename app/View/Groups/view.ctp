	<div class="grid_entry row" id="posts-list">
  
     
      <div class="large-4 columns ">
        <div class="panel">
          <h3 class="text-center space"><?php echo $group['Group']['name']; ?></h3>

          
            <div class="section-container vertical-nav" data-section data-options="deep_linking: false; one_up: true">
				<?php echo $this->Html->image($group['Group']['image'], array("alt" => $group['Group']['name'])); ?>
				<section class="section">
				  <p class="title"><?php echo $group['Group']['description']; ?></p>
				</section>
				<section class="section">
				  <h5 class="title">
					<?php
					echo $this->Html->link(
						    '<i class="fi-torsos-all large"></i> View Members ('. (count($users) + 1) .' Members)',
						    array(
						        'controller' => 'groups',
						        'action' => 'view_members',
							    $this->Session->read('Auth.Group.id'),
						        $group['Group']['id'],
						        'admin' => false,
						        'plugin' => false
						    ),
						    array('escape' => false )); ?></h5>
				</section>
				<section class="section">
				  <h5 class="title">
					<?php echo $this->Html->link(
						    '<i class="fi-plus large"></i> Invite Member',
						    array(
						        'controller' => 'groups',
						        'action' => 'invite',
						        $group['Group']['id'],
						        'admin' => false,
						        'plugin' => false
						    ),
						    array(
						    	'escape' => false
						    )
						); ?>
				  </h5>
				</section> 
				
			</div>
          
        </div>
		<div class="panel text-center">
          <div class="section-container vertical-nav" data-section data-options="deep_linking: false; one_up: true">  
            <h3>Group Events</h3>
			
		<?php   
			$isOwner = $this->requestAction(array(
				'controller' => 'groups',
				'action' => 'isOwner',
				$group['Group']['id']));
				
				$isMember = $this->requestAction(array(
				'controller' => 'groups',
				'action' => 'isMember',
				$group['Group']['id']));
				
				if(!$isMember && !$isOwner && $this->Session->read('Auth.User.role') == 'member'){
					$this->Session->setFlash("You are not a member of this group", 'warning');
					header ("Location: https://clipper.encs.concordia.ca/~mfc353_2/profiles/index");
				}
				
				?>
			
			<?php if($isOwner): ?>
				<section class="section">
				  <h5 class="title">
				  
					<?php echo $this->Html->link(
						    '<i class="fi-plus large"></i> Manage Events',
						    array(
						        'controller' => 'events',
						        'action' => 'index',
								$group_id,
						        'admin' => false,
						        'plugin' => false
						    ),
						    array(
						    	'escape' => false
						    )
						); ?>
				  </h5>
				</section> 
		
				<?php foreach ($events as $event): ?>

					<div class="panel text-center">
				
					<h4 class="title"><?php echo $event['Event']['name']; ?></h4>
					<h5 class="title"><?php echo $event['Event']['date'].' '.$event['Event']['time']; ?></h5>
					<h5 class="title"><?php echo 'Meets at '. $event['Event']['place']; ?></h5>	

					
					</div>
				<?php endforeach ?>			

			
			<?php else: ?>
		
				<?php foreach ($events as $event): ?>
					<div class="panel text-center">
					
						  <h5 class="title">
						  
							<?php echo $this->Html->link(
									'<i class="fi-pencil large"></i> Details',
									array(
										'controller' => 'groups',
										'action' => 'view_events',
										$group_id,
										'admin' => false,
										'plugin' => false
									),
									array(
										'escape' => false
									)
								); ?>
						  </h5>			
					
					<h5 class="title"><?php echo $event['Event']['name']; ?></h5>
					<h5 class="title"><?php echo $event['Event']['date'].' '.$event['Event']['time']; ?></h5>
					<h5 class="title"><?php echo 'Meets at '. $event['Event']['place']; ?></h5>	
					<h5 class="title"><?php echo $event['Event']['description']; ?></h5>
					</div>
				<?php endforeach ?>
			<?php endif ?>

          </div>
        </div>
		
      </div>
	  
	  
      

      <div class="large-8 columns">
        
        <!-- START Post Form -->
        <?php echo $this->Form->create('Item', array('action' => 'create', 'enctype' => 'multipart/form-data')); 
				echo $this->Form->input('Item.upload', array('label' => 'Upload an image', 'type' => 'file'));
				echo $this->Form->textarea('Item.description', array('label' => false, 'placeholder' => 'What\'s on your mind ?', 'required')); 
				echo $this->Form->input('Item.group_id', array('type' => 'hidden', 'value' => $this->request->pass[0]));
    		echo $this->Form->submit(
                'Publish', 
                array('class' => 'button', 'title' => 'submit')
            ); ?>
        <?php echo $this->Form->End(); ?>
        <!-- END Post Form -->
		<?php foreach ($items as $item): ?>
        <!-- START Post -->
			<?php 
			$user = $this->requestAction(array(
				'controller' => 'users',
				'action' => 'findUser',
				$item['Item']['user_id']));
			
			$currentPermission = $this->requestAction(array(
				'controller' => 'permissions',
				'action' => 'currentPermission',
				$this->Session->read('Auth.User.id'),
				$item['Item']['id']));
			?>
			
			<?php if ($currentPermission != 0): ?>
				<div class="row post-item">
					
				  <div class="large-3 columns small-3">
					<?php
							echo $this->Html->link(
								$this->Html->image($user['User']['image'], array('class' => 'thumbnail')),
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
						?>
				  </div>
				  <div class="large-9 columns">
					<strong><?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></strong> <?php echo $this->Text->autoLinkUrls($item['Item']['description']);  ?>
					<h3><small><i class="fi-clock large"></i> <?php echo $this->time->niceShort($item['Item']['created']); ?></small></h3>
					
					<?php 
					if($item['Item']['image'] != null): ?>
						<ul class="clearing-thumbs" data-clearing>
						  <li>
							<?php echo $this->Html->link(
										$this->Html->image($item['Item']['image'], array('class' => 'item')),
										'/img/'.$item['Item']['image'],
										array(
											'escape' => false,
											'class' => 'th item'
										)
									); ?>
						  </li>
						</ul>
					<?php endif; ?>
					
						<!-- START Comments -->
						<h6><?php echo count($item['Comments']).' Comment(s)' ; ?>

						<?php if ($this->Session->read('Auth.User.id') == $item['Item']['user_id']):
								echo $this->Form->postLink(
									'<i class="fi-trash large"></i> Delete',
									array(
										'controller' => 'items',
										'action' => 'delete',
										$item['Item']['id'],
										'admin' => false,
										'plugin' => false
									),
									array('confirm' => 'Are you sure?',
									'data-placement'=>'left',
									'class'=> 'radius secondary label right alert',
									'escape'=>false
								));
								echo $this->Html->link(
										'<i class="fi-widget large"></i> Manage Permissions',
										array(
											'controller' => 'permissions',
											'action' => 'manage',
											$item['Item']['id'],
											'admin' => false,
											'plugin' => false
										),
										array(
											'escape' => false,
											'class' => 'radius secondary label right'
										)
									);?></h6><?php 
						else:
							if ($currentPermission > 2):	
								echo $this->Form->postLink(
									'<i class="fi-share large"></i> Share',
									array(
										'controller' => 'items',
										'action' => 'share',
										$item['Item']['id'],
										$this->Session->read('Auth.User.id'),
										$group['Group']['id'],
										'admin' => false,
										'plugin' => false
									),
									array('confirm' => 'The link to this item will be posted on your behalf',
									'data-placement'=>'left',
									'class'=> 'radius secondary label right',
									'escape'=>false
								));?></h6><?php 
							endif;
						endif; ?>

						<?php foreach ($item['Comments'] as $comment): ?>
							<?php 
							$user = $this->requestAction(array(
								'controller' => 'users',
								'action' => 'findUser',
								$comment['user_id']));
							 ?>
							<div class="row panel collapse">
							  <div class="large-2 columns small-3"><?php
									echo $this->Html->link(
										$this->Html->image($user['User']['image'], array('class' => 'comments')),
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
								<div class="large-10">
									<?php echo $comment['description'] ; ?>
									<h4><small><i class="fi-clock small"></i> <?php echo $this->time->niceShort($comment['created']); ?></small></h4>
								</div>
							</div>
						<?php endforeach; ?>	
						<!-- END Comments -->

					<?php if ($currentPermission == 2 || $currentPermission == 4): ?>
						<!-- START Comment Form -->
						 <?php echo $this->Form->create('Comment', array('action' => 'create', 'url' => array($group['Group']['id']))); 
								echo $this->Form->textarea('Comment.description', array('label' => false, 'placeholder' => 'Write your comment...', 'required')); 
								echo $this->Form->input('Comment.user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
								echo $this->Form->input('Comment.item_id', array('type' => 'hidden', 'value' => $item['Item']['id']));
							echo $this->Form->submit(
								'Comment', 
								array('class' => 'button tiny', 'title' => 'submit')
							); ?>
						<?php echo $this->Form->End(); ?>
						<!-- END Comment Form -->
					<?php endif; ?>
				  </div>
				</div>
			<!-- END Post -->
			 <?php endif; ?>
	   
			<hr/>
			
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
	<?php unset($group); ?>
			 
			


       
          
      </div>
 
     
      

    </div>
 
     
    
 
 
   
 
  
    
    
    
