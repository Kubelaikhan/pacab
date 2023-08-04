<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pa_model extends CI_Model
{
	
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}

	function get_form_header($nik){ // buat user
		return $this->db->query("SELECT * FROM pacab_formheader WHERE nik ='$nik' AND is_delete = 'N' ORDER BY tgl_input DESC")->result();
	}

	function get_form_msjenis(){
		return $this->db->query("SELECT * FROM pacab_msjenis ORDER BY tgl_input DESC")->result();
	}

	function get_form_bawahan($nik){ //buat atasan
		$bod_dept = $this->cek_bod_dept($this->session->userdata('nik'));
		if ($bod_dept == 1) {
			return $this->db->query("SELECT a.* FROM pacab_formheader a LEFT JOIN mskaryawan b ON a.nik = b.nik WHERE atasan ='$nik' AND is_delete = 'N' AND nilai_ratarata != 0 AND level ='130' ORDER BY tgl_input DESC")->result();
		}else{
			// return $this->db->query("SELECT a.*
			// 				FROM pacab_formheader a LEFT JOIN mskaryawan b ON a.nik = b.nik WHERE atasan ='$nik' AND is_delete = 'N' AND nilai_ratarata != 0 ORDER BY tgl_input DESC")->result();
			return $this->db->query("SELECT a.* 
			FROM pacab_formheader a 
				LEFT JOIN mskaryawan b 
					ON a.nik = b.nik 
				LEFT JOIN pacab_pesertajenis c
					ON a.kode_pa = c.kd_jenis
				WHERE b.level ='210' 
					AND c.soh = '$nik'
					AND is_delete = 'N' 
					AND nilai_ratarata != 0 
				ORDER BY tgl_input DESC
			")->result();
		}
	}

	function get_form_bawahan_ss(){
		$cabang = $this->session->userdata("cabang");
		$nik = $this->session->userdata("nik");
		// return $this->db->query("SELECT a.* from pacab_formheader a left join mskaryawan b ON a.kode_cabang = b.kode_cabang 
		// 						where a.kode_cabang = '$cabang' AND is_delete = 'N' AND nilai_ratarata != 0 AND level ='240' GROUP BY kode_pa
		// 						ORDER BY tgl_input DESC ")->result();

		// -- AND b.level = '240'
		// return $this->db->query("SELECT a.*
		// FROM pacab_formheader a
		// LEFT JOIN mskaryawan b ON b.kode_cabang = a.kode_cabang 
		// AND b.level IN('240','220','230')
		// WHERE a.kode_cabang = '$cabang' 
		// 	AND a.is_delete = 'N' 
		// 	AND a.nik != '$nik'
		// 	AND a.nilai_ratarata != 0
		// 	AND (b.level IS NULL OR b.level IN ('220','230','240')
		// GROUP BY a.kode_pa ORDER BY tgl_input ")->result();

		return $this->db->query("SELECT a.*
		FROM pacab_formheader a
			LEFT JOIN mskaryawan b ON b.kode_cabang = a.kode_cabang AND b.level IN ('240', '220', '230')
		WHERE a.kode_cabang = '$cabang' 
			AND a.is_delete = 'N' 
			AND a.nik != '$nik'
			AND a.nilai_ratarata != 0
			AND (b.level IS NULL OR b.level IN ('240', '220', '230'))
		GROUP BY a.kode_pa 
		ORDER BY tgl_input")->result();
	}

	function get_form_bawahan_byit($bln1, $thn1, $bln2, $thn2, $jenis_pa){ //buat it bawahan
		$tgl_dari = $thn1.'-'.$bln1.'-01';
		$tgl_smp = $thn2.'-'.$bln2.'-01';
		$tgl_smp1 = date('Y-m-d', strtotime('+1 month', strtotime($tgl_smp)));
		$tgl_sampai = date('Y-m-d', strtotime('-1 days', strtotime($tgl_smp1)));
		if (substr($jenis_pa,0,1) == 'S' && $jenis_pa != 'ALL' && $jenis_pa != '') {
			$jenis = "AND substr(jenis_pa,1,1) = 'S'";
		}elseif(substr($jenis_pa,0,1) != 'S' && $jenis_pa != 'ALL' && $jenis_pa != ''){
			$jenis = "AND substr(jenis_pa,1,1) != 'S'";
		}else{
			$jenis = "";
		}
		return $this->db->query("SELECT a.*, c.inisial AS departemen FROM pacab_formheader a LEFT JOIN mskaryawan b ON a.nik = b.nik LEFT JOIN msdepartemen c ON b.departemen = c.kode_dept WHERE is_delete = 'N' AND a.status = 'PROCESS'  AND nilai_ratarata != 0 AND tgl_periode2 >= '$tgl_dari' AND tgl_periode2 <= '$tgl_sampai' $jenis ORDER BY departemen, jenis_pa, nama, tgl_penilaian DESC")->result();
	}

	 function get_form_bawahan_bysoh($bln1, $thn1, $bln2, $thn2, $jenis_pa){ //buat head dept
		// function get_form_bawahan_bysoh($bln1, $thn1, $bln2, $thn2, $jenis_pa){ //buat SOH
		// $dept = $this->session->userdata('dept');
		$cabang = $this->session->userdata('cabang');
		$nik_login = $this->session->userdata('nik');
		$bod_dept = $this->cek_bod_dept($nik_login);
		$tgl_dari = $thn1.'-'.$bln1.'-01';
		$tgl_smp = $thn2.'-'.$bln2.'-01';
		$tgl_smp1 = date('Y-m-d', strtotime('+1 month', strtotime($tgl_smp)));
		$tgl_sampai = date('Y-m-d', strtotime('-1 days', strtotime($tgl_smp1)));
		if (substr($jenis_pa,0,1) == 'S' && $jenis_pa != 'ALL' && $jenis_pa != '') {
			$jenis = "AND substr(jenis_pa,1,1) = 'S'";
		}elseif(substr($jenis_pa,0,1) != 'S' && $jenis_pa != 'ALL' && $jenis_pa != ''){
			$jenis = "AND substr(jenis_pa,1,1) != 'S'";
		}else{
			$jenis = "";
		}

		if ($bod_dept == 1) {
			return $this->db->query("
				SELECT * FROM (
					SELECT a.*, 
					c.inisial AS departemen 
						FROM pacab_formheader a 
							LEFT JOIN mskaryawan b ON a.nik = b.nik 
							LEFT JOIN msdepartemen c ON b.departemen = c.kode_dept 
					WHERE a.nik IN (SELECT nik 
										FROM bod_sublevel 
										WHERE kd_dept IN (SELECT kd_dept 
															FROM bod_dept 
															WHERE nik ='$nik_login' 
																AND app_type ='PA') 
											AND app_type ='PA') 
						AND a.is_delete ='N' 
						AND a.status IN ('PROCESS','APPROVED') 
						
						UNION ALL

					SELECT a.*, 
						c.inisial AS departemen 
					FROM pacab_formheader a 
						LEFT JOIN mskaryawan b ON a.nik = b.nik 
						LEFT JOIN msdepartemen c ON b.departemen = c.kode_dept 
					WHERE b.departemen IN (SELECT kd_dept 
											FROM bod_dept
											WHERE nik ='$nik_login')
						AND a.is_delete ='N' 
						AND a.status IN ('PROCESS','APPROVED') 
						AND user_input ='$nik_login'

					UNION ALL

					SELECT a.*, 
						c.inisial AS departemen 
					FROM pacab_formheader a 
						LEFT JOIN mskaryawan b ON a.nik = b.nik 
						LEFT JOIN msdepartemen c ON b.departemen = c.kode_dept 
					WHERE b.departemen IN (SELECT kd_dept 
											FROM bod_dept 
											WHERE nik ='$nik_login') 
						AND a.is_delete ='N' 
						AND a.status NOT IN('PROCESS','CONFIRMED') 
						AND nilai_ratarata != 0 
						AND b.level != '130'

					UNION ALL

					SELECT a.*, 
						c.inisial AS departemen 
							FROM pacab_formheader a 
								LEFT JOIN mskaryawan b ON a.nik = b.nik 
								LEFT JOIN msdepartemen c ON b.departemen = c.kode_dept 
						WHERE a.nik IN (SELECT nik 
											FROM mskaryawan 
											WHERE atasan IN (SELECT nik 
																FROM mskaryawan 
																WHERE aktif ='N') 
												AND aktif ='Y')
							AND a.is_delete ='N' 
							AND a.status IN ('PROCESS','APPROVED') 
							AND nilai_ratarata != 0 
							AND b.level != '130'
					) xx
					WHERE tgl_periode2 >= '$tgl_dari' AND tgl_periode2 <= '$tgl_sampai' $jenis GROUP BY kode_pa ORDER BY departemen, jenis_pa, nama, tgl_input DESC")->result();
		}else{
			// if ($dept == '300') { // pak welly
			// 	$departemen = "AND b.departemen IN ('300','310','320')";
			// $cabang = "kode_cabang IN(SELECT cabang FROM pacab_pesertajenis WHERE soh = '$nik')"
			// }elseif($dept == 'A00'){ // pak abid
			// 	$departemen ="AND b.departemen IN ('200','800','A00','A10','A20')";
			// }else{
			// 	$departemen = "AND b.departemen = '$dept'";
			// }
			return $this->db->query("
			SELECT * FROM (
				SELECT a.*, c.inisial AS cabang 
						FROM pacab_formheader a 
						LEFT JOIN mskaryawan b ON a.nik = b.nik 
						LEFT JOIN mscabang c ON b.kode_cabang = c.kode_cabang
				WHERE is_delete = 'N' AND a.status NOT IN('PROCESS','CONFIRMED')
				AND b.kode_cabang IN(SELECT cabang FROM pacab_pesertajenis WHERE soh = '$nik_login')
				AND nilai_ratarata != 0
				AND b.level != '210'
				
				
				UNION ALL 

				SELECT a.*, c.inisial AS cabang 
						FROM pacab_formheader a 
						LEFT JOIN mskaryawan b ON a.nik = b.nik 
						LEFT JOIN mscabang c ON b.kode_cabang = c.kode_cabang
				WHERE is_delete = 'N'
				AND a.status = 'PROCESS'
				AND a.user_input IN (SELECT nik FROM bod_dept WHERE app_type ='PA' GROUP BY nik) 
				AND b.kode_cabang IN(SELECT cabang FROM pacab_pesertajenis WHERE soh = '$nik_login')
				AND nilai_ratarata != 0 


				UNION ALL
				
				SELECT a.*, c.inisial AS cabang 
						FROM pacab_formheader a 
						LEFT JOIN mskaryawan b ON a.nik = b.nik 
						LEFT JOIN mscabang c ON b.kode_cabang = c.kode_cabang
						LEFT JOIN pacab_pesertajenis d ON a.kode_pa = d.kd_jenis
				WHERE is_delete = 'N'
				AND a.status IN ('PROCESS')
				AND b.kode_cabang IN(SELECT cabang FROM pacab_pesertajenis WHERE soh = '$nik_login')
				AND nilai_ratarata != 0 
				AND b.level != '210'
				AND b.kode_cabang NOT IN (
					SELECT kode_cabang
					FROM mskaryawan
					WHERE LEVEL = '210'
				)

				
				UNION ALL 

				SELECT a.*, c.inisial AS cabang 
						FROM pacab_formheader a 
						LEFT JOIN mskaryawan b ON a.nik = b.nik 
						LEFT JOIN mscabang c ON b.kode_cabang = c.kode_cabang 
				WHERE is_delete = 'N'
				AND a.user_input = '$nik_login'
				AND a.nik != '$nik_login'
				AND a.status = 'PROCESS'
				AND b.kode_cabang IN(SELECT cabang FROM pacab_pesertajenis WHERE soh = '$nik_login')
				AND nilai_ratarata != 0 
				
				) xx WHERE tgl_periode2 >= '$tgl_dari' AND tgl_periode2 <= '$tgl_sampai' $jenis
				ORDER BY cabang, jenis_pa, nama, tgl_input DESC")->result();
		}
	}

	function get_form_bawahan_bysoh2($bln1, $thn1, $bln2, $thn2, $cabang, $kd_jenis){ //buat head dept

		$nik_login = $this->session->userdata('nik');
		$bod_dept = $this->cek_bod_dept($nik_login);
		$tgl_dari = $thn1.'-'.$bln1.'-01';
		$tgl_smp = $thn2.'-'.$bln2.'-01';
		$tgl_smp1 = date('Y-m-d', strtotime('+1 month', strtotime($tgl_smp)));
		$tgl_sampai = date('Y-m-d', strtotime('-1 days', strtotime($tgl_smp1)));

		// var_dump($tgl_dari.'-'.$tgl_sampai.' '.$kd_jenis.' '.$cabang)

		if ($bod_dept == 1) {
			return $this->db->query("
				SELECT * FROM (
					SELECT a.*, 
					c.inisial AS departemen 
						FROM pacab_formheader a 
							LEFT JOIN mskaryawan b ON a.nik = b.nik 
							LEFT JOIN msdepartemen c ON b.departemen = c.kode_dept 
					WHERE a.nik IN (SELECT nik 
										FROM bod_sublevel 
										WHERE kd_dept IN (SELECT kd_dept 
															FROM bod_dept 
															WHERE nik ='$nik_login' 
																AND app_type ='PA') 
											AND app_type ='PA') 
						AND a.is_delete ='N' 
						AND a.status IN ('PROCESS','APPROVED') 
						
						UNION ALL

					SELECT a.*, 
						c.inisial AS departemen 
					FROM pacab_formheader a 
						LEFT JOIN mskaryawan b ON a.nik = b.nik 
						LEFT JOIN msdepartemen c ON b.departemen = c.kode_dept 
					WHERE b.departemen IN (SELECT kd_dept 
											FROM bod_dept
											WHERE nik ='$nik_login')
						AND a.is_delete ='N' 
						AND a.status IN ('PROCESS','APPROVED') 
						AND user_input ='$nik_login'

					UNION ALL

					SELECT a.*, 
						c.inisial AS departemen 
					FROM pacab_formheader a 
						LEFT JOIN mskaryawan b ON a.nik = b.nik 
						LEFT JOIN msdepartemen c ON b.departemen = c.kode_dept 
					WHERE b.departemen IN (SELECT kd_dept 
											FROM bod_dept 
											WHERE nik ='$nik_login') 
						AND a.is_delete ='N' 
						AND a.status NOT IN('PROCESS','CONFIRMED') 
						AND nilai_ratarata != 0 
						AND b.level NOT IN ('130', '240', '230', '220')

					UNION ALL

					SELECT a.*, 
						c.inisial AS departemen 
							FROM pacab_formheader a 
								LEFT JOIN mskaryawan b ON a.nik = b.nik 
								LEFT JOIN msdepartemen c ON b.departemen = c.kode_dept 
						WHERE a.nik IN (SELECT nik 
											FROM mskaryawan 
											WHERE atasan IN (SELECT nik 
																FROM mskaryawan 
																WHERE aktif ='N') 
												AND aktif ='Y')
							AND a.is_delete ='N' 
							AND a.status IN ('PROCESS','APPROVED') 
							AND nilai_ratarata != 0 
							AND b.level != '130'
					) xx
					WHERE tgl_periode2 >= '$tgl_dari' AND tgl_periode2 <= '$tgl_sampai' $jenis GROUP BY kode_pa ORDER BY departemen, jenis_pa, nama, tgl_input DESC")->result();
		}else{
			return $this->db->query("
			SELECT * FROM (
				SELECT a.*, c.inisial AS cabang 
						FROM pacab_formheader a 
						LEFT JOIN mskaryawan b ON a.nik = b.nik 
						LEFT JOIN mscabang c ON b.kode_cabang = c.kode_cabang
				WHERE is_delete = 'N' AND a.status NOT IN('PROCESS','CONFIRMED')
				AND b.kode_cabang IN(SELECT cabang FROM pacab_pesertajenis WHERE soh = '$nik_login')
				AND nilai_ratarata != 0
				
				AND SUBSTR(a.kode_pa,1,8)='$kd_jenis'
				
				UNION ALL 

				SELECT a.*, c.inisial AS cabang 
						FROM pacab_formheader a 
						LEFT JOIN mskaryawan b ON a.nik = b.nik 
						LEFT JOIN mscabang c ON b.kode_cabang = c.kode_cabang
				WHERE is_delete = 'N'
				AND a.status = 'PROCESS'
				AND a.user_input IN (SELECT nik FROM bod_dept WHERE app_type ='PA' GROUP BY nik) 
				AND b.kode_cabang IN(SELECT cabang FROM pacab_pesertajenis WHERE soh = '$nik_login')
				AND nilai_ratarata != 0 
				AND SUBSTR(a.kode_pa,1,8)='$kd_jenis'






				UNION ALL
				
				SELECT a.*, c.inisial AS cabang 
						FROM pacab_formheader a 
						LEFT JOIN mskaryawan b ON a.nik = b.nik 
						LEFT JOIN mscabang c ON b.kode_cabang = c.kode_cabang
						LEFT JOIN pacab_pesertajenis d ON a.kode_pa = d.kd_jenis
				WHERE is_delete = 'N'
				AND a.status IN ('PROCESS', 'CONFIRMED')
				AND b.kode_cabang IN(SELECT cabang FROM pacab_pesertajenis WHERE soh = '$nik_login')
				AND nilai_ratarata != 0 
				AND SUBSTR(a.kode_pa,1,8)='$kd_jenis'
				AND b.kode_cabang NOT IN (
					SELECT kode_cabang
					FROM mskaryawan
					WHERE LEVEL = '210'
				)





				
				UNION ALL 

				SELECT a.*, c.inisial AS cabang 
						FROM pacab_formheader a 
						LEFT JOIN mskaryawan b ON a.nik = b.nik 
						LEFT JOIN mscabang c ON b.kode_cabang = c.kode_cabang 
				WHERE is_delete = 'N'
				AND a.user_input = '$nik_login'
				AND a.nik != '$nik_login'
				AND a.status = 'PROCESS'
				AND b.kode_cabang IN(SELECT cabang FROM pacab_pesertajenis WHERE soh = '$nik_login')
				AND nilai_ratarata != 0 
				AND SUBSTR(a.kode_pa,1,8)='$kd_jenis'

				) xx WHERE tgl_periode2 >= '$tgl_dari' AND tgl_periode2 <= '$tgl_sampai' AND  kode_cabang = '$cabang' 
				ORDER BY cabang, jenis_pa, nama, tgl_input DESC")->result();
		}
	}

	function get_form_all_karyawan($bln1, $thn1, $bln2, $thn2, $bod, $jenis_pa){ //buat bod
		$nik_login = $this->session->userdata('nik');
		$tgl_dari = $thn1.'-'.$bln1.'-01';
		$tgl_smp = $thn2.'-'.$bln2.'-01';
		$tgl_smp1 = date('Y-m-d', strtotime('+1 month', strtotime($tgl_smp)));
		$tgl_sampai = date('Y-m-d', strtotime('-1 days', strtotime($tgl_smp1)));
		if (substr($jenis_pa,0,1) == 'S' && $jenis_pa != 'ALL' && $jenis_pa != '') {
			$jenis = "AND substr(jenis_pa,1,1) = 'S'";
		}elseif(substr($jenis_pa,0,1) != 'S' && $jenis_pa != 'ALL' && $jenis_pa != ''){
			$jenis = "AND substr(jenis_pa,1,1) != 'S'";
		}else{
			$jenis = "";
		}
		if ($bod == "") {
			// $dept = "";
			// $cabang = "";
		}else{
			// $dept = "AND kode_dept IN (
			// 	SELECT * FROM (
			// 	SELECT departemen FROM mskaryawan
			// 	WHERE atasan IN (SELECT nik FROM mskaryawan WHERE atasan ='$bod' AND aktif ='Y' AND LEVEL != 111 UNION ALL SELECT nik
			// 	FROM mskaryawan WHERE LEVEL ='131' AND atasan IN (SELECT nik FROM mskaryawan WHERE atasan ='$bod' AND aktif ='Y' AND LEVEL != 111)) AND AKTIF ='y'

			// 	UNION ALL
			// 	SELECT departemen FROM mskaryawan
			// 	WHERE nik IN (SELECT nik FROM mskaryawan WHERE atasan ='$bod' AND aktif ='Y' AND LEVEL != 111 UNION ALL SELECT nik
			// 	FROM mskaryawan WHERE LEVEL ='131' AND atasan IN (SELECT nik FROM mskaryawan WHERE atasan ='$bod' AND aktif ='Y' AND LEVEL != 111)) AND AKTIF ='y'
			// 	 ) vv

			// 	GROUP BY departemen)";
		}
		return $this->db->query("
			SELECT * FROM (
				SELECT a.*, 
				c.inisial AS kode_cabang, 
				c.kode_dept 
				FROM pacab_formheader a 
					LEFT JOIN mskaryawan b ON a.nik = b.nik 
					LEFT JOIN mscabang c ON b.kode_cabang = c.kode_cabang
				WHERE is_delete = 'N' AND a.status IN ('RE-ASSESMENT','ACCEPTED','APPROVED') 
				UNION ALL 

				SELECT a.*,
						c.inisial AS cabang, 
						c.kode_cabang 
					FROM pacab_formheader a 
						LEFT JOIN mskaryawan b ON a.nik = b.nik 
						LEFT JOIN mscabang c ON b.kode_cabang = c.kode_cabang 
					WHERE is_delete = 'N' 
						AND a.user_input = '$nik_login' 
						AND a.nik != '$nik_login' 
						AND a.status NOT IN('RE-ASSESMENT','ACCEPTED','APPROVED') 
						AND b.atasan NOT IN (SELECT nik FROM mskaryawan WHERE departemen IN (SELECT kd_dept FROM bod_dept WHERE nik='$nik_login' AND app_type ='PA') 
												AND nik NOT IN (SELECT nik FROM bod_sublevel WHERE app_type ='PA') AND aktif ='Y' AND LEVEL !='130') 
				UNION ALL 

				SELECT a.*,
						c.inisial AS departemen, 
						c.kode_dept 
					FROM pacab_formheader a 
						LEFT JOIN mskaryawan b ON a.nik = b.nik 
						LEFT JOIN mscabang c ON b.kode_cabang = c.kode_cabang 
					WHERE is_delete = 'N'
						AND a.status = 'PROCESS'
						AND a.user_input IN (SELECT nik FROM bod_dept WHERE nik != '$nik_login' AND app_type ='PA')

				) xx WHERE tgl_periode2 >= '$tgl_dari' AND tgl_periode2 <= '$tgl_sampai' $jenis
				ORDER BY kode_cabang, jenis_pa, nama, tgl_input DESC")->result();	
	}

	function get_form_all_karyawan_tohr($bln1, $thn1, $bln2, $thn2, $bod, $jenis_pa, $cabang){ // buat hrd
		$tgl_dari = $thn1.'-'.$bln1.'-01';
		$tgl_smp = $thn2.'-'.$bln2.'-01';
		$tgl_smp1 = date('Y-m-d', strtotime('+1 month', strtotime($tgl_smp)));
		$tgl_sampai = date('Y-m-d', strtotime('-1 days', strtotime($tgl_smp1)));
		if (substr($jenis_pa,0,1) == 'S' && $jenis_pa != 'ALL' && $jenis_pa != '') {
			$jenis = "AND substr(jenis_pa,1,1) = 'S'";
		}elseif(substr($jenis_pa,0,1) != 'S' && $jenis_pa != 'ALL' && $jenis_pa != ''){
			$jenis = "AND substr(jenis_pa,1,1) != 'S'";
		}else{
			$jenis = "";
		}
		if ($bod == '') {
			// $cabang = "";
		}else{
			// $cabang = "AND kd_dept IN (
			// 	SELECT * FROM (
			// 	SELECT departemen FROM mskaryawan
			// 	WHERE atasan IN (SELECT nik FROM mskaryawan WHERE atasan ='$bod' AND aktif ='Y' AND LEVEL != 111 UNION ALL SELECT nik
			// 	FROM mskaryawan WHERE LEVEL ='131' AND atasan IN (SELECT nik FROM mskaryawan WHERE atasan ='$bod' AND aktif ='Y' AND LEVEL != 111)) AND AKTIF ='y'
				
			// 	UNION ALL
			// 	SELECT departemen FROM mskaryawan
			// 	WHERE nik IN (SELECT nik FROM mskaryawan WHERE atasan ='$bod' AND aktif ='Y' AND LEVEL != 111 UNION ALL SELECT nik
			// 	FROM mskaryawan WHERE LEVEL ='131' AND atasan IN (SELECT nik FROM mskaryawan WHERE atasan ='$bod' AND aktif ='Y' AND LEVEL != 111)) AND AKTIF ='y'
			// 	) vv
				
			// 	GROUP BY departemen)";
		}

		if($cabang == NULL){
			$nama_cabang = "";
		} else {
			$nama_cabang = "AND kode_cabang = '$cabang'";
		}

		return $this->db->query("
			SELECT * FROM (
					SELECT a.*, 
						c.inisial AS cabang, 
						c.kode_cabang AS CBg 
					FROM pacab_formheader a 
						LEFT JOIN mskaryawan b ON a.nik = b.nik LEFT JOIN
						mscabang c ON b.kode_cabang = c.kode_cabang 
					WHERE is_delete = 'N' 
						AND a.status IN ('CONFIRMED SOH', 'ACCEPTED','APPROVED')
					
				UNION ALL 

					SELECT a.*, 
						c.inisial AS cabang, 
						c.kode_cabang AS cab
					FROM pacab_formheader a 
						LEFT JOIN mskaryawan b ON a.nik = b.nik 
						LEFT JOIN mscabang c ON b.kode_cabang = c.kode_cabang
						WHERE is_delete = 'N' 
							AND a.status ='RE-ASSESMENT'
			) xx WHERE tgl_periode2 >= '$tgl_dari' AND tgl_periode2 <= '$tgl_sampai' $jenis $nama_cabang ORDER BY jenis_pa, nama, tgl_input DESC")->result();
		
	}	

	function get_departemen_bynik($nik){
		return $this->db->query("SELECT departemen FROM mskaryawan WHERE nik ='$nik'")->row()->departemen;
	}

	function get_data_header($kode){
		return $this->db->query("SELECT * FROM pacab_formheader 
									WHERE kode_pa ='$kode' 
										AND is_delete = 'N' 
									ORDER BY tgl_penilaian, 
											kode_pa")->result();
	}

	// function get_faktor_kategori($nik, $atasan){
	// 	if ($nik != $atasan){
	// 		$where = "WHERE level = 1";
	// 	}else{
	// 		$where = "WHERE level IN (1,2)";
	// 	}
	// 	return $this->db->query("SELECT * FROM pacab_faktordankategori $where")->result();
	// }

	function get_faktor_kategori($nik, $atasan){
		if ($this->session->userdata('level') == 240){
			$where = "WHERE level = 1";
		}elseif($this->session->userdata('level') == 230){
			$where = "WHERE level = 1";
		}elseif($this->session->userdata('level') == 220){
			$where = "WHERE level = 1";
		}else{
			$where = "WHERE level IN (1,2)";
		}
		return $this->db->query("SELECT * FROM pacab_faktordankategori $where")->result();
	}

	function get_all_fk(){
		return $this->db->query("SELECT * FROM pacab_faktordankategori")->result();
	}

	function get_kategori($faktor){
		return $this->db->query("SELECT * FROM pacab_faktordankategori WHERE faktor ='$faktor'")->result();
	}

	function get_fk_bykode($kode_fk){
		return $this->db->query("SELECT * FROM pacab_faktordankategori WHERE kode_fk ='$kode_fk'")->result();
	}

	function get_detail($kode){
		return $this->db->query("SELECT a.*, 
									b.kode_fk, 
									b.kategori_a, 
									b.kategori_b, 
									b.kategori_c, 
									b.kategori_d,
									b.kategori_e, 
									b.level 
								FROM pacab_formdetail a 
								LEFT JOIN pacab_faktordankategori b 
									ON a.faktor = b.faktor 
								WHERE kode_pa ='$kode'")->result();
	}

	function isi_detail($kode){
		return $this->db->query("SELECT COUNT(faktor) AS isi_detail 
									FROM pacab_formdetail 
									WHERE kode_pa ='$kode' AND kategori != '' AND nilai != '' AND skor != ''")->row()->isi_detail;
	}

	function jml_detail($kode){
		return $this->db->query("SELECT COUNT(faktor) AS jml_detail 
									FROM pacab_formdetail 
									WHERE kode_pa ='$kode'")->row()->jml_detail;
	}

	function get_detail_byid($id){
		return $this->db->query("SELECT * FROM pacab_formdetail WHERE id = '$id'")->result();
	}

	function get_kategori_fix($kode, $kategori){
		return $this->db->query("SELECT kode_fk, 
										faktor, 
										$kategori AS kategori 
									FROM pacab_faktordankategori
									WHERE kode_fk ='$kode'")->result();
	}

	function get_ms_nilai($nilai){
		return $this->db->query("SELECT * FROM pacab_msnilai WHERE nilai ='$nilai'")->result();
	}

	function get_check_nilai($rt){
		return $this->db->query("SELECT nilai, 
										predikat,
										skor 
									FROM pacab_msnilai 
									WHERE skor >= $rt 
									ORDER BY ABS(skor - $rt) LIMIT 1")->result();
	}

	function get_nilai(){
		return $this->db->query("SELECT * FROM pacab_msnilai")->result();
	}

	function get_last_kd_today(){
		$date = date('Y-m');
		return $this->db->query("SELECT *, 
									SUBSTRING(tgl_input, 1, 7) AS tgl_pa 
									FROM pacab_formheader 
									WHERE SUBSTRING(tgl_input, 1, 7) = '$date' 
									ORDER BY id DESC")->result();
	}

	function get_last_kd_hari(){
		$date = date('Y-m');
		return $this->db->query("SELECT *, 
										SUBSTRING(tgl_input, 1, 7) AS tgl_pa 
									FROM pacab_msjenis 
									WHERE SUBSTRING(tgl_input, 1, 7) = '$date' 
									ORDER BY ids DESC")->result();
	}

	function get_last_fk_today(){
		return $this->db->query("SELECT kode_fk FROM pacab_faktordankategori ORDER BY id DESC")->result();
	}

	function get_karyawan_bynik($nik){
		return $this->db->query("SELECT a.*, b.inisial AS inisial_level, b.nama AS nama_level, c.inisial AS inisial_dept, c.nama AS nama_dept FROM mskaryawan a LEFT JOIN mslevel b ON a.level = b.kode_level LEFT JOIN msdepartemen c ON a.departemen = c.kode_dept WHERE nik ='$nik'")->result();
	}

	function get_nik_atasan(){
		$nik = $this->session->userdata('nik');
		return $this->db->query("SELECT atasan FROM mskaryawan WHERE aktif='Y' AND atasan !='' AND atasan ='$nik' GROUP BY atasan")->num_rows();
	}

	function get_nik_atasan_ss(){
		$nik = $this->session->userdata('nik');
		$cabang = $this->getCabang($nik);
		return $this->db->query("SELECT * FROM mskaryawan WHERE aktif='Y' and kode_cabang = '$cabang' and level IN('240','220','230')")->num_rows();
		// return $this->db->query("SELECT * FROM mskaryawan WHERE aktif='Y' and kode_cabang = '$cabang' and level = '240'")->num_rows();
		// return $this->db->query("SELECT * FROM pacab_pesertajenis WHERE  and kode_cabang = '$cabang'")->num_rows();
		
	}

	function getCabang($nik){
		return $this->db->query("SELECT kode_cabang FROM mskaryawan where nik = '$nik'")->row()->kode_cabang;
	}

	function get_head_dept_by_atasan(){
		//cek kalo dia ada atasan di staffnya berarti dia perlu muncul PA departemen
		$nik = $this->session->userdata('nik');
		// return $this->db->query("SELECT * 
		// 						FROM mskaryawan 
		// 							WHERE atasan ='$nik' 
		// 							AND nik IN (SELECT atasan FROM mskaryawan GROUP BY atasan) AND aktif ='Y'")->num_rows();

		return $this->db->query("SELECT * FROM mskaryawan WHERE atasan ='$nik' AND LEVEL ='210' AND aktif ='Y'")->num_rows();
	}

	function get_rata_rata($kode){
		return $this->db->query("SELECT isi, 
										skor,
										ROUND(skor/isi) AS rata_rata 
									FROM ( SELECT COUNT(skor) AS isi, 
													SUM(skor) AS skor 
												FROM pacab_formdetail 
												WHERE kode_pa ='$kode') xx")->result();
	}

	function get_super_user(){
		$nik = $this->session->userdata('nik');
		return $this->db->query("SELECT * 
									FROM pacab_superuser
										WHERE nik ='$nik'")->num_rows();
	}

	function get_auth_bynik(){
		$nik = $this->session->userdata('nik');
		$a = $this->db->query("SELECT * FROM pacab_superuser WHERE nik ='$nik'")->result();
		if ($a != NULL) {
			return $this->db->query("SELECT * FROM pacab_superuser WHERE nik ='$nik'")->row()->auth;
		}
	}

	function get_tahun(){
		return $this->db->query("SELECT 
									YEAR(tgl_penilaian) AS tahun 
									FROM pacab_formheader 
										GROUP BY tahun")->result();
	}

	function get_summary1($bulan, $tahun, $cabang){
		if ($cabang != '') {
			$d ="AND b.kode_cabang ='$cabang'";
		}else{
			$d ="";
		}
		return $this->db->query("SELECT a.kode_pa,
										a.kode_cabang,
										a.nik, 
										a.nama, 
										a.status_karyawan, 
										a.jabatan, 
										a.tgl_gabung, 
										a.tgl_penilaian, 
										a.tgl_periode2, 
										a.periode, 
										a.tujuan_penilaian, 
										a.nilai_ratarata, 
										a.nilai_kpi, 
										a.keterangan, 
										a.rekomendasi 
								FROM pacab_formheader a 
									LEFT JOIN mskaryawan b ON a.nik = b.nik 
								WHERE MONTH(a.tgl_penilaian) = '$bulan' 
										AND YEAR(a.tgl_penilaian) = '$tahun' 
										AND a.nilai_ratarata != 0 
										AND a.is_delete = 'N' 
										$cabang
										ORDER BY nilai_ratarata DESC")->result();
	}

	function get_summary($jenis, $tahun, $cabang){
		if ($cabang != '') {
			$d ="AND b.kode_cabang ='$cabang'";
		}else{
			$d ="";
		}
		return $this->db->query("SELECT a.kode_pa,
										a.kode_cabang,
										a.nik, 
										a.nama, 
										a.status_karyawan, 
										a.jabatan, 
										a.tgl_gabung, 
										a.tgl_penilaian, 
										a.tgl_periode2, 
										a.periode, 
										a.tujuan_penilaian, 
										a.nilai_ratarata, 
										a.nilai_kpi, 
										a.keterangan, 
										a.rekomendasi 
								FROM pacab_formheader a 
									LEFT JOIN mskaryawan b ON a.nik = b.nik 
								WHERE substr(a.jenis_pa,1,2) = '$jenis' 
										AND YEAR(a.tgl_penilaian) = '$tahun' 
										AND a.nilai_ratarata != 0 
										AND a.is_delete = 'N' 
										AND a.status ='ACCEPTED' $d ORDER BY nilai_ratarata DESC")->result();
										// -- AND a.status ='APPROVED' $d ORDER BY nilai_ratarata DESC")->result();
	}

	function summary_to_excel($jenis, $tahun, $cabang){
		if ($cabang != '') {
			$d ="AND b.kode_cabang ='$cabang'";
		}else{
			$d ="";
		}
		return $this->db->query("SELECT a.kode_pa,
										a.kode_cabang, 
										a.nik,
										a.nama,
										a.status_karyawan, 
										a.jabatan, 
										a.tgl_gabung, 
										a.tgl_penilaian, 
										a.tgl_periode2, 
										a.periode, 
										a.tujuan_penilaian, 
										a.nilai_ratarata, 
										a.nilai_kpi, 
										a.keterangan, 
										a.rekomendasi 
									FROM pacab_formheader a 
										LEFT JOIN mskaryawan b ON a.nik = b.nik 
									WHERE substr(a.jenis_pa,1,2) = '$jenis' 
										AND YEAR(a.tgl_penilaian) = '$tahun' 
										AND a.nilai_ratarata != 0 
										AND a.is_delete = 'N' 
										AND a.status ='ACCEPTED' $d ORDER BY nilai_ratarata DESC")->result();
										//AND a.status ='APPROVED' $d ORDER BY nilai_ratarata DESC")
	}

	function get_departemen(){
		return $this->db->query("SELECT 
									kode_dept, 
									nama AS nama_dept 
								FROM msdepartemen 
								WHERE kode_dept NOT IN ('200','800')")->result();
	}

	function list_atasan($nik){
		return $this->db->query("SELECT * 
									FROM mskaryawan
									WHERE nik IN (SELECT atasan FROM mskaryawan GROUP BY atasan) 
										AND aktif ='Y' 
										AND atasan != '-' 
										AND nik ='$nik' ")->result();
	}

	function get_nik_karyawan_sudahisi(){
		return $this->db->query("SELECT 
									nik, 
									nama 
								FROM pacab_formheader 
									WHERE STATUS ='APPROVED' 
										AND is_delete ='N' 
									GROUP BY nik 
									ORDER BY nik")->result();
	}

	
	function get_nik_karyawan_sudahisi2hrd(){
		return $this->db->query("SELECT 
									nik, 
									nama 
								FROM pacab_formheader 
									WHERE STATUS ='ACCEPTED' 
										AND is_delete ='N' 
									GROUP BY nik 
									ORDER BY nik")->result();
	}

	function get_nilai_grafik_x($nik, $jenis){
		if($nik == "" AND $jenis !=""){
			if($jenis == 'ALL'){
				return $this->db->query("SELECT CONCAT(jenis,' ', th) AS nilai_x FROM (
					SELECT IF(SUBSTR(jenis_pa,1,2) = 'S1', 'Semester 1', 'Semester 2') AS jenis, 
							SUBSTR(jenis_pa,4,4) AS th 
					FROM pacab_formheader a 
						LEFT JOIN mskaryawan b ON a.nik = b.nik 
					WHERE nilai_ratarata != 0 
						AND a.status = 'ACCEPTED'
						AND is_delete ='N' 
					GROUP BY jenis_pa) xx ")->result();
			}else{
				return $this->db->query("SELECT CONCAT(jenis,' ', th) AS nilai_x 
											FROM ( SELECT IF(SUBSTR(jenis_pa,1,2) = 'S1', 'Semester 1', 'Semester 2') AS jenis, 
															SUBSTR(jenis_pa,4,4) AS th
														FROM pacab_formheader a 
														LEFT JOIN mskaryawan b ON a.nik = b.nik 
													WHERE nilai_ratarata != 0 
														AND a.status = 'ACCEPTED' 
														AND is_delete ='N' 
														AND jenis_pa ='$jenis' 
													GROUP BY jenis_pa) xx ")->result();
			}
		}elseif($nik != "" AND $jenis != ""){
			if ($jenis =='ALL'){
				return $this->db->query("SELECT CONCAT(MONTHNAME(tgl_penilaian),
												' ', 
												YEAR(tgl_penilaian)) AS nilai_x, 
												nilai_ratarata AS nilai_y 
										FROM pacab_formheader a 
											LEFT JOIN mskaryawan b ON a.nik = b.nik
										WHERE a.nik ='$nik' 
											AND nilai_ratarata != 0 
											AND a.status = 'ACCEPTED' 
											AND is_delete ='N'")->result();
			}else{
				return $this->db->query("SELECT YEAR(tgl_penilaian) AS nilai_x 
											FROM pacab_formheader a 
												LEFT JOIN mskaryawan b ON a.nik = b.nik
											WHERE a.nik ='$nik' 
												AND nilai_ratarata != 0 
												AND a.status = 'ACCEPTED' 
												AND is_delete ='N' 
											GROUP BY YEAR(tgl_penilaian)")->result();
			}
		}
	}

	function get_nilai_grafik_y($nik, $jenis){
		if($nik == "" AND $jenis !=""){
			if ($jenis =='ALL'){
				return $this->db->query("SELECT 
											ROUND(AVG(nilai_ratarata),2) AS nilai_y 
										FROM pacab_formheader a 
											LEFT JOIN mskaryawan b ON a.nik = b.nik
										WHERE nilai_ratarata != 0 
											AND a.status = 'ACCEPTED' 
											AND is_delete ='N' 
										GROUP BY CONCAT(MONTHNAME(tgl_penilaian),' ', 
												YEAR(tgl_penilaian)) 
										ORDER BY YEAR(tgl_penilaian), 
											MONTH(tgl_penilaian)")->result();
			}else{
				return $this->db->query("SELECT ROUND(AVG(nilai_ratarata),2) AS nilai_y 
											FROM pacab_formheader a 
												LEFT JOIN mskaryawan b ON a.nik = b.nik 
											WHERE nilai_ratarata != 0 
												AND a.status = 'ACCEPTED' 
												AND is_delete ='N'
											GROUP BY YEAR(tgl_penilaian)")->result();
			}
		}elseif($nik != "" AND $jenis != ""){
			if ($jenis =='ALL'){
				return $this->db->query("SELECT nilai_ratarata AS nilai_y 
											FROM pacab_formheader a 
												LEFT JOIN mskaryawan b ON a.nik = b.nik 
											WHERE a.nik ='$nik' 
												AND nilai_ratarata != 0 
												AND a.status = 'ACCEPTED' 
												AND is_delete ='N'")->result();
			}else{
				return $this->db->query("SELECT ROUND(AVG(nilai_ratarata),2) AS nilai_y
											FROM pacab_formheader a 
												LEFT JOIN mskaryawan b ON a.nik = b.nik
											WHERE a.nik ='$nik'
												AND nilai_ratarata != 0 
												AND a.status = 'ACCEPTED' 
												AND is_delete ='N' 
											GROUP BY YEAR(tgl_penilaian)")->result();
			}
		}
	}

	function get_nik_nama_byheader(){
		return $this->db->query("SELECT nik, nama FROM pacab_formheader GROUP BY nik")->result();
	}

	function get_data_detail($kode_pa){
		return $this->db->query("SELECT * FROM pacab_formdetail WHERE kode_pa ='$kode_pa'")->result();
	}

	function cek_dept($nik){
		return $this->db->query("SELECT departemen FROM mskaryawan WHERE nik ='$nik'")->result();
	}

	function cek_manager($dept){ //nyari SOH
		$nik = $this->session->userdata('nik');
		$adasan = $this->db->query("SELECT * FROM mskaryawan where nik = '$nik'")->result();
		$assd = $adasan[0]->atasan;
		$cabang = $this->db->query("SELECT kode_cabang FROM mskaryawan where nik ='$nik'")->row()->kode_cabang;
		//INI COBA LIAT LAGI
		if($this->session->userdata('level') == 240 || $this->session->userdata('level') == 230 || $this->session->userdata('level') == 220  ){ // SOH karyawan itu atasannya supervisor
			$query = $this->db->query("SELECT atasan 
										FROM mskaryawan
									WHERE level=210 
											AND kode_cabang = '$cabang' 
											AND aktif='Y' ")->result();
			$queries = $this->db->query("SELECT * 
											FROM pacab_pesertajenis
											WHERE nik = '$nik' 
											ORDER BY ids DESC")->result();
			$r = count($query);
			$s = count($queries);
			if($r > 0){
				$result = $query[0]->atasan;
				return $result;
			} else if( $s > 0){
				$result = $queries[0]->soh;
				return $result;
			} else {
				$akhireu = $this->db->query("SELECT * FROM mskaryawan where nik = '$nik'")->result();
				$result = $akhireu[0]->atasan;
				return $result;
			}
		}else if($dept = '210') { //atasan dari supervisor
			$level = '130';
			$departemen = '600';
			return $this->db->query("SELECT nik FROM mskaryawan WHERE level ='$level' AND departemen='$departemen' AND aktif ='Y'")->row()->nik;
		} else{
			return $this->db->query("SELECT nik FROM mskaryawan WHERE level ='$level' AND departemen='$departemen' AND aktif ='Y'")->row()->nik;
		}
		
	}

	function cek_atasan($nik){ //atasan karyawan = supervisor, atasan supervisor = soh
		$kode_cabang = $this->getCabang($nik);
		if($this->session->userdata('level') == 240 || $this->session->userdata('level') == 230 || $this->session->userdata('level') == 220 ){//untuk pegawai nyari
			$Cekaja = $this->db->query("SELECT * 
												FROM mskaryawan 
												WHERE kode_cabang = '$kode_cabang' 
													AND level = '210'
													AND aktif = 'Y'");
			$cekLagi = $this->db->query("SELECT soh 
												FROM pacab_pesertajenis
												WHERE nik = '$nik' 
												ORDER BY ids DESC");

			if($Cekaja->num_rows() > 0) {
											return $this->db->query("SELECT nik 
											FROM mskaryawan 
											WHERE kode_cabang ='$kode_cabang' 
												AND level = '210' 
												AND aktif ='Y'")->row()->nik;
			}else if($cekLagi->num_rows() >0){
				return $this->db->query("SELECT soh 
											FROM pacab_pesertajenis 
											WHERE nik = '$nik'")->row()->soh;
			}else{
				$query = $this->db->query("SELECT * 
												FROM mskaryawan 
												WHERE nik = '$nik' 
													AND aktif = 'Y' ")->result();
				$result = $query[0]->atasan;
				return $result;
			}
		}elseif($this->session->userdata('level') == 210){
			$cekLagi = $this->db->query("SELECT soh 
												FROM pacab_pesertajenis
												WHERE nik = '$nik' 
												ORDER BY ids DESC");
			if($cekLagi->num_rows()>0){
				return $this->db->query("SELECT soh 
											FROM pacab_pesertajenis 
											WHERE nik = '$nik'")->row()->soh;
			}else{
				return $this->db->query("SELECT atasan FROM mskaryawan WHERE nik ='$nik'")->row()->atasan;
			}
		}else{
			return $this->db->query("SELECT atasan FROM mskaryawan WHERE nik ='$nik'")->row()->atasan;
		}
		
	}

	function getCabangPA($cabang, $kd_jenis){
		// if($cabang == NULL){
		// 	$cabangg = "";
		// } else {
		// 	$cabangg = "WHERE kode_cabang = '$cabang'";
		// }
		return $this->db->query("SELECT * FROM pacab_formheader 
								WHERE kode_cabang = '$cabang' AND substr(kode_pa, 1, 8) = '$kd_jenis' 
								AND status NOT IN ('PROCESS', 'CONFIRMED', 'RE-ASSESTMENT')")->result();

		// return $this->db->query("SELECT *
		// FROM pacab_formheader
		// WHERE kode_cabang = '$cabang'
		//   AND SUBSTR(kode_pa, 1, 8) = '$kd_jenis'
		//   AND STATUS NOT IN ('CONFIRMED', 'RE-ASSESSMENT')
		//   OR STATUS IN (
		// 	SELECT STATUS
		// 	FROM pacab_formheader
		// 	WHERE STATUS = 'PROCESS' AND user_input = '$nik_login' AND kode_cabang = '$cabang'
		//   )")->result();
	}

	function getCabangPaSoh($cabang, $kd_jenis){
		// if($cabang == NULL){
		// 	$cabangg = "";
		// } else {
		// 	$cabangg ="AND kode_cabang = '$cabang'";
		// }

		
		return $this->db->query("SELECT * FROM pacab_formheader 
									WHERE  substr(kode_pa,1,8) = '$kd_jenis'
										AND kode_cabang = '$cabang'")->result();
	}

	function get_form_all_karyawan_kpi($bln1, $thn1, $bln2, $thn2, $jenis_pa, $cabang){ //buat input kpi
		$nik_login = $this->session->userdata('nik');
		$tgl_dari = $thn1.'-'.$bln1.'-01';
		$tgl_smp = $thn2.'-'.$bln2.'-01';
		$tgl_smp1 = date('Y-m-d', strtotime('+1 month', strtotime($tgl_smp)));
		$tgl_sampai = date('Y-m-d', strtotime('-1 days', strtotime($tgl_smp1)));
		if (substr($jenis_pa,0,1) == 'S' && $jenis_pa != 'ALL' && $jenis_pa != '') {
			$jenis = "AND substr(jenis_pa,1,1) = 'S'";
		}elseif(substr($jenis_pa,0,1) != 'S' && $jenis_pa != 'ALL' && $jenis_pa != ''){
			$jenis = "AND substr(jenis_pa,1,1) != 'S'";
		}else{
			$jenis = "";
		}
		
		if($cabang == NULL){
			$cabangg = "";
		} else {
			$cabangg = "AND a.kode_cabang = '$cabang'";
		}

		// var_dump($tgl_dari." ".$tgl_sampai." ".$jenis." ". $cabangg);die();
		return $this->db->query("SELECT a.*, 
									c.inisial AS mscabang 
								FROM pacab_formheader a 
									LEFT JOIN mskaryawan b ON a.nik = b.nik 
									LEFT JOIN mscabang c ON b.kode_cabang = c.kode_cabang
								WHERE is_delete = 'N' 
									AND a.status IN('ACCEPTED','APPROVED') 
									AND tgl_periode2 >= '$tgl_dari' 
									AND tgl_periode2 <= '$tgl_sampai' $jenis $cabangg
								ORDER BY kode_cabang, jenis_pa, nama, tgl_penilaian, kode_pa")->result();
	}

	function get_lampiran_pa($kode_pa){
		return $this->db->query("SELECT * 
								FROM pacab_lampiran 
								WHERE kode_pa ='$kode_pa' 
									AND is_delete ='N'")->result();
	}

	function get_last_urut_file($kode){
		return $this->db->query("SELECT * 
									FROM pacab_lampiran 
									WHERE kode_pa = '".$kode."' 
									ORDER BY id DESC")->result();
	}

	function get_det_lampiran($kode){
		return $this->db->query("SELECT * 
									FROM pacab_lampiran 
									WHERE kode_file ='$kode'")->result();
	}

	function get_nama_jk($nik){
		return $this->db->query("SELECT nama,
										kelamin
									FROM mskaryawan
									WHERE nik ='$nik' 
										AND aktif ='Y'")->result();
	}

	function tb_mskaryawan($nik){
		return $this->db->query("SELECT * 
									FROM mskaryawan
									WHERE nik ='$nik'")->result();
	}

	function get_superlevel(){
		return $this->db->query("SELECT * 
									FROM pacab_dept_superlevel ORDER BY nama_dept, level")->result();
	}

	function cek_bod_dept($nik){
		return $this->db->query("SELECT nik FROM bod_dept WHERE nik ='$nik' AND app_type ='PA' GROUP BY nik")->num_rows();
	}

	function cek_cabang_yang_diambil(){
		return $this->db->query("SELECT nik FROM bod_dept_cabang WHERE nik ='$nik' AND app_type ='PA' GROUP BY nik")->num_rows();
	}

	function list_bod(){
		return $this->db->query("SELECT nik FROM bod_dept WHERE app_type ='PA' GROUP BY nik")->row()->nik;
	}

	function list_bawahan_bod($nik){
		return $this->db->query("SELECT * FROM bod_sublevel WHERE nik ='$nik' AND app_type ='PA'")->num_rows();
	}

	function insert($table, $data){
		return $this->db->insert($table, $data);
	}

	function update($table, $data, $where){
		return $this->db->update($table, $data, $where);
	}

	function delete($table, $where){
		return $this->db->delete($table, $where);
	}

	function get_SOH(){
		return $this->db->query("SELECT * FROM mskaryawan WHERE kode_cabang = 'NH000' AND departemen = '600' AND LEVEL='130' AND aktif ='Y'")->result();
	}

	function get_SOH_pesertajenis(){
		return $this->db->query("SELECT soh FROM pacab_pesertjenis WHERE nik = '$nik'")->row()->soh;
	}

	function get_cab(){
		return $this->db->query("SELECT * FROM mscabang where aktif = 'Y' and kode_cabang != 'NH000'")->result();
	}

	function get_karyawan_cabang(){
		return $this->db->query("SELECT * FROM mskaryawan where departemen='600' and level in('240','230','220','210') and aktif='Y'");
	}

	function get_all_PA(){
		return $this->db->query("SELECT * FROM pacab_formheader")->result();
	}

	function getJenis($kd_jenis){
		return $this->db->query("SELECT * FROM pacab_msjenis where kd_jenis = '$kd_jenis'")->result();
	}

	function getHeaderAll(){
		return $this->db->query("SELECT * FROM pacab_formheader")->result();
	}

	function cariPesertaJenis($kd_jenis,$nik){
		return $this->db->query("SELECT * FROM pacab_pesertajenis WHERE nik = '$nik' AND kd_jenis LIKE '$kd_jenis%' ")->result();
	}

	function check_atasan($kd_jenis, $nik){
		return $this->db->query("SELECT soh FROM pacab_pesertajenis WHERE nik = '$nik' AND kd_jenis LIKE '$kd_jenis' ")->result();
	}

	function get_supervisor_store($kode_cabang){
		return $this->db->query("SELECT * FROM mskaryawan where aktif = 'Y' and kode_cabang = '$kode_cabang' and level = '210'");
	}

	function get_employee_store_formheader($kode_cabang){
		return $this->db->query("SELECT * FROM pacab_formheader WHERE kode_cabang = '$kode_cabang'")->result();
	}

	function get_your_own($nik){
		return $this->db->query("SELECT * FROM pacab_formheader 
								WHERE nik = '$nik' ")->result();
	}

	function get_peserta_jenis($kode_jenis){
		return $this->db->query("SELECT * FROM pacab_pesertajenis WHERE kd_jenis = '$kode_jenis'")->result();
	}
	
	function getHeaderOnlyYou($nik, $kd_jenis){
		return $this->db->query("SELECT * 
									FROM pacab_formheader 
									WHERE nik = '$nik' 
										and substr(kode_pa, 1, 8) = '$kd_jenis'
										AND is_delete ='N'")->result();
	}

	function cekSmt($kd_jenis, $nik){
		return $this->db->query("SELECT * 
									FROM pacab_pesertajenis 
									WHERE nik = '$nik' 
										AND substring(kd_jenis, 1,8) = '$kd_jenis'");
	}

	function udahBelumJenis($nik, $kd_jenis){
		return $this->db->query("SELECT * 
									FROM pacab_pesertajenis 
									WHERE nik = '$nik' 
										AND substring(kd_jenis, 1,8) = '$kd_jenis'");
	}

	function cekAtasanSOH($kode_pa){
		return $this->db->query("SELECT soh FROM pacab_pesertajenis WHERE kd_jenis = '$kode_pa' ")->row()->soh;
	}

	//kalau hrd bisa lihat semuanya
	function get_pa_hrd($cabang){
		if($cabang == 'ALL'){
			return $this->db->query("SELECT * FROM pacab_formheader where is_delete = 'N'")->result();
		}else {
			return $this->db->query("SELECT * FROM pacab_formheader WHERE kode_cabang = '$cabang'");
		}
	}

	//kalau soh cuma bisa yang ada 
	function get_pa_soh($cabang){
		$nik = $this->session->userdata('nik');
		if($cabang == 'ALL'){
			return $this->db->query("SELECT * FROM pacab_formheader a
			JOIN pacab_pesertajenis b 
			ON a.kode_pa =b.kd_jenis
			WHERE b.soh = '$nik' AND is_delete='N'")->result();
		}else{
			return $this->db->query("SELECT * FROM pacab_formheader a 
				JOIN pacab_pesertajensis b 
				ON a.kode_pa = b.kd_jenis
				WHERE b.soh = '$nik' and kode_cabang = '$cabang'  AND is_delete='N'")->result();
		}

	}
	
	function get_pasoh_bawahanlangsung(){
		return $this->db->query(
			"SELECT * FROM pacab_formheader a JOIN mskaryawan b
			ON a.nik = b.nik"
		);
	}

	function get_soh_cabang_dasarpeserta(){
		$nik = $this->session->userdata('nik');
		return $this->db->query("SELECT * FROM pacab_pesertajenis WHERE soh = '$nik' GROUP BY cabang")->result();
	}

	function soh_cabang_searchhh(){
		$nik = $this->session->userdata('nik');
		return $this->db->query("SELECT cabang, 
										b.nama_cabang as nama_cab
									FROM pacab_pesertajenis a 
										JOIN mscabang b 
											ON b.kode_cabang = a.cabang 
									WHERE soh = '$nik' 
									GROUP BY cabang")->result();
	}


	function cabangSOH($kd_jenis){
		$nik = $this->session->userdata('nik');
		return $this->db->query("SELECT * FROM pacab_pesertajenis a
										JOIN mscabang b
											ON a.cabang = b.kode_cabang
										WHERE  substr(kd_jenis,1,8) = '$kd_jenis' 
												AND soh = '$nik' GROUP BY cabang")->result();
	}

	function cabangHRD($kd_jenis){
		// return $this->db->query("SELECT * FROM pacab_pesertajenis a
		// 								JOIN mscabang b
		// 									ON a.cabang = b.kode_cabang
		// 								WHERE  substr(kd_jenis,1,8) = '$kd_jenis' 
		// 								GROUP BY cabang")->result();

		return $this->db->query("SELECT * FROM pacab_pesertajenis a
									JOIN mscabang b
										ON a.cabang = b.kode_cabang
									JOIN pacab_formheader c
										ON a.kd_jenis = c.kode_pa
									WHERE  SUBSTR(kd_jenis,1,8) = '$kd_jenis' 
									AND c.status NOT IN ('CONFIRMED', 'PROCESS')
									GROUP BY cabang")->result();
	}
	

	function cekPA($kd_jenis){
		return $this->db->query("SELECT * FROM pacab_formheader WHERE kode_pa ='$kd_jenis'");
	}

	function loadKode($kd_jenis){
		return $this->db->query("SELECT * FROM pacab_msjenis WHERE kd_jenis = '$kode_jenis'")->result();
	}

	function cekSS($nik){
		$get_cabang = $this->db->query("SELECT * FROM mskaryawan where nik = '$nik'")->result();
		$cabang = $get_cabang[0]->kode_cabang;
		
		return $this->db->query("SELECT * FROM mskaryawan where level = '210' and aktif = 'Y' and kode_cabang = '$cabang'")->num_rows();
	}


}

?>