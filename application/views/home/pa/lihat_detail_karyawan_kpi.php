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
                            PA ini Re-Assesment oleh SOH. <?php echo $sebutan.' '.$bio[0]->nama?> akan hubungi User untuk lanjut ke tahap penilaian berikutnya.
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
                            PA ini Re-Assesment oleh BOD. <?php echo $sebutan.' '.$bio[0]->nama?> akan hubungi User untuk lanjut ke tahap penilaian berikutnya.
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
                        PA telah Re-Assesment oleh <?php echo $sebutan.' '.$bio[0]->nama?>, klik <a href="<?php echo base_url('pa/lihatDetailKaryawan/'.$header[0]->ref_kdpa);?>"><u><?php echo $header[0]->ref_kdpa?></u></a> untuk melihat PA yang berjalan. 
                    </div>
            <?php }
            ?>
            <div class="container-fluid rounded shadow" style="background: #fcfbfc;position: relative; height: 82vh;overflow-y:scroll" id="konten">
                <div class="row pt-3 pl-3 pr-3">
                    <div class="col-md-3 text-left">
                        <!-- <a href="javascript: history.go(-3)" class="btn btn-sm btn-secondary" onclick="loader()"><i class="fas fa-chevron-left"></i> Kembali</a>&ensp; -->
                        <a href="<?php echo base_url('pa/lihatAllKaryawanKPI')?>" class="btn btn-sm btn-secondary" onclick="loader()"><i class="fas fa-chevron-left"></i> Kembali</a>&ensp;
                        <a href="<?php echo base_url('pa/lampiranPA/'.$kode_pa)?>" target="_blank" class="btn btn-sm btn-tosca">LAMPIRAN</a>
                    </div>
                    <div class="col-md-6"><h4>FORMULIR PERFORMANCE APPRAISAL</h4></div>
                    <div class="col-md-3 text-right">
                        <a href="javascript:;" data-toggle="modal" class="btn btn-sm btn-tosca" data-placement="bottom" title="REKOMENDASI & KETERANGAN" data-target="#rekomendasi-keterangan">R & K</a>
                        <?php if($header[0]->status == 'AGREE' || $header[0]->status =='CONFIRMED SOH'){?>
                        <a href="<?php echo base_url('pa/updateAccepted/'.$kode_pa)?>" class="btn btn-sm btn-success" onclick="return confirm('Yakin Ingin Accepted Data?')"><i class="fas fa-check"></i> ACCEPTED</a>
                        <?php }?>
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
                            <div class="form-group row text-left">
                                <div class="col-md-2"><label>Nilai</label></div>
                                <div class="col-md-3">
                                    <input type="text" name="" class="form-control form-control-sm" value="<?php echo $check_nilai[0]->nilai?>" readonly>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2"><label>Predikat</label></div>
                                <div class="col-md-3">
                                    <input type="text" name="" class="form-control form-control-sm" value="<?php echo strtoupper($check_nilai[0]->predikat)?>" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 pt-3">
                        <table class="table table-bordered table-sm pt-4 pl-3 pr-3" style="border: 2px solid !important; font-size:12px">
                        <thead>
                            <tr>
                                <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">NO</th>
                                <th class="bg-nobby text-light" style="width: 8%; border: 1px solid #000;">FAKTOR</th>
                                <th class="bg-nobby text-light" style="width: 15%; border: 1px solid #000;">KATEGORI </th>
                                <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">NILAI </th>
                                <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">SKOR </th>
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
                                <td class="text-left" style="border: 1px solid #000;"><?php echo wordwrap($detail->kategori,85,"<br>\n");?></td>
                                <td style="border: 1px solid #000;"><?php echo $detail->nilai;?></td>
                                <td style="border: 1px solid #000;"><?php echo $detail->skor;?></td>
                            </tr>
                            <?php } ?>

                            <tr>
                                <td class="text-left" style="border: 1px solid #000;" colspan="1"><b></b></td>
                                <td class="text-left" style="border: 1px solid #000;" colspan="3"><b>JUMLAH SKOR</b></td>
                                <td class="text-left" style="border: 1px solid #000;"><b><?php echo $nilai[0]->skor?></b></td>
                            </tr>
                            <tr>
                                <td class="text-left" style="border: 1px solid #000;" colspan="1"><b></b></td>
                                <td class="text-left" style="border: 1px solid #000;" colspan="3"><b>TOTAL PENGISIAN</b></td>
                                <td class="text-left" style="border: 1px solid #000;"><b><?php echo $nilai[0]->isi?></b></td>
                            </tr>
                            <tr>
                                <td class="text-left" style="border: 1px solid #000;" colspan="1"><b></b></td>
                                <td class="text-left" style="border: 1px solid #000;" colspan="3"><b>RATA - RATA</b></td>
                                <td class="text-left" style="border: 1px solid #000;"><b><?php echo $nilai[0]->rata_rata?></b></td>
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
                        <div class="col-md-4" style="font-size: 20px;">
                            <label>Rekomendasi<font color="red"><i><sup>*</sup></i></font></label>
                        </div>
                        <div class="col-md-8">
                            <input type="hidden" name="kode_pa" value="<?php echo $kode_pa?>">
                            <textarea cols="10" rows="5" class="form-control-sm form-control" name="rekomendasi" readonly><?php echo $header[0]->rekomendasi?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4" style="font-size:20px">
                            <label>Keterangan<font color="red"><i><sup>*</sup></i></font></label>
                        </div>
                        <div class="col-md-8">
                            <textarea cols="10" rows="5" class="form-control-sm form-control" name="keterangan" readonly><?php echo $header[0]->keterangan?></textarea>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Modal Rekomendasi & Keterangan-->

    <script type="text/javascript">

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