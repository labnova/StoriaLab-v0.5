<?php


/**
 * http://webdeveloperswall.com/php/get-youtube-video-id-from-url
**/ 
function extractUTubeVidId($url){
	/*
	* type1: http://www.youtube.com/watch?v=9Jr6OtgiOIw
	* type2: http://www.youtube.com/watch?v=9Jr6OtgiOIw&feature=related
	* type3: http://youtu.be/9Jr6OtgiOIw
	*/
	$vid_id = "";
	$flag = false;
	if(isset($url) && !empty($url)){
		/*case1 and 2*/
		$parts = explode("?", $url);
		if(isset($parts) && !empty($parts) && is_array($parts) && count($parts)>1){
			$params = explode("&", $parts[1]);
			if(isset($params) && !empty($params) && is_array($params)){
				foreach($params as $param){
					$kv = explode("=", $param);
					if(isset($kv) && !empty($kv) && is_array($kv) && count($kv)>1){
						if($kv[0]=='v'){
							$vid_id = $kv[1];
							$flag = true;
							break;
						}
					}
				}
			}
		}
		
		/*case 3*/
		if(!$flag){
			$needle = "youtu.be/";
			$pos = null;
			$pos = strpos($url, $needle);
			if ($pos !== false) {
				$start = $pos + strlen($needle);
				$vid_id = substr($url, $start, 11);
				$flag = true;
			}
		}
	}
	return $vid_id;
}


function IsChecked($chkname,$value)
    {
        if(!empty($_POST[$chkname]))
        {
            foreach($_POST[$chkname] as $chkval)
            {
                if($chkval == $value)
                {
                    return true;
                }
            }
        }
        return false;
    }
    


function numero_genere($gen) {

$genere=0;

switch ($gen) {

case "pop": 
	$genere="1";
break;

case 'rock': 
	$genere='2';
break;

case 'dance': 
	$genere='4';
break;

case 'chill out': 
	$genere='5';
break;

case 'ska': 
	$genere='6';
break;

case 'punk': 
	$genere='7';
break;

case 'alternative rap': 
	$genere='8';
break;

case 'pop rock': 
	$genere='9';
break;

case 'rap': 
	$genere='10';
break;

case 'alternative rock': 
	$genere='11';
break;

case 'musica leggera': 
	$genere="12";
break;

case 'soundtrack movie': 
	$genere='13';
break;

case 'dance': 
	$genere='14';
break;

case 'cantilene': 
	$genere='15';
break;

case 'musical': 
	$genere='16';
break;

case 'autore': 
	$genere='17';
break;

case 'rap metal': 
	$genere='18';
break;

case 'nu metal': 
	$genere='19';
break;

case 'musica italiana': 
	$genere='20';
break;

case 'musica regionale': 
	$genere='21';
break;

case 'classica': 
	$genere='22';
break;

case 'grunge': 
	$genere='23';
break;

}

return $genere;


}

function numero_sentimento($sen) {

$sentimento=0;

switch ($sen) {

case 'armonia': 
	$sentimento='195';
break;

case 'riflessione': 
	$sentimento='196';
break;

case 'felicità': 
	$sentimento='197';
break;

case 'felice': 
	$sentimento='197';
break;

case "malinconia": 
	$sentimento="198";
break;

case 'abbandono': 
	$sentimento='200';
break;

case 'rabbia': 
	$sentimento='201';
break;

case 'tristezza': 
	$sentimento='202';
break;

case 'gioia': 
	$sentimento='203';
break;

case 'riscatto': 
	$sentimento='204';
break;

case 'sorpresa': 
	$sentimento='205';
break;

case 'angoscia': 
	$sentimento='206';
break;

case 'stupore': 
	$sentimento='207';
break;

case 'ribellione': 
	$sentimento='209';
break;

case 'amore': 
	$sentimento='210';
break;

case 'curiosità': 
	$sentimento='211';
break;

case 'speranza': 
	$sentimento='212';
break;

case 'paura': 
	$sentimento='213';
break;

case 'confusione': 
	$sentimento='214';
break;

case 'inquietitudine': 
	$sentimento='215';
break;

case 'divertimento': 
	$sentimento='216';
break;

case 'rassegnazione': 
	$sentimento='217';
break;


}

return $sentimento;

}


function numero_situazione($sit) {

$situazione="";
$caso=0;

$explode($situazione, $sit);

switch(is_array($sit)) {

case "lasciato": 
	$caso=1;
	
	}

return $caso;

}

function numero_scena($scen) {
$scena=0;

switch($scen) {

	case "inizio": 
		$scena=1;
	break;
	
	case "scena_1": 
		$scena=2;
	break;
	
	case "scena_2": 
		$scena=3;
	break;
	
	case "fine": 
		$scena=4;
	break;
	}

return $scena;

}


function altroUtente() {

$utente= array($nome, $cognome, $commento);

$conn= mysqli_connect('62.149.150.212', 'Sql749552', '88ik7syf56', 'Sql749552_2');

if (mysqli_connect_errno()) {
	echo 'Errore durante la connessione al server MySQL';
	exit();
}


$sql=mysqli_query($conn, 'SELECT * FROM utente WHERE idUtente=FLOOR(1+RAND()*7)  LIMIT 1');

if(!$sql) {
 		die("la richiesta non &egrave; avvenuta..." .mysqli_error($conn));
	}

echo "<p>un utente ha scritto questo...</p><br/>";

while($row=mysqli_fetch_assoc($sql)) {

echo  $row['Nome'] .'<br/>'; 
echo $row['Cognome'] .'<br/>'; 
echo $row['racconti'] .'<br/>'; 

}



/* 

$utente[$nome]= $row['nome']; 
$utente[$cognome]= $row['cognome']; 
$utente[$commento]= $row['commento']; 


*/
}


    
/* include_once 'securimage/securimage.php';
$securimage= new Securimage();

if($securimage->check($_POST['captcha_code'])==false) {

?>
<p>sbagliato il codice CAPTCHA. Ti preghiamo di riprovare nuovamente, grazie. :-)<br/>
<a href="http://www.area51editore.com/MeetingRoom/newsletter/index.php">TORNA ALLA NEWSLETTER</a></p>

<?
} else  {  */


?>