<?php 	
	class Profile extends AppModel {

		var $belongsTo = array(
				'User' =>
                       array('className'  => 'User',
                             'conditions' => '',
                             'order'      => '',
                             'foreignKey' => 'user_id'
                       )
				);
		
		
		var $hasMany = 'Elements';
} ?>