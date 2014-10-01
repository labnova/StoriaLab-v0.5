<?php
error_reporting(E_ALL^ E_WARNING); 
error_reporting(E_ALL^ E_NOTICE); 





require_once('../function.php');





if(isset($_POST['submit'])) {





$valori_selezionati=0;

$autore=$_POST['autore'];
$citazione=$_POST['citazione'];
$sentimento= $_POST['sentimento'];
$fattore_L=$_POST['fattore_L']; 
$simili=$_POST['simili']; 

$simili=numero_scena($simili);

//if($sentimento="") { $sentimento=rand(195, 217); }

/*

if(isset($_POST['personale_sentimento'])) {
		
		$sentimento=$_POST['personale_sentimento']; 

	}  */
	
	
	


/*
if(!isset($i)) { $i= rand(1, 5000); } else { $i=$_POST['i']; }     
if(!isset($im)) { $im= rand(1, 5000); } else { $im=$_POST['im']; }                     //$im=$_POST['im'];
if(!isset($f)) { $f= rand(1, 5000); } else { $f=$_POST['f']; }                         //$f=$_POST['f'];
if(!isset($cm)) {  $cm=  rand(1, 5000); } else { $cm=$_POST['cm']; }                       //$cm=$_POST['cm'];
if(!isset($c)) { $c=  rand(1, 5000); } else { $c=$_POST['c']; }  						//$cm=$_POST['c'];
if(!isset($fattore_L)) { $fattore_L=  rand(1, 5000); } else { $i=$_POST['$fattore_L']; }  
*/





 


$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');

if (mysqli_connect_errno()) {
	echo 'Errore durante la connessione al server MySQL' ;
	exit();
}

$query= "INSERT INTO citazioni (autore, citazione, sentimento, fattore_L, simili ) 
VALUES ('{$autore}','{$citazione}', '{$sentimento}', '{$fattore_L}', '{$simili}' )";
					
$risultato= mysqli_query($conn, $query);

if(!$risultato) {
	die("il database ha qualche problema... " .mysqli_error($conn));
}


  


}



?> 

<html>

<head>
	
	
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/rangeslider.css">
	
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

.container li { list-style-type:none; }

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

<meta name="viewport" content="width=device-width, initial-scale=1.0" >
</head>


 <body>

 
<div class="row col-lg-12 container">
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" >


 

<label>Autore*</label><input type="text" name="autore" placeholder="inserisci il nome dell'autore"  /><br/>
<label>Citazione*</label><input type="text" name="citazione" placeholder="inserisci la citazione"  /><br/>
<label>Sentimento*</label>
<select name="sentimento">
    <option value="riflessione">riflessione</option>
    <option value="felicit&agrave;">felicit&agrave;</option>
    <option value="malinconia" >malinconia</option>
    <option value="rabbia" >rabbia</option>
    <option value="tristezza" >tristezza</option>
    <option value="riscatto">riscatto</option>
    <option value="amore" >amore</option>
    <option value="curiosit&agrave;">curiosit&agrave;</option>
    <option value="confusione">confusione</option>
    <option value="speranza">speranza</option>
</select>


<br/>

<label>Inserisci il fattore L</label><!-- <input type="text" name="fattore" placeholder="inserisci il tuo fattore" /> -->
<div id="js-example-change-value">
       
        <input type="range" name="fattore_L" min="1" max="5000" data-rangeslider>
        <output></output>
     <!--   <input type="number"  placeholder="inserisci il tuo fattore"> -->
    </div>



<br/>


<label>Dove collocheresti questa citazione?</label>
<select name="simili" size='5' >
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
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
 <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js" ></script>
    <script src="../js/rangeslider.min.js"></script>
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
<a href="../principale.php"><input type="submit" style="text-decoration:none !important;" value="Torna indietro" /></a>
</div>

    
    
</body>


</html>

