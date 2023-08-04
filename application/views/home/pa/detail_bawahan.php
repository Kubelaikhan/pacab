<?php $this->load->view('layout/header.php');?>
    <div class="wrapper">
        <?php $this->load->view('layout/sidebar.php')?>
        <div id="content" class="content text-center" style="">
            <?php $this->load->view('layout/top_menu.php');?>
            <?php $msg = $this->session->flashdata('msg');
                if(isset($msg)){echo $this->session->flashdata('msg');$this->session->unset_userdata('msg');}?>
            <?php 
                if ($header[0]->user_input != $header[0]->nik AND $header[0]->status =='PROCESS') {
                    if ($header[0]->user_input == $manager) {
                        $bio = $this->pa_model->get_nama_jk($manager);   
                        if ($bio[0]->kelamin == 'P') {
                            $sebutan = 'Ibu';
                        }else{
                            $sebutan = 'Bapak';
                        }?>
                        <div class="alert alert-warning alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">
                            PA ini Re-Assesment oleh SOH. Staff akan hubungi <?php echo $sebutan.' '.$bio[0]->nama?> untuk lanjut ke tahap penilaian berikutnya.
                        </div>
                    <?php }else{
                        $bio = $this->pa_model->get_nama_jk($header[0]->user_input);   
                        if ($bio[0]->kelamin == 'P') {
                            $sebutan = 'Ibu';
                        }else{
                            $sebutan = 'Bapak';
                        }
                        ?>
                        <div class="alert alert-warning alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">
                            PA ini Re-Assesment oleh BOD. Staff akan hubungi <?php echo $sebutan.' '.$bio[0]->nama?> untuk lanjut ke tahap penilaian berikutnya.
                        </div>
                <?php }
                 }elseif($header[0]->status =='RE-ASSESMENT'){
                    $bio = $this->pa_model->get_nama_jk($header[0]->user_update);   
                    if ($bio[0]->kelamin == 'P') {
                        $sebutan = 'Ibu';
                    }else{
                        $sebutan = 'Bapak';
                    }?>
                    <div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">
                        PA telah Re-Assesment oleh <?php echo $sebutan.' '.$bio[0]->nama?>, klik <a href="<?php echo base_url('pa/lihatDetailBawahan/'.$header[0]->ref_kdpa);?>"><u><?php echo $header[0]->ref_kdpa?></u></a> untuk melihat PA yang berjalan. 
                    </div>

            <?php }
            ?>
            <div class="container-fluid rounded shadow" style="background: #fcfbfc;position: relative; height: 82vh;overflow-y:scroll" id="konten">
                <div class="row pt-3 pl-3 pr-3">
                    <div class="col-md-3 text-left">
                        <a href="<?php echo base_url('pa/lihatBawahan')?>" class="btn btn-sm btn-secondary" onclick="loader()"><i class="fas fa-chevron-left"></i> Kembali</a>&ensp;
                        <a href="<?php echo base_url('pa/lampiranPA/'.$kode_pa)?>" target="_blank" class="btn btn-sm btn-tosca">LAMPIRAN</a>
                    </div>
                    <div class="col-md-6"><h4>FORMULIR PERFORMANCE APPRAISAL</h4></div>
                    <div class="col-md-3 text-right">
                        <a href="javascript:;" data-toggle="modal" class="btn btn-sm btn-tosca" data-placement="bottom" title="REKOMENDASI & KETERANGAN" data-target="#rekomendasi-keterangan">R & K</a>
                        <?php
                        if($header[0]->nik == $header[0]->user_input){
                            if(($isi == $jml AND $header[0]->status == 'PROCESS') OR $header[0]->status == 'REVISI'){
                                if($karyawan[0]->level == '130'){?>
                                    <a href="<?php echo base_url('pa/updateApproved/'.$kode_pa)?>" class="btn btn-sm btn-success" onclick="return confirm('Pastikan Detail Rekomendasi & Keterangan PA sudah diisi terlebih dahulu sebelum melakukan APPROVED.\n\nPilih CANCEL untuk mengisi kembali detail Rekomendasi & Keterangan.\n\nInfo lebih lanjut hubungi IT.')"><i class="fas fa-check"></i> APPROVED</a>
                            <?php }elseif($atasan == $this->session->userdata('nik')){?>
                                    <a href="<?php echo base_url('pa/updateConfirmedDept/'.$kode_pa)?>" class="btn btn-sm btn-success" onclick="return confirm('Pastikan sudah mengupload File KPI di tombol Lampiran.\n\nYakin Ingin Confirmed Data?')"><i class="fas fa-check"></i> CONFIRM SOH</a>
                                    <!-- <a href="<?php echo base_url('pa/lihatDetailBawahan/'.$header[0]->ref_kdpa);?>" class="btn btn-sm" style="background:#b3cccc"><font style="font-size:12px; color: #527a7a;">RE-ASSESMENT SOH</font></a> -->
                            <?php }else{?>
                                    <a href="<?php echo base_url('pa/updateConfirmed/'.$kode_pa)?>" class="btn btn-sm btn-success" onclick="return confirm('Yakin Ingin Confirmed Data?')"><i class="fas fa-check"></i> CONFIRM</a>
                            <?php }
                                }

                            $bod_dept = $this->pa_model->cek_bod_dept($header[0]->user_update);
                            if($header[0]->status == 'RE-ASSESMENT' AND $header[0]->user_update == $manager){?>
                                <a href="<?php echo base_url('pa/lihatDetailBawahan/'.$header[0]->ref_kdpa);?>" class="btn btn-sm" style="background:#b3cccc"><font style="font-size:12px; color: #527a7a;">Re-Assesment Head</font></a>
                            <?php }elseif($header[0]->status == 'RE-ASSESMENT' AND $bod_dept > 0){?>
                                <a href="<?php echo base_url('pa/lihatDetailBawahan/'.$header[0]->ref_kdpa);?>" class="btn btn-sm" style="background:#b3cccc"><font style="font-size:12px; color: #527a7a;">Re-Assesment BOD</font></a>
                            <?php }
                            }
                        ?>
                    </div>
                </div>
                <div class="row pt-4 pl-4 pr-3">

                </div>
                <div class="table-responsive pl-4 pr-3 pb-4">
                    <div class="col-md-12 bg-light text-left rounded border pt-4 pl-4 pr-4">
                        <form method="POST" action="<?php echo base_url('');?>">
                            <div class="form-group row text-left">
                                <div class="col-md-2"><label>Kode PA</label></div>
                                <div class="col-md-3">
                                    <input type="text" name="" class="form-control form-control-sm" value="<?php echo $kode_pa?>" readonly>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2"><label>Tgl Masuk</label></div>
                                <div class="col-md-3">
                                    <input type="text" name="" class="form-control form-control-sm" value="<?php echo $header[0]->tgl_gabung?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row text-left">
                                <div class="col-md-2"><label>Nama - NIK</label></div>
                                <div class="col-md-4">
                                    <input type="text" name="" class="form-control form-control-sm" value="<?php echo $header[0]->nama.' - '.$header[0]->nik?>" readonly>
                                </div>
                                <!-- <div class="col-md-1"></div> -->
                                <div class="col-md-2"><label>Masa Kerja</label></div>
                                <?php 
                                    $date_now = date_create($header[0]->tgl_periode2);
                                    $date_gabung = date_create($header[0]->tgl_gabung);
                                    $masa_kerja = date_diff($date_now,$date_gabung);
                                    $bulan = $masa_kerja->m;
                                    $tahun = $masa_kerja->y;
                                    $hari = $masa_kerja->d;
                                    ?>
                                <div class="col-md-3">
                                    <input type="text" name="" class="form-control form-control-sm" value="<?php echo $tahun.' Tahun '.$bulan.' Bulan '.$hari.' Hari'?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row text-left">
                                <div class="col-md-2"><label>Jabatan</label></div>
                                <div class="col-md-3">
                                    <input type="text" name="" class="form-control form-control-sm" value="<?php echo $header[0]->jabatan?>" readonly>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2"><label>Periode Penilaian</label></div>
                                <div class="col-md-3">
                                    <input type="text" name="" class="form-control form-control-sm" value="<?php echo $header[0]->periode?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row text-left">
                                <div class="col-md-2"><label>Status</label></div>
                                <div class="col-md-3">
                                    <input type="text" name="" class="form-control form-control-sm" value="<?php echo $header[0]->status_karyawan?>" readonly>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2"><label>Tujuan Penilaian</label></div>
                                <div class="col-md-3">
                                    <textarea type="text" name="" class="form-control form-control-sm" readonly><?php echo $header[0]->tujuan_penilaian?></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered table-sm pt-4 pl-3 pr-3" style="border: 2px solid !important; font-size:12px">
                        <thead>
                            <tr>
                                <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">NO</th>
                                <th class="bg-nobby text-light" style="width: 15%; border: 1px solid #000;">FAKTOR</th>
                                <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">NILAI </th>
                                <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">SKOR </th>
                                <th class="bg-nobby text-light" style="width: 30%; border: 1px solid #000;">KATEGORI </th>
                                <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">OPSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                foreach($detail as $detail){
                            ?>
                            <tr>
                                <td style="border: 1px solid #000;"><?php echo $no++;?></td>
                                <td align="left" style="border: 1px solid #000;"><?php echo $detail->faktor;?></td>
                                <td style="border: 1px solid #000;"><?php echo $detail->nilai;?></td>
                                <td style="border: 1px solid #000;"><?php echo $detail->skor;?></td>
                                <td class="text-left" style="border: 1px solid #000;"><?php echo wordwrap($detail->kategori,90,"<br>\n");?></td>
                                <td style="border: 1px solid #000;">
                                    <a href="javascript:;" class="btn btn-xs btn-secondary" data-toggle="modal" data-placement="bottom" title="LIHAT OPSI" data-target="#edit<?php echo $detail->kode_fk?>">O</a>&nbsp;
                                    <a href="javascript:;" class="btn btn-xs btn-danger" data-toggle="modal" data-placement="bottom" title="Komentar" data-target="#ket_atasan<?php echo $detail->kode_fk?>">C</a>
                                </td>
                            </tr>

                                <!-- Modal Keterangan Atasan-->
                                <div class="modal fade" id="ket_atasan<?php echo $detail->kode_fk?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="width:100%">
                                            <div class="modal-header bg-nobby">
                                                <h5 class="modal-title text-light" id="exampleModalLabel">KOMENTAR NILAI <?php echo $detail->faktor?></h5>
                                                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="<?php echo base_url('pa/updateKomentarNilai');?>"> 
                                                <div class="modal-body">
                                                    <div class="form-group row">
                                                        <div class="col-md-12" align="justify">
                                                            <input type="hidden" name="faktor" value="<?php echo $detail->faktor?>">
                                                            <input type="hidden" name="kode_pa" value="<?php echo $detail->kode_pa?>">
                                                            <textarea rows="10" class="form-control form-control-sm" name="ket_atasan" <?php if($header[0]->status == 'PROCESS'){ echo 'placeholder="isi saran/komentar berdasarkan nilai kategori '.$detail->faktor.'"';}?><?php if($header[0]->status != 'PROCESS'){ echo 'readonly'; }?>><?php echo $detail->ket_atasan; ?></textarea>
                                                        </div>
                                                    </div>                    
                                                </div>
                                                <?php if($header[0]->nik == $header[0]->user_input){
                                                if($header[0]->status == 'PROCESS'){?>
                                                <div class="modal-footer text-center">
                                                    <input type="submit" class="btn btn-sm btn-success" value="SIMPAN" onclick="return confirm('Yakin Ingin Simpan Data?')">
                                                </div>
                                                <?php }
                                                }?>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END MODAL KETERANGAN-->

                                <!-- Modal Edit-->
                                <div class="modal fade" id="edit<?php echo $detail->kode_fk?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="width:120%">
                                            <div class="modal-header bg-nobby">
                                                <h5 class="modal-title text-light" id="exampleModalLabel">PILIH NILAI <?php echo $detail->faktor?></h5>
                                                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="<?php echo base_url('');?>"> 
                                                <div class="modal-body">
                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-1"><label>A</label></div>
                                                        <div class="col-md-10" align="justify">
                                                            <?php echo wordwrap($detail->kategori_a,50,"<br>\n")?>
                                                        </div>
                                                        <!-- <div class="col-md-1"></div> -->
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-1"><label>B</label></div>
                                                        <div class="col-md-10" align="justify">
                                                            <?php echo wordwrap($detail->kategori_b,50,"<br>\n")?>
                                                        </div>
                                                        <!-- <div class="col-md-1"></div> -->
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-1"><label>C</label></div>
                                                        <div class="col-md-10" align="justify">
                                                            <?php echo wordwrap($detail->kategori_c,50,"<br>\n")?>
                                                        </div>
                                                        <!-- <div class="col-md-1"></div> -->
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-1"><label>D</label></div>
                                                        <div class="col-md-10" align="justify">
                                                            <?php echo wordwrap($detail->kategori_d,50,"<br>\n")?>
                                                        </div>
                                                        <!-- <div class="col-md-1"></div> -->
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-1"><label>E</label></div>
                                                        <div class="col-md-10" align="justify">
                                                            <?php echo wordwrap($detail->kategori_e,50,"<br>\n")?>
                                                        </div>
                                                        <!-- <div class="col-md-1"></div> -->
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END MODAL EDIT-->
                            <?php }?>
                            <tr>
                                <td class="text-left" style="border: 1px solid #000;" colspan="1"><b></b></td>
                                <td class="text-left" style="border: 1px solid #000;" colspan="2"><b>JUMLAH SKOR</b></td>
                                <td class="text-left" style="border: 1px solid #000; padding-left: 30px;" colspan="3"><b><?php echo $nilai[0]->skor?></b></td>
                            </tr>
                            <tr>
                                <td class="text-left" style="border: 1px solid #000;" colspan="1"><b></b></td>
                                <td class="text-left" style="border: 1px solid #000;" colspan="2"><b>TOTAL PENGISIAN</b></td>
                                <td class="text-left" style="border: 1px solid #000; padding-left: 30px;" colspan="3"><b><?php echo $nilai[0]->isi?></b></td>
                            </tr>
                            <tr>
                                <td class="text-left" style="border: 1px solid #000;" colspan="1"><b></b></td>
                                <td class="text-left" style="border: 1px solid #000;" colspan="2"><b>RATA - RATA</b></td>
                                <td class="text-left" style="border: 1px solid #000; padding-left: 30px;" colspan="3"><b><?php echo $nilai[0]->rata_rata?></b></td>
                            </tr>
                        </tbody>
                        </table>
                        <br><br><br>
                    </div>
                </div>
            </div>
        </div>
        <div class="" id="load" style="visibility: hidden">
            <div id="content" class="content bg-secondary" style="opacity: 0.1; position: fixed;"></div>
            <img src="<?php echo base_url('assets/images/loader.gif');?>" width="80" style="position: fixed;z-index:5;top:45%;left:55%">
        </div>
    </div>


