<?php

class Card extends DB\SQL\Mapper
{
	/**
    * Constructor, maps user table fields to php object
	*
    * Creates temporary VIEW in database that represents student's enrolled courses; F3 mapper doesn't support ManyToMany JOIN
	* Returns: course object, user id, user status
    * @param DB\SQL $db Database connection
    */
	public function __construct (DB\SQL $db)
	{		
		$db->exec("DROP VIEW IF EXISTS studentCoursesOnCard");
		
		$db->exec("CREATE VIEW studentCoursesOnCard AS
						SELECT p.*, u.student_id, u.status
						FROM predmeti p INNER JOIN upisi u
						ON p.id = u.predmet_id");
						
		parent::__construct($db, 'studentCoursesOnCard');		
			
	}
	
	// Fetch card by user id
	public function getById ($uid)
	{
		$this->load(array('student_id = ?', $uid));
		return $this->query;
	}
	
	// Drop view
	public function dropView ()
	{
		$this->db->exec("DROP VIEW IF EXISTS studentCoursesOnCard");		
	}
	
}