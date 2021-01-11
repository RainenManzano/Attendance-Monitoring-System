<?php 

	class Users extends CI_Controller {

		public $currentuser;

		function __construct() {
			parent::__construct();
			$this->load->model('mdl_users');
			SessionExist();	
			$this->currentuser = $this->session->userdata("currentuser");
			if(!isAdmin($this->currentuser["level"]))
				redirect(base_url("auth/LoggingOut"));
		}

		function index() {
			$dataTemplate["level"] = $this->currentuser["level"];
			$data["users"] = $this->mdl_users->getAllUsers();
			$this->load->view('template/nav-side', $dataTemplate);	
			$this->load->view("view-users", $data);
		}

		function createUser() {
			$data = array (
				"firstname" => $this->input->post("firstname"),
				"middlename" => $this->input->post("middlename"),
				"lastname" => $this->input->post("lastname"),
				"birthdate" => $this->input->post("birthdate"),
				"username" => $this->input->post("username"),
				"password" => $this->input->post("password"),
				"level" => $this->input->post("level")
			);
			$this->mdl_users->insertUser($data);
			redirect(base_url('users'));
		}

		function getUser() {
			$userId = $this->input->post("id");
			$userInfo = $this->mdl_users->getUser($userId);
			foreach($userInfo->result() as $user) {
				$users = array(
					"firstname"=>$user->Firstname,
					"middlename"=>$user->Middlename,
					"lastname"=>$user->Lastname,
					"birth"=>$user->Birthdate,
					"username"=>$user->Username,
					"password"=>$user->Pw,
					"level"=>$user->Level,
					"status"=>$user->Status,
				);
			}
			echo json_encode($users);
		}

		function editUser() {
			$userid = $this->input->post("userid");
			$userInfo = array(
				"firstname" => $this->input->post("firstname"),
				"middlename" => $this->input->post("middlename"),
				"lastname" => $this->input->post("lastname"),
				"birthdate" => $this->input->post("birthdate"),
				"username" => $this->input->post("username"),
				"password" => $this->input->post("password"),
				"level" => $this->input->post("level"),
				"status" => $this->input->post("status"),
				"userid" => $userid
			);
			$this->mdl_users->editUser($userInfo);
			redirect(base_url('users'));
		}

		function deleteUser() {
			$userId = $this->input->post("userid");
			$this->mdl_users->deleteUser($userId);
			redirect(base_url('users'));
		}

	}