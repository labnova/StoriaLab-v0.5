<?php



if(isset($_POST['rivoluziona'])) {

	$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2'); 

	$id=$_POST['id'];
	$i=$_POST['valore_i'];
	$im=$_POST['valore_im'];
	$f=$_POST['valore_f'];
	$cm=$_POST['valore_cm'];
	$c=$_POST['valore_c'];

	

	if(isset($i)) {
	$query = "UPDATE iframe SET valore_i= {$i} where idiFrame='{$id}'";
	mysqli_query($conn, $query) or die("problemi durante la connessione" . mysqli_error($conn));
	if($query) { echo "valore_i cambiato!"; } else {echo "valore non cambiato"; }
	}

	if(isset($im)) {
	$query = "UPDATE iframe SET valore_im= {$im} where idiFrame='{$id}'";
	mysqli_query($conn,$query) or die("problemi durante la connessione" . mysqli_error($conn));
	
	}

	if(isset($c)) {
	$query = "UPDATE iframe SET valore_c= {$c} where idiFrame='{$id}'";
	mysqli_query($conn,$query)  or die("problemi durante la connessione" . mysqli_error($conn));
	
	}

	if(isset($cm)) {
	$query = "UPDATE iframe SET valore_cm= {$cm} where idiFrame='{$id}'";
	mysqli_query($conn,$query)  or die("problemi durante la connessione" . mysqli_error($conn));
	
	}

	if(isset($f)) {
	$query = "UPDATE iframe SET valore_f= {$f} where idiFrame='{$id}'";
	mysqli_query($conn,$query)  or die("problemi durante la connessione" . mysqli_error($conn));
	
	} 

}


?>


<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/demo.css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" >

 


	<title></title>
</head>
<body>

<?php

var_dump($i);


$id=$_POST['id'];
$i=$_POST['valore_i'];
$im=$_POST['valore_im'];
$f=$_POST['valore_f'];
$cm=$_POST['valore_cm'];
$c=$_POST['valore_c'];


echo "<div style='float:right; clear:both; border:2px solid black;'>";
echo "<h1>".randomValues(). "</h1>";
trovaVideo($i);
echo "</div>";


$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2'); 


$richiesta= " SELECT * ";
		$richiesta .= " FROM iframe ";
		$richiesta .= " WHERE idiFrame='$id' "; 
		
		

	
	$risultato= mysqli_query($conn, $richiesta);
	
	if(!$risultato) {
 		die("la richiesta non &egrave; avvenuta..." .mysqli_error($conn));
	}


	while ($row= mysqli_fetch_assoc($risultato)) {
		
		
		

		
	
				$id=$row['idiFrame'];
				//$_SESSION['id']=$row['idiFrame'];
				//$_SESSION['citazione']=$row['idCitazione'];
				
				//var_dump($id);

			
				echo "<section>";
				echo "<div class='titolo' >". $row['canzone'] ."<br/></div>";
				echo  "<iframe width='420' height='315' src='//www.youtube.com/embed/".$row['collegamento']."?autoplay=1'  frameborder='0' allowfullscreen></iframe><br/>";
				
				echo "<label>FattoreL:</label><p style='font-size:30px;'>" . $row['fattore_L'] ."</p><br/>";
				echo  $row['citazione'] ."<br/>";
				echo  $row['autore'] ."<br/><br/><br/><br/>"; ?>
				<form action='<? $_SERVER['PHP_SELF']; ?>'  method='post'>
				<?
				echo "<h1>Vecchi valori</h1>";
				echo "<div id='js-example-change-value'>";
				echo"<label>interesse dimostrato per il video?</label>";
				echo "<input type='range'  value=".$row['valore_i']." min='1' max='5000' name='valore_i' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo"<label>Che impatto avr&agrave; nella tua vita?</label>";
				echo "<input type='range'  value=".$row['valore_im']." min='1' max='5000' name='valore_im' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo"<label>quanto ti lasci influenzare dagli altri</label>";
				echo "<input type='range'  value=".$row['valore_c']." min='1' max='5000' name='valore_c' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo"<label>quanto ti stanno sul cazzo gli altri?</label>";
				echo "<input type='range' value=".$row['valore_cm']." min='1' max='5000' name='valore_cm' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo"<label>quanto lavori di fantasia</label>";
				echo "<input type='range'  value=".$row['valore_f']." min='1' max='5000' name='valore_f' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<input type='hidden' name='id' value='$id'>";
				
				echo "<button value='rivoluziona' name='rivoluziona'>Rivoluziona</button>";
				
				echo "</form>";
				echo "</section>";
				
				

}


function trovaVideo($i) {
	$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2'); 

	$query="SELECT * FROM `iframe` ";
	$query .=  "ORDER BY ABS( valore_i - $i) ";
	/*$query .= " AND ABS( valore_im - $im) ";
	$query .= " AND ABS( valore_c - $c) ";
	$query .= " AND ABS( valore_cm - $f) ";   */
	$query .= "  ASC LIMIT 4";  

$video= mysqli_query($conn, $query);
	
	if(!$video) {
 		die("la richiesta non &egrave; avvenuta..." .mysqli_error($conn));
	}


	while ($row= mysqli_fetch_assoc($video)) {

		echo "<section>";
				echo "<div class='titolo' >". $row['canzone'] ."<br/></div>";
				echo  "<iframe width='420' height='315' src='//www.youtube.com/embed/".$row['collegamento']."'  frameborder='0' allowfullscreen></iframe><br/>";
				
				echo "<label>FattoreL:</label><p style='font-size:30px;'>" . $row['fattore_L'] ."</p><br/>";
				
				echo"<form  method='post'>";
				
				echo "<h1>Vecchi valori</h1>";
				echo "<div id='js-example-change-value'>";
				echo"<label>interesse dimostrato per il video?</label>";
				echo "<input type='range'  value=".$row['valore_i']." min='1' max='5000' name='valore_i' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo"<label>Che impatto avr&agrave; nella tua vita?</label>";
				echo "<input type='range'  value=".$row['valore_im']." min='1' max='5000' name='valore_im' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo"<label>quanto ti lasci influenzare dagli altri</label>";
				echo "<input type='range'  value=".$row['valore_c']." min='1' max='5000' name='valore_c' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo"<label>quanto ti stanno sul cazzo gli altri?</label>";
				echo "<input type='range' value=".$row['valore_cm']." min='1' max='5000' name='valore_cm' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<div id='js-example-change-value'>";
				echo"<label>quanto lavori di fantasia</label>";
				echo "<input type='range'  value=".$row['valore_f']." min='1' max='5000' name='valore_f' data-rangeslider /><br/>";
				echo"<output></output>";
				echo "</div>";
				echo "<input type='hidden' name='id' value='$id'>";
				
				echo "<button value='rivoluziona' name='rivoluziona'>Vai</button>";
				
				echo "</form>";
				echo "</section>";




	}



}

?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link rel="stylesheet" href="css/rangeslider.css">
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