<!-- Modal Rekomendasi & Keterangan-->
<div class="modal fade" id="rekomendasi-keterangan" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-nobby">
                <h5 class="modal-title text-light" id="exampleModalLabel">REKOMENDASI & KETERANGAN</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?php echo base_url('pa/simpanRK');?>"> 
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-4" style="font-size:20px">
                        <label>Rekomendasi<font color="red"><i><sup>*</sup></i></font></label>
                    </div>
                    <div class="col-md-8">
                        <input type="hidden" name="kode_pa" value="<?php echo $kode_pa?>">
                        <textarea cols="10" rows="5" class="form-control-sm form-control" name="rekomendasi" <?php if($header[0]->status != 'REVISI' AND $header[0]->status != 'PROCESS'){ echo 'readonly'; }?>  required><?php echo $header[0]->rekomendasi?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4" style="font-size:20px">
                        <label>Keterangan<font color="red"><i><sup>*</sup></i></font></label>
                    </div>
                    <div class="col-md-8">
                        <textarea cols="10" rows="5" class="form-control-sm form-control" name="keterangan" <?php if($header[0]->status != 'REVISI' AND $header[0]->status != 'PROCESS'){ echo 'readonly'; }?> required><?php echo $header[0]->keterangan?></textarea>
                    </div>
                </div>
            </div>
            <?php if($header[0]->nik == $header[0]->user_input){
            if($header[0]->status == 'PROCESS' OR $header[0]->status =='REVISI'){?>
            <div class="modal-footer">
                <input type="submit" class="btn btn-sm btn-success" value="SIMPAN" onclick="return confirm('Yakin Ingin Simpan Data?')">
            </div>
            <?php }
                }?>
            </form>
        </div>
    </div>
</div>
<!--End Modal Rekomendasi & Keterangan-->

<script type="text/javascript">
    function cekNilai1(){
        var nilai = document.getElementById('n_pilih').value;
        alert(nilai);
        if (isNaN(nilai)){
            alert('Kolom Nilai Wajib diisi!');
            return false;
        }
        if (nilai == ""){
            alert('Kolom Nilai Wajib diisi!!');
            return false;
        }
        if(nilai != 'A' || nilai != 'B' || nilai != 'C' || nilai != 'D' || nilai != 'E'){
            alert('Nilai Tidak Valid !');
            return false;
        }else{
            var x = confirm('Yakin Ingin Simpan Data?');
            if(x == true){
                return true;
            }else{
                return false;
            }
        }
    }

    function cekNilai() {
        var x = confirm('Yakin Ingin Simpan Data?');
            if(x == true){
                return true;
            }else{
                return false;
            }
    }
</script>

<?php $this->load->view('layout/footer.php')?>