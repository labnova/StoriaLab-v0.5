<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css.map">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/demo.css" />
<script type="text/javascript" src="js/jquery.js" /></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link rel="stylesheet" href="css/rangeslider.css">






<?php

session_start();

if(!isset($_SESSION['login'])) {
	header("Location:index.php");
	
}


error_reporting(E_ALL^ E_WARNING); 
error_reporting(E_ALL^ E_NOTICE); 

require_once('function.php');

$i=$_POST['i']; //interesse per il video

$im=$_POST['im']; //impatto nella sua vita

$f=$_POST['f']; //fantasia stuzzicata
$c=$_POST['c']; //consiglio degli altri
$s= $_POST['fattore']; //fantasia generale

$cm=$_POST['cm']; //consiglio dei più antipatici

$fattoreU=0; //FATTORE U


    
    

    
    

if(IsChecked('check','fattore_random')) {  $s= rand(1, 3000); } 

if(IsChecked('valori','valore_i_random')) {  $i= rand(1, 3000); }
if(IsChecked('valori','valore_im_random')) {  $im= rand(1, 3000); }
if(IsChecked('valori','valore_f_random')) {  $f= rand(1, 3000); }
if(IsChecked('valori','valore_c_random')) {  $c= rand(1, 3000); }
if(IsChecked('valori','valore_cm_random')) {  $cm= rand(1, 3000); }




if ($s==0) {
	$s=10;
	}


//$fattoreU= round((100*($i+$f) / $s+$c) + (($im+ $c) / $cm));

$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');

if (mysqli_connect_errno()) {
	echo 'Errore durante la connessione al server MySQL';
	exit();
}

$umore= $_POST['umore'];


// if(!controllo($umore)) { echo "non rompere il cazzo!"; }


 

if(isset($_POST['scelte'])) {
        $musica = implode($_POST['scelte'],', '); 
 }   else {
        $musica = 'Nessun valore selezionato'; } 
        





		

		

 
        
		$richiesta= " SELECT * ";
		$richiesta .= "FROM iframe JOIN citazioni ";
		
		$richiesta .= "WHERE iframe.sentimento= '$umore' "; 
		
		
		//$richiesta .= "AND ( fattore_L <= " .$fattoreU. " ) ";
		//$richiesta .= "AND genere= '$musica' ";
		//$richiesta .= "AND citazioni.sentimento =  '$umore' ";
		$richiesta .= "ORDER BY RAND()";
		$richiesta .= "LIMIT 1"; 
		





