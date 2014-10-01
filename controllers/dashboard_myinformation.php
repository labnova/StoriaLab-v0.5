<?php
	if( !$this->user->is_logged ) {
		$this->redirect('home');
	}
	
	
	/*************************************************************************/
	// needed before proceeding
	require_once('_all-required-language.php');
	
	$this->load_langfile('global/global.php');	
	$this->load_langfile('inside/dashboard.php');

	/*************************************************************************/
	
	
	require_once('_all-required-dashboard.php');
	

	/*************************************************************************/


	$D->optionactive = 2;
	$this->load_template('dashboard-myinformation.php');
?>