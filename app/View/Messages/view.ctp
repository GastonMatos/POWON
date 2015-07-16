<table>
<tr>
<th>First Name</th>
<th></th>
<th>Message</th> 
<th>Date & Time</th>
</tr> 

<?php  foreach($Message as $msg): ?>

<tr>
<td><?php echo $msg['messages']['first_name'] ?></td>
<td align="left">says</td>
<td width="600px"><?php echo $msg['messages']['body']; ?></td>
<td><?php echo $msg['messages']['created']; ?></td>
<?php endforeach; ?>
</table><div class="row">
    <div class="large-11 columns">
      <div class="row collapse">
        <div class="small-10 columns">
        <?php  echo $this->Form->create('Message', array('action' => 'sendmsg'));
		echo $this->Form->input('body', array('label'=>false, 'placeholder'=>'Type your text here...'));
		echo $this->Form->hidden('id', array('value'=>$this->request->params['pass'][0]));
		?> 
		
		  
        </div>
        <div class="small-2 columns">
          <?php echo $this->Form->submit('Send Message', array('class' => 'button postfix')); ?>
        </div>
		<?php echo $this->Form->end(); ?>
      </div>
    </div>
  </div>
