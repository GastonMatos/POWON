<?php class MessagesController extends AppController {

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
	
public function view($inbox){
		$user_id = $this->Session->read('Auth.User.id');
		
		$this->set('Inbox', $inbox);
		$updateread="
		
		UPDATE `mfc353_2`.`inboxes` 
		
		SET     			inboxes.receiver_read = CASE  	WHEN inboxes.receiver_id = $user_id 
															THEN inboxes.receiver_read-inboxes.receiver_read
															ELSE inboxes.receiver_read
															
															
		END,
							inboxes.sender_read = CASE 		WHEN inboxes.sender_id = $user_id 
															THEN inboxes.sender_read-inboxes.sender_read
															ELSE inboxes.sender_read
															
															
		END													
		
		
		
		WHERE `id`=$inbox";
		
		
		$this->Message->query($updateread);
		
		$query="SELECT *
				FROM mfc353_2.messages
				WHERE messages.inbox_id=$inbox
				ORDER BY messages.created ASC";
		$messages=$this->Message->query($query);
		
		
foreach($messages as &$message){
		$writer_id=intval($message['messages']['writer_id']);
		$qquery="SELECT users.first_name, users.last_name  
				FROM mfc353_2.users
				WHERE users.id = $writer_id";
		$tempq = $this->Message->query($qquery);
		
		$message['messages']['first_name']= $tempq[0]['users']['first_name'];

}
$this->set('Message', $messages);
}


public function sendmsg(){
$user_id = $this->Session->read('Auth.User.id');

if($this->request->data){
$bodytext=$this->request->data['Message']['body'];
$inboxid=$this->request->data['Message']['id'];

$query = "INSERT INTO `mfc353_2`.`messages` ( `body`, `writer_id`, `inbox_id`) 
		VALUES (\"$bodytext\", $user_id ,$inboxid)";
if (!$this->Message->query($query)){

$notificationquery="UPDATE  mfc353_2.inboxes
					SET     inboxes.receiver_read = CASE  	WHEN inboxes.sender_id = $user_id 
															THEN inboxes.receiver_read+1
															ELSE inboxes.receiver_read
															
															
					END,
							inboxes.sender_read = CASE 		WHEN inboxes.receiver_id = $user_id 
															THEN inboxes.sender_read+1
															ELSE inboxes.sender_read
															
															
															
					END
					WHERE inboxes.id=$inboxid";
$this->Message->query($notificationquery);

                $this->Session->setFlash(__('Message Sent!'), 'good');
                $this->redirect(array('controller'=>'messages', 'action'=>'view', $inboxid));
            }
            else{
                $this->Session->setFlash(__('Your Message couldn\'t be sent.'), 'bad');
                $this->redirect(array('controller'=>'messages', 'action'=>'view', $inboxid));
            }
}





}

public function sendnew($targetuser){
		$user_id = $this->Session->read('Auth.User.id');
		$query="INSERT INTO `mfc353_2`.`inboxes` (`sender_id`, `receiver_id`) VALUES ($user_id, $targetuser)";


$existinboxquery=
					"SELECT inboxes.id
					FROM `mfc353_2`.inboxes 
					WHERE (receiver_id=$targetuser AND sender_id=$user_id)
					OR (receiver_id=$user_id AND sender_id=$targetuser)
					";

$existinginbox=$this->Message->query($existinboxquery);

if(empty($existinginbox)){		
			if (!$this->Message->query($query)){
				$inboxquery="SELECT id FROM mfc353_2.inboxes WHERE receiver_id=$targetuser";
				$inbox=$this->Message->query($inboxquery);
				$inboxid=$inbox[0]['inboxes']['id'];
				$hello="hello";
				$msgquery = "INSERT INTO `mfc353_2`.`messages` ( `body`, `writer_id`, `inbox_id`) 
				VALUES (\"$hello\", $user_id ,$inboxid)";
				$this->Message->query($msgquery);
                $this->Session->setFlash(__('You said hello :)'), 'good');
                $this->redirect(array('controller'=>'messages', 'action'=>'view', $inboxid));
}
			else{
                $this->Session->setFlash(__('Your Message couldn\'t be sent.'), 'bad');
                $this->redirect(array('controller'=>'messages', 'action'=>'view', $inboxid));
            }
            
			
			
}						
else{
					
					$this->redirect(array('controller'=>'messages', 'action'=>'view', $existinginbox[0]['inboxes']['id']));
}
		
}





	
	

}	
	?>