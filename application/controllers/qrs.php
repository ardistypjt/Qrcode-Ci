<?php
class Qrs extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('models'); //pemanggilan models mahasiswa
	}

	function gen($npms=null){
		if(isset($npms)){
			$hasil=$this->models->Getsifo($npms);
			//echo json_encode($hasil);
			$host="http://a0d85fb9.ngrok.io";
			require_once("vendor/phpqrcode/qrlib.php");
			QRcode::png($host."/coba/ci/index.php/qr/detail/".$hasil[0]['tokens']);
		}
	}

	function detail($tokens){
		$mhs=$this->models->Getsifobytokens($tokens);
		$data=array(
			"npms" => $mhs[0]['npms'],
			"namas" => $mhs[0]['namas'],
			"jenisk" => $mhs[0]['jenisk'],
			"alamats" => $mhs[0]['alamats']);
		$this->load->view('form_edit',$data);
	}
}
