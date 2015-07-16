<?php 
    $statusName = array('Inactive', 'Active', 'Suspended');
    $labelClass = array('warning', 'success', 'alert');
?>

<h1>POWON Members</h1>
<?php echo $this->Html->link( "<i class='fi-plus large'></i> Add New",   array('action'=>'add'),array('class' => 'button', 'escape' => false) ); ?>
<table>
    <thead>
        <tr>
            
            <th><?php echo $this->Paginator->sort('first_name', 'First Name');?>  </th>
            <th><?php echo $this->Paginator->sort('last_name', 'Last Name');?>  </th>
            <th><?php echo $this->Paginator->sort('username', 'Username');?>  </th>
            <th><?php echo $this->Paginator->sort('created', 'Created');?></th>
            <th><?php echo $this->Paginator->sort('modified','Last Update');?></th>
            <th><?php echo $this->Paginator->sort('role','Role');?></th>
            <th><?php echo $this->Paginator->sort('status','Status');?></th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>                       
        <?php $count=0; ?>
        <?php foreach($users as $user): ?>                
        <?php $count ++;?>
        <?php if($count % 2): echo '<tr>'; else: echo '<tr class="zebra">' ?>
        <?php endif; ?>
            <td><?php echo $user['User']['first_name']; ?></td>
            <td><?php echo $user['User']['last_name']; ?></td>
            <td><?php echo $this->Html->link( $user['User']['username']  ,   array('action'=>'edit', $user['User']['id']),array('escape' => false) );?></td>
            <td><?php echo $this->Time->niceShort($user['User']['created']); ?></td>
            <td><?php echo $this->Time->niceShort($user['User']['modified']); ?></td>
            <td><?php echo $user['User']['role']; ?></td>
            <td class="text-center">

                <span class="label <?php echo $labelClass[$user['User']['status']]; ?>"> <?php echo $statusName[$user['User']['status']]; ?></span>

            </td>
            <td >
            <?php echo $this->Html->link(    "<i class='fi-eye large'></i> View Profile",   array('controller'=>'profiles', 'action'=>'view', $user['User']['id'], 'admin'=>false), array('class'=>'button tiny expand', 'escape' => false) ); ?>
            <?php echo $this->Html->link(    "<i class='fi-pencil large'></i> Edit",   array('action'=>'edit', $user['User']['id']) , array('class'=>'button tiny expand', 'escape' => false)); ?> 
            <?php
                if( $user['User']['status'] != 0){ 
                    echo $this->Html->link(    "Deactivate", array('action'=>'deactivate', $user['User']['id']), array('class'=>'button tiny expand warning', 'escape' => false));}
                    else{
                    echo $this->Html->link(    "Re-Activate", array('action'=>'activate', $user['User']['id']), array('class'=>'button tiny expand warning', 'escape' => false));
                    }
            ?>
            

            <?php 
                if( $user['User']['status'] != 2){ 
                    echo $this->Html->link( "Suspend", array('action' => 'suspend', $user['User']['id']), array('class'=>'button tiny expand alert'));
                }
                else{
                echo $this->Html->link(    "Unsuspend", array('action'=>'activate', $user['User']['id']), array('class'=>'button tiny expand alert'));
            }
            ?>
            <?php echo $this->Form->postLink('<i class="fi-trash large"></i> Delete Member',
                            array('action' => 'delete', $user['User']['id'], 'admin' => true),
                            array('confirm' => 'Are you sure ? All Items linked to this user will be deleted.',
                            'data-placement'=>'left',
                            'class'=> 'tiny expand button alert',
                            'escape'=>false
                        ));  ?>

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

