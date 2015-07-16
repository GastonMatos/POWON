<?php 

class Item extends AppModel
{
	var $belongsTo = array('User', 'Group');
	
	var $hasMany = array('Comments', 'Permissions');
} ?>