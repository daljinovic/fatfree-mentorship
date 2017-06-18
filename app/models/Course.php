<?php

class Course extends DB\SQL\Mapper
{
	/* 
	* @ id;
	* @ ime;
	* @ kod;
	* @ program;
	* @ bodovi;
	* @ sem_redovni;
	* @ sem_izvanredni;
	* @ izborni;
	*/
	
	/**
    * Constructor, maps user table fields to php object
    * 
    * @param DB\SQL $db Database connection
    */
	public function __construct (DB\SQL $db)
	{
		parent::__construct($db, 'predmeti');
	}
	
	// Fetch all courses
	public function getAll()
	{
		$this->load();
		return $this->query;
	}
	
	// Fetch course by id
	public function getById ($cid)
	{
		$this->load(array('id = ?', $cid));
		return $this->query;
	}

	// Insert new course
	public function add ($f3)
	{
		$f3->set('POST', $f3->clean($f3->get('POST')));
		
		$this->ime = $f3->get('POST.ime');
		$this->kod = $f3->get('POST.kod');
		$this->program = $f3->get('POST.program');
		$this->bodovi = $f3->get('POST.bodovi');
		$this->sem_redovni = $f3->get('POST.sem_redovni');
		$this->sem_izvanredni = $f3->get('POST.sem_izvanredni');
		$this->izborni = $f3->get('POST.izborni');
		
		$this->save();
	}
	
	// Edit specific course by id
	public function edit ($cid)
	{
		$f3 = Base::instance();		
		$this->load(array('id = ?', $cid));		
		$this->copyFrom('POST');		
		$this->update();
	}
	
}