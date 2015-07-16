<div class="row post-item">
				
			  <div class="large-3 columns small-3">
				<?php
						echo $this->Html->link(
						    $this->Html->image($item['User']['image'], array('class' => 'thumbnail')),
						    array(
						        'controller' => 'profiles',
						        'action' => 'view',
						        $item['Item']['id'],
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
				<strong><?php echo $item['User']['first_name'].' '.$item['User']['last_name']; ?></strong> <?php echo $item['Item']['description']; ?>
				<h3><small><i class="fi-clock large"></i> <?php echo $this->time->niceShort($item['Item']['created']); ?> in 
								<?php echo $this->Html->link(
									$item['Group']['name'],
									array(
										'controller' => 'groups',
										'action' => 'view',
										$item['Group']['id'],
										'admin' => false,
										'plugin' => false
									),
									array(
										'escape' => false
									)
								); ?>
				</small></h3>
				
				<?php 
				if($item['Item']['image'] != null): ?>
					<ul class="clearing-thumbs" data-clearing>
					  <li>
						<?php echo $this->Html->link(
									$this->Html->image($item['Item']['image'], array('class' => 'Item')),
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
					<h6><?php echo count($item['Comments']).' Comment(s)'; ?>
					
					<?php if ($this->Session->read('Auth.User.id') == $item['Item']['user_id']):
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
						echo $this->Html->link(
									'<i class="fi-share large"></i> Share',
									array(
										'controller' => 'items',
										'action' => 'share',
										$item['Item']['id'],
										$this->Session->read('Auth.item.id'),
										'admin' => false,
										'plugin' => false
									),
									array(
										'escape' => false,
										'class' => 'radius secondary label right'
									)
								);?></h6><?php 
					
					endif;
					foreach ($item['Comments'] as $comment):
			
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
								<p><?php echo $comment['description'] ; ?></p>
								<h4><small><i class="fi-clock small"></i> <?php echo $this->time->niceShort($comment['created']); ?></small></h4>
							</div>
						</div>
					<?php endforeach; ?>	
					<!-- END Comments -->


				<!-- START Comment Form -->
				 <?php echo $this->Form->create('Comment', array('action' => 'create', 'url' => array($item['Item']['group_id']))); 
						echo $this->Form->textarea('Comment.description', array('label' => false, 'placeholder' => 'Write your comment...', 'required')); 
						echo $this->Form->input('Comment.user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
						echo $this->Form->input('Comment.item_id', array('type' => 'hidden', 'value' => $item['Item']['id']));
					echo $this->Form->submit(
						'Comment', 
						array('class' => 'button tiny', 'title' => 'submit')
					); ?>
				<?php echo $this->Form->End(); ?>
				<!-- END Comment Form -->

			  </div>
			</div>
			<!-- END Post -->
			 
	   
			<hr/>