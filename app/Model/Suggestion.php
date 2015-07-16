<?php 
class Suggestion extends AppModel
{
	var $belongsTo = 'Events';
	
	var $hasAndBelongsToMany = array(	
        'User' => array(
            'joinTable' => 'users_groups',
            'className' => 'User',
            'foreignKey' => 'suggestion_id',
            'associationForeignKey' => 'user_id'
        )
    );
		 
} 
?>