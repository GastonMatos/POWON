<?php class ItemsController extends AppController {

	public $components = array('Paginator');
	
	public $paginate = array(
        'limit' => 5,
        'order' => array(
            'Item.created' => 'DESC'
        )
    );
	
	public function beforeFilter() {
		parent::beforeFilter();
	    $this->Auth->allow('index');
	}
	
	public function index(){
		$items = $this->Item->find('all', array(
		    'order' => array('Item.created DESC')
		));
		$this->Paginator->settings = $this->paginate;

	    // similaire à un findAll(), mais récupère les résultats paginés
	    $items = $this->Paginator->paginate('Item');

	    if ( isset($this->params['requested']) && $this->params['requested'] == 1){
	    	return $items;
	    }
	    else{
	    	$this->set('items', $items);
	    }
	}

	public function view($item_id){
		if(!$item_id){
			throw new NotFoundException("Error 404. Item not found");	
		}
		$item = $this->Item->findById($item_id);
		if(empty($item)){
			throw new NotFoundException("Error 404. Item not found");
		}
		$this->set('item', $item);
	}
	
	public function create(){
		if($this->request->is('post')){
			$this->Item->create();    
            //Check if image has been uploaded
            if(!empty($this->request->data['Item']['upload']['name']))
            {
                    $file = $this->request->data['Item']['upload']; //put the data into a var for easy use

                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                    $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
                    $random = substr(number_format(time() * mt_rand(),0,'',''),0,10); //Random number

                    //only process if the extension is valid
                    if(in_array($ext, $arr_ext))
                    {
                            //do the actual uploading of the file. First arg is the tmp name, second arg is 
                            //where we are putting it
                            move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/uploads/items/' . $random . '_'. $file['name']);

                            //prepare the filename for database entry
                            $this->request->data['Item']['image'] = 'uploads/items/' . $random . '_'. $file['name'];
                    }
            }
			if (!empty($this->request->data)) {
                
				$this->request->data['Item']['user_id'] = $this->Session->read('Auth.User.id');

				// Because our User hasOne Profile, we can access
				// the Profile model through the User model:
				$this->Item->save($this->request->data);

				$this->Session->setFlash('The Item has been created.', 'good');
				$this->redirect(array('controller'=>'groups', 'action'=>'view', $this->request->data['Item']['group_id'], 'admin' => false));
                
            }
            else{
                $this->Session->setFlash('The Item could not be saved.', 'bad');
            }
		}
	}
	
	public function share($item_id, $user_id, $group_id){
		$this->Item->query("INSERT INTO `mfc353_2`.`items` (`group_id`, `user_id`, `description`, `created`) VALUES ($group_id, $user_id, \"https://clipper.encs.concordia.ca/~mfc353_2/items/view/$item_id\", CURRENT_TIMESTAMP)");
		$this->redirect(array('controller'=>'groups', 'action'=>'view', $group_id, 'admin' => false));
	}
	
	public function delete($id = null) {
         
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Item->delete($id)) {
            $this->Session->setFlash("The Item with id : $id has been deleted.", 'good');
            return $this->redirect(array('controller' => 'profiles', 'action' => 'index', 'admin' => false));
        }
    }
}
?>