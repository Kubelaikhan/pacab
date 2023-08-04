<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExportExcel extends CI_Controller {

	// Include librari PhpSpreadsheet
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
		$dept = $this->input->post('dept');	
		$this->load->library("excel");
      	
      	$spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();

    	 // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
	    $style_col = [
	      'font' => ['bold' => true], // Set font nya jadi bold
	      'alignment' => [
	        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
	        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
	      ],
	      'borders' => [
	        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
	        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
	        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
	        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
	      ]
	    ];
	    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
	    $style_row = [
	      'alignment' => [
	        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
	      ],
	      'borders' => [
	        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
	        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
	        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
	        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
	      ]
	    ];
	    
		$table_columns = array("NO", "KODE PA", "NIK", "NAMA", "STATUS", "JABATAN", "TGL MASUK", "MASA KERJA", "TGL PENILAIAN", "PERIODE PENILAIAN", "TUJUAN PENILAIAN", "KETERANGAN", "NILAI PA", "NILAI KPI", "NILAI PA & KPI", "NILAI", "REKOMENDASI", "PREDIKAT");
		$column = 0;
		foreach($table_columns as $field){
			$object->getActiveSheet()->getStyle('E4:R4')->getAlignment()->setWrapText(true); 
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, 4, $field)->getStyle('A4:R4')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '00BFFF')), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER), 'font'=> array('size' => 12,'bold' => true,'color' => array('rgb' => '000000'))));;
			$column++;
		}

		$object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$object->getActiveSheet()->getColumnDimension('B')->setWidth(12);
		$object->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$object->getActiveSheet()->getColumnDimension('D')->setWidth(23);
		$object->getActiveSheet()->getColumnDimension('E')->setWidth(11);
		$object->getActiveSheet()->getColumnDimension('F')->setWidth(35);
		$object->getActiveSheet()->getColumnDimension('G')->setWidth(13);
		$object->getActiveSheet()->getColumnDimension('H')->setWidth(21);
		$object->getActiveSheet()->getColumnDimension('I')->setWidth(12);
		$object->getActiveSheet()->getColumnDimension('J')->setWidth(23);
		$object->getActiveSheet()->getColumnDimension('K')->setWidth(30);
		$object->getActiveSheet()->getColumnDimension('L')->setWidth(52);
		$object->getActiveSheet()->getColumnDimension('M')->setWidth(8);
		$object->getActiveSheet()->getColumnDimension('N')->setWidth(8);
		$object->getActiveSheet()->getColumnDimension('O')->setWidth(8);
		$object->getActiveSheet()->getColumnDimension('P')->setWidth(8);
		$object->getActiveSheet()->getColumnDimension('Q')->setWidth(52);
		$object->getActiveSheet()->getColumnDimension('R')->setWidth(12);

		$nilai_row = $this->pa_model->get_summary($jenis, $tahun, $dept);
		
		$excel_row = 5;
		$no = 1;
      	foreach($nilai_row as $row){
      		$date_now = date_create($row->tgl_penilaian);
            $date_gabung = date_create($row->tgl_gabung);
            $masa_kerja = date_diff($date_now,$date_gabung);
            $bln = $masa_kerja->m;
            $thn = $masa_kerja->y;
            $hari = $masa_kerja->d;

            $nilai_pa_kpi = ($row->nilai_ratarata * 40/100)+($row->nilai_kpi * 60/100);
            if($nilai_pa_kpi <= 100 and $nilai_pa_kpi > 89){
                $nilai ='A';
                $predikat ='Sangat Baik';
            }elseif($nilai_pa_kpi <= 89 and $nilai_pa_kpi > 78){
                $nilai = 'B';
                $predikat = 'Baik';
            }elseif($nilai_pa_kpi <= 78 and $nilai_pa_kpi > 67){
                $nilai = 'C';
                $predikat = 'Cukup';
            }elseif($nilai_pa_kpi <= 67 and $nilai_pa_kpi > 56){
                $nilai = 'D';
                $predikat = 'Kurang';
            }elseif($nilai_pa_kpi <= 56 and $nilai_pa_kpi > 45){
                $nilai = 'E';
                $predikat = 'Kurang Sekali';
            }else{
                $nilai = '';
                $predikat = '';
            }
            // judul
            $object->getActiveSheet()->mergeCells('A1:R1')->getStyle('A1:A1')->applyFromArray(array('font' => array('size' => 18,'bold' => true,'color' => array('rgb' => '000000')), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
            $object->getActiveSheet()->setCellValue( "A1", "HASIL PENILAIAN KINERJA KARYAWAN");
            $object->getActiveSheet()->mergeCells('A2:R2')->getStyle('A2:A2')->applyFromArray(array('font' => array('size' => 18,'bold' => true,'color' => array('rgb' => '000000')), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
            $object->getActiveSheet()->setCellValue( "A2", "PT BASA INTI PERSADA" );
            // judul end 

            $object->getActiveSheet()->getStyle('A1:R999')->getAlignment()->setWrapText(true); 
        	$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $no);
        	$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->kode_pa);
			$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->nik);
			$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->nama);
			$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->status_karyawan);
			$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->jabatan);
			$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->tgl_gabung);
			$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $thn.' Tahun '.$bln.' Bulan '.$hari.' Hari');
			$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->tgl_penilaian);
			$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->periode);
			$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->tujuan_penilaian);
			$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, wordwrap($row->keterangan,50,"\n"));
			$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row->nilai_ratarata);
			$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $row->nilai_kpi);
			$object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $nilai_pa_kpi);
			$object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $nilai);
			$object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, wordwrap($row->rekomendasi,50,"\n"));
			$object->getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, $predikat);
	        $excel_row++;
	        $no++;
      	}
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Report_penilaian_kinerja_'.$tahun.$jenis.'.xlsx"');
		$object_writer->save('php://output');
	}

}
