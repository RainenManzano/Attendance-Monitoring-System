<?php 

	class Classes extends CI_Controller {

		public $currentuser;

		function __construct() {
			parent::__construct();
			$this->load->model("mdl_class");
			//For Authentication
			SessionExist();	
			$this->currentuser = $this->session->userdata("currentuser");
		}

		////////////////// PAGES //////////////////////
		function index() {
			$dataTemplate["level"] = $this->currentuser["level"];
			$data["sections"] = $this->mdl_class->getAllSections();
			if(isAdmin($this->currentuser["level"])) {
				$data["teachers"] = $this->mdl_class->Get_Teachers();
				$data["class"] = $this->mdl_class->getAllClass();
			} else {
				$data["class"] = $this->mdl_class->getTeacherClasses($this->currentuser["UserId"]);
			}
			
			$this->load->view('template/nav-side', $dataTemplate);	
			$this->load->view('view-class-list', $data);
		}

		function Class_Attendance() {
			$class_id = $this->input->post("class_id");
			$data["class_id"] = $class_id;
			$data["schedule"] = $this->mdl_class->GetClassSchedule($class_id);
			$this->load->view("template/attendance-nav");
			$this->load->view("class-student-standing", $data);
		}


		////////////////// ACTIONS /////////////////////

		function Create_Class() {
			$subject_code = $this->input->post("subject_code");
			$subject_name = $this->input->post("subject_name");
			$subject_desc = $this->input->post("subject_desc");
			$units = $this->input->post("units");
			$section_id = $this->input->post("section_id");
			$user_id = $this->input->post("teacher") ? $this->input->post("teacher") : $this->currentuser["UserId"];
			$day = $this->input->post("day");
			$time = $this->input->post("time");
			$class_id = $this->mdl_class->Insert_Class($subject_code, $subject_name, $subject_desc, $units, $section_id, $user_id);
			$sched_day = $this->input->post("day");
			$sched_time_begin = $this->input->post("time_begin");
			$sched_time_end = $this->input->post("time_end");
			$this->mdl_class->Insert_Schedule($class_id, $sched_day, $sched_time_begin, $sched_time_end);
			redirect(base_url('classes'));
		}

		function Remove_Class() {
			$class_id = $this->input->post("delete_id");
			$this->mdl_class->Delete_Class($class_id);
			redirect(base_url('classes'));
		}

		function Deactivate_Class() {
			$class_id = $this->input->post("delete_id");
			$this->mdl_class->Deactivate_Class($class_id);
			redirect(base_url('classes'));
		}


		////////////////AJAX CALLS //////////////////////////

		function ajaxGetClassInfo() {
			$classid = $this->input->post("classid");
			$classinfo = array();
			$class_schedule = array();
			$ctr = 0;
			$classdb = $this->mdl_class->getClassInfo($classid);
			if(isAdmin($this->currentuser["level"])) {
				foreach ($classdb->result() as $class) {
					$classinfo["id"] = $class->Id;
					$classinfo["subjectCode"] = $class->Subject_Code;
					$classinfo["subjectName"] = $class->Subject;
					$classinfo["subjectDesc"] = $class->Subject_Description;
					$classinfo["units"] = $class->Units;
					$classinfo["sectionId"] = $class->Section_Id;
					$classinfo["sectionName"] = $class->Section_Name;
					$classinfo["sectionDesc"] = $class->Section_Desc;
					$classinfo["instructor"] = $class->Lastname.", ".$class->Firstname. " ".substr($class->Middlename,0,1);
					$classinfo["instructorId"] = $class->User_Id;
				}
			} else {
				foreach ($classdb->result() as $class) {
					$classinfo["id"] = $class->Id;
					$classinfo["subjectCode"] = $class->Subject_Code;
					$classinfo["subjectName"] = $class->Subject;
					$classinfo["subjectDesc"] = $class->Subject_Description;
					$classinfo["units"] = $class->Units;
					$classinfo["sectionId"] = $class->Section_Id;
					$classinfo["sectionName"] = $class->Section_Name;
					$classinfo["sectionDesc"] = $class->Section_Desc;
				}
			}
			$schedules = $this->mdl_class->GetClassSchedule($classid);
			foreach($schedules->result() as $schedule) {
				$class_schedule["day"][$ctr] = $schedule->Day;
				$class_schedule["beginTime"][$ctr] = $schedule->Beginning_Time;
				$class_schedule["endTime"][$ctr] = $schedule->End_Time;
				$ctr++;
			}
			$classinfo["schedule"] = $class_schedule;
			echo json_encode($classinfo);
		}

		function Get_Students_Attendance() {
			$attendance = array();
			$class_id = $this->input->post("class_id");
			$from = $this->input->post("from");
			$to = $this->input->post("to");
			$ctr = 0;
			$id = 0;

			$schedule = $this->mdl_class->GetClassSchedule($class_id);
			foreach($schedule->result() as $schedule) {
				$attendance["schedule"][$ctr]["Day"] = $schedule->Day;
				$attendance["schedule"][$ctr]["Beginning_Time"] = $schedule->Beginning_Time;
				$attendance["schedule"][$ctr]["End_Time"] = $schedule->End_Time;
				$ctr++;
			}
			$dates = $this->mdl_class->Get_Dates($class_id, $from, $to);
			foreach($dates->result() as $date) {
				$attendance["dates"][] = $date->Datein;
			}
			$students = $this->mdl_class->Get_Students_By_Class($class_id);
			foreach($students->result() as $student) {
				$attendance["student"][$student->Id]["studentNum"] = $student->Student_No;
				$attendance["student"][$student->Id]["name"] = $student->Lastname.", ".$student->Firstname." ".substr($student->Middlename, 0, 1);
			}
			$ctr = 0;
			$students_attendance = $this->mdl_class->Get_Students_Attendance($class_id, $from, $to);
			foreach($students_attendance->result() as $student_attendance) {
				if($id!=$student_attendance->Student_Id) {
					$ctr = 0;
				}
				$attendance["attendance"][$student_attendance->Student_Id]["datein"][$ctr] = $student_attendance->Datein;
				$attendance["attendance"][$student_attendance->Student_Id]["timein"][$ctr] = $student_attendance->Timein;
				$id = $student_attendance->Student_Id;
				$ctr++;
			}
			echo json_encode($attendance);
		}

	}