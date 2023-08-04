<?php $this->load->view('layout/header.php');?>
    <div class="wrapper">
        <?php $this->load->view('layout/sidebar.php')?>
        <div id="content" class="content text-center">
        	<?php $this->load->view('layout/top_menu.php');?>
        	<?php $msg = $this->session->flashdata('msg');
                if(isset($msg)){echo $this->session->flashdata('msg');$this->session->unset_userdata('msg');}?>
        	<div class="container-fluid rounded shadow" style="background: #f2f2f2;position: relative; height: 82vh;overflow-y:scroll">
                <div class="row pt-3 pl-1 pr-1 pb-2">
                    <div class="col-md-2 text-left">
                    	<a href="<?php echo base_url('home');?>" class="btn btn-sm btn-secondary" onclick="loader()"><i class="fas fa-chevron-left"></i> Kembali</a>
                    </div>
                    <div class="col-md-8">
                        <h4>GANTI PASSWORD</h4>
                    </div>
                    <div class="col-md-2 text-right">
                        
                    </div>
                </div>
                <div class="table-responsive rounded pl-1 pr-1" style="height:80%">
                    <div class="col-md-12 bg-light text-left rounded pb-2 mb-3" id="tambah-lainnya">
                        <?php echo form_open('ganti-password', 'name="password"')?>
                            <div class="form-group text-left pt-3">
                                <div class="col-md-10 centered">
                                    <label>Password Lama</label>
                                    <div class="input-group">
                                        <input type="password" name="passlama" id="passlama" class="form-control" placeholder="Silahkan masukkan pasword lama anda" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"><input type="checkbox" id="lihat1" onclick="myFunction1()">&ensp;Lihat</span>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="passlamaerror"></span>
                                </div>
                            </div>
                            <div class="form-group text-left">
                                <div class="col-md-10 centered">
                                    <label>Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" name="passbaru" id="passbaru" class="form-control" placeholder="Silahkan masukkan pasword baru anda" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"><input type="checkbox" id="lihat1" onclick="myFunction2()">&ensp;Lihat</span>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="passbaruerror"></span>
                                </div>
                            </div>
                            <div class="form-group text-left">
                                <div class="col-md-10 centered">
                                    <label>Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" name="cpassbaru" id="cpassbaru" class="form-control" placeholder="Silahkan ketik ulang password baru anda" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"><input type="checkbox" id="lihat1" onclick="myFunction3()">&ensp;Lihat</span>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="cpassbaruerror"></span>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-tosca" value="Ganti" onclick="return confirm('Yakin ingin ganti password?')">
                                <input type="reset" class="btn btn-secondary" value="Reset">
                            </div>
                        </form>
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
        function myFunction1() {
            var x = document.getElementById("passlama");
            if (x.type === "password"){
                x.type = "text";
            }else{
                x.type = "password";
            }
        } 

        function myFunction2() {
            var x = document.getElementById("passbaru");
            if (x.type === "password"){
                x.type = "text";
            }else{
                x.type = "password";
            }
        } 

        function myFunction3() {
            var x = document.getElementById("cpassbaru");
            if (x.type === "password"){
                x.type = "text";
            }else{
                x.type = "password";
            }
        } 
    </script>
    
<?php $this->load->view('layout/footer.php')?>