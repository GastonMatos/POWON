<header>
    <div class="row">
      <div class="large-12 columns">
        <h1>Groups I belong to </h1>
        <h3>
        	<?php echo $this->Html->link("<i class='fi-plus large'></i> Create New Group", array('controller' => 'groups', 'action' => 'create', 'admin' => false),  array(
		        'data-placement'=>'left',
		        'escape'=>false
		    )); ?>
		</h3>
      </div>
    </div>
</header>

	
<h3> You are member in these groups</h3>
	<?php foreach ($groups2 as $group2): ?>
		<div class="panel post-item">

					<div class="large-12 medium-12 columns space">
						
				        	<?php echo $this->Html->link("<i class='fi-pencil large'></i> Withdraw from this Group", 
							array('controller' => 'groups', 
								'action' => 'withdraw', $group2['Group']['id'], 'admin' => false),  
				                array('confirm' => 'Are you sure ?',
						        'data-placement'=>'left',
						        'escape'=>false
						    )); ?>
					</div>

					
					<div class="large-4 medium-4 columns">

						<?php
									echo $this->Html->link(
									    $this->Html->image($group2['Group']['image'], array("alt" => "Group", 'class' => 'thumbnail')),
									    array(
									        'controller' => 'groups',
									        'action' => 'view',
									        $group2['Group']['id'],
									        'admin' => false,
									        'plugin' => false
									    ),
									    array(
									    	'escape' => false,
									    	'class' => 'th'
									    )
									);
					?></div>
					<h1 class="large-8 medium-8 columns"><?php echo $this->Html->link(
					"<i class='fi-torsos-all large'></i> ". $group2['Group']['name'], 
					array('controller' => 'groups', 'action' => 'view', $group2['Group']['id'], 'admin' => false),  array(
					        'data-placement'=>'left',
					        'escape'=>false
					    )); ?></h1>
					<p><i class="fi-clock large"></i> Created <?php echo $this->time->niceShort($group3['Group']['created']); ?>
						
			
					<div class='collapse'>
						<h3>Description</h3>
						<?php echo $group2['Group']['description']; ?>
					</div>
			
		</div>
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
	<?php unset($groups); ?>
</div>

