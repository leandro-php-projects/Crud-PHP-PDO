<?php
class database extends PDO
{
	private $dsn      = 'mysql:dbname=crud_php;host=localhost';
	private $user     = 'root';
	private $password = '';
	public  $handle   = NULL;
	
	public function __construct()
	{
		try{
		  if($this->handle== NULL)
		  {
		   $dbh = parent::__construct($this->dsn, $this->user, $this->password); 
		   $this->handle = $dbh;
		 
		   return $this->handle;		 
		  }
		}catch(PDOException $e){
		  echo 'Error: '.$e->getMessage();
		  return false;
		}
	}
	
	public function __destruct()
	{
	  $this->handle = NULL;
	}
	
	
	
}
