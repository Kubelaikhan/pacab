<?php $this->load->view('layout/header.php');?>
<div class="table-responsive rounded" style="background: #f2f2f2;padding-left: 2%;padding-right: 2%">
    <div class="text-center">
        <h4>HASIL PENILAIAN KINERJA KARYAWAN</h4>
        <h4>PT BASA INTI PERSADA</h4>
    </div>
    <div class="row">
        <div class="col-lg-8 pt-3">
            <form action="<?php echo base_url('exportexcel')?>" method="post">
                <input type="hidden" name="jenis" value="<?php echo $jenis?>">
                <input type="hidden" name="tahun" value="<?php echo $tahun?>">
                <input type="hidden" name="cabang" value="<?php echo $cabang?>">
                <button type="submit" class="btn btn-sm btn-success">Export to Excel <i class="fas fa-arrow-right"></i> <i class="fas fa-file-excel"></i></button>
            </form>
            <br>
                <table class="table table-bordered table-hover table-sm shadow pt-2 pl-3 pr-3 pb-3" style="border: 2px solid !important; font-size: 12px">
                    <thead>
                        <tr>
                            <th class="bg-nobby text-light text-center" style="width: 5%; border: 1px solid #000;">NO <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 30%; border: 1px solid #000;">KODE PA <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 30%; border: 1px solid #000;">KODE CABANG <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 15%; border: 1px solid #000;">NIK <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 15%; border: 1px solid #000;">NAMA <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 15%; border: 1px solid #000;">STATUS <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 15%; border: 1px solid #000;">JABATAN <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 15%; border: 1px solid #000;">TGL MASUK <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 15%; border: 1px solid #000;">MASA KERJA <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 15%; border: 1px solid #000;">TGL PENILAIAN <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 15%; border: 1px solid #000;">PERIODE <br> PENILAIAN <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 15%; border: 1px solid #000;">TUJUAN PENILAIAN <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 15%; border: 1px solid #000;">KETERANGAN <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 15%; border: 1px solid #000;">NILAI PA <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 15%; border: 1px solid #000;">NILAI KPI <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 15%; border: 1px solid #000;">NILAI PA & KPI <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 15%; border: 1px solid #000;">NILAI <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 15%; border: 1px solid #000;">REKOMENDASI <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 15%; border: 1px solid #000;">PREDIKAT <i class="fas fa-sort"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;                                                    
                        if(empty($summary)){?>
                            <tr><td class="text-center" colspan="18">DATA KOSONG ATAU TIDAK DITEMUKAN</td></tr>
                        <?php }else{
                            foreach($summary as $s){

                                $date_now = date_create($s->tgl_periode2);
                                $date_gabung = date_create($s->tgl_gabung);
                                $masa_kerja = date_diff($date_now,$date_gabung);
                                $bln = $masa_kerja->m;
                                $thn = $masa_kerja->y;
                                $hari = $masa_kerja->d;

                                if($s->nilai_ratarata == NULL || $s->nilai_ratarata == ""){
                                    if($s->nilai_ratarata <= 100 and $s->nilai_ratarata > 89){
                                        $nilai ='A';
                                        $predikat ='Sangat Baik';
                                    }elseif($s->nilai_ratarata <= 89 and $s->nilai_ratarata > 78){
                                        $nilai = 'B';
                                        $predikat = 'Baik';
                                    }elseif($s->nilai_ratarata <= 78 and $s->nilai_ratarata > 67){
                                        $nilai = 'C';
                                        $predikat = 'Cukup';
                                    }elseif($s->nilai_ratarata <= 67 and $s->nilai_ratarata > 56){
                                        $nilai = 'D';
                                        $predikat = 'Kurang';
                                    }elseif($s->nilai_ratarata <= 56 and $s->nilai_ratarata > 45){
                                        $nilai = 'E';
                                        $predikat = 'Kurang Sekali';
                                    }else{
                                        $nilai = '';
                                        $predikat = '';
                                    }
    
                                    $nilai_pa_kpi = 0;
                                } else {

                                    $nilai_pa_kpi = ($s->nilai_ratarata * 40/100) + ($s->nilai_kpi * 60/100);
                                    
    
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
                                }


                            ?>
                        <tr>
                            <td class="text-right" style="border: 1px solid #000;"><?php echo $no++;?></td>
                            <td style="border: 1px solid #000;"><?php echo $s->kode_pa?></td>
                            <td style="border: 1px solid #000;"><?php echo $s->kode_cabang?></td>
                            <td class="text-left" style="border: 1px solid #000;"><?php echo $s->nik?></td>
                            <td class="text-left" style="border: 1px solid #000;"><?php echo $s->nama?></td>
                            <td class="text-left" style="border: 1px solid #000;"><?php echo $s->status_karyawan?></td>
                            <td class="text-left" style="border: 1px solid #000;"><?php echo $s->jabatan?></td>
                            <td class="text-left" style="border: 1px solid #000;"><?php echo $s->tgl_gabung?></td>
                            <td class="text-left" style="border: 1px solid #000;"><?php echo $thn.' Tahun '.$bln.' Bulan '.$hari.' Hari'?></td>
                            <td class="text-left" style="border: 1px solid #000;"><?php echo $s->tgl_penilaian?></td>
                            <td class="text-left" style="border: 1px solid #000;"><?php echo $s->periode?></td>
                            <td class="text-left" style="border: 1px solid #000;"><?php echo $s->tujuan_penilaian?></td>
                            <td class="text-left" style="border: 1px solid #000;"><?php echo wordwrap($s->keterangan,50,"<br>\n")?></td>
                            <td class="text-center" style="border: 1px solid #000;"><?php echo $s->nilai_ratarata?></td>
                            <td class="text-center" style="border: 1px solid #000;"><?php echo $s->nilai_kpi?></td>
                            <td class="text-center" style="border: 1px solid #000;"><?php echo $nilai_pa_kpi?></td>
                            <td class="text-center" style="border: 1px solid #000;"><?php echo $nilai?></td>
                            <td class="text-left" style="border: 1px solid #000;"><?php echo wordwrap($s->rekomendasi,50,"<br>\n")?></td>
                            <td class="text-center" style="border: 1px solid #000;"><?php echo $predikat?></td>
                        </tr>
                        <?php }
                        }?> 
                    </tbody>
                </table>
            </div>
        </div><br/>
        <div class="col text-center">
            <button class="btn btn-secondary" onclick="window.close();">TUTUP</button>
        </div>
    </div>
</div>

                