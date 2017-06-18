<?php

class User extends DB\SQL\Mapper
{
	/* 
	* @ id;
	* @ email;
	* @ password;
	* @ role;
	* @ status;
	*/
	 
    /**
    * Constructor, maps user table fields to php object
    * 
    * @param DB\SQL $db Database connection
    */
    public function __construct(DB\SQL $db) 
    {
        parent::__construct($db, 'korisnici');
    }
	
    // Fetch all users
    public function getAll() 
    {
        $this->load();
        return $this->query;
    }
	
	// Fetch by role
	public function getByRole($role) 
    {
		$this->load(array('role = ?', $role));
        return $this->query;
    }
	
    // Fetch by id  
    public function getById($id) 
    {
        $this->load(array('id=?',$id));
        return $this->query;
    }
    
	// Fetch by username/email
    public function getByName($username) 
    {
        $this->load(array('email=?', $username));
		return $this->query;
    }
	
    // Insert new user
	public function add ($username, $password, $status, $role)
	{		
		$this->email = $username;
		$this->password = password_hash($password, PASSWORD_BCRYPT);
		$this->status = $status;
		$this->role = $role;		
		
		$this->save();
	}
	
	
    // Edit user by id   
    public function edit($id) 
    {
        $this->load(array('id=?',$id));
        $this->copyFrom('POST');
        $this->update();
    }
    
    // Delete user by id  
    public function delete($id) 
    {
        $this->load(array('id=?',$id));
        $this->erase();
    }
	
	
}