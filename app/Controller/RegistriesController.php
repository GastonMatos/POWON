<?php class RegistriesController extends AppController {
 
 public function beforeFilter() {
        parent::beforeFilter();
        if($this->Auth->user('role')=='admin'){
                $this->Auth->allow('admin_edit','admin_add', 'admin_logout', 'admin_index');//put your all admin actions separated by comma
        }
        else
        {
                $this->Auth->allow('login','register'); //put your all non-admin actions separated by comma
        }
         
    }
    public function create() {

    		if ($this->request->is('post')) {
            
            $this->Registry->create();    
            //Check if image has been uploaded
            if(!empty($this->request->data['Registry']['upload']['name']))
            {
                    $file = $this->request->data['Registry']['upload']; //put the data into a var for easy use

                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                    $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
                    $random = substr(number_format(time() * mt_rand(),0,'',''),0,10); //Random number

                    //only process if the extension is valid
                    if(in_array($ext, $arr_ext))
                    {
                            //do the actual uploading of the file. First arg is the tmp name, second arg is 
                            //where we are putting it
                            move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/uploads/gifts/' . $random . '_'. $file['name']);

                            //prepare the filename for database entry
                            $this->request->data['Registry']['image'] = 'uploads/gifts/' . $random . '_'. $file['name'];
                    }
            }
			if (!empty($this->request->data['Registry']['name'])) {
                $this->loadModel('User');
                // it should be in $this->request->data['User']

                // If the user was saved, Now we add this information to the data
                // and save the Profile.

                if ($this->Registry->save($this->request->data)) {
                    // The ID of the newly created user has been se
					
                    // Because our User hasOne Profile, we can access
                    // the Profile model through the User model:
                    $this->Registry->save($this->request->data);
					
                    $this->Session->setFlash('The item has been created.', 'good');
                    $this->redirect(array('controller'=>'registries', 'action'=>'index'));
					}
                else{
                    $this->Session->setFlash('The item could not be saved.', 'bad');
                }
            }
            else{
                $this->Session->setFlash('The item could not be saved.', 'bad');
            }
		}
	}
     public function view($id=null){

        if ($this->Session->read('Auth.User.id') == $id) {
                $this->redirect(array('controller' => 'registries', 'action'=>'index'));
        }
        $id = intval($id);
        $this->loadModel('Registry');
        
        $query ="SELECT id FROM `mfc353_2`.`registries` WHERE `user_id` = $id ";
        $ItemsId = $this->Registry->query($query);

        $ListId = array();


        foreach ($ItemsId as $ItemsId) {
             foreach ($ItemsId as $key => $values) {
                  foreach ($values as $key => $value) {
                        array_push($ListId, $value);
                    }
            }
        }

                $List = $this->Registry->find('all',array(
                    'conditions' => array(
                        "Registry.id" => $ListId
                        )

                    )
        );

        $this->set('ListofItems', $List);






    }

    public function gift($id = null) {


        $this->loadModel('Registry');
  
        $buyer = $this->Session->read('Auth.User.id');
        $buyer = intval($buyer);

        if (!$id) {
            $this->Session->setFlash('Please provide a group id','bad');
            $this->redirect(array('action'=>'index'));
        }
        $query ="SELECT user_id FROM `mfc353_2`.`registries` WHERE `id` = $id";

        $OwnerId = $this->Registry->query($query);
 

        $own_Id = array();

        foreach ($OwnerId as $OwnerId) {
            foreach ($OwnerId as $key => $values) {
                foreach ($values as $key => $value) {
                    array_push($own_Id, $value);
                }
            }
        }
    
        $ID = implode("",$own_Id);





        $this->Registry->id = $id;
        if (!$this->Registry->exists()) {
            $this->Session->setFlash('Invalid gift id provided','bad');
            $this->redirect(array('action'=>'view',$ID));
        }
        if ($this->Registry->saveField('bought', 1))
        {
            $this->Registry->saveField('buyer_id', $buyer);
            $this->Session->setFlash('You have gifted the item','good');
            $this->redirect(array('controller' => 'registries', 'action' => 'view' , $ID  ));
        }
        $this->Session->setFlash(__('Item was not gifted'),'bad');
        $this->redirect(array('action' => 'view', $ID));
    }








    public function index() {
            $this->loadModel('Registry');
            $user_id = $this->Session->read('Auth.User.id');

            $query ="SELECT id FROM `mfc353_2`.`registries` WHERE `user_id` = $user_id AND `bought` = 0";
            $ItemsId = $this->Registry->query($query);

            $ListId = array();

            foreach ($ItemsId as $ItemsId) {
                 foreach ($ItemsId as $key => $values) {
                      foreach ($values as $key => $value) {
                            array_push($ListId, $value);
                        }
                }
            }

                    $List = $this->Registry->find('all',array(
                        'conditions' => array(
                            "Registry.id" => $ListId
                            )

                        )
            );


            $this->set('ListofItems', $List);

    }
}

