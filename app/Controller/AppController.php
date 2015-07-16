<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	var $helpers = array('Time', 'Text');

	public $components = array(
	    'Session',
	    'Auth' => array(
	    	'Form' => array(
		        'fields' => array('username' => 'username', 'password' => 'password'),
		        'scope' => array('User.status' => true)
		    ),
	        'loginRedirect' => array('controller' => 'pages', 'action' => 'home', 'admin' => false),
	        'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
	        'authError' => 'You must be logged in to view this page.',
	        'loginError' => array('Invalid Username or Password entered, please try again.', 'warning'),
			'authorize' => 'Controller'
	 
	    ));
	 
	function flatten($arraysList) {
		$arraysId = array();
		foreach ($arraysList as $arrayList) {
			foreach ($arrayList as $key => $values) {
				foreach ($values as $key => $value) {
					array_push($arraysId, $value);
				}
			}
		}
		return $arraysId;
	}
	
	// only allow the login controllers only
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->userScope = array('User.status' => 1);
	    $this->Auth->allow('login');
    	$this->Auth->fields = array(
            'username' => 'username',
            'password' => 'password'
        );
	
										/* 
										if($this->Auth->user()){
										$userid = $this->Session->read('Auth.User.id');	
										
										$this->loadModel('Inbox');
										$notifquery="SELECT
													(SELECT SUM(sender_read) FROM mfc353_2.inboxes WHERE sender_id=$userid)
													+
													(SELECT SUM(receiver_read) FROM mfc353_2.inboxes WHERE receiver_id=$userid)
													as SumCount";
										$notif=$this->Inbox->query($notifquery);
										
										$notifications=$notif[0][0]['SumCount'];
											if($notifications!=0){
											if($notifications=1)
											$notification="You have $notifications unread message in your inbox!";
											else
											$notification="You have $notifications unread messages in your inbox!";
											$this->Session->setFlash(__($notification), 'good');
											}
										}
										*/
	}
	
	function isAuthorized() {
    if (!empty($this->params['prefix']) && $this->params['prefix'] == 'admin') {
        if ($this->Auth->user('role') != 'admin') {
            return false;
        }
    }
    return true;
}
	 
	
}
