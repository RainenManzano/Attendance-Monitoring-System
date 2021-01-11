<?php 

	class Mdl_Schedule extends CI_Model {
		function __construct() {
			parent::__construct();
		}

		function getSchedules() {
			$query = "select schedule.Day, schedule.Beginning_Time, schedule.End_Time, class.Subject, section.Section_Name, users.Firstname, users.Middlename, users.Lastname from class
				inner join schedule on schedule.Class_Id = class.Id
				inner join section on section.Section_Id = class.Section_Id
				inner join users on class.User_Id = users.User_ID
				where class.Status = 1 and users.Level = 0 and users.Status = 'Active'";
			$res = $this->db->query($query);
			if(!$res) 
				die($this->db->error());
			else 
				return $res;
		}

		function getMySchedules($userId) {
			$query = "select * from class
							inner join schedule on schedule.Class_Id = class.Id
							inner join section on section.Section_Id = class.Section_Id
							where class.User_Id = ? and class.Status = 1";
			$res = $this->db->query($query, array($userId));
			if(!$res) 
				die($this->db->error());
			else 
				return $res;
		}

		

	}