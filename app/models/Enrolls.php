<?php

class Enrolls extends DB\SQL\Mapper
{
	/* 
	*@ student_id;
	*@ predmet_id;
	*@ status;
	*/
	 
	/**
    * Constructor, maps user table fields to php object
    * 
    * @param DB\SQL $db Database connection
    */
	public function __construct (DB\SQL $db)
	{
		parent::__construct($db, 'upisi');
	}
	
	// Insert enrolled course
	public function add ($uid, $cid)
	{		
		$this->db->exec(
			array('INSERT INTO upisi (student_id, predmet_id, status) VALUES (?, ?, ?)'),
			array(array(1 => $uid, 2 => $cid, 3 => 'enrolled'))
		);
		
	}
	
	// Edit card-course status (enrolled OR passed)
	public function edit ($uid, $cid)
	{
		$this->load(array('student_id=? AND predmet_id=?', $uid, $cid));
		
		if($this->status == 'enrolled')
		{
			$this->db->exec(
				array('UPDATE upisi SET status = "passed" WHERE student_id = ? AND predmet_id = ?'),
				array(array(1 => $uid, 2 => $cid))
			);
		} else
		{
			$this->db->exec(
				array('UPDATE upisi SET status = "enrolled" WHERE student_id = ? AND predmet_id = ?'),
				array(array(1 => $uid, 2 => $cid))
			);
		}
	}
	
	// Delete course from the list
	public function delete ($uid, $cid)
	{		
		$this->db->exec(
			array('DELETE FROM upisi WHERE student_id = ? AND predmet_id = ?'),
			array(array(1 => $uid, 2 => $cid))
		);		
	}
	

}