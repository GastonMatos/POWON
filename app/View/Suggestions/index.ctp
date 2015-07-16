<header>
    <div class="row">
      <div class="large-12 columns">
        <h1><i class="fi-torsos-all large"></i> Voting</h1>
      </div>
    </div>
</header>

<h3>
	<?php echo $this->Html->link("<i class='fi-plus large'></i> Add Option",
					array(
						'controller' => 'suggestions',
						'action' => 'create',
						$this->request->params['pass'][0], 
						'full_base' => true
					),
					array(
					        'data-placement'=>'left',
					        'escape'=>false
					    )); ?>
					</h3>
<div class="grid_entry row" id="posts-list">
	
		<?php $number=1;?>
	<?php foreach ($suggestions as $suggestion): ?>			

		<div class="panel post-item large-10 columns">
		
			<h4 class=''><?php echo 'Option '.$number.': '.$suggestion['suggestions']['option']; ?></h4>
			
			
			<?php			

					echo $this->Form->postLink('<i class="fi-trash medium"></i> Delete This Option',
								array('action' => 'delete', $suggestion['suggestions']['id'], 
								$this->request->params['pass'][0], 
								'admin' => false),
								array('confirm' => 'Are you sure ?',
								'data-placement'=>'left',
								'class'=> 'button alert',
								'escape'=>false
							));		
							
					echo $this->Form->postLink('<i class="fi-eye+
					medium"></i> See Statistics',
								array('action' => 'see', $suggestion['suggestions']['id'], 
								$this->request->params['pass'][0], 
								'admin' => false),
							array(
							  'class' => 'button',
							  'escape' => false
							));									
					?>


		</div>

	<?php $number++; ?>
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