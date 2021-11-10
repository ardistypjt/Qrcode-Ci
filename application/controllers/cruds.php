<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cruds extends CI_Controller {
  function __construct(){
		parent::__construct();
		$this->load->model('models'); //pemanggilan models mahasiswa
	}
	public function index(){
		$data=$this->models->Getsifo();
    $this->load->view('tabelsifo',array('data'=>$data));
	}

	public function add_data(){
		$this->load->view('formadds');
	}
	function RandomString($length = 20) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
}
	public function do_insert(){
		$npms = $_POST['npms'];
		$namas = $_POST['namas'];
		$jenisk = $_POST['jenisk'];
		$alamats = $_POST['alamats'];
		$tokens=$this->RandomString();
		echo $tokens;
		$data_insert = array(
		'npms' => $npms,
		'namas' => $namas,
		'jenisk' => $jenisk,
		'alamats' => $alamats,
		);
		$res = $this->models->InsertData('sifo',$data_insert);
		if($res>=1){
			redirect('index.php/cruds/index');
		}else{
			echo "<h2>Insert Data Gagal</h2>";
		}
	}

	public function edit_data($npms=null){
		if(isset($npms)){
			$mhs=$this->models->Getsifo($npms);
			$data=array(
				"npms" => $mhs[0]['npms'],
				"namas" => $mhs[0]['namas'],
				"jenisk" => $mhs[0]['jenisk'],
				"alamats" => $mhs[0]['alamats']);
			$this->load->view('formedits',$data);
		}else{
			$data=array(
				"npms" => $this->input->post('npms'),
				"namas" => $this->input->post('namas'),
				"jenisk" =>$this->input->post('jenisk'),
				"alamats" => $this->input->post('alamats'));
				$res=$this->models->UpdateData('sifo','npms='.$this->input->post('npms'),$data);
				echo json_encode($data);
				echo json_encode($res);
		}
	}

	public function do_delete($npms){
		$where = array('npms' => $npms);
		$res = $this->models->DeleteData('sifo',$where);
		if($res>=1){
			redirect('index.php/cruds/index');
		}else{
			echo "<h2>Delete Data Gagal</h2>";
		}
	}

	public function pdf($npms){
		require_once("vendor/phpqrcode/qrlib.php");
		$filename=$_SERVER["DOCUMENT_ROOT"]."/coba/ci/vendor/img/".$this->RandomString(5).".png";
		$this->load->library('dompdf_gen');
		$mhs = $this->models->Getsifo($npms);
		QRcode::png("http://a0d85fb9.ngrok.io/coba/ci/index.php/qr/detail/".$mhs[0]['tokens'],$filename);
		$data=array(
			"npms" => $mhs[0]['npms'],
			"namas" => $mhs[0]['namas'],
			"jenisk" => $mhs[0]['jenisk'],
			"alamats" => $mhs[0]['alamats'],
			"imgurl"=>$filename);
			//echo json_encode($data);
		$this->load->view('printpdfs',$data);

		$paper_size = 'A4';
		$orientation = 'landscape';
		$html = $this->output->get_output();
		//echo json_encode($html);
		$this->dompdf->set_paper($paper_size, $orientation);
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream("data_mahasiswa.pdf", array('attachment' =>0));
		// //return $this->dompdf->output();
		$this->dompdf_gen->generate($html);
	}

  public function editsf($npms=null){
    if(isset($npms)){
      $mhs=$this->models->Getsifo($npms);
      $data=array(
        "npms" => $mhs[0]['npms'],
        "namas" => $mhs[0]['namas'],
        "jenisk" => $mhs[0]['jenisk'],
        "alamats" => $mhs[0]['alamats'],
        "tgllahir" => $mhs[0]['tgllahir'],
        "about" => $mhs[0]['about'],
        "username" => $mhs[0]['username'],
        "foto" => $mhs[0]['foto']
      );
      $this->load->view('editsf',$data);
    }else{
      $config['upload_path']         = 'assets/images/';  // folder upload
      $config['allowed_types']        = 'gif|jpg|png'; // jenis file
      $config['max_size']             = 30000;
      $config['max_width']            = 10241;
      $config['max_height']           = 76800;

      $this->load->library('upload', $config);
      $this->upload->do_upload('gambar'); //sesuai dengan name pada form
            //tampung data dari form
      $file = $this->upload->data();
      $foto = $file['file_name'];
      $data=array(
        "npms" => $this->input->post('npms'),
        "namas" => $this->input->post('namas'),
        "jenisk" =>$this->input->post('jenisk'),
        "alamats" => $this->input->post('alamats'),
        "tgllahir" => $this->input->post('tgllahir'),
        "about" => $this->input->post('about'),
        "foto" => $foto
      );
        $res=$this->models->UpdateData('sifo','npms='.$this->input->post('npms'),$data);
        redirect('index.php/cruds/detailsf/'.$this->input->post('npms'));
    }
  }

  function detailsf($npms=null){
    require_once("vendor/phpqrcode/qrlib.php");
    $filename=$_SERVER["DOCUMENT_ROOT"]."/coba/ci/vendor/img/".$this->RandomString(5).".png";
    $this->load->library('dompdf_gen');
    $mhs = $this->models->Getsifo($npms);
    QRcode::png("http://a0d85fb9.ngrok.io/coba/ci/index.php/qrs/detail/".$mhs[0]['tokens'],$filename);
    $data=array(
      "npms" => $mhs[0]['npms'],
      "namas" => $mhs[0]['namas'],
      "jenisk" => $mhs[0]['jenisk'],
      "alamats" => $mhs[0]['alamats'],
      "username" => $mhs[0]['username'],
      "foto" => $mhs[0]['foto'],
      "imgurl"=>$filename);
    $this->load->view('tabelsf',$data);
  }
}
