<?php 	
	class Inbox extends AppModel {

		var $belongsTo = array(
				'User' =>
                       array('className'  => 'User',
                             'conditions' => '',
                             'order'      => '',
                             'foreignKey' => 'sender_id'
                       )
				);
		
	
		var $hasMany = 'Messages';
} ?>