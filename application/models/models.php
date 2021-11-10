<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Models extends CI_model {
  function __construct(){
		parent::__construct();
		$this->load->model('models'); //pemanggilan models mahasiswa
	}
	public function Getsifo($npms=null){
		if(isset($npms)){
			$data=$this->db->query("select * from sifo WHERE npms='{$npms}'");
		}else{
				$data=$this->db->query('select * from sifo');
		}
		return $data->result_Array();
		}
		
		public function Getsifobytokens($tokens=null){
			if(isset($tokens)){
				$data=$this->db->query("select * from sifo WHERE tokens='{$tokens}'");
			}
			return $data->result_Array();
			}

		public function InsertData($tabelName,$data){
			$res=$this->db->insert($tabelName,$data);
			return $res;
		}

		// function cek_login($tabelName,$where){
		// 	$res=$this->db->get_where($tabelName,$where);
		// 	return $res;
		// 	}
		/*public function detail($npms)
	{
		$this->db->select('*');
		$this->db->from('sifo');
		$this->db->where('npms',$npms);
		$query=$this->db->get();
		return $query->row();
	}
		public function update($npms)
	{
		$this->db->where('npms',$data['npms']);
		$this->db->update('sifo',$data);
	}*/
		public function UpdateData($tabelName,$where,$data){
			$res=$this->db->update($tabelName,$data,$where);
			return $res;
		}
		public function DeleteData($tabelName,$where){
			$res=$this->db->delete($tabelName,$where);
			return $res;
		}
	}
