<?php

	class attendance extends CI_Controller {
		function __construct() {
			parent::__construct();
			$this->load->model("mdl_attendance");
		}

		function index() {
			die("Not allowed");
		}

		function Barcode_Scanner() {
			$this->load->view("template/attendance-nav.php");
			$this->load->view("bar-code");
		}

		function Get_Info_Student() {
			date_default_timezone_set('Asia/Manila');
			$ymd = date("Y-m-d");
			$hms = date("H:i:s");
			$class_id = $this->input->post("class_id");
			$student_number = $this->input->post("id");
			$student_info = array();
			$student_id = "";

			$studentExist = $this->mdl_attendance->Student_Exist($class_id, $student_number);
			foreach($studentExist->result() as $rowId) {
				$student_id = $rowId->Id;
			}
			if($student_id!=null) {
				$does_exist = $this->mdl_attendance->AttendanceExist($student_number, $class_id);
				if($does_exist) {
					$result = $this->mdl_attendance->GetInfoByStudentNumber($student_id);
					$student_info = $this->Student_Result($result);
				} else if(!$does_exist) {
					$this->mdl_attendance->InsertAttendance($class_id, $student_id, $ymd, $hms);
					$result = $this->mdl_attendance->GetInfoByStudentNumber($student_id);
					$student_info = $this->Student_Result($result);
				}
			}
			else {
				$student_info["status"] = "none";
			}
			echo json_encode($student_info);	
		}

		function Student_Result($result) {
			$student_info = array();
			foreach($result->result() as $student) {
				$student_info["studentNum"] = $student->Student_No;
				$student_info["name"] = $student->Lastname.", ".$student->Firstname." ".substr($student->Middlename,0,1);
				$student_info["imagePath"] = $student->Image_Path;
				$student_info["sectionName"] = $student->Section_Name;
				$student_info["sectionDesc"] = $student->Section_Desc;
				$student_info["Timein"] = $student->Timein;
				$student_info["status"] = "success";
			}
			return $student_info;
		}


	}