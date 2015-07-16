<?php class InboxesController extends AppController {

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
	
	public function view(){
		$this->loadModel('Inbox');
		$user_id = $this->Session->read('Auth.User.id');
		
		$conversation_query = "SELECT messages.body,messages.created, messages.writer_id, messages.inbox_id
								FROM messages
								WHERE messages.writer_id<>$user_id AND messages.created IN(
								SELECT MAX(messages.created)
								FROM messages
								WHERE messages.inbox_id IN
								(SELECT inboxes.id
								FROM `mfc353_2`.inboxes 
								WHERE (sender_id = $user_id OR receiver_id=$user_id)
								GROUP BY inboxes.id)
								GROUP BY messages.writer_id)";
		$conversations = $this->Inbox->query($conversation_query);
		foreach($conversations as &$con){
		$writer_id=intval($con['messages']['writer_id']);
		$qquery="SELECT users.first_name, users.last_name, users.status 
				FROM mfc353_2.users
				WHERE users.id = $writer_id";
		$tempq = $this->Inbox->query($qquery);
		
		$con['messages']['first_name']= $tempq[0]['users']['first_name'];
		$con['messages']['last_name']= $tempq[0]['users']['last_name'];
		$con['messages']['status']= $tempq[0]['users']['status'];
		
		}
		$this->set('Conversation', $conversations);
		
		
		$newquery="SELECT id, first_name, last_name, image
					FROM mfc353_2.users
					WHERE id IN(
					SELECT user_id
					from (
				SELECT DISTINCT user_id
					FROM mfc353_2.users_groups
					WHERE user_id<>$user_id AND group_id IN (
					SELECT group_id
					FROM mfc353_2.users_groups
					WHERE user_id=$user_id
					UNION 
					SELECT id
					FROM mfc353_2.groups
					WHERE user_id=$user_id)) a
				WHERE user_id NOT IN
					(SELECT DISTINCT sender_id
					FROM
					(SELECT sender_id FROM inboxes
					UNION ALL
					SELECT receiver_id FROM inboxes) a
					WHERE sender_id<>$user_id)
					
                    UNION
                    
					SELECT DISTINCT friend_id
					FROM
					(SELECT `friend_id` FROM `mfc353_2`.`users_friends` WHERE `user_id` = $user_id AND `approved` = 1
					UNION
					SELECT `user_id` FROM `mfc353_2`.`users_friends` WHERE `approved` = 1 AND `friend_id` = $user_id) a
					WHERE  friend_id NOT IN (
                    SELECT sender_id FROM inboxes WHERE receiver_id=$user_id
					UNION ALL
					SELECT receiver_id FROM inboxes WHERE sender_id=$user_id))
					";
		$members = $this->Inbox->query($newquery);
		$this->set('Members', $members);
		}
		
		
	
}
?>