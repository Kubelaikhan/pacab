<nav class="shadow" id="sidebar" style="position:fixed;z-index:2;">
    <div class="sidebar-header bg-light border shadow">
        <a href="<?php echo base_url('welcome');?>"><img src="<?php echo base_url('assets/images/nobby.png');?>" width="150" onclick="loader()"></a>
    </div>
    <div style="left: 0;">
        <ul class="list-unstyled components">
            <!-- <p class="p">Form Branch Performance Appraisal</p> -->
            <h5 style="margin-left:5px">Form PA Cabang</h5>
            <li class="bg-light">
                <a class="bg-light text-dark"><i class="fas fa-user"></i> Assalamualaikum, <?php echo $this->session->userdata('nama');?></a>
            </li>
            <?php 
            if($this->session->userdata('level')==210){
                $atasan = $this->pa_model->get_nik_atasan_ss();
            } else {
                $atasan = $this->pa_model->get_nik_atasan(); //ini niknya dari session
            }
        
            $head = $this->pa_model->get_head_dept_by_atasan(); //ini niknya juga dari session diganti jadi buat si SOH
            $superuser = $this->pa_model->get_super_user(); //semuanya pakai nik session
            $auth = $this->pa_model->get_auth_bynik(); //semuanya pakai nik session
            if ( $auth == 'R' OR $this->session->userdata('dept') != "A00" AND $atasan != 0 AND $this->session->userdata() != "A10" || $auth == 'R'){
                if($nav1 == 1){?>
                <li class="active">
                <?php }else{?>
                <li>
                <?php }?>
                <a href="#bawahan" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Bawahan</a>
                <ul class="collapse list-unstyled" id="bawahan">
                    <?php if ($atasan != 0 || $this->session->userdata('dept') != 'A10' ||  $this->session->userdata('dept') != 'A00' ){?>
                        <?php if($nav2 == 1){?>
                    <li class="active">
                        <?php }else{?>
                        <li>
                            <?php }?>
                            <a href="<?php echo base_url('pa/lihatBawahan');?>" onclick="loader()">PA Bawahan</a>
                        </li>
                    <?php }?>

                    <?php if ($head != 0){?>
                        <?php if($nav2 == 8){?>
                    <li class="active">
                            <?php }else{?>
                    <li>
                        <?php }?>
                        <a href="<?php echo base_url('pa/lihatBawahanByHead');?>" onclick="loader()">PA Pegawai Toko</a>
                    </li>
                    <?php }?>
                    
                    <?php if($auth == 'R') {?>
                        <?php if($nav2 == 5){?>
                    <li class="active">
                        <?php }else{?>
                        <li>
                        <?php }?>
                        <a href="<?php echo base_url('pa/lihatBawahanByIT');?>" onclick="loader()">PA Bawahan All Karyawan</a>
                    </li>
                    <?php }?>
                </ul>
            <?php }?>

            <?php if ($auth == 'A' OR $superuser != 0){
                if($nav1 == 2){?>
                <li class="active">
                <?php }else{?>
                <li>
                <?php }?>
                <a href="#allKaryawan" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Karyawan</a>
                <ul class="collapse list-unstyled" id="allKaryawan">
                    <?php if ($auth == 'A' OR $auth == 'R'){?>
                    <?php if($nav2 == 2){?>
                    <li class="active">
                    <?php }else{?>
                    <li>
                    <?php }?>
                        <a href="<?php echo base_url('pa/lihatAllKaryawan');?>" onclick="loader()">PA Karyawan <?php if($auth =='R'){ ?>by HR<?php }?></a>
                    </li>
                    <?php }

                    if($auth == 'W' OR $auth =='R'){?>
                    <?php if($nav2 == 3){?>
                    <li class="active">
                    <?php }else{?>
                    <li>
                    <?php }?>
                        <!-- <a href="<?php echo base_url('pa/lihatAllKaryawan2');?>" onclick="loader()">PA Karyawan <?php if($auth =='R'){ ?>by BOD<?php }?></a> -->
                    </li>
                    <?php }

                    if($auth == 'A' OR $auth =='R' OR $auth =='W'){?>
                        <?php if($nav2 == 9){?>
                        <li class="active">
                        <?php }else{?>
                        <li>
                        <?php }?>
                            <a href="<?php echo base_url('pa/lihatAllKaryawanKPI');?>" onclick="loader()">PA & KPI Karyawan</a>
                        </li>
                    <?php }?>
                </ul>
                <?php }?>
            <?php if ($auth == 'A' OR $auth =='R' OR $auth =='W'){
                if($nav1 == 3){?>
                <li class="active">
                <?php }else{?>
                <li>
                <?php }?>
                <a href="#summary" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Summary</a>
                <ul class="collapse list-unstyled" id="summary">
                    <?php if ($auth == 'A' OR $auth == 'R' OR $auth =='W'){?>
                    <?php if($nav2 == 7){?>
                    <li class="active">
                    <?php }else{?>
                    <li>
                    <?php }?>
                        <a href="<?php echo base_url('pa/laporanSummary');?>" onclick="loader()">Laporan</a>
                    </li>
                    <?php }?>
                </ul>
            <?php }?>
            <?php if ($auth =='R'){
                if($nav1 == 4){?>
                <li class="active">
                <?php }else{?>
                <li>
                <?php }?>
                <a href="#adminIT" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Admin IT</a>
                <ul class="collapse list-unstyled" id="adminIT">
                    <?php if ($auth == 'R'){?>
                    <?php if($nav2 == 10){?>
                    <li class="active">
                    <?php }else{?>
                    <li>
                    <?php }?>
                        <a href="<?php echo base_url('pa/faktorKategori');?>" onclick="loader()">Faktor dan Kategori</a>
                    </li>
                    <?php }?>
                    <?php if ($auth == 'R'){?>
                    <?php if($nav2 == 11){?>
                    <li class="active">
                    <?php }else{?>
                    <li>
                    <?php }?>
                        <!-- <a href="<?php echo base_url('pa/DeptSuperlevel');?>" onclick="loader()">Dept Super Level</a> -->
                    </li>
                    <?php }?>
                </ul>
            <?php }?>
            <li><a class="" href="<?php echo base_url('logout/signOut');?>" onclick="return confirm('YAKIN INGIN LOGOUT?')"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
    <div class="" style="bottom:0 !important;width: 100%;position: sticky;padding-top: 60%">
        <ul class="list-unstyled component">
            <!-- <li><a class="bg-dark" href="<?php echo base_url('login/changePassword')?>" onclick="loader()"><i class="fas fa-cog"></i> Change Password</a></li> -->
            <!-- <li><a class="bg-dark" href="<?php echo base_url('logout/signOut');?>" onclick="return confirm('YAKIN INGIN LOGOUT?')"><i class="fas fa-sign-out-alt"></i> Logout</a></li> -->
        </ul>
    </div>
</nav>