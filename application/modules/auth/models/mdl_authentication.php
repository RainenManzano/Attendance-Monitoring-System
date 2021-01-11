<?php

	class Mdl_Authentication extends CI_Model {
		function __construct() {
			parent::__construct();
		}

		function getUser($data) {
			$query = "select * from users where Username = ? and Pw = ? and Status = 'Active';";
			return $this->db->query($query, $data);
		}
	}