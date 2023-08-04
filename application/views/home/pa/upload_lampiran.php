<?php $this->load->view('layout/header.php');?>
    <div class="wrapper">
        <?php $this->load->view('layout/sidebar.php')?>
        <div id="content" class="content text-center" style="">
            <?php $this->load->view('layout/top_menu.php');?>
            <?php $msg = $this->session->flashdata('msg');
                if(isset($msg)){echo $this->session->flashdata('msg');$this->session->unset_userdata('msg');}?>
            <div class="container-fluid rounded shadow" style="background: #fcfbfc;position: relative; height: 82vh;overflow-y:scroll" id="konten">
                <div class="row pt-3 pl-3 pr-3">
                    <div class="col-md-3 text-left">
                        <a href="javascript: history.go(-1)" class="btn btn-sm btn-secondary" onclick="loader()"><i class="fas fa-chevron-left"></i> Kembali</a>&ensp;
                    </div>
                    <div class="col-md-6"><h4>UPLOAD LAMPIRAN PERFORMANCE APPRAISAL</h4></div>
                    <div class="col-md-3 text-right">
                    
                    </div>
                </div>
                <div class="row pt-4 pl-4 pr-3">
                </div>
                <div class="table-responsive pl-4 pr-3 pb-4">
                    <div class="col-md-12 bg-light text-left rounded border pb-2 mb-3 pt-4">
                        <form action="" method="POST">
                            <div class="form-group row text-left">
                                <div class="col-md-2"><label>Kode PA</label></div>
                                <div class="col-md-3">
                                    <input type="text" name="" class="form-control form-control-sm" value="<?php echo $kode_pa?>" readonly>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-1"><label>NIK</label></div>
                                <div class="col-md-3">
                                    <input type="text" name="" class="form-control form-control-sm" value="<?php echo $header[0]->nik?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row text-left">
                                <div class="col-md-2"><label>Nama</label></div>
                                <div class="col-md-3">
                                    <input type="text" name="" class="form-control form-control-sm" value="<?php echo $header[0]->nama?>" readonly>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-1.5"><label>Tgl Penilaian</label></div>
                                <div class="col-md-2">
                                    <input type="text" name="" class="form-control form-control-sm" value="<?php echo date('d F Y', strtotime($header[0]->tgl_penilaian))?>" readonly>
                                </div>
                                <div class="col-md-1.3">
                                    <input type="text" name="" class="form-control form-control-sm" value="<?php echo date('d F Y', strtotime($header[0]->tgl_periode2))?>" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive pl-4 pr-3 pb-4">
                    <div class="col-md-12 bg-light text-left rounded border pb-2 mb-3">
                        <?php echo form_open_multipart('pa/simpanUploadFile');?>
                            <div class="form-group row pt-3">
                                <!-- kode_pa hidden -->
                                <input type="hidden" class="form-control form-control-sm" name="kode_pa" value="<?php echo $kode_pa?>">
                                <!-- kode_pa hidden end -->
                                <div class="col-md-1"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3"><label>Judul File<font style="color:red;"><sup>*</sup></font></label></div>
                                <div class="col-md-8">
                                    <select class="form-control form-control-sm" name="judul_file" required>
                                        <option value="KPI">FILE KPI</option>
                                    </select>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3"><label>Jenis File<font style="color:red;"><sup>*</sup></font></label></div>
                                <div class="col-md-8">
                                    <select class="form-control form-control-sm" name="jenis_file" id="jenis_file" required>
                                        <!-- <option disabled selected></option> -->
                                        <!-- <option value="IMAGE">Image (PNG & JPG)</option> -->
                                        <option value="TEXT">Text (PDF)</option>
                                    </select>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3"><label>Upload File<font style="color:red;"><sup>*</sup></font></label></div>
                                <div class="col-md-8">
                                    <input type="file" name="path_file" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3"></div>
                                <div class="col-md-8"><font color="red" size="2px">Ukuran File PDF Minimal 10 KB, Maksimal 1 MB</font></div>
                                <div class="col-md-1"></div>
                            </div>
                            <!-- button -->
                            <div class="form-group row text-center">
                                <div class="col-md-5"></div>
                                 <div class="col-md-1">
                                    <input type="submit" name="submit" onclick="return confirm('Apakah Anda Yakin Upload File?')"  class="btn btn-sm btn-success" value="UPLOAD">
                                </div>
                                <div class="col-md-1">
                                    <input type="reset" class="btn btn-sm btn-secondary" value="RESET">
                                </div>
                            </div>
                            <!-- button end -->
                        <?php echo form_close()?>
                    </div>
                </div>
            </div>
        </div>
        <div class="" id="load" style="visibility: hidden">
            <div id="content" class="content bg-secondary" style="opacity: 0.1; position: fixed;"></div>
            <img src="<?php echo base_url('assets/images/loader.gif');?>" width="80" style="position: fixed;z-index:5;top:45%;left:55%">
        </div>
    </div>



<?php $this->load->view('layout/footer.php')?>