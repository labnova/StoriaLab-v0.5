<?php
/*************************************************************************/

	// If there is a user logged in, get ready a variable for use.
	$D->is_logged = 0;
	if ($this->user->is_logged) {
		$D->me = $this->user->info;
		$D->is_logged = 1;
	}
/*************************************************************************/

	$D->i_am_network_admin = ( $this->user->is_logged && $this->user->info->is_network_admin );
	
	
/*************************************************************************/

	$D->adsProfile1 = trim($this->network->get_ads('adsProf01'));
	$D->adsProfile2 = trim($this->network->get_ads('adsProf02'));
	
	
/*************************************************************************/

	$D->useraccesories = '';
	if ($this->user->is_logged) $userAleat = $this->network->getUserAleat(5,$D->me->iduser);
	else $userAleat = $this->network->getUserAleat(5);
	
	ob_start();
	
	foreach($userAleat as $oneUser) {
		$D->acc_name = (empty($oneUser->firstname) || empty($oneUser->lastname))?stripslashes($oneUser->username):(stripslashes($oneUser->firstname).' '.stripslashes($oneUser->lastname));
		$D->acc_avatar = $oneUser->avatar;
		$D->acc_numphotos = $oneUser->num_posts;
		$D->acc_username = $oneUser->username;
		$this->load_template('__accessories-one-user.php');
	}

	$D->useraccesories = ob_get_contents();
	ob_end_clean();
	
	unset($userAleat, $oneUser);
	
	
/*************************************************************************/

	$trendsTopic = $this->network->getTrendsTopic($C->NUM_TRENDS_SIDEBAR);
	
	$D->trendsTopic = '';
	ob_start();
	foreach($trendsTopic as $oneTrend) {
		$D->g = $oneTrend;
		$this->load_template('__search-one-trend.php');
	}
	$D->trendsTopic = ob_get_contents();
	ob_end_clean();
	
	unset($trendsTopic, $oneTrend);

/*************************************************************************/

	$D->site_keywords = $C->SITE_TITLE.', '.$C->SITE_KEYWORDS;
	$D->site_description = $C->SITE_TITLE.', '.$C->SITE_DESCRIPTION;

/*************************************************************************/



?>