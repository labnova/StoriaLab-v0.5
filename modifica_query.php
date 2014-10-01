<?php

require_once('function.php');

$idIframe=$_POST['idIframe'];


$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_4');

if (mysqli_connect_errno()) {
	echo 'Errore durante la connessione al server MySQL';
	exit();
}


$sql="SELECT * FROM iframe WHERE idIframe=$idIframe";

$collegamento= mysqli_query($conn, $sql);
	
	if(!$collegamento) {
 		die("la richiesta non &egrave; avvenuta..." .mysqli_error($conn));
	}

$risultato="";
while($row=mysqli_fetch_assoc($collegamento)) {
$valore=$row['collegamento'];




$pattern='';

$risultato=preg_match('/d\/(\w+)"/', $valore, $risultato);

$risultato= explode(",", $risultato);

var_dump($risultato). "</br>";

/*
$sql2= "UPDATE iframe SET collegamento='$risultato' LIMIT 2";
$rissql2= mysqli_query($conn, $sql2); */
	
	
}


/*if(!$rissql2) {
 		die("la richiesta non &egrave; avvenuta..." .mysqli_error($conn));
	} else {
	
		echo "upload completato";

	} */


?>