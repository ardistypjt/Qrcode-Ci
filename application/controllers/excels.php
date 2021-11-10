<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excels extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    }
    public function index()
    {
      $data=$this->model->Getsifo();
      $this->load->view('tabelsifo',array('data'=>$data));
    }
    public function upload(){
        $fileName = time().$_FILES['file']['name'];

        $config['upload_path'] = './assets/'; //buat folder dengan namas assets di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;

        $this->load->library('upload', $config);
        // $this->upload->initialize($config);

        if(! $this->upload->do_upload('file') )
        $this->upload->display_errors();

        $media = $this->upload->data();
        print_r($media);
        $inputFileName = $media['full_path'];

        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }

            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);

                //Sesuaikan sama namas kolom tabel di database
                 $data = array(
                    "npms"=> $rowData[0][0],
                    "namas"=> $rowData[0][1],
                    "jenisk"=> $rowData[0][2],
                    "alamats"=> $rowData[0][3]
                );

                //sesuaikan nama dengan namas tabel
                $insert = $this->db->insert("sifo",$data);
                // delete_files($media['full_path']);

            }
        	redirect('index.php/cruds/index');
    }
}
