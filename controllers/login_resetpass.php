<?php

	/*************************************************************************/
	// needed before proceeding
	require_once('_all-required-language.php');
	
	/*************************************************************************/

	$this->load_langfile('global/global.php');

	/*************************************************************************/
	
	require_once('_all-required-recovery.php');
	
	/*************************************************************************/

	$codeuser = '';
	if ($this->param('cu')) $codeuser = $this->db2->e($this->param('cu'));
	
	$coderecovery = '';
	if ($this->param('c')) $coderecovery = $this->db2->e($this->param('c'));

	if (empty($codeuser) || empty($coderecovery)) {
		$D->status = 0;
	} else {
		
		$username = $this->db2->fetch_field("SELECT username FROM users WHERE code='".$codeuser."' AND coderecovery='".$coderecovery."' LIMIT 1");
		
		if ($username) {
			
			$D->newpass = getCode(10, 0);
			$newpass_ms5 = md5($D->newpass);
			$salt = md5(uniqid(rand(),true));
			$hash = hash('sha512', $salt.$newpass_ms5);
			
			$this->db2->query("UPDATE users SET coderecovery='', password='".$hash."', salt='".$salt."' WHERE code='".$codeuser."' AND coderecovery='".$coderecovery."' LIMIT 1");
			
			$D->username = $username;

			$D->status = 2;
			
		} else {
			
			$D->status = 1;
			
		}
		
	}

	/*************************************************************************/

	$D->page_title = $this->lang('global_reset_title').' - '.$C->SITE_TITLE;
		
	$this->load_template('login-resetpass.php');
?>