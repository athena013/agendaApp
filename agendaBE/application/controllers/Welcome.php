<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

		public function index(){
				$this->load->view('menu_pdf');
		}

		public function pdf_blanco(){
				$this->load->library('mydompdf');
				$data["saludo"] = "Hola mundo!";
				$html= $this->load->view('pdf/blanco', $data, true);
				$this->mydompdf->load_html($html);
				$this->mydompdf->render();
				$this->mydompdf->stream("welcome.pdf", array("Attachment" => false));
		}

		function header_footer(){
			  $this->load->library('mydompdf');
				$data["numero"] = 250;
				$html= $this->load->view('pdf/header_footer', $data, true);
			  $this->mydompdf->load_html($html);
			  $this->mydompdf->render();
				$this->mydompdf->set_base_path('./assets/css/dompdf.css'); //agregar de nuevo el css
			  $this->mydompdf->stream("welcome.pdf", array("Attachment" => false));
		 }

		 function datos_bd(){
			 	$this->load->model('Usuarios');
 			  $this->load->library('mydompdf');

				$data['usuarios'] = $this->Usuarios->getUsuarios();
 				$html= $this->load->view('pdf/datos_bd', $data, true);
 			  $this->mydompdf->load_html($html);
 			  $this->mydompdf->render();
 				$this->mydompdf->set_base_path('./assets/css/dompdf.css'); //agregar de nuevo el css
 			  $this->mydompdf->stream("welcome.pdf", array("Attachment" => false));
 		 }

}
