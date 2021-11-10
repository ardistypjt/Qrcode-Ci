<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datamhs extends CI_Controller {
	public function index()
	{
		$data=$this->model->Getdatamhs();
		$this->load->view('tabel',array('data'=>$data));
	}
	public function insert(){
		$res=$this->model->InsertData('datamhs', array(
		"npm" => "1634010066",
		"namamhs" => "Ardisty Palvelus Jumala",
		"jeniskelamin" => "perempuan",
		"alamatmhs" => "royal park 2 block D2 kutisari selatan surabaya",
		));
		
		if($res >= 1){
			echo "<h2>Insert Data Sukses</h2>";
		}else{
			echo "<h2>Insert Data Gagal</h2>";
		}
	}
	public function update(){
		$res=$this->model->UpdateData('datamhs', array(
		"alamatmhs" => "rahasia lo",
		),array('npm' => "1634010066"));
		
		if($res >= 1){
			echo "<h2>Update Data Sukses</h2>";
		}else{
			echo "<h2>Update Data Gagal</h2>";
		}
	}
	public function delete(){
		$res=$this->model->DeleteData('datamhs',array('npm' => "0"));
		
		if($res >= 1){
			echo "<h2>Delete Data Sukses</h2>";
		}else{
			echo "<h2>Delete Data Gagal</h2>";
		}
	}
	public function panggil(){
		$data = $this->db->query('select * from datamhs');
		/*echo "<pre>";
		print_r($data);
		echo "</pre>";*/
		echo "Jumlah Data= ".$data->num_rows()."<br />";
		foreach ($data->result() as $row){
			echo "NPM	:".$row->npm."<br />";
			echo "Nama	:".$row->namamhs."<br />";
			echo "Jenis Kelamin	:".$row->jeniskelamin."<br />";
			echo "Alamat	:".$row->alamatmhs."<br />";
			echo "<hr />";
		}
	}
}