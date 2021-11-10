<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
    }
    public function index()
    {
      $data=$this->model->Getdatamhs();
      $this->load->select('tabel',array('data'=>$data));
    }
    public function upload(){
        $fileName = time().$_FILES['file']['name'];

        $config['upload_path'] = './assets/'; //buat folder dengan namamhsmhs assets di root folder
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

                //Sesuaikan sama namamhsmhs kolom tabel di database
                 $data = array(
                    "npm"=> $rowData[0][0],
                    "namamhsmhs"=> $rowData[0][1],
                    "jenpmkelamin"=> $rowData[0][2],
                    "alamatmhs"=> $rowData[0][3]
                );

                //sesuaikan namamhs dengan namamhsmhs tabel
                $insert = $this->db->insert("datamhs",$data);
                // delete_files($media['full_path']);

            }
        	redirect('index.php/crud/index');
    }

    public function exprt()
    {
      $data['title'] = 'Export';
      $data['mahasiswa'] = $this->excel->view();
      $data['user'] = $this->db->get_where('user', ['npm' => $this->session->userdata('npm')])->row_array();

      $this->load->view('template/header', $data);
      $this->load->view('template/sidebar', $data);
      $this->load->view('template/topbar', $data);
      $this->load->view('admin/mahasiswa/view', $data);
      $this->load->view('template/footer');
    }

    public function export()
    {
      // Load plugin PHPExcel nya
      // include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
      $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

      // Panggil class PHPExcel nya
      $excel = new PHPExcel();

      // Settingan awal fil excel
      $excel->getProperties()->setCreator('My Notes Code')
        ->setLastModifiedBy('My Notes Code')
        ->setTitle("Data Mahasiswa")
        ->setSubject("Mahasiswa")
        ->setDescription("Laporan Semua Data Mahasiswa")
        ->setKeywords("Data Mahasiswa");

      // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
      $style_col = array(
        'font' => array('bold' => true), // Set font nya jadi bold
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
        ),
        'borders' => array(
          'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
          'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
          'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
        )
      );

      // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
      $style_row = array(
        'alignment' => array(
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
        ),
        'borders' => array(
          'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
          'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
          'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
        )
      );

      $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA MAHASISWA"); // Set kolom A1 dengan tulisan "DATA SISWA"
      $excel->getActiveSheet()->mergeCells('A1:D1'); // Set Merge Cell pada kolom A1 sampai E1
      $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
      $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
      $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

      // Buat header tabel nya pada baris ke 3
      $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
      $excel->setActiveSheetIndex(0)->setCellValue('B3', "NPM"); // Set kolom B3 dengan tulisan "npm"
      $excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
      $excel->setActiveSheetIndex(0)->setCellValue('D3', "JENIS KELAMIN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
      $excel->setActiveSheetIndex(0)->setCellValue('E3', "ALAMAT"); // Set kolom E3 dengan tulisan "ALAMAT"

      // Apply style header yang telah kita buat tadi ke masing-masing kolom header
      $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
      $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
      $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
      $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
      $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);

      // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
      $siswa = $this->excel->view();

      $no = 1; // Untuk penomoran tabel, di awal set dengan 1
      $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
      foreach ($siswa as $data) { // Lakukan looping pada variabel siswa
        $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
        $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->npm);
        $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->namamhs);
        $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->jeniskelamin);
        $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->alamatmhs);

        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);

        $no++; // Tambah 1 setiap kali looping
        $numrow++; // Tambah 1 setiap kali looping
      }

      // Set width kolom
      $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
      $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
      $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
      $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
      $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kol

      // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
      $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

      // Set orientasi kertas jadi LANDSCAPE
      $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

      // Set judul file excel nya
      $excel->getActiveSheet(0)->setTitle("Laporan Data Mahasiswa");
      $excel->setActiveSheetIndex(0);

      // Proses file excel
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="Data Mahasiswa.xlsx"'); // Set nama file excel nya
      header('Cache-Control: max-age=0');

      $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
      $write->save('php://output');
    }
  }
