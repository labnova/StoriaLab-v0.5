<?php
	if (isset($_SESSION["DATAGLOBAL"][0]) && !empty($_SESSION["DATAGLOBAL"][0])) $C->LANGUAGE = $_SESSION["DATAGLOBAL"][0];

	$this->load_langfile('global/global.php');
	
	$errored = 0;
	$txterror = '';
	
	$squery = '';

	if (isset($_POST["q"]) && !empty($_POST["q"])) $squery = $this->db1->e($_POST["q"]);

	if (empty($squery) || strlen($squery)<=2) { $errored = 1; $txterror .= '<div class="centered mrg20B txtsize01">'.$this->lang('global_search_qshort').'</div>'; }

	if ($errored == 1) {
		$D->divclose = '<div class="areaclose"><a href="#" onclick="hideSearchTop(); return false;" title="'.$this->lang('global_txt_close_notification').'"><img src="'.$C->SITE_URL.'themes/default/imgs/icoclose.png"></a></div>';
		$cadreturn = '<div id="contentSearch"><div id="resultsSearch">' . $D->divclose . $txterror . '</div></div>';
		echo($cadreturn);
	} else {

		$r = $this->db2->query("SELECT DISTINCT trend FROM trends WHERE trend like '%".$squery."%' LIMIT 0,".$C->NUM_RESULT_SEARCH_TOP);
	
		$D->htmlTrends = '';
		ob_start();
	
		while( $obj = $this->db2->fetch_object($r) ) {
			$D->g = $obj;
			$this->load_template('__search-top-one-trend.php');
		}
		
		$D->htmlTrends = ob_get_contents();
		ob_end_clean();
		
		unset($r, $obj);
		
		if (empty($D->htmlTrends)) {
			$D->htmlTrends = '<div class="centered pdn20B txtsize01">'.$this->lang('global_search_noresult').'</div>';
		}
		$D->divclose = '<div class="areaclose"><a href="#" onclick="hideSearchTop(); return false;" title="'.$this->lang('global_search_msgclose').'"><img src="'.$C->SITE_URL.'themes/default/imgs/icoclose.png"></a></div>';
		
		$cadreturn = '<div id="contentSearch">';
		$cadreturn .= '<div id="resultsSearch">';
		$cadreturn .= $D->divclose;
		$cadreturn .= $D->htmlTrends;
		$cadreturn .= '</div>';
		$cadreturn .= '</div>';
		
		echo $cadreturn;
	}
?>