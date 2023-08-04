<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url', 'html', 'file'));
		$this->load->library(array('session', 'form_validation', 'upload', 'user_agent', 'encryption'));
		$this->load->database();
		$this->load->model(array('login_model', 'home_model', 'pa_model'));
		$this->session->keep_flashdata('msg');
		date_default_timezone_set('Asia/Jakarta');
	}

	function hasSession(){
		if($this->session->userdata('login') == true){
				return true;
		}
		redirect('logout/sessionEnd');
	}

	function hari_ini($day){
		$hari = date("D", strtotime($day));
		switch($hari){
			case 'Sun':
				$hari_ini = "Minggu";
			break;
			case 'Mon':			
				$hari_ini = "Senin";
			break;
			case 'Tue':
				$hari_ini = "Selasa";
			break;
			case 'Wed':
				$hari_ini = "Rabu";
			break;
			case 'Thu':
				$hari_ini = "Kamis";
			break;
			case 'Fri':
				$hari_ini = "Jumat";
			break;
			case 'Sat':
				$hari_ini = "Sabtu";
			break;
			default:
				$hari_ini = "Tidak di ketahui";		
			break;
		}
		return $hari_ini;
	}

	function index(){
		if($this->hasSession()){
			$nik = $this->session->userdata('nik');
			// $header = $this->pa_model->get_form_header($nik);
			$header = $this->pa_model->get_form_msjenis();
			$SOH = $this->pa_model->get_SOH();
			$cabang = $this->pa_model->get_cab();
			$data_karyawan = $this->pa_model->get_karyawan_bynik($nik);
			$interval = $this->pa_model->get_nilai(); 
			if ($header == NULL) {
				$atasan = $data_karyawan[0]->atasan;
				$manager = $this->pa_model->cek_manager($data_karyawan[0]->departemen);
			}else{
				$atasan = $this->pa_model->cek_atasan($nik);
				$dept = $this->pa_model->cek_dept($nik);
				$manager = $this->pa_model->cek_manager($dept[0]->departemen);
			}
			
			$data = array(
				'interval'	=> $interval,
				'header' => $header,
				'soh' => $SOH,
				'cabang' => $cabang,
				'data_karyawan' => $data_karyawan,
				'atasan' => $atasan,
				'manager' => $manager,
				'nav1' => 0,
				'nav2' => 0
			);
		// var_dump($this->session->userdata("dept")); die();
			$this->load->view('home/index.php', $data);
		}
	}

}
?>