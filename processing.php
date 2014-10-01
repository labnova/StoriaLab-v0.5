
<?php



session_start();

if(!isset($_SESSION['login'])) {
	header("Location:index.php");
	
}


function cambiaValore_i($val, $id) {

	$valorei=$val;
$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');

if (mysqli_connect_errno()) {
	echo 'Errore durante la connessione al server MySQL';
	exit();
}

$sql= mysqli_query($conn, "UPDATE iframe SET valore_i='$valorei' WHERE idiFrame='$id'");

if($sql) {echo "operazione completata"; }
	else { die('problemi...' .mysqli_error($conn));}


}




function inserisciUltime($id, $cit) {

	$nome=$_SESSION['nome'];

			$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');

			if (mysqli_connect_errno()) {
				echo 'Errore durante la connessione al server MySQL';
			exit();
		}

			$sql= mysqli_query($conn, "UPDATE utente SET ultimi_id='{$id}',ultime_cit='{$cit}' WHERE Nome='$nome'" );

			if(!$sql) {
 				die("la richiesta non &egrave; avvenuta..." .mysqli_error($conn));
		}





		} 



error_reporting(E_ALL^ E_WARNING); 
error_reporting(E_ALL^ E_NOTICE); 


require_once('function.php');
//require_once('database.php');





?>

<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/demo.css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" >
<script type="text/javascript" src="js/jquery.js" /></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link rel="stylesheet" href="css/rangeslider.css">
 


	<title></title>
</head>
<body>

<!--<div class="svg-wrap">
			<svg width="64" height="64" viewBox="0 0 64 64">
				<path id="arrow-left-1" d="M46.077 55.738c0.858 0.867 0.858 2.266 0 3.133s-2.243 0.867-3.101 0l-25.056-25.302c-0.858-0.867-0.858-2.269 0-3.133l25.056-25.306c0.858-0.867 2.243-0.867 3.101 0s0.858 2.266 0 3.133l-22.848 23.738 22.848 23.738z" />
			</svg>
			<svg width="64" height="64" viewBox="0 0 64 64">
				<path id="arrow-right-1" d="M17.919 55.738c-0.858 0.867-0.858 2.266 0 3.133s2.243 0.867 3.101 0l25.056-25.302c0.858-0.867 0.858-2.269 0-3.133l-25.056-25.306c-0.858-0.867-2.243-0.867-3.101 0s-0.858 2.266 0 3.133l22.848 23.738-22.848 23.738z" />
			</svg>
			
		</div> -->
<div class="row col-lg-12 ">


<?php


    
    
/* function controllo($um) {

	$umore=$um;
	
	$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');
	$query="SELECT sentimento FROM iframe";
	$controllo= mysqli_query($conn, $query);

	while($row= mysqli_fetch_assoc($controllo)) {
		
			if ($umore != $row['sentimento']) {
		
				echo "non è stata ritrovata nessuna corrispondenza";
		
		}
		
	
		
		}
		
		
	
		
		

} */
    
$i=$_POST['i']; //interesse per il video

$im=$_POST['im']; //impatto nella sua vita

$f=$_POST['f']; //fantasia stuzzicata
$c=$_POST['c']; //consiglio degli altri
$s= $_POST['fattore']; //fantasia generale

$cm=$_POST['cm']; //consiglio dei più antipatici

//var_dump($i);
//var_dump($im);
//var_dump($f);
//var_dump($c);
//var_dump($cm);

$fattoreU=0; //FATTORE U 

if(IsChecked('check','fattore_random')) {  $s= rand(1, 5000); } 

if(IsChecked('valori','valore_i_random')) {  $i= rand(1, 5000); }
if(IsChecked('valori','valore_im_random')) {  $im= rand(1, 5000); }
if(IsChecked('valori','valore_f_random')) {  $f= rand(1, 5000); }
if(IsChecked('valori','valore_c_random')) {  $c= rand(1, 5000); }
if(IsChecked('valori','valore_cm_random')) {  $cm= rand(1, 5000); }




if ($s==0) {
	$s=10;
	}

if ($cm==0) {
	$cm=20;
	}


$fattoreU= round((100*($i+$f) / $s+$c) + (($im+ $c) / $cm));

$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');

if (mysqli_connect_errno()) {
	echo 'Errore durante la connessione al server MySQL';
	exit();
}



// if(!controllo($umore)) { echo "non rompere il cazzo!"; }


 

if(isset($_POST['scelte'])) {
        $musica = implode($_POST['scelte'],', '); 
 }   else {
        $musica = 'Nessun valore selezionato'; } 
        

$umore= $_POST['umore'];
var_dump($musica);

