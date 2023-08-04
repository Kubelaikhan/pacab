<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login_model extends CI_Model
{
	
	public function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}
	
	function cabang_available($where){
	    $this->db->from('mskaryawan k');
	    $this->db->where($where);
	    return $this->db->get()->num_rows();
	}

	function get_password($where){
		$this->db->from('users u')->join('mskaryawan k', 'u.nik = k.nik')->where($where, 'COLLATE utf8_general_ci');
		return $this->db->get()->row()->pass2;
	}

	function get_cabang($where){
	    $this->db->from('mskaryawan k');
	    $this->db->join('mscabang c', 'k.kode_cabang = c.kode_cabang');
	    $this->db->where($where);
	    $query = $this->db->get();
	    return $query->result();
	}
	
	function get_ho(){
	    $this->db->from('mscabang');
	    $this->db->where('inisial', 'HO');
	    $query = $this->db->get();
	    return $query->row()->kode_cabang;
	}

	function change_password($table, $data, $where){
		return $this->db->update($table, $data, $where);
	}

	function cek_row(){
		$query = $this->db->query('select count(`nik`) as total from `mskaryawan` where aktif = "Y" and nik NOT IN (select nik FROM cl_msauth);');
		return $query->row()->total;
	}

	function get_nik_nama(){
		return $this->db->query("select nik, nama, kode_cabang from `mskaryawan` where aktif = 'Y' order by nama")->result();
		
	}

	function get_authorisasi_departemen($where){
		$this->db->from('mskaryawan k');
		$this->db->join('mscabang c', 'k.kode_cabang = c.kode_cabang');
		$this->db->where($where);
		$this->db->where("departemen IN (600, 500, 'A10', 'A00', 100)");
		$query = $this->db->get();
		return $query->result();
		// return $this->db->query("SELECT * FROM mskaryawan k join mscabang c on a.kode_cabang = c.kode_cabang WHERE nik = '$nik' and departemen IN(600,500,'A10','A00') AND a.aktif = 'Y'")->result();
	}

}

?>