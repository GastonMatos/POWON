<header>
    <div class="row">
      <div class="large-12 columns">
        <h1>Events Voting</h1>

      </div>
    </div>
</header>







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