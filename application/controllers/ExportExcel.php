<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExportExcel extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url', 'html', 'file'));
		$this->load->library(array('session', 'form_validation', 'upload', 'user_agent'));
		$this->load->database();
		$this->load->model(array('login_model', 'pa_model'));
		$this->session->keep_flashdata('msg');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index(){
		$jenis = $this->input->post('jenis');
		$tahun = $this->input->post('tahun');	
		// $dept = $this->input->post('dept');	
		$cabang = $this->input->post('cabang');	
		$this->load->library("excel");
      	$object = new PHPExcel();
    	$object->setActiveSheetIndex(0)->setTitle("Sheet1"); //->setTitle("asd") to add worksheet title
		$table_columns = array("NO", "KODE PA", "KODE CABANG", "NIK", "NAMA", "STATUS", "JABATAN", "TGL MASUK", "MASA KERJA", "TGL PENILAIAN", "PERIODE PENILAIAN", "TUJUAN PENILAIAN","KETERANGAN", "NILAI RATA-RATA", "NILAI PA", "REKOMENDASI", "PREDIKAT");
		$column = 0;
		foreach($table_columns as $field){
			$object->getActiveSheet()->getStyle('E4:Q4')->getAlignment()->setWrapText(true); 
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, 4, $field)->getStyle('A4:Q4')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '00BFFF')), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font'=> array('size' => 12,'bold' => true,'color' => array('rgb' => '000000'))));;
			$column++;
		}

		$object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$object->getActiveSheet()->getColumnDimension('B')->setWidth(23);
		$object->getActiveSheet()->getColumnDimension('C')->setWidth(23);
		$object->getActiveSheet()->getColumnDimension('D')->setWidth(23);
		$object->getActiveSheet()->getColumnDimension('E')->setWidth(23);
		$object->getActiveSheet()->getColumnDimension('F')->setWidth(11);
		$object->getActiveSheet()->getColumnDimension('G')->setWidth(35);
		$object->getActiveSheet()->getColumnDimension('H')->setWidth(13);
		$object->getActiveSheet()->getColumnDimension('I')->setWidth(21);
		$object->getActiveSheet()->getColumnDimension('J')->setWidth(12);
		$object->getActiveSheet()->getColumnDimension('K')->setWidth(23);
		$object->getActiveSheet()->getColumnDimension('L')->setWidth(30);
		$object->getActiveSheet()->getColumnDimension('M')->setWidth(52);
		$object->getActiveSheet()->getColumnDimension('N')->setWidth(12);
		$object->getActiveSheet()->getColumnDimension('O')->setWidth(8);
		$object->getActiveSheet()->getColumnDimension('P')->setWidth(52);
		$object->getActiveSheet()->getColumnDimension('Q')->setWidth(12);

		$nilai = $this->pa_model->get_summary($jenis, $tahun, $cabang);
		$excel_row = 5;
		$no = 1;
      	foreach($nilai as $row){
      		$date_now = date_create($row->tgl_penilaian);
            $date_gabung = date_create($row->tgl_gabung);
            $masa_kerja = date_diff($date_now,$date_gabung);
            $bln = $masa_kerja->m;
            $thn = $masa_kerja->y;
            $hari = $masa_kerja->d;

            if($row->nilai_ratarata <= 100 and $row->nilai_ratarata > 89){
                $nilai_pa ='A';
                $predikat ='Sangat Baik';
            }elseif($row->nilai_ratarata <= 89 and $row->nilai_ratarata > 78){
                $nilai_pa = 'B';
                $predikat = 'Baik';
            }elseif($row->nilai_ratarata <= 78 and $row->nilai_ratarata > 67){
                $nilai_pa = 'C';
                $predikat = 'Cukup';
            }elseif($row->nilai_ratarata <= 67 and $row->nilai_ratarata > 56){
                $nilai_pa = 'D';
                $predikat = 'Kurang';
            }elseif($row->nilai_ratarata <= 56 and $row->nilai_ratarata > 45){
                $nilai_pa = 'E';
                $predikat = 'Kurang Sekali';
            }else{
                $nilai_pa = '';
                $predikat = '';
            }
            // judul
            $object->getActiveSheet()->mergeCells('A1:P1')->getStyle('A1:A1')->applyFromArray(array('font' => array('size' => 18,'bold' => true,'color' => array('rgb' => '000000')), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
            $object->getActiveSheet()->setCellValue( "A1", "HASIL PENILAIAN KINERJA KARYAWAN");
            $object->getActiveSheet()->mergeCells('A2:P2')->getStyle('A2:A2')->applyFromArray(array('font' => array('size' => 18,'bold' => true,'color' => array('rgb' => '000000')), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
            $object->getActiveSheet()->setCellValue( "A2", "PT BASA INTI PERSADA" );
            // judul end 

            $object->getActiveSheet()->getStyle('A1:P999')->getAlignment()->setWrapText(true); 
        	$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $no);
        	$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->kode_pa);
			$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->kode_cabang);
			$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->nik);
			$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->nama);
			$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->status_karyawan);
			$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->jabatan);
			$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->tgl_gabung);
			$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $thn.' Tahun '.$bln.' Bulan '.$hari.' Hari');
			$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->tgl_penilaian);
			$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->periode);
			$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row->tujuan_penilaian);
			$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, wordwrap($row->keterangan,50,"\n"));
			$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $row->nilai_ratarata);
			$object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $nilai_pa);
			$object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, wordwrap($row->rekomendasi,50,"\n"));
			$object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, $predikat);
	        $excel_row++;
	        $no++;
      	}
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Report_penilaian_kinerja_'.$tahun.$jenis.'.xlsx"');
		$object_writer->save('php://output');
	}

}