$umore= numero_sentimento($umore);

$musica=numero_genere($musica);


		

		

 
        
		$richiesta= " SELECT * ";
		$richiesta .= "FROM iframe JOIN citazioni ";
		
		$richiesta .= "WHERE iframe.sentimento= '$umore' "; 
		
		
		//$richiesta .= "AND ( fattore_L <= " .$fattoreU. " ) ";
		$richiesta .= "AND genere= '$musica' ";
		//$richiesta .= "AND citazioni.sentimento =  '$umore' ";
		$richiesta .= "ORDER BY RAND()";
		$richiesta .= "LIMIT 1"; 
		





//$richiesta .= "AND ( fattore_L <= " .$fattoreU. " ) ";

	
	$risultato= mysqli_query($conn, $richiesta);
	
	if(!$risultato) {
 		die("la richiesta non &egrave; avvenuta..." .mysqli_error($conn));
	}





	
	if($fattoreU <= rand(1, 5000)) {

		

	
	
		while ($row= mysqli_fetch_assoc($risultato)) {
		
		
		
		//if (!cont_iframe(row['idiFrame']) {
		
			if ($row['fattore_L']<= rand(1, 5000)) {
				$id=$row['idiFrame'];
				$_SESSION['id']=$row['idiFrame'];
				$_SESSION['citazione']=$row['idCitazione'];
				
				var_dump($id);

			inserisciUltime($id, $cit);
				echo "<section>";
				echo "<div class='titolo' >". $row['canzone'] ."<br/></div>";
				echo  "<iframe width='420' height='315' src='//www.youtube.com/embed/".$row['collegamento']."?autoplay=1'  frameborder='0' allowfullscreen></iframe><br/>";
				
				echo "<label>FattoreL:</label><p style='font-size:30px;'>" . $row['fattore_L'] ."</p><br/>";
				echo  $row['citazione'] ."<br/>";
				echo  $row['autore'] ."<br/><br/><br/><br/>";
				echo "<form action='insert_if/insert.php' method='post'>";

				echo "<div id='js-example-change-value'>";
				echo"<label>interesse dimostrato per il video?</label>";
				echo "<input type='range' id='valore_i' value=".$row['valore_i']." min='1' max='5000' name='valore_i' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo"<label>Che impatto avr&agrave; nella tua vita?</label>";
				echo "<input type='range' id='valore_im' value=".$row['valore_im']." min='1' max='5000' name='valore_im' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo"<label>quanto ti lasci influenzare dagli altri</label>";
				echo "<input type='range' id='valore_c' value=".$row['valore_c']." min='1' max='5000' name='valore_c' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo"<label>quanto ti stanno sul cazzo gli altri?</label>";
				echo "<input type='range' id='valore_cm' value=".$row['valore_cm']." min='1' max='5000' name='valore_cm' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo"<label>quanto lavori di fantasia</label>";
				echo "<input type='range' id='valore_f' value=".$row['valore_f']." min='1' max='5000' name='valore_f' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<input type='hidden' name='id' value='$id'>";

				echo "<input type='submit' id='cambia' value='cambia' name='cambia'>";
				echo "<div id='valori_cambiati'></div>";	
				echo "</form>";
				echo "</section>";
				//if(isset($_POST['cambia'])) {$id=$_POST['id']; $valorei=$_POST['valore_i']; cambiaValore_i($valorei, $id); }
				
				?>
               
                
                 <br/><br/><br/><br/><br/><br/>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- primo_ad -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-7543123859390493"
     data-ad-slot="6155357669"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<br/><br/><br/>
<?php
				echo"<button class='btn btn-4 btn-4b icon-arrow-left'><a href='principale.php'>vai indietro</a></button>";

			?>

			<!--<section class="color-4">
			<form action="prima_scena.php" method="post" >
			<label>Inserisci un contesto in cui ti stai ritrovando...</label>
			<input type="text" name="umore" placeholder="inserisci la situazione" />
			<input type="submit" class="btn btn-4 btn-4a icon-arrow-right"  name="submit" value="vai alla prima scena" />
			</form>
			<br/>
			<form action="altra_combo.php" method="post" >
			<label>completa questa scena</label>
			<input type="text" name="umore" placeholder="inserisci la situazione" />
			<input type="submit" name="submit" value="completa attuale scena" />
			</form>
			<br/>
			<form action="random.php" method="post" >
			<label>vai nella storia di un altro utente</label>
			<input type="text" name="umore" placeholder="inserisci la situazione" />
			<input type="submit" name="submit" value="colpo di scena" />
			</form>
			<a href="principale.php">vai indietro</a>
			</section> -->
				
			
			
			
			
			<?php
			
			/* echo "<p>Come sarebbe stato scialbo essere felici! (Marguerite Yourcenar)</p>"; */
		
	} 	else {	
				echo "<section>";
				
				$id=$row['idiFrame'];
				
				var_dump($id);

				$_SESSION['id']=$row['idiFrame'];
				echo "<div class='titolo' >". $row['canzone'] ."<br/></div>";
				echo  "<iframe width='420' height='315' src='//www.youtube.com/embed/".$row['collegamento']."?autoplay=1'  frameborder='0' allowfullscreen></iframe><br/>";
				echo $fattoreU;
				echo "<label>FattoreL:</label><p style='font-size:30px;'>" . $row['fattore_L'] ."</p><br/>";
				echo  $row['citazione'] ."<br/>";
				echo  $row['autore'] ."<br/>";
				echo "</div>";
				echo "<form action='insert_if/insert.php' method='post'>";

				echo "<div id='js-example-change-value'>";
				echo"<label>interesse dimostrato per il video?</label>";
				echo "<input type='range' id='valore_i' value=".$row['valore_i']." min='1' max='5000' name='valore_i' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo"<label>Che impatto avr&agrave; nella tua vita?</label>";
				echo "<input type='range' id='valore_im' value=".$row['valore_im']." min='1' max='5000' name='valore_im' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo"<label>quanto ti lasci influenzare dagli altri</label>";
				echo "<input type='range' id='valore_c' value=".$row['valore_c']." min='1' max='5000' name='valore_c' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo"<label>quanto ti stanno sul cazzo gli altri?</label>";
				echo "<input type='range' id='valore_cm' value=".$row['valore_cm']." min='1' max='5000' name='valore_cm' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo"<label>Quanto stai lavorando di fantasia?</label>";
				echo "<input type='range' id='valore_f' value=".$row['valore_f']." min='1' max='5000' name='valore_f' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<input type='hidden' name='id' value='$id'>";

				echo "<input type='submit'  id='cambia' value='cambia'  name='cambia'>";
				echo "<div id='valori_cambiati'></div>";
				echo "</form>";
				echo "</section>"; 

				?>
                <br/><br/><br/><br/><br/><br/>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- primo_ad -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-7543123859390493"
     data-ad-slot="6155357669"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<br/><br/><br/>
			<button class="btn btn-4 btn-4b icon-arrow-left"><a href="principale.php">vai indietro</a></button>
		
			
			
			
			<?php
		
		
		
			
			/*echo "<p>È certamente vero che noi dobbiamo pensare alla felicità degli altri; 
			ma non si dice mai abbastanza che il meglio 
			che possiamo fare per quelli che amiamo è ancora l'essere felici. (Émile-Auguste Chartier)</p>"; */
			
		
		}
		
		//altroUtente();
		
	//}
		
	}
	
	} //-> fine $fattoreU
	
	else {
	
	echo "<div class='row col-lg-12 principale'>";
	echo"<p style='font-size:40px; text-align:center; margin-bottom:20px;'> Purtroppo il database non pu&ograve; soddisfare la tua storia.
	Puoi inserire direttamente tu il tuo video preferito, con il relativo sentimento che vuoi assegnare,
	 <a href='insert_if/index.php' target='_blank'>cliccando qui</a></p><br/> ";

	echo "ecco un video a caso presente nel database, che gli altri utenti hanno inserito:";
	
		$richiesta = "SELECT * ";
		$richiesta .= "FROM iframe, citazioni ";
		$richiesta .= "ORDER BY RAND() ";
		$richiesta .= " LIMIT 1";
	
		$risultato= mysqli_query($conn, $richiesta);
	
		if(!$risultato) {
 		die("la richiesta non &egrave; avvenuta..." .mysqli_error($conn));
	}
	
	
	while ($row= mysqli_fetch_assoc($risultato)) {
		
		
				$id=$row['idiFrame'];
				$_SESSION['id']=$row['idiFrame'];
		
			
		
				echo "<div style='display:block; width:600px; margin-left:auto; margin-right:auto; text-align:center;'>";
				echo "<div class='titolo' >". $row['canzone'] ."<br/></div>";
				echo  "<iframe width='420' height='315' src='//www.youtube.com/embed/".$row['collegamento']."?autoplay=1'  frameborder='0' allowfullscreen></iframe><br/>";
				
				echo "<p style='font-size:30px;'> FattoreL: " . $row['fattore_L'] ."</p><br/>";
				echo  $row['citazione'] ."<br/>";
				echo  $row['autore'] ."<br/><br/><br/><br/>";
				echo "<form action='insert_if/insert.php' method='post'>";
				echo"<label>Interesse dimostrato per il video?</label>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' id='valore_i' value=".$row['valore_i']." min='1' max='5000' name='valore_i' data-rangeslider /><output></output><br/>";
				
				echo "</div>";
				echo"<label>Che impatto avr&agrave; nella tua vita?</label>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' id='valore_im' value=".$row['valore_im']." min='1' max='5000' name='valore_im' data-rangeslider /><output></output><br/>";
				
				echo "</div>";
				echo"<label>Quanto ti lasci influenzare dagli altri</label>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' id='valore_c' value=".$row['valore_c']." min='1' max='5000' name='valore_c' data-rangeslider /><output></output><br/>";
				
				echo "</div>";
				echo"<label>Quanto ti stanno sul cazzo gli altri?</label>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' id='valore_cm' value=".$row['valore_cm']." min='1' max='5000' name='valore_cm' data-rangeslider /><output></output><br/>";
				
				echo "</div>";
				echo"<label>Quanto stai lavorando di fantasia?</label>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' id='valore_f' value=".$row['valore_f']." min='1' max='5000' name='valore_f' data-rangeslider /><output></output><br/>";
				
				echo "</div>";
				echo "<input type='hidden' name='id' value='$id'>";

				echo "<input type='submit'  id='cambia' value='cambia'  name='cambia'>";
				echo "<div id='valori_cambiati'></div>";
				echo "</form>";
				echo "</div>";

				?>
			<br/><br/><br/><br/><br/><br/>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- primo_ad -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-7543123859390493"
     data-ad-slot="6155357669"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<br/><br/><br/><br/><br/><br/>
				<button class="btn btn-4 btn-4b icon-arrow-left"><a href="principale.php">vai indietro</a></button>
	
				<?php
	
		}
		
		//altroUtente();
		
		
		
		
	
		
	
	} 
	
	?>

	<!--<section class="color-4" style="background-color:black;">
				<h2>Round Slide</h2>
				<nav class="nav-roundslide">
					<a class="prev" href="/item1">
						<span class="icon-wrap"><svg class="icon" width="32" height="32" viewBox="0 0 64 64"><use xlink:href="#arrow-left-4"></svg></span>
						<h3>Hannah Leigh</h3>
					</a>
					<a class="next" href="/item3">
						<span class="icon-wrap"><svg class="icon" width="32" height="32" viewBox="0 0 64 64"><use xlink:href="#arrow-right-4"></svg></span>
						<h3>Greg Kennedy</h3>
					</a>
				</nav>
			</section> -->

	<?php
	






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
		
				$id=$row['idiFrame'];
				$_SESSION['id']=$row['idiFrame'];
		
		echo  $row['canzone'] ."<br/>";
				echo  "<iframe width='420' height='315' src='//www.youtube.com/embed/".$row['collegamento']."?autoplay=1'  frameborder='0' allowfullscreen></iframe> .'<br/>";
		echo $fattoreU;
		echo "<p style='font-size:30px;'>" . $row['fattore_L'] ."</p><br/>";
		echo "<form action='insert_if/insert.php' method='post'>";

				echo "<div id='js-example-change-value'>";
				echo "<input type='range' id='valore_i' value=".$row['valore_i']." min='1' max='5000' name='valore_i' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range'  id='valore_im' value=".$row['valore_im']." min='1' max='5000' name='valore_im' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' id='valore_c' value=".$row['valore_c']." min='1' max='5000' name='valore_c' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' id='valore_cm' value=".$row['valore_cm']." min='1' max='5000' name='valore_cm' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo "<input type='range' id='valore_f' value=".$row['valore_f']." min='1' max='5000' name='valore_f' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<input type='hidden' name='id' value='$id'>";

				echo "<input type='submit' id='cambia' value='cambia'  name='cambia'>";
				echo "<div id='valori_cambiati'></div>";
				echo "</form>";
?>
			<br/><br/><br/><br/><br/><br/>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- primo_ad -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-7543123859390493"
     data-ad-slot="6155357669"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<br/><br/><br/>
				<button  class="btn btn-4 btn-4b icon-arrow-left"><a href="principale.php">vai indietro</a></button>
				</div>
	
				<?php
	
		} 
		
		
	
	
   
  
}

/*
if($umore=" ") {
 echo '<iframe width="420" height="315" src="//www.youtube.com/embed/SdhAfMor9BM" frameborder="0" allowfullscreen></iframe>';

} */


//$richiesta="SELECT * FROM iframe WHERE sentimento='felice' AND ( fattore_L <= " .$fattoreU. ") LIMIT 1 "; //WHERE sentimento='felice'




//switch ($musica) 

?>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js" ></script>
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

