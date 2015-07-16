<header>
    <div class="row">
      <div class="large-12 columns">
        <h1>Announcements</h1>
        <h4><i class="fi-flag large"></i> Public Service Announcements </h4>
      </div>
    </div>
</header>
<h3>
			<?php if($this->Session->read('Auth.User') && $this->Session->read( 'Auth.User.role') == 'admin'): ?>
			        	<?php echo $this->Html->link("<i class='fi-plus large'></i> Add Announcement", array('controller' => 'announcements', 'action' => 'add', 'admin' => true),  array(
					        'data-placement'=>'left',
					        'escape'=>false
					    )); ?>
					</h3>
			<?php endif;?>

<div class="grid_entry row" id="posts-list">
	

	<?php foreach ($announcements as $announcement): ?>
		<div class="panel post-item">
			<?php if($this->Session->read('Auth.User') && $this->Session->read('Auth.User.role') == 'admin'): ?>
					<?php echo $this->Html->link(
		                '<i class="fi-pencil large"></i> Edit Announcement',
		                array(
		                    'controller' => 'announcements',
		                    'action' => 'edit',
		                    $announcement['Announcement']['id'],
		                    'admin' => true,
		                    'full_base' => true
		                ),
		                array(
		                  'class' => 'button',
		                  'escape' => false
		                )
		              );	
		              	echo $this->Form->postLink('<i class="fi-minus large"></i> Delete Announcement',
					                array('action' => 'delete', $announcement['Announcement']['id'], 'admin' => true),
					                array('confirm' => 'Are you sure ?',
							        'data-placement'=>'left',
							        'class'=> 'button alert',
							        'escape'=>false
							    )); ?>
					
			<?php endif; ?>
			<p class=''><?php echo $announcement['Announcement']['body']; ?></p>
			<p class=''><i class="fi-clock large"></i> <?php echo $this->time->niceShort($announcement['Announcement']['created']); ?> by <?php echo $announcement['User']['username']; ?></p>
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
	<?php unset($announcements); ?>
</div>

