	<br>
<?php if (empty($friends)): ?> 
<h3><?php echo 'You have no users in this category'; ?></h3>
<?php endif; ?>
<div class="grid_entry row" id="posts-list">	
	<?php foreach ($friends as $friend): ?>
		<div class="large-3 medium-3 text-center columns post-item">
			<div class="box">
				<?php
							echo $this->Html->link(
							    $this->Html->image($friend['User']['image'], array("alt" => "Powon", 'class' => 'thumbnail')),
							    array(
							        'controller' => 'profiles',
							        'action' => 'view',
							        $friend['User']['id'],
							        'admin' => false,
							        'plugin' => false
							    ),
							    array(
							    	'escape' => false,
							    	'class' => 'th'
							    )
							);
						?></div>
		
		<?php echo $friend['User']['first_name'].' '.$friend['User']['last_name']; ?>
		
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
	<?php unset($friends); ?>
</div>