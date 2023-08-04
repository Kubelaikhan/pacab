<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url', 'html', 'file'));
		$this->load->library(array('session', 'form_validation', 'upload'));
		$this->load->database();
		//$this->load->model('logs_model');
		$this->session->keep_flashdata('msg');
		date_default_timezone_set('Asia/Jakarta');
	}
	
	function index(){
		/*$log = array(
			'nik' => $this->session->userdata('nik'),
			'nama' => $this->session->userdata('nama'),
			'menu' => 'LOGOUT',
			'aktivitas' => 'LOGOUT DARI SISTEM',
			'ip' => $this->input->ip_address(),
			'waktu' => date('Y-m-d H:i:s')
		);
		$this->logs_model->insert($log);*/
		$this->session->set_flashdata('msg', '  <div class="alert alert-warning alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Anda berhasil logout
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            	    </button>
            	</div>');
		$this->session->sess_destroy();
		$this->load->view('welcome_message');
	}

	function signOut(){
		/*$log = array(
			'nik' => $this->session->userdata('nik'),
			'nama' => $this->session->userdata('nama'),
			'menu' => 'LOGOUT',
			'aktivitas' => 'LOGOUT DARI SISTEM',
			'ip' => $this->input->ip_address(),
			'waktu' => date('Y-m-d H:i:s')
		);
		$this->logs_model->insert($log);*/
		$this->session->set_flashdata('msg', '  <div class="alert alert-warning alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Anda sudah logout!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            	    </button>
            	</div>');
		$this->session->sess_destroy();
		redirect('/welcome');
	}

	function sessionEnd(){
		/*$log = array(
			'nik' => $this->session->userdata('nik'),
			'nama' => $this->session->userdata('nama'),
			'aktivitas' => 'LOGOUT DARI SISTEM',
			'ip' => $this->input->ip_address(),
			'waktu' => date('Y-m-d H:i:s')
		);
		$this->logs_model->insert($log);*/
		$this->session->set_flashdata('msg', '  <div class="alert alert-warning alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Session habis, silahkan login ulang!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            	    </button>
            	</div>');
		$this->session->sess_destroy();
		$this->load->view('welcome_message');
	}

	function isMobile(){
		$this->session->sess_destroy();
		$this->load->view('index/mobile');
	}
}

?>