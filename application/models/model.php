<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model extends CI_model {
	public function GetDatamhs($npm=null){
		if(isset($npm)){
			$data=$this->db->query("select * from datamhs WHERE npm='{$npm}'");
		}else{
				$data=$this->db->query('select * from datamhs');
		}
		return $data->result_Array();
		}
		
		public function GetdatamhsbyToken($token=null){
			if(isset($token)){
				$data=$this->db->query("select * from datamhs WHERE token='{$token}'");
			}
			return $data->result_Array();
			}

		public function InsertData($tabelName,$data){
			$res=$this->db->insert($tabelName,$data);
			return $res;
		}

		public function GetDatamhs2($npm=nul){
			if($npm!=null){
				$data=$this->db->query("select * from data WHERE npm='{$npm}'");
			}else{
					$data=$this->db->query('select * from data');
			}
			return $data->result_Array();
			}

		function some_model_function() {
	  $this->db->from('datamhs');
	  return $num_rows = $this->db->count_all_results();
	}

		public function UpdateData($tabelName,$where,$data){
			$res=$this->db->update($tabelName,$data,$where);
			return $res;
		}
		public function DeleteData($tabelName,$where){
			$res=$this->db->delete($tabelName,$where);
			return $res;
		}

		function upload($data){
        $result= $this->db->insert('datamhs',$data);
        return $result;
    }

	}
