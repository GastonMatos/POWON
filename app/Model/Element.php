<?php 
class Element extends AppModel
{
	var $belongsTo =  array(
				'Profile' =>
                       array('className'  => 'Comment',
                             'conditions' => '',
                             'order'      => '',
                             'foreignKey' => 'profile_id'
                       ) );
} 
?>