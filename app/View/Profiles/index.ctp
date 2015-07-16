<div class="grid_entry row" id="posts-list">
  
     
      <div class="large-4 columns ">
        <div class="panel text-center">
          <h3 class="text-center space"><?php echo $profile['User']['first_name'].' '.$profile['User']['last_name']; ?></h3>

          <?php echo $this->Html->image($profile['User']['image']); ?>
          <h6><?php echo $this->Html->link(
              '<i class="fi-pencil large"></i> Edit Account',
              array(
                  'controller' => 'users',
                  'action' => 'edit',
                  $this->Session->read('Auth.User.id'),
                  'full_base' => true
              ),
              array(
				'class' => 'button expand',
                'escape' => false
            )
          ); ?></h6>
		  
          
		  
		  
          <div class="section-container vertical-nav" data-section data-options="deep_linking: false; one_up: true">
          <?php foreach ($profile['Elements'] as $element): ?>
              <section class="section">
                <h5 class="title"><strong><?php echo ucwords($element['type']); ?></strong>: <?php echo ucwords($element['value']); ?></h5>
              </section>
          <?php endforeach ?>
          </div>
		  <h6><?php echo $this->Html->link(
              '<i class="fi-pencil large"></i> Edit Profile',
              array(
                  'controller' => 'elements',
                  'action' => 'edit',
                  $this->Session->read('Auth.User.id')
              ),
              array(
				'class' => 'button expand',
                'escape' => false
            )
          ); ?></h6>

   
      </div>
			<?php 
				$user_id = $this->Session->read('Auth.User.id');
				$isActive = $this->requestAction(array(
				'controller' => 'users',
				'action' => 'isActive',
				$user_id));
			?>
	<?php if($isActive):?>
 
          <?php echo $this->Html->link(   "<i class='fi-shopping-cart'></i> Gift registry"  ,
		  array('controller' => 'registries', 'action' => 'index'),  
		  array('class'=>'button medium expand', 'escape' => false)); ?> 

 

      </div>
      
       
       <div class="large-8 columns">
        
      
        <!-- END Post Form -->
		<?php foreach ($items as $item): ?>
        <!-- START Post -->
			<?php 
			$user = $this->requestAction(array(
				'controller' => 'users',
				'action' => 'findUser',
				$item['Items']['user_id']));
				
			$group = $this->requestAction(array(
				'controller' => 'groups',
				'action' => 'findGroup',
				$item['Items']['group_id']));
			
			$currentPermission = $this->requestAction(array(
				'controller' => 'permissions',
				'action' => 'currentPermission',
				$this->Session->read('Auth.User.id'),
				$item['Items']['id']));
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
					<strong><?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></strong> <?php echo $this->Text->autoLinkUrls($item['Items']['description']);  ?>
					<h3><small><i class="fi-clock large"></i> <?php echo $this->time->niceShort($item['Items']['created']); ?> in 
									<?php echo $this->Html->link(
										$group['Group']['name'],
										array(
											'controller' => 'groups',
											'action' => 'view',
											$group['Group']['id'],
											'admin' => false,
											'plugin' => false
										),
										array(
											'escape' => false
										)
									); ?>
					</small></h3>
					
					<?php 
					if($item['Items']['image'] != null): ?>
						<ul class="clearing-thumbs" data-clearing>
						  <li>
							<?php echo $this->Html->link(
										$this->Html->image($item['Items']['image'], array('class' => 'Items')),
										'/img/'.$item['Items']['image'],
										array(
											'escape' => false,
											'class' => 'th item'
										)
									); ?>
						  </li>
						</ul>
					<?php endif; ?>
					
					<?php 
					$item['Comments'] = $this->requestAction(array(
						'controller' => 'comments',
						'action' => 'findComments',
						$item['Items']['id']));
					 ?>
					
						<!-- START Comments -->
						<h6><?php echo count($item['Comments']).' Comment(s)'; ?>
						
						<?php if ($this->Session->read('Auth.User.id') == $item['Items']['user_id']):
							echo $this->Form->postLink(
									'<i class="fi-trash large"></i> Delete',
									array(
										'controller' => 'items',
										'action' => 'delete',
										$item['Items']['id'],
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
											$item['Items']['id'],
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
										$item['Items']['id'],
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
						endif;
						foreach ($item['Comments'] as $comment):
				
								$user = $this->requestAction(array(
									'controller' => 'users',
									'action' => 'findUser',
									$comment['Comment']['user_id']));
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
									<?php echo $comment['Comment']['description'] ; ?>
									<h4><small><i class="fi-clock small"></i> <?php echo $this->time->niceShort($comment['Comment']['created']); ?></small></h4>
								</div>
							</div>
						<?php endforeach; ?>	
						<!-- END Comments -->

					<?php if ($currentPermission == 2 || $currentPermission == 4): ?>
						<!-- START Comment Form -->
						 <?php echo $this->Form->create('Comment', array('action' => 'create', 'url' => array($item['Items']['group_id']))); 
								echo $this->Form->textarea('Comment.description', array('label' => false, 'placeholder' => 'Write your comment...', 'required')); 
								echo $this->Form->input('Comment.user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
								echo $this->Form->input('Comment.item_id', array('type' => 'hidden', 'value' => $item['Items']['id']));
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
		
	<?php endif?>
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
      

    </div>
     
      

    </div>