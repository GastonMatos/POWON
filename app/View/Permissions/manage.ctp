<?php 
    $permissionName = array('Hidden', 'View Only', 'View & Comment', 'View & Share', 'View, Comment & Share');
    // $labelClass = array('warning', 'success', 'alert');
?>
		<div class="row">	
			<div class="large-3 columns small-3">
				<?php
						echo $this->Html->link(
						    $this->Html->image($user_item['User']['image'], array('class' => 'thumbnail')),
						    array(
						        'controller' => 'profiles',
						        'action' => 'view',
						        $user_item['User']['id'],
						        'admin' => false,
						        'plugin' => false
						    ),
						    array(
						    	'escape' => false,
						    	'class' => 'th'
						    )
						);
					?>
			  </div>
			  <div class="large-9 columns">
				<strong><?php echo $user_item['User']['first_name'].' '.$user_item['User']['last_name']; ?></strong> <?php echo $item['Item']['description']; ?>
				<h3><small><i class="fi-clock large"></i> <?php echo $this->time->niceShort($item['Item']['created']); ?></small></h3>
				
				<?php 
				if($item['Item']['image'] != null): ?>
					<ul class="clearing-thumbs" data-clearing>
					  <li>
						<?php echo $this->Html->link(
									$this->Html->image($item['Item']['image'], array('class' => 'item')),
									'/img/'.$item['Item']['image'],
									array(
										'escape' => false,
										'class' => 'th item'
									)
								); ?>
					  </li>
					</ul>
				<?php endif; ?>
				
					<!-- START Comments -->
					<h6><?php echo count($item['Comments']).' Comment(s)' ; ?>

				</div>
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
				$currentPermission = $this->requestAction(array(
					'controller' => 'permissions',
					'action' => 'currentPermission',
					$user['User']['id'],
					$item['Item']['id']));
					?>
				
				<?php echo $this->Form->create('Permission', array('url' => 'manage/'.$item['Item']['id']));
					echo $this->Form->input('permission', array( 'onChange'=>'javascript:this.form.submit()', 'label' => false,
					'options' => array('0' => $permissionName[0], '1' => $permissionName[1], '2' => $permissionName[2], '3' => $permissionName[3], '4' => $permissionName[4],
												), 'selected'=> $currentPermission));
					 echo $this->Form->hidden('user_id', array('value' => $user['User']['id']));
					 echo $this->Form->hidden('item_id', array('value' => $item['Item']['id']));

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

