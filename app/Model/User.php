<?php App::uses('AuthComponent', 'Controller/Component');
 
class User extends AppModel {
     
    var $hasAndBelongsToMany = array(	
        'Friend' => array(
						'joinTable' => 'users_friends',
						'className' => 'User',
						'foreignKey' => 'user_id',
						'associationForeignKey' => 'friend_id'
					),
					
        'Group' => array(
            'joinTable' => 'users_groups',
            'className' => 'Group',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'group_id'
        ),
        'Suggestion' => array(
            'joinTable' => 'users_suggestions',
            'className' => 'Suggestion',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'suggestion_id'
        )
		
    );
	
    var $hasOne = array(
					'Profile' =>
                    array('className'    => 'Profile',
                          'conditions'   => '',
                          'order'        => '',
                          'dependent'    =>  true,
                          'foreignKey'   => 'user_id'
                    ),
					
					/*'Message' =>
                    array('className'    => 'Message',
                          'conditions'   => '',
                          'order'        => '',
                          'dependent'    =>  true,
                          'foreignKey'   => 'writer_id'
                    ),*/
					

					/*
					'Suggestion' =>
                    array('className'    => 'Suggestion',
                          'conditions'   => '',
                          'order'        => '',
                          'dependent'    =>  true,
                          'foreignKey'   => 'user_id'
                    )
					*/
              );
	/*		  
	var $belongTo = array(
				'Comment' =>
                       array('className'  => 'Comment',
                             'conditions' => '',
                             'order'      => '',
                             'foreignKey' => 'user_id'
                       ),
					   
				'Suggestion' =>
                       array('className'  => 'Suggestion',
                             'conditions' => '',
                             'order'      => '',
                             'foreignKey' => 'user_id'
                       )

                 );
	*/
	var $hasMany = array('Announcements', 'Items', 'Registries'/*'Inboxes', 'Comments', 'Suggestions'*/);

     
    public $validate = array(
        
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            ),
            'min_length' => array(
                'rule' => array('minLength', '6'),  
                'message' => 'Password must have a mimimum of 6 characters'
            )
        ),
         
        'password_confirm' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please confirm your password'
            ),
             'equaltofield' => array(
                'rule' => array('equaltofield','password'),
                'message' => 'Both passwords must match.'
            )
        ),
         
        'username' => array(
            'required' => array(
                'rule' => array('email', true),    
                'message' => 'Please provide a valid email address.'   
            ),
             'unique' => array(
                'rule'    => array('isUniqueUsername'),
                'message' => 'This email is already in use',
            ),
            'between' => array( 
                'rule' => array('between', 6, 60), 
                'message' => 'Usernames must be between 6 to 60 characters'
            )
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'user')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        ),

        'refered' => array(
            'required' => array(
                'rule' => 'notEmpty',    
                'message' => 'Please enter the first name of your referal.'   
            ),
             'unique' => array(
                'rule'    => array('nameExists'),
                'message' => 'Please enter an existing member name',
            )
        ),
         
         
        'password_update' => array(
            'min_length' => array(
                'rule' => array('minLength', '6'),   
                'message' => 'Password must have a mimimum of 6 characters',
                'allowEmpty' => true,
                'required' => false
            )
        ),
        'password_confirm_update' => array(
             'equaltofield' => array(
                'rule' => array('equaltofield','password_update'),
                'message' => 'Both passwords must match.',
                'required' => false,
            )
        ),
		
		'email_invite' => array(
            'required' => array(
                'rule' => array('email', true),    
                'message' => 'Please enter the email of your invitee.'   
            )
        )
 
         
    );

    
     
        /**
     * Before isUniqueUsername
     * @param array $options
     * @return boolean
     */
    function isUniqueUsername($check) {
 
        $username = $this->find(
            'first',
            array(
                'fields' => array(
                    'User.id',
                    'User.username'
                ),
                'conditions' => array(
                    'User.username' => $check['username']
                )
            )
        );
 
        if(!empty($username)){
            if($this->data[$this->alias]['id'] == $username['User']['id']){
                return true; 
            }else{
                return false; 
            }
        }else{
            return true; 
        }
    }

    function nameExists($check) {
 
        $username = $this->find(
            'first',
            array(
                'fields' => array(
                    'User.id',
                    'User.first_name'
                ),
                'conditions' => array(
                    'User.first_name' => $check['refered']
                )
            )
        );
 
        if(!empty($username)){
            if($this->data['User']['first_name'] == $username['User']['first_name']){
                return false; 
            }else{
                return true; 
            }
        }else{
            return false; 
        }
    }
 
    /**
     * Before isUniqueEmail
     * @param array $options
     * @return boolean
     */
    function isUniqueEmail($check) {
 
        $email = $this->find(
            'first',
            array(
                'fields' => array(
                    'User.id'
                ),
                'conditions' => array(
                    'User.email' => $check['email']
                )
            )
        );
 
        if(!empty($email)){
            if($this->data[$this->alias]['id'] == $email['User']['id']){
                return true; 
            }else{
                return false; 
            }
        }else{
            return true; 
        }
    }

    function emailExists($check) {
 
        $username = $this->find(
            'first',
            array(
                'fields' => array(
                    'User.id',
                    'User.username'
                ),
                'conditions' => array(
                    'User.username' => $check['email_invite']
                )
            )
        );
 
        if(!empty($username)){
            if($this->data['User']['username'] == $username['User']['username']){
                return false;
            }else{
                return true; 
            }
        }else{
            return false; 
        }
    }
     
    public function alphaNumericDashUnderscore($check) {
        // $data array is passed using the form field name as the key
        // have to extract the value to make the function generic
        $value = array_values($check);
        $value = $value[0];
 
        return preg_match('/^[a-zA-Z0-9_ \-]*$/', $value);
    }
     
    public function equaltofield($check,$otherfield) 
    { 
        //get name of field 
        $fname = ''; 
        foreach ($check as $key => $value){ 
            $fname = $key; 
            break; 
        } 
        return $this->data[$this->name][$otherfield] === $this->data[$this->name][$fname]; 
    } 
 
    /**
     * Before Save
     * @param array $options
     * @return boolean
     */
     public function beforeSave($options = array()) {
        // hash our password
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
         
        // if we get a new password, hash it
        if (isset($this->data[$this->alias]['password_update']) && !empty($this->data[$this->alias]['password_update'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password_update']);
        }
     
        // fallback to our parent
        return parent::beforeSave($options);
    }
 
} ?>