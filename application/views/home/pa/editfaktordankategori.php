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
                        <a href="<?php echo base_url('pa/editFK/'.$kode_fk);?>" class="btn btn-sm btn-secondary" onclick="loader()"><i class="fas fa-sync"></i></a>
                    </div>
                    <div class="col-md-6"><h4>EDIT FAKTOR DAN KATEGORI</h4></div>
                    <div class="col-md-3 text-right">
                    </div>
                </div>
                <div class="row pt-4 pl-4 pr-3">
                </div>
                <div class="table-responsive pl-4 pr-3 pb-4">
                    <div class="col-md-12 bg-light text-left rounded border pt-4 pl-4 pr-4">
                        <form method="POST" action="<?php echo base_url('pa/updateFK');?>">
                            <div class="form-group row text-left">
                                <div class="col-md-2"><label>KODE FK</label></div>
                                <div class="col-md-3">
                                    <input type="text" name="kode_fk" class="form-control form-control-sm" value="<?php echo $kode_fk?>" readonly>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2"><label>FAKTOR</label></div>
                                <div class="col-md-3">
                                    <input type="text" name="faktor" class="form-control form-control-sm" value="<?php echo $fk[0]->faktor?>">
                                </div>
                            </div>
                            <div class="form-group row text-left">
                                <div class="col-md-2"><label>KATEGORI A</label></div>
                                <div class="col-md-3">
                                    <textarea type="text" name="kategori_a" rows="5" class="form-control form-control-sm" ><?php echo $fk[0]->kategori_a?></textarea>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2"><label>KATEGORI B</label></div>
                                <div class="col-md-3">
                                    <textarea type="text" name="kategori_b" rows="5" class="form-control form-control-sm" ><?php echo $fk[0]->kategori_b?></textarea>
                                </div>
                            </div>
                            <div class="form-group row text-left">
                                <div class="col-md-2"><label>KATEGORI C</label></div>
                                <div class="col-md-3">
                                    <textarea type="text" name="kategori_c" rows="5" class="form-control form-control-sm" ><?php echo $fk[0]->kategori_c?></textarea>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2"><label>KATEGORI D</label></div>
                                <div class="col-md-3">
                                    <textarea type="text" name="kategori_d" rows="5" class="form-control form-control-sm" ><?php echo $fk[0]->kategori_d?></textarea>
                                </div>
                            </div>
                            <div class="form-group row text-left">
                                <div class="col-md-2"><label>KATEGORI E</label></div>
                                <div class="col-md-3">
                                    <textarea type="text" name="kategori_e" rows="5" class="form-control form-control-sm" ><?php echo $fk[0]->kategori_e?></textarea>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2"><label>LEVEL</label></div>
                                <div class="col-md-3">
                                    <select name="level" class="form-control form-control-sm">
                                        <option <?php if($fk[0]->level == 1){ echo 'selected;'; }?> value="1">Staff</option>
                                        <option <?php if($fk[0]->level == 2){ echo 'selected;'; }?> value="2">Atasan/Manager</option>
                                    </select>
                                </div>
                            </div>
                            <hr width="100%">
                            <div class="form-group row text-center">
                                <div class="col-md-12">
                                    <button type="submit" name="submit" class="btn btn-sm btn-success">UPDATE</button>
                                </div>
                            </div>                            
                        </form>
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