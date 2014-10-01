<?php 
	// We check in which language we will work
	if (isset($_SESSION["DATAGLOBAL"][0]) && !empty($_SESSION["DATAGLOBAL"][0])) $C->LANGUAGE = $_SESSION["DATAGLOBAL"][0];

	$this->load_langfile('inside/dashboard.php');
	$this->load_langfile('global/global.php');

	// We are here only if you're logged in
	if (!$this->user->is_logged) {
		echo('0: '.$this->lang('dashboard_no_session'));
		die();
	}
	
	$errored = 0;
	$txterror = '';
	
	$action=0;
	
	if (isset($_POST["todo"]) && $_POST["todo"] != '') $action = $this->db1->e($_POST["todo"]);
	if (!is_numeric($action)) {
		$errored = 1;
		$txterror .= 'Error. ';
		echo('0: '.$caderror);
		die();
	}

	// 
	if ($action == 1)	{

		$ip = $idowner = 0;
		
		if (isset($_POST["ip"]) && $_POST["ip"]!='') $ip = $this->db1->e($_POST["ip"]);
		if (isset($_POST["iu"]) && !empty($_POST["iu"])) $idowner = $this->db1->e($_POST["iu"]);
		
		if ($ip == 0) { $errored = 1; $txterror .= 'Error. '; }
		if ($idowner == 0) { $errored = 1; $txterror .= 'Error. '; }
		
	}

	if ($action == 2)	{

		$ip = $idowner = 0;
		
		if (isset($_POST["ip"]) && $_POST["ip"]!='') $ip = $this->db1->e($_POST["ip"]);
		if (isset($_POST["iu"]) && !empty($_POST["iu"])) $idowner = $this->db1->e($_POST["iu"]);
		
		if ($ip == 0) { $errored = 1; $txterror .= 'Error. '; }
		if ($idowner == 0) { $errored = 1; $txterror .= 'Error. '; }
		
	}

	if ($action == 3)	{
		$codpost = '';
		if (isset($_POST["cp"]) && !empty($_POST["cp"])) $codpost = $this->db1->e($_POST["cp"]);
		if (empty($codpost)) { $errored = 1; $txterror .= 'Error... '; }
	}

	if ($action == 4)	{
		$comment = $codep = '';
		$ip = $idowner = 0;
		
		if (isset($_POST["ip"]) && $_POST["ip"]!='') $ip = $this->db1->e($_POST["ip"]);
		if (isset($_POST["iu"]) && !empty($_POST["iu"])) $idowner = $this->db1->e($_POST["iu"]);
		if (isset($_POST["c"]) && !empty($_POST["c"])) $comment = $this->db1->e(htmlspecialchars($_POST["c"]));
		if (isset($_POST["cp"]) && !empty($_POST["cp"])) $codep = $this->db1->e($_POST["cp"]);
		
		if ($ip == 0) { $errored = 1; $txterror .= 'Error. '; }
		if ($idowner == 0) { $errored = 1; $txterror .= 'Error. '; }
		if (empty($comment)) { $errored = 1; $txterror .= 'Error. '; }
		if (empty($codep)) { $errored = 1; $txterror .= 'Error. '; }
	}
	
	if ($action == 5)	{
		$idcomment = $ip = $idowner = 0;
		
		if (isset($_POST["ip"]) && $_POST["ip"]!='') $ip = $this->db1->e($_POST["ip"]);
		if (isset($_POST["ic"]) && !empty($_POST["ic"])) $idcomment = $this->db1->e($_POST["ic"]);
		if (isset($_POST["io"]) && !empty($_POST["io"])) $idowner = $this->db1->e($_POST["io"]);
		if ($idcomment == 0) { $errored = 1; $txterror .= 'Error... '; }
		if ($idowner == 0) { $errored = 1; $txterror .= 'Error. '; }
		if ($ip == 0) { $errored = 1; $txterror .= 'Error. '; }
	}
	
	if ($errored == 1) {
		echo('0: '.$txterror);
	} else {
		
		// like
		if ($action == 1) {	
			$r = $this->db1->query("INSERT INTO likes SET idpost=".$ip.", iduser=".$this->user->id.", datewhen='".time()."'");
			$idlike = $this->db1->insert_id();
			$this->db1->query("UPDATE users SET num_likes=num_likes+1 WHERE iduser=".$this->user->id.' LIMIT 1');
			$this->db1->query("UPDATE posts SET numlikes=numlikes+1 WHERE idpost=".$ip.' LIMIT 1');
			//$this->db1->query('INSERT INTO activities SET iduser='.$this->user->id.', action=5, idresult='.$idlike.', iditem='.$idphoto.', typeitem=1, date="'.time().'"');
			if ($this->user->id != $idowner) {
				$this->db1->query("INSERT INTO notifications SET notif_type=2, idresult=".$idlike.", to_user_id=".$idowner.", from_user_id=".$this->user->id.", notif_object_type=1, notif_object_id=".$ip.",date='".time()."'");
				$this->db1->query("UPDATE users SET num_notifications=num_notifications+1 WHERE iduser=".$idowner.' LIMIT 1');
			}
			echo('1: Ok');
			return;
		}

		if ($action == 2) {	
				$r = $this->db1->query("DELETE FROM likes WHERE idpost=".$ip." AND iduser=".$this->user->id);
				//$idlike = $this->db1->insert_id();
				$this->db1->query("UPDATE users SET num_likes=num_likes-1 WHERE iduser=".$this->user->id.' LIMIT 1');
				$this->db1->query("UPDATE posts SET numlikes=numlikes-1 WHERE idpost=".$ip.' LIMIT 1');
				//$this->db1->query('DELETE FROM activities WHERE iduser='.$this->user->id.' AND action=5 AND iditem='.$idphoto.' AND typeitem=1');

				if ($this->user->id != $idowner) {
					$this->db1->query("DELETE FROM notifications WHERE notif_type=2 AND to_user_id=".$idowner." AND from_user_id=".$this->user->id." AND notif_object_type=1 AND notif_object_id=".$ip);
					$nnotifications = $this->network->getNumNotifications($idowner);
					if ($nnotifications <= 0) $nnotifications = 0;
					else $nnotifications = $nnotifications - 1;
					$this->db1->query("UPDATE users SET num_notifications=".$nnotifications." WHERE iduser=".$idowner.' LIMIT 1');
				}
				echo('1: Ok');
				return;
		}

		if ($action == 3) {
			$thepost = new post($codpost);
			$thepost->deletePost();
			unset($thepost);
			echo('1: Ok');
			return;
		}
		
		if ($action == 4) {			
			$r = $this->db1->query("INSERT INTO comments SET idpost=".$ip.", iduser=".$this->user->id.", comment='".$comment."', whendate='".time()."'");
			$idcomment = $this->db1->insert_id();
			$this->db1->query("UPDATE users SET num_comments=num_comments+1 WHERE iduser=".$this->user->id.' LIMIT 1');
			$this->db1->query("UPDATE posts SET numcomments=numcomments+1 WHERE idpost=".$ip.' LIMIT 1');
			//$this->db1->query('INSERT INTO activities SET iduser='.$this->user->id.', action=4, idresult='.$idcomment.', iditem='.$iditem.', typeitem=1, date="'.time().'"');
			if ($this->user->id != $idowner) {
				$this->db1->query("INSERT INTO notifications SET notif_type=3, idresult=".$idcomment.", to_user_id=".$idowner.", from_user_id=".$this->user->id.", notif_object_type=1, notif_object_id=".$ip.",date='".time()."'");
				$this->db1->query("UPDATE users SET num_notifications=num_notifications+1 WHERE iduser=".$idowner.' LIMIT 1');
			}
			
			$htmlReturn = '';
			ob_start();
			$D->o_comment = stripslashes($comment);
			$D->o_username = stripslashes($this->user->info->username);
			$D->o_firstname = stripslashes($this->user->info->firstname);
			$D->o_lastname = stripslashes($this->user->info->lastname);
			$D->o_nameUser = (empty($D->o_firstname) || empty($D->o_lastname))?stripslashes($D->o_username):(stripslashes($D->o_firstname).' '.stripslashes($D->o_lastname));
			$D->o_whendate = time();
			$D->o_avatar =  empty($this->user->info->avatar)?$C->AVATAR_DEFAULT:$this->user->info->avatar;
			$D->o_idcomment = $idcomment;
			$D->o_idUser = $this->user->id;
			$D->o_idpost = $ip;
			$D->o_idUserOwner = $idowner;
			$D->o_codepost = $codep;
			$this->load_template('__dashboard-onecomment-post.php');	
			$htmlReturn = ob_get_contents();
			ob_end_clean();

			echo("1: ".$htmlReturn);
			return;
		}
		
		if ($action == 5) {
			$this->db1->query("DELETE FROM comments WHERE idcomment=".$idcomment);
			if ($this->db1->affected_rows()>0) {
				$this->db1->query("UPDATE users SET num_comments=num_comments-1 WHERE iduser=".$this->user->id.' LIMIT 1');
				$this->db1->query("UPDATE posts SET numcomments=numcomments-1 WHERE idpost=".$ip.' LIMIT 1');
				//$this->db1->query('DELETE FROM activities WHERE iduser='.$this->user->id.' AND action=4 AND idresult='.$idcomment);

				if ($this->user->id != $idowner) {
					$this->db1->query("DELETE FROM notifications WHERE notif_type=3 AND idresult=".$idcomment." AND from_user_id=".$this->user->id);
					
					$nnotifications = $this->network->getNumNotifications($idowner);
					if ($nnotifications <= 0) $nnotifications = 0;
					else $nnotifications = $nnotifications - 1;
					
					$this->db1->query("UPDATE users SET num_notifications=".$nnotifications." WHERE iduser=".$idowner." LIMIT 1");
				}
			}
			echo('1: Ok');
			return;
		}

	
	}
?>