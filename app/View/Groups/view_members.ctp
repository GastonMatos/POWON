<header>

    <div class="row">
      <div class="large-12 columns">
        <h1>Group Members</h1>
        <h4><i class="fi-torso-business large"></i> Group Owner</h4>
                <div class ="box">
            	<?php echo $this->Html->link($this->Html->image($owner['User']['image'],
            		array("alt" => "Powon", 'class' => 'thumbnail')),
            		array(
            			'controller' => 'profiles',
            			'action' => 'view',
            			$owner['User']['id']),
            		array('escape' => false)
            	);
            	?>
            	</div>
            	<?php echo $owner['User']['first_name'].' '.$owner['User']['last_name']; ?>
            	<br /><br />

        <h4><i class="fi-torsos-all large"></i> <?php echo (count($users)); ?> Members have joined this group</h4>
      </div>
    </div>
</header>


<?php foreach ($users as $user): ?>
	<div class="large-3 medium-3 text-center columns">
		<div class="box">

						<?php if($owner['User']['id'] == $this->Session->read('Auth.User.id')): ?>
						<?php echo $this->Form->postLink(
						   '<i class="fi-x large"></i>',
						   array(
						   'controller' => 'groups',
						   'action' => 'remove_member',
						    $user['User']['id'],
						    $group['Group']['id'],  
					    	'full_base' => true
								 )
						   , 
						   array(
						'confirm' => 'Are you sure you wish to remove this member from the group?',
						'escape'=>false,
						'class' => 'button alert tiny right'
							 )
						   );
						   ?>
						<?php endif;?>

			<?php
						echo $this->Html->link(
						    $this->Html->image($user['User']['image'],
							array("alt" => "Powon", 'class' => 'thumbnail')),
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
	
	<?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?>
	
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
	<?php unset($users); ?>