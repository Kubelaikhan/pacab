<?php $this->load->view('layout/header.php');?>
    <div class="wrapper">
        <?php $this->load->view('layout/sidebar.php');?>
        <div id="content" class="content text-center">
            <?php $this->load->view('layout/top_menu.php');?>
            <?php $msg = $this->session->flashdata('msg');
                if(isset($msg)){ echo $this->session->flashdata('msg');$this->session->unset_userdata('msg');}?>
            <div class="" style="background: #fcfbfc; height:520px">
                <div class="row pl-5 pr-5 pt-3 pb-3">
                    <div class="col-md-2 text-left">
                        
                    </div>
                    <div class="col-md-8"><h5>LAPORAN SUMMARY FORM PA</h5></div>
                    <div class="col-md-2 text-right">
                        
                    </div>
                </div>
                <div class="row pl-5 pr-5">
                    <div class="col-md-12 border text-left" style="font-size:13px">
                        <form method="GET" action="<?php echo base_url('pa/detailSummary')?>" target="_blank" name="cari">
                                <?php
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
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Cabang</label><br/>
                                    <select class="form-control form-control-sm" id="cabang"name="cabang">
                                            <option value="">--PILIH CABANG--</option>
                                        <?php foreach($cabang as $d){?>
                                            <option value="<?php echo $d->kode_cabang;?>"><?php echo $d->kode_cabang.'-'.$d->nama_cabang;?></option>
                                        <?php }?>
                                    </select>
                                </div> 
                                <div class="col-md-2">
                                    <label>Jenis PA</label><br/>
                                    <select class="form-control form-control-sm" name="jenis_pa">
                                        <option value="S1">Semester 1</option>
                                        <option value="S2">Semester 2</option>
                                        <option value="HK">Habis Kontrak</option>
                                        <option value="LL">Lainnya</option>
                                    </select>
                                </div> 
                                <div class="col-md-1.5">
                                    <label>Tahun</label><br/>
                                    <select class="form-control form-control-sm" name="tahun">
                                        <?php foreach($tahun as $t){?>
                                            <option value="<?php echo $t->tahun;?>" <?php if($t->tahun == date('Y')){echo 'selected';}?>><?php echo $t->tahun;?></option>
                                        <?php }?>
                                    </select>
                                </div> 
                                <div class="col-md-2 text-center">
                                    <label class="" style="color: #f2f2f2">.</label><br/>
                                    <button type="submit" class="btn btn-secondary btn-sm">Cari</button>
                                </div> 
                            </div>
                        </form>  
                    </div>
                    <div class="col-md-12 pt-5 pb-3"><h5>GRAFIK SUMMARY FORM PA</h5></div>
                        <div class="col-md-12 border text-left pt-2" style="font-size:13px">
                            <form method="GET" action="<?php echo base_url('pa/summaryLine')?>" target="_blank" name="cari">
                                    <?php
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
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>NIK</label><br/>
                                        <select class="form-control form-control-sm" name="nik" id="nik" style="width: 100%; height:30px">
                                            <option value="">-- PILIH NIK --</option>
                                            <?php foreach($nik_karyawan as $n){?>
                                            <option value="<?php echo $n->nik;?>"><?php echo $n->nik.' - '. $n->nama;?></option>
                                            <?php }?>
                                        </select>
                                    </div> 
                                    <div class="col-md-2">
                                        <label>Jenis PA</label><br/>
                                        <select class="form-control form-control-sm" name="jenis_pa">
                                            <option value="ALL">--PILIH SEMESTER--</option>
                                            <option value="S1">Semester 1</option>
                                            <option value="S2">Semester 2</option>
                                        </select>
                                    </div> 
                                    <div class="col-md-1">
                                        <label>Chart</label><br>
                                        <select class="form-control form-control-sm" name="chart" style="width: 100%; height:30px">
                                            <option value="bar">Bar</option>
                                            <option value="line">Line</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <label style="color: #f2f2f2">.</label><br>
                                        <button type="submit" class="btn btn-secondary btn-sm">Cari</button>
                                    </div>
                                </div>
                            </form>  
                        </div>
                    </div>
                </div>
            </div>  
        </div>




        <div class="" id="load" style="visibility: hidden">
            <div id="content" class="content bg-secondary" style="opacity: 0.1; position: fixed;"></div>
            <img src="<?php echo base_url('assets/images/loader.gif');?>" width="80" style="position: fixed;z-index:5;top:45%;left:57%">
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#nik').select2();
        });

        $(document).ready(function(){
            $('#cabang').select2();
        });
    </script>
<?php $this->load->view('layout/footer.php');?>
