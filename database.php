<?php


class database {

private $connessione;

function apriConnessione() {

//query per la connessione al database
$this->connessione= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');

if (!$this->connessione) {
	die('Errore durante la connessione al server MySQL' .mysqli_error($this->connessione));
	
}

}


/*query per la mail
$query= "INSERT INTO iscrizioni (Nome, Cognome, Mail) 
					VALUES ('{$nome}','{$cognome}', '{$mail}')";
					
$risultato= mysqli_query($this->connessione, $query);

if(!$risultato) {
	die("il database ha qualche problema... " .mysqli_error);
} */

<h1>
public function chiudiConnessione() {

	if(isset($this->connessione)) {

	mysqli_close($this->connessione);
	unset($this->connessione);

	}

}


}

$database=new database();
$database->apriConnessione();



?>