<?php $this->load->view('layout/header.php');?>
    <div class="wrapper page">
        <?php $this->load->view('sidebar.php')?>
        <div id="content" class="content text-center">
            <?php $this->load->view('layout/top_menu.php');?>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 border rounded bg-light" style="padding-top: 20px">
                    <?php $msg = $this->session->flashdata('msg');
                if(isset($msg)){echo $this->session->flashdata('msg');
                    $this->session->unset_userdata('msg');}?>
                    <legend class="border-bottom">Login Form</legend>
                    <form action="<?php echo base_url('login');?>" method="POST" name="login" autocomplete="off" onsubmit="return validateLogin()">
                        <div class="form-group text-left">
                            <div class="col-md-10 centered">
                            <label>NIK</label>
                            <input type="text" name="nik" id="nik" class="form-control" placeholder="Masukkan NIK">
                            <span class="text-danger" id="nikerror"></span>
                            </div>
                        </div>
                        <div class="form-group text-left">
                            <div class="col-md-10 centered">
                            <label>Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password">
                            <span class="text-danger" id="passworderror"></span>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="col-md-10 centered">
                            <button class="btn btn-tosca" type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
        <div class="" id="load" style="visibility: hidden">
            <div id="content" class="content bg-secondary" style="opacity: 0.1; position: fixed;"></div>
            <img src="<?php echo base_url('assets/images/loader.gif');?>" width="80" style="position: fixed;z-index:5;top:45%;left:57%">
        </div>
    </div>
    
    <script>
    
        $(document).ready(function (){
            //console.log(localStorage.getItem('nik'));
            document.getElementById('nik').value = localStorage.getItem('nik'); 
        });
    
        function validateLogin(){
        var nik = document.login.nik.value;
        var password = document.login.password.value;

        if(nik === '' || nik === null){
            document.getElementById("nikerror").innerHTML = "Harap masukkan NIK";
            document.getElementById("passworderror").innerHTML = "";
            document.getElementById("nik").className = "form-control form-control-sm is-invalid";
            document.getElementById("password").className = "form-control form-control-sm";
            return false;
        }else if(nik.length < 8 || nik.length > 8){
            document.getElementById("nikerror").innerHTML = "NIK terdiri dari 8 karakter";
            document.getElementById("passworderror").innerHTML = "";
            document.getElementById("nik").className = "form-control form-control-sm is-invalid";
            document.getElementById("password").className = "form-control form-control-sm";
            return false;
        }else if(password === '' || password === null){
            document.getElementById("nikerror").innerHTML = "";
            document.getElementById("passworderror").innerHTML = "Harap masukkan password";
            document.getElementById("password").className = "form-control form-control-sm is-invalid";
            document.getElementById("nik").className = "form-control form-control-sm";
            return false;
        }else if(password.toString().length < 4 || password.toString().length > 15){
            document.getElementById("nikerror").innerHTML = "";
            document.getElementById("passworderror").innerHTML = "Password harus terdiri dari 4 sampai 15 karakter";
            document.getElementById("password").className = "form-control form-control-sm is-invalid";
            document.getElementById("nik").className = "form-control form-control-sm";
            return false;
        }else{
            loader();
            return true;
        }
    }
    </script>
<?php $this->load->view('layout/footer.php')?>