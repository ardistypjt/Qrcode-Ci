<?php

class Mhs extends CI_Controller {
  function __construct(){
		parent::__construct();
	
	}

  function detailtf($npm=null){
		require_once("vendor/phpqrcode/qrlib.php");
		$filename=$_SERVER["DOCUMENT_ROOT"]."/coba/ci/vendor/img/".$this->RandomString(5).".png";
		$this->load->library('dompdf_gen');
		$mhs = $this->model->Getdatamhs($npm);
		QRcode::png("http://a0d85fb9.ngrok.io/coba/ci/index.php/qr/detail/".$mhs[0]['token'],$filename);
		$data=array(
			"npm" => $mhs[0]['npm'],
			"namamhs" => $mhs[0]['namamhs'],
			"jeniskelamin" => $mhs[0]['jeniskelamin'],
			"alamatmhs" => $mhs[0]['alamatmhs'],
			"imgurl"=>$filename);
			//echo json_encode($data);
		$this->load->view('tabeltf',$data);
	}

  function detailsf($npms=null){
		require_once("vendor/phpqrcode/qrlib.php");
		$filename=$_SERVER["DOCUMENT_ROOT"]."/coba/ci/vendor/img/".$this->RandomString(5).".png";
		$this->load->library('dompdf_gen');
		$mhs = $this->models->Getsifo($npms);
		QRcode::png("http://a0d85fb9.ngrok.io/coba/ci/index.php/qr/detail/".$mhs[0]['token'],$filename);
		$data=array(
			"npms" => $mhs[0]['npms'],
			"namas" => $mhs[0]['namas'],
			"jenisk" => $mhs[0]['jenisk'],
			"alamats" => $mhs[0]['alamats'],
			"imgurl"=>$filename);
			//echo json_encode($data);
		$this->load->view('tabelsf',$data);
	}

 public function edittf($npm){
	 if(isset($npm)){
	 	$mhs=$this->model->Getdatamhs($npm);
	 	$data=array(
	 		"npm" => $mhs[0]['npm'],
	 		"namamhs" => $mhs[0]['namamhs'],
	 		"jeniskelamin" => $mhs[0]['jeniskelamin'],
	 		"alamatmhs" => $mhs[0]['alamatmhs']);
	 	$this->load->view('edittf',$data);
	 }else{
	 	$data=array(
	 		"npm" => $this->input->post('npm'),
	 		"namamhs" => $this->input->post('namamhs'),
	 		"jeniskelamin" =>$this->input->post('jeniskelamin'),
	 		"alamatmhs" => $this->input->post('alamatmhs'));
	 		$res=$this->model->UpdateData('datamhs','npm='.$this->input->post('npm'),$data);
	 		echo json_encode($data);
	 		echo json_encode($res);
		}
	redirect ('index.php/mhs/detailtf');
	}

  public function inserttf(){
    $npm = $_POST['npm'];
    $namamhs = $_POST['namamhs'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $alamatmhs = $_POST['alamatmhs'];

    $token=$this->RandomString();
    echo $token;
    $data_insert = array(
    'npm' => $npm,
    'namamhs' => $namamhs,
    'jeniskelamin' => $jeniskelamin,
    'alamatmhs' => $alamatmhs,
    'token'=> $token,
    // 'foto' => $foto
    );
    $res = $this->model->InsertData('datamhs',$data_insert);
    if($res>=1){
      redirect('index.php/mhs/detailtf');
    }else{
      echo "<h2>Insert Data Gagal</h2>";
    }
  }

  public function insertsf(){
		$npm = $_POST['npms'];
		$namamhs = $_POST['namas'];
		$jeniskelamin = $_POST['jenisk'];
		$alamatmhs = $_POST['alamats'];

		$token=$this->RandomString();
		echo $token;
		$data_insert = array(
		'npm' => $npms,
		'namamhs' => $namas,
		'jeniskelamin' => $jenisk,
		'alamatmhs' => $alamats,
		'token'=> $token,
		// 'foto' => $foto
		);
		$res = $this->models->InsertData('sifo',$data_insert);
		if($res>=1){
			redirect('index.php/crud/log');
		}else{
			echo "<h2>Insert Data Gagal</h2>";
		}
	}
}
