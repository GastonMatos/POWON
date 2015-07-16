<?php 
    $permissionName = array('Hidden', 'Visible');
    // $labelClass = array('warning', 'success', 'alert');
?>
		<div class="row panel">	
				<h3>Element</h3>
				<p class="title"><strong><?php echo ucwords($element['Element']['type']); ?></strong>: <?php echo ucwords($element['Element']['value']); ?></p>
				<h3><small><i class="fi-clock large"></i> <?php echo $this->time->niceShort($element['Element']['created']); ?></small></h3>
		</div>
<br/>
<h2>Members from My Groups & Friends</h2>

<table class="large-12 columns text-center">
    <thead>
        <tr>
            
            <th><?php echo $this->Paginator->sort('first_name', 'First Name');?>  </th>
            <th><?php echo $this->Paginator->sort('last_name', 'Last Name');?>  </th>
            <th><?php echo $this->Paginator->sort('username', 'Username');?>  </th>
            <th><i class="fi-widget large"></i> Privacy Settings</th>
        </tr>
    </thead>
    <tbody>                       
      
        <?php foreach($users as $user): ?>                
        
            <td><?php echo $user['User']['first_name']; ?></td>
            <td><?php echo $user['User']['last_name']; ?></td>
            <td><?php echo $this->Html->link( $user['User']['username']  ,   array('controller'=>'profiles', 'action'=>'view', $user['User']['id']),array('escape' => false) );?></td>
			
            <td >
				<?php   
				$currentElementPermission = $this->requestAction(array(
					'controller' => 'permissions',
					'action' => 'currentElementPermission',
					$user['User']['id'],
					$element['Element']['id']));
					?>
				
				<?php echo $this->Form->create('Permission', array('url' => 'manageElement/'.$element['Element']['id']));
					echo $this->Form->input('permission', array( 'onChange'=>'javascript:this.form.submit()', 'label' => false,
					'options' => array('0' => $permissionName[0], '1' => $permissionName[1]
												), 'selected'=> $currentElementPermission));
					 echo $this->Form->hidden('user_id', array('value' => $user['User']['id']));
					 echo $this->Form->hidden('element_id', array('value' => $element['Element']['id']));

				 echo $this->Form->end();
				?>

            </td>
        </tr>
        <?php endforeach; ?>
        <?php unset($user); ?>
    </tbody>
</table>

<div class="large-12 columns text-center">
        <?php echo $this->Paginator->numbers(array(
                'before' => '<ul class="pagination">',
                'after' => '</ul>',
                'separator' => '',
                'tag' => 'li',
                'currentClass' => 'current',
                'first' => 'Première page',
                'last' => 'Dernière page',
                'currentTag' => 'a'
            ));
            //echo $this->Paginator->next('Load More...');
        ?>
</div>
<br/>                

