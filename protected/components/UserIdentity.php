<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    public $userType = 'Front';
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
    {
        if($this->userType=='Front') // This is front login
        {
            // check if login details exists in database
            $record=User::model()->findByAttributes(array('username'=>$this->username)); 
            if($record===null)
            { 
                $this->errorCode=self::ERROR_USERNAME_INVALID;
            }
            else if($record->password!==$this->password)            // here I compare db password with password field
            { 
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }
            else
            {  
                $this->setState('userId',$record->userId);
                $this->setState('name', $record->firstName.' '.$record->lastName);
                $this->errorCode=self::ERROR_NONE;
            }
            return !$this->errorCode;
        }
        if($this->userType=='Back')// This is admin login
        {
            // check if login details exists in database
                        $record=AdminUser::model()->findByAttributes(array('email'=>$this->username));  // here I use Email as user name which comes from database
            if($record===null)
            { 
                $this->errorCode=self::ERROR_USERNAME_INVALID;
            }
            else if($record->password!==base64_encode($this->password)) // let we have base64_encode password in database
            { 
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }
            else
            {  
                $this->setState('isAdmin',1);
                $this->setState('userId',$record->userId);
                $this->setState('name', $record->name);
                $this->errorCode=self::ERROR_NONE;
            }
            return !$this->errorCode;
        }
    }
}