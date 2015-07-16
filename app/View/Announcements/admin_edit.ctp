<?php $this->set('title_for_layout', 'Edit Announcement'); ?>
<header>
    <div class="row">
      <div class="large-12 columns">
        <h1><i class="fi-pencil large"></i> Edit Announcement</h1>
      </div>
    </div>
</header><br/>
<div class="row collapse">
	<div class="large-7 columns">	
		<?php echo $this->Form->create('Announcement'); 
				echo $this->Form->textarea('Announcement.body', array( 'label' => false),array( 'language'=>'fr'), 'full'); 
				echo $this->Form->input('Announcement.id', array('type' => 'hidden'));
                echo $this->Form->input('Announcement.user_id', array('type' => 'hidden')); ?><br/> 
    		<?php echo $this->Form->submit(
                'Edit', 
                array('class' => 'button', 'title' => 'submit')
            ); ?>
        <?php echo $this->Form->End(); ?>
	</div>
</div>