<?php
	$this->user->logout();
	session_destroy();
	$this->redirect($C->SITE_URL);
?>