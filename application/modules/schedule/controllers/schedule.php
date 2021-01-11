<?php 

	class Schedule extends CI_Controller {

		public $currentUser;

		function __construct() {
			parent::__construct();
			$this->currentUser = $this->session->userdata("currentuser");
			$this->load->model("mdl_schedule");
			SessionExist();
			// PrintArray($this->currentUser);
		}

		///////////////////////// PAGES ////////////////////////////////////////

		function index() {
			$dataTemplate["level"] = $this->currentUser["level"];
			if(isAdmin($this->currentUser["level"])) 
				$data["schedules"] = $this->mdl_schedule->getSchedules();
			else
				$data["schedules"] = $this->mdl_schedule->getMySchedules($this->currentUser["UserId"]);
			// PrintArray($data["sections"]);
			$this->load->view("template/nav-side", $dataTemplate);
			$this->load->view("schedule-main-view", $data);
		}


		
 
	}