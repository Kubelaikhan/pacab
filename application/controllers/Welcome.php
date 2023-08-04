<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url', 'html', 'file'));
		$this->load->library(array('session', 'form_validation', 'upload', 'user_agent'));
		$this->load->database();
		$this->load->model(array('login_model'));
		$this->session->keep_flashdata('msg');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index(){
		if($this->session->userdata('login') == true){
			/*$log = array(
				'nik' => $this->session->userdata('nik'),
				'nama' => $this->session->userdata('nama'),
				'menu' => 'HOME',
				'aktivitas' => 'LIHAT HOMEPAGE',
				'ip' => $this->input->ip_address(),
				'waktu' => date('Y-m-d H:i:s')
			);
			$this->logs_model->insert($log);*/
    	    redirect('/home');
		}else{
		    //if(strpos($this->agent->referrer(), "nobby-official") === false){
    	    //    header("location: https://nobby-official.com/");
    	    //    die();
    	    //}else{
		        $this->session->sess_destroy();
			    $data = array(
			    	'nav1' => 0,
			    	'nav2' => 0,
			    );
			    $this->load->view('welcome_message', $data);
		    //}
		}
	}
}
