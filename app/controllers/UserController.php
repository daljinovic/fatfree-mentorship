<?php
session_start();
class UserController extends Controller
{
	// Controller::beforeroute() will be called before anything here; if not overriden here
    	
	/**
	*	Display users home page
	*/
	function displayHome()
    {		
		$user = new User($this->db);
		$user->getById($this->f3->get('SESSION.user'));
		
		if($user->role == 'student')
			(new CardController($this->db))->displayCard();			
		elseif($user->role == 'mentor')
			$this->f3->reroute('@students');
		else
			$this->f3->error(404);
    }
	
	// Check if logged in user is mentor
	function displayStudents ()
	{
		$user = new User($this->db);
		$user->getById($this->f3->get('SESSION.user'));	
		
		if($user->role != 'mentor')
			$this->f3->reroute('@home');
		
		self::renderStudents();
	}
	
	// Render student list
	function renderStudents ()
	{		
		$this->f3->set('nav', 'nav_mentor.php');
		$this->f3->set('content', 'student_list.php');
		$this->f3->set('students', (new User($this->db))->getByRole('student'));
		
		echo \Template::instance()->render('home.php');		
	}
    
    
}