<?php $this->load->view('layout/header.php');?>
    <div class="wrapper">
        <?php $this->load->view('layout/sidebar.php')?>
        <div id="content" class="content text-center" style="">
            <?php $this->load->view('layout/top_menu.php');?>
            <?php $msg = $this->session->flashdata('msg');
                if(isset($msg)){echo $this->session->flashdata('msg');$this->session->unset_userdata('msg');}?>
            <!--<div class="container-fluid" style="background: #f2f2f2;position: relative; min-height: 76vh;">-->
            <div class="container-fluid rounded shadow" style="background: #f2f2f2;position: relative; height: 82vh;overflow-y:scroll">
                <div class="row pt-3 pl-5 pr-5">
                    <div class="col-md-4 text-left">
                        <?php if($this->session->userdata('dept') == '500'){?>
                            <a href="<?php echo base_url('booking-meeting');?>" class="btn btn-sm btn-success" onclick="loader()"><i class="fas fa-plus"></i></a>
                        <?php }?>
                        <a href="<?php echo base_url('home');?>" class="btn btn-sm btn-secondary" onclick="loader()"><i class="fas fa-sync"></i></a>
                    </div>
                    <div class="col-md-4"><h4>LAPORAN MEETING</h4></div>
                    <div class="col-md-4 text-right">
                    </div>
                </div>
                <div class="table-responsive rounded pl-5 pr-5 pt-2">
                    <table class="table table-bordered table-hover table-sm shadow" id="meetingTable" style="border: 2px solid !important; font-size: 12px">
                        <thead>
                            <tr>
                                <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">NO <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">KODE MEETING  <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">TANGGAL <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">JENIS <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">JUDUL <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">STATUS <i class="fas fa-sort"></i></th>
                                <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">OPSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach($meeting as $m){
                            ?>
                                <tr>
                                    <td style="border: 1px solid #000;"><?php echo $no++;?></td>
                                    <td style="border: 1px solid #000;"><?php echo $m->kode_meeting;?></td>
                                    <td style="border: 1px solid #000;"><?php echo $m->tanggal_meeting;?></td>
                                    <td style="border: 1px solid #000;"><?php echo $m->jenis_meeting;?></td>
                                    <td style="border: 1px solid #000;"><?php echo $m->judul_meeting;?></td>
                                    <td style="border: 1px solid #000;"><?php echo $m->status;?></td>
                                    <td style="border: 1px solid #000;">
                                        <div class="row mx-auto" style="justify-content: center;">
                                        <a href="<?php echo base_url("detail-meeting/".$m->kode_meeting);?>" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" title="DETAIL" onclick="loader()">D</a>&nbsp;
                                        <?php if($m->status == "BOOKING" && ($m->user_booking == $this->session->userdata('nik'))){?>
                                        <a href="<?php echo base_url('lihat-peserta/'.$m->kode_meeting)?>" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="bottom" title="PESERTA" onclick="loader()">P</a>&nbsp;
                                        <?php }?>
                                        <?php if($m->status == "OPEN"){?>
                                        <a href="<?php echo base_url('detail-meeting/'.$m->kode_meeting);?>" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="JOIN" onclick="loader()">J</a>&nbsp;
                                        <?php }?>
                                        <?php if($m->status == "OPEN"){?>
                                        <a href="<?php echo base_url()?>" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="bottom" title="CLOSE" onclick="loader()">C</a>&nbsp;
                                        <?php }?>
                                        <?php if($m->status == "BOOKING" && ($m->user_booking == $this->session->userdata('nik'))){?>
                                        <a href="<?php echo base_url()?>" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="BATAL" onclick="loader()">B</a>&nbsp;
                                        <?php }?>
                                        <!--<form method="POST" action="<?php echo base_url('hapus-komputer')?>" onsubmit="return validateDelete()">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                            <input type="hidden" name="id" value="<?php echo $m->id;?>">
                                            <input type="hidden" name="nama_komputer" value="<?php echo $m->nama_komputer;?>">
                                            <button class="bg-danger text-light" style="cursor:pointer" data-toggle="tooltip" data-placement="bottom" title="Hapus">X</button>
                                        </form>-->
                                        </div>
                                    </td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
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
            $('#meetingTable').DataTable({
                "pageLength": 10,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true
            });
        });
    </script>

<?php $this->load->view('layout/footer.php')?>