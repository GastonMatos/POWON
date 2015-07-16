<header>
    <div class="row">
      <div class="large-12 columns">
        <h1><i class="fi-torso large"></i> Edit Profile</h1>
      </div>
    </div>
</header><br>
<h3>Create Element</h3>
 <?php echo $this->Form->create('Element', array('action' => 'create')); 
			echo $this->Form->input('Element.type', array('required', 'class' => 'large-5')); 
			echo $this->Form->input('Element.value', array('class' => 'large-5'));
			echo $this->Form->input('Element.profile_id', array('type' => 'hidden', 'value' => $profile_id, 'class' => 'large-5'));
			echo $this->Form->submit('Create Element', array('class' => 'button tiny large-2', 'title' => 'submit'));
		echo $this->Form->End(); ?>
		
<div class="grid_entry row" id="posts-list">
	<?php foreach ($elements as $element): ?>
		<div class="panel post-item">
			<p class="title"><strong><?php echo ucwords($element['Elements']['type']); ?></strong>: <?php echo ucwords($element['Elements']['value']); ?></p>
			<?php
				echo $this->Html->link(
					'<i class="fi-pencil large"></i> Edit Element',
					array(
						'controller' => 'elements',
						'action' => 'editElement',
						$element['Elements']['id'],
						'full_base' => true
					),
					array(
					  'class' => 'button tiny',
					  'escape' => false
					)
				  );
				  echo $this->Html->link(
					'<i class="fi-widget large"></i> Manage Permissions',
					array(
						'controller' => 'permissions',
						'action' => 'manageElement',
						$element['Elements']['id'],
						'full_base' => true
					),
					array(
					  'class' => 'button tiny',
					  'escape' => false
					)
				  );
				  echo $this->Form->postLink('<i class="fi-trash large"></i> Delete Element',
								array('action' => 'delete', $element['Elements']['id'], 'admin' => false),
								array('confirm' => 'Are you sure ?',
								'data-placement'=>'left',
								'class'=> 'button tiny alert',
								'escape'=>false
							));
			?>
		</div>
	<?php endforeach; ?>
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
	<?php unset($elements); ?>
</div>