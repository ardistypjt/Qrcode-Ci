<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Name:  DOMPDF
*
* Author: Jd Fiscus
* 	 	  jdfiscus@gmail.com
*         @iamfiscus
*
*
* Origin API Class: http://code.google.com/p/dompdf/
*
* Location: http://github.com/iamfiscus/Codeigniter-DOMPDF/
*
* Created:  06.22.2010
*
* Description:  This is a Codeigniter library which allows you to convert HTML to PDF with the DOMPDF library
*
*/

class Dompdf_gen {

	public function __construct() {

		require_once APPPATH.'third_party/dompdf/dompdf_config.inc.php';

		$pdf = new DOMPDF();

		$CI =& get_instance();
		$CI->dompdf = $pdf;

	}
	public function generate($html, $filename)
	{
		define('DOMPDF_ENABLE_AUTOLOAD',false);
		require_once APPPATH.'third_party/dompdf/dompdf_config.inc.php';

		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->render();
		$dompdf->stream($filename.'.pdf', array('attachment' =>0));
	}
}
