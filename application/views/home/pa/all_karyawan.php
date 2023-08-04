<?php $this->load->view('layout/header.php');?>
<!-- <meta http-equiv="refresh" content="120"> -->
    <div class="wrapper">
        <?php $this->load->view('layout/sidebar.php')?>
        <div id="content" class="content text-center" style="">
            <?php $this->load->view('layout/top_menu.php');?>
            <?php $msg = $this->session->flashdata('msg');
                if(isset($msg)){echo $this->session->flashdata('msg');$this->session->unset_userdata('msg');}?>
            <!--<div class="container-fluid" style="background: #f2f2f2;position: relative; min-height: 76vh;">-->
            <div class="container-fluid rounded shadow" style="background: #fcfbfc;position: relative; height: 82vh;overflow-y:scroll" id="konten">
                <div class="row pt-3 pl-3 pr-3">
                    <div class="col-md-3 text-left">
                    <a href="<?php echo base_url('home') ?>" class="btn btn-sm btn-secondary" onclick="loader()"><i class="fas fa-chevron-left"></i> Kembali</a>&ensp;
                        <a href="<?php echo base_url('pa/lihatAllKaryawan');?>" class="btn btn-sm btn-secondary" onclick="loader()"><i class="fas fa-sync"></i></a>
                    </div>
                    <div class="col-md-6"><h4>LIST FORM PA KARYAWAN</h4></div>
                    <div class="col-md-3 text-right">
                        <a href="javascript:;" data-toggle="modal" data-placement="bottom" title="INFO NILAI" data-target="#info-nilai" class="btn btn-sm btn-tosca"><i class="fas fa-question-circle"></i></a>
                    </div>
                </div>
                <hr width="100%">
                <div class="col-md-12 text-left rounded pl-3 pr-3 pt-2" style="font-size:14px;">
                    <form method="POST" action="<?php echo base_url('pa/lihatAllKaryawan');?>">
                        <?php
                            $tahun = $this->pa_model->get_tahun();
                            $bln = array('01','02','03','04','05','06','07','08','09','10','11','12');
                            $nm_bln = array(
                                'Januari',
                                'Februari',
                                'Maret',
                                'April',
                                'Mei',
                                'Juni',
                                'Juli',
                                'Agustus',
                                'September',
                                'Oktober',
                                'November',
                                'Desember' 
                            );
                        ?> 
                        <div class="form-group row pl-3">
                            <div class="col-md-2"></div>
                            <div class="col-md-1">
                                <label>Jenis PA<font color="red"><i><sup>*</sup></i></font></label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control form-control-sm" name="jenis_pa">
                                    <option value="ALL" <?php if($jenis_pa == 'ALL' || $jenis_pa == ''){ echo 'selected'; }?>>-- ALL --</option>
                                    <option value="SMT" <?php if($jenis_pa == 'SMT'){ echo 'selected'; }?>>SEMESTER</option>
                                    <option value="KHS" <?php if($jenis_pa == 'KHS'){ echo 'selected'; }?>>KHUSUS</option>
                                </select>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-1">
                                <label style="font-size:11px">Cabang</label>
                            </div>
                            <div class="col-md-3">
                                    <select class="form-control form-control-md" id="cabang"name="cabang">
                                        <option value="" <?php if($cabang == 'ALL' || $cabang == ''){ echo 'selected'; }?>>--PILIH CABANG--</option>
                                        <?php foreach($cabang as $d){?>
                                            <option value="<?php echo $d->kode_cabang;?>" <?php if($cabs == $d->kode_cabang){echo 'selected';} ?>><?php echo $d->kode_cabang.'-'.$d->nama_cabang;?></option>
                                        <?php }?>
                                    </select>
                            </div>
                            <!-- <div class="col-md-1">
                                <label style="font-size:11px">Approved By</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control form-control-sm" name="bod">
                                    <option value="">--PILIH BOD--</option>
                                    <option <?php if($bod == '10000001'){ echo 'selected'; }?> value="10000001">Pak Sapari</option>
                                    <option <?php if($bod == '10000002'){ echo 'selected'; }?> value="10000002">Bu Unilahwati</option>
                                </select>
                            </div> -->
                        </div>
                        <div class="form-group row pl-3">
                            <div class="col-md-2"></div>
                            <div class="col-md-1">
                                <label>Dari<font color="red"><i><sup>*</sup></i></font></label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control form-control-sm" name="bulan1">
                                    <?php for($i = 0; $i < 12; $i++){?>
                                        <option value="<?php echo $bln[$i];?>" <?php if($bln[$i] == $bulan1 ){echo 'selected';}?>><?php echo $nm_bln[$i];?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-md-1.5">
                                <select class="form-control form-control-sm" name="tahun1">
                                    <?php foreach($tahun as $t){?>
                                        <option value="<?php echo $t->tahun;?>" <?php if($t->tahun == $tahun1){echo 'selected';}?>><?php echo $t->tahun;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <!-- <div class="col-md-1"></div> -->
                            <div class="col-md-1">
                                <label>Sampai<font color="red"><i><sup>*</sup></i></font></label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control form-control-sm" name="bulan2">
                                    <?php for($i = 0; $i < 12; $i++){?>
                                        <option value="<?php echo $bln[$i];?>" <?php if($bln[$i] == $bulan2){echo 'selected';}?>><?php echo $nm_bln[$i];?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-md-1.5">
                                <select class="form-control form-control-sm" name="tahun2">
                                    <?php foreach($tahun as $t){?>
                                        <option value="<?php echo $t->tahun;?>" <?php if($t->tahun == $tahun2){echo 'selected';}?>><?php echo $t->tahun;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <!-- <div class="col-md-1"></div> -->
                            
                            <div class="col-md-1 text-center">
                                <!-- <label class="" style="color: #f2f2f2">.</label><br/> -->
                                <button type="submit" class="btn btn-secondary btn-sm">View</button>
                            </div>
                        </div>
                  </form>
                </div>
                <hr width="100%">
                <div class="table-responsive rounded pl-3 pr-3 pt-2">
                    <table class="table table-bordered table-hover table-sm shadow" id="table" style="border: 2px solid !important; font-size: 12px">
                        <thead>
                            <tr>
                                <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">NO <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 8%; border: 1px solid #000;">KODE PA <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 8%; border: 1px solid #000;">CABANG <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 8%; border: 1px solid #000;">NIK  <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 15%; border: 1px solid #000;">NAMA <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">JENIS <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">SUBJENIS <i class="fas fa-sort"></i></th>
                                <!-- <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">TGL MASUK <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">MASA KERJA <i class="fas fa-sort"></i></th> -->
                                <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">TGL PENILAIAN <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">PERIODE PENILAIAN <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 8%; border: 1px solid #000;">AVG <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 8%; border: 1px solid #000;">NILAI <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 8%; border: 1px solid #000;">STATUS <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">OPSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if(empty($header)){?>
                                <tr><td colspan="12">DATA TIDAK DITEMUKAN</td></tr>
                            <?php }else{
                                foreach($header as $header){
                                    $date_now = date_create($header->tgl_periode2);
                                    $date_gabung = date_create($header->tgl_gabung);
                                    $masa_kerja = date_diff($date_now,$date_gabung);
                                    $bulan = $masa_kerja->m;
                                    $tahun = $masa_kerja->y;
                                    // if ($header->status_process == 1 AND $header->status_confirmed == 0) {
                                    //     $status ='PROCESS';
                                    // }elseif($header->status_confirmed == 1 AND $header->status_agree == 0){
                                    //     $status ='CONFIRMED';
                                    // }elseif($header->status_agree == 1 AND $header->status_accepted == 0){
                                    //     $status ='AGREE';
                                    // }elseif($header->status_accepted == 1 AND $header->status_approved == 0) {
                                    //     $status ='ACCEPTED';
                                    // }elseif($header->status_approved == 1){
                                    //     $status ='APPROVED';
                                    // }

                                    if($header->nilai_ratarata <= 100 and $header->nilai_ratarata > 89){
                                        $nilai ='A';
                                    }elseif($header->nilai_ratarata <= 89 and $header->nilai_ratarata > 78){
                                        $nilai = 'B';
                                    }elseif($header->nilai_ratarata <= 78 and $header->nilai_ratarata > 67){
                                        $nilai = 'C';
                                    }elseif($header->nilai_ratarata <= 67 and $header->nilai_ratarata > 56){
                                        $nilai = 'D';
                                    }elseif($header->nilai_ratarata <= 56 and $header->nilai_ratarata > 45){
                                        $nilai = 'E';
                                    }else{
                                        $nilai = '';
                                    }

                                    if (substr($header->jenis_pa,0,1) == 'S') {
                                        $jenis_pa = 'SEMESTER';
                                    }else{
                                        $jenis_pa = 'KHUSUS';
                                    }
                                    if (substr($header->jenis_pa,0,1) == 'S') {
                                        $det_jns = 'SEMESTER '.substr($header->jenis_pa, 1,2);
                                    }else{
                                        if (substr($header->jenis_pa, 0,2) == 'HK') {
                                            $det_jns = 'HABIS KONTRAK';
                                        }else{
                                            $det_jns = 'LAINNYA';
                                        }
                                    }
                            ?>
                            <tr>
                                <td style="border: 1px solid #000;"><?php echo $no++;?></td>
                                <td style="border: 1px solid #000;"><?php echo $header->kode_pa;?></td>
                                <td style="border: 1px solid #000;"><?php echo $header->kode_cabang;?></td>
                                <td style="border: 1px solid #000;"><?php echo $header->nik?></td>
                                <td style="border: 1px solid #000;"><?php echo $header->nama?></td>
                                <!-- <td style="border: 1px solid #000;"><?php echo $header->tgl_gabung?></td>
                                <td style="border: 1px solid #000;"><?php echo $tahun.' Tahun '.$bulan.' Bulan'?></td> -->
                                <td style="border: 1px solid #000;"><?php echo $jenis_pa?></td>
                                <td style="border: 1px solid #000;"><?php echo $det_jns?></td>
                                <td style="border: 1px solid #000;"><?php echo date('d M Y', strtotime($header->tgl_penilaian)).' s/d '.date('d M Y', strtotime($header->tgl_periode2))?></td>
                                <td style="border: 1px solid #000;"><?php echo $header->periode?></td>
                                <td style="border: 1px solid #000;"><?php echo $header->nilai_ratarata?></td>
                                <td style="border: 1px solid #000;"><?php echo $nilai?></td>
                                <td style="border: 1px solid #000;"><?php echo $header->status ?></td>
                                <td style="border: 1px solid #000;">
                                    <?php 
                                        $isi = $this->pa_model->isi_detail($header->kode_pa);
                                        $jml = $this->pa_model->jml_detail($header->kode_pa);
                                    ?>
                                    <a href="<?php echo base_url('pa/lihatDetailKaryawan/'.$header->kode_pa)?>" class="btn btn-xs <?php if($header->status == 'CONFIRMED SOH' || $header->status =='AGREE'){ echo 'btn-success'; }else{ echo 'btn-secondary'; }?>" data-placement="bottom">D</a>
                                </td>
                            </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                    <br><br><br><br>
                    <!-- <div class="text-right pl-3 pr-4 pt-2" style="border: 1px; font-size:12px;">
                        <tr>
                            <th>Keterangan : &nbsp;&nbsp;</th>
                            <th>&nbsp;<a href="" class="btn btn-xs btn-success"></a> Data Belum Disetujui&nbsp;</th>
                            <th>&nbsp;<a href="" class="btn btn-xs btn-secondary"></a> Data Sudah Disetujui</th>
                        </tr>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="" id="load" style="visibility: hidden">
            <div id="content" class="content bg-secondary" style="opacity: 0.1; position: fixed;"></div>
            <img src="<?php echo base_url('assets/images/loader.gif');?>" width="80" style="position: fixed;z-index:5;top:45%;left:55%">
        </div>
    </div>



<!-- Modal Info-->
<div class="modal fade" id="info-nilai" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-nobby">
                <h5 class="modal-title text-light" id="exampleModalLabel">INTERVAL NILAI</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="table-responsive rounded pl-3 pr-3 pt-2">
                <table class="table table-bordered table-hover table-sm shadow" id="table" style="border: 2px solid !important; font-size: 12px">
                    <thead>
                        <tr>
                            <th class="bg-nobby text-light text-center" colspan="2" style="width: 5%; border: 1px solid #000;">KRITERIA NILAI <i class="fas fa-sort"></i></th>
                            <th class="bg-nobby text-light text-center" style="width: 5%; border: 1px solid #000;">PREDIKAT <i class="fas fa-sort"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($interval as $int){ ?>
                        <tr>
                            <td class="text-center" style="border: 1px solid #000;"><?php echo $int->skor1.' - '.$int->skor;?></td>
                            <td class="text-center" style="border: 1px solid #000;"><?php echo $int->nilai?></td>
                            <td class="text-center" style="border: 1px solid #000;"><?php echo $int->predikat?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL INFO-->
<script type="text/javascript">

        $(document).ready(function(){
            $('#nik').select2();
        });

        $(document).ready(function(){
            $('#cabang').select2();
        });

    $(function () {
        $('#table').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "info": false,
            "autoWidth": true
        });
    });
</script>
<?php $this->load->view('layout/footer.php')?>