<?php class EventsController extends AppController {

	public $components = array('Paginator');
	
	public $paginate = array(
        'limit' => 5,
        'order' => array(
            'Event.date' => 'DESC'
        )
    );
	
	public function beforeFilter() {
		parent::beforeFilter();
	    $this->Auth->allow('index');
     }
 	public function create($group_id){
		if ($this->request->is('post')) {
            
            $this->Event->create();    
			
            
			if (!empty($this->request->data)) {
                $this->loadModel('Group');
                // it should be in $this->request->data['User']

                // If the user was saved, Now we add this information to the data
                // and save the Profile.

                if ($this->Event->save($this->request->data)) {
                    // The ID of the newly created user has been se
					
                    // Because our User hasOne Profile, we can access
                    // the Profile model through the User model:
                    $this->Event->save($this->request->data);
					
                    $this->Session->setFlash('The event has been created.', 'good');
                    $this->redirect(array('controller'=>'events', 'action'=>'index', $this->request->data['Event']['group_id']));
					}
                else{
                    $this->Session->setFlash('The event could not be saved.', 'bad');
                }
            }
            else{
                $this->Session->setFlash('The group could not be saved.', 'bad');
            }
		}
			
	}
	

	public function delete($event_id, $group_id = null){
		if ($this->request->is('get')) {
	        throw new MethodNotAllowedException();
	    }
	    if ($this->Event->delete($event_id, true)) {
	        $this->Session->setFlash("The Event with id : $event_id has been deleted.", 'good');
	        return $this->redirect(array('action' => 'index', $group_id, 'admin' => false));
	    }
	}
	public function edit($id = null, $group_id = null){

				if (!$id) {
					$this->Session->setFlash('Please provide a group id');
					$this->redirect(array('action'=>'index'));
				}
				
				$event = $this->Event->findById($id);
				if (!$event) {
					$this->Session->setFlash('Invalid Event ID Provided');
					$this->redirect(array('action'=>'index'));
				}
	 
				if ($this->request->is('post') || $this->request->is('put')) {
					$this->Event->id = $id;
                     
					if ($this->Event->save($this->request->data)) {
						$this->Session->setFlash(__('The event has been updated'), 'good');
						$this->redirect(array('controller' => 'events', 'action' => 'index', $group_id));
					}else{
						$this->Session->setFlash(__('Unable to update your event.'), 'bad');
					}
				}
	 
				if (!$this->request->data) {
					$this->request->data = $event;
				}

	    }
		
	public function index($group_id){
		$events = $this->Event->find('all', array(
		    'order' => array('Event.date DESC'),
		    'conditions' => array('Event.group_id'=>$group_id)			
		));
		$this->Paginator->settings = $this->paginate;

	    // similaire à un findAll(), mais récupère les résultats paginés
	    //$events = $this->Paginator->paginate('Event');

	    if ( isset($this->params['requested']) && $this->params['requested'] == 1){
	    	return $items;
	    }
	    else{
	    	$this->set('events', $events);
	    }

	}
	
	public function view($event_id){
		$events = $this->Event->find('all', array(
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
	    	$this->set('events', $events);
	    }
		}
		
		
	public function hasVote($event_id){
			$this->loadModel('Suggestion');
			$query = 	"SELECT `id`FROM `mfc353_2`.`suggestions` WHERE `event_id` = $event_id";
		
		$suggestions = $this->Event->query($query);
		$suggestionsId = $this->flatten($suggestions);
		
		if(!empty($suggestions)){
		return true;
		}
		else{
		return false;
		}
	}	
	

	
}
?>