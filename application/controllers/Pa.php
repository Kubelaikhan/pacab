<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pa extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url', 'html', 'file'));
		$this->load->library(array('session', 'form_validation', 'upload', 'user_agent', 'encryption'));
		$this->load->database();
		$this->load->model(array('login_model', 'home_model', 'pa_model'));
		$this->session->keep_flashdata('msg');
		date_default_timezone_set('Asia/Jakarta');
	}

	//SESSION
	function hasSession(){
		if($this->session->userdata('login') == true){
				return true;
		}
		redirect('logout/sessionEnd');
	}

	//KODE YANG DIGENERATE
	// private function generateKodePA(){
	// 	$date = date('y-m');
	// 	$bulan = date('m');
	// 	$tahun = date('y');
	// 	$check_kode = $this->pa_model->get_last_kd_today();
	// 	$kode_pa = '';
	// 	if(empty($check_kode)){
	// 		$next = 1;
	// 		$new = sprintf("%04s", $next);
	// 		$kode_pa = 'PA'.date('ym').$new;
	// 	}else{
	// 		$format = substr($check_kode[0]->kode_pa, -4);
	// 		$next = (int)$format;
	// 		$new = sprintf("%04s", $next+1);
	// 		$kode_pa = 'PA'.date('ym').$new;
	// 	}
	// 	return $kode_pa;
	// }

	private function generateKodeJenis($nm_jenis, $jenis_ke){
		$tahun = date('y');
		// $nm_jenis = substr($nm_jenis,0,2);

		 if($nm_jenis == "HK" || $nm_jenis == "LL"){
		 	$jenis_ke = date('d', strtotime($jenis_ke));
		 	$jenis_ke = substr($jenis_ke, 1);
		 }
		// $check_kode = $this->pa_model->get_last_kd_today();
		$check_kode = $this->pa_model->get_last_kd_hari();
		// $kode_pa = '';
		if(empty($check_kode)){
			$next = 1;
			$new = sprintf("%03s", $next);
			$kode_pa = $nm_jenis.$jenis_ke.$tahun.$new;
		}else{
			$format = substr($check_kode[0]->kd_jenis, -3);
			$next = (int)$format;
			$new = sprintf("%03s", $next+1);
			$kode_pa = $nm_jenis.$jenis_ke.date('y').$new;
		}
		// var_dump($nm_jenis.' '.$jenis_ke.' '.$tahun.' '.$new);die();
		// var_dump($kode_pa);die();
		return $kode_pa;
	}

	private function generateKodePeserta($kd_jenis){
		$query = $this->db->query("SELECT * from pacab_pesertajenis where substr(kd_jenis, 1, 8) = '$kd_jenis' order by kd_jenis desc limit 1")->result();
		if(empty($query)){
			$number = 1;
			$kode= sprintf("%03s",$number); // String
			$peserta = $kd_jenis.$kode;
			return $peserta;
		}else{
			$number = substr($query[0]->kd_jenis, -3);
			$kode= sprintf("%03s",$number+1); // String
			$peserta =$kd_jenis.$kode;
			return $peserta;
		}
	}

	private function generateKodePeserta2($kd_jenis){

		$query = $this->db->query("SELECT * from pacab_pesertajenis where kd_jenis = '$kd_jenis' order by kd_jenis desc limit 1")->result();
		if(empty($query)){
			$number = 1;
			$kode= sprintf("%03s",$number); // String
			$peserta = $kd_jenis.$kode;
			// var_dump($peserta);die();
			return $peserta;
		}else{
			$number = substr($query[0]->kd_jenis, -3);
			$kode= sprintf("%03s",$number+1); // String
			$kodee = substr($kd_jenis,0,8);
			$peserta =$kodee.$kode;
			return $peserta;
		}
	}

	//HALAMAN UNTUK SIMPAN JENIS SEMESTER ATUA KHUSUS
	function simpanJenis(){
		if ($this->hasSession()){
			// $kode_pa = $this->uri->segment(3);
			$nik = $this->session->userdata('nik');
			// $header = $this->pa_model->get_data_header($kode_pa);
			// $detail = $this->pa_model->get_detail($kode_pa);
			// $atasan = $this->pa_model->cek_atasan($header[0]->nik);
			// $dept = $this->pa_model->cek_dept($header[0]->nik);
			// $manager = $this->pa_model->cek_manager($dept[0]->departemen);
			// $this->load->view('home/pa/formulir.php', $data);
			$tujuan= $this->input->post("tujuan");
			
			
			$jenis = $this->input->post("jenis_pa");
			if($jenis == "KHS"){
				$jenis_ke = $this->input->post("periode1");
				// $nm_jenis = "KHUSUS";
				$nm_jenis = $this->input->post("khusus");
			
				$periode1 = $this->input->post("periode1");
				$periode2 = $this->input->post("periode2");

				if($nm_jenis == "HK"){
					$nama = "HABIS KONTRAK";
				}else{
					$nama = "Lainnya";
				}

				// var_dump($nm_jenis.' '.$jenis_ke);die();
				
				$data = array(
					"kd_jenis" => $this->generateKodeJenis($nm_jenis, $jenis_ke),
					"nm_jenis" => $nm_jenis, 
					// "nm_jenis" => $nama, 
					"tgl_awal" => $periode1,
					"tgl_akhir" => $periode2,
					"jenis_ke" => $jenis_ke,
					"tujuan" => $tujuan,
					"aktif" => "Y",
					"user_input" =>  $this->session->userdata('nik'),
					"tgl_input" => date('Y-m-d H:i:s'),
					"user_update" =>  $this->session->userdata('nik'),
					"tgl_update" => date('Y-m-d H:i:s'),
				);

				// var_dump($data['tujuan']);die();
				$this->db->insert('pacab_msjenis', $data);
	
			} else if($jenis == "SMT"){
				$jenis_ke = $this->input->post("semester");
				$nm_jenis = "SM";
				// $nama = "SEMESTER";
				$thn_periode = $this->input->post("thn_periode");
				if($jenis_ke == 1){
					$periode1 = $thn_periode.'-01-01';
					$periode2 = $thn_periode.'-06-30';
				}
				if($jenis_ke == 2){
					$periode1 = $thn_periode.'-07-01';
					$periode2 = $thn_periode.'-12-31';
				}

				$data = array(
					"kd_jenis" => $this->generateKodeJenis($nm_jenis, $jenis_ke),
					"nm_jenis" => $nm_jenis,
					// "nm_jenis" => $nama,
					"tgl_awal" => $periode1,
					"tgl_akhir" => $periode2,
					"jenis_ke" => $jenis_ke,
					"tujuan" => $tujuan,
					"aktif" => "Y",
					"user_input" => $this->session->userdata('nik') ,
					"tgl_input" => date('Y-m-d H:i:s'),
					"user_update" =>  $this->session->userdata('nik'),
					"tgl_update" => date('Y-m-d H:i:s'),
				);
				// var_dump($data);die();
				$this->db->insert('pacab_msjenis', $data);
			}
		
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil simpan jenis <i>Performance Appraisal</i>!
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>');
			redirect('home');
		}
	}

	function simpanPesertaJenis(){
		if ($this->hasSession()){
			// $kode_pa = $this->uri->segment(3);
			// var_dump( $this->input->post('kd_jenis'));die();
			$nik = $this->session->userdata('nik');
			$nik = $this->input->post('nik');
			$cabang = $this->input->post('cabang');
			$soh = $this->input->post('soh');
			$kd_jenis = $this->input->post('kd_jenis');
			$cekDulu = $this->pa_model->udahBelumJenis($nik, $kd_jenis);
			// var_dump($soh);die();
			if($soh == "Pilih NAMA SOH" || $soh ==NULL){
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Pilih nama SOH</i>!
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>');
				redirect('home');
			}
			if($cekDulu->num_rows() > 0){
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Kamu sudah mendaftar dalam periode jenis ini</i>!
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>');
				redirect('home');
			}
			$data = array(
				'kd_jenis' => $this->generateKodePeserta($kd_jenis),
				'nik'=> $nik,
				'cabang' => $cabang,
				'soh' => $soh
			);
			// var_dump($this->generateKodePeserta($kd_jenis));die();
		
			$this->db->insert('pacab_pesertajenis', $data);
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Silakan klik masuk detail.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
			</div>');
			redirect('home');
		}
	}

	function lihatKaryawanCabang($kode_cabang){
		if ($this->hasSession()){
			$kar_cab = $this->pa_model->get_employee_store($kode_cabang);
			$data = array(
				$header => $kar_cab,
			);
			$this->load->view('pa/lihat_pacab_kamu', $data);
		}
	}

	//HALAMAN HEADER PERFORMANCE APPRAISAL
	function formPerformance($kd_jenis){
		if ($this->hasSession()){
			$kd_jenis = $this->uri->segment(3);
			$nik = $this->session->userdata('nik');
			$cekJenis = $this->pa_model->cekSmt($kd_jenis, $nik);
			if($this->session->userdata('level') == 210 || $this->session->userdata('level') == 240 ){
				if($cekJenis->num_rows() <= 0){
					// var_dump('Y');die();
					$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Kamu belum mengonfirmasi data diri.
															<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
															</div>');
					redirect('home');
				}
			}
			// $header = $this->pa_model->get_data_header($kode_pa);
			// $detail = $this->pa_model->get_detail($kode_pa);
	
			$dept = $this->pa_model->cek_dept($nik);
			$manager = $this->pa_model->cek_manager($dept[0]->departemen);
			// $this->load->view('home/pa/formulir.php', $data);
			// $manggil = $this->pa_model->panggilKode($kd_jenis);
			// var_dump($nik);die();
			$cari = $this->pa_model->cariPesertaJenis($kd_jenis,$nik);
			$cabang = $this->pa_model->get_cab();
			$karyawan = $this->pa_model->get_karyawan_bynik($nik);
			$jenis = $this->pa_model->getJenis($kd_jenis);
			// $header = $this->pa_model->getHeaderAll();
			$header = $this->pa_model->getHeaderOnlyYou($nik, $kd_jenis);
			$atasan = $this->pa_model->cek_atasan($nik);
			if($jenis[0]->nm_jenis == "SM"){
				$penggal = substr($jenis[0]->kd_jenis, 0, 3);
			}else{
				$penggal = substr($jenis[0]->kd_jenis, 0, 2);
			}
			
			
			if($penggal == "HK"){
				$nama_jenis = "KHUSUS - HABIS KONTRAK";
			}else if($penggal == "LL"){
				$nama_jenis = "KHUSUS - Lainnya";
			}else if($penggal == "SM1"){
				$nama_jenis = "SEMESTER 1";
			}else{
				$nama_jenis = "SEMESTER 2";
			}
			
			$data =array(
				'header' => $header,
				'atasan' => $atasan,
				'cari' => $cari,
				'data_karyawan' => $karyawan,
				'interval' => $this->pa_model->get_nilai(),
				'nama_jenis' =>$nama_jenis,
				'nav1' => 0,
				'nav2' => 0
			);	
			$this->load->view('home/lihat_pacab_kamu', $data);
		}
	}

	// function editFormPerfomance($kd_jenis){
	// 	if($this->hasSession()){
	// 		$editt = $this->pa_model->loadKode($kd_jenis);
	// 		$data = [
	// 			'header' => $editt,
	// 		];
	// 		$this->load->view('edit_form', $data);
	// 	}
	// }

	//HALAMAN HEADER PERFORMANCE APPRAISAL
	function formPerformanceSOH($kd_jenis){
		if ($this->hasSession()){
			$kd_jenis = $this->uri->segment(3);
			$nik = $this->session->userdata('nik');
			// $cabang = $this->input->get('cabang');
			$cabang = $this->uri->segment(4);
			$cekJenis = $this->pa_model->cekSmt($kd_jenis, $nik);
			if($this->session->userdata('level') == 210 || $this->session->userdata('level') == 240 ){
				if($cekJenis->num_rows() <= 0){
					// var_dump('Y');die();
					$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Kamu belum mengonfirmasi data diri.
															<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
															</div>');
					redirect('home');
				}
			}
	
			$dept = $this->pa_model->cek_dept($nik);
			$manager = $this->pa_model->cek_manager($dept[0]->departemen);

			$cari = $this->pa_model->cariPesertaJenis($kd_jenis,$nik);
			$nama_cabang = $this->pa_model->soh_cabang_searchhh();
			$karyawan = $this->pa_model->get_karyawan_bynik($nik);
			$jenis = $this->pa_model->getJenis($kd_jenis);
			// $header = $this->pa_model->getHeaderOnlyYou($nik);
			// $header = $this->pa_model->getCabangPaSoh($cabang);
			$header = $this->pa_model->getCabangPaSoh($cabang, $kd_jenis);
			$atasan = $this->pa_model->cek_atasan($nik);
			$data =array(
				'header' 		=> $header,
				'atasan' 		=> $atasan,
				'cari' 			=> $cari,
				'cabang' 		=> $nama_cabang,
				'cabs' 			=> $cabang,
				'data_karyawan' => $karyawan,
				'interval'		=> $this->pa_model->get_nilai(),
				'jenis' 		=> $jenis,
				'nav1' 			=> 0,
				'nav2' 			=> 0
			);	
			$this->load->view('home/lihat_pacab_soh', $data);
		}
	}

	function formPerformanceHRD($kd_jenis){
		if ($this->hasSession()){
			$kd_jenis = $this->uri->segment(3);
			$nik = $this->session->userdata('nik');
			$cabang = $this->uri->segment(4);
			// $cabang = $this->input->get('cabang');
			// var_dump($cabang);die();
			$cekJenis = $this->pa_model->cekSmt($kd_jenis, $nik);
			if($this->session->userdata('level') == 210 || $this->session->userdata('level') == 240 ){
				if($cekJenis->num_rows() <= 0){
					// var_dump('Y');die();
					$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Kamu belum mengonfirmasi data diri.
															<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
															</div>');
					redirect('home');
				}
			}

			$header = $this->pa_model->getCabangPA($cabang,  $kd_jenis);

			$dept = $this->pa_model->cek_dept($nik);
			$manager = $this->pa_model->cek_manager($dept[0]->departemen);
			$cari = $this->pa_model->cariPesertaJenis($kd_jenis,$nik);
			$karyawan = $this->pa_model->get_karyawan_bynik($nik);
			$nama_cabang = $this->pa_model->get_cab();
			$jenis = $this->pa_model->getJenis($kd_jenis);
			//$header = $this->pa_model->getHeaderOnlyYou($nik);
			$atasan = $this->pa_model->cek_atasan($nik);
			$data =array(
				'header' 		=> $header,
				'atasan' 		=> $atasan,
				'cari' 	 		=> $cari,
				'cabs' 			=> $cabang,
				'cabang' 		=> $nama_cabang,
				'data_karyawan' => $karyawan,
				'interval' 		=> $this->pa_model->get_nilai(),
				'jenis' 		=> $jenis,
				'nav1' 			=> 0,
				'nav2' 			=> 0
			);	
			$this->load->view('home/lihat_pacab_hrd', $data);
		}
	}

	function simpanPA(){
		if($this->hasSession()){
			$kode_cabang = $this->input->post('kode_cabang');
			$niknama = $this->input->post('niknama');
			$nn = explode(' - ', $niknama);
			$nik = $nn[0];
			$nama = $nn[1];
			$jenis_pa = $this->input->post('jenis');
			$kd_jenis = $this->input->post('kd_jenis');
			// var_dump($kd_jenis);die();
			$kode = substr($kd_jenis, 0, 8);
			$status = $this->input->post('status');
			$pjenis = $this->pa_model->getJenis($kode);
			$jabatan = $this->input->post('jabatan');
			$karyawan = $this->pa_model->get_karyawan_bynik($nik);
			$timestamp = date('Y-m-d H:i:s');
			
			$periode1= $pjenis[0]->tgl_awal;
			$periode2= $pjenis[0]->tgl_akhir;
			$thn = date('Y', strtotime($pjenis[0]->tgl_akhir));
			$date2 = date_create($periode2);
			$date1 = date_create($periode1);
			$periode = date_diff($date2,$date1);
			$bulan = $periode->m;
			$tahun = $periode->y;
			$hari = $periode->d;
			$prd = $tahun.' Tahun '.$bulan.' Bulan '.$hari.' Hari';
			
			// $cekPA= $this->db->query("SELECT * FROM pacab_formheader WHERE kode_pa ='$kd_jenis'");
			$cekPA = $this->pa_model->cekPA($kd_jenis);
			if($cekPA->num_rows() > 0){
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%"> Kamu sudah buat PA periode ini.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>');
				redirect('home');
			}

			$coba = substr($pjenis[0]->nm_jenis, 0, 2);
			if($coba == 'HK' || $coba == 'LL'){
				// var_dump("Y");die();
				$jenis_pa = $coba.' '.$periode1;
			}else{
				$jenama = substr($pjenis[0]->nm_jenis,0,1);
				$jenis_pa = $jenama.$pjenis[0]->jenis_ke.' '.$thn;
			}


			$tujuan = $pjenis[0]->tujuan;
			$atasan = $this->pa_model->list_atasan($nik);
			$faktor = $this->pa_model->get_faktor_kategori($karyawan[0]->nik, $atasan[0]->nik);

			$data = array(
				'kode_pa' 			=> $kd_jenis,
				'kode_cabang'		=> $kode_cabang,
				'jenis_pa' 			=> $jenis_pa,
				'nik'               => $nik,
				'nama'				=> $nama,
				'jabatan'           => $jabatan,
				'status_karyawan'   => $status,
				'tgl_gabung'        => $karyawan[0]->tgl_gabung,
				'tgl_penilaian'     => $periode1,
				'tgl_periode2'	    => $periode2,
				'periode'			=> $prd,
				'tujuan_penilaian'  => strtoupper($tujuan),
				'status'		    => 'PROCESS',
				'user_input'        => $nik,
				'tgl_input'         => $timestamp,
				'user_update'        => $nik,
				'tgl_update'         => $timestamp,
			);

			if($this->pa_model->insert('pacab_formheader', $data)){
				$count = count($faktor);
				for ($i=0; $i < $count; $i++){ 
					$data = array(
						'kode_pa'		=> $kd_jenis,
						'nik'			=> $nik,
						'nama'			=> $nama,
						'faktor'        => $faktor[$i]->faktor,
						'user_input'    => $nik,
						'tgl_input'     => $timestamp
						);
					$this->pa_model->insert('pacab_formdetail', $data);
				}		
				// var_dump($data);die();		
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil Simpan Data Diri ! Silakan Isi Formulir Performance Appraisal Berikut ini.
														<button type="button" class="close" data-dismiss="alert" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
														</div>');
				redirect('pa/lihatFormulirr/'.$kd_jenis);
			}
		}
		
	}

	function lihatFormulirr(){
		if ($this->hasSession()){
			$kode_jenis = $this->uri->segment(3);
			// var_dump($kode_jenis);die();
			// $nyari = $this->pa_model->get_peserta_jenis($kode_jenis);
			// $nik = $nyari[0]->nik;
			$header = $this->pa_model->get_data_header($kode_jenis);
			$detail = $this->pa_model->get_detail($kode_jenis);
			$atasan = $this->pa_model->cek_atasan($header[0]->nik);
			$dept = $this->pa_model->cek_dept($header[0]->nik);
			$manager = $this->pa_model->cek_manager($dept[0]->departemen);
			// $soh = $this->pa_model->check_atasan($kode_jenis, $header[0]->nik);
			// $soh = $soh[0]->soh;
			$data = array(
				'header' => $header,
				'detail' => $detail,
				'kode_pa' => $kode_jenis,
				'atasan' => $atasan,
				'manager' => $manager,
				'nav1' => 0,
				'nav2' => 0
			);
			// var_dump($data );die();
			// var_dump($data);die();
			$this->load->view('home/pa/formulir.php', $data);
		}
	}
































	function UpdateNilai(){
		if ($this->hasSession()){
			$id = $this->input->post('id');
			$kode_fk = $this->input->post('kode_fk');
			$nilai = strtoupper($this->input->post('nilai'));
			$skor = $this->input->post('skor');			
			$detail = $this->pa_model->get_detail_byid($id);
			if ($skor == NULL OR $skor == "") {
				$this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Gagal simpan Nilai, Silakan input skor ketika pilih nilai!
															<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>');
				redirect('pa/lihatFormulirr/'.$detail[0]->kode_pa);
			}
			$timestamp = date('Y-m-d H:i:s');
			$nik = $this->session->userdata('nik');
			if ($nilai == 'A') {
				$kategori = 'kategori_a';
			}elseif ($nilai == 'B') {
				$kategori = 'kategori_b';
			}elseif ($nilai == 'C') {
				$kategori = 'kategori_c';
			}elseif ($nilai == 'D') {
				$kategori = 'kategori_d';
			}elseif ($nilai == 'E'){
				$kategori = 'kategori_e';
			}else{
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Nilai Tidak Valid!
														<button type="button" class="close" data-dismiss="alert" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>');
				redirect('pa/lihatFormulirr/'.$detail[0]->kode_pa);
			}
			$fk = $this->pa_model->get_kategori_fix($kode_fk, $kategori);
			$msnilai = $this->pa_model->get_ms_nilai($nilai);
			$data = array(
				'kategori' => $fk[0]->kategori,
				'nilai' => $nilai,
				'skor' => $skor,
				'user_update' => $nik,
				'tgl_update' => $timestamp
			);
			$where = array(
				'id' => $id,
				'kode_pa' => $detail[0]->kode_pa
			);
			if($this->pa_model->update('pacab_formdetail', $data, $where)){
				$isi_det = $this->pa_model->isi_detail($detail[0]->kode_pa);
				$jml_det = $this->pa_model->jml_detail($detail[0]->kode_pa);
				$nilai = $this->pa_model->get_rata_rata($detail[0]->kode_pa);
				if ($isi_det == $jml_det){
					$data = array(
						'nilai_ratarata' 	=> $nilai[0]->rata_rata,
						'user_update' 		=> $nik,
						'tgl_update' 		=> $timestamp
					);
					$where = array(
						'kode_pa'			=> $detail[0]->kode_pa
					);
					if($this->pa_model->update('pacab_formheader', $data, $where)){
						$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil Simpan Nilai.
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>');
						redirect('pa/lihatFormulirr/'.$detail[0]->kode_pa);
					}else{
						$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Gagal Update Nilai Rata-rata.
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>');
						redirect('pa/lihatFormulirr/'.$detail[0]->kode_pa);
					}
				}
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil Simpan Nilai.
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>');
						redirect('pa/lihatFormulirr/'.$detail[0]->kode_pa);
			}else{
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Gagal Update Nilai.
															<button type="button" class="close" data-dismiss="alert" aria-label="Close">
															<span aria-hidden="true">&times;</span>
															</button>
														</div>');
				redirect('pa/lihatFormulirr/'.$detail[0]->kode_pa);
			}
		}
	}

	function hapusForm(){
		if ($this->hasSession()) {
			$id = $this->uri->segment(3);
			$kode_pa = $this->uri->segment(4);
			$nik = $this->session->userdata('nik');
			$timestamp = date('Y-m-d H:i:s');
			$data = array(
				'is_delete'		=> 'Y',
				'user_update'	=> $nik,
				'tgl_update'	=> $timestamp
			);
			$where = array(
				'id' => $id
			);
			if($this->pa_model->update('pacab_formheader', $data, $where)){
				$data = array(
					'is_delete'		=> 'Y',
					'user_update'	=> $nik,
					'tgl_update'	=> $timestamp
				);
				$where = array(
					'kode_pa' => $kode_pa
				);
				$this->pa_model->update('pacab_formdetail', $data, $where);
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil Hapus Data.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							    <span aria-hidden="true">&times;</span>
							</button>
						</div>');
				redirect('home');
			}
		}
	}

	function updateAgree(){
		if ($this->hasSession()){
			$kode_jenis = $this->uri->segment(3);
			$timestamp = date('Y-m-d H:i:s');			
			$nilai = $this->pa_model->get_rata_rata($kode_jenis);
			$data = array(
				'nilai_ratarata' 	=> $nilai[0]->rata_rata,
				'status'			=> 'AGREE',
				'user_update'		=> $this->session->userdata('nik'),
				'tgl_update'		=> $timestamp
			);
			$where = array(
				'kode_pa'			=> $kode_jenis
			);
			if($this->pa_model->update('pacab_formheader', $data, $where)){
				$this->session->set_flashdata('msg', '<div	div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil Agree Data.
															<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
													</div>');
				redirect('pa/lihatFormulirr/'.$kode_jenis);
			}
		}
	}

	function updateConfirmed(){
		if ($this->hasSession()){
			$kode_pa = $this->uri->segment(3);
			$header = $this->pa_model->get_data_header($kode_pa);
			if($header[0]->rekomendasi == "" OR $header[0]->keterangan == ""){
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Gagal Confirm ! Silakan isi Rekomendasi & Keterangan pada button RK.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							    <span aria-hidden="true">&times;</span>
							</button>
						</div>');
				redirect('pa/lihatDetailBawahan/'.$kode_pa);
			}
			$timestamp = date('Y-m-d H:i:s');			
			$nilai = $this->pa_model->get_rata_rata($kode_pa);			
			$dept = $this->pa_model->cek_dept($header[0]->nik);
			$atasan = $this->pa_model->cek_atasan($header[0]->nik);
			$manager = $this->pa_model->cek_manager($dept[0]->departemen);
			$lampiran = $this->pa_model->get_lampiran_pa($kode_pa);
			$file_count = count($lampiran); 
			
			// if ($file_count == 0) {
			// 	$this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Gagal ! Silakan Masukkan File KPI ditombol Lampiran.
			// 				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			// 				    <span aria-hidden="true">&times;</span>
			// 				</button>
			// 			</div>');
			// 	// redirect('pa/lihatDetailBawahanDept/'.$kode_pa);
			// 	echo '<script>javascript:history.go(-1)</script>';
			// 	GOTO AKHIR;
			// }

			if($header[0]->user_input == $header[0]->nik AND $header[0]->status == 'PROCESS'){
				$data = array(
					'nilai_ratarata' 	=> $nilai[0]->rata_rata,
					'status'			=> 'CONFIRMED',
					'user_update'		=> $this->session->userdata('nik'),
					'tgl_update'		=> $timestamp
				);
			}elseif($header[0]->user_input == $header[0]->nik AND $header[0]->status == 'PROCESS' AND $atasan == $manager){
				$data = array(
					'nilai_ratarata' 	=> $nilai[0]->rata_rata,
					'status'			=> 'CONFIRMED SOH',
					'user_update'		=> $this->session->userdata('nik'),
					'tgl_update'		=> $timestamp
				);
			}elseif($header[0]->status == 'REVISI'){
				$data = array(
					'nilai_ratarata' 	=> $nilai[0]->rata_rata,
					'status'			=> 'AGREE',
					'user_update'		=> $this->session->userdata('nik'),
					'tgl_update'		=> $timestamp
				);
			}			
			$where = array(
				'kode_pa'		=> $kode_pa
			);
			if($this->pa_model->update('pacab_formheader', $data, $where)){
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil Confirm Data.
														<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																<span aria-hidden="true">&times;</span>
														</button>
													</div>');

				echo '<script>javascript:history.go(-1)</script>';
			}
			AKHIR:
		}
	}

	function lihatBawahan(){
		if ($this->hasSession()){
			$nik = $this->session->userdata('nik');
			// $dept = $this->pa_model->get_departemen_bynik($nik);
			if($this->session->userdata('level') == 210){
				$header = $this->pa_model->get_form_bawahan_ss();
			}else{
				$header = $this->pa_model->get_form_bawahan($nik);
			}
			$interval = $this->pa_model->get_nilai(); 
			$data = array(
				'interval' => $interval,
				'header' => $header,
				'nav1' => 1,
				'nav2' => 1
			);
			$this->load->view('home/pa/bawahan.php', $data);
		}
	}

	// function lihatBawahanSOH(){
	// 	if ($this->hasSession()){
	// 		$nik = $this->session->userdata('nik');
	// 		// $dept = $this->pa_model->get_departemen_bynik($nik);
	// 		if($this->session->userdata('level') == 210){
	// 			$header = $this->pa_model->get_form_bawahan_ss();
	// 		}else{
	// 			$header = $this->pa_model->get_form_bawahan($nik);
	// 		}
	// 		$interval = $this->pa_model->get_nilai(); 
	// 		$data = array(
	// 			'interval' => $interval,
	// 			'header' => $header,
	// 			'nav1' => 1,
	// 			'nav2' => 1
	// 		);
	// 		$this->load->view('home/pa/bawahan_SOH.php', $data);
	// 	}
	// }

	function lihatBawahanhrsoh(){
		$cabang = $this->input->post('cabang');
		$header = $this->pa_model->get_pa_hrdsoh($cabang);
		$interval = $this->pa_model->get_nilai(); 
			$data = array(
				'interval' => $interval,
				'header' => $header,
				'nav1' => 1,
				'nav2' => 1
			);
	}

	function lihatBawahanByIT(){
		if($this->hasSession()){
			$bulan1 = $this->input->post('bulan1');
			$tahun1 = $this->input->post('tahun1');
			$bulan2 = $this->input->post('bulan2');
			$tahun2 = $this->input->post('tahun2');
			$jenis_pa = $this->input->post('jenis_pa');
			if ($bulan1 == null && $tahun1 == null && $bulan2 == null && $tahun2 == null) {
				if (date('m') == '01' || date('m') == '02' || date('m') == '03' || date('m') == '04' || date('m') == '05' || date('m') == '06') {
					$bln1 = '07';
					$thn1 = date('Y') -1;
					$bln2 = '12';
					$thn2 = date('Y') -1;
				}elseif(date('m') == '07' || date('m') == '08' || date('m') == '09' || date('m') == '10' || date('m') == '11' || date('m') == '12'){
					$bln1 = '01';
					$thn1 = date('Y');
					$bln2 = '06';
					$thn2 = date('Y');
				}
			}
			else{
				$bln1 = $bulan1;
				$thn1 = $tahun1;
				$bln2 = $bulan2;
				$thn2 = $tahun2;			
			}
			$header = $this->pa_model->get_form_bawahan_byit($bln1, $thn1, $bln2, $thn2, $jenis_pa);
			$interval = $this->pa_model->get_nilai(); 
			$data = array(
				'jenis_pa' => $jenis_pa,
				'interval' => $interval,
				'header' => $header,
				'bulan1' => $bln1,
				'tahun1' => $thn1,
				'bulan2' => $bln2,
				'tahun2' => $thn2,
				'nav1' => 1,
				'nav2' => 5
			);
			$this->load->view('home/pa/bawahan_byit.php', $data);
		}
	}

	function lihatDetailBawahan(){
		if ($this->hasSession()){
			$kode_pa = $this->uri->segment(3);
			$header = $this->pa_model->get_data_header($kode_pa);
			$detail = $this->pa_model->get_detail($kode_pa);
			$isi_det = $this->pa_model->isi_detail($kode_pa);
			$jml_det = $this->pa_model->jml_detail($kode_pa);			
			$nilai = $this->pa_model->get_rata_rata($kode_pa);
			$cekAtasanSOH = $this->pa_model->cekAtasanSOH($kode_pa);
			$atasan = $cekAtasanSOH;
			// $atasan = $this->pa_model->cek_atasan($header[0]->nik);
			$cek_dept = $this->pa_model->cek_dept($header[0]->nik);
			$cek_manager = $this->pa_model->cek_manager($cek_dept[0]->departemen);
			$karyawan = $this->pa_model->tb_mskaryawan($header[0]->nik);
			
			$data = array(
				'nilai'	=> $nilai,
				'header' => $header,
				'detail' => $detail,
				'kode_pa' => $kode_pa,
				'isi' => $isi_det,
				'jml' => $jml_det,
				'karyawan'=> $karyawan,
				'atasan' => $atasan,
				'manager' => $cek_manager,
				'nav1' => 1,
				'nav2' => 1
			);
			$this->load->view('home/pa/detail_bawahan.php', $data);
		}
	}

	function lihatDetailBawahanDept(){
		if ($this->hasSession()){
			$kode_pa = $this->uri->segment(3);
			$header = $this->pa_model->get_data_header($kode_pa);
			$detail = $this->pa_model->get_detail($kode_pa);
			$isi_det = $this->pa_model->isi_detail($kode_pa);
			$jml_det = $this->pa_model->jml_detail($kode_pa);		
			$nilai = $this->pa_model->get_rata_rata($kode_pa);
			$cek_dept = $this->pa_model->cek_dept($header[0]->nik);
			$cek_manager = $this->pa_model->cek_manager($cek_dept[0]->departemen);
			$status_ss = $this->pa_model->cekSS($header[0]->nik);
			$bod_dept = $this->pa_model->cek_bod_dept($this->session->userdata('nik'));
			// var_dump($header[0]->user_input .' '.$this->session->userdata('nik'));die();
			$data = array(
				'nilai' => $nilai,
				'bod_dept' => $bod_dept,
				'header' => $header,
				'detail' => $detail,
				'status_ss' => $status_ss,
				'kode_pa' => $kode_pa,
				'isi' => $isi_det,
				'jml' => $jml_det,
				'manager' => $cek_manager,
				'nav1' => 1,
				'nav2' => 8
			);
			$this->load->view('home/pa/lihat_detail_karyawan_dept.php', $data);
		}
	}

	

	function lihatDetailBawahanDept2(){
		if ($this->hasSession()){
			$kode_pa = $this->uri->segment(3);
			$header = $this->pa_model->get_data_header($kode_pa);
			$detail = $this->pa_model->get_detail($kode_pa);
			$isi_det = $this->pa_model->isi_detail($kode_pa);
			$jml_det = $this->pa_model->jml_detail($kode_pa);		
			$nilai = $this->pa_model->get_rata_rata($kode_pa);
			$cek_dept = $this->pa_model->cek_dept($header[0]->nik);
			$cek_manager = $this->pa_model->cek_manager($cek_dept[0]->departemen);
			$bod_dept = $this->pa_model->cek_bod_dept($this->session->userdata('nik'));
			// var_dump($header[0]->user_input .' '.$this->session->userdata('nik'));die();
			$data = array(
				'nilai' => $nilai,
				'bod_dept' => $bod_dept,
				'header' => $header,
				'detail' => $detail,
				'kode_pa' => $kode_pa,
				'isi' => $isi_det,
				'jml' => $jml_det,
				'manager' => $cek_manager,
				'nav1' => 1,
				'nav2' => 8
			);
			$this->load->view('home/pa/lihat_detail_karyawan_dept_depan.php', $data);
		}
	}

	function lihatAllKaryawan(){
		if ($this->hasSession()){
			$bulan1 = $this->input->post('bulan1');
			$tahun1 = $this->input->post('tahun1');
			$bulan2 = $this->input->post('bulan2');
			$tahun2 = $this->input->post('tahun2');
			$jenis_pa = $this->input->post('jenis_pa');
			$cabang = $this->input->post('cabang');
			// var_dump($cabang);die();
			$bod = $this->input->post('bod');
			if ($bulan1 == null && $tahun1 == null && $bulan2 == null && $tahun2 == null) {
				if (date('m') == '01' || date('m') == '02' || date('m') == '03' || date('m') == '04' || date('m') == '05' || date('m') == '06') {
					$bln1 = '07';
					$thn1 = date('Y') -1;
					$bln2 = '12';
					$thn2 = date('Y') -1;
				}elseif(date('m') == '07' || date('m') == '08' || date('m') == '09' || date('m') == '10' || date('m') == '11' || date('m') == '12'){
					$bln1 = '01';
					$thn1 = date('Y');
					$bln2 = '06';
					$thn2 = date('Y');
				}
			}
			else{
				$bln1 = $bulan1;
				$thn1 = $tahun1;
				$bln2 = $bulan2;
				$thn2 = $tahun2;			
			}
			$header = $this->pa_model->get_form_all_karyawan_tohr($bln1, $thn1, $bln2, $thn2, $bod, $jenis_pa, $cabang);
			$interval = $this->pa_model->get_nilai(); 
			$cabang_nama = $this->pa_model->get_cab();
			$data = array(
				'jenis_pa' 	=> $jenis_pa,
				'interval' 	=> $interval,
				'header' 	=> $header,
				'cabs'		=> $cabang,
				'cabang'	=> $cabang_nama,
				'bulan1' 	=> $bln1,
				'tahun1' 	=> $thn1,
				'bulan2' 	=> $bln2,
				'tahun2' 	=> $thn2,
				'bod' 		=> $bod,
				'nav1' 		=> 2,
				'nav2' 		=> 2
			);
			$this->load->view('home/pa/all_karyawan.php', $data);
		}
	}

	function lihatAllKaryawan2(){
		if ($this->hasSession()){
			$bulan1 = $this->input->post('bulan1');
			$tahun1 = $this->input->post('tahun1');
			$bulan2 = $this->input->post('bulan2');
			$tahun2 = $this->input->post('tahun2');
			$jenis_pa = $this->input->post('jenis_pa');
			// $bod = $this->input->post('bod');
			if ($bulan1 == null && $tahun1 == null && $bulan2 == null && $tahun2 == null) {
				if (date('m') == '01' || date('m') == '02' || date('m') == '03' || date('m') == '04' || date('m') == '05' || date('m') == '06') {
					$bln1 = '07';
					$thn1 = date('Y') -1;
					$bln2 = '12';
					$thn2 = date('Y') -1;
				}elseif(date('m') == '07' || date('m') == '08' || date('m') == '09' || date('m') == '10' || date('m') == '11' || date('m') == '12'){
					$bln1 = '01';
					$thn1 = date('Y');
					$bln2 = '06';
					$thn2 = date('Y');
				}
			}
			else{
				$bln1 = $bulan1;
				$thn1 = $tahun1;
				$bln2 = $bulan2;
				$thn2 = $tahun2;	
			}
			$interval = $this->pa_model->get_nilai(); 
			// $header = $this->pa_model->get_form_all_karyawan($bln1, $thn1, $bln2, $thn2, $bod, $jenis_pa);
			$header = $this->pa_model->get_form_all_karyawan($bln1, $thn1, $bln2, $thn2, $jenis_pa);
			$data = array(
				'jenis_pa' => $jenis_pa,
				'interval' => $interval,
				'header' => $header,
				'bulan1' => $bln1,
				'tahun1' => $thn1,
				'bulan2' => $bln2,
				'tahun2' => $thn2,
				'bod' => $bod,
				'nav1' => 2,
				'nav2' => 3
			);
			$this->load->view('home/pa/all_karyawan2.php', $data);
		}
	}

	function lihatDetailKaryawan(){
		if ($this->hasSession()) {
			$kode_pa = $this->uri->segment(3);
			$header = $this->pa_model->get_data_header($kode_pa);
			$detail = $this->pa_model->get_detail($kode_pa);
			$nilai = $this->pa_model->get_rata_rata($kode_pa);
			$check_nilai = $this->pa_model->get_check_nilai($nilai[0]->rata_rata);			
			$cek_dept = $this->pa_model->cek_dept($header[0]->nik);
			$manager = $this->pa_model->cek_manager($cek_dept[0]->departemen);
			$data = array(
				'manager'	=> $manager,
				'check_nilai' => $check_nilai,
				'nilai' => $nilai,
				'header' => $header,
				'detail' => $detail,
				'kode_pa' => $kode_pa,
				'nav1' => 2,
				'nav2' => 2
			);
			$this->load->view('home/pa/lihat_detail_karyawan.php', $data);
		}
	}
	
	function lihatDetailKaryawanKPI(){
		if ($this->hasSession()) {
			$kode_pa = $this->uri->segment(3);
			$header = $this->pa_model->get_data_header($kode_pa);
			$detail = $this->pa_model->get_detail($kode_pa);
			$nilai = $this->pa_model->get_rata_rata($kode_pa);
			$check_nilai = $this->pa_model->get_check_nilai($nilai[0]->rata_rata);			
			$cek_dept = $this->pa_model->cek_dept($header[0]->nik);
			$manager = $this->pa_model->cek_manager($cek_dept[0]->departemen);
			$data = array(
				'manager'	=> $manager,
				'check_nilai' => $check_nilai,
				'nilai' => $nilai,
				'header' => $header,
				'detail' => $detail,
				'kode_pa' => $kode_pa,
				'nav1' => 2,
				'nav2' => 2
			);
			$this->load->view('home/pa/lihat_detail_karyawan_kpi.php', $data);
		}
	}

	function lihatDetailKaryawan2(){
		if ($this->hasSession()){
			$kode_pa = $this->uri->segment(3);
			$header = $this->pa_model->get_data_header($kode_pa);
			$detail = $this->pa_model->get_detail($kode_pa);
			$nilai = $this->pa_model->get_rata_rata($kode_pa);
			$check_nilai = $this->pa_model->get_check_nilai($nilai[0]->rata_rata);
			$auth = $this->pa_model->get_auth_bynik($this->session->userdata('nik'));
			$cek_dept = $this->pa_model->cek_dept($header[0]->nik);
			$manager = $this->pa_model->cek_manager($cek_dept[0]->departemen);
			$data = array(
				'check_nilai' => $check_nilai,
				'nilai' => $nilai,
				'header' => $header,
				'manager' => $manager,
				'detail' => $detail,
				'kode_pa' => $kode_pa,
				'auth'	=> $auth,
				'nav1' => 2,
				'nav2' => 3
			);
			$this->load->view('home/pa/lihat_detail_karyawan2.php', $data);
		}
	}

	function updateAccepted(){
		if ($this->hasSession()){
			$kode_pa = $this->uri->segment(3);
			$timestamp = date('Y-m-d H:i:s');			
			$nilai = $this->pa_model->get_rata_rata($kode_pa);
			$data = array(
				'nilai_ratarata' 	=> $nilai[0]->rata_rata,
				'status'			=> 'ACCEPTED',
				'user_update'		=> $this->session->userdata('nik'),
				'tgl_update'		=> $timestamp
			);
			$where = array(
				'kode_pa'		=> $kode_pa
			);
			if($this->pa_model->update('pacab_formheader', $data, $where)){
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil Accepted Data. Silakan Input nilai KPI pada menu PA & KPI Karyawan.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							    <span aria-hidden="true">&times;</span>
							</button>
						</div>');
				redirect('pa/lihatDetailKaryawan/'.$kode_pa);
			}
		}	
	}

	function updateApproved(){
		if ($this->hasSession()){
			$kode_pa = $this->uri->segment(3);
			$header = $this->pa_model->get_data_header($kode_pa);
			if($header[0]->keterangan == "" OR $header[0]->rekomendasi == ""){
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Gagal Approved ! Silakan cek kembali Rekomendasi & Keterangan pada button RK.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							    <span aria-hidden="true">&times;</span>
							</button>
						</div>');
				echo '<script>javascript:history.go(-1)</script>';
				goto AKHIR;
			}
			$lampiran = $this->pa_model->get_lampiran_pa($kode_pa);
			$file_count = count($lampiran); 
			// if ($file_count == 0) {
			// 	$this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Gagal ! Silakan Masukkan File KPI terlebih dahulu ditombol Lampiran.
			// 				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			// 				    <span aria-hidden="true">&times;</span>
			// 				</button>
			// 			</div>');
			// 	// redirect('pa/lihatDetailBawahanDept/'.$kode_pa);
			// 	echo '<script>javascript:history.go(-1)</script>';
			// 	GOTO AKHIR;
			// }
			$timestamp = date('Y-m-d H:i:s');			
			$nilai = $this->pa_model->get_rata_rata($kode_pa);
			$data = array(
				'nilai_ratarata' 	=> $nilai[0]->rata_rata,
				'status'			=> 'APPROVED',
				'user_update'		=> $this->session->userdata('nik'),
				'tgl_update'		=> $timestamp
			);
			$where = array(
				'kode_pa'		=> $kode_pa
			);
			if($this->pa_model->update('pacab_formheader', $data, $where)){
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil Approved Data.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							    <span aria-hidden="true">&times;</span>
							</button>
						</div>');
				echo '<script>javascript:history.go(-1)</script>';
			}
			AKHIR:
		}	
	}

	function laporanSummary(){
		if ($this->hasSession()){
			$tahun = $this->pa_model->get_tahun();
			//$dept = $this->pa_model->get_departemen();
			$cabang = $this->pa_model->get_cab();
			// $nik_karyawan = $this->pa_model->get_nik_karyawan_sudahisi();
			$nik_karyawan = $this->pa_model->get_nik_karyawan_sudahisi2hrd();
			$data = array(
				'nik_karyawan' => $nik_karyawan,
				'tahun' => $tahun,
				'cabang' => $cabang,
				//'dept' => $dept,
				'nav1' => 3,
				'nav2' => 7
			);
			$this->load->view('home/pa/cari.php', $data);
		}
	}

	function detailSummary(){
		if ($this->hasSession()){
			$jenis_pa = $this->input->get('jenis_pa');
			$tahun = $this->input->get('tahun');
			$cabang = $this->input->get('cabang');
			$summary = $this->pa_model->get_summary($jenis_pa, $tahun, $cabang);
			// var_dump($summary[0]->nilai_ratarata.' '.$summary[0]->nilai_kpi);die();
			$data = array(
				'tahun' => $tahun,
				'jenis' => $jenis_pa,
				'summary' => $summary,
				'cabang'	=> $cabang,
				'nav1' => 3,
				'nav2' => 7
			);
			$this->load->view('home/pa/summary.php', $data);			
		}
	}

	function summaryLine(){
		if ($this->hasSession()){
			$nik = $this->input->get('nik');
			$jenis_pa = $this->input->get('jenis_pa');
			$chart = $this->input->get('chart');
			$nilai_x = $this->pa_model->get_nilai_grafik_x($nik, $jenis_pa);			
			$nilai_y = $this->pa_model->get_nilai_grafik_y($nik, $jenis_pa);
			$data = array(
				'chart'	=> $chart,
				'nilai_x' => $nilai_x,
				'nilai_y' => $nilai_y,
				'nav1' => 3,
				'nav2' => 7
			);
			$this->load->view('home/pa/grafik.php', $data);			
		}
	}

	function simpanRK(){
		if($this->hasSession()){
			$kode_pa = $this->input->post('kode_pa');
			$header = $this->pa_model->get_data_header($kode_pa);
			$rekomendasi = $this->input->post('rekomendasi');
			$keterangan = $this->input->post('keterangan');
			$timestamp = date('Y-m-d H:i:s');
			$nik = $this->session->userdata('nik');
			$dept = $this->input->post('dept');
			$data = array(
				'rekomendasi'		=> $rekomendasi,
				'keterangan'		=> $keterangan,
				'user_update'		=> $nik,
				'tgl_update'		=> $timestamp
			);			
			$where = array(
				'kode_pa'			=> $kode_pa
			);
			$this->pa_model->update('pacab_formheader', $data, $where);
			$this->session->set_flashdata('msg', 
						'<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil Simpan Data.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>');
			if ($dept == null) {
				redirect('pa/lihatDetailBawahan/'.$kode_pa);
			}elseif($dept == 1){
				redirect('pa/lihatDetailBawahanDept/'.$kode_pa);
			}elseif($dept == 2){
				redirect('pa/lihatDetailBawahanDept2/'.$kode_pa);
			}
		}
	}

	function revisiRK(){
		if($this->hasSession()){
			$kode_pa = $this->input->post('kode_pa');		
			$timestamp = date('Y-m-d H:i:s');
			$nik = $this->session->userdata('nik');
			$data = array(
				'status'		 => 'REVISI',
				'user_update'    => $nik,
				'tgl_update'     => $timestamp
			);
			$where = array(
				'kode_pa'		=> $kode_pa
			);
			$this->pa_model->update('pacab_formheader', $data, $where);
			$this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil Simpan Revisi Rekomendasi & Keterangan! Revisi akan dilakukan oleh Atasan user.
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
													</div>');
				redirect('pa/lihatDetailBawahanDept2/'.$kode_pa);	
		}
	}

	function revisiAll(){
		if ($this->hasSession()){
			$kode_pa = $this->input->post('kode_pa');
			$timestamp = date('Y-m-d H:i:s');
			$nik = $this->session->userdata('nik');
			$data = array(
				'status'  			=> 'PROCESS',
				'user_update'	    => $nik,
				'tgl_update'	    => $timestamp
			);
			$where = array(
				'kode_pa'			=> $kode_pa
			);
			$this->pa_model->update('pacab_formheader', $data, $where);
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil Mengirim Revisi Data.
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>');
			redirect('pa/lihatAllKaryawan2');
		}
	}

	function updateKomentarNilai(){
		if ($this->hasSession()){
			$faktor = $this->input->post('faktor');
			$kode_pa = $this->input->post('kode_pa');
			$ket_atasan = $this->input->post('ket_atasan');	
			$dept = $this->input->post('dept');
			$timestamp = date('Y-m-d H:i:s');
			$nik = $this->session->userdata('nik');
			$data = array(
				'ket_atasan'	=>	$ket_atasan,
				'user_update'	=>	$nik,
				'tgl_update'	=>	$timestamp
			);
			$where = array(
				'faktor'	=> $faktor,
				'kode_pa'	=> $kode_pa
			);
			$this->pa_model->update('pacab_formdetail', $data, $where);
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil kirim keterangan!
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>');
			if ($dept == null) {
				redirect('pa/lihatDetailBawahan/'.$kode_pa);
			}else{
				redirect('pa/lihatDetailBawahanDept/'.$kode_pa);
			}
				
		}else{
			redirect('logout/sessionEnd');
		}
	}

	function lihatBawahanByHead(){
		if ($this->hasSession()){
			$bulan1 = $this->input->post('bulan1');
			$tahun1 = $this->input->post('tahun1');
			$bulan2 = $this->input->post('bulan2');
			$tahun2 = $this->input->post('tahun2');
			$jenis_pa = $this->input->post('jenis_pa');
			// $cabang = $this->input->post('cabang');
			if ($bulan1 == null && $tahun1 == null && $bulan2 == null && $tahun2 == null) {
				if (date('m') == '01' || date('m') == '02' || date('m') == '03' || date('m') == '04' || date('m') == '05' || date('m') == '06') {
					$bln1 = '07';
					$thn1 = date('Y') -1;
					$bln2 = '12';
					$thn2 = date('Y') -1;
				}elseif(date('m') == '07' || date('m') == '08' || date('m') == '09' || date('m') == '10' || date('m') == '11' || date('m') == '12'){
					$bln1 = '01';
					$thn1 = date('Y');
					$bln2 = '06';
					$thn2 = date('Y');
				}
			}
			else{
				$bln1 = $bulan1;
				$thn1 = $tahun1;
				$bln2 = $bulan2;
				$thn2 = $tahun2;			
			}
			$header = $this->pa_model->get_form_bawahan_bysoh($bln1, $thn1, $bln2, $thn2, $jenis_pa);
			$interval = $this->pa_model->get_nilai(); 
			$data = array(
				'jenis_pa' => $jenis_pa,
				'interval' => $interval,
				'header' => $header,
				'bulan1' => $bln1,
				'tahun1' => $thn1,
				'bulan2' => $bln2,
				'tahun2' => $thn2,
				'nav1' => 1,
				'nav2' => 8
			);
			// var_dump($data['jenis_pa']);die();
			$this->load->view('home/pa/bawahan_byhead.php', $data);
		}
	}

	function lihatBawahanByHead2($kd_jenis, $cabang){
		if ($this->hasSession()){
			$bulan1 = $this->input->post('bulan1');
			$tahun1 = $this->input->post('tahun1');
			$bulan2 = $this->input->post('bulan2');
			$tahun2 = $this->input->post('tahun2');
			// $jenis_pa = $this->input->post('jenis_pa');
			// $cabang = $this->input->post('cabang');
			// $cabang = $this->input->post('cabang');
			// var_dump($kd_jenis.' '.$cabang);die();
			if ($bulan1 == null && $tahun1 == null && $bulan2 == null && $tahun2 == null) {
				if (date('m') == '01' || date('m') == '02' || date('m') == '03' || date('m') == '04' || date('m') == '05' || date('m') == '06') {
					$bln1 = '07';
					$thn1 = date('Y') -1;
					$bln2 = '12';
					$thn2 = date('Y') -1;
				}elseif(date('m') == '07' || date('m') == '08' || date('m') == '09' || date('m') == '10' || date('m') == '11' || date('m') == '12'){
					$bln1 = '01';
					$thn1 = date('Y');
					$bln2 = '06';
					$thn2 = date('Y');
				}
			}
			else{
				$bln1 = $bulan1;
				$thn1 = $tahun1;
				$bln2 = $bulan2;
				$thn2 = $tahun2;			
			}
			$header = $this->pa_model->get_form_bawahan_bysoh2($bln1, $thn1, $bln2, $thn2, $cabang, $kd_jenis);
			$interval = $this->pa_model->get_nilai(); 
			$data = array(
				// 'jenis_pa' => $jenis_pa,
				'interval' => $interval,
				'header' => $header,
				'bulan1' => $bln1,
				'tahun1' => $thn1,
				'bulan2' => $bln2,
				'tahun2' => $thn2,
				'nav1' => 1,
				'nav2' => 8
			);
			
			// var_dump($data['jenis_pa']);die();
			$this->load->view('home/pa/bawahan_byhead2.php', $data);
		}
	}

	function updateAssesment(){
		if ($this->hasSession()){
			$kode_pa = $this->uri->segment(3);
			$cariSOH = $this->pa_model->cekAtasanSOH($kode_pa);
			$header = $this->pa_model->get_data_header($kode_pa);
			$detail = $this->pa_model->get_data_detail($kode_pa);
			$lampiran = $this->pa_model->get_lampiran_pa($kode_pa);
			$timestamp = date('Y-m-d H:i:s');
			$kd_pa = $this->generateKodePeserta2($kode_pa);

			$data = array(
				'kode_pa'			=> $kd_pa,
				'jenis_pa'			=> $header[0]->jenis_pa,
				'kode_cabang'		=> $header[0]->kode_cabang,
				'nama'              => $header[0]->nama,
				'nik'               => $header[0]->nik,
				'jabatan'           => $header[0]->jabatan,
				'status_karyawan'   => $header[0]->status_karyawan,
				'tgl_gabung'        => $header[0]->tgl_gabung,
				'tgl_penilaian'     => $header[0]->tgl_penilaian,
				'tgl_periode2'	    => $header[0]->tgl_periode2,
				'periode'			=> $header[0]->periode,
				'tujuan_penilaian'  => $header[0]->tujuan_penilaian,
				'nilai_ratarata'	=> $header[0]->nilai_ratarata,
				'nilai_kpi'			=> $header[0]->nilai_kpi,
				'rekomendasi'		=> $header[0]->rekomendasi,
				'keterangan'		=> $header[0]->keterangan,
				'status'		    => 'PROCESS',
				'user_input'        => $this->session->userdata('nik'),
				'tgl_input'         => $timestamp,
				'user_update'		=> $this->session->userdata('nik'),
				'tgl_update'		=> $timestamp
			);
			if($this->pa_model->insert('pacab_formheader', $data)){
				$count = count($detail);
				for ($i=0; $i < $count; $i++){
					$data = array(
						'kode_pa'		=> $kd_pa,
						'nik'			=> $detail[$i]->nik,
						'nama'			=> $detail[$i]->nama,
						'faktor'        => $detail[$i]->faktor,
						'kategori'		=> $detail[$i]->kategori,
						'ket_atasan'	=> $detail[$i]->ket_atasan,
						'nilai'			=> $detail[$i]->nilai,
						'skor'			=> $detail[$i]->skor,
						'user_input'    => $detail[$i]->nik,
						'tgl_input'     => $timestamp
					);
					$this->pa_model->insert('pacab_formdetail', $data);
				}
			}

			$dataa = array(
				'kd_jenis' 	=> $kd_pa,
				'nik' 		=> $header[0]->nik,
				'cabang' 	=> $header[0]->kode_cabang,
				'soh' 		=> $cariSOH,
			);
			$this->pa_model->insert('pacab_pesertajenis', $dataa);
			
			if(count($lampiran) != 0){
				for ($i=0; $i < count($lampiran); $i++) { 
					$data = array(
						'kode_pa'			=> $kd_pa
					);
					$where = array(
						'kode_file'			=> $lampiran[$i]->kode_file
					);
					$this->pa_model->update('pacab_lampiran', $data, $where);
				}
				
			}
			$data = array(
				'status'		=> 'RE-ASSESMENT',
				'user_update'	=> $this->session->userdata('nik'),
				'tgl_update'	=> $timestamp,
				'ref_kdpa'		=> $kd_pa
			);
			$where = array(
				'kode_pa'		=> $kode_pa
			);
			if($this->pa_model->update('pacab_formheader', $data, $where)){
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil Re-Assesment PA!
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								    <span aria-hidden="true">&times;</span>
								</button>
							</div>');
					echo '<script>javascript:history.go(-1)</script>';
			}
		}
	}

	function lihatAllKaryawanKPI(){
		if ($this->hasSession()) {
			$bulan1 = $this->input->post('bulan1');
			$tahun1 = $this->input->post('tahun1');
			$bulan2 = $this->input->post('bulan2');
			$tahun2 = $this->input->post('tahun2');
			$jenis_pa = $this->input->post('jenis_pa');
			$cabang = $this->input->post('cabang');
			if ($bulan1 == null && $tahun1 == null && $bulan2 == null && $tahun2 == null) {
				if (date('m') == '01' || date('m') == '02' || date('m') == '03' || date('m') == '04' || date('m') == '05' || date('m') == '06') {
					$bln1 = '07';
					$thn1 = date('Y') -1;
					$bln2 = '12';
					$thn2 = date('Y') -1;
				}elseif(date('m') == '07' || date('m') == '08' || date('m') == '09' || date('m') == '10' || date('m') == '11' || date('m') == '12'){
					$bln1 = '01';
					$thn1 = date('Y');
					$bln2 = '06';
					$thn2 = date('Y');
				}
			}
			else{
				$bln1 = $bulan1;
				$thn1 = $tahun1;
				$bln2 = $bulan2;
				$thn2 = $tahun2;	
			}
			//tambahin cabang
			$interval = $this->pa_model->get_nilai(); 
			$header = $this->pa_model->get_form_all_karyawan_kpi($bln1, $thn1, $bln2, $thn2, $jenis_pa, $cabang);
			
			$cabang_nama = $this->pa_model->get_cab();
			$karyawan = $this->pa_model->get_nik_nama_byheader();
			$data = array(
				'jenis_pa'	=> $jenis_pa,
				'karyawan'	=> $karyawan,
				'interval'	=> $interval,
				'header'	=> $header,
				'cabs'		=> $cabang,
				'cabang'	=> $cabang_nama,
				'bulan1' 	=> $bln1,
				'tahun1' 	=> $thn1,
				'bulan2' 	=> $bln2,
				'tahun2' 	=> $thn2,
				'nav1'		=> 2,
				'nav2' 		=> 9
			);
			$this->load->view('home/pa/all_karyawan_kpi.php', $data);
		}
	}

	function simpanNilaiKPI(){
		if ($this->hasSession()) {
			$kode_pa = $this->input->post('kode_pa');
			$nik = $this->input->post('nik');
			$nilai_kpi = $this->input->post('nilai_kpi');
			$timestamp = date('Y-m-d H:i:s');
			$data = array(
				'nilai_kpi'		=>	$nilai_kpi,
				'user_update'	=>	$this->session->userdata('nik'),
				'tgl_update'	=>	$timestamp
			);
			$where = array(
				'nik'		=> $nik,
				'kode_pa'	=> $kode_pa
			);
			$this->pa_model->update('pacab_formheader', $data, $where);
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil Update Nilai KPI kode PA : '.$kode_pa.'.
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								    <span aria-hidden="true">&times;</span>
								</button>
							</div>');
					redirect('pa/lihatAllKaryawanKPI');
		}else{
			redirect('logout/sessionEnd');
		}
	}

	function updateConfirmedDept(){
		if ($this->hasSession()){
			$kode_pa = $this->uri->segment(3);
			$header = $this->pa_model->get_data_header($kode_pa);
			$timestamp = date('Y-m-d H:i:s');			
			$nilai = $this->pa_model->get_rata_rata($kode_pa);
			$lampiran = $this->pa_model->get_lampiran_pa($kode_pa);
			$file_count = count($lampiran); 
			// if ($file_count == 0) {
			// 	$this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Silakan Masukkan File KPI ditombol Lampiran.
			// 				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			// 				    <span aria-hidden="true">&times;</span>
			// 				</button>
			// 			</div>');
			// 	// redirect('pa/lihatDetailBawahanDept/'.$kode_pa);
			// 	echo '<script>javascript:history.go(-1)</script>';
			// 	GOTO AKHIR;
			// }
			if($header[0]->rekomendasi == "" OR $header[0]->keterangan == ""){
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Gagal Confirm ! Silakan isi Rekomendasi & Keterangan pada button RK.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							    <span aria-hidden="true">&times;</span>
							</button>
						</div>');
				echo '<script>javascript:history.go(-1)</script>';
				GOTO AKHIR;
			}
			$data = array(
				'nilai_ratarata' 	=> $nilai[0]->rata_rata,
				'status'			=> 'CONFIRMED SOH',
				'user_update'		=> $this->session->userdata('nik'),
				'tgl_update'		=> $timestamp
			);			
			$where = array(
				'kode_pa'		=> $kode_pa
			);
			if($this->pa_model->update('pacab_formheader', $data, $where)){
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil Confirm Dept Data.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							    <span aria-hidden="true">&times;</span>
							</button>
						</div>');
				echo '<script>javascript:history.go(-1)</script>';
			}
			AKHIR:
		}
	}

	function faktorKategori(){
		if ($this->hasSession()) {
			$fk = $this->pa_model->get_all_fk();
			$data = array(
				'fk'		=> $fk,
				'nav1'		=> 4,
				'nav2' 		=> 10
			);
			$this->load->view('home/pa/faktordankategori.php', $data);
		}else{
			redirect('logout/sessionEnd');
		}
	}

	private function generateKodeFK(){
		$check_kode = $this->pa_model->get_last_fk_today();
		$kode_fk = '';
		if(empty($check_kode)){
			$next = 1;
			$new = sprintf("%03s", $next);
			$kode_fk = $new;
		}else{
			$format = substr($check_kode[0]->kode_fk, -3);
			$next = (int)$format;
			$new = sprintf("%03s", $next+1);
			$kode_fk = $new;
		}
		return $kode_fk;
	}

	function tambahFK(){
		if ($this->hasSession()){
			$kode_fk = $this->generateKodeFK();
			$data = array(
				'kode_fk'		=> $kode_fk,
				'nav1'			=> 4,
				'nav2' 			=> 10
			);
			$this->load->view('home/pa/tambahfaktordankategori.php', $data);
		}else{
			redirect('logout/sessionEnd');
		}
	}

	function simpanFK(){
		if ($this->hasSession()) {
			$kode_fk = $this->input->post('kode_fk');
			$faktor = $this->input->post('faktor');
			$kategori_a = $this->input->post('kategori_a');
			$kategori_b = $this->input->post('kategori_b');
			$kategori_c = $this->input->post('kategori_c');
			$kategori_d = $this->input->post('kategori_d');
			$kategori_e = $this->input->post('kategori_e');
			$level = $this->input->post('level');
			$timestamp = date('Y-m-d H:i:s');
			
			$data = array(
				'kode_fk'		=> $this->generateKodeFK(),
				'faktor'		=> strtoupper($faktor),
				'kategori_a'	=> $kategori_a,
				'kategori_b'	=> $kategori_b,
				'kategori_c'	=> $kategori_c,
				'kategori_d'	=> $kategori_d,
				'kategori_e'	=> $kategori_e,
				'level'			=> $level,
				'user_update'	=> $this->session->userdata('nik'),
				'tgl_update'	=> $timestamp
			);
			if($this->pa_model->insert('pacab_faktordankategori', $data)){
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil tambah faktor dan kategori.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							    <span aria-hidden="true">&times;</span>
							</button>
						</div>');
				redirect('pa/faktorKategori');
			}
		}else{
			redirect('logout/sessionEnd');
		}
	}

	function editFK(){
		if ($this->hasSession()) {
			$kode_fk = $this->uri->segment(3);
			$fk = $this->pa_model->get_fk_bykode($kode_fk);
			$data = array(
				'fk'			=> $fk,
				'kode_fk'		=> $kode_fk,
				'nav1'			=> 4,
				'nav2' 			=> 10
			);
			$this->load->view('home/pa/editfaktordankategori.php', $data);
		}else{
			redirect('logout/sessionEnd');
		}
	}

	function updateFK(){
		if ($this->hasSession()) {
			$kode_fk = $this->input->post('kode_fk');
			$faktor = $this->input->post('faktor');
			$kategori_a = $this->input->post('kategori_a');
			$kategori_b = $this->input->post('kategori_b');
			$kategori_c = $this->input->post('kategori_c');
			$kategori_d = $this->input->post('kategori_d');
			$kategori_e = $this->input->post('kategori_e');
			$level = $this->input->post('level');
			$timestamp = date('Y-m-d H:i:s');

			$data = array(
				'faktor'		=> $faktor,
				'kategori_a'	=> $kategori_a,
				'kategori_b'	=> $kategori_b,
				'kategori_c'	=> $kategori_c,
				'kategori_d'	=> $kategori_d,
				'kategori_e'	=> $kategori_e,
				'level'			=> $level,
				'user_update'	=> $this->session->userdata('nik'),
				'tgl_update'	=> $timestamp
			);
			$where = array(
				'kode_fk'	=> $kode_fk
			);
			if($this->pa_model->update('pacab_faktordankategori', $data, $where)){
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil update faktor dan kategori.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							    <span aria-hidden="true">&times;</span>
							</button>
						</div>');
				redirect('pa/faktorKategori');
			}
		}else{
			redirect('logout/sessionEnd');
		}
	}

	function hapusFK(){
		if ($this->hasSession()) {
			$kode_fk = $this->uri->segment(3);
			
			$where = array (
				'kode_fk'	=> $kode_fk
			);
			if($this->pa_model->delete('pacab_faktordankategori', $where)){
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">Berhasil hapus faktor dan kategori.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							    <span aria-hidden="true">&times;</span>
							</button>
						</div>');
				redirect('pa/faktorKategori');
			}
		}else{
			redirect('logout/sessionEnd');
		}
	}

	function generateKodeFile($kode_pa){
		$check_kode = $this->pa_model->get_last_urut_file($kode_pa);
		$kode_file = '';
		if(empty($check_kode)){
			$next = 1;
			$new = sprintf("%02s", $next);
			$kode_file = $kode_pa.$new;
		}else{
			$format = substr($check_kode[0]->kode_file, -2);
			$next = (int)$format;
			$new = sprintf("%02s", $next+1);
			$kode_file = $kode_pa.$new;
		}
		return $kode_file;
	}

	function lampiranPA(){
		if($this->hasSession()){
			$kode_pa = $this->uri->segment(3);
			$kode_file = $this->uri->segment(4);
			if ($kode_file != '') {
				$detail_file = $this->pa_model->get_det_lampiran($kode_file);
			}else{
				$detail_file = '';
			}
			$header = $this->pa_model->get_data_header($kode_pa);
			$atasan = $this->pa_model->cek_atasan($header[0]->nik);
			$dept = $this->pa_model->cek_dept($header[0]->nik);
			$manager = $this->pa_model->cek_manager($dept[0]->departemen);
			$lampiran_pa = $this->pa_model->get_lampiran_pa($kode_pa);
			// membuat folder nik
			if($path_file=''){}else{
				$path = 'assets/modul_files/';
				$newpath = trim($path.$header[0]->nik);
				if(!is_dir($newpath)){
					mkdir($newpath,0777);
				}
			}
			// membuat folder nik end
			$data = array(
				'manager'		=> $manager,
				'atasan'		=> $atasan,
				'doc_view'		=> $kode_file,
				'detail_file'	=> $detail_file,
				'header'		=> $header,
				'lampiran_pa'	=> $lampiran_pa,
				'kode_pa'		=> $kode_pa,
				'nav1'			=> 0,
				'nav2'			=> 0
			);
			$this->load->view('home/pa/lampiran_pa', $data);
		}else{
			redirect('logout/sessionEnd');
		}
	}

	function uploadLampiran(){
		if($this->hasSession()){
			$kode_pa = $this->uri->segment(3);
			$header = $this->pa_model->get_data_header($kode_pa);
			$data = array(
				'kode_pa'	=> $kode_pa,
				'header'	=> $header,
				'nav1'		=> 0,
				'nav2'		=> 0
			);
			$this->load->view('home/pa/upload_lampiran', $data);
		}else{
			redirect('logout/sessionEnd');
		}
	}

	function simpanUploadFile(){
		if ($this->hasSession()) {
			if(isset($_POST['submit'])){
				$kode_pa = $this->input->post('kode_pa');
				$header = $this->pa_model->get_data_header($kode_pa);
				$kode_file = $this->generateKodeFile($kode_pa);
				$judul_file = $this->input->post('judul_file');
				$jenis_file = $this->input->post('jenis_file');
				$timestamp = date('Y-m-d H:i:s');
				$ukuran_file = $_FILES['path_file'] ['size'];
				$tipe_file = $_FILES['path_file']['type'];

				if ($tipe_file != 'application/pdf') { // cek kalau formatnya bukan pdf
					$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">
						Gagal Upload! Jenis file harus format .pdf 
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									    <span aria-hidden="true">&times;</span>
									</button>
								</div>');
					redirect('pa/uploadLampiran/'. $kode_pa);
				}
				if ($ukuran_file < 10240) { // KB to Bytes in binary
					$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">
						Gagal Upload! Ukuran File Terlalu Kecil.
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									    <span aria-hidden="true">&times;</span>
									</button>
								</div>');
					redirect('pa/uploadLampiran/'. $kode_pa);
				}
				if ($ukuran_file > 1048576) { // MB to Bytes in binary
					$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">
						Gagal Upload! Ukuran File Terlalu Besar.
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									    <span aria-hidden="true">&times;</span>
									</button>
								</div>');
					redirect('pa/uploadLampiran/'. $kode_pa);
				}
				$nama = basename($_FILES['path_file'] ['name']);
				$newpath = 'assets/modul_files/'.$header[0]->nik;
				$path = trim($newpath);
				$link_path = $path;
				$new_name = date('Ym').'_'.$kode_file.'_'.$nama;
				
				$config['file_name']        = $new_name;
	        	$config['remove_spaces']	= TRUE; //mengganti spasi
				$config['upload_path']		= $link_path; //target
				$config['allowed_types'] 	='pdf';

				$this->upload->initialize($config);
				$this->load->library('upload',$config);
				if(!$this->upload->do_upload('path_file')){
					$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">
						Gagal Upload!
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									    <span aria-hidden="true">&times;</span>
									</button>
								</div>');
					redirect('pa/uploadLampiran/'. $kode_pa);
				}else{
					$path_file = $this->upload->data('file_name');
				}
				$data = array(
					'kode_pa'			=> $kode_pa,
					'kode_file'			=> $kode_file,
					'judul_file'		=> $judul_file,
					'jenis_file'		=> $jenis_file,
					'ukuran_file'		=> $ukuran_file,
					'path_file'			=> $path_file,
					'download'			=> 'N',
					'user_input'		=> $this->session->userdata('nik'),
					'tgl_input'			=> $timestamp
				);
				if($this->pa_model->insert('pacab_lampiran', $data)){
					$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">
						Berhasil Upload Dokumen '.$nama_file.'!
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									    <span aria-hidden="true">&times;</span>
									</button>
								</div>');
					redirect('pa/lampiranPA/'.$kode_pa);
				}
			}
		}else{
			redirect('logout/sessionEnd');
		}
	}

	function hapusDetailFile(){
		if ($this->hasSession()) {
			$kode_pa = $this->uri->segment(3);
			$kode_file = $this->uri->segment(4);

			$data = array(
				'is_delete'		=> 'Y',
				'user_hapus'	=> $this->session->userdata('nik'),
				'tgl_hapus'		=> date('Y-m-d H:i:s')
			);

			$where = array(
				'kode_pa' 		=> $kode_pa,
				'kode_file'		=> $kode_file
			);
			if ($this->pa_model->update('pacab_lampiran', $data, $where)) {
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">
						Berhasil Hapus File.
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									    <span aria-hidden="true">&times;</span>
									</button>
								</div>');
					redirect('pa/lampiranPA/'.$kode_pa);
			}

		}else{
			redirect('logout/sessionEnd');
		}
	}

	function DeptSuperlevel(){
		if ($this->hasSession()) {
			$super_level = $this->pa_model->get_superlevel();
			$data = array(
				'super_level'	=> $super_level,
				'nav1'			=> 4,
				'nav2' 			=> 11
			);
			$this->load->view('home/pa/dept_super_level.php', $data);		
		}else{
			redirect('logout/sessionEnd');
		}
	}

	function cabangSOH($kd_jenis){
		if ($this->hasSession()){
			$header = $this->pa_model->cabangSOH($kd_jenis);
			$data = [
				'header' => $header,
				'nav1' 	 => 0,
				'nav2'	 => 0,
			];
			$this->load->view('home/cabang_soh', $data);
		}
	}

	function cabangHRD($kd_jenis){

		if ($this->hasSession()){
			$header = $this->pa_model->cabangHRD($kd_jenis);
			$data = [
				'header' => $header,
				'nav1' 	 => 0,
				'nav2'	 => 0,
			];
			$this->load->view('home/cabang_hrd', $data);
		}
	}


}
?>