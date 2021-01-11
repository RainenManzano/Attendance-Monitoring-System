<?php

	class Register extends CI_Controller {

		function __construct() {
			parent::__construct();
			$this->load->model("mdl_users");
		}

		function index() {
			if($_POST) {
				$this->form_validation->set_rules("firstname", "Firstname", "required");
				$this->form_validation->set_rules("middlename", "Middlename", "required");
				$this->form_validation->set_rules("lastname", "Lastname", "required");
				$this->form_validation->set_rules("birthdate", "Birthday", "required");
				$this->form_validation->set_rules("username", "Username", "required");
				$this->form_validation->set_rules("password", "Password", "required");
				if($this->form_validation->run() == false) {
					$this->load->view("view_register");
				} else {
					$this->Validation_Successful();
				}
			} else {
				$this->load->view("view_register");
			}
		}

		function Validation_Successful() {
			$data = array(
				"firstname" => $this->input->post("firstname"),
				"middlename" => $this->input->post("middlename"),
				"lastname" => $this->input->post("lastname"),
				"birthdate" => $this->input->post("birthdate"),
				"username" => $this->input->post("username"),
				"password" => $this->input->post("password"),
				"level" => 0, 
				"Status" => "Active"
			);
			$this->mdl_users->Insert_User($data);
			redirect(base_url());
		}

		function checkDuplications() {
			$firstname = $this->input->post("firstname");
			$lastname = $this->input->post("lastname");
			$birthdate = $this->input->post("birthdate");
			$response = $this->mdl_users->validateUser($firstname, $lastname, $birthdate);
			echo json_encode($response);
		}

	}