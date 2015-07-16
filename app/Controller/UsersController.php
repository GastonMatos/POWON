<?php class UsersController extends AppController {
 
    public $paginate = array(
        'limit' => 25,
        'conditions' => array('status' => '1'),
        'order' => array('User.username' => 'asc' ) 
    );
     
    public function beforeFilter() {
        parent::beforeFilter();
        if($this->Auth->user('role')=='admin'){
                $this->Auth->allow('admin_edit','admin_add', 'admin_logout', 'admin_index');//put your all admin actions separated by comma
        }
        else
        {
                $this->Auth->allow('login','register'); //put your all non-admin actions separated by comma
        }
        $this->Auth->userScope = array('User.status' => array(0, 1));
         
    }
    

    public function admin_add() {
        if ($this->request->is('post')) {
            
            $this->User->create();    
            //Check if image has been uploaded
            if(!empty($this->request->data['User']['upload']['name']))
            {
                    $file = $this->request->data['User']['upload']; //put the data into a var for easy use

                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                    $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
                    $random = substr(number_format(time() * mt_rand(),0,'',''),0,10); //Random number

                    //only process if the extension is valid
                    if(in_array($ext, $arr_ext))
                    {
                            //do the actual uploading of the file. First arg is the tmp name, second arg is 
                            //where we are putting it
                            move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/uploads/users/' . $random . '_'. $file['name']);

                            //prepare the filename for database entry
                            $this->request->data['User']['image'] = 'uploads/users/' . $random . '_'. $file['name'];
                    }
            }


            if (!empty($this->request->data)) {
                // We can save the User data:
                // it should be in $this->request->data['User']

                $user = $this->User->save($this->request->data);

                // If the user was saved, Now we add this information to the data
                // and save the Profile.

                if (!empty($user)) {
                    // The ID of the newly created user has been set
                    // as $this->User->id.
                    $this->request->data['Profile']['user_id'] = $this->User->id;
                    $this->request->data['Inbox']['user_id'] = $this->User->id;

                    // Because our User hasOne Profile, we can access
                    // the Profile model through the User model:
                    $this->User->Profile->save($this->request->data);

                    $this->Session->setFlash('The user has been created.', 'good');
                    $this->redirect(array('controller'=>'profiles', 'action'=>'index', 'admin' => false));
                }
                else{
                    $this->Session->setFlash('The user could not be saved.', 'bad');
                }
            }
            else{
                $this->Session->setFlash('The user could not be saved.', 'bad');
            }
            
        }
    }

    public function add() {
        if ($this->request->is('post')) {
            
            $this->User->create();    
            //Check if image has been uploaded
            if(!empty($this->request->data['User']['upload']['name']))
            {
                    $file = $this->request->data['User']['upload']; //put the data into a var for easy use

                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                    $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
                    $random = substr(number_format(time() * mt_rand(),0,'',''),0,10); //Random number

                    //only process if the extension is valid
                    if(in_array($ext, $arr_ext))
                    {
                            //do the actual uploading of the file. First arg is the tmp name, second arg is 
                            //where we are putting it
                            move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/uploads/users/' . $random . '_'. $file['name']);

                            //prepare the filename for database entry
                            $this->request->data['User']['image'] = 'uploads/users/' . $random . '_'. $file['name'];
                    }
            }


            if (!empty($this->request->data)) {
                // We can save the User data:
                // it should be in $this->request->data['User']

                $user = $this->User->save($this->request->data);

                // If the user was saved, Now we add this information to the data
                // and save the Profile.

                if (!empty($user)) {
                    // The ID of the newly created user has been set
                    // as $this->User->id.
                    $this->request->data['Profile']['user_id'] = $this->User->id;

                    // Because our User hasOne Profile, we can access
                    // the Profile model through the User model:
                    $this->User->Profile->save($this->request->data);

                    $this->Session->setFlash('The user has been created.', 'good');
                    $this->redirect(array('controller'=>'profiles', 'action'=>'index'));
                }
                else{
                    $this->Session->setFlash('The user could not be saved.', 'bad');
                }
            }
            else{
                $this->Session->setFlash('The user could not be saved.', 'bad');
            }
            
        }
    }
 
 
    public function login() {
         
        //if already logged-in, redirect
        if($this->Session->check('Auth.User')){
            $this->redirect(array('controller' => 'pages', 'action' => 'home'));      
        }

        // if we get the post information, try to authenticate
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
				$user_id = $this->Session->read('Auth.User.id');
				$this->loadModel('User');
				$status = $this->User->find('all',
						array(
						//tableau de conditions
						'conditions' => array('User.id' => $user_id)
							));
				
				if($status[0]['User']['status']==1){
                $this->Session->setFlash(__('Welcome, '. $this->Auth->user('username')), 'good');
                $this->redirect($this->Auth->redirectUrl());				
				
				} 
				else if($status[0]['User']['status']==0){  
                $this->Session->setFlash(__('Your account is inactive'), 'good');
				$this->redirect($this->Auth->redirectUrl());
				
				 }
				else if($status[0]['User']['status']==2){  
                $this->Session->setFlash(__('Your account is suspended'), 'bad');
				$this->redirect($this->Auth->logout());
				 }
				else{
                $this->Session->setFlash(__('Welcome, '. $this->Auth->user('username')), 'good');
                $this->redirect($this->Auth->redirectUrl());
				}
            } else {
                $this->Session->setFlash(__('Invalid username or password'), 'bad');
            }
        } 

	 
    }

    public function admin_login() {
         
        //if already logged-in, redirect
        if($this->Session->check('Auth.User')){
            $this->redirect(array('action' => 'index'));      
        }
         
        // if we get the post information, try to authenticate
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->Session->setFlash(__('Welcome, '. $this->Auth->user('username')), 'good');
                $this->redirect(array('controller' => 'pages', 'action' => 'home', 'admin' => false));
            } else {
                $this->Session->setFlash(__('Invalid username or password'), 'bad');
            }
        } 
    }
 
    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    public function admin_logout() {
        $this->redirect($this->Auth->logout());
    }
 
    public function admin_index() {
        $this->paginate = array(
            'limit' => 6,
            'order' => array('User.username' => 'asc' )
        );
        $users = $this->paginate('User');
        $this->set(compact('users'));
    }
 
 
    public function register() {
        if ($this->request->is('post')) {
            
            $this->User->create();    
            //Check if image has been uploaded
            if(!empty($this->request->data['User']['upload']['name']))
            {
                    $file = $this->request->data['User']['upload']; //put the data into a var for easy use

                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                    $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
                    $random = substr(number_format(time() * mt_rand(),0,'',''),0,10); //Random number

                    //only process if the extension is valid
                    if(in_array($ext, $arr_ext))
                    {
                            //do the actual uploading of the file. First arg is the tmp name, second arg is 
                            //where we are putting it
                            move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/uploads/users/' . $random . '_'. $file['name']);

                            //prepare the filename for database entry
                            $this->request->data['User']['image'] = 'uploads/users/' . $random . '_'. $file['name'];
                    }
            }


            if (!empty($this->request->data)) {
                // We can save the User data:
                // it should be in $this->request->data['User']

                $user = $this->User->save($this->request->data);

                // If the user was saved, Now we add this information to the data
                // and save the Profile.

                if (!empty($user)) {
                    // The ID of the newly created user has been set
                    // as $this->User->id.
                    $this->request->data['Profile']['user_id'] = $this->User->id;
					
                    // Because our User hasOne Profile, we can access
                    // the Profile model through the User model:
                    $this->User->Profile->save($this->request->data);
					
                    $this->Session->setFlash('The user has been created.', 'good');
                    $this->redirect(array('controller'=>'profiles', 'action'=>'index'));
					}
                else{
                    $this->Session->setFlash('The user could not be saved.', 'bad');
                }
            }
            else{
                $this->Session->setFlash('The user could not be saved.', 'bad');
            }
            
        }
    }
 
    public function edit($id = null) {
            
            if (!$id) {
                //$this->Session->setFlash('Please provide a user id');
                $this->redirect(array('controller' => 'profiles', 'action'=>'index'));
            }
			if ($this->Session->read('Auth.User.id') != $id) {
                $this->redirect(array('controller' => 'profiles', 'action'=>'index'));
            }
            
            $user = $this->User->findById($id);
            if (!$user) {
                $this->Session->setFlash('Invalid User ID Provided');
                $this->redirect(array('action'=>'index'));
            }
 
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->User->id = $id;


                //Check if image has been uploaded         
                if(!empty($this->request->data['User']['upload']['name']))
                {
                    
                        $file = $this->request->data['User']['upload']; //put the data into a var for easy use

                        $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                        $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
                        $random = substr(number_format(time() * mt_rand(),0,'',''),0,10); //Random number

                        //only process if the extension is valid
                        if(in_array($ext, $arr_ext))
                        {
                                //do the actual uploading of the file. First arg is the tmp name, second arg is 
                                //where we are putting it
                                move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/uploads/users/' . $random . '_'. $file['name']);

                                //prepare the filename for database entry
                                $this->request->data['User']['image'] = 'uploads/users/' . $random . '_'. $file['name'];
                                
                        }
                }						
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('The user has been updated'), 'good');
                    $this->redirect(array('controller' => 'users', 'action' => 'edit'));
                }else{
                    $this->Session->setFlash(__('Unable to update your profile.'), 'bad');
                }
            }
 
            if (!$this->request->data) {
                $this->request->data = $user;
            }
    }

    public function admin_edit($id = null) {
 
            if (!$id) {
                $this->Session->setFlash('Please provide a user id');
                $this->redirect(array('action'=>'index'));
            }
 
            $user = $this->User->findById($id);
            if (!$user) {
                $this->Session->setFlash('Invalid User ID Provided','bad');
                $this->redirect(array('action'=>'index'));
            }
 
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->User->id = $id;
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('The user has been updated'));
                    $this->redirect(array('action' => 'edit', $id));
                }else{
                    $this->Session->setFlash(__('Unable to update your user.'));
                }
            }
 
            if (!$this->request->data) {
                $this->request->data = $user;
            }
    }
 
    public function admin_delete($id = null) {
         
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        if ($this->User->delete($id)) {
            $this->Session->setFlash("The User with id : $id has been deleted.", 'good');
            return $this->redirect(array('action' => 'index', 'admin' => true));
        }
    }

    public function admin_suspend($id = null) {
         
        if (!$id) {
            $this->Session->setFlash('Please provide a user id');
            $this->redirect(array('action'=>'index'));
        }
         
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->Session->setFlash('Invalid user id provided');
            $this->redirect(array('action'=>'index'));
        }
        if ($this->User->saveField('status', 2)) {
            $this->Session->setFlash(__('User suspended'), 'good');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not suspended'));
        $this->redirect(array('action' => 'index'));
    }
     
    public function admin_activate($id = null) {
         
        if (!$id) {
            $this->Session->setFlash('Please provide a user id','bad');
            $this->redirect(array('action'=>'index'));
        }
         
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->Session->setFlash('Invalid user id provided','bad');
            $this->redirect(array('action'=>'index'));
        }
        if ($this->User->saveField('status', 1)) {
            $this->Session->setFlash(__('User re-activated'),'good');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not re-activated'),'bad');
        $this->redirect(array('action' => 'index'));
    }
	
	 public function admin_deactivate($id = null) {
         
        if (!$id) {
            $this->Session->setFlash('Please provide a user id','bad');
            $this->redirect(array('action'=>'index'));
        }
         
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->Session->setFlash('Invalid user id provided','bad');
            $this->redirect(array('action'=>'index'));
        }
        if ($this->User->saveField('status', 0)) {
            $this->Session->setFlash(__('User deactivated'),'good');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deactivated'),'bad');
        $this->redirect(array('action' => 'index'));
    }
	
	public function sendFriendRequest($friend_id, $user_id){
        $to = $this->User->findById($friend_id);
        if($this->request->data){
            $category = $this->request->data['Choose Relationship'];
            $query = "INSERT INTO `mfc353_2`.`users_friends` (`approved`, `user_id`, `friend_id`, `category`) VALUES ('0', $user_id, $friend_id, \"$category\")";
            if (!$this->User->Friend->query($query)){
                $this->Session->setFlash(__('Friend Request Sent!'), 'good');
                $this->redirect(array('controller'=>'profiles', 'action'=>'view', $user_id));
            }
            else{
                $this->Session->setFlash(__('Your Friend Request couldn\'t be sent.'), 'bad');
                $this->redirect(array('controller'=>'profiles', 'action'=>'view', $user_id));
            }
		}
        $this->set('to', $to);
	}
	
	public function requestsHasBeenSent($user_id, $friend_id){
		$query = "SELECT `friend_id` FROM `mfc353_2`.`users_friends` WHERE `user_id` = $user_id AND `approved` = 0 AND `friend_id` = $friend_id
                    UNION
                    SELECT `friend_id` FROM `mfc353_2`.`users_friends` WHERE `user_id` = $friend_id AND `approved` = 0 AND `friend_id` = $user_id";

        $user = $this->User->Friend->query($query);
        if(!empty($user)){
            return true;
        }
        else{
            return false;
        }
	}

    public function isFriend($user_id, $friend_id){
        $query = "SELECT `friend_id` FROM `mfc353_2`.`users_friends` WHERE `user_id` = $user_id AND `approved` = 1 AND `friend_id` = $friend_id
                    UNION
                SELECT `friend_id` FROM `mfc353_2`.`users_friends` WHERE `user_id` = $friend_id AND `approved` = 1 AND `friend_id` = $user_id";

        $user = $this->User->Friend->query($query);
        if(!empty($user)){
            return true;
        }
        else{
            return false;
        }
    }

    function isAuthorized() {
        if (!empty($this->params['prefix']) && $this->params['prefix'] == 'admin') {
            if ($this->Auth->user('role') != 'admin') {
                return false;
            }
        }
        return true;
    }
	
	public function isActive($user_id){
       $query = "SELECT `id` FROM `mfc353_2`.`users` WHERE `status` = 1";
	   $user = $this->User->query($query);
        if(!empty($user)){
            return true;
        }
        else{
            return false;
        }

	}
 
	public function message() {
		$this->loadModel('User');
		$user_id = $this->Session->read('Auth.User.id');
		$conversation_query = "SELECT users.first_name,users.last_name, users_messages.body,users_messages.created,users.id,users_messages.sender_id
FROM `mfc353_2`.`users`  
INNER JOIN mfc353_2.users_messages
ON users.id=users_messages.receiver_id
where users_messages.id IN

(SELECT `id` FROM `mfc353_2`.`users_messages` WHERE `sender_id` = $user_id and created IN(

SELECT max(created)from mfc353_2.users_messages group by receiver_id))";
		$conversations = $this->User->Message->query($conversation_query);
		$this->set('Conversation', $conversations);
	}
	
	public function findUser($user_id){
		$user = $this->User->find('all',
            array(
                //tableau de conditions
                'conditions' => array('User.id' => $user_id)
            ));
		return $user[0];
	}
} ?>