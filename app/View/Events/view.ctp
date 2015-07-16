<header>
    <div class="row">
      <div class="large-12 columns">
        <h1><i class="fi-torsos-all large"></i> Group Events</h1>
      </div>
    </div>
</header>
<h3>
			        	<?php echo $this->Html->link("<i class='fi-plus large'></i> Create Event", 
						array('controller' => 'events', 
						'action' => 'create', $this->request->params['pass'][0], 'admin' => false),  array(
					        'data-placement'=>'left',
					        'escape'=>false
					    )); ?>
					</h3>

<div class="grid_entry row" id="posts-list">
	

	<?php foreach ($events as $event): ?>			
			
		<div class="panel post-item large-10 columns">
		
			<h2 class=''><?php echo $event['Event']['name']; ?></h2>
			<h2 class=''><?php echo 'Place: '.$event['Event']['place']; ?></h2>
			<h4 class=''><i class="fi-clock large"></i> 
						<?php echo 'Date:'.$event['Event']['date'].' '.$event['Event']['time']; ?></h4>
			<p class=''><?php echo $event['Event']['description']; ?></p>


			<?php 
				
					echo $this->Html->link(
					'<i class="fi-pencil large"></i> Edit Event',
					array(
						'controller' => 'events',
						'action' => 'edit',
						$event['Event']['id'],
						$this->request->params['pass'][0],
						'full_base' => true
					),
					array(
					  'class' => 'button',
					  'escape' => false
					)
				  );
		
					echo $this->Form->postLink('<i class="fi-trash large"></i> Delete Event',
								array('action' => 'delete', $event['Event']['id'], $this->request->params['pass'][0], 'admin' => false),
								array('confirm' => 'Are you sure ?',
								'data-placement'=>'left',
								'class'=> 'button alert',
								'escape'=>false
							)); ?>
					<br/>		
			<?php		  
				  	echo $this->Html->link(
					'<i class="fi-calendar large"></i> Manage Voting',
					array(
						'controller' => 'suggestions',
						'action' => 'index',
						$event['Event']['id'],
						'full_base' => true
					),
					array(
					  'class' => 'button',
					  'escape' => false
					)
				  );  
			?>

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
	<?php unset($events); ?>
</div>