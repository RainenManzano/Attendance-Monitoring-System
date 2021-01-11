<?php 

	class Mdl_Class extends CI_Model {
		function __construct() {
			parent::__construct();
		}

		function getAllClass() {
			$query = "Select c.Id, c.Subject_Code, c.Subject, c.Subject_Description, c.Units, u.Firstname, u.Middlename, u.Lastname from class c inner join users u on c.User_Id = u.User_Id;";
			return $this->db->query($query);
		}

		function getTeacherClasses($user_id) {
			$query = "SELECT Id, Subject_Code, Subject, Units from class where User_Id = ? and Status = 1;";
			$result = $this->db->query($query, array($user_id));
			if(!$result) 
				die($this->db->error());
			else
				return $result;
		}

		function getAllSections() {
			$query = "SELECT * from section;";
			$res = $this->db->query($query);
			if(!$res)
				die($this->db->error());
			else
				return $res;
		}

		function Get_Teachers() {
			$query = "SELECT User_ID, Firstname, Middlename, Lastname from users where Level = 0 and Status = 'Active'; ";
			$res = $this->db->query($query);
			if(!$res) 
				die($this->db->error());
			else
				return $res;
		}

		function getClassInfo($classid) {
			$query = "Select class.*, sec.*, u.User_Id, u.Firstname, u.Middlename, u.Lastname from class 
			inner join section sec on class.Section_Id = sec.Section_Id 
			inner join users u on u.User_ID = class.User_Id 
			where Id = ?;";
			return $this->db->query($query, array($classid));
		}

		function GetClassSchedule($classid) {
			$query = "SELECT * from schedule where Class_Id = ? order by Schedule_Id asc;";
			$res = $this->db->query($query,array($classid));
			if(!$res) 
				die($this->db->error());
			else
				return $res;
		}

		function Get_Dates($class_id, $from, $to) {
			$query = "SELECT distinct Datein from attendance 
					where Class_Id = ? 
					and Datein between CAST(? as Date) and CAST(? as Date)
					order by Datein asc;";
			$res = $this->db->query($query, array($class_id, $from, $to));
			if(!$res) 
				die($this->db->error());
			else 
				return $res;
		}

		function Get_Students_By_Class($class_id) {
			$query = "SELECT student.Id, student.Student_No, student.Lastname, student.Firstname, student.Middlename
					from student
					INNER JOIN class on class.Section_Id = student.Section_Id
					where class.Id = ?
					order by student.Id asc;";
			$res = $this->db->query($query, array($class_id));
			if(!$res) 
				die($this->db->error());
			else 
				return $res;
		}

		function Get_Students_Attendance($class_id, $from, $to) {
			$query = "SELECT Student_Id, Datein, Timein 
					from attendance
					where Class_Id = ?
					AND
					Datein between CAST(? as Date) and CAST(? as Date)
					ORDER BY Student_Id asc;";
			$res = $this->db->query($query, array($class_id, $from, $to));
			if(!$res)
				die($this->db->error());
			else
				return $res;
		}

		function Insert_Class($subject_code, $subject_name, $subject_desc, $units, $section_id, $user_id) {
			$query = "INSERT into class(Subject_Code, Subject, Subject_Description, Units, Section_Id, User_Id) values(?, ?, ?, ?, ?, ?);";
			if(!$this->db->query($query, array($subject_code, $subject_name, $subject_desc, $units, $section_id, $user_id))) 
				die($this->db->error());
			else
				return $this->db->insert_id();
		}

		function Insert_Schedule($class_id, $sched_day, $sched_time_begin, $sched_time_end) {
			$ctr = 0;
			$query = "INSERT INTO schedule() values(null, ?, ?, ?, ?);";
			foreach($sched_day as $sched) {
				if(!$this->db->query($query, array($sched_day[$ctr], $sched_time_begin[$ctr], $sched_time_end[$ctr], $class_id)))
					die($this->db->error());
				$ctr ++;
			}
		}

		function Deactivate_Class($class_id) {
			$query = "UPDATE class SET Status = 0 where Id = ?;";
			if(!$this->db->query($query,array($class_id))) 
				die($this->db->error());
		}

		function Delete_Class($class_id) {
			$query = "DELETE from class where Id = ?;";
			if(!$this->db->query($query, array($class_id)))
				die($this->db->error());
		}
	}