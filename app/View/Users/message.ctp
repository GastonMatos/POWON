<table class="hoverTable">
<tr>
<th>First Name</th>
<th>Last Name</th> 
<th>Last Message</th>
<th>Date & Time</th>
<th><div><p><a id="newmessage" href=#sendnew><i class="fi-plus large"></i> New Conversation</a></p></div></th>
</tr> 
<?php  foreach($Conversation as $convo):   ?>
<?php var_dump($convo); ?>
<tr><td><?php echo $convo['users']['first_name'] ?></td>
<td><?php echo $convo['users']['last_name']; ?></td>
<td width="600px"><?php echo $convo['users_messages']['body']; ?></td>
<td width="300px"><?php echo $convo['users_messages']['created']?></td>
<td><div><p id="sendmsg"></i><?php echo $this->Html->link('Send Message',

array(
'controller' => 'users',

'action' => 'sendmessage',
$convo['users']['id'],
$convo['users_messages']['sender_id'],
'full_base' => true
),

array(
'escape' => false)
); ?></p></div></td>
</tr>

<?php endforeach; ?>
</table>
