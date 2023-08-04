<?php $this->load->view('layout/header.php');?>
    <div class="wrapper">
        <?php $this->load->view('layout/sidebar.php')?>
        <div id="content" class="content text-center" style="">
            <?php $this->load->view('layout/top_menu.php');?>
            <?php $msg = $this->session->flashdata('msg');
                if(isset($msg)){echo $this->session->flashdata('msg');$this->session->unset_userdata('msg');}?>
            <div class="container-fluid rounded shadow" style="background: #f2f2f2;position: relative; height: 82vh;overflow-y:scroll" id="konten">
                <div class="row pt-3 pl-3 pr-3">
                    <div class="col-md-3 text-left">
                        
                    </div>
                    <div class="col-md-6">
                        <h4>DEPARTEMEN SUPER LEVEL</h4>
                    </div>
                    <div class="col-md-3 text-right">

                    </div>
                </div>
                <div class="row pt-4 pl-4 pr-3">
                </div>
                <div class="table-responsive pl-4 pr-3 pb-4">
                    <div class="col-md-12 bg-light text-left rounded border pt-4 pl-4 pr-4">
                        <table class="table table-bordered table-hover table-sm shadow" style="border: 2px solid !important;font-size:15px">
                            <thead>
                                <tr align="center">
                                    <th class="bg-nobby text-light" style="width: 3%; border: 1px solid #000;">NO</th>
                                    <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">NIK</th>
                                    <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">NAMA</th>
                                    <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">DEPT</th>
                                    <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">LEVEL</th>
                                    <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                if(empty($super_level)){?>
                                    <tr align="center"><td colspan="6">DATA TIDAK DITEMUKAN</td></tr>
                                <?php }else{
                                    foreach($super_level as $lvl){?>
                                <tr align="center">
                                    <td style="border: 1px solid #000;"><?php echo ++$no;?></td>
                                    <td style="border: 1px solid #000;"><?php echo $lvl->nik?></td>
                                    <td align="left" style="border: 1px solid #000;"><?php echo $lvl->nama?></td>
                                    <td style="border: 1px solid #000;"><?php echo $lvl->nama_dept?></td>
                                    <td style="border: 1px solid #000;"><?php echo $lvl->level?></td>
                                    <td style="border: 1px solid #000;"></td>
                                </tr>
                                <?php
                                    }
                                    }?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        
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