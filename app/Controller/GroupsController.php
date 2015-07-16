<?php class GroupsController extends AppController {

	public $components = array('Paginator');
	
	public $paginate = array(
        'limit' => 5,
        'order' => array(
            'Group.created' => 'DESC'
        )
    );
	
	public function beforeFilter() {
		parent::beforeFilter();
	    $this->Auth->allow('index');
	}
	
	public function index(){
	
		if($this->request->data){
		$category=$this->request->data['Group']['category'];
		
		$groups = $this->Group->find('all', array(
		    'order' => array('Group.created DESC'), 
			'conditions' => array('Group.category' => $category)));
	
		}
		else{
		/*$query = 	"SELECT `id` FROM `mfc353_2`.`groups` 
					WHERE `friend_id` = $user_id AND `approved` = 0";
		
		$groups  = $this->Group->query($query);
		*/
		$this->Paginator->settings = $this->paginate;
		$groups = $this->Paginator->paginate('Group');
		}
	   
	   

	    if ( isset($this->params['requested']) && $this->params['requested'] == 1){
	    	return $groups;
	    }
	    else{
	    	$this->set('groups', $groups);
	    }
		
	}
	public function Category($category){
				$groups = $this->Group->find('all', array(
		    'order' => array('Group.created DESC')
		));
		$this->Paginator->settings = $this->paginate;

	    // similaire à un findAll(), mais récupère les résultats paginés
	    $groups = $this->Paginator->paginate('Group');

	    if ( isset($this->params['requested']) && $this->params['requested'] == 1){
	    	return $groups;
	    }
	    else{
	    	$this->set('groups', $groups);
	    }
	}

	
	
	
	
	public function create(){
		if ($this->request->is('post')) {
            
            $this->Group->create();    
            //Check if image has been uploaded
            if(!empty($this->request->data['Group']['upload']['name']))
            {
                    $file = $this->request->data['Group']['upload']; //put the data into a var for easy use

                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                    $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
                    $random = substr(number_format(time() * mt_rand(),0,'',''),0,10); //Random number

                    //only process if the extension is valid
                    if(in_array($ext, $arr_ext))
                    {
                            //do the actual uploading of the file. First arg is the tmp name, second arg is 
                            //where we are putting it
                            move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/uploads/groups/' . $random . '_'. $file['name']);

                            //prepare the filename for database entry
                            $this->request->data['Group']['image'] = 'uploads/groups/' . $random . '_'. $file['name'];
                    }
            }
			if (!empty($this->request->data)) {
                $this->loadModel('User');
                // it should be in $this->request->data['User']

                // If the user was saved, Now we add this information to the data
                // and save the Profile.

                if ($this->Group->save($this->request->data)) {
                    $this->Session->setFlash('The group has been created.', 'good');
                    $this->redirect(array('controller'=>'groups', 'action'=>'index'));
				}
                else{
                    $this->Session->setFlash('The group could not be saved.', 'bad');
                }
            }
            else{
                $this->Session->setFlash('The group could not be saved.', 'bad');
            }
		}
	}

	
	public function view($group_id){
		$this->loadModel('Comment');
		$this->loadModel('Item');
		$this->loadModel('Event');
		$user_id = $this->Session->read('Auth.User.id');
		// $groups = $this->Group->query("SELECT `id` FROM `mfc353_2`.`users_groups` WHERE `user_id` = $user_id AND `group_id` = $group_id");
		// if(empty($groups)){
			// $groups = $this->Group->query("INSERT INTO `mfc353_2`.`users_groups` (`accepted`, `user_id`, `group_id`) VALUES ('1', $user_id, $group_id)");
		// }
		if(!$this->isMember($group_id) && !$this->isOwner($group_id) && ($this->Session->read('Auth.User.role') != 'admin')){
			$this->Session->setFlash("You are not a member of Group with id : $group_id.", 'warning');
	        return $this->redirect(array('controller'=>'groups','action' => 'index', 'admin' => false));
		}
		$group = $this->Group->findById($group_id);
		$this->set('group', $group);

		$query = 	"SELECT `user_id` FROM `mfc353_2`.`users_groups` WHERE `group_id` = $group_id AND `accepted` = 1
		AND `user_id` NOT IN (SELECT `id` FROM `mfc353_2`.`users` WHERE `status` <> 1)";
		
		$users = $this->Group->query($query);
		$usersId = $this->flatten($users);
		
		$users = $this->Group->User->find('all', array(
		    'order' => array('User.first_name ASC'),
		    'conditions' => array(
		        "User.id" => $usersId
				
		    ) )
		);



		$this->set('users', $users);	


		$items = $this->Comment->Item->find('all', array(
			'conditions' => array('Item.group_id' => $group_id),
			'order' => array('Item.created' => 'desc')
		));
		$date = date('Y-m-d H:i:s');
		$events =  $this->Event->find('all', array(
			'conditions' => array('Event.group_id' => $group_id,
			                      'Event.date >' => $date),
		'order' => array('Event.date' => 'desc')
		));
		$this->Paginator->settings = array(
			'limit' => 7,
			'conditions' => array('Item.group_id' => $group_id),
			'order' => array('Item.created' => 'desc')
		);

	    // similaire à un findAll(), mais récupère les résultats paginés
	    $items = $this->Paginator->paginate('Item');
		//$events = $this->Paginator->paginate('Event');
		$this->set('items', $items);
		$this->set('events',$events);
		$this->set('group_id',$group_id);
		
	}
	
   	public function mygroups(){

		$user_id = $this->Session->read('Auth.User.id');

		$query = 	"SELECT `id` FROM `mfc353_2`.`groups` WHERE `user_id` = $user_id
					UNION
					SELECT `group_id` FROM `mfc353_2`.`users_groups` WHERE `user_id` = $user_id ";
		
		$myGroups = $this->Group->query($query);
		$myGroupsId = $this->flatten($myGroups);

		$this->Paginator->settings = array(
			'limit' => 7,
			'conditions' => array('Group.id' => $myGroupsId),
			'order' => array('Group.created' => 'desc')
		);
		
		$groups = $this->Paginator->paginate('Group');
		
		$this->set('groups', $groups);
		}
		
	
	public function delete($group_id){
		if ($this->request->is('get')) {
	        throw new MethodNotAllowedException();
	    }
	    if ($this->Group->delete($group_id, true)) {
	        $this->Session->setFlash("The Group with id : $group_id has been deleted.", 'good');
	        return $this->redirect(array('action' => 'index', 'admin' => false));
	    }
	}
	
	
	public function withdraw($group_id){
		$this->loadModel('User');
		$users = $this->Group->UsersGroup->deleteAll( array(
		        'UsersGroup.user_id' => $this->Session->read('Auth.User.id'),
		        'UsersGroup.group_id' => $group_id
		    ),
			false
		);
		$this->Session->setFlash("You have withdrawn from the group", 'good');
		return $this->redirect(array('action' => 'index', 'admin' => false));
		
	}
	
   	public function view_members($group_id){
		$this->loadModel('User');

		$user_id = $this->Session->read('Auth.User.id');

		$query = 	"SELECT `user_id` FROM `mfc353_2`.`users_groups` WHERE `group_id` = $group_id AND `accepted` = 1
		AND `user_id` NOT IN (SELECT `id` FROM `mfc353_2`.`users` WHERE `status` <> 1)";
		
		$users = $this->Group->query($query);
		$usersId = $this->flatten($users);
		
		$users = $this->Group->User->find('all', array(
		    'order' => array('User.first_name ASC'),
		    'conditions' => array(
		        "User.id" => $usersId
				
		    ) )
		);

	

		$this->set('users', $users);	

    	$Group = $this->Group->find('all', array(
		    'conditions' => array(
			    'Group.id' => $group_id
		    ))
		);	
	
		$owner = $this->User->find('all', array(
			'conditions' => array(
				'User.id' => $Group[0]['Group']['user_id']
				)
			));
    	$this->set('owner', $owner[0]);
    	$this->set('group',$Group[0]);



    }

    public function isMember($group_id){

    	$this->loadModel('User');
    	$member = $this->Group->UsersGroup->find('all', array(
		    'conditions' => array(
			    'UsersGroup.user_id' => $this->Session->read('Auth.User.id'),
			    'UsersGroup.group_id' => $group_id,
			    'UsersGroup.accepted' => 1
		    ))
		);
		if(!empty($member)){
            return true;
        }
        else{
            return false;
        }

    }

    public function isOwner($group_id){

    	$member = $this->Group->find('all', array(
		    'conditions' => array(
			    'Group.user_id' => $this->Session->read('Auth.User.id'),
			    'Group.id' => $group_id
				
		    ))
		);
		if(!empty($member)){
            return true;
        }
        else{
            return false;
        }

    }

    public function groupRequestSent($group_id){

    	$this->loadModel('User');
    	$member = $this->Group->UsersGroup->find('all', array(
		    'conditions' => array(
			    'UsersGroup.user_id' => $this->Session->read('Auth.User.id'),
			    'UsersGroup.group_id' => $group_id,
			    'UsersGroup.accepted' => 0,
		    ))
		);
		if(!empty($member)){
            return true;
        }
        else{
            return false;
        }

    }

    public function group_requests(){

    	$user_id = $this->Session->read('Auth.User.id');
    	$query = "SELECT `user_id`, `group_id` FROM `mfc353_2`.`users_groups` WHERE `accepted` = 0 
		                    AND `group_id` IN (SELECT `id` FROM `mfc353_2`.`groups` WHERE `user_id` = $user_id)" ;
    	$requests = $this->Group->query($query);
		
		$this->set('requests', $requests);
		

    }

    public function requestGroup($group_id){
    	$user_id = $this->Session->read('Auth.User.id');

    	$query = "INSERT INTO `mfc353_2`.`users_groups` (`accepted`, `user_id`, `group_id`) VALUES ('0', $user_id, $group_id)";
        if (!$this->Group->query($query)){
            $this->Session->setFlash(__('Group Request Sent!'), 'good');
            $this->redirect(array('controller'=>'groups', 'action'=>'index'));
        }
        else{
            $this->Session->setFlash(__('Your Group Request couldn\'t be sent.'), 'bad');
            $this->redirect(array('controller'=>'groups', 'action'=>'index'));
        }

    }
	
		public function accept($user_id, $group_id){
		$this->loadModel('User','Group');

		$query = 	"UPDATE `mfc353_2`.`users_groups` SET `accepted`=1 WHERE `user_id` = $user_id AND `group_id` = $group_id";

		$this->User->Group->query($query);
		
		$this->Session->setFlash('Request accepted', 'good');

		$this->redirect(array('controller'=>'groups', 'action'=>'view', $group_id));
	}
	
		public function deny($user_id, $group_id){
		$this->loadModel('User','Group');

		$query = 	"DELETE FROM `mfc353_2`.`users_groups` WHERE `user_id` = $user_id AND `group_id` = $group_id AND `accepted` = 0";

		$this->User->Group->query($query);
		
		$this->Session->setFlash('Request denied', 'good');

		$this->redirect(array('controller'=>'groups', 'action'=>'index'));
	}
		public function remove_member($user_id, $group_id){

		$this->loadModel('User', 'Group');

		$query = 	"DELETE FROM `mfc353_2`.`users_groups` WHERE `user_id` = $user_id AND `group_id` = $group_id";

		$this->User->Group->query($query);
		
		$this->Session->setFlash('User was removed from the group', 'good');

		$this->redirect(array('controller'=>'groups', 'action'=>'view_members', $group_id));

	}

	public function findGroup($group_id){
		$group = $this->Group->find('all',
            array(
                //tableau de conditions
                'conditions' => array('Group.id' => $group_id)
            ));
		return $group[0];
	}
	        public function invite($group_id){
            
			$groups = $this->Group->find('all',
				array(
					//tableau de conditions
					'conditions' => array('Group.id' => $group_id)
				));
			$this->loadModel('User');
			$user = array();
			if ($this->request->is('post')) {	
				if($this->request->data){
					
					$email = $this->request->data['User']['email_invite'];
					$user_id = $this->request->data['User']['id'];
					$first_name = $this->request->data['User']['first_name'];
					$query = "SELECT `username` FROM `mfc353_2`.`users` WHERE `username` = \"$email\" AND `first_name` = \"$first_name\" AND `id` = $user_id";

					$user = $this->User->query($query);
				}
            
			     if(!empty($user)){
				$query = "INSERT INTO `mfc353_2`.`users_groups` (`accepted`, `user_id`, `group_id`) VALUES ('1', $user_id, $group_id)";
				$this->User->query($query);
				$this->Session->setFlash('User has been added to group.', 'good');
				$this->redirect(array('controller'=>'groups', 'action'=>'view', $group_id));
			
			     }
		      	else{
				$this->Session->setFlash('Please enter existing member credentials.', 'warning');
			     }
            }
			$this->set('group', $groups[0]);
        }


        public function edit($id = null) {
			
				if (!$id) {
					$this->Session->setFlash('Please provide a group id');
					$this->redirect(array('action'=>'index'));
				}
				
				$group = $this->Group->findById($id);
				if (!$group) {
					$this->Session->setFlash('Invalid Group ID Provided');
					$this->redirect(array('action'=>'index'));
				}
	 
				if ($this->request->is('post') || $this->request->is('put')) {
					$this->Group->id = $id;


					//Check if image has been uploaded       
					if(!empty($this->request->data['Group']['upload']['name']))
					{
						
							$file = $this->request->data['Group']['upload']; //put the data into a var for easy use

							$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
							$arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
							$random = substr(number_format(time() * mt_rand(),0,'',''),0,10); //Random number

							//only process if the extension is valid
							if(in_array($ext, $arr_ext))
							{
									//do the actual uploading of the file. First arg is the tmp name, second arg is 
									//where we are putting it
									move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/uploads/groups/' . $random . '_'. $file['name']);

									//prepare the filename for database entry
									$this->request->data['Group']['image'] = 'uploads/groups/' . $random . '_'. $file['name'];
									
							}
					}                       
					if ($this->Group->save($this->request->data)) {
						$this->Session->setFlash(__('The group has been updated'), 'good');
						$this->redirect(array('controller' => 'groups', 'action' => 'mygroups'));
					}else{
						$this->Session->setFlash(__('Unable to update your group.'), 'bad');
					}
				}
	 
				if (!$this->request->data) {
					$this->request->data = $group;
				}
			
	    }
		
   	public function view_events($group_id){
		
		$this->loadModel('Event');
		$date = date('Y-m-d');
		$query = 	"SELECT `id`,`date`,`name`,`place`,`time`,`description`FROM `mfc353_2`.`events` WHERE `group_id` = $group_id AND `date` > $date";
		
		$events = $this->Group->query($query);
		$eventsId = $this->flatten($events);
		/*
		$events = $this->Group->Event->find('all', array(
		    'order' => array('Event.date ASC'),
		    'conditions' => array(
		        "group_id" => $groupsId,
				"date>"=>$date
				
		    ) )
		);*/

		$this->set('events', $events);	

    }
	

	}

?>