<?php

	class Auth extends CI_Controller {
		function __construct() {
			parent::__construct();
			$this->load->model("mdl_authentication");
		}

		function index() {
			if($_POST) {
				$this->form_validation->set_rules("username", "Username", "required");
				$this->form_validation->set_rules("password", "Password", "required");
				if($this->form_validation->run()==false) {
					$this->load->view("view-login");
				} else {
					$this->UserExists();
				}
			} else {
				$this->load->view("view-login");
			}
		}

		private function UserExists() {
			$data = array(
				"username" => $this->input->post("username"),
				"password" => $this->input->post("password")
			);
			$user = $this->mdl_authentication->getUser($data)->row();
			if(isset($user)) {
				$LoggedInUser = array(
					"UserId" => $user->User_ID,
					"firstname" => $user->Firstname,
					"middlename" => $user->Middlename,
					"lastname" => $user->Lastname,
					"username" => $user->Username,
					"level" => $user->Level
				);
				$this->session->set_userdata("currentuser", $LoggedInUser);
				redirect(base_url('classes'));
			} else {
				$data["error_msg"] = "Invalid username or Password";
				$this->load->view("view-login", $data);
			}
		}

		function LoggingOut() {
			logout();
		}


	}