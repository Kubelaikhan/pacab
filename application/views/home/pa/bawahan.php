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
                        <a href="<?php echo base_url('pa/lihatBawahan');?>" class="btn btn-sm btn-secondary" onclick="loader()"><i class="fas fa-sync"></i></a>
                    </div>
                    <div class="col-md-6"><h4>LIST FORM PA BAWAHAN</h4></div>
                    <div class="col-md-3 text-right">
                        <a href="javascript:;" data-toggle="modal" data-placement="bottom" title="INFO NILAI" data-target="#info-nilai" class="btn btn-sm btn-tosca"><i class="fas fa-question-circle"></i></a>
                    </div>
                </div>
                <div class="table-responsive rounded pl-3 pr-3 pt-2">
                    <table class="table table-bordered table-hover table-sm shadow" id="table" style="border: 2px solid !important; font-size: 12px">
                        <thead>
                            <tr>
                                <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">NO <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 8%; border: 1px solid #000;">KODE PA <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 8%; border: 1px solid #000;">NIK  <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 15%; border: 1px solid #000;">NAMA <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">JENIS <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">SUBJENIS <i class="fas fa-sort"></i></th>
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
                                <tr><td colspan="11">DATA TIDAK DITEMUKAN</td></tr>
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
                                <td style="border: 1px solid #000;"><?php echo $header->nik?></td>
                                <td style="border: 1px solid #000;"><?php echo $header->nama?></td>
                                <td style="border: 1px solid #000;"><?php echo $jenis_pa?></td>
                                <td style="border: 1px solid #000;"><?php echo $det_jns?></td>
                                <td style="border: 1px solid #000;"><?php echo date('d M Y', strtotime($header->tgl_penilaian)).' s/d '.date('d M Y', strtotime($header->tgl_periode2))?></td>
                                <td style="border: 1px solid #000;"><?php echo $header->periode?></td>
                                <td style="border: 1px solid #000;"><?php echo $header->nilai_ratarata?></td>
                                <td style="border: 1px solid #000;"><?php echo $nilai?></td>
                                <td style="border: 1px solid #000;"><?php echo $header->status?></td>
                                <td style="border: 1px solid #000;">
                                    <?php 
                                        $isi = $this->pa_model->isi_detail($header->kode_pa);
                                        $jml = $this->pa_model->jml_detail($header->kode_pa);
                                        $dept = $this->pa_model->cek_dept($header->nik);
                                        $atasan = $this->pa_model->cek_atasan($header->nik);
                                        $manager = $this->pa_model->cek_manager($dept[0]->departemen);
                                    ?>
                                    <a href="<?php echo base_url('pa/lihatDetailBawahan/'.$header->kode_pa)?>" class="btn btn-xs <?php if($isi == $jml AND ($header->status == 'PROCESS' || ($header->status == 'AGREE' && $atasan == $manager)) AND $header->nik == $header->user_input){ echo 'btn-success'; }elseif($isi != $jml AND $header->status == 'PROCESS'){ echo 'btn-warning text-light'; }else{ echo 'btn-secondary'; }?>" data-placement="bottom">D</a>
                                </td>
                            </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                    <br><br><br><br>
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