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
	
	$D->avatar = $this->user->info->avatar;
	$D->username = $this->user->info->username;
	$D->nameUser = (empty($this->user->info->firstname) || empty($this->user->info->lastname))?$this->user->info->username:($this->user->info->firstname.' '.$this->user->info->lastname);

	$D->totalcomments = $this->db2->fetch_field('SELECT count(idcomment) FROM comments WHERE iduser='.$this->user->id);
	
	$r = $this->db2->query('SELECT posts.code as pcode, posts.iduser as piduser, posts.idpost as pidpost, username, comments.idcomment, comments.comment, comments.whendate FROM comments, posts, users WHERE users.iduser=posts.iduser AND comments.iduser='.$this->user->id.' AND comments.idpost=posts.idpost ORDER BY comments.whendate DESC LIMIT 0,'.$C->NUM_COMMENTS_DASH_PAGE);

	$D->numcomments = $this->db2->num_rows();

	$D->htmlComments = '';
	ob_start();
	
	while( $obj = $this->db2->fetch_object($r) ) {
		$D->g = $obj;
		$D->g->comment = stripslashes($D->g->comment);
		$this->load_template('__dashboard-one-comment.php');
	}
	
	$D->htmlComments = ob_get_contents();
	ob_end_clean();
	
	unset($r, $obj, $D->g);
	
	/*************************************************************************/

	$D->optionactive = 5;
	$this->load_template('dashboard-mycomments.php');
?>