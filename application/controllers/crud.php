<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class crud extends CI_Controller {
  function __construct(){
		parent::__construct();
		$this->load->model('model'); //pemanggilan model mahasiswa
	}
	public function index(){
		$this->load->view('login');
	}

  public function log(){
    $data=$this->model->Getdatamhs();
    $this->load->view('tabeladmin',array('data'=>$data));
  }

	public function add_data(){
		$this->load->view('form_add');
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
   		'token' => $token=$this->RandomString()
		);
		$res = $this->model->InsertData('datamhs',$data_insert);
		if($res>=1){
			redirect('index.php/crud/log');
		}else{
			echo "<h2>Insert Data Gagal</h2>";
		}
	}

	public function edit_data($npm=null){
		if(isset($npm)){
			$mhs=$this->model->Getdatamhs($npm);
			$data=array(
				"npm" => $mhs[0]['npm'],
				"namamhs" => $mhs[0]['namamhs'],
				"jeniskelamin" => $mhs[0]['jeniskelamin'],
				"alamatmhs" => $mhs[0]['alamatmhs']
      );
			$this->load->view('form_edit',$data);
		}else{
			$data=array(
				"npm" => $this->input->post('npm'),
				"namamhs" => $this->input->post('namamhs'),
				"jeniskelamin" =>$this->input->post('jeniskelamin'),
				"alamatmhs" => $this->input->post('alamatmhs')
      );
				$res=$this->model->UpdateData('datamhs','npm='.$this->input->post('npm'),$data);
				echo json_encode($data);
				echo json_encode($res);
		}
	}

	public function do_delete($npm){
		$where = array('npm' => $npm);
		$res = $this->model->DeleteData('datamhs',$where);
		if($res>=1){
			redirect('index.php/crud/index');
		}else{
			echo "<h2>Delete Data Gagal</h2>";
		}
	}

	public function pdf($npm){
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
		$this->load->view('printpdf',$data);

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


  public function edittf($npm=null){
    if(isset($npm)){
      $mhs=$this->model->Getdatamhs($npm);
      $data=array(
        "npm" => $mhs[0]['npm'],
        "namamhs" => $mhs[0]['namamhs'],
        "jeniskelamin" => $mhs[0]['jeniskelamin'],
        "alamatmhs" => $mhs[0]['alamatmhs'],
        "tgllahir" => $mhs[0]['tgllahir'],
        "about" => $mhs[0]['about'],
        "username" => $mhs[0]['username'],
        "foto" => $mhs[0]['foto']
      );
      $this->load->view('edittf',$data);
    }else{
      $config['upload_path']         = 'assets/images/';  // folder upload
      $config['allowed_types']        = 'gif|jpg|png'; // jenis file
      $config['max_size']             = 30000;
      $config['max_width']            = 10241;
      $config['max_height']           = 76800;
      // $config['source_image'] = "assets/images/".$foto;
      // $config['new_image'] = "assets/images/".$foto;
      $this->load->library('upload', $config);
      $this->upload->do_upload('gambar'); //sesuai dengan name pada form
            //tampung data dari form
      $file = $this->upload->data();
      $foto = $file['file_name'];

      $data=array(
        "npm" => $this->input->post('npm'),
        "namamhs" => $this->input->post('namamhs'),
        "jeniskelamin" =>$this->input->post('jeniskelamin'),
        "alamatmhs" => $this->input->post('alamatmhs'),
        "tgllahir" => $this->input->post('tgllahir'),
        "about" => $this->input->post('about'),
        "foto" => $foto
      );
        $res=$this->model->UpdateData('datamhs','npm='.$this->input->post('npm'),$data);
        // echo json_encode($data);
        // echo json_encode($res);
        redirect('index.php/crud/detailtf/'.$this->input->post('npm'));
    }
  }



  function detailtf($npm=null){
		require_once("vendor/phpqrcode/qrlib.php");
		$filename=$_SERVER["DOCUMENT_ROOT"]."/coba/ci/vendor/img/".$this->RandomString(5).".png";
		$this->load->library('dompdf_gen');
    $mhs = $this->model->Getdatamhs($npm);
		QRcode::png("http://a0d85fb9.ngrok.io/coba/ci/index.php/qr/detail/".$mhs[0]['token'],$filename);
		$data=array(
      "username" => $mhs[0]['username'],
			"npm" => $mhs[0]['npm'],
			"namamhs" => $mhs[0]['namamhs'],
			"jeniskelamin" => $mhs[0]['jeniskelamin'],
			"alamatmhs" => $mhs[0]['alamatmhs'],
      "foto" => $mhs[0]['foto'],
			"imgurl"=>$filename);
			// echo json_encode($data);
		$this->load->view('tabeltf',$data);
	}
	
 function hitung(){
    $this->load->model('model');
     $data['num_results'] = $this->model->some_model_function();
     // $this->load->view('admindash', $data);
     // if (isset($num_results)) {
// echo 'There are ' . $num_results . ' returned';
    json_encode($data);
}


    public function resourceWeb($url=null){
     $data = curl_init();
      curl_setopt($data, CURLOPT_URL, $url);
      curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
         $hasil = curl_exec($data);
         curl_close($data);
         $url =  $this->resourceWeb('https://www.jobstreet.co.id/id/job-search/job-vacancy.php');
         $split = explode('<div id="job_listing_panel">', $url);
         $splitLagi = explode('</div>', $split[0]);

         $this->load->view('welcome_message');
         json_encode($splitLagi);
         // redirect('index.php/crud/hasil');
         return $hasil;
}

 // public function hasil(){
 //   $url =  $this->resourceWeb('https://www.jobstreet.co.id/id/job-search/job-vacancy.php');
 //   $split = explode('<div id="job_listing_panel">', $url);
 //   $splitLagi = explode('</div>', $split[0]);
 //
 //   $this->load->view('welcome_message');
 //   json_encode($splitLagi);
 // }
}
