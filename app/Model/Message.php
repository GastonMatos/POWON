<?php 
class Message extends AppModel
{
	var $belongsTo = 'Inbox';
	
    var $hasOne = array(
					'User' =>
                    array('className'    => 'User',
                          'conditions'   => '',
                          'order'        => '',
                          'dependent'    =>  true,
                          'foreignKey'   => 'writer_id'
                    )
				);
} 
?>