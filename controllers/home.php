<?php
	if( $this->user->is_logged ) {
		$this->redirect('dashboard');
	}
	
	$D->is_logged = $this->user->is_logged;
	
	$D->is_home = TRUE;
	
	/*************************************************************************/
	// facebook

	require_once('_connect-facebook.php');
		
	
	/*************************************************************************/
	// needed before proceeding
	require_once('_all-required-language.php');
	
	/*************************************************************************/
	
	$this->load_langfile('global/global.php');
	$this->load_langfile('outside/home.php');
	
	/*************************************************************************/
	
	$D->userAleat = $this->network->getUsersAleatHome(8);
	$D->numuserAleat = count($D->userAleat);	
	
	/*************************************************************************/

	$D->page_title	= $this->lang('home_page_title', array('#SITE_TITLE#'=>$C->SITE_TITLE));
	$D->intro_line1	= $this->lang('home_msg_line1', array('#SITE_TITLE#'=>$C->SITE_TITLE));
	$D->intro_line2	= $this->lang('home_msg_line2', array('#SITE_TITLE#'=>$C->SITE_TITLE));
	$D->intro_line3	= $this->lang('home_msg_line3', array('#SITE_TITLE#'=>$C->SITE_TITLE));
	if( isset($C->HOME_INTRO_LINE1) && !empty($C->HOME_INTRO_LINE1) ) {
		$D->page_title	= strip_tags($C->SITE_TITLE.' - '.$C->HOME_INTRO_LINE1);
		$D->intro_line1	= $C->HOME_INTRO_LINE1;
	}
	if( isset($C->HOME_INTRO_LINE2) && !empty($C->HOME_INTRO_LINE2) ) {
		$D->intro_line2	= $C->HOME_INTRO_LINE2;
	}	

	$this->load_template('home.php');
?>