<?php $this->set('title_for_layout', 'Create Announcement'); ?>
<header>
    <div class="row">
      <div class="large-12 columns">
        <h1><i class="fi-plus large"></i> Create Announcement</h1>
      </div>
    </div>
</header><br/>
<div class="row collapse">
	<div class="large-7 columns">	
		<?php echo $this->Form->create('Announcement');
				echo $this->Form->textarea('body', array( 'label' => 'Body', 'placeholder' => 'Write Announcement...', 'required')); ?><br/>
		<?php echo $this->Form->submit(
			'Create', 
			array('class' => 'button', 'title' => 'submit')
		); 
		$this->Form->End()?>
	</div>
</div>