

<?php



function prendiID($nome) {

$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');

if (mysqli_connect_errno()) {
    echo 'Errore durante la connessione al server MySQL';
    exit();
} 

$id= mysqli_query($conn, "SELECT idUtente FROM utente WHERE Nome='$nome' " );

$row= mysqli_fetch_assoc($id);

$idUtente=$row['idUtente'];

return $idUtente;




}

function videoAssegnati($nome) {

    $idUtente=prendiID($nome);



    $conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');

if (mysqli_connect_errno()) {
    echo 'Errore durante la connessione al server MySQL';
    exit();
} 




$richiesta= "SELECT  utente.*, iframe.canzone, iframe.collegamento ";
$richiesta .= "FROM assegnamenti, iframe, utente ";
$richiesta .= " WHERE iframe.idiFrame=assegnamenti.idCanzone AND assegnamenti.idRicevente=$idUtente";
$richiesta .= " AND assegnamenti.idRicevente= utente.idUtente";



//$utenteEsterno= "SELECT utente.* from utente, assegnamenti WHERE assegnamenti.idRicevente='$id' AND assegnamenti.idEmittente=''"

$id= mysqli_query($conn, $richiesta);

$richiesta2= "SELECT utente.Nome";

$richiesta2.=" FROM assegnamenti, utente";
$richiesta2.=" WHERE assegnamenti.idRicevente =$idUtente";
$richiesta2.=" AND utente.altriUtenti = assegnamenti.idEmittente";
//$richiesta2.=" AND assegnamenti.idRicevente=$id";
//$richiesta2.=" LIMIT 1";

$utenteEsterno= mysqli_query($conn, $richiesta2);
$utenteEsterno= mysqli_fetch_assoc($utenteEsterno);


  echo "ecco gli ultimi video assegnati casualmente da " .$utenteEsterno['Nome'] ."<br/>";


while($row=mysqli_fetch_assoc($id)) {

  

    echo $row['nome']."<br/>"; 
    echo $row['canzone']."<br/>";
    
  echo  "<iframe width='420' height='315' src='//www.youtube.com/embed/".$row['collegamento']."'  frameborder='0' allowfullscreen></iframe><br/>";



}





}

function ultimiVideo() {



$nome=$_SESSION['nome'];



$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');

if (mysqli_connect_errno()) {
    echo 'Errore durante la connessione al server MySQL';
    exit();
} 

$id= mysqli_query($conn, "SELECT ultimi_id FROM utente WHERE Nome='$nome' " );
$citazione= mysqli_query($conn, "SELECT ultime_cit FROM utente WHERE Nome='$nome' " );

$row= mysqli_fetch_assoc($id);
$row2= mysqli_fetch_assoc($citazione);

$valore_id= $row['ultimi_id'];
$valore_cit= $row2['ultime_cit'];





$richiesta=mysqli_query($conn, "SELECT iframe.canzone, iframe.collegamento FROM iframe, utente WHERE utente.ultimi_id='{$valore_id}' AND utente.ultime_cit='{$valore_cit}' AND iframe.idiFrame='{$valore_id}' ");

while($row=mysqli_fetch_assoc($richiesta)) {

    $collegamento=$row['collegamento'];

    echo $row['canzone'] ."<br/>";
    echo  "<iframe width='420' height='315' src='//www.youtube.com/embed/$collegamento'  frameborder='0' allowfullscreen></iframe><br/>";



}

}



session_start();





if(!isset($_SESSION['login'])) {
	header("Location:index.php");
	
}


$_SESSION['idUtente']= prendiID($nome);



$id=$_SESSION['idUtente'];

//var_dump($id);

?>
<!DOCTYPE html>

<html>

<head>

<title>Profilo La(b)Storia principale</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" >



<script type="text/javascript" src="js/jquery.js" /></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/introjs.css" />
<link rel="stylesheet" href="css/rangeslider.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/demo.css" />
</head>

<body>
<script type='text/javascript'>
$(document).ready(function() {
    $('#selecctall').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
    
});
</script>
<div class="container">
<div class="row col-lg-12 form_wrapper">
 <a  style="border:2px solid black; float:right; clear:both;" class="btn" href="javascript:void(0);" onclick="startIntro();">Spiegazioni</a>
<label style="text-align:center; font-size:50px;">Ciao  <?php echo $_SESSION['nome'];  ?></label>



<form  enctype="multipart/form-data" action="processing.php" method="post">

<div id="step1">
<label>Inserisci il tuo umore</label>
<!-- <input type="text"  style="color:black !important; " name="umore" placeholder="inserisci il tuo umore" /><br/> 
<label>o scegli dal men&ugrave;</label> -->
<select name="umore">
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
</div>
<label style="margin-right:10px;">Mi sento fortunato<input type="checkbox" name="fortunato" ></label>
<br/><br/><br/>
<div id="step2">
<label>Scelte musicali (solo una)</label><br/>

<ul style=" color:black; margin-right:20px; font-size:30px; list-style-type:none;" >


<li><input type="radio" name="scelte[]" value="elettronica" />dance/elettronica</li>
<li><input type="radio" name="scelte[]" value="melody" />melody</li>
<li><input type="radio" name="scelte[]" value="rock" />rock</li>
<li><input type="radio" name="scelte[]" value="pop" />pop</li>
<li><input type="radio" name="scelte[]" value="classica" />classica</li>
<li><input type="radio" name="scelte[]" value="autore" />musica d'autore</li>

