<?php 
// We check in which language we will work
if (isset($_SESSION["DATAGLOBAL"][0]) && !empty($_SESSION["DATAGLOBAL"][0])) $C->LANGUAGE = $_SESSION["DATAGLOBAL"][0];
$this->load_langfile('outside/home.php');

$errored = 0;
$txterror = '';

$em = '';

if (isset($_POST["em"]) && $_POST["em"] != '') $em = $this->db1->e($_POST["em"]);

if (empty($em)) { $errored = 1; $txterror .= 'Error... '; }

if ($errored == 1) {
	echo("0: ".$txterror);
} else {
	$codeuser = $this->db2->fetch_field("SELECT code FROM users WHERE email='".$em."' LIMIT 1");
	if (!$codeuser) echo('0: '.$this->lang('home_f_recovery_error2'));
	else {
		$coderecovery = getCode(20, 0);
		
		$this->db2->query("UPDATE users SET coderecovery='".$coderecovery."' WHERE code='".$codeuser."' LIMIT 1");
		
		$D->linkresetpass = $C->SITE_URL.'login/resetpass/c:'.$coderecovery.'/cu:'.$codeuser;
		
		$message = $this->load_template('__mail_resetpass.php', FALSE);

		$subject = $this->lang('home_f_recovery_em_subject', array('#SITE_TITLE#'=>$C->SITE_TITLE));
		
		send_mail_phpmailer($em, $subject, $message);
		
		echo('1: '.$this->lang('home_f_recovery_ok'));
		
	}

}
?>