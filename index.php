
<?php 


session_start();

function criptaPassword($pass) {
	$password=$pass;
	$hash_format="$2y$10$";
	$salt='ciaoFacciamo22caratteri';

	$insieme= $hash_format . $salt;

	$hash=crypt($password, $insieme);

	return $hash;
}

/*

function confrontaPassword($id, $pass) {
	$utente=$id;
	$confronta=false;
	$password=$pass;

	$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');

if (mysqli_connect_errno()) {
	echo 'Errore durante la connessione al server MySQL';
	exit();
} 

$sql= mysqli_query($conn, "SELECT password FROM utente WHERE Nome='$utente' ");

if(!$sql) 
	 { die('problemi...' .mysqli_error($conn));}

$row=mysqli_fetch_assoc($sql);

if($password==$row['password']) { $confronta=true; }



return $confronta;

var_dump($confronta);

}

*/

$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');

if (mysqli_connect_errno()) {
	echo 'Errore durante la connessione al server MySQL';
	exit();
} 



if(isset($_POST['accedi'])) {

	$nome=$_POST['nome'];
	$password=$_POST['password'];
	$password= criptaPassword($password);

	$_SESSION['nome']= $nome;
$_SESSION['password']=$password;

$sql= mysqli_query($conn, "SELECT password FROM utente WHERE Nome='$nome' ");

if(!$sql) 
	 { die('problemi...' .mysqli_error($conn));}

$row=mysqli_fetch_assoc($sql);

$valore=$row['password'];



if($password==$valore) { 

	$_SESSION['login'] = "verificata"; 
            header("Location:principale.php");  
 
    /* inserire su questa riga la password voluta $password="r05xWRtI";  */
if (isset($_SESSION['login'])) {  
    if (isset($_POST['logout'])) { 
        unset($_SESSION['login']); 
        $messaggio = "Logout effettuato con successo! Arrivederci!"; 
        session_destroy();
    
} else { 

	

	
		
							$year = time() + 31536000;	
		
							
							if($_POST['remember']) {
								setcookie('remember_me', $_POST['password'], $year);
							}

					elseif(!$_POST['remember']) {
						
					if(isset($_COOKIE['remember_me'])) {
					$past = time() - 100;
					setcookie(remember_me, gone, $past);
	}
}
				
			 
        }


        

    }


         
    }  else { echo "non sei iscritto!";}
 


}




if(isset($_POST['iscriviti'])) {



$nome= $_POST['nome'];
$cognome= $_POST['cognome'];
$mail= $_POST['mail'];
$sesso= $_POST['sesso'];
$nascita= $_POST['nascita'];
$categoria= $_POST['scelta'];
$password= $_POST['password'];
$fattoreL=$_POST['fattoreL'];



$categoria= implode(",", $categoria);


$criptapassword= criptaPassword($password);

$_SESSION['nome']= $nome;
//$_SESSION['password']=$password;

$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');

if (mysqli_connect_errno()) {
	echo 'Errore durante la connessione al server MySQL';
	exit();
} 

$query= "INSERT INTO utente (Nome, Cognome, mail, Sesso, Nascita, categoria, password, fattoreL) 
					VALUES ('{$nome}','{$cognome}', '{$mail}', '{$sesso}', '{$nascita}', '{$categoria}',  '$criptapassword', '{$fattoreL}' )";
					
$risultato= mysqli_query($conn, $query);

if(!$risultato) {
	die("il database ha qualche problema... " .mysqli_error);
}

$_SESSION['login'] = "verificata"; 

header('Location:principale.php');



$oggetto= "Nuova iscrizione allo STORYLAB";
$messaggio="Ciao! Grazie per esserti iscritto alla piattaforma StoryLab. 
Ecco i tuoi dati completi:

Nome utente: ".$nome." 
Password: ".$password." 

nome: ".$nome." 
cognome: ".$cognome."
Fattore L: ".$fattoreL."
categoria scelta: " .$categoria."";

strip_tags(trim(stripslashes($messaggio)));

if(!@mail($mail, $oggetto, $messaggio)) {


echo"<p>qualcosa &egrave; andato storto. Riprova l'iscrizione. 
<a href='index.php'>torna indietro</a>";
}





}

?>

<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" >
<link rel="stylesheet" href="css/rangeslider.css">
<link rel="stylesheet" type="text/css" href="css/demo.css" />
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans+SC' rel='stylesheet' type='text/css'>
<style type="text/css">

.sesso {
	font-size:15px;
	font-style: italic;
	text-align: center;
	display: block;
	margin: 0 auto;
	border-radius: 10px;


}

label {
	margin: 20px auto;
}

select {
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

input[type='range'] {

margin: 30px auto;


}
</style>


</head>

<div id="container">
<body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>

<script type="text/javascript" src="bootstrap/js/bootstrap.min.js" ></script>

<div class="row col-md-6">
<div class="form_wrapper">
<?php conteggi(); ?> 

<form action=" <? $_SERVER['PHP_SELF']; ?>" method="post">
<label>Gi&agrave; iscritto? Accedi con le credenziali</label>
<input type="text" name="nome" placeholder="inserisci il tuo nome utente"></input><br/>
Inserisci la password<input type="password" name="password" 
        value="<?php echo $_COOKIE['remember_me']; ?>" placeholder="INSERISCI IL CODICE"/> 
        <br />
        <input type="checkbox" name="remember" <?php if(isset($_COOKIE['remember_me'])) {
		echo 'checked="checked"';
	}
	else {
		echo '';
	}
	?> >Ricorda la password<input type="submit" name="accedi" value="accedi!" />
</form>
</div>
</div>





<form class=" row col-md-4 col-md-offset-1 form_wrapper" action=" <? $_SERVER['PHP_SELF']; ?>" method="post">
<label style="font-size:50px !important;">Iscriviti ora!</label>
<label>Nome</label><input type="text" name="nome" placeholder="inserisci il tuo nome"  /><br/>
<label>Cognome</label><input type="text" name="cognome" placeholder="inserisci il tuo cognome"  /><br/>

<label>Sesso</label>
<div class="sesso">
<input type="radio" name="sesso" value="maschio" /><p id="sesso" >Maschio</p>

<input type="radio" name="sesso" value="femmina"  /><p id="sesso" >Femmina</p><br/>
</div>
<label>Data di nascita</label>
<input type="date"  max="03/01/2020" name="data_di_nascita" placeholder="inserisci la tua data di nascita" /><br/>
<br/>



<label>Indirizzo mail</label><input type="email" name="mail" placeholder="inserisci la mail"  /><br/>

<label>Seleziona la tua categoria preferita</label>

 <select name="scelta[]" >
	<option  value="rock">ROCK</option>
	<option  value="classica">CLASSICA</option>
	<option  value="elettronica">ELETTRONICA</option>
	<option  value="pop">POP</option>
</select>

<label>Inserisci un valore casuale <br/> (sar&agrave; il tuo fattore L)</label><!-- <input type="text" name="fattore" placeholder="inserisci il tuo fattore" /> -->
<br/><br/>
<div id="js-example-change-value">
       
        <input type="range" name="fattoreL" min="1" max="5000" data-rangeslider>
        <output></output>
     <!--   <input type="number"  placeholder="inserisci il tuo fattore"> -->
    </div>

</select> <br/><br/><br/><br/> 

<label>Crea una nuova password</label>
<input type="password" name="password" value="<?php echo $_COOKIE['remember_me']; ?>" placeholder="Crea una nuova password"/> 
        <br />
        <input type="checkbox" name="remember" <?php if(isset($_COOKIE['remember_me'])) {
		echo 'checked="checked"';
	}
	else {
		echo '';
	}
	?> />Ricorda la password<br/><br/><br/><br/>

<input type="submit" name="iscriviti" value="Iscriviti!" />




<?
function conteggi() {

	$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');

if (mysqli_connect_errno()) {
	echo 'Errore durante la connessione al server MySQL';
	exit();
} 

$sql= mysqli_query($conn, "SELECT COUNT(idiFrame) FROM iframe");

if(!$sql) {
	die("il database ha qualche problema... " .mysqli_error($conn));
}

echo "<div class='conteggio'> ". implode(" ", mysqli_fetch_assoc($sql)) . " canzoni totali nel database</div>";

echo "<br/>";
echo "<br/>";


$sql= mysqli_query($conn, "SELECT COUNT(idiFrame) FROM iframe WHERE genere='1'");

if(!$sql) {
	die("il database ha qualche problema... " .mysqli_error($conn));
}

echo "<div class='conteggio'> ". implode(" ", mysqli_fetch_assoc($sql)) . "<div style='font-size:20px;'> genere POP</div></div>";

echo "<br/>";
echo "<br/>";

$sql= mysqli_query($conn, "SELECT COUNT(idiFrame) FROM iframe WHERE genere='2'");

if(!$sql) {
	die("il database ha qualche problema... " .mysqli_error($conn));
}

echo "<div class='conteggio'> ".  implode(" ", mysqli_fetch_assoc($sql)) . "<div style='font-size:20px;'> genere ROCK</div></div>";

echo "<br/>";
echo "<br/>";

$sql= mysqli_query($conn, "SELECT COUNT(idiFrame) FROM iframe WHERE genere='20'");

if(!$sql) {
	die("il database ha qualche problema... " .mysqli_error($conn));
}

echo "<div class='conteggio'> ".  implode(" ", mysqli_fetch_assoc($sql)) . "<div style='font-size:20px;'> genere MUSICA ITALIANA</div></div>";

echo "<br/>";
echo "<br/>";

$sql= mysqli_query($conn, "SELECT COUNT(idiFrame) FROM iframe WHERE genere='17'");

if(!$sql) {
	die("il database ha qualche problema... " .mysqli_error($conn));
}

echo "<div class='conteggio'> ".  implode(" ", mysqli_fetch_assoc($sql)) . "<div style='font-size:20px;'> genere MUSICA D'AUTORE</div></div>";

echo "<br/>";
echo "<br/>";


}


?>

    <script src="js/rangeslider.min.js"></script>
    <script>
        $(function() {
        
         var $document   = $(document),
                selector    = '[data-rangeslider]',
                $input      = $(selector);

            $document.on('change', selector, function(e) {
                var value = e.target.value,
                    output = e.target.parentNode.getElementsByTagName('output')[0];
                output.innerHTML = value;
            });

            $input.rangeslider({

                // Deactivate the feature detection
                polyfill: false,

                // Callback function
                onInit: function() {},

                // Callback function
                onSlide: function(position, value) {},

                // Callback function
                onSlideEnd: function(position) {}
            });
        
       	  // Example functionality to demonstrate programmatic value changes
            $document.on('click', '#js-example-change-value button', function(e) {
                var $inputRange = $('input[type="range"]', e.target.parentNode),
                    value = $('input[type="number"]', e.target.parentNode)[0].value;

                $inputRange.val(value).change();
            });

            
            

            

        }); 
    </script>
</form>

</div> <!--container -->
</body>


</html>