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
                        <a href="<?php echo base_url('pa/faktorKategori');?>" class="btn btn-sm btn-secondary" onclick="loader()"><i class="fas fa-sync"></i></a>
                        <a href="<?php echo base_url('pa/tambahFK');?>" class="btn btn-sm btn-success"><i class="fas fa-plus"></i></a>
                    </div>
                    <div class="col-md-6"><h4>FAKTOR DAN KATEGORI</h4></div>
                    <div class="col-md-3 text-right">
                    </div>
                </div>
                <div class="table-responsive rounded pl-3 pr-3 pt-2">
                    <table class="table table-bordered table-hover table-sm shadow" id="table" style="border: 2px solid !important; font-size: 12px">
                        <thead>
                            <tr>
                                <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">NO <i class="fas fa-sort"></i></th>
                                <!-- <th class="bg-nobby text-light" style="width: 8%; border: 1px solid #000;">KODE FK <i class="fas fa-sort"></i></th> -->
                                <th class="bg-nobby text-light" style="width: 20%; border: 1px solid #000;">FAKTOR  <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 15%; border: 1px solid #000;">KATEGORI A <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 15%; border: 1px solid #000;">KATEGORI B <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 15%; border: 1px solid #000;">KATEGORI C <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 15%; border: 1px solid #000;">KATEGORI D <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 15%; border: 1px solid #000;">KATEGORI E <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 8%; border: 1px solid #000;">LEVEL <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">OPSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if(empty($fk)){?>
                                <tr><td colspan="10">DATA TIDAK DITEMUKAN</td></tr>
                            <?php }else{
                                foreach($fk as $fk){
                                if ($fk->level == 1) {
                                    $lvl = 'Staff';
                                }else{
                                    $lvl ='Atasan/Manager';
                                }
                            ?>
                            <tr align="left">
                                <td style="border: 1px solid #000;"><?php echo $no++;?></td>
                                <!-- <td style="border: 1px solid #000;"><?php echo $fk->kode_fk;?></td> -->
                                <td style="border: 1px solid #000;"><?php echo wordwrap($fk->faktor,20,"<br>\n")?></td>
                                <td style="border: 1px solid #000;"><?php echo wordwrap($fk->kategori_a,20,"<br>\n")?></td>
                                <td style="border: 1px solid #000;"><?php echo wordwrap($fk->kategori_b,20,"<br>\n")?></td>
                                <td style="border: 1px solid #000;"><?php echo wordwrap($fk->kategori_c,20,"<br>\n")?></td>
                                <td style="border: 1px solid #000;"><?php echo wordwrap($fk->kategori_d,20,"<br>\n")?></td>
                                <td style="border: 1px solid #000;"><?php echo wordwrap($fk->kategori_e,20,"<br>\n")?></td>
                                <td style="border: 1px solid #000;"><?php echo $lvl ?></td>
                                <td style="border: 1px solid #000;">
                                    <a href="<?php echo base_url('pa/editFK/'.$fk->kode_fk)?>" class="btn btn-xs btn-warning" data-placement="bottom">E</a><br>
                                    <a href="<?php echo base_url('pa/hapusFK/'.$fk->kode_fk)?>" class="btn btn-xs btn-danger" data-placement="bottom">X</a>
                                </td>
                            </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                    <br><br>
                </div>
            </div>
        </div>
        <div class="" id="load" style="visibility: hidden">
            <div id="content" class="content bg-secondary" style="opacity: 0.1; position: fixed;"></div>
            <img src="<?php echo base_url('assets/images/loader.gif');?>" width="80" style="position: fixed;z-index:5;top:45%;left:55%">
        </div>
    </div>

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