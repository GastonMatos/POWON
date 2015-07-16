<?php class PermissionsController extends AppController {

	public $components = array('Paginator');
	
	public $paginate = array(
        'limit' => 5,
        'order' => array(
            'User.first_name' => 'ASC'
        )
    );
	
	public function manage($item_id){
		$this->loadModel('User');
		$this->loadModel('Item');
		$user_id = $this->Session->read('Auth.User.id');
		
		$query = "SELECT `user_id` FROM `mfc353_2`.`users_groups` WHERE `group_id` IN 
						(SELECT `group_id` FROM `mfc353_2`.`users_groups` WHERE `user_id` = $user_id AND `accepted` = 1
								UNION
						SELECT `id` FROM `mfc353_2`.`groups` WHERE `user_id` = $user_id)
					UNION
										SELECT `friend_id` FROM `mfc353_2`.`users_friends` WHERE `user_id` = $user_id AND `approved` = 1
											UNION
					SELECT `user_id` FROM `mfc353_2`.`users_friends` WHERE `approved` = 1 AND `friend_id` = $user_id;";
		
		$users = $this->Permission->query($query);
	
		$userIds = $this->flatten($users);
		
		$this->Paginator->settings = array(
			'limit' => 10,
			'conditions' => array(
				'AND' => array(
					"User.id" => $userIds,
					"User.id !=" => $user_id,
					"User.status" => 1
				)
		    ),
			'group' => 'User.id',
			'order' => array('User.first_name' => 'asc')
		);
		
		$item = $this->Item->findById($item_id);
		$user_item = $this->User->findById($user_id);

	    // similaire à un findAll(), mais récupère les résultats paginés
	    $users = $this->Paginator->paginate('User');
		
		$this->set('users', $users);
		$this->set('item', $item);
		$this->set('user_item', $user_item);
		
		if($this->request->data){
			$user_id = $this->request->data['Permission']['user_id'];
			$item_id = $this->request->data['Permission']['item_id'];
			$permission = $this->request->data['Permission']['permission'];
			$query = 	"INSERT INTO `mfc353_2`.`permissions` (`user_id`, `item_id`, `permission`)
								VALUES ($user_id, $item_id, $permission)
								ON DUPLICATE KEY UPDATE permission = $permission";
			$this->Permission->query($query);
			$this->redirect(array('action' => 'manage', $item_id));
		}
	}
	
	public function manageElement($element_id){
		$this->loadModel('User');
		$this->loadModel('Element');
		$user_id = $this->Session->read('Auth.User.id');
		
		$query = "SELECT `user_id` FROM `mfc353_2`.`users_groups` WHERE `group_id` IN 
						(SELECT `group_id` FROM `mfc353_2`.`users_groups` WHERE `user_id` = $user_id AND `accepted` = 1
								UNION
						SELECT `id` FROM `mfc353_2`.`groups` WHERE `user_id` = $user_id)
					UNION
										SELECT `friend_id` FROM `mfc353_2`.`users_friends` WHERE `user_id` = $user_id AND `approved` = 1
											UNION
					SELECT `user_id` FROM `mfc353_2`.`users_friends` WHERE `approved` = 1 AND `friend_id` = $user_id;";
		
		$users = $this->Permission->query($query);
	
		$userIds = array_unique($this->flatten($users));
		
		$this->Paginator->settings = array(
			'limit' => 10,
			'conditions' => array(
				'AND' => array(
					"User.id" => $userIds,
					"User.id !=" => $user_id,
					"User.status" => 1
				)
		    ),
			'group' => 'User.id',
			'order' => array('User.first_name' => 'asc')
		);
		
		$element = $this->Element->findById($element_id);
		$user_element = $this->User->findById($user_id);

	    // similaire à un findAll(), mais récupère les résultats paginés
	    $users = $this->Paginator->paginate('User');
		
		
		$this->set('users', $users);
		$this->set('element', $element);
		// $this->set('user_element', $user_element);
		
		if($this->request->data){
			$user_id = $this->request->data['Permission']['user_id'];
			$element_id = $this->request->data['Permission']['element_id'];
			$permission = $this->request->data['Permission']['permission'];
			$query = 	"INSERT INTO `mfc353_2`.`elements_permissions` (`user_id`, `element_id`, `permission`)
								VALUES ($user_id, $element_id, $permission)
								ON DUPLICATE KEY UPDATE permission = $permission";
			$this->Permission->query($query);
			$this->redirect(array('action' => 'manageElement', $element_id));
		}
	}
	
	
	public function currentPermission($user_id, $item_id){
		$query = 	"SELECT `permission` FROM `mfc353_2`.`permissions` WHERE `user_id` = $user_id AND `item_id` = $item_id";
		$currentPermission = $this->flatten($this->Permission->query($query));
		if(empty($currentPermission)){
			$currentPermission[0] = 2;
		}
		return intval($currentPermission[0]);
	}
	
	public function currentElementPermission($user_id, $element_id){
		$query = 	"SELECT `permission` FROM `mfc353_2`.`elements_permissions` WHERE `user_id` = $user_id AND `element_id` = $element_id";
		$currentPermission = $this->flatten($this->Permission->query($query));
		if(empty($currentPermission)){
			$currentPermission[0] = 1;
		}
		return intval($currentPermission[0]);
	}
	
	
}
?>