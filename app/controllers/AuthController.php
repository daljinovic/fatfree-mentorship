<?php
session_start();

class AuthController extends Controller
{
	// @override	
	function beforeroute()
	{
		// Override Controller beforeroute(); otherwise it will loop forever
	}
 
	// Process login data
	function login($f3) 
    {
		if($f3->exists('POST.username') == false OR $f3->exists('POST.password') == false) {
			$f3->reroute('@home');
		}

		$f3->set('POST', $f3->clean($f3->get('POST')));
		
        $username = $f3->get('POST.username');
        $password = $f3->get('POST.password');	
		
        $user = new User($this->db);
        $user->getByName($username);
	
		// Check if user exists
        if($user->dry()) {
            $f3->reroute('@home');
        }
		
        if(password_verify($password, $user->password))	{
			self::setSession($user);
        } else {
            $f3->reroute('@home');
        }
    }
	
	
	// Process register data
	function register ($f3)
	{
		if(!$f3->exists('POST.username') OR !$f3->exists('POST.password')
			OR !$f3->exists('POST.repass') OR !$f3->get('POST.status'))
		{
			$f3->reroute('@home');
		}
		
		$f3->set('POST', $f3->clean($f3->get('POST')));
		
		$username = $f3->get('POST.username');
        $password = $f3->get('POST.password');
		$password2 = $f3->get('POST.repass');
		$status = $f3->get('POST.status');
		$role = 'student';
		
		// clean() removes tags <>; trim() removes empty spaces
		if(trim($username) == "" OR trim($password) == "")
			$f3->reroute('@home');		
		
		$user = new User($this->db);
		$user->getByName($username);
		
		// Check if username is taken or repeated passwords don't match
		if(!$user->dry() OR $password != $password2)
			$f3->reroute('@home');
		
		$user->reset();	// Set mapper to none
		$user->add($username, $password, $status, $role);
		self::setSession($user);		
	}
	
	// Set user session
	function setSession ($user)
	{
		$this->f3->set('SESSION.user', $user->id);
		$this->f3->reroute('@home');		
	}
	
	// Process logout
	function logout ()
	{
		(new Card($this->db))->dropView();		
		$this->f3->clear('SESSION');
		$this->f3->reroute('@home');
	}
	
	
}