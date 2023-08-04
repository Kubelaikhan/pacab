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
                    <a href="javascript: history.go(-1)" class="btn btn-sm btn-secondary" onclick="loader()"><i class="fas fa-chevron-left"></i> Kembali</a>&ensp;
                        <a href="<?php echo base_url('pa/cabangHRD/'.$this->uri->segment(3));?>" class="btn btn-sm btn-secondary" onclick="loader()"><i class="fas fa-sync"></i></a>
                    <!-- <?php if($this->session->userdata('dept') == 'A00' OR $this->session->userdata('dept') == 'A10' OR $this->session->userdata('dept') == '500'  ){?>
                        <a href="javascript:;" data-toggle="modal" data-placement="bottom" title="TAMBAH PENILAIAN" data-target="#tambah-jenis" class="btn btn-sm btn-success"><i class="fas fa-plus"></i></a>
                    <?php } ?> -->
                    </div>
                    <div class="col-md-6"><h4>TABEL JENIS</h4></div>
                    <div class="col-md-3 text-right">
                        <a href="javascript:;" data-toggle="modal" data-placement="bottom" title="INFO NILAI" data-target="#info-nilai" class="btn btn-sm btn-tosca"><i class="fas fa-question-circle"></i></a>
                    </div>
                </div>
                <div class="table-responsive rounded pl-3 pr-3 pt-2">
                    <table class="table table-bordered table-hover table-sm shadow" id="table" style="border: 2px solid !important; font-size: 12px">
                        <thead>
                            <tr>
                                <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">NO <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 8%; border: 1px solid #000;">KODE CABANG <i class="fas fa-sort"></i></th>                                
                                <th class="bg-nobby text-light" style="width: 8%; border: 1px solid #000;"> NAMA CABANG <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 8%; border: 1px solid #000;"> ACTION <i class="fas fa-sort"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if(empty($header)){?>
                                <tr><td colspan="13">DATA TIDAK DITEMUKAN</td></tr>
                            <?php }else{
                                foreach($header as $header){
                                    // $date_now = date_create($header->tgl_periode2);
                                    // $date_gabung = date_create($header->tgl_gabung);
                                    // $masa_kerja = date_diff($date_now,$date_gabung);
                                    // $bulan = $masa_kerja->m;
                                    // $tahun = $masa_kerja->y;
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

                            ?>
                            <tr>
                                <td style="border: 1px solid #000;"><?php echo $no++;?></td>
                                <td style="border: 1px solid #000;"><?php echo $header->cabang;?></td>
                                <td style="border: 1px solid #000;"><?php echo $header->nama_cabang;?></td>
                                <td style="border: 1px solid #000;">
                                <?php if($this->session->userdata('level') == '240' || $this->session->userdata('level') == "210"){?>
                                    <a href="<?php echo base_url('pa/lihatFormulir/'.$header->kd_jenis)?>" data-toggle="modal" data-target="#modal-karyawan" class="btn btn-xs btn-success">+</a>
                                    <a href="<?php echo base_url('pa/formPerformance/'.$header->kd_jenis)?>" class="btn btn-xs btn-secondary">D</a>
                                <?php } ?>
                                <?php if( $this->session->userdata('level') == '130' AND $this->session->userdata('cabang') == "NH000" AND $this->session->userdata('dept') == '600'){?>
                                    <a href="<?php echo base_url('pa/formPerformanceSOH/'.$header->kd_jenis)?>" class="btn btn-xs btn-secondary">D</a>
                                <?php } ?>
                                <?php if($this->session->userdata('dept') == 'A10' || $this->session->userdata('dept') == 'A00'){?>
                                    <a href="<?php echo base_url('pa/formPerformanceHRD/'.$this->uri->segment(3).'/'.$header->cabang)?>" class="btn btn-xs btn-secondary">D</a>
                                <?php } ?>
                                <!-- <?php if( $header->user_input == $header->nik){?> -->
                                    <!-- <a href="<?php echo base_url('pa/hapusForm/'.$header->id.'/'.$header->kd_jenis)?>" class="btn btn-xs btn-danger" onclick="return confirm('Yakin Ingin Hapus Data?')">X</a> -->
                                    <!-- <?php }?> -->
                                </td>

                    <!-- Modal Karyawan-->
                            <div class="modal fade" id="modal-karyawan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-nobby">
                                            <h5 class="modal-title text-light" id="exampleModalLabel">Konfirmasi Data Diri</h5>
                                            <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="table-responsive rounded pl-3 pr-3 pt-2">
                                            <form action="<?php echo base_url('pa/simpanPesertaJenis');?>"  method="post">
                                                
                                                <input hidden type="text" name="kd_jenis" value="<?=$header->kd_jenis?>">
                                                <div class="modal-body">
                                                    <div class="col-md-3">
                                                        <label>NIK<font style="color:red"><sup>*</sup></font></label>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input readonly class="form-control" type="text" value=<?= $this->session->userdata('nik') ?> name="nik">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>Cabang<font style="color:red"><sup>*</sup></font></label>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input readonly name="cabang" class="form-control" type="text" value="<?= $this->session->userdata('cabang');?>">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>SOH<font style="color:red"><sup>*</sup></font></label>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <select name="soh" id="soh">
                                                            <option readonly>Pilih NAMA SOH</option>
                                                            <?php foreach($soh as $s){ ?>
                                                                <option value="<?=$s->nik?>"><?= $s->kode_cabang.'-'.$s->nama ?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" class="btn btn-sm btn-success" value="NEXT" onclick="return confirm('Pastikan pengisian sudah sesuai dengan instruksi HR karena data tidak dapat diubah. \n\nYakin Ingin Simpan Data?')">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <!-- End Modal Karyawan-->



                            </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div align="center" id="footer">
                <font style="color: grey;">V.2206.02</font>
            </div>
        </div>
        <div class="" id="load" style="visibility: hidden">
            <div id="content" class="content bg-secondary" style="opacity: 0.1; position: fixed;"></div>
            <img src="<?php echo base_url('assets/images/loader.gif');?>" width="80" style="position: fixed;z-index:5;top:45%;left:55%">
        </div>
    </div>

<!-- Modal Tambah Jenis-->
<div class="modal fade" id="tambah-jenis" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-nobby">
                <h5 class="modal-title text-light" id="exampleModalLabel">BUAT JENIS</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?php echo base_url('pa/simpanJenis');?>"> 
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-3">
                        <label>JENIS<font style="color:red"><sup>*</sup></font></label>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control form-control-sm" name="jenis_pa" id="jenis_pa" onclick="return cekJenis()" required>
                            <option disabled selected></option>
                            <option value="SMT">SEMESTER</option>
                            <option value="KHS">KHUSUS</option>
                        </select>
                        <input type="hidden" id="jenis">
                    </div>
                    <script type="text/javascript">
                        function cekJenis(){
                            var jns = document.getElementById('jenis_pa').value;
                            
                            document.getElementById('jenis').value = jns;
                            if (jns == 'KHS') {
                                document.getElementById('khusus').style.display = 'block';
                                document.getElementById('semester').style.display = 'none';                                
                                document.getElementById('periode').style.display = 'block';                            
                                document.getElementById('th_periode').style.display = 'none';
                            }else if(jns == 'SMT'){
                                document.getElementById('khusus').style.display = 'none';
                                document.getElementById('semester').style.display = 'block';                              
                                document.getElementById('th_periode').style.display = 'block';                                
                                document.getElementById('periode').style.display = 'none';
                            }
                        }                        
                    </script>
                    <div class="col-md-5" id="khusus" style="display:none;">
                        <select class="form-control form-control-sm" name="khusus" required>
                            <option value="HK">HABIS KONTRAK</option>
                            <option value="LL">Lainnya</option>
                        </select>
                    </div>
                    <div class="col-md-3" id="semester" style="display:none;">
                        <select class="form-control form-control-sm" name="semester" required>
                            <option value="1" <?php if(date('m') > 6){ echo 'selected'; }?>>Ke - 1</option>
                            <option value="2" <?php if(date('m') < 7){ echo 'selected'; }?>>Ke - 2</option>
                        </select>
                    </div>
                </div>
                <?php
                    if (date('m') == '01' || date('m') == '02' || date('m') == '03' || date('m') == '04' || date('m') == '05' || date('m') == '06') {
                        $bln1 = '07';
                        $thn1 = date('Y') -1;
                        $bln2 = '12';
                        $thn2 = date('Y') -1;
                        $periode1 = $thn1.'-'.$bln1.'-01';
                        $periode2 = $thn2.'-'.$bln2.'-01';
                    }elseif(date('m') == '07' || date('m') == '08' || date('m') == '09' || date('m') == '10' || date('m') == '11' || date('m') == '12'){
                        $bln1 = '01';
                        $thn1 = date('Y');
                        $bln2 = '06';
                        $thn2 = date('Y');
                        $periode1 = $thn1.'-'.$bln1.'-01';
                        $periode2 = $thn2.'-'.$bln2.'-01';
                    }

                ?>
                <div id="periode" style="display:none">
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label>PERIODE<font style="color:red"><sup>*</sup></font></label>
                        </div>&nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="col-md-4.5">
                            <input type="date" class="form-control form-control-sm" value="<?php echo $periode1?>" name="periode1" required>
                        </div>
                        <div class="col-md-4.5">
                            <input type="date" class="form-control form-control-sm" value="<?php echo $periode2?>" name="periode2" required>
                        </div>
                    </div>
                </div>
                <div id="th_periode" style="display:none">
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label>PERIODE<font style="color:red"><sup>*</sup></font></label>
                        </div>
                        <div class="col-md-5">
                            <select class="form-control form-control-sm" name="thn_periode">
                                <option value="<?php echo date('Y') - 1?>" <?php if((date('Y') -1) == date('Y') && date('m') < 7){ echo 'selected'; }?>><?php echo date('Y') - 1?></option>
                                <option value="<?php echo date('Y')?>" <?php if(date('Y') == date('Y') && date('m') > 6){ echo 'selected'; }?>><?php echo date('Y')?></option>
                                <option value="<?php echo date('Y') + 1?>" <?php if(date('Y') + 1 == date('Y') && date('m') > 6){ echo 'selected'; }?>><?php echo date('Y') + 1?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3">
                        <label>TUJUAN<font style="color:red"><sup>*</sup></font></label>
                    </div>
                    <div class="col-md-9">
                        <textarea class="form-control form-control-sm" name="tujuan" required></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label><font style="color:red"><i>*Untuk Jenis, Periode dan Tujuan PA silakan tanyakan pada HR</i></font></label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-sm btn-success" value="NEXT" onclick="return confirm('Pastikan pengisian sudah sesuai dengan instruksi HR karena data tidak dapat diubah. \n\nYakin Ingin Simpan Data?')">
            </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL Tambah Jenis-->


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

<!-- Modal Karyawan-->
<div class="modal fade" id="modal-karyawan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-nobby">
                <h5 class="modal-title text-light" id="exampleModalLabel">Konfirmasi Data Diri</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="table-responsive rounded pl-3 pr-3 pt-2">
                <form action="<?php echo base_url('pa/simpanPesertaJenis');?>"  method="post">
                            
                            <input type="text" name="kd_jenis">
                    <div class="modal-body">
                        <div class="col-md-3">
                            <label>NIK<font style="color:red"><sup>*</sup></font></label>
                        </div>
                        <div class="col-md-4">
                            <input readonly type="text" value=<?= $this->session->userdata('nik') ?> name="nik">
                        </div>
                        <div class="col-md-3">
                            <label>Cabang<font style="color:red"><sup>*</sup></font></label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="cabang" value="<?= $this->user->session('cabang')?>">
                          
                        </div>
                        <div class="col-md-3">
                            <label>SOH<font style="color:red"><sup>*</sup></font></label>
                        </div>
                        <div class="col-md-4">
                            <select name="soh" id="soh">
                                <option >Pilih NAMA SOH</option>
                                <?php foreach($soh as $s){ ?>
                                    <option value="<?=$s->nik?>"><?= $s->kode_cabang.'-'.$s->nama ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-sm btn-success" value="NEXT" onclick="return confirm('Pastikan pengisian sudah sesuai dengan instruksi HR karena data tidak dapat diubah. \n\nYakin Ingin Simpan Data?')">
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Karyawan-->


<script type="text/javascript">
    // $(document).ready(function(){
    //      $('#nik').select2();
    //  });

     $(document).ready(function(){
            $('#soh').select2();
        });

    $(function () {
        $('#table').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });
    });
</script>

<?php $this->load->view('layout/footer.php')?>