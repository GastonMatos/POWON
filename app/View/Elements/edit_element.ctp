<?php $this->set('title_for_layout', 'Edit Element'); ?>
<header>
    <div class="row">
      <div class="large-12 columns">
        <h1><i class="fi-pencil large"></i> Edit Element</h1>
      </div>
    </div>
</header><br/>
<div class="row collapse">
	<div class="large-7 columns">	
		<?php echo $this->Form->create('Element'); 
				echo $this->Form->input('Element.type');
				echo $this->Form->input('Element.value'); 
				echo $this->Form->input('Element.id', array('type' => 'hidden'));
                echo $this->Form->input('Element.profile_id', array('type' => 'hidden')); ?><br/> 
    		<?php echo $this->Form->submit(
                'Edit', 
                array('class' => 'button', 'title' => 'submit')
            ); ?>
        <?php echo $this->Form->End(); ?>
	</div>
</div>