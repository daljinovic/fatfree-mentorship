<?php
session_start();
class Controller
{
    protected $f3;
    protected $db;
	
    /**
     * The beforeroute event handler is provided by f3 and it is 
     * automatically invoked by f3 before every time routing happens
     *
     * If session exists, don't allow login screen access
	 * If not, make sure user is redirected to login
	 * Will not work if beforeroute() is overriden in controllers
     *
     * @return void 
    */
    function beforeroute()
    {
        if($this->f3->exists('SESSION.user') == false)
		{
			echo \Template::instance()->render('login.php');
            exit;
        }		
		//if($this->f3->get('SERVER.REQUEST_URI') == '/login')
		if($this->f3->get('PARAMS[0]') == '/login')
			$this->f3->reroute('@home');
		
    }
	
	
    /**
     * The afterroute event handler is provided by f3 and it is 
     * automatically invoked by f3 after every time routing happens
     *
     * The below code is just a placeholder 
     *
     * @return void 
     */
    function afterroute()
    {
        // your code comes here
    }
	
	
    /**
     * Class constructor 
     * We connect to the mysql database here and  
     * Assign value to f3 and db protected class variables defined above
     *
     * @return void 
     */
    function __construct()
    {   
        $f3=Base::instance();
        $this->f3=$f3;
        
        $db=new DB\SQL(
            $f3->get(DB_CONN),
            $f3->get(DB_USERNAME),
            $f3->get(DB_PASSWORD),
            array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION )
        );
        $this->db=$db;
    }

	
}