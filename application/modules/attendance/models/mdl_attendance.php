<?php

	class mdl_attendance extends CI_Model { 
		function __construct() {
			parent::__construct();
		}

		function GetInfoByStudentNumber($student_id) {
			$query = "SELECT * from student 
					INNER JOIN section on student.Section_Id = section.Section_Id 
					INNER JOIN attendance on student.Id = attendance.Student_Id
					where student.Id = ?
					and attendance.Datein = cast(now() as DATE); ";
			$res = $this->db->query($query, array($student_id));
			if(!$res) 
				die($this->db->error());
			else
				return $res;
		}

		function AttendanceExist($student_id, $class_id) {
			$query = "SELECT * from attendance
					INNER JOIN student on attendance.Student_Id = student.Id
					where attendance.Class_Id = ?
					and student.Student_No = ?
					and attendance.Datein = cast(now() as DATE);";
			$res = $this->db->query($query, array($class_id, $student_id));
			if(!$res)
				die($this->db->error());
			else {
				if($res->num_rows()!=0) {
					return true;
				} else {
					return false;
				}
			}
		}

		function Student_Exist($class_id, $student_no) {
			$query = "SELECT class.Section_Id, student.Id from class 
			INNER JOIN student on student.Section_Id = class.Section_Id
			WHERE class.Id = ?
			and student.Student_No = ?;";
			$res = $this->db->query($query, array($class_id, $student_no));
			if(!$res) 
				die($this->db->error());
			else {
				return $res;
			}
		}

		function InsertAttendance($class_id, $student_id, $datein, $timein) {
			$query = "INSERT INTO attendance(Class_Id, Student_Id, Datein, Timein) values(?,?,?,?);";
			if(!$this->db->query($query, array($class_id, $student_id, $datein, $timein))) {
				die($this->db->error());
			}
		}

	}