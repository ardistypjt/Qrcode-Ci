<?php

class Adm extends CI_Controller{

	function __construct(){
		parent::__construct();

		if($this->session->userdata('status') != "login"){
			redirect(base_url("Auth"));
		}
	}

	// function logged_id()
  //   {
  //       return $this->session->userdata('status') != "login");
  //   }

	function index(){
		$this->load->view('loginadmin');
	}
}
