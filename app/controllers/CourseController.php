<?php
session_start();
class CourseController extends Controller
{
	// Check if user is logged on; check if role is 'mentor'
	// @override
	function beforeroute ()
	{
		if(!$this->f3->exists('SESSION.user'))
			$this->f3->reroute('@home');
		
		$user = new User($this->db);
		$user->getById($this->f3->get('SESSION.user'));
		
		if($user->role != 'mentor')
			$this->f3->reroute('@home');
	}
	
	
	function displayCourses ($f3)
	{
		$f3->set('nav', 'nav_mentor.php');
		$f3->set('content', 'course_list.php');
		$f3->set('courses', (new Course($this->db))->getAll());
		
		echo \Template::instance()->render('home.php');		
	}
	
	// Display course form
	// Both insert and edit render same template
	function displayOneCourse ($f3)
	{		
		$f3->set('nav', 'nav_mentor.php');
		
		$course = new Course($this->db);
		$course->getById($f3->get('PARAMS.cid'));
		
		if($f3->exists('PARAMS.cid') && !$course->dry())
			$f3->set('course', $course);
		else
			$f3->set('course', NULL);
		
		$f3->set('content', 'course_form.php');		
		echo \Template::instance()->render('home.php');
	}
	
	
	function insertCourse($f3)
	{
		if($f3->exists('POST.cancel'))
			$f3->reroute('@courses');
		
		if($f3->exists('POST.add_course'))
			(new Course($this->db))->add($f3);			
		
		$f3->reroute('@course_add');
	}
	
	// Update course
	// URL parameters are set in $args which is automatically passed
	function updateCourse($f3, $args)
	{		
		if($f3->exists('POST.cancel'))
			$f3->reroute('@courses');
		
		if($f3->exists('POST.edit_course'))
			(new Course($this->db))->edit($args['cid']);
		
		$f3->reroute('@courses');
	}
	
}