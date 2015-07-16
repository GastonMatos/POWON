
<table>
<tr>
<th width="150px">First Name</th>
<th width="150px">Last Name</th> 
<th width="600px">Last Message Received</th>
<th width="300px">Date & Time</th>
<th><div><p><a id="newmessage" href="#" data-reveal-id="myModal"><i class="fi-plus large"></i> New Conversation</a></p></div></th>
</tr> 

<?php  foreach($Conversation as $convo): 

if((($convo['messages']['writer_id'])!= $this->Session->read('Auth.User.id'))): ?>
<?php if($convo['messages']['status']!=0) : ?>
<tr><td><?php echo $convo['messages']['first_name'] ?></td>
<td><?php echo $convo['messages']['last_name']; ?></td>
<td width="600px"><?php echo $convo['messages']['body']; ?></td>
<td width="300px"><?php echo $convo['messages']['created']; ?></td>
<td><div><p id="sendmsg"></i>
<?php echo $this->Html->link('Access Conversation',

array(
'controller' => 'messages',
'action' => 'view',
$convo['messages']['inbox_id'],
'full_base' => true
),

array(
'escape' => false)
); ?></p></div></td>
</tr>
<?php endif; ?>
<?php endif; ?>
<?php endforeach; ?>




</table>

<div id="myModal" class="reveal-modal" data-reveal>
					<h5> Select the member you wish to talk to </h5>
  <?php foreach ($Members as $user): ?>
	<div class="large-3 medium-3 text-center columns left">
		<div class="box">

			<?php
						echo $this->Html->link(
						    $this->Html->image($user['users']['image'],
							array("alt" => "Powon", 'class' => 'thumbnail')),
						    array(
						        'controller' => 'messages',
						        'action' => 'sendnew',
						        $user['users']['id'],
						        'admin' => false,
						        'plugin' => false
						    ),
						    array(
						    	'escape' => false,
						    	'class' => 'th'
						    )
						);
					?></div>
	
			<?php echo $user['users']['first_name'].' '.$user['users']['last_name']; ?>
	
	</div>

<?php endforeach ?>
</div>


