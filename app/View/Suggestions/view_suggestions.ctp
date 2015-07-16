<header>
    <div class="row">
      <div class="large-12 columns">
        <h1>Events Voting</h1>
      </div>
    </div>
</header>

<div class="grid_entry row" id="posts-list">	



	<div class="panel post-item large-10 columns">

		<?php echo $this->Form->create('Suggestion', array('action' => 'vote')); ?>
			<?php foreach ($suggestions as $suggestion): ?>	
				
				<?php echo $this->Form->input('suggestion_id', array(
									 'div' => true,
									 'label' => true,
									 'type' => 'radio',
									 'legend' => false,
									 'options' =>
									 array($suggestion['suggestions']['id'] => $suggestion['suggestions']['option'])
									));
						
			endforeach ?>	


		<?php echo $this->Form->submit('Vote', 
		array('class' => 'button', array('action' => 'vote', $suggestion['suggestions']['id'], 
								'admin' => false),
							array(
							  'class' => 'button',
							  'escape' => false
							)));	?>	

	<?php echo $this->Form->End(); ?>

	</div>

	



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