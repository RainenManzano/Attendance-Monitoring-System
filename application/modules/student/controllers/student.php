<?php 

	class Student extends CI_Controller {

		public $currentuser;

		function __construct() {
			parent::__construct();
			$this->currentuser = $this->session->userdata("currentuser");
			SessionExist();
			$this->load->model("mdl_student");
		}

		function index() {
			$dataTemplate["level"] = $this->currentuser["level"];
			if(isAdmin($this->currentuser["level"]))
				$data["students"] = $this->mdl_student->getAllStudents();
			else
				$data["students"] = $this->mdl_student->getMyStudents($this->currentuser["UserId"]);
			$data["sectionList"] = $this->mdl_student->getListOfSection();
			$this->load->view("template/nav-side", $dataTemplate);
			$this->load->view("view_student", $data);
		}

		function editStudentProfile() {
			$student_id = $this->input->post("editid");
			$student_info = $this->mdl_student->getStudentInfo($student_id);
			foreach($student_info->result() as $student) {
				$data["id"] = $student->Id;
				$data["student_num"] = $student->Student_No;
				$data["firstname"] = $student->Firstname;
				$data["middlename"] = $student->Middlename;
				$data["lastname"] = $student->Lastname;
				$data["image_path"] = $student->Image_Path;
				$data["section_id"] = $student->Section_Id;
			}

			$dataTemplate["level"] = $this->currentuser["level"];
			$data["sectionList"] = $this->mdl_student->getListOfSection();
			$this->load->view("template/nav-side", $dataTemplate);
			$this->load->view("editStudent", $data);
		}

		function createStudent() {
			if($_FILES["studentCsv"]["tmp_name"]!="") {
				$ctr=0;
				if($_FILES["studentCsv"]["type"]=="application/vnd.ms-excel - csv") {
					$csvAsArray = array_map('str_getcsv', file($_FILES["studentCsv"]["tmp_name"]));
					for($ctr=0;$ctr<sizeOf($csvAsArray);$ctr++) {
						$csvAsArray[$ctr][0] = json_encode($csvAsArray[$ctr][0]);
						$studentNumber = str_replace("\ufeff", "", $csvAsArray[$ctr][0]);
						$studentNumber = json_decode($studentNumber);
						$this->mdl_student->insertStudent($studentNumber, $csvAsArray[$ctr][2], $csvAsArray[$ctr][3], $csvAsArray[$ctr][1], null, null); 
					}
				} else if($_FILES["studentCsv"]["type"]=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || $_FILES["studentCsv"]["type"]=="application/vnd.ms-excel") {
					$this->load->library("excelreader");
					$cells = $this->excelreader->readExcel($_FILES["studentCsv"]["tmp_name"]);
					for($ctr=0;$ctr<sizeOf($cells);$ctr++) {
						$this->mdl_student->insertStudent($cells[$ctr][0], $cells[$ctr][2], $cells[$ctr][3], $cells[$ctr][1], null, null); 
					}
				} else {
					die("Not an Excel");
				}
				
			} else {
				$studno = $this->input->post("StudentNo");
				$firstname = $this->input->post("firstname");
				$middlename = $this->input->post("middlename");
				$lastname = $this->input->post("lastname");
				$section = $this->input->post("section")=="" ? null : $this->input->post("section");
				$last_id = $this->mdl_student->insertStudent($studno, $firstname, $middlename, $lastname, "", $section);
				if($_FILES["image"]["tmp_name"]!="") {
					$config["upload_path"] = $_SERVER['DOCUMENT_ROOT']."/ams/assets/student_pictures/";
					$config["allowed_types"] = "jpg|jpeg|png";
					$config["file_name"] = $last_id;
					$config["max_size"] = 0;
					$config["max_filename"] = 0;
					$this->load->library("upload", $config);
					if(!$this->upload->do_upload('image')) 
						die($this->upload->display_errors());
					else {
						$data["upload_data"] = $this->upload->data();
						$this->mdl_student->updateImagePath($last_id, $data["upload_data"]["file_name"]);
					}
				}
			}
			redirect(base_url("student#".$last_id));
		}

		function updateProfile() {
			$studid = $this->input->post("studentid");
			$studno = $this->input->post("studentnumber");
			$firstname = $this->input->post("firstname");
			$middlename = $this->input->post("middlename");
			$lastname = $this->input->post("lastname");
			$section = $this->input->post("section")=="" ? null : $this->input->post("section");
			$this->mdl_student->updateStudent($studid, $studno, $firstname, $middlename, $lastname, $section);
			if($_FILES["image"]["tmp_name"]) {
				 $config["upload_path"] = $_SERVER["DOCUMENT_ROOT"]."/ams/assets/student_pictures/";
				$config["allowed_types"] = "jpg|jpeg|png";
				$config["file_name"] = $studid;
				$config["max_size"] = 0;
				$config["max_filename"] = 0;
				$config["overwrite"] = true; 
				$this->load->library("upload", $config);
				if(!$this->upload->do_upload("image")) 
					die($this->upload->display_errors());
			}
			redirect(base_url("student")."#".$studid);
		}

		function deleteStudent() {
			$studid = $this->input->post("studentid");
			$this->mdl_student->deleteStudent($studid);
			redirect(base_url("student"));
		}

		function ajaxStudentInfo() {
			$studentid = $this->input->post("studentid");
			$infos = $this->mdl_student->getStudentInfo($studentid);
			$infoArray = array();
			foreach($infos->result() as $info) {
				$infoArray["StudId"] = $info->Student_No;
				$infoArray["Firstname"] = $info->Firstname;
				$infoArray["Middlename"] = $info->Middlename;
				$infoArray["Lastname"] = $info->Lastname;
				$infoArray["image"] = $info->Image_Path;
				$infoArray["section"] = $info->Section_Name;
			}
			echo json_encode($infoArray);
		}

	}


?>