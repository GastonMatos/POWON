<div class="row">
 
<?php echo $this->Form->create('Registry', array('enctype' => 'multipart/form-data')); ?>
    <fieldset>
        <legend><?php echo __('Add item to registry'); ?></legend>
        <?php 
        echo $this->Form->hidden('user_id', array('value' => $this->Session->read('Auth.User.id')));
        echo $this->Form->input('name', array('label' => 'Name of the item'));
        echo $this->Form->input('price', array('type' => 'float'));
        echo $this->Form->input('description', array('label' => 'Description', 'type' => 'textarea'));
        echo $this->Form->input('upload', array('label' => 'Upload your item image', 'type' => 'file'));



        echo $this->Form->hidden('bought');
        echo $this->Form->hidden('bought_by');

        echo $this->Form->submit('Add item', array('class' => 'button',  'title' => 'Click here to add an item') ); 

?>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>