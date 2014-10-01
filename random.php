<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css.map">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/demo.css" />



	<title></title>
</head>
<body>

</body>
</html>
<?php

error_reporting(E_ALL^ E_WARNING); 
error_reporting(E_ALL^ E_NOTICE); 

session_start();

require_once('function.php');

function assegnaVideoCasuale($sen, $sce, $idUtente, $altroUtente) {



$scelta=$sce;
$sentimento= $sen;

if ($sentimento=="") { $sentimento= rand(195, 217); }

$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');

if (mysqli_connect_errno()) {
	echo 'Errore durante la connessione al server MySQL';
	exit();
}

$richiesta = "SELECT * FROM iframe ";
$richiesta .= " WHERE idiFrame= FLOOR(1+ RAND()*50) ";
//$richiesta .= " AND sentimento= '$sentimento') ";
$richiesta .= " LIMIT 1";


$sql= mysqli_query($conn, $richiesta);

if(!$sql) {
 		die("la richiesta non &egrave; avvenuta..." .mysqli_error($conn));
	}




	
echo "<p>il video casuale &egrave; </p>";

while($row=mysqli_fetch_assoc($sql)) {



echo  $row['idiFrame'] ."<br/>";
				echo  $row['canzone'] ."<br/>";
				echo  "<iframe width='420' height='315' src='//www.youtube.com/embed/".$row['collegamento']."?autoplay=1'  frameborder='0' allowfullscreen></iframe><br/>";
				echo $fattoreU;
				echo "<p style='font-size:30px;'>" . $row['fattore_L'] ."</p><br/>";

				echo "<a href='principale.php'>torna indietro</a> ";
				
//var_dump($scelta);

//switch($scelta) {

//case "si":


$rich2= mysqli_query($conn, "UPDATE utente SET iframeAssegnati=".$row['idiFrame']." WHERE idUtente='$idUtente'");
if(!$rich2) {
 		die("la richiesta non &egrave; avvenuta..." .mysqli_error($conn));
	}
	
$rich3= mysqli_query($conn, "UPDATE utente SET sentimentoAssegnato='$sentimento' WHERE idUtente='$idUtente'");
if(!$rich3) {
 		die("la richiesta non &egrave; avvenuta..." .mysqli_error($conn));
	}

$rich4= mysqli_query($conn, "UPDATE utente SET altriUtenti='$altroUtente' WHERE idUtente='$idUtente'");
if(!$rich3) {
 		die("la richiesta non &egrave; avvenuta..." .mysqli_error($conn));
	}

$rich5= mysqli_query($conn, "INSERT INTO assegnamenti (idEmittente, idRicevente, idCanzone) VALUES ('{$altroUtente}', '{$idUtente}', ".$row['idiFrame'].")");
if(!$rich5) {
 		die("la richiesta non &egrave; avvenuta..." .mysqli_error($conn));
	}
	
//break;

//case "no":

//assegnaVideoCasuale($sentimento, $scelta,$idUtente);
//break;

	}

}




//}


if(isset($_POST['submit'])) {

$altroUtente=$_SESSION['idUtente'];

var_dump($altroUtente);


$nome=$_SESSION['nome'];



$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');

if (mysqli_connect_errno()) {
	echo 'Errore durante la connessione al server MySQL';
	exit();
}

$richiesta2=mysqli_query($conn, "SELECT Nome FROM utente WHERE idUtente='$idUtente'");
if(!$richiesta2) {
 		die("la richiesta non &egrave; avvenuta..." .mysqli_error($conn));
	}

$nome=mysqli_fetch_assoc($richiesta2);
$nome=$nome['Nome']; 

var_dump($sql);

$sql= mysqli_query($conn,"SELECT * FROM utente ORDER BY RAND() LIMIT 1");

if(!$sql) {
 		die("la richiesta non &egrave; avvenuta..." .mysqli_error($conn));
	}



while($row=mysqli_fetch_assoc($sql)) {



echo "il nome &egrave; ". $row['Nome'] .'<br/>'; 
echo "il cognome &egrave; ".  $row['Cognome'] .'<br/>'; 
echo "i commenti sono ".  $row['racconti'] .'<br/>'; 

echo "hai assegnato un video e un sentimento a " . $row['Nome'] . '<br/>';
/*
echo "<form action='$_SERVER[PHP_SELF]' method='post' >";
echo "<input type='text' name='sentimento' placeholder='sentimento' />";
echo "<p>confermi la scelta?</p>";
echo "<input type='radio' name='scelta[]' value='si'>Si<br/>";
echo "<input type='radio' name='scelta[]' value='no'>No<br/>";
echo "<input type='submit' name='submit' value='invia' />";
echo "</form>";
*/
$sentimento= numero_sentimento($sentimento);
assegnaVideoCasuale($sentimento, $scelta,$row['idUtente'], $altroUtente);

}






}





?>