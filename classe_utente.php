<?php

require_once('database.php');



class Utente {

	public function find_all() {

	global $database;
	$result_set= $database->query('SELECT * FROM users');
	return $result_set;

	}
	
	public static function find_by_id($id=0) {
	
	global $database;
	$result_set= $database->query('SELECT * FROM users WHERE id=" id " ');
	$found= $database->fetch_array($result_set);
	return $found;
	
	}
	
	public static function find_by_sql($sql="") {
	
	global $database;
	$result_set= $database->query($sql);
	return $result_set;
	
	}


	



$sql="SELECT * FROM utenti WHERE id='1' ";
$result_set= $database->query($sql);
$found_user= $database->fetch_array($result_set);
echo $found_user['username'];







function credenziali($nom, $cogn, $mai, $conne) {

	$this->nome= $nom;
	$this->cognome= $cogn;
	$this->email= $mai;
	$this->connessioni= $conne;



	}
	
	
	function sentimenti($sent, $gen)  {

	$this->sentimenti= $sent;
	$this->genere= $gen;
	
}

	function cont_iframe($num) {
	
		if($num==is_array($num_prec)) {
		
		
		$richiesta .= "AND genere= 'rock' ";
		$richiesta .= "AND citazioni.sentimento =  'felice' ";
		$richiesta .= "ORDER BY RAND()";
		$richiesta .= "LIMIT 1";
		
		$risultato= mysqli_query($conn, $richiesta);
	
		if(!$risultato) {
 		die("la richiesta non &egrave; avvenuta...");
		}
		
		
		}


	} 
	
	
	}


	



	
	/*  */
	
	/*
	
	public $sentimenti;
	static public $total_sentimenti=0;
	
	
	function _construct() {
	
	$this->sentimenti=4;
	utente::$total_sentimenti++;
	
	}
	
	
	$utente= new utente();
	echo $utente->sentimenti ."<br/>";
	
	echo utente::$total_sentimenti . "<br/>";
	$t1= new utente();
	echo utente::$total_sentimenti. "<br/>";
	$t2= new utente();
	echo utente::$total_sentimenti . "<br/>";

	
	
	*/

?>