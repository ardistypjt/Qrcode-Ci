<?php
class Qr extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('model'); //pemanggilan model mahasiswa
	}

	function gen($npm=null){
		if(isset($npm)){
			$hasil=$this->model->GetDatamhs($npm);
			//echo json_encode($hasil);
			$host="http://a0d85fb9.ngrok.io";
			require_once("vendor/phpqrcode/qrlib.php");
			QRcode::png($host."/coba/ci/index.php/qr/detail/".$hasil[0]['token']);
		}
	}

	function detail($token){
		$mhs=$this->model->GetdatamhsbyToken($token);
		$data=array(
			"npm" => $mhs[0]['npm'],
			"namamhs" => $mhs[0]['namamhs'],
			"jeniskelamin" => $mhs[0]['jeniskelamin'],
			"alamatmhs" => $mhs[0]['alamatmhs']);
		$this->load->view('form_edit',$data);
	}
}
