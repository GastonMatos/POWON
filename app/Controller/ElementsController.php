<?php class ElementsController extends AppController {

	public $components = array('Paginator');
	
	public $paginate = array(
        'limit' => 5,
        'order' => array(
            'User.first_name' => 'ASC'
        )
    );
	
	// to edit profile which will filled into elements tableau
	public function edit($id = null) {
        $this->loadModel('Profile'); 
		$this->loadModel('Element'); 
		$profile = $this->Profile->find('all', array(
			'conditions' => array(
				'Profile.user_id' => $id
			)
		));
		$profile_id = $profile[0]['Profile']['id'];
		$elements = $this->Profile->Elements->find('all',
			array(
				'conditions' => array(
					'Elements.profile_id' => $profile_id
			)
		));
		
		$this->Paginator->settings = array(
				'limit' => 5,
				'conditions' => array(
					'Elements.profile_id' => $profile_id
				),
				'order' => array('Elements.created' => 'desc')
		);
		$elements = $this->Paginator->paginate($this->Profile->Elements);
		$this->set(compact('elements'));
		$this->set(compact('profile_id'));
		$this->request->data['Element']['profile_id'] = $profile_id;
		if (!$id) {
			$this->Session->setFlash('Please provide an element id');
			$this->redirect(array('controller'=>'profiles', 'action'=>'index'));
		} 
 
        if ($this->request->is('post') || $this->request->is('put')) {
						
			if ($this->Element->save($this->request->data)) {
				$this->Session->setFlash(__('The profile has been updated'), 'good');
				$this->redirect(array('controller' => 'profiles', 'action' => 'index'));
			}
			else{
				$this->Session->setFlash(__('Unable to update your user.'), 'bad');
			}
        }
    }
	
	public function create(){
		if ($this->request->is('post')) {
            
            $this->Element->create();    
			if (!empty($this->request->data)) {

                if ($this->Element->save($this->request->data)) {
                    $this->Session->setFlash('The element has been created.', 'good');
                    $this->redirect(array('controller'=>'elements', 'action'=>'edit', $this->Session->read('Auth.User.id')));
				}
                else{
                    $this->Session->setFlash('The element could not be saved.', 'bad');
                }
            }
            else{
                $this->Session->setFlash('The element could not be saved.', 'bad');
            }
		}
	}
	
	public function delete($element_id){
		if ($this->request->is('get')) {
	        throw new MethodNotAllowedException();
	    }
	    if ($this->Element->delete($element_id, true)) {
	        $this->Session->setFlash("The Element with id : $element_id has been deleted.", 'good');
	        return $this->redirect(array('action' => 'edit', $this->Session->read('Auth.User.id'), 'admin' => false));
	    }
	}
	
	public function editElement($id){
		if(!$id){
			throw new NotFoundException("Invalid Element");
		}

		$Element = $this->Element->findById($id);

		if(!$Element){
			throw new NotFoundException("Invalid Element");
		}

		if($this->request->is('post') || $this->request->is('put')){
			$this->Element->id = $id;
			if($this->request->is('put')){
				$this->Element->create();
				if($this->Element->save($this->request->data)){
					$this->Session->setFlash('Element modified', 'good');
					$this->redirect(array('action' => 'edit', $this->Session->read('Auth.User.id'), 'admin' => false));
				}
				else
					$this->Session->setFlash('The Element wasn\'t modified', 'bad');
			}
		}
		
		if(!$this->request->data){
			$this->request->data = $Element;
		}
	}

}
?>