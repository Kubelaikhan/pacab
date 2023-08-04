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
                        <a onclick="window.close();" class="btn btn-sm btn-secondary" style="color:white;">TUTUP</a>&ensp;
                        
                    </div>
                    <div class="col-md-6"><h4>LAMPIRAN PERFORMANCE APPRAISAL</h4></div>
                    <div class="col-md-3 text-right">
                        <?php 
                        $auth = $this->pa_model->get_auth_bynik($this->session->userdata('nik'));
                        // if($this->session->userdata('nik') == $manager || $atasan == '10000001' || $auth == 'R' || $auth == 'A'){?>
                        <a href="<?php echo base_url('pa/uploadLampiran/'.$kode_pa)?>" class="btn btn-sm btn-success"><i class="fas fa-plus"></i></a>
                        <?php 
                        // }?>
                    </div>
                </div>
                <div class="row pt-4 pl-4 pr-3">
                </div>
                <div class="table-responsive pl-4 pr-3 pb-4">
                    <div class="col-md-12 bg-light text-left rounded border pt-4 pl-4 pr-4">
                        <table class="table table-bordered table-hover table-sm shadow" style="border: 2px solid !important;font-size:12px">
                            <thead>
                                <tr align="center">
                                    <th class="bg-nobby text-light" style="width: 3%; border: 1px solid #000;">NO</th>
                                    <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">KODE PO</th>
                                    <th class="bg-nobby text-light" style="width: 20%; border: 1px solid #000;">NAMA</th>
                                    <th class="bg-nobby text-light" style="width: 10%; border: 1px solid #000;">KODE FILE</th>
                                    <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">JUDUL FILE</th>
                                    <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">UKURAN FILE</th>
                                    <th class="bg-nobby text-light" style="width: 5%; border: 1px solid #000;">OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                if(empty($lampiran_pa)){?>
                                    <tr align="center"><td colspan="7">DATA TIDAK DITEMUKAN</td></tr>
                                <?php }else{
                                    foreach($lampiran_pa as $file){?>
                                <tr align="center">
                                    <td style="border: 1px solid #000;"><?php echo ++$no;?></td>
                                    <td style="border: 1px solid #000;"><?php echo $file->kode_pa?></td>
                                    <td style="border: 1px solid #000;"><?php echo $header[0]->nama?></td>
                                    <td style="border: 1px solid #000;"><?php echo $file->kode_file?></td>
                                    <td style="border: 1px solid #000;"><?php echo $file->judul_file?></td>
                                    <td style="border: 1px solid #000;">
                                    <?php 
                                        $ukuran = $file->ukuran_file;
                                        $size_kb = round($ukuran / 1024);
                                        $size_mb = round($ukuran / 1048576);
                                        if ($size_kb < 1024) {
                                            echo $size_kb; ?> KB
                                    <?php } elseif ($size_kb > 1024){
                                            echo $size_mb; ?> MB 
                                    <?php } ?></td>
                                    <td style="border: 1px solid #000;">
                                        <a href="<?php echo base_url('pa/lampiranPA/'.$file->kode_pa.'/'.$file->kode_file);?>" class="btn btn-xs btn-success text-light" data-toggle="tooltip" data-placement="bottom" title="LIHAT"><i class="fa fa-eye"></i></a>

                                        <a href="<?php echo base_url('assets/modul_files/'.$header[0]->nik.'/'.$file->path_file);?>" class="btn btn-xs btn-primary text-light" data-toggle="tooltip" data-placement="bottom" title="UNDUH"><i class="fa fa-download"></i></a>

                                        <?php if($this->session->userdata('nik') == $file->user_input || $auth == 'R'){?>
                                        <a href="<?php echo base_url('pa/hapusDetailFile/'.$file->kode_pa.'/'.$file->kode_file);?>" onclick="return confirm('Yakin Ingin Hapus File?')" class="btn btn-xs btn-danger text-light" data-toggle="tooltip" data-placement="bottom" title="HAPUS"><i class="fas fa-trash-alt"></i></a>
                                        <?php }?>
                                    </td>
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
                <div class="pt-4 pl-4 pr-3"></div>
                <?php if($doc_view != ""){ ?>
                <div class="table-responsive pl-3 pr-3">
                    <div class="col-md-12 bg-light text-left rounded border">
                        <div class="pt-3" align="center">
                            <h5>Dokumen <?php echo $detail_file[0]->judul_file?></h5>
                        </div>
                        <div class="pt-3 pl-4 pr-4 pb-5" id="pdf-viewer"></div>
                    </div>
                </div>
                <?php }?>
                <div class="pt-4 pl-4 pr-3"></div>
            </div>
        </div>
        <div class="" id="load" style="visibility: hidden">
            <div id="content" class="content bg-secondary" style="opacity: 0.1; position: fixed;"></div>
            <img src="<?php echo base_url('assets/images/loader.gif');?>" width="80" style="position: fixed;z-index:5;top:45%;left:55%">
        </div>
    </div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.3.200/pdf.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/jscript">
    document.oncontextmenu = injectJS;
    function injectJS(){
        var frame =  $('iframe');
        var contents =  frame.contents();
        var body = contents.find('body').attr("oncontextmenu", "return false");
        var body = contents.find('body').append('<div></div>');    
    }

    window.onload = function() {
        document.addEventListener("contextmenu", function(e){
            e.preventDefault();
        }, false);
    }

    $(document).contextmenu(function() { return false;});
    url = "<?php echo base_url('assets/modul_files/'.$header[0]->nik.'/'.$detail_file[0]->path_file)?>";
    var thePdf = null;
    var scale = 1.4;

    pdfjsLib.getDocument(url).promise.then(function(pdf) {
        thePdf = pdf;
        viewer = document.getElementById('pdf-viewer');

        for(page = 1; page <= pdf.numPages; page++) {
            canvas = document.createElement("canvas");
            canvas.className = 'pdf-page-canvas';
            viewer.appendChild(canvas);
            renderPage(page, canvas);
        }
    });

    function renderPage(pageNumber, canvas){
        thePdf.getPage(pageNumber).then(function(page) {
            viewport = page.getViewport(scale);
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            page.render({canvasContext: canvas.getContext('2d'), viewport: viewport});
        });
    }
</script>
<?php $this->load->view('layout/footer.php')?>