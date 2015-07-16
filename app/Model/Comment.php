<?php 
class Comment extends AppModel
{
	 var $belongsTo = array('Item', 'User');
	 /*
	 var $hasOne = array(
			'User' =>
                    array('className'    => 'User',
                          'conditions'   => '',
                          'order'        => '',
                          'dependent'    =>  true,
                          'foreignKey'   => 'user_id'
                    )
			);
			*/
} ?>