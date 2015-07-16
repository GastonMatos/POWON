<div class="grid_entry row" id="posts-list">
  
     
      <div class="large-4 columns ">
        <div class="panel text-center">
          <h3 class="text-center space"><?php echo $profile['User']['first_name'].' '.$profile['User']['last_name']; ?></h3>


          <?php echo $this->Html->image($profile['User']['image'], array('class' => '')); ?>
          <?php if ($this->Session->read('Auth.User.role') == 'admin'): ?> 
            <h6><?php echo $this->Html->link(
                '<i class="fi-pencil large"></i> Edit Account',
                array(
                    'controller' => 'users',
                    'action' => 'edit',
                    $profile['User']['id'],
                    'full_base' => true
                ),
                array(
                  'escape' => false
              )
            ); ?></h6>
          <?php endif; ?>


          
          <?php 
            $sent = $this->requestAction(array(
              'controller' => 'users',
              'action' => 'requestsHasBeenSent',
              $this->Session->read('Auth.User.id'),
              $profile['User']['id']
              ));

            $isFriend = $this->requestAction(array(
              'controller' => 'users',
              'action' => 'isFriend',
              $this->Session->read('Auth.User.id'),
              $profile['User']['id']
              ));
          ?>

          <?php if($isFriend): ?>
            <button class="button disabled expand success"><i class="fi-torsos large"></i> Friends</button>

          <?php elseif($sent) : ?>
            <button class="button disabled expand warning"><i class="fi-check large"></i> Friend Request Pending</button>
          
          <?php elseif((!$isFriend) && (!$sent)):
             echo $this->Html->link(
                '<i class="fi-plus large"></i> Send Friend Request',
                array(
                    'controller' => 'users',
                    'action' => 'sendFriendRequest',
                    $this->Session->read('Auth.User.id'),
                    $profile['User']['id'],
                    'full_base' => true
                ),
                array(
                  'class' => 'button expand',
                  'escape' => false
                )
              );
           endif; ?>

          
          <div class="section-container vertical-nav" data-section data-options="deep_linking: false; one_up: true">
          <?php foreach ($profile['Elements'] as $element): ?>
				  <?php
			
					$currentElementPermission = $this->requestAction(array(
						'controller' => 'permissions',
						'action' => 'currentElementPermission',
						$this->Session->read('Auth.User.id'),
						$element['id']));
					?>
				<?php if ($currentElementPermission == 1): ?>
				  <section class="section">
					<h5 class="title"><strong><?php echo ucwords($element['type']); ?></strong>: <?php echo ucwords($element['value']); ?></h5>
				  </section>
				<?php endif;
          endforeach ?>
          </div>

   
        </div>
  
            

        <?php if($isFriend): ?>
           <div >
             <?php echo $this->Html->link(   "<i class='fi-shopping-cart'></i> Gift registry"  ,array('controller' => 'registries', 'action' => 'view', $profile['User']['id']),  array('class'=>'button medium expand', 'escape' => false)); ?> 
            </div>
   		<?php endif; ?>
      </div>
      
       
       <div class="large-8 columns">
        
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
			<!-- START Item -->
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
				<strong><?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></strong> <?php echo $this->Text->autoLinkUrls($item['Item']['description']); ?>
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
				
					<?php if ($currentPermission == 2 || $currentPermission == 4): ?>
						<!-- START Comments -->
						<h6><?php echo count($item['Comments']).' Comment(s)' ;
						
						if ($currentPermission > 2):
								echo $this->Form->postLink(
									'<i class="fi-share large"></i> Share',
									array(
										'controller' => 'items',
										'action' => 'share',
										$item['Item']['id'],
										$this->Session->read('Auth.User.id'),
										$item['Item']['group_id'],
										'admin' => false,
										'plugin' => false
									),
									array('confirm' => 'The link to this item will be posted on your behalf',
									'data-placement'=>'left',
									'class'=> 'radius secondary label right',
									'escape'=>false
								));?></h6><?php 
							endif;?></h6>
						
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
									<strong><?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></strong> <?php echo $comment['description'] ; ?>
									<h4><small><i class="fi-clock small"></i> <?php echo $this->time->niceShort($comment['created']); ?></small></h4>
								</div>
							</div>
						<?php endforeach; ?>	
						<!-- END Comments -->
					<?php endif; ?>

				<?php if($isFriend && ($currentPermission == 2 || $currentPermission == 4)): ?>
					<!-- START Comment Form -->
					 <?php echo $this->Form->create('Comment', array('action' => 'create')); 
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
			<!-- END Item -->
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
      

    </div>