<?php class ProfilesController extends AppController {

	public $components = array('Paginator');
	
	public $paginate = array(
        'limit' => 5,
        'order' => array(
            'User.first_name' => 'ASC'
        )
    );

	public function index(){
		$user_id = $this->Session->read('Auth.User.id');
		$this->loadModel('User');
		$this->loadModel('Group');
		$this->loadModel('Item');
		$profile = $this->User->Profile->find('all',
			array(
			    //tableau de conditions
			    'conditions' => array('Profile.user_id' => $user_id)
			));
		$this->set('profile', $profile[0]);

		$query = 	"SELECT `group_id` FROM `mfc353_2`.`users_groups` WHERE `user_id` = $user_id AND `accepted` = 1
						UNION
					SELECT `id` FROM `mfc353_2`.`groups` WHERE `user_id` = $user_id";
		
		$belong_groups = $this->Group->query($query);
	
		$belong_groupsId = $this->flatten($belong_groups);


		$query2 = 	"SELECT `friend_id` FROM `mfc353_2`.`users_friends` WHERE `user_id` = $user_id AND `approved` = 1
					UNION
					SELECT `user_id` FROM `mfc353_2`.`users_friends` WHERE `approved` = 1 AND `friend_id` = $user_id";
		
		$friends = $this->Group->query($query2);
		
		$friendsId = $this->flatten($friends);

		$this->Paginator->settings = array(
			    'limit' => 7,
			    'conditions' => array(
					'OR' => array(
						'Items.group_id' => $belong_groupsId,
						'Items.user_id' => $friendsId
					)
				),
				'order' => array('Items.created' => 'desc')
			);
		$items = $this->Paginator->paginate($this->Group->Items);
		
		$this->set('items', $items);



	}


	public function view($id=null){
		if ($this->Session->read('Auth.User.id') == $id) {
			$this->redirect(array('controller' => 'profiles', 'action'=>'index'));
        }
		$id = intval($id);
		$this->loadModel('User');
		$this->loadModel('Item');
		$profile = $this->User->Profile->find('all',
			array(
			    //tableau de conditions
			    'conditions' => array('Profile.user_id' => $id)
			));
		if(!$profile){
			throw new NotFoundException("The user doesn't exist");
		}
		
		$this->Paginator->settings = array(
			    'limit' => 7,
			    'conditions' => array(
					'Item.user_id' => $id
				),
				'order' => array('Item.created' => 'desc')
			);
		$items = $this->Paginator->paginate('Item');
		
		$this->set('profile', $profile[0]);
		$this->set('items', $items);
		
	}
	


	public function friends($category=null){
		$this->loadModel('User');
		
		$user_id = $this->Session->read('Auth.User.id');

		if($category != null){
			$query = 	"SELECT `friend_id` FROM `mfc353_2`.`users_friends` WHERE `user_id` = $user_id AND `approved` = 1 AND `category` = \"$category\"
					UNION
					SELECT `user_id` FROM `mfc353_2`.`users_friends` WHERE `approved` = 1 AND `friend_id` = $user_id AND `category` = \"$category\"";
		}
		else{
			$query = 	"SELECT `friend_id` FROM `mfc353_2`.`users_friends` WHERE `user_id` = $user_id AND `approved` = 1
					UNION
					SELECT `user_id` FROM `mfc353_2`.`users_friends` WHERE `approved` = 1 AND `friend_id` = $user_id";
		}
		
		$friends = $this->User->Friend->query($query);

		$friendsId = $this->flatten($friends);

		$friends = $this->User->find('all', array(
		    'order' => array('User.first_name ASC'),
		    'conditions' => array(
		        "User.id" => $friendsId
		    )
		));

		$this->Paginator->settings = array(
				'limit' => 12,
				'conditions' => array(
					"User.id" => $friendsId, 
				),
				'order' => array(
					'User.first_name' => 'ASC'
				)
			);
		$friends = $this->Paginator->paginate('User');

		$this->set('friends', $friends);

	}

	public function friendRequests(){
		$this->loadModel('User');

		$user_id = $this->Session->read('Auth.User.id');

		$query = 	"SELECT `user_id` FROM `mfc353_2`.`users_friends` WHERE `friend_id` = $user_id AND `approved` = 0";
		
		$friends = $this->User->Friend->query($query);

		$friendsId = $this->flatten($friends);

		$friends = $this->User->find('all', array(
		    'order' => array('User.first_name ASC'),
		    'conditions' => array(
		        "User.id" => $friendsId
		    )
		));
		
		//display all members who are not friends nor send request 
		/*$query2 = 	"SELECT `id` FROM `mfc353_2`.`users` WHERE `id`<> $user_id AND `status` = 1";
		
		$usersList= $this->User->query($query2);
		$usersId = array();		

		foreach ($usersList as $userList) {
			foreach ($userList as $key => $values) {
				foreach ($values as $key => $value) {
					array_push($usersId, $value);
				}
			}
		}
		
		$users = $this->User->find('all', array(
		    'order' => array('User.first_name ASC'),
		    'conditions' => array(
		        "User.id" => $usersId
				
		    ) )
		);
		*/ 
		$user_id = $this->Session->read('Auth.User.id');
		$this->Paginator->settings = array(
			'limit' => 7,
		    'order' => array('User.first_name ASC'),
		    'conditions' => array(
		        "User.status =" => 1,
				"User.id <>" => $user_id
				
		    ));
		
		$users = $this->Paginator->paginate('User');

		$this->set('friends', $friends);
		$this->set('users', $users);		

	}
	



	public function accept($friend_id){
		$this->loadModel('User');

		$user_id = $this->Session->read('Auth.User.id');

		$query = 	"UPDATE `mfc353_2`.`users_friends` SET `approved`=1 WHERE `friend_id` = $user_id AND `user_id` = $friend_id AND `approved` = 0";

		$this->User->Friend->query($query);
		
		$this->Session->setFlash('Request accepted', 'good');

		$this->redirect(array('controller'=>'profiles', 'action'=>'view', $friend_id));
	}
	

	public function deny($friend_id){
		$this->loadModel('User');

		$user_id = $this->Session->read('Auth.User.id');

		$query = 	"DELETE FROM `mfc353_2`.`users_friends` WHERE `friend_id` = $user_id AND `user_id` = $friend_id AND `approved` = 0";

		$this->User->Friend->query($query);
		
		$this->Session->setFlash('Request denied', 'good');

		$this->redirect(array('controller'=>'profiles', 'action'=>'view', $friend_id));
	}

}
?>