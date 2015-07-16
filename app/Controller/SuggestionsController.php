<?php class SuggestionsController extends AppController {

	public $components = array('Paginator');
	
	public $paginate = array(
        'limit' => 5,
        'order' => array(
            'Suggestion.id' => 'DESC'
        )
    );
	
	public function beforeFilter() {
		parent::beforeFilter();
	    $this->Auth->allow('index');
     }
 	public function create($event_id){
		if ($this->request->is('post')) {
            
            $this->Suggestion->create();    
			
            
			if (!empty($this->request->data)) {
                $this->loadModel('Event');
                // it should be in $this->request->data['User']

                // If the user was saved, Now we add this information to the data
                // and save the Profile.

                if ($this->Suggestion->save($this->request->data)) {
                    // The ID of the newly created user has been se
					
                    // Because our User hasOne Profile, we can access
                    // the Profile model through the User model:
                    $this->Suggestion->save($this->request->data);
					
                    $this->Session->setFlash('The event has been created.', 'good');
                    $this->redirect(array('controller'=>'suggestions', 'action'=>'index',$event_id
								));
					}//$this->request->data['Suggestion']['Event']['group_id']
                else{
                    $this->Session->setFlash('The Suggestion could not be saved.', 'bad');
                }
            }
            else{
                $this->Session->setFlash('The Suggestion could not be saved.', 'bad');
            }
		}
			
	}
	public function index($event_id){
		/*$suggestions = $this->Suggestion->find('all', array(
		    'order' => array('Suggestion.id DESC'),
		    'conditions' => array('Suggestion.event_id'=>$event_id)			
		));*/
		$query = 	"SELECT `id` ,`option` FROM `mfc353_2`.`suggestions` WHERE `event_id` = $event_id";
		$suggestions= $this->Suggestion->query($query);
		$this->Paginator->settings = $this->paginate;

	    // similaire à un findAll(), mais récupère les résultats paginés
	    //$events = $this->Paginator->paginate('Event');

	    if ( isset($this->params['requested']) && $this->params['requested'] == 1){
	    	return $items;
	    }
	    else{
	    	$this->set('suggestions', $suggestions);
	    }

	}
	
	public function delete($suggestion_id=null,$event_id=null){
	$this->loadModel('Event');
	$this->loadModel('Suggestion');
		if ($this->request->is('get')) {
	        throw new MethodNotAllowedException();
	    }
$query = 	"DELETE FROM `mfc353_2`.`suggestions` WHERE `id` = $suggestion_id";

		$this->User->Friend->query($query);
	}
	
	public function view($event_id){
	
		$suggestions = $this->Suggestion->find('all', array(
		    'order' => array('Event.date DESC'),
		    'conditions' => array('Event.id'=>$event_id)			
		));
		$this->Paginator->settings = $this->paginate;

	    // similaire à un findAll(), mais récupère les résultats paginés
	    //$events = $this->Paginator->paginate('Event');

	    if ( isset($this->params['requested']) && $this->params['requested'] == 1){
	    	return $items;
	    }
	    else{
	    	$this->set('suggestions', $suggestions);
		
	    }

	}	
	
   	public function view_suggestions($event_id){
		

		$query = 	"SELECT `id`,`option`FROM `mfc353_2`.`suggestions` WHERE `event_id` = $event_id";
		
		$suggestions = $this->Suggestion->query($query);
		$suggestionsId = $this->flatten($suggestions);
		/*
		$events = $this->Group->Event->find('all', array(
		    'order' => array('Event.date ASC'),
		    'conditions' => array(
		        "group_id" => $groupsId,
				"date>"=>$date
				
		    ) )
		);*/
	    if ( isset($this->params['requested']) && $this->params['requested'] == 1){
	    	return $items;
	    }
	    else{
	    	$this->set('suggestions', $suggestions);
	    } 
    }
	
	public function hasRights($group_id){
		$this->loadModel('User');
		$this->loadModel('Group');	
		$user_id = $this->Session->read('Auth.User.id');
		$query = 	"SELECT `user_id`FROM `mfc353_2`.`users_groups` WHERE `group_id` = $group_id";	
		$users = $this->User->Group->query($query);	
	
		foreach($users as $user){
		if ($user['users_groups']['user_id'] ==$user_id){
		return true;}
		else {
		return false;}
		}	
	
	}
	
	public function vote($id = null){	

		$user_id = $this->Session->read('Auth.User.id');
	
        var_dump($this->request->data);
        if($this->request->data){

            $query = "INSERT INTO `mfc353_2`.`users_suggestions` ( `user_id`, `suggestion_id`) 
			VALUES ( $user_id, $id)";
			$this->Suggestion->query($query);			

            if (!$this->User->Suggestion->query($query)){
                $this->Session->setFlash(__('Voting Sent!'), 'good');
                $this->redirect(array('controller'=>'profiles', 'action'=>'index'));
            }
            else{
                $this->Session->setFlash(__('Your Vote couldn\'t be sent.'), 'bad');
                $this->redirect(array('controller'=>'profiles', 'action'=>'index'));
            }
		}	

	    }
		
	public function see($suggestion_id=null){
	     $this->loadModel('User','Suggestion');
		$query = 	"SELECT `id`FROM `mfc353_2`.`users_suggestions` WHERE `suggestion_id` = $suggestion_id";	
		$total= $this->User->UsersSuggestion->query($query);		
		$num = count($total);
		$this->set('num',$num);

	
	}


}
?>