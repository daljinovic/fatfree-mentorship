<?php
session_start();
class CardController extends Controller
{
	/**
	* Check if user has all permissions to actually display card
	*
	* @override
	*/
	function beforeroute ()
	{
		if($this->f3->exists('SESSION.user') == false)
			$this->f3->reroute('@home');
		
		$user = new User($this->db);
		$user->getById($this->f3->get('SESSION.user'));	

		if($this->f3->exists('PARAMS.uid')){
			$cardOwner = new User($this->db);
			$cardOwner->getById($this->f3->get('PARAMS.uid'));

			if($cardOwner->dry())
				$this->f3->reroute('@students');
			
			if( $user->role == 'student' AND $cardOwner->id != $user->id )
					// Student is not allowed to see cards other than his own
				$this->f3->reroute('@home');
				
			if( $user->role == 'mentor' AND $cardOwner->role == 'mentor' )
					// URL parameter is(accidentally) of mentor; his card does not exist
				$this->f3->reroute('@home');
			
		}
	}
	
	// Determine who is logged in user
	// Student can display his card only
	function displayCard ()
	{
		$user = new User($this->db);
		$user->getById($this->f3->get('SESSION.user'));
		
		if($user->role == 'student')
			self::renderCard($user->id);
		elseif($user->role == 'mentor')
			self::renderCard($this->f3->get('PARAMS.uid'));
		else
			$this->f3->error(404);
	}
	
	// Set all data needed and render final view
	function renderCard ($sid)
	{		
		$user = new User($this->db);
		$courses = new Course($this->db);
		$card = new Card($this->db);		
		
		// Courses not enrolled by this student
		$availableCourses = array_udiff(
			$courses->getAll(), $card->getById($sid),
			function ($obj_a, $obj_b) {
					return $obj_a->id - $obj_b->id;
			}
		);

		// Get logged in user and set his navbar
		$user->getById($this->f3->get('SESSION.user'));
		$this->f3->set('nav', ($user->role == 'mentor') ? 'nav_mentor.php' : 'nav_student.php' );	
		
		$user->reset();
		
		// Get this student (card owner)
		$user->getById($sid);
		$this->f3->set('card_owner', $user);
		
		// Set rendering template depending if student is regular or part-time
		$this->f3->set('content', ($user->status == 'redovni') ? 'student_card_regular.php' : 'student_card_parttime.php' );
		$this->f3->set('courses', $availableCourses);
		$this->f3->set('card', $card->getById($sid));		

		echo \Template::instance()->render('home.php');
	}
	
	// Ajax course enroll
	public function ajaxApiCardCourseAdd ()
	{
		$user = new User($this->db);
		$course = new Course($this->db);
		$enroll = new Enrolls($this->db);
		
		$user->getById($this->f3->get('PARAMS.uid'));
		$course->getById($this->f3->get('PARAMS.cid'));
		
		$enroll->add($user->id, $course->id);
		
		$json = array(
			"uid" => $user->id,
			"id" => $course->id,
			"ime" => $course->ime,
			"kod" => $course->kod,
			"program" => $course->program,
			"bodovi" => $course->bodovi,
			"sem" => (($user->status) == "redovni" ? $course->sem_redovni : $course->sem_izvanredni),
			"izborni" => $course->izborni
		);		
		echo json_encode($json);
	}
	
	// Ajax course update (passed, not passed)
	function ajaxApiCardCourseUpdate ()
	{
		$enroll = new Enrolls($this->db);		
		$enroll->edit($this->f3->get('PARAMS.uid'), $this->f3->get('PARAMS.cid'));
		
		$json = array("id" => $this->f3->get('PARAMS.cid'));		
		echo json_encode($json);
	}
	
	// Ajax course unenroll
	function ajaxApiCardCourseRemove ()
	{
		$user = new User($this->db);
		$course = new Course($this->db);
		$enroll = new Enrolls($this->db);
		
		$user->getById($this->f3->get('PARAMS.uid'));		
		$course->getById($this->f3->get('PARAMS.cid'));	
		
		$enroll->delete($user->id, $course->id);		
		
		$json = array(
			"uid" => $user->id,
			"id" => $course->id,
			"ime" => $course->ime,
			"sem" => (($user->status) == "redovni" ? $course->sem_redovni : $course->sem_izvanredni)
		);		
		echo json_encode($json);
	}
	
	/**
	* Generate PDF of this student card and show in browser
	* http://www.fpdf.org/
	* tFPDF version supports UTF-8 Croatian letters
	*/
	function makePDF ()
	{
		if($this->f3->exists('POST.show_pdf_card') == false)
		{
			$this->f3->error(404);
		}
		
		$card = new Card($this->db);
		$card->getById($this->f3->get('POST.userid'));
		
		$user = new User($this->db);
		$user->getById($this->f3->get('PARAM.sid'));
		
		$pdf = new tFPDF();
		$pdf->AddPage();
		
		$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
		$pdf->SetFont('DejaVu','',14);
		
		// Full page width = 210
		$w = array(120, 40, 30);
		$h = 10;
		
		// First line: "Student: red@oss.hr"
		$pdf->Write($h, 'Student:  '.$this->f3->get('POST.username'));
		$pdf->Ln();
		
		// Table header
		$pdf->Cell($w[0], $h, 'Predmet', 1, 0, C);
		$pdf->Cell($w[1], $h, 'Kod', 1, 0, C);
		$pdf->Cell($w[2], $h, 'ECTS', 1, 0, C);
		$pdf->Ln();
		
		// Fill table with data
		$sum = 0;
		while(!$card->dry()) {
			$sum += $card->bodovi;
			$pdf->Cell($w[0], $h, $card->ime, 1, 0, L );
			$pdf->Cell($w[1], $h, $card->kod, 1, 0, L );
			$pdf->Cell($w[2], $h, number_format($card->bodovi), 1, 1, L );
			$card->next();
		}
		
		// Sum up the ECTS points enrolled
		$pdf->Cell(190, $h, 'Upisano ECTS: '.$sum, 1, 1, R );
		
		$pdf->Output();
	}		
	
}