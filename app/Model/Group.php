<?php

Class Group extends AppModel{
    
	var $hasAndBelongsToMany = array(	
        'User' => array(
            'joinTable' => 'users_groups',
            'className' => 'User',
            'foreignKey' => 'group_id',
            'associationForeignKey' => 'user_id'
        )
    );

    var $hasMany = 'Items';
	
	// var $hasMany = ('Items','Events');
	
}
?>