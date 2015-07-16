<?php class AnnouncementsController extends AppController {

	public $components = array('Paginator');
	
	public $paginate = array(
        'limit' => 5,
        'order' => array(
            'Announcement.created' => 'DESC'
        )
    );
	
	public function beforeFilter() {
		parent::beforeFilter();
	    $this->Auth->allow('index');
	}
	
	public function index(){
		$announcements = $this->Announcement->find('all', array(
		    'order' => array('Announcement.created DESC')
		));
		$this->Paginator->settings = $this->paginate;

	    // similaire à un findAll(), mais récupère les résultats paginés
	    $announcements = $this->Paginator->paginate('Announcement');

	    if ( isset($this->params['requested']) && $this->params['requested'] == 1){
	    	return $announcements;
	    }
	    else{
	    	$this->set('announcements', $announcements);
	    }
	}
	
	public function admin_add(){
		if($this->request->is('post')){
			if (!empty($this->request->data)) {
                // We can save the User data:
                // it should be in $this->request->data['User']

       
				// The ID of the newly created user has been set
				// as $this->User->id.
				$this->request->data['Announcement']['user_id'] = $this->Session->read('Auth.User.id');

				// Because our User hasOne Profile, we can access
				// the Profile model through the User model:
				$this->Announcement->save($this->request->data);

				$this->Session->setFlash('The Announcement has been created.', 'good');
				$this->redirect(array('controller'=>'announcements', 'action'=>'index', 'admin' => false));
                
            }
            else{
                $this->Session->setFlash('The Announcement could not be saved.', 'bad');
            }
		}
	}

	public function admin_edit($id){
		if(!$id){
			throw new NotFoundException("Invalid Announcement");
		}

		$announcement = $this->Announcement->findById($id);

		if(!$announcement){
			throw new NotFoundException("Invalid Announcement");
		}

		if($this->request->is('post') || $this->request->is('put')){
			$this->Announcement->id = $id;
			if($this->request->is('put')){
				$this->Announcement->create();
				if($this->Announcement->save($this->request->data)){
					$this->Session->setFlash('Announcement modified', 'good');
					$this->redirect(array('action' => 'index', 'admin' => false));
				}
				else
					$this->Session->setFlash('The Announcement wasn\'t modified', 'bad');
			}
		}
		
		if(!$this->request->data){
			$this->request->data = $announcement;
		}
	}

	public function admin_delete($id) {
	    if ($this->request->is('get')) {
	        throw new MethodNotAllowedException();
	    }
	    if ($this->Announcement->delete($id)) {
	        $this->Session->setFlash("The Announcement with id : $id has been deleted.", 'good');
	        return $this->redirect(array('action' => 'index', 'admin' => false));
	    }
	}
}
?>