<?php

	class Mdl_Users extends CI_Model {
		function __construct() {
			parent::__construct();
		}

		function getUser($userId) {
			$query = "select * from users where User_ID = ?;";
			return $this->db->query($query, array($userId));
		}

		function getAllUsers() {
			$query = "select * from users Order By User_ID desc;";
			return $this->db->query($query);	
		}

		function insertUser($data) {
			$query = "Insert into users(Firstname, Middlename, Lastname, Birthdate, Username, Pw, Level) values(?,?,?,?,?,?,?);";
			if(!$this->db->query($query,$data)) {
				die($this->db->error());
			} 
		}

		function deleteUser($userid) {
			$query = "Delete from users where User_ID = ?";
			if(!$this->db->query($query,array($userid))) {
				die($this->db->error());
			}
		}

		function editUser($userinfo) {
			$query = "Update users set Firstname = ?, Middlename = ?, Lastname = ?, Birthdate = ?, Username = ?, Pw = ?, Level = ?, Status = ? where User_ID = ?;";
			if(!$this->db->query($query, $userinfo)) {
				die($this->db->error());
			}
		}
	}