<ul>
</div>
<br/>
<br/>
<br/>
<a href="insert_if/index.php" target="_blank">Inserisci un nuovo video e assegna i valori specifici</a><br/><br/>
<a href="insert_if/inser_cit.php" target="_blank" ><span style="text-align:right !important;">Inserisci una nuova citazione</span></a>
</div>

<div class="row col-lg-12">
<br/><br/><br/><br/><br/><br/>
<br/>

<div id="step3">
   <div id="js-example-change-value">
       
        <input type="range" name="fattore" min="1" max="5000" data-rangeslider>
        <output></output>
     <!--   <input type="number"  placeholder="inserisci il tuo fattore"> -->
    </div>


<input type="checkbox" class="checkbox1" name="check[]" value="fattore_random" />valore casuale</li>
</div>

<br/><br/><br/><br/><br/><br/>


<ul class="chk-container">

<div id="step4">
<li><label>interesse dimostrato per il video?</label>
<input type="checkbox" class="checkbox1" name="valori[]" value="valore_i_random" />valore casuale

        <div id="js-example-change-value">
       
        <input type="range" name="i" min="1" max="5000" data-rangeslider>
        <output></output>
     <!--   <input type="number"  placeholder="inserisci il tuo fattore"> -->
    </div>

</li>

</div>


<div id="step5">
    <li><label>Che impatto avr&agrave; nella tua vita?</label>
    <input type="checkbox" class="checkbox1"  name="valori[]" value="valore_im_random" />valore casuale
     <div id="js-example-change-value">
           
            <input type="range"  name="im" min="1" max="5000" data-rangeslider>
            <output></output>
            
        </div>

    </li>



    <li><label>Quanto stai lavorando di fantasia adesso?</label>

    <input type="checkbox"  class="checkbox1" name="valori[]" value="valore_f_random" />valore casuale
               <div id="js-example-change-value">
            
            <input type="range"  name="f"  min="1" max="5000" data-rangeslider>
            <output></output>
          <!--  <input type="number"   placeholder="inserisci il tuo fattore" > -->
        </div>

    </li>
</div>

<div id="step6">
    <li><label>Quanto ti stai lasciando influenzare dagli altri?</label>
    <input type="checkbox" class="checkbox1" name="valori[]" value="valore_c_random"  />valore casuale
            <div id="js-example-change-value">
           
            <input type="range" name="c"  min="1" max="5000" data-rangeslider>
            <output></output>
            
        </div>

    </li>
    <li><label>Quanto ti stanno sul cazzo gli altri?</label>
    <input type="checkbox" class="checkbox1" name="valori[]" value="valore_cm_random" />valore casuale
      
              <div id="js-example-change-value">
           
            <input type="range" name="cm"  min="1" max="5000" data-rangeslider>
            <output></output>
         <!--   <input type="number"  placeholder="inserisci il tuo fattore"></input> -->
        </div>

    </li>
</div>
<input type="checkbox" id="selecctall" />seleziona tutti<br/>
</ul>

<input type="submit" class="btn btn-4 btn-4b icon-arrow-left" name="submit" value="invia" />
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
<?php 

echo "<div class='row col-lg-5'>";
videoAssegnati($nome);
echo "</div>";




?>



<?php 
echo "<div class='row col-lg-4 col-xs-offset-1'>";
echo "Ecco gli ultimi video che hai visualizzato:<br/><br/>";

ultimiVideo(); 



 echo "</div>"; 




?>
<br/>
<br/>
<br/>

 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
 <script type="text/javascript" src="bootstrap/js/bootstrap.min.js" ></script>
    <script src="js/rangeslider.min.js"></script>
    <script type="text/javascript" src="js/intro.js" /></script>
    <script type="text/javascript">
      function startIntro(){
        var intro = introJs();
          intro.setOptions({
            steps: [
              {
                element: '#step1',
                intro: "<p style='color:black;'> Inserisci il tuo umore, il sentimento che stai provando in questo momento.</p>"

              },
              {
                element: '#step2',
                intro: "<p style='color:black;'>La scelta musicale &egrave; importante per selezionare il video che evidenzier&agrave; il tuo stato d'animo.</p>",
                
              },
              {
                element: '#step3',
                intro: "<p style='color:black;'>scegli il tuo fattoreL senza pensarci: lascia agire il subconscio.</p>",
                
              },
              {
                element: '#step4',
                intro: "<p style='color:black;'>Sei davvero interessato al video che uscir&agrave;?</p>",
                
              },
              {
                element: '#step5',
                intro: '<p style="color:black;"">Quanto valore potr&agrave; avere il video che uscir&agrave;, secondo te? Sar&agrave; una canzone che smuover&agrave; davvero il tuo animo?</p>'
              },
              {
                element: '#step6',
                intro: '<p style="color:black;"">In questo momento, quanto sono importanti le persone che ti circondando?</p> '
              }
            ]
          });

          intro.start();
      }
    </script>
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
<div class='row col-lg-5'>
<form name="logout" action="http://www.labnova.it/progetto_colonna/index.php" method="post"> 
			<input type="hidden" name="logout" value="esci"/>
            <input  class="btn btn-4 btn-4b icon-arrow-left" type="submit" value="ESCI" /> 

</form>
</div>
<!--
<label>Inserisci il tuo nome</label><input type="text" name="nome" placeholder="inserisci il tuo nome" /><br/>
<label>Inserisci il tuo cognome</label><input type="text" name="cognome" placeholder="inserisci il tuo cognome" /><br/>
<label>Inserisci la tua mail</label><input type="text" name="mail" placeholder="inserisci la tua mail" /><br/>
<input type="submit" name="submit" value="invia" />
-->

</div>
</div> <!--container -->
</body>



</html>