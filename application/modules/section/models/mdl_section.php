<?php 

	class Mdl_Section extends CI_Model {
		function __construct() {
			parent::__construct();
		}

		function getSections() {
			$query = "SELECT * from section;";
			$queryResult = $this->db->query($query);
			if($queryResult) {
				return $queryResult;
			} else {
				die($queryResult->error());
			}  
		}

		function getMySections($teacher_Id) {
			$query = "SELECT * from section 
							inner join class on section.Section_Id = class.Section_Id
							where class.User_Id = ?;";
			$res = $this->db->query($query, array($teacher_Id));
			if(!$res) {
				die($this->db->error());
			} else {
				return $res;
			}
		}

		function getSectionInfo($sectionid) {
			$query = "SELECT * from section sec left join student stud on sec.Section_Id = stud.Section_Id where sec.Section_Id = ?";
			$result = $this->db->query($query, array($sectionid));
			if($result) {
				return $result;
			} else {
				die($this->db->error());
			}
		}

		function getStudentsWithoutSection() {
			$query = "SELECT Id, Student_No, Firstname, Middlename, Lastname from student where Section_Id is NULL;";
			$res = $this->db->query($query);
			if(!$res) 
				die($this->db->error());
			else 
				return $res;
		}

		function getBlockStudents($sectionid) {
			$query = "SELECT Id, Student_No, Firstname, Middlename, Lastname, Section_Id
					  FROM student
					  WHERE Section_Id = ? OR Section_Id IS NULL;";
			$res = $this->db->query($query, array($sectionid));
			if(!$res)
				die($this->db->error());
			else 
				return $res;
		}

		function updateStudentSection($sectionId, $studentsId) {
			$query = "UPDATE student set Section_Id = ? where Id = ?;";
			for($ctr=0;$ctr<sizeOf($studentsId);$ctr++) {
				if(!$this->db->query($query, array($sectionId, $studentsId[$ctr])))
					die($this->db->error());
			}
		}

		function updateSection($sectionid, $sectionname, $sectiondesc) {
			$query = "UPDATE section set Section_Name = ?, Section_Desc = ? where Section_Id = ?;";
			if(!$this->db->query($query,array($sectionname, $sectiondesc, $sectionid)))
				die($this->db->error());
		}

		function insertSection($sectionName, $sectionDesc) {
			$query = "INSERT into section(Section_Name, Section_Desc) values(?, ?);";
			if(!$this->db->query($query, array($sectionName, $sectionDesc)))
				die($this->db->error());
			else
				return $this->db->insert_id();
		}

		function deleteSection($sectionId) {
			$query = "DELETE from section where Section_Id = ?";
			if(!$this->db->query($query, array($sectionId)))
				die($this->db->error());
		}

		

	}