<?php $this->load->view('layout/header.php');?>
    <div class="wrapper">
        <?php $this->load->view('layout/sidebar.php')?>
        <div id="content" class="content text-center" style="">
            <?php $this->load->view('layout/top_menu.php');?>
            <?php $msg = $this->session->flashdata('msg');
                if(isset($msg)){echo $this->session->flashdata('msg');$this->session->unset_userdata('msg');}?>
            <?php 
                if ($header[0]->user_input == $header[0]->nik AND $header[0]->status =='AGREE') { 
                    $bio = $this->pa_model->get_nama_jk($atasan);
                        if ($bio[0]->kelamin =='L') {
                            $sebutan = 'Bapak';
                        }elseif($bio[0]->kelamin =='P'){
                            $sebutan = 'Ibu';
                        }?>
                    <div class="alert alert-warning alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">
                        Selanjutnya <?php echo $sebutan.' '.$bio[0]->nama?> akan hubungi SOH untuk ke tahap penilaian berikutnya.
                    </div>
            <?php }elseif($header[0]->user_input == $header[0]->nik AND $header[0]->status =='PROCESS' AND $header[0]->nilai_ratarata != 0){
                    $bio = $this->pa_model->get_nama_jk($atasan);
                    if ($bio == null) {
                        $sebutan = '';
                        $nama = 'BOD';
                    }else{
                        if ($bio[0]->kelamin =='L') {
                            $sebutan = 'Bapak';
                        }elseif($bio[0]->kelamin =='P'){
                            $sebutan = 'Ibu';
                        }
                        $nama = $bio[0]->nama;
                    }
                        ?>
                        <div class="alert alert-warning alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">
                            Silakan hubungi <?php echo $sebutan.' '.$nama?> untuk lanjut ke tahap penilaian berikutnya.
                        </div>
            <?php }
                if ($header[0]->user_input != $header[0]->nik AND $header[0]->status =='PROCESS') {
                    if ($header[0]->user_input == $atasan) {
                        $bio = $this->pa_model->get_nama_jk($atasan);
                        if ($bio[0]->kelamin =='L') {
                            $sebutan = 'Bapak';
                        }elseif($bio[0]->kelamin =='P'){
                            $sebutan = 'Ibu';
                        }
                        ?>
                        <?php if($this->session->userdata('dept') != 600 AND $this->session->userdata('cabang') =="NH00") {?>
                        <div class="alert alert-warning alert-dismissible text-center" role="alert" style="position:relative;z-index:501;width:100%">
                            PA ini Re-Assesment oleh SOH. <?php echo $sebutan.' '.$bio[0]->nama?> akan hubungi User untuk lanjut ke tahap penilaian berikutnya.
                        </div>
                        <?php } ?>
                    <?php }else{
                        $bio = $this->pa_model->get_nama_jk($header[0]->user_input);
                        if ($bio[0]->kelamin =='L') {
                            $sebutan = 'Bapak';
                        }elseif($bio[0]->kelamin =='P'){
                            $sebutan = 'Ibu';
                        }?>
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
                        PA telah Re-Assesment oleh <?php echo $sebutan.' '.$bio[0]->nama?>, klik <a href="<?php echo base_url('pa/lihatFormulirr/'.$header[0]->ref_kdpa);?>"><u><?php echo $header[0]->ref_kdpa?></u></a> untuk melihat PA yang berjalan. 
                    </div>
            <?php }
            ?>
            <div class="container-fluid rounded shadow" style="background: #fcfbfc;position: relative; height: 82vh;overflow-y:scroll" id="konten">
                <div class="row pt-3 pl-3 pr-3">
                    <div class="col-md-3 text-left">
                    <a href="javascript: history.go(-1)" class="btn btn-sm btn-secondary" onclick="loader()"><i class="fas fa-chevron-left"></i> Kembali</a>&ensp;
                        <a href="<?php echo base_url('pa/lihatFormulir/'.$kode_pa);?>" class="btn btn-sm btn-secondary" onclick="loader()"><i class="fas fa-sync"></i></a>
                    </div>
                    <div class="col-md-6"><h4>FORMULIR PERFORMANCE APPRAISAL</h4></div>
                    <div class="col-md-3 text-right">
                        <?php if($header[0]->user_input == $header[0]->nik AND $header[0]->status =='CONFIRMED'){?>
                        <a href="<?php echo base_url('pa/updateAgree/'.$kode_pa)?>" class="btn btn-sm btn-success" onclick="return confirm('Yakin Ingin Mengirim Data?')"><i class="fas fa-check"></i> AGREE</a>
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
                        </form>
                    </div>
                    <?php if($header[0]->nilai_ratarata == 0){?>
                        <div class="col-md-12" align="justify">
                            <font style="color:red;"><i>*PA tidak akan terkirim ke Atasan bila nilai belum terisi semua.</i></font>
                        </div>
                    <?php }?>
                    <div class="col-md-12">
                        <table class="table table-bordered table-sm pt-4 pl-3 pr-3" style="border: 2px solid !important; font-size:12px">
                            <thead>
                                <tr>
                                    <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">NO</th>
                                    <th class="bg-nobby text-light" style="width: 15%; border: 1px solid #000;">FAKTOR</th>
                                    <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">NILAI </th>
                                    <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">SKOR </th>
                                    <th class="bg-nobby text-light" style="width: 30%; border: 1px solid #000;">KATEGORI </th>
                                    <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">EDIT</th>
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
                                    <td style="border: 1px solid #000;"><?php if($detail->skor == 0){ echo ''; }else{ echo $detail->skor; }?></td>
                                    <td class="text-left" style="border: 1px solid #000;"><?php echo wordwrap($detail->kategori,100,"<br>\n");?></td>
                                    <td style="border: 1px solid #000;">
                                        <?php if($header[0]->status == 'PROCESS'){?>
                                        <a href="javascript:;" class="btn btn-xs btn-success" data-toggle="modal" data-placement="bottom" title="EDIT" data-target="#edit<?php echo $detail->kode_fk?>">E</a>
                                        <?php }else{?>
                                        <a href="javascript:;" class="btn btn-xs btn-danger" data-toggle="modal" data-placement="bottom" title="Komentar" data-target="#ket_atasan<?php echo $detail->kode_fk?>">C</a>
                                        <?php }?>
                                    </td>
                                </tr>

                                <!-- Modal Edit-->
                                <div class="modal fade" id="edit<?php echo $detail->kode_fk?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content responsive" style="width:100%">
                                            <div class="modal-header bg-nobby">
                                                <h5 class="modal-title text-light" id="exampleModalLabel">PILIH NILAI <?php echo $detail->faktor?></h5>
                                                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="<?php echo base_url('pa/UpdateNilai');?>"> 
                                                <div class="modal-body">
                                                    <div class="form-group row" onclick="return cekA()">
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-1"><label>A</label></div>
                                                        <div class="col-md-10" align="justify">
                                                            <?php echo wordwrap($detail->kategori_a,45,"<br>\n")?>
                                                        </div>
                                                        <!-- <div class="col-md-1"></div> -->
                                                    </div>
                                                    <hr width="100%">
                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-1"><label>B</label></div>
                                                        <div class="col-md-10" align="justify">
                                                            <?php echo wordwrap($detail->kategori_b,45,"<br>\n")?>
                                                        </div>
                                                        <!-- <div class="col-md-1"></div> -->
                                                    </div>
                                                    <hr width="100%">
                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-1"><label>C</label></div>
                                                        <div class="col-md-10" align="justify">
                                                            <?php echo wordwrap($detail->kategori_c,45,"<br>\n")?>
                                                        </div>
                                                        <!-- <div class="col-md-1"></div> -->
                                                    </div>
                                                    <hr width="100%">
                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-1"><label>D</label></div>
                                                        <div class="col-md-10" align="justify">
                                                            <?php echo wordwrap($detail->kategori_d,45,"<br>\n")?>
                                                        </div>
                                                        <!-- <div class="col-md-1"></div> -->
                                                    </div>
                                                    <hr width="100%">
                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-1"><label>E</label></div>
                                                        <div class="col-md-10" align="justify">
                                                            <?php echo wordwrap($detail->kategori_e,45,"<br>\n")?>
                                                        </div>
                                                        <!-- <div class="col-md-1"></div> -->
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-12 border">
                                                            <input type="hidden" name="id" value="<?php echo $detail->id?>">
                                                            <input type="hidden" name="kode_fk" value="<?php echo $detail->kode_fk?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-2">NILAI :</div>
                                                        <div class="col-md-6">
                                                            <input type="radio" name="nilai" id="nilai" onclick="nilaiSkorA<?php echo $detail->kode_fk?>()" value="A"> A &nbsp;&nbsp;
                                                            <input type="radio" name="nilai" id="nilai" onclick="nilaiSkorB<?php echo $detail->kode_fk?>()" value="B"> B &nbsp;&nbsp;
                                                            <input type="radio" name="nilai" id="nilai" onclick="nilaiSkorC<?php echo $detail->kode_fk?>()" value="C"> C &nbsp;&nbsp;
                                                            <input type="radio" name="nilai" id="nilai" onclick="nilaiSkorD<?php echo $detail->kode_fk?>()" value="D"> D &nbsp;&nbsp;
                                                            <input type="radio" name="nilai" id="nilai" onclick="nilaiSkorE<?php echo $detail->kode_fk?>()" value="E"> E &nbsp;&nbsp;
                                                        </div>
                                                    </div>
                                                    <script type="text/javascript">
                                                        function nilaiSkorA<?php echo $detail->kode_fk?>(){
                                                            document.getElementById('list_skorA<?php echo $detail->kode_fk?>').style.display = 'block';
                                                            document.getElementById('list_skorB<?php echo $detail->kode_fk?>').style.display = 'none';
                                                            document.getElementById('list_skorC<?php echo $detail->kode_fk?>').style.display = 'none';
                                                            document.getElementById('list_skorD<?php echo $detail->kode_fk?>').style.display = 'none';
                                                            document.getElementById('list_skorE<?php echo $detail->kode_fk?>').style.display = 'none';
                                                        }

                                                        function nilaiSkorB<?php echo $detail->kode_fk?>(){
                                                            document.getElementById('list_skorB<?php echo $detail->kode_fk?>').style.display = 'block';
                                                            document.getElementById('list_skorA<?php echo $detail->kode_fk?>').style.display = 'none';
                                                            document.getElementById('list_skorC<?php echo $detail->kode_fk?>').style.display = 'none';
                                                            document.getElementById('list_skorD<?php echo $detail->kode_fk?>').style.display = 'none';
                                                            document.getElementById('list_skorE<?php echo $detail->kode_fk?>').style.display = 'none';
                                                        }

                                                        function nilaiSkorC<?php echo $detail->kode_fk?>(){
                                                            document.getElementById('list_skorC<?php echo $detail->kode_fk?>').style.display = 'block';
                                                            document.getElementById('list_skorA<?php echo $detail->kode_fk?>').style.display = 'none';
                                                            document.getElementById('list_skorB<?php echo $detail->kode_fk?>').style.display = 'none';
                                                            document.getElementById('list_skorD<?php echo $detail->kode_fk?>').style.display = 'none';
                                                            document.getElementById('list_skorE<?php echo $detail->kode_fk?>').style.display = 'none';
                                                        }

                                                        function nilaiSkorD<?php echo $detail->kode_fk?>(){
                                                            document.getElementById('list_skorD<?php echo $detail->kode_fk?>').style.display = 'block';
                                                            document.getElementById('list_skorA<?php echo $detail->kode_fk?>').style.display = 'none';
                                                            document.getElementById('list_skorB<?php echo $detail->kode_fk?>').style.display = 'none';
                                                            document.getElementById('list_skorC<?php echo $detail->kode_fk?>').style.display = 'none';
                                                            document.getElementById('list_skorE<?php echo $detail->kode_fk?>').style.display = 'none';
                                                        }

                                                        function nilaiSkorE<?php echo $detail->kode_fk?>(){
                                                            document.getElementById('list_skorE<?php echo $detail->kode_fk?>').style.display = 'block';
                                                            document.getElementById('list_skorA<?php echo $detail->kode_fk?>').style.display = 'none';
                                                            document.getElementById('list_skorB<?php echo $detail->kode_fk?>').style.display = 'none';
                                                            document.getElementById('list_skorC<?php echo $detail->kode_fk?>').style.display = 'none';
                                                            document.getElementById('list_skorD<?php echo $detail->kode_fk?>').style.display = 'none';
                                                        }

                                                    </script>
                                                    <div id="list_skorA<?php echo $detail->kode_fk?>" style="display:none;">
                                                        <div class="form-group row">
                                                            <div class="col-md-2">SKOR :</div>
                                                            <div class="col-md-6">
                                                                <select class="form-control form-control-sm" name="skor" required>
                                                                    <option disabled selected>-- PILIH SKOR A --</option>
                                                                    <option value="90">90</option>
                                                                    <option value="91">91</option>
                                                                    <option value="92">92</option>
                                                                    <option value="93">93</option>
                                                                    <option value="94">94</option>
                                                                    <option value="95">95</option>
                                                                    <option value="96">96</option>
                                                                    <option value="97">97</option>
                                                                    <option value="98">98</option>
                                                                    <option value="99">99</option>
                                                                    <option value="100">100</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="list_skorB<?php echo $detail->kode_fk?>" style="display:none;">
                                                        <div class="form-group row">
                                                            <div class="col-md-2">SKOR :</div>
                                                            <div class="col-md-6">
                                                                <select class="form-control form-control-sm" name="skor" required>
                                                                    <option disabled selected>-- PILIH SKOR B --</option>
                                                                    <option value="79">79</option>
                                                                    <option value="80">80</option>
                                                                    <option value="81">81</option>
                                                                    <option value="82">82</option>
                                                                    <option value="83">83</option>
                                                                    <option value="84">84</option>
                                                                    <option value="85">85</option>
                                                                    <option value="86">86</option>
                                                                    <option value="87">87</option>
                                                                    <option value="88">88</option>
                                                                    <option value="89">89</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="list_skorC<?php echo $detail->kode_fk?>" style="display:none;">
                                                        <div class="form-group row">
                                                            <div class="col-md-2">SKOR :</div>
                                                            <div class="col-md-6">
                                                                <select class="form-control form-control-sm" name="skor" required>
                                                                    <option disabled selected>-- PILIH SKOR C --</option>
                                                                    <option value="68">68</option>
                                                                    <option value="69">69</option>
                                                                    <option value="70">70</option>
                                                                    <option value="71">71</option>
                                                                    <option value="72">72</option>
                                                                    <option value="73">73</option>
                                                                    <option value="74">74</option>
                                                                    <option value="75">75</option>
                                                                    <option value="76">76</option>
                                                                    <option value="77">77</option>
                                                                    <option value="78">78</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="list_skorD<?php echo $detail->kode_fk?>" style="display:none;">
                                                        <div class="form-group row">
                                                            <div class="col-md-2">SKOR :</div>
                                                            <div class="col-md-6">
                                                                <select class="form-control form-control-sm" name="skor" required>
                                                                    <option disabled selected>-- PILIH SKOR D --</option>
                                                                    <option value="57">57</option>
                                                                    <option value="58">58</option>
                                                                    <option value="59">59</option>
                                                                    <option value="60">60</option>
                                                                    <option value="61">61</option>
                                                                    <option value="62">62</option>
                                                                    <option value="63">63</option>
                                                                    <option value="64">64</option>
                                                                    <option value="65">65</option>
                                                                    <option value="66">66</option>
                                                                    <option value="67">67</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="list_skorE<?php echo $detail->kode_fk?>" style="display:none;">
                                                        <div class="form-group row">
                                                            <div class="col-md-2">SKOR :</div>
                                                            <div class="col-md-6">
                                                                <select class="form-control form-control-sm" name="skor" required>
                                                                    <option disabled selected>-- PILIH SKOR E --</option>
                                                                    <option value="46">46</option>
                                                                    <option value="47">47</option>
                                                                    <option value="48">48</option>
                                                                    <option value="49">49</option>
                                                                    <option value="50">50</option>
                                                                    <option value="51">51</option>
                                                                    <option value="52">52</option>
                                                                    <option value="53">53</option>
                                                                    <option value="54">54</option>
                                                                    <option value="55">55</option>
                                                                    <option value="56">56</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer text-center">
                                                    <input type="submit" class="btn btn-sm btn-success" value="PILIH" onclick="return confirm('Yakin Ingin Simpan Data?')">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END MODAL EDIT-->


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
                                            <form method="POST" action="<?php echo base_url('');?>"> 
                                                <div class="modal-body">
                                                    <div class="form-group row">
                                                        <div class="col-md-12" align="justify">
                                                            <textarea rows="10" class="form-control form-control-sm" name="ket_atasan" readonly><?php echo $detail->ket_atasan;?></textarea>
                                                        </div>
                                                    </div>                    
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END MODAL KETERANGAN-->

                                <?php }?>
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

                    
<script type="text/javascript">
    function cekA(){
        var nilai_a = 'A';
        document.getElementById('nilai').value = nilai_a;
        return nilai_a;
    }

    function inputNilai(){
        var n = document.getElementById('nilai').value;
        document.getElementById('nil').value = n;
        return n;
    }
</script>

<?php $this->load->view('layout/footer.php')?>