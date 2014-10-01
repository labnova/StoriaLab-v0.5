<?php
	// We check in which language we will work
	if (isset($_SESSION["DATAGLOBAL"][0]) && !empty($_SESSION["DATAGLOBAL"][0])) $C->LANGUAGE = $_SESSION["DATAGLOBAL"][0];

	$this->load_langfile('global/global.php');
	$this->load_langfile('inside/dashboard.php');
	
	$errored = 0;
	$txterror = '';

	$codepost = '';
	$numitems = 0;
	
	if (isset($_POST["cp"]) && !empty($_POST["cp"])) $codepost = $this->db1->e($_POST["cp"]);
	if (isset($_POST["ni"]) && !empty($_POST["ni"])) $numitems = $this->db1->e($_POST["ni"]);
	
	if (empty($codepost)) { $errored = 1; $txterror .= 'Error. '; }
	if (!is_numeric($numitems) || $numitems <= 0) { $errored = 1; $txterror .= 'Error. '; }
	
	if ($errored == 1) {
		echo('0: '.$txterror);
	} else {
		
		$onePost = new post($codepost);
		$htmlResults = '';
		$totalitems = $onePost->numComments();
		$allcommentspost = $onePost->getComments($numitems,$C->NUM_COMMENTS_PER_POST);
		$numitemsnow = count($allcommentspost);
		
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
			$D->o_idpost = $onecomment->idpost;
			$D->o_idUserOwner = $onePost->iduser;
			$D->o_codepost = $codepost;
			$this->load_template('__dashboard-onecomment-post.php');
			$htmlResults .= ob_get_contents();
			ob_end_clean();
		}
		unset($onecomment);

		if ($totalitems <= $numitemsnow + $numitems) {
			echo("2: ".$htmlResults);
			return;
		} else {
			echo("1: ".$htmlResults);
			return;	
		}
			
	}
?>