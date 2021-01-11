<?php 

	class Section extends CI_Controller {

		public $currentUser;

		function __construct() {
			parent::__construct();
			$this->currentUser = $this->session->userdata("currentuser");
			$this->load->model("mdl_section");
			SessionExist();
			// PrintArray($this->currentUser);
		}

		///////////////////////// PAGES ////////////////////////////////////////

		function index() {
			$dataTemplate["level"] = $this->currentUser["level"];
			if(isAdmin($this->currentUser["level"])) 
				$data["sections"] = $this->mdl_section->getSections();
			else
				$data["sections"] = $this->mdl_section->getMySections($this->currentUser["UserId"]);
			// PrintArray($data["sections"]);
			$this->load->view("template/nav-side", $dataTemplate);
			$this->load->view("view_section", $data);
		}

		function editSectionPage() {
			$dataTemplate["level"] = $this->currentUser["level"];
			$this->load->view("template/nav-side", $dataTemplate);

			$sectionid = $this->input->post("editSectionId");
			$section = $this->mdl_section->getSectionInfo($sectionid);

			foreach($section->result() as $info) {
				$data["sectionid"] = $info->Section_Id;
				$data["sectionname"] = $info->Section_Name;
				$data["sectiondesc"] = $info->Section_Desc;
 			}
			$data["students"] = $this->mdl_section->getBlockStudents($sectionid);
			$this->load->view("editSection", $data);
		}

		function updateSection() {
			$ctr = 0;
			$ctr1 = 0;
			$currentId = array();
			$id = 0;
			//UPDATE SECTION
			$sectionid = $this->input->post("sectionid");
			$sectionname = $this->input->post("sectionname");
			$sectiondesc = $this->input->post("sectiondesc");
			$this->mdl_section->updateSection($sectionid, $sectionname, $sectiondesc);

			//UPDATE STUDENT WITH VALUE
			$newStudentId = $this->input->post("newStudentId");
			$this->mdl_section->updateStudentSection($sectionid, $newStudentId);

			//UPDATE STUDENT WITH A NULL VALUE
			$oldStudentId = $this->input->post("oldStudentsId");
			for($ctr=0;$ctr<sizeOf($oldStudentId);$ctr++) {
				for($ctr1=0;$ctr1<sizeOf($newStudentId); $ctr1++) {
					if($oldStudentId[$ctr]!=$newStudentId[$ctr1]) 
						$id = $oldStudentId[$ctr];
					else {
						$id = 0;
						break;
					}
				}
				if($id!=0)
					$currentId[] = $id;
			}
			$this->mdl_section->updateStudentSection(null, $currentId);

			redirect(base_url("section"));
		}


		function createSection() {
			$sectionName = $this->input->post("name");
			$sectionDesc = $this->input->post("description");
			$last_id = $this->mdl_section->insertSection($sectionName, $sectionDesc);
			if(isset($_POST["student"])) {
				$students = $_POST["student"];
				$this->mdl_section->updateStudentSection($last_id, $students);
			}
			redirect(base_url("section"));
		}

		function deleteSection() {
			$sectionId = $this->input->post("sectionid");
			$this->mdl_section->deleteSection($sectionId);
			redirect(base_url("section"));
		}

		////////////////////// AJAX CALLS ////////////////////
		function getSectionInfo() {
			$ctr = 0;
			$sectionInfo = array();
			$sectionid = $this->input->post("sectionid");
			$result = $this->mdl_section->getSectionInfo($sectionid);
			foreach($result->result() as $res) {
				$sectionInfo[$ctr]["sectionId"] = $res->Section_Id;
				$sectionInfo[$ctr]["sectionName"] = $res->Section_Name;
				$sectionInfo[$ctr]["sectionDesc"] = $res->Section_Desc;
				$sectionInfo[$ctr]["studentNo"] = $res->Student_No;
				$sectionInfo[$ctr]["studentId"] = $res->Id;
				$sectionInfo[$ctr]["name"] = $res->Lastname. ", ".$res->Firstname." ".substr($res->Middlename, 0, 1).".";
				$ctr++;
			}
			echo json_encode($sectionInfo);
		}

		function getStudents() {
			$students = $this->mdl_section->getStudentsWithoutSection();
			echo json_encode($students->result());
		}
 
	}