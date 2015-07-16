<header>
    <div class="row">
      <div class="large-12 columns">
        <h1>Group Events</h1>
        <h4><i class="fi-calendar large"></i> <?php echo (count($events) ); ?> Events</h4>
      </div>
    </div>
</header>

<?php foreach ($events as $event): ?>

		<?php 
			$hasVote = $this->requestAction(array(
				'controller' => 'events',
				'action' => 'hasVote',
				$event['events']['id']));

		?>
 

		<div class="panel post-item large-10 columns">
   <?php if($hasVote):?>
	<h3>
	<?php echo $event['events']['name']; ?><br/><br/><br/>	</h3>
	<h4><?php echo $event['events']['date'].' '.$event['events']['time']; ?><br/><br/>
	<?php echo 'Meets at '.$event['events']['place']; ?>	<br/><br/>
	<?php echo $event['events']['description']; ?></h4>	
				  <h5 class="title">
				  
					<?php echo $this->Html->link(
						    '<i class="fi-calendar large"></i> There is voting for this events',
						    array(
						        'controller' => 'suggestions',
						        'action' => 'view_suggestions',
								$event['events']['id'],
						        'admin' => false,
						        'plugin' => false
						    ),
						    array(
						    	'escape' => false
						    )
						); ?>
				  </h5>	


	<?php else:?>
	<h3>
	<?php echo $event['events']['name']; ?><br/><br/><br/>	</h3>
	<h4><?php echo $event['events']['date'].' '.$event['events']['time']; ?><br/><br/>
	<?php echo 'Meets at '.$event['events']['place']; ?>	<br/><br/>
	<?php echo $event['events']['description']; ?></h4>	
	
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
		 		'first' => 'Premi¨¨re page',
		 		'last' => 'Derni¨¨re page',
		 		'currentTag' => 'a'
			)); */
	        echo $this->Paginator->next('Load More...');
		?>
	</div>
	<?php unset($users); ?>