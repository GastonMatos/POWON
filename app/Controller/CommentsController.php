<?php class CommentsController extends AppController {

	public $components = array('Paginator');

	public $paginate = array(
		'limit' => 5,
		'order' => array(
			'User.created' => 'DESC'
		)
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
		 
	}

	public function create($group_id = null){
		if ($this->request->is('post')) {
			$this->Comment->create();
			if($this->Comment->save($this->request->data)){
				$this->Session->setFlash('Your comment has been added.', 'good');
				$this->redirect(array('controller' => 'groups', 'action' => 'view', $group_id, 'admin' => false));
			}
			else{
				$this->Session->setFlash('Your comment has not been added.', 'bad');
			}
	   }
	}
	
	public function findComments($item_id){
		$comments = $this->Comment->find('all',
            array(
                //tableau de conditions
                'conditions' => array('Comment.item_id' => $item_id)
            ));
		return $comments;
	}
}
?>