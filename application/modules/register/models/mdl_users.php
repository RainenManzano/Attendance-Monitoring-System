<?php 

	class Mdl_Users extends CI_Model {
		function __construct() {
			parent::__construct();
		}

		function Insert_User($data) {
			$query = "Insert into users(Firstname, Middlename, Lastname, Birthdate, Username, Pw, Level, Status) values(?,?,?,?,?,?,?, ?);";
			if($this->db->query($query,$data)) {
				redirect(base_url());
			} else {
				die($this->db->error());
			}
		}

		function validateUser($firstname, $lastname, $birthdate) {
			$query = "SELECT * FROM `users` WHERE Firstname=? and Lastname=? and Birthdate=? and level=0";
			$res = $this->db->query($query, array($firstname, $lastname, $birthdate));
			if(!$res) {
				return $this->db->error();
			} else {
				return $res->num_rows();
			}
		}
	}