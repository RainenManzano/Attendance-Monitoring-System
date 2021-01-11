<?php 

	class Mdl_Student extends CI_Model {

		function __construct() {
			parent::__construct();
		}

		function getAllStudents() {
			$query = "SELECT * from student 
							left join section on student.Section_Id = section.Section_Id";
			$result = $this->db->query($query);
			if($result) 
				return $result;
			else
				die($this->db->error());
		}

		function getMyStudents($userId) {
			$query = "select * from class
							inner join section on section.Section_Id = class.Section_Id
							inner join student on student.Section_Id = class.Section_Id
							where class.User_Id = ? and class.status=1";
			$result = $this->db->query($query, array($userId));
			if($result) 
				return $result;
			else
				die($this->db->error());
		}

		function getListOfSection() {
			$query = "SELECT * from section;";
			$res = $this->db->query($query);
			if($res)
				return $res;
			else
				die($this->db->error());
		}

		function insertStudent($studno, $firstname, $middlename, $lastname, $image, $section) {
			$query = "INSERT into student(Student_No, Firstname, Middlename, Lastname, Image_Path, Section_Id) values(?,?,?,?,?,?);";
			if(!$this->db->query($query, array($studno, $firstname, $middlename, $lastname, $image, $section)))
				die($this->db->error());
			else{
				return $this->db->insert_id();
			}
		}

		function updateStudent($studid, $studno, $firstname, $middlename, $lastname, $section) {
			$query = "UPDATE student set Student_No = ?, Firstname = ?, Middlename = ?, Lastname = ?, Section_Id = ? where Id = ?;";
			if(!$this->db->query($query, array($studno, $firstname, $middlename, $lastname, $section, $studid))) {
				die($this->db->error());
			}
		}

		function updateImagePath($studentid, $image) {
			$query = "UPDATE student set Image_Path = ? where Id = ?;";
			if(!$this->db->query($query, array($image, $studentid)))
				die($this->db->error());
		}

		function deleteStudent($studentid) {
			$query = "DELETE from student where Id = ?;";
			if(!$this->db->query($query, array($studentid)))
				die($this->db->error());
		}

		function getStudentInfo($studentid) {
			$query = "SELECT * from student left join section on student.Section_Id = section.Section_Id where Id = ?;";
			$res = $this->db->query($query, array($studentid));
			if(!$res)
				return $this->db->error();
			else
				return $res;
		}

	}

?>