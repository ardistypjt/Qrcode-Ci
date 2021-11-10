<?php
    if (! defined('BASEPATH')) exit ('No direct script access allowed');

class Tf extends CI_Model{
    public function __construct()
  	{
  		parent::__construct();
  		// $this->load->database();
  	}
    public function get($usernametf,$pass){
        $this->db->where('usernametf','pass', $pass, $usernametf); // Untuk menambahkan Where Clause : username='$username'
        $result = $this->db->get('datamhs')->row(); // Untuk mengeksekusi dan mengambil data hasil query
        return $result;
    }

    function tf(){
    $datax=$this->db->query('select * from datamhs');
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
