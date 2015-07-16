<header>
    <div class="row">
      <div class="large-12 columns">
        <h1><i class="fi-torsos-all large"></i> Groups</h1>
			<?php echo $this->Form->create('Group', array('controller' => 'groups', 'action' => 'index'));
			echo $this->Form->input('category', array( 'onChange'=>'javascript:this.form.submit()',
		    'options' => array('casual' => 'Casual', 'car' => 'Car','sports' => 'Sports', 'reading' => 'Reading',
								'pets' => 'Pets', 'music' => 'Music','programming' => 'Programming', 'religion' => 'Religion',
								'traveling' => 'Travelling', 'photograph' => 'Photograph','arts' => 'Arts', 'others' => 'Others'),
		    							'empty' => '(Show groups by category)'));

			 echo $this->Form->end();
			?>



      </div>
    </div>
</header><br>
<h3>
			        	<?php echo $this->Html->link("<i class='fi-plus large'></i> Create Group", array('controller' => 'groups', 'action' => 'create', 'admin' => false),  array(
					        'data-placement'=>'left',
					        'escape'=>false
					    )); ?>
					</h3>

 
<div class="grid_entry row" id="posts-list">
	

	<?php foreach ($groups as $group): ?>
		<?php 
			$user = $this->requestAction(array(
				'controller' => 'users',
				'action' => 'findUser',
				$group['Group']['user_id']));
			$isMember = $this->requestAction(array(
				'controller' => 'groups',
				'action' => 'isMember',
				$group['Group']['id']));
			
			$isOwner = $this->requestAction(array(
				'controller' => 'groups',
				'action' => 'isOwner',
				$group['Group']['id'])); 

			$groupRequestSent = $this->requestAction(array(
				'controller' => 'groups',
				'action' => 'groupRequestSent',
				$group['Group']['id'])); 
		?>
		
		<div class="large-2 columns post-item">
		<?php
			echo $this->Html->image($group['Group']['image']);?></div>
			
			
		<div class="panel post-item large-10 columns">
		
			<h2 class=''><?php echo $group['Group']['name']; ?></h2>
			<h2 class=''><small><?php echo 'Category: '.$group['Group']['category']; ?></small></h2>
			<h4 class=''><small><i class="fi-clock large"></i> 
						<?php echo 'Created '. $this->time->niceShort($group['Group']['created']); ?> 
								by <?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></small></h4>
			<p class=''><?php echo $group['Group']['description']; ?></p>
			
			



			<?php if ($isMember):
				if($isOwner):
					echo $this->Html->link(
					'<i class="fi-eye large"></i> View Group',
					array(
						'controller' => 'groups',
						'action' => 'view',
						$group['Group']['id'],
						'full_base' => true
					),
					array(
					  'class' => 'button',
					  'escape' => false
					)
				  );
					echo $this->Html->link(
					'<i class="fi-pencil large"></i> Edit Group',
					array(
						'controller' => 'groups',
						'action' => 'edit',
						$group['Group']['id'],
						'full_base' => true
					),
					array(
					  'class' => 'button',
					  'escape' => false
					)
				  );
					echo $this->Html->link(
					'<i class="fi-plus large"></i> Invite Member',
					array(
						'controller' => 'groups',
						'action' => 'invite',
						$group['Group']['id'],
						'full_base' => true
					),
					array(
					  'class' => 'button',
					  'escape' => false
					)
				  );	
				  echo $this->Html->link(
					'<i class="fi-calendar large"></i> Create Event',
					array(
						'controller' => 'events',
						'action' => 'create',
						$group['Group']['id'],
						'full_base' => true
					),
					array(
					  'class' => 'button',
					  'escape' => false
					)
				  );	
					echo $this->Form->postLink('<i class="fi-trash large"></i> Delete Group',
								array('action' => 'delete', $group['Group']['id'], 'admin' => false),
								array('confirm' => 'Are you sure ?',
								'data-placement'=>'left',
								'class'=> 'button alert',
								'escape'=>false
							));
					else:
						echo $this->Html->link(
						'<i class="fi-eye large"></i> View Group',
						array(
							'controller' => 'groups',
							'action' => 'view',
							$group['Group']['id'],
							'full_base' => true
						),
						array(
						  'class' => 'button',
						  'escape' => false
						)
					  );
						echo $this->Html->link(
						'<i class="fi-minus large"></i> Withdraw',
						array(
							'controller' => 'groups',
							'action' => 'withdraw',
							$group['Group']['id'],
							'full_base' => true
						),
						array(
						  'class' => 'button warning',
						  'escape' => false
						)
					  );
					endif;
			elseif ($isOwner || ($this->Session->read('Auth.User') && $this->Session->read('Auth.User.role') == 'admin')):
				echo $this->Html->link(
                '<i class="fi-eye large"></i> View Group',
                array(
                    'controller' => 'groups',
                    'action' => 'view',
                    $group['Group']['id'],
                    'full_base' => true
                ),
                array(
                  'class' => 'button',
                  'escape' => false
                )
              );
				echo $this->Html->link(
                '<i class="fi-pencil large"></i> Edit Group',
                array(
                    'controller' => 'groups',
                    'action' => 'edit',
                    $group['Group']['id'],
                    'full_base' => true
                ),
                array(
                  'class' => 'button',
                  'escape' => false
                )
              );
              	echo $this->Html->link(
                '<i class="fi-plus large"></i> Invite Member',
                array(
                    'controller' => 'groups',
                    'action' => 'invite',
                    $group['Group']['id'],
                    'full_base' => true
                ),
                array(
                  'class' => 'button',
                  'escape' => false
                )
              );	
			  echo $this->Html->link(
                '<i class="fi-calendar large"></i> Create Event',
                array(
                    'controller' => 'events',
                    'action' => 'create',
                    $group['Group']['id'],
                    'full_base' => true
                ),
                array(
                  'class' => 'button',
                  'escape' => false
                )
              );	
              	echo $this->Form->postLink('<i class="fi-trash large"></i> Delete Group',
			                array('action' => 'delete', $group['Group']['id'], 'admin' => false),
			                array('confirm' => 'Are you sure ?',
					        'data-placement'=>'left',
					        'class'=> 'button alert',
					        'escape'=>false
					    ));		
			elseif ($groupRequestSent):
				echo $this->Html->link(
                '<i class="fi-check large"></i> Group Request Pending',
                '#',
                array(
                  'class' => 'button disabled warning',
                  'escape' => false
                )
              );	

       		else:
       			echo $this->Html->link(
                '<i class="fi-plus large"></i> Request to join',
                array(
                    'controller' => 'groups',
                    'action' => 'requestGroup',
                    $group['Group']['id'],
                    'full_base' => true
                ),
                array(
                  'class' => 'button',
                  'escape' => false
                )
              );					
			endif ?>
			




		</div>
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
	<?php unset($groups); ?>
</div>