<?php
	// We check in which language we will work
	if (isset($_SESSION["DATAGLOBAL"][0]) && !empty($_SESSION["DATAGLOBAL"][0])) $C->LANGUAGE = $_SESSION["DATAGLOBAL"][0];

	$this->load_langfile('global/global.php');
	$this->load_langfile('outside/profile.php');
	
	$D->is_logged = 0;
	if ($this->user->is_logged) {
		$D->me = $this->user->info;
		$D->is_logged = 1;
	}
	
	$errored = 0;
	$txterror = '';

	$numitems = $iduser = 0;
	
	if (isset($_POST["ni"]) && !empty($_POST["ni"])) $numitems = $this->db1->e($_POST["ni"]);
	if (isset($_POST["idu"]) && !empty($_POST["idu"])) $iduser = $this->db1->e($_POST["idu"]);
	
	if (!is_numeric($numitems) || $numitems <= 0) { $errored = 1; $txterror .= 'Error. '; }
	if (!is_numeric($iduser) || $iduser <= 0) { $errored = 1; $txterror .= 'Error. '; }
	
	if ($errored == 1) {
		echo('0: '.$txterror);
	} else {
		
		$itemsperpage = $C->NUM_ACTIVITIES_PAGE;
		
		$D->u = $this->network->get_user_by_id(intval($iduser));
		
		$totalitems = $this->db2->fetch_field('SELECT count(id) FROM activities WHERE iduser='.$iduser);

		$theactivities = $this->db2->fetch_all('SELECT activities.iduser, iduser2, action, idresult, iditem, date, username, firstname, lastname, avatar FROM activities, users WHERE (users.iduser=activities.iduser) AND activities.iduser='.$iduser.' ORDER BY date DESC LIMIT '.$numitems.','.$itemsperpage);

		$numitemsnow = count($theactivities);
		
		$D->nameUser = (empty($D->u->firstname) || empty($D->u->lastname))?$D->u->username:($D->u->firstname.' '.$D->u->lastname);
		 
		// see if there are "follows" and we group the user ids seconds
		$secondsids = array();
		foreach($theactivities as $oneactivity) {
			if ($oneactivity->action == 1 && $oneactivity->iduser2 != 0) $secondsids[] = $oneactivity->iduser2;
		}
		
		if (count($secondsids) > 0) {
			$following = $this->db2->fetch_all('SELECT iduser, username, firstname, lastname, avatar, num_posts, validated FROM users WHERE iduser in ('.implode($secondsids,',').')');
		}
		/////////
		
		$htmlResults = '';
		
		ob_start();
		foreach($theactivities as $oneactivity) {
			
			$D->userName = $oneactivity->username;
			$D->nameUser = (empty($oneactivity->firstname) || empty($oneactivity->lastname))?$oneactivity->username:($oneactivity->firstname.' '.$oneactivity->lastname);
			$D->userAvatar = $oneactivity->avatar;
			$D->isThisUserVerified0 = $this->network->isUserVerified($oneactivity->iduser);
			
			switch ($oneactivity->action) {
				case 1:
					$D->txtaction = $this->lang('profile_activities_follow');
					foreach($following as $onefg) {
						if ($onefg->iduser == $oneactivity->iduser2) {
							$D->isThisUserVerified = $onefg->validated==1?TRUE:FALSE;
							$D->f_username = $onefg->username;
							$D->f_date = $oneactivity->{'date'};
							$D->f_name = (empty($onefg->firstname) || empty($onefg->lastname))?stripslashes($onefg->username):(stripslashes($onefg->firstname).' '.stripslashes($onefg->lastname));
							$D->f_avatar = $onefg->avatar;
							$D->f_numphotos = $onefg->num_posts;
							$this->load_template('__profile-activity-one-following.php');
						}
					}
					
					break;
				
				case 2:
					// in case de hability albums
					break;
				
				case 3:
					$D->a_date = $oneactivity->{'date'};
					
					$D->idpost = $oneactivity->iditem;
					$D->codepost = $this->network->getCodePost($D->idpost);
					$onePost = new post($D->codepost);
					$D->idUser = $onePost->iduser;
					$D->typepost = $onePost->typepost;
					$D->numlikes = $onePost->numlikes;
					$D->numcommentstotal = $onePost->numcomments;
					$D->post = stripslashes($onePost->post);
					$D->typepost = $onePost->typepost;
					$D->valueattach = $onePost->valueattach;
					
					// see if the favorite is for the observer
					$D->liketoUser = 0;
					if ($D->is_logged == 1) {
						if ($onePost->likeOfUser($this->user->id) > 0) $D->liketoUser = 1;
					}
					
					$D->htmlcommentspost = '';
					$D->totalcomments = $onePost->numComments();
					$allcommentspost = $onePost->getComments(0,$C->NUM_COMMENTS_PER_POST);
					$D->numcomments = count($allcommentspost);
					
					$allcommentspost = array_reverse($allcommentspost);	
					
					foreach($allcommentspost as $onecomment){
						ob_start();
						$D->o_comment = stripslashes($onecomment->comment);
						$D->o_username = stripslashes($onecomment->username);
						$D->o_firstname = stripslashes($onecomment->firstname);
						$D->o_lastname = stripslashes($onecomment->lastname);
						$D->o_nameUser = (empty($D->o_firstname) || empty($D->o_lastname))?stripslashes($D->o_username):(stripslashes($D->o_firstname).' '.stripslashes($D->o_lastname));
						$D->o_whendate = $onecomment->whendate;
						$D->o_avatar =  empty($onecomment->avatar)?$C->AVATAR_DEFAULT:$onecomment->avatar;
						$D->o_idcomment = $onecomment->idcomment;
						$D->o_idUser = $onecomment->iduser;
						$D->o_idpost = $D->idpost;
						$D->o_idUserOwner = $D->idUser;
						$D->o_codepost = $D->codepost;
						$this->load_template('__profile-onecomment-post.php');
						$D->htmlcommentspost .= ob_get_contents();
						ob_end_clean();
					}
					unset($onecomment);
					
					$this->load_template('__profile-activity-one-post.php');
					unset($onePost);
					break;
				
				case 4:
					//if comment a post
					break;
					
				case 5:
					// If add a post to your favorites
					break;
				
			}
		}
		
		//ponemos el dia de registro del perfil
		if ($totalitems <= $numitemsnow + $numitems) {
			$D->isUserVerified = $this->network->isUserVerified($iduser);
			$this->load_template('__profile-info-register.php');
		}
		///////////////////////////////////////
		
		$htmlResults = ob_get_contents();
		ob_end_clean();

		
		if ($totalitems <= ($numitemsnow + $numitems) ) {
			echo("2: ".$htmlResults);
			return;
		} else {
			echo("1: ".$htmlResults);
			return;	
		}
			
	}


?>