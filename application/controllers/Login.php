<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url', 'html', 'file'));
		$this->load->library(array('session', 'form_validation', 'upload', 'user_agent'));
		$this->load->database();
		$this->load->model(array('login_model'));
		date_default_timezone_set('Asia/Jakarta');
	}
	
	function hasSession(){
		if($this->session->userdata('login') == true){
			redirect('home');
		}else{
		    return true;
		}
	}

	function index(){
		if($this->hasSession()){			

			$nik = $this->input->post('nik');
			$password = $this->input->post('password');
			$this->form_validation->set_rules('nik', 'NIK Karyawan', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

			if($this->form_validation->run() == FALSE){
					$this->load->view('welcome_message');
			}else{
				$where = array(
					'k.nik' => $nik,
					'k.aktif' => 'Y'
				);
				if($this->login_model->cabang_available($where) > 0){
					$pass = $this->login_model->get_password($where);
					if(md5($password) == $pass){
						$result = $this->login_model->get_cabang($where);
						if(count($result) > 0){
							$dept = $this->login_model->get_authorisasi_departemen($where);
							if(count($dept) > 0){
								$sess = array(
										'login' => TRUE, 
										'nik' => $dept[0]->nik,
										'cabang' => $dept[0]->kode_cabang,
										'nama' => $dept[0]->nama,
										'dept' => $dept[0]->departemen,
										'level' => $dept[0]->level,
										'apps' => 'PA'
									);

									$this->session->set_userdata($sess);
								//$ip = $this->input->ip_address();
								//$this->insert_logs('LOGIN', 'LOGIN KE SISTEM', $result[0]->nik);
								$this->session->set_flashdata('msg', '  <div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Selamat datang, '.$result[0]->nama.'!
																			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																			<span aria-hidden="true">&times;</span></button>
																		</div>');
								redirect('home');
							}else{
								$this->session->set_flashdata('msg', '  <div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Anda tidak memiliki akses ke halaman ini!
																			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																				<span aria-hidden="true">&times;</span>
																			</button>
																		</div>');
								redirect('welcome');
							}
						}else{
							$this->session->set_flashdata('msg', '  <div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Akun tidak aktif, silakan hubungi Staff IT.
																		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																			<span aria-hidden="true">&times;</span>
																		</button>
																	</div>');
								redirect('welcome');
						}
					}else{
						$this->session->set_flashdata('msg', '  <div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Password salah, silakan coba lagi.
																	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>');
								redirect('welcome');
					}
				}else{
					$this->session->set_flashdata('msg', '  <div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Akun tidak terdaftar atau tidak aktif, silakan hubungi Staff IT!
																<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>');
								redirect('welcome');
				}
			}
		}
	}

	function changePassword(){
		$data = array(
			'nav1' => null,
			'nav2' => null
		);
		//$this->insert_logs('GANTI PASSWORD', 'FORM GANTI PASSWORD', '');
		$this->load->view('home/ganti_password', $data);
	}

	function updatePassword(){
		$passlama = $this->input->post('passlama');
		$passbaru = $this->input->post('passbaru');
		$cpassbaru = $this->input->post('cpassbaru');
		$this->form_validation->set_rules('passlama', 'Password Lama', 'trim|required|xss_clean');
		$this->form_validation->set_rules('passbaru', 'Password Baru', 'trim|required|xss_clean');
		$this->form_validation->set_rules('cpassbaru', 'Konfirmasi Password Baru', 'trim|required|matches[passbaru]|xss_clean');
		if($this->form_validation->run() == FALSE){
			//validation fail
			redirect('home');
		}else{
			$nik = $this->session->userdata('nik');
			$where = array(
				'k.nik' => $nik
			);
			$old = $this->login_model->get_password($where);
			if($old == md5($passlama)){
				$data = array(
					'pass2' => md5($passbaru),
					'tgl_update' => date('Y-m-d H:i:s')
				);
				$where = array(
					'nik' => $nik
				);

				if($this->login_model->change_password('users', $data, $where)){
					//$this->insert_logs('GANTI PASSWORD', 'SIMPAN PASSWORD BARU', '');
					$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil mengganti password, silahkan login ulang!
					            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                <span aria-hidden="true">&times;</span>
					            	    </button>
					            	</div>');
					redirect('/logout/');
				}else{
					$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Gagal ganti password, silahkan coba lagi!
					            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                <span aria-hidden="true">&times;</span>
					            	    </button>
					            	</div>');
					redirect('login/changePassword');
				}
			}else{
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Password lama salah, silahkan coba lagi!
					            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					                <span aria-hidden="true">&times;</span>
					            	    </button>
					            	</div>');
				redirect('login/changePassword');
			}
		}
	}

	function tes(){
		echo $this->session->userdata('nik').'-'.$this->session->userdata('nama');
	}
}

?>
