<header>
    <div class="row">
      <div class="large-12 columns">
        <h1>Items</h1>
      </div>
    </div>
</header>

<div class="grid_entry row" id="posts-list">
	

	<?php foreach ($items as $item): ?>
		<div class="panel post-item">
			<?php if($this->Session->read('Auth.User') && $this->Session->read('Auth.User.role') == 'admin'): ?>
					<p class='large-4 columns'>
			        	<?php echo $this->Html->link("<i class='fi-pencil large'></i> Edit Item", array('controller' => 'items', 'action' => 'edit', $item['Item']['id'], 'admin' => true),  array(
					        'data-placement'=>'left',
					        'escape'=>false
					    )); ?>
					</p>
					<p class='large-4 columns'>
			        	<?php echo $this->Html->link("<i class='fi-plus large'></i> Add Item", array('controller' => 'items', 'action' => 'add', 'admin' => true),  array(
					        'data-placement'=>'left',
					        'escape'=>false
					    )); ?>
					</p>
					<p class='large-4 columns'>
			        	<?php echo $this->Form->postLink('<i class="fi-minus large"></i> Delete Item',
			                array('action' => 'delete', $item['Item']['id'], 'admin' => true),
			                array('confirm' => 'Are you sure ?',
					        'data-placement'=>'left',
					        'escape'=>false
					    )); ?>
					</p>
					
			<?php endif; ?>
			<p class='panel callout collapse'><?php echo $item['Item']['body']; ?></p>
			<p class='panel'><i class="fi-clock large"></i> <?php echo $this->time->niceShort($item['Item']['created']); ?> by <?php echo $item['User']['username']; ?></p>
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
	<?php unset($items); ?>
</div>

