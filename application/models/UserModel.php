<?php
    if (! defined('BASEPATH')) exit ('No direct script access allowed');

class UserModel extends CI_Model{
    public function __construct()
  	{
  		parent::__construct();
  		// $this->load->database();
  	}

    function adminn(){
    $datax=$this->db->query('select * from admin');
      return $datax->result_Array();
    }

  	function cek_login($table,$wherex){
  		return $this->db->get_where($table,$wherex);
      }

      public function registadm($table,$datax){
        return $this->db->Insert($table,$datax);
      }
    }
?>
