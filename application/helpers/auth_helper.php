<?php

	function logout() {
		$ci =& get_instance();
		$ci->session->sess_destroy();
		redirect(base_url());
	}

	function SessionExist() {
		$ci =& get_instance();
		if(!$ci->session->has_userdata("currentuser")) {
			redirect(base_url());	
		}
		// else {
		// 	redirect(base_url("section"));
		// }
	}

	function isAdmin($level) {
		if($level==1) {
			return true;
		} else {
			return false;
		}
	}

?>