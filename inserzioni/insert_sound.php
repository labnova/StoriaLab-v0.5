<?php
error_reporting(E_ALL^ E_WARNING); 
error_reporting(E_ALL^ E_NOTICE); 





require_once('../function.php');





if(isset($_POST['submit'])) {





$valori_selezionati=0;

$titolo=$_POST['titolo'];
$cognome=$_POST['artista'];
$collegamento= $_POST['collegamento'];
$sentimento=$_POST['scelta']; 

if($sentimento="") { $sentimento=rand(195, 217); }

if(isset($_POST['personale_sentimento'])) {
		
		$sentimento=$_POST['personale_sentimento']; 

	} 
	
	
	
$genere=$_POST['genere'];
$simili=$_POST['simili'];
$scena=$_POST['scena'];

$i= rand(1, 10000);       //$i=$_POST['i'];
$im= rand(1, 10000);                     //$im=$_POST['im'];
$f= rand(1, 10000);                        //$f=$_POST['f'];
$cm=  rand(1, 10000);                      //$cm=$_POST['cm'];
$c=  rand(1, 10000); 						//$cm=$_POST['c'];
$fattore_L=  rand(1, 10000);



//$sentimento= numero_sentimento($sentimento);
$collegamento=extractUTubeVidId($collegamento);

 
//$genere= numero_genere($genere);

//$simili=numero_genere($simili);



$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');

$valore=controllaRecord($titolo);

if($valore=="si") {

chiamaUpdate($string= " collegamento='{$collegamento}' ", $titolo);
chiamaUpdate($string= "sentimento='$sentimento' ", $titolo);
chiamaUpdate($string= "scena='$scena' ", $titolo);
chiamaUpdate($string= "simili='{$simili}' ", $titolo);
chiamaUpdate($string= "fattoreL='$fattore_L' ", $titolo);

chiamaUpdate($string= "valore_i='$i' ", $titolo);
chiamaUpdate($string= "valore_im='$im' ", $titolo);
chiamaUpdate($string= "valore_f='$f' ", $titolo);
chiamaUpdate($string= "valore_cm='$cm' ", $titolo);
chiamaUpdate($string= "valore_c='$c' ", $titolo);



} else {


$query= "INSERT INTO soundtrack (titolo, autore, film, collegamento, simili, sentimento, scena, fattoreL, valore_i, valore_im, valore_f, valore_cm, valore_c ) 
VALUES ('{$titolo}','{$cognome}', '{$film}', '{$collegamento}', '{$simili}', '{$sentimento}',  '{$scena}','{$fattore_L}', '{$i}', '{$im}', '{$f}', '{$cm}', '{$c}' )";
					
$risultato= mysqli_query($conn, $query);

if(!$risultato) {
	die("il database ha qualche problema... " .mysqli_error($conn));
}

}














}
  
  
function controllaRecord($tit) {


$titolo=$tit;

$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');

$controllo=mysqli_query($conn, "SELECT titolo FROM soundtrack WHERE titolo='{$titolo}'");

$trovato = "";

if(mysqli_num_rows($controllo) > 0) {

 $trovato='si'; } 
 
 else { $trovato='no'; }
 
return $trovato;

var_dump($trovato);



}


function chiamaUpdate($concat, $tit) {

$titolo=$tit;

$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');


$aggiornamento="UPDATE soundtrack SET ";
$aggiornamento .= $concat;
$aggiornamento .= " WHERE titolo='{$titolo}'  ";

$risultato= mysqli_query($conn, $aggiornamento);

if(!$risultato) {
	die("il database ha qualche problema... " .mysqli_error($conn));
}

}



?> 

<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	
<style type="text/css">

@font-face {
font-family: 'font';
src:url(font/font.woff);

}

body {
width:100%;
font-family: 'font', Calibri, Arial, sans-serif;



}

form {
	padding: 20px;
 	background: #bfd9e6;
    border-radius: 4px;
    color: #7e7975;
    box-shadow:
        0 2px 2px rgba(0,0,0,0.2),        
        0 1px 5px rgba(0,0,0,0.2),        
        0 0 0 12px rgba(255,255,255,0.4); 


}



input, select {
	font-size:20px;
	display:block;
	margin-left:auto;
	margin-right:auto;
	position:relative;
	width:40%;
 border: 3px solid #ebe6e2;
 -webkit-transition: all 0.3s ease-out;
    -moz-transition: all 0.3s ease-out;
    -ms-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;


}



input[type="text"], input[type="email"], input[type="date"], select {
margin-top: 1em;
width: 60%;
padding: 10px;
text-align:center;
border-radius: 10px;
box-shadow: 
		0 0 1px rgba(0,0,0, 0.3),
		0 3px 7px rgba(0,0,0, 0.3),
		inset 0 1px rgba(128,128,128,1),
        inset 0 -3px 2px rgba(0,0,0,0.25);

}


label {

text-align:center; 

}

input[type="radio"] {


width:30px;
display:block;
margin-left:auto;
margin-right:auto;
position:relative;



}

 #sesso, #consenso {

display:block;
margin-left:auto;
margin-right:auto;
position:relative;
font-size:20px;


}

input[type="submit"] {
	display:block;
	margin-left:auto;
	margin-right:auto;
	font-size:25px;
 	width:80%;
 	border-radius:20px;
    background: #fbd568; /* Fallback */
    background: -moz-linear-gradient(#fbd568, #ffb347);
    background: -ms-linear-gradient(#fbd568, #ffb347);
    background: -o-linear-gradient(#fbd568, #ffb347);
    background: -webkit-gradient(linear, 0 0, 0 100%, from(#fbd568), to(#ffb347));
    background: -webkit-linear-gradient(#fbd568, #ffb347);
    background: linear-gradient(#fbd568, #ffb347);
    border: 1px solid #f4ab4c;
    color: #996319;
    text-shadow: 0 1px rgba(255,255,255,0.3);


}

label {
	color:black !important;
	font-size: 25px;
	margin-right:20px;
}
</style>
</head>


 <body>
 
<div class="container">
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" >

<label>Nome canzone</label><input type="text" name="titolo" placeholder="inserisci il nome della canzone"  /><br/>
<label>Autore canzone</label><input type="text" name="artista" placeholder="inserisci il nome dell'artista"  /><br/>
<label>Film</label><input type="text" name="film" placeholder="inserisci il nome del film"  /><br/>

<label>iFrame soundtrack (da Youtube)</label><input type="text" name="collegamento" placeholder="inserisci il collegamento alla canzone"  /><br/>


<br/><br/><br/>
<label>Scrivi un numero da 1 a 1500</label><input type="text" name="fattore_L" placeholder="inserisci il tuo fattore_L" /><br/>

<!--
<label>Scrivi un numero da 1 a 1500 (interesse per il video)</label><input type="text" name="i" placeholder="interesse per il video"  /><br/>
<label>Scrivi un numero da 1 a 1500 (impatto nella vita altrui)</label><input type="text" name="im" placeholder="impatto nella vita altrui"  /><br/>
<label>Scrivi un numero da 1 a 1500 (potere di fantasia)</label><input type="text" name="f" placeholder="potere di fantasia"  /><br/>
<label>Scrivi un numero da 1 a 1500 (antipatia generata dagli altri)</label><input type="text" name="cm" placeholder="antipatia generata dagli altri"  /><br/>
-->

<br/>


<label>Cosa ti provoca questa canzone?</label>
<!--
<select name="scelta" size='6' >
	<option  value="malinconia">MALINCONIA</option>
	<option  value="felice">FELICITA'</option>
	<option  value="riflessione">RIFLESSIONE</option>
	<option  value="armonia">ARMONIA</option>
	
</select> <br/><br/><br/><br/> -->
<label>inserisci il tuo personale sentimento</label><input type="text" name="personale_sentimento" placeholder="inserisci il tuo personale sentimento" /><br/>

<label>Generi simili</label><input type="text" name="simili" placeholder="inserisci i Generi simili" /><br/>


<label>Dove collocheresti questa canzone?</label>
<select name="scena" size='6' >
	<option  value="inizio">inizio</option>
	<option  value="scena_1">scena_1</option>
	<option  value="scena_2">scena_2</option>
	<option  value="fine">fine</option>
	
</select> <br/><br/><br/><br/>


<!--<label><p style="text-align:center;">Scrivi il codice nell'immagine <br/>(in minuscolo)</p></label>
<img style="display:block; margin-left:auto; margin-right:auto;" id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
<a href="#" onclick="document.getElementById('captcha').src =
 'securimage/securimage_show.php?'
 + Math.random(); return false"><p style="text-align:center;">[ Usa un'altra immagine ]</p></a>
<input type="text" style="width:300px !important; margin-bottom:10px !important; margin-top: -5px !important; " name="captcha_code" size="10" maxlength="6" />-->


<input type="submit" name="submit" value="Invia contributo" />
</form>
</div>
</body>


</html>

