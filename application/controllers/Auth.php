<?php

class Auth extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('UserModel');

	}

	public function log(){
		$this->load->view('login');
	}

	public function reg(){
		$this->load->view('regist');
	}

	function index(){
    // $data=$this->model->Getdatamhs();
    // $this->load->view('tabeladmin',array('data'=>$data));
		$this->load->view('admindash');
	}

	public function login(){
		if(isset($_POST['btnSubmit'])){
			if ($_POST['login']=='admin') {
				$tabel='admin';
			}elseif ($_POST['login']=='tf') {
				$tabel='datamhs';
			}elseif ($_POST['login']=='sifo') {
				$tabel='sifo';
			}
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$status = $this->input->post('status');
			$status= "aktif";
			$wherex = array(
				'username' => $username,
				'password' => $password,
				);
			$query=$this->UserModel->cek_login($tabel,$wherex);
			$cek = $query->num_rows();
			$data=$query->result();
			if($cek > 0){
				$data_session = array(
					'nama' => $username,
					'status' => "login"
					);
					$this->session->set_userdata($data_session);
					if ($_POST['login']=='admin') {
						redirect('index.php/Auth/index');
					}elseif ($_POST['login']=='tf') {
						redirect('index.php/crud/detailtf/'.$data[0]->npm);
					}elseif ($_POST['login']=='sifo') {
						redirect('index.php/cruds/detailsf/'.$data[0]->npms);
					}
				}else{
					echo "Username dan password salah !";
				}
		}
	}


  public function registadm(){

    if(isset($_POST['btnSubmit'])){
      $username = $_POST['username'];
      $nama_adm = $_POST['nama_adm'];
      $id_adm = $_POST['id_adm'];
      $password = $_POST['password'];
      $dataxx = array(
      'username' => $username,
      'nama_adm' => $nama_adm,
      'id_adm' => $id_adm,
      'password' => $password
      );
      $y = $this->UserModel->registadm('admin',$dataxx);
      if($y>=1){
        redirect('index.php/Auth/log');
      }else{
        echo "<h2>Insert Data Gagal</h2>";
      }
    }else{
      $this->load->view("regist");
    }
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

	public function registtf(){

		if(isset($_POST['btnSubmit'])){
			$username = $_POST['username'];
			$namamhs = $_POST['namamhs'];
			$npm = $_POST['npm'];
			$alamatmhs = $_POST['alamatmhs'];
			$jeniskelamin = $_POST['jeniskelamin'];
			$password = $_POST['password'];
			$dataxx = array(
			'username' => $username,
			'namamhs' => $namamhs,
			'npm' => $npm,
			'jeniskelamin' => $jeniskelamin,
			'alamatmhs' => $alamatmhs,
			'password' => $password,
			'token' => $token=$this->RandomString()
			);
			$y = $this->model->InsertData('datamhs',$dataxx);
			if($y>=1){
				redirect('index.php/Auth/log');
			}else{
				echo "<h2>Insert Data Gagal</h2>";
			}
		}
		else{
			$this->load->view("registtf");
		}
	}

	public function registsf(){

		if(isset($_POST['btnSubmit'])){
			$username = $_POST['username'];
			$namas = $_POST['namas'];
			$npms = $_POST['npms'];
			$alamats = $_POST['alamats'];
			$jenisk = $_POST['jenisk'];
			$password = $_POST['password'];
			$dataxx = array(
			'username' => $username,
			'namas' => $namas,
			'npms' => $npms,
			'jenisk' => $jenisk,
			'alamats' => $alamats,
			'password' => $password,
			'tokens' => $tokens=$this->RandomString()
			);
			$y = $this->models->InsertData('sifo',$dataxx);
			if($y>=1){
				redirect('index.php/Auth/log');
			}else{
				echo "<h2>Insert Data Gagal</h2>";
			}
		}else{
			$this->load->view("registsf");
		}
	}

	public function logout(){
		$this->session->sess_destroy();
				redirect('index.php/Auth/Log');
	}
}