//$richiesta .= "AND ( fattore_L <= " .$fattoreU. " ) ";

	
	$risultato= mysqli_query($conn, $richiesta);
	
	if(!$risultato) {
 		die("la richiesta non &egrave; avvenuta..." .mysqli_error($conn));
	}





	
	if($fattoreU <= rand(1, 10000)) {
	

	
	
		while ($row= mysqli_fetch_assoc($risultato)) {
		

		
		//if (!cont_iframe(row['idiFrame']) {
		
			if ($row['fattore_L']<= rand(1, 10000)) {
			
				
		
		
				echo  $row['canzone'] ."<br/>";
								echo  "<iframe width='420' height='315' src='//www.youtube.com/embed/".$row['collegamento']." '  frameborder='0' allowfullscreen></iframe> .'<br/>";

				echo $fattoreU;
				echo "<p style='font-size:30px;'>" . $row['fattore_L'] ."</p><br/>";
				echo  $row['citazione'] ."<br/>";
				echo  $row['autore'] ."<br/><br/><br/>";
				echo "<form action='$_SERVER[PHP_SELF]' method='post'>";

				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_i']." min='1' max='5000' name='valore_i' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_im']." min='1' max='5000' name='valore_im' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_c']." min='1' max='5000' name='valore_c' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_cm']." min='1' max='5000' name='valore_cm' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_f']." min='1' max='5000' name='valore_f' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<input type='hidden' name='id' value='$id'>";

				echo "<input type='submit' value='cambia' name='cambia'>cambia il valore</p>";
				echo "</form>";
				
				
		?>
		
		
				<form action="principale.php" method="post" >
			<label>Inserisci un contesto in cui ti stai ritrovando...</label>
			<input type="text" name="umore" placeholder="inserisci la situazione" />
			<input type="submit" name="submit" value="inventa un'altra storia" />
			</form>
			
			<?php
			
			/* echo "<p>Come sarebbe stato scialbo essere felici! (Marguerite Yourcenar)</p>"; */
		
			} else {
		
	
				echo  $row['canzone'] ."<br/>";
								echo  "<iframe width='420' height='315' src='//www.youtube.com/embed/".$row['collegamento']." '  frameborder='0' allowfullscreen></iframe> .'<br/>";

				echo $fattoreU;
				echo "<p style='font-size:30px;'>" . $row['fattore_L'] ."</p><br/>";
				echo  $row['citazione'] ."<br/>";
				echo  $row['autore'] ."<br/><br/><br/>";
				echo "<form action='$_SERVER[PHP_SELF]' method='post'>";

				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_i']." min='1' max='5000' name='valore_i' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_im']." min='1' max='5000' name='valore_im' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_c']." min='1' max='5000' name='valore_c' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_cm']." min='1' max='5000' name='valore_cm' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_f']." min='1' max='5000' name='valore_f' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<input type='hidden' name='id' value='$id'>";

				echo "<input type='submit' value='cambia' name='cambia'>cambia il valore</p>";
				echo "</form>";
				
						
		?>
		
		
				<form action="principale.php" method="post" >
			<label>Inserisci un contesto in cui ti stai ritrovando...</label>
			<input type="text" name="umore" placeholder="inserisci la situazione" />
			<input type="submit" name="submit" value="inventa un'altra storia" />
			</form>
			
			<?php
			
			
			/*echo "<p>È certamente vero che noi dobbiamo pensare alla felicità degli altri; 
			ma non si dice mai abbastanza che il meglio 
			che possiamo fare per quelli che amiamo è ancora l'essere felici. (Émile-Auguste Chartier)</p>"; */
			
		
		}
		
	//}
		
	}
	
	} //-> fine $fattoreU
	
	else {
	
	echo "<p> Primo Colpo di Scena, la tua storia non &egrave; partita.<br/>
	Il destino ti propone questo video: <br/> ";
	
		$richiesta = "SELECT * ";
		$richiesta .= "FROM iframe, citazioni ";
		$richiesta .= "WHERE RAND() ";
		//$richiesta .= "WHERE RAND(iframe.scena)";
		$richiesta .= " LIMIT 1";
	
		$risultato= mysqli_query($conn, $richiesta);
	
		if(!$risultato) {
 		die("la richiesta non &egrave; avvenuta..." .mysqli_error($conn));
	}
	
	
	while ($row= mysqli_fetch_assoc($risultato)) {
		
		
		
		
			
		
		
				echo  $row['canzone'] ."<br/>";
								echo  "<iframe width='420' height='315' src='//www.youtube.com/embed/".$row['collegamento']." '  frameborder='0' allowfullscreen></iframe> .'<br/>";

				echo $fattoreU;
				echo "<p style='font-size:30px;'>" . $row['fattore_L'] ."</p><br/>";
				echo  $row['citazione'] ."<br/>";
				echo  $row['autore'] ."<br/>";
				echo "<form action='$_SERVER[PHP_SELF]' method='post'>";

				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_i']." min='1' max='5000' name='valore_i' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_im']." min='1' max='5000' name='valore_im' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_c']." min='1' max='5000' name='valore_c' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_cm']." min='1' max='5000' name='valore_cm' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_f']." min='1' max='5000' name='valore_f' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<input type='hidden' name='id' value='$id'>";

				echo "<input type='submit' value='cambia' name='cambia'>cambia il valore</p>";
				echo "</form>";
			
	
	
				
	
		}
	
	}
	
	






//pulsante "mi sento fortunato

if(isset($_POST['fortunato'])) {

$genere="";
$musica="";
$fattoreL= 1;

$richiesta="SELECT * FROM iframe ORDER BY RAND() LIMIT 1 ";
$risultato= mysqli_query($conn, $richiesta);

if(!$risultato) {
 die("la richiesta non &egrave; avvenuta...");
}

	while ($row= mysqli_fetch_assoc($risultato)) {
		

		
		echo  $row['canzone'] ."<br/>";
		echo  "<iframe width='420' height='315' src='//www.youtube.com/embed/".$row['collegamento']." '  frameborder='0' allowfullscreen></iframe><br/>";

		echo $fattoreU;
		echo "<p style='font-size:30px;'>" . $row['fattore_L'] ."</p><br/>";
		echo "<form action='$_SERVER[PHP_SELF]' method='post'>";

				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_i']." min='1' max='5000' name='valore_i' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_im']." min='1' max='5000' name='valore_im' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_c']." min='1' max='5000' name='valore_c' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_cm']." min='1' max='5000' name='valore_cm' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' value=".$row['valore_f']." min='1' max='5000' name='valore_f' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<input type='hidden' name='id' value='$id'>";

				echo "<input type='submit' value='cambia' name='cambia'>cambia il valore</p>";
				echo "</form>";
	
		} 
		
		
	
	
   
  
}

/*
if($umore=" ") {
 echo '<iframe width="420" height="315" src="//www.youtube.com/embed/SdhAfMor9BM" frameborder="0" allowfullscreen></iframe>';

} */


//$richiesta="SELECT * FROM iframe WHERE sentimento='felice' AND ( fattore_L <= " .$fattoreU. ") LIMIT 1 "; //WHERE sentimento='felice'




//switch ($musica) 

?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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

    </body>

    
    </html>

