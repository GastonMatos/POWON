<?php 

class Event extends AppModel
{
	var $belongTo = array(
		'Groupe' =>
			array(	'className'  => 'Event',
					'conditions' => '',
					'order'      => '',
					'foreignKey' => 'group_id'
                  )
         );
				 
	var $hasMany = 'Suggestions';
	
} ?>