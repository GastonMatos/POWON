<?php 	class Registry extends AppModel {


		var $belongTo =array(	
				'User' => array(
						'joinTable' => 'users_friends',
						'className' => 'User',
						'foreignKey' => 'owner_id'));
						

		 
} ?>