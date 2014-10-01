<?php
	// We check in which language we will work
	if (isset($_SESSION["DATAGLOBAL"][0]) && !empty($_SESSION["DATAGLOBAL"][0])) $C->LANGUAGE = $_SESSION["DATAGLOBAL"][0];

	$this->load_langfile('global/global.php');
	$this->load_langfile('inside/dashboard.php');
	
	$errored = 0;
	$txterror = '';

	$numitems = $iduser = 0;
	
	if (isset($_POST["ni"]) && !empty($_POST["ni"])) $numitems = $this->db1->e($_POST["ni"]);
	if (isset($_POST["idu"]) && !empty($_POST["idu"])) $iduser = $this->db1->e($_POST["idu"]);
	
	if (!is_numeric($numitems) || $numitems <= 0) { $errored = 1; $txterror .= 'Error... '; }
	if (!is_numeric($iduser) || $iduser <= 0) { $errored = 1; $txterror .= 'Error... '; }
	
	if ($errored == 1) {
		echo('0: '.$txterror);
	} else {
		
		$D->avatar = $this->user->info->avatar;
		$D->username = $this->user->info->username;
		$D->nameUser = (empty($this->user->info->firstname) || empty($this->user->info->lastname))?$this->user->info->username:($this->user->info->firstname.' '.$this->user->info->lastname);
		
		//We load the comments
		$totalitems = $this->db2->fetch_field('SELECT count(idcomment) FROM comments WHERE iduser='.$this->user->id);
		
		$r = $this->db2->query('SELECT posts.code as pcode, posts.iduser as piduser, posts.idpost as pidpost, username, comments.idcomment, comments.comment, comments.whendate FROM comments, posts, users WHERE users.iduser=posts.iduser AND comments.iduser='.$this->user->id.' AND comments.idpost=posts.idpost ORDER BY comments.whendate DESC LIMIT '.$numitems.','.$C->NUM_COMMENTS_DASH_PAGE);
	
		$numitemsnow = $this->db2->num_rows();

		$htmlResults = '';
		ob_start();
		
		while( $obj = $this->db2->fetch_object($r) ) {
			$D->g = $obj;
			$D->g->comment = stripslashes($D->g->comment);
			$this->load_template('__dashboard-one-comment.php');
		}
		
		$htmlResults = ob_get_contents();
		ob_end_clean();
		
		unset($r, $obj);

		if ($totalitems <= $numitemsnow + $numitems) {
			echo("2: ".$htmlResults);
			return;
		} else {
			echo("1: ".$htmlResults);
			return;	
		}
			
	}


?>