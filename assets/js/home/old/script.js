    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('timestamp').innerHTML =
        h + ":" + m + ":" + s;
        var t = setTimeout(startTime, 500);
    }

    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }

    function loader(){
        document.getElementById('load').style.visibility="visible";
        return true;
    }

    function submitSort(){
        sort.submit()
        loader();
    }

    function valueCari(){
        var keyword = document.cari.keyword.value;
        if(keyword == null || keyword == ''){
            document.getElementById("keyword").className = "form-control is-invalid";
            return false;
        }else{
            loader();
            return true;
        }
    }

    function confirmDeleteAsset(){
        var x = confirm('Yakin ingin hapus data asset?');
        if(x == true){
            loader();
        }
        return x;
    }

    function validateTambahKategori(){
        var sub = document.tambahKategori.subclass.value;
        var nama = document.tambahKategori.nama.value;
        var inisial = document.tambahKategori.inisial.value;
        var check = document.tambahKategori.check.value;
        var x = confirm('Yakin ingin menyimpan data?');
        if(x == true){
            if(sub == 0){
                document.getElementById("subclass").className = "form-control is-invalid";
                document.getElementById("nama").className = "form-control";
                document.getElementById("inisial").className = "form-control";
                alert('Harap pilih SubClass!');
                return false;
            }else if(nama == '' || nama == null || nama == ' '){
                document.getElementById("subclass").className = "form-control";
                document.getElementById("nama").className = "form-control is-invalid";
                document.getElementById("inisial").className = "form-control";
                alert('Nama Asset Harus Diisi!');
                return false;
            }else if(inisial == '' || inisial == null || inisial == ' '){
                document.getElementById("subclass").className = "form-control";
                document.getElementById("nama").className = "form-control";
                document.getElementById("inisial").className = "form-control is-invalid";
                alert('Inisial Harus Diisi!');
                return false;
            }else if(inisial.length > 5){
                document.getElementById("subclass").className = "form-control";
                document.getElementById("nama").className = "form-control";
                document.getElementById("inisial").className = "form-control is-invalid";
                alert('Inisial Maksimal 5 Karakter!');
                return false;
            }else if(check == 0 || check == null || check == ' '){
                document.getElementById("subclass").className = "form-control";
                document.getElementById("nama").className = "form-control";
                document.getElementById("inisial").className = "form-control";
                document.getElementById("btncheck").className = "btn btn-secondary text-light border-danger";
                alert('Harap klik check inisial dahulu!');
                return false;
            }else{                
                loader();
                return true;
            }
        }
        return x;
    }

    function validateTambahAssetBangunan(){
        var sub = document.tambahAssetBangunan.subclass.value;
        var nama = document.tambahAssetBangunan.nama.value;
        var tgl = document.tambahAssetBangunan.tgl.value;
        var hrg = document.tambahAssetBangunan.hrg.value;
        var umr = document.tambahAssetBangunan.umr.value;
        var x = confirm('Yakin ingin menyimpan data?');
        if(x == true){
            if(sub == 0){
                document.getElementById("subclassB").className = "form-control is-invalid";
                document.getElementById("namabangunan").className = "form-control";
                document.getElementById("tglB").className = "form-control";
                document.getElementById("hrgB").className = "form-control";
                document.getElementById("umrB").className = "form-control";
                alert('Harap pilih SubClass!');
                return false;
            }else if(nama == '' || nama == null || nama == ' '){
                document.getElementById("subclassB").className = "form-control";
                document.getElementById("namabangunan").className = "form-control is-invalid";
                document.getElementById("tglB").className = "form-control";
                document.getElementById("hrgB").className = "form-control";
                document.getElementById("umrB").className = "form-control";
                alert('Harap Generate Nama Asset!');
                return false;
            }else if(tgl == '' || tgl == null){
                document.getElementById("subclassB").className = "form-control";
                document.getElementById("namabangunan").className = "form-control";
                document.getElementById("tglB").className = "form-control is-invalid";
                document.getElementById("hrgB").className = "form-control";
                document.getElementById("umrB").className = "form-control";
                alert('Tanggal Peroleh harus diisi!');
                return false;
            }else if(hrg == '' || hrg == null){
                document.getElementById("subclassB").className = "form-control";
                document.getElementById("namabangunan").className = "form-control";
                document.getElementById("tglB").className = "form-control";
                document.getElementById("hrgB").className = "form-control is-invalid";
                document.getElementById("umrB").className = "form-control";
                alert('Harga Peroleh harus diisi!');
                return false;
            }else if(umr == '' || umr == null){
                document.getElementById("subclassB").className = "form-control";
                document.getElementById("namabangunan").className = "form-control";
                document.getElementById("tglB").className = "form-control";
                document.getElementById("hrgB").className = "form-control";
                document.getElementById("umrB").className = "form-control is-invalid";
                alert('Umur Manfaat harus diisi!');
                return false;
            }else{                
                loader();
                return true;
            }
        }
        return x;
    }

    function validateTambahAssetKendaraan(){
        var sub = document.tambahAssetKendaraan.subclass.value;
        var nama = document.tambahAssetKendaraan.nama.value;
        var tgl = document.tambahAssetKendaraan.tgl.value;
        var hrg = document.tambahAssetKendaraan.hrg.value;
        var umr = document.tambahAssetKendaraan.umr.value;
        var x = confirm('Yakin ingin menyimpan data?');
        if(x == true){
            if(sub == 0){
                document.getElementById("subclassK").className = "form-control is-invalid";
                document.getElementById("namakendaraan").className = "form-control";
                document.getElementById("tglK").className = "form-control";
                document.getElementById("hrgK").className = "form-control";
                document.getElementById("umrK").className = "form-control";
                alert('Harap pilih SubClass!');
                return false;
            }else if(nama == '' || nama == null || nama == ' '){
                document.getElementById("subclassK").className = "form-control";
                document.getElementById("namakendaraan").className = "form-control is-invalid";
                document.getElementById("tglK").className = "form-control";
                document.getElementById("hrgK").className = "form-control";
                document.getElementById("umrK").className = "form-control";
                alert('Harap Generate Nama Asset!');
                return false;
            }else if(tgl == '' || tgl == null){
                document.getElementById("subclassK").className = "form-control";
                document.getElementById("namakendaraan").className = "form-control";
                document.getElementById("tglK").className = "form-control is-invalid";
                document.getElementById("hrgK").className = "form-control";
                document.getElementById("umrK").className = "form-control";
                alert('Tanggal Peroleh harus diisi!');
                return false;
            }else if(hrg == '' || hrg == null){
                document.getElementById("subclassK").className = "form-control";
                document.getElementById("namakendaraan").className = "form-control";
                document.getElementById("tglK").className = "form-control";
                document.getElementById("hrgK").className = "form-control is-invalid";
                document.getElementById("umrK").className = "form-control";
                alert('Harga Peroleh harus diisi!');
                return false;
            }else if(umr == '' || umr == null){
                document.getElementById("subclassK").className = "form-control";
                document.getElementById("namakendaraan").className = "form-control";
                document.getElementById("tglK").className = "form-control";
                document.getElementById("hrgK").className = "form-control";
                document.getElementById("umrK").className = "form-control is-invalid";
                alert('Umur Manfaat harus diisi!');
                return false;
            }else{                
                loader();
                return true;
            }
        }
        return x;
    }

    function validateTambahAssetKomputer(){
        var sub = document.tambahAssetKomputer.subclass.value;
        var nama = document.tambahAssetKomputer.nama.value;
        var tgl = document.tambahAssetKomputer.tgl.value;
        var hrg = document.tambahAssetKomputer.hrg.value;
        var umr = document.tambahAssetKomputer.umr.value;
        var x = confirm('Yakin ingin menyimpan data?');
        if(x == true){
            if(sub == 0){
                document.getElementById("subclassL").className = "form-control is-invalid";
                document.getElementById("namakomputer").className = "form-control";
                document.getElementById("tglL").className = "form-control";
                document.getElementById("hrgL").className = "form-control";
                document.getElementById("umrL").className = "form-control";
                alert('Harap pilih SubClass!');
                return false;
            }else if(nama == '' || nama == null || nama == ' '){
                document.getElementById("subclassL").className = "form-control";
                document.getElementById("namakomputer").className = "form-control is-invalid";
                document.getElementById("tglL").className = "form-control";
                document.getElementById("hrgL").className = "form-control";
                document.getElementById("umrL").className = "form-control";
                alert('Harap Generate Nama Asset!');
                return false;
            }else if(tgl == '' || tgl == null){
                document.getElementById("subclassL").className = "form-control";
                document.getElementById("namakomputer").className = "form-control";
                document.getElementById("tglL").className = "form-control is-invalid";
                document.getElementById("hrgL").className = "form-control";
                document.getElementById("umrL").className = "form-control";
                alert('Tanggal Peroleh harus diisi!');
                return false;
            }else if(hrg == '' || hrg == null){
                document.getElementById("subclassL").className = "form-control";
                document.getElementById("namakomputer").className = "form-control";
                document.getElementById("tglL").className = "form-control";
                document.getElementById("hrgL").className = "form-control is-invalid";
                document.getElementById("umrL").className = "form-control";
                alert('Harga Peroleh harus diisi!');
                return false;
            }else if(umr == '' || umr == null){
                document.getElementById("subclassL").className = "form-control";
                document.getElementById("namakomputer").className = "form-control";
                document.getElementById("tglL").className = "form-control";
                document.getElementById("hrgL").className = "form-control";
                document.getElementById("umrL").className = "form-control is-invalid";
                alert('Umur Manfaat harus diisi!');
                return false;
            }else{                
                loader();
                return true;
            }
        }
        return x;
    }

    function validateTambahAssetGadget(){
        var sub = document.tambahAssetGadget.subclass.value;
        var nama = document.tambahAssetGadget.nama.value;
        var tgl = document.tambahAssetGadget.tgl.value;
        var hrg = document.tambahAssetGadget.hrg.value;
        var umr = document.tambahAssetGadget.umr.value;
        var x = confirm('Yakin ingin menyimpan data?');
        if(x == true){
            if(sub == 0){
                document.getElementById("subclassG").className = "form-control is-invalid";
                document.getElementById("namagadget").className = "form-control";
                document.getElementById("tglG").className = "form-control";
                document.getElementById("hrgG").className = "form-control";
                document.getElementById("umrG").className = "form-control";
                alert('Harap pilih SubClass!');
                return false;
            }else if(nama == '' || nama == null || nama == ' '){
                document.getElementById("subclassG").className = "form-control";
                document.getElementById("namagadget").className = "form-control is-invalid";
                document.getElementById("tglG").className = "form-control";
                document.getElementById("hrgG").className = "form-control";
                document.getElementById("umrG").className = "form-control";
                alert('Harap Generate Nama Asset!');
                return false;
            }else if(tgl == '' || tgl == null){
                document.getElementById("subclassG").className = "form-control";
                document.getElementById("namagadget").className = "form-control";
                document.getElementById("tglG").className = "form-control is-invalid";
                document.getElementById("hrgG").className = "form-control";
                document.getElementById("umrG").className = "form-control";
                alert('Tanggal Peroleh harus diisi!');
                return false;
            }else if(hrg == '' || hrg == null){
                document.getElementById("subclassG").className = "form-control";
                document.getElementById("namagadget").className = "form-control";
                document.getElementById("tglG").className = "form-control";
                document.getElementById("hrgG").className = "form-control is-invalid";
                document.getElementById("umrG").className = "form-control";
                alert('Harga Peroleh harus diisi!');
                return false;
            }else if(umr == '' || umr == null){
                document.getElementById("subclassG").className = "form-control";
                document.getElementById("namagadget").className = "form-control";
                document.getElementById("tglG").className = "form-control";
                document.getElementById("hrgG").className = "form-control";
                document.getElementById("umrG").className = "form-control is-invalid";
                alert('Umur Manfaat harus diisi!');
                return false;
            }else{                
                loader();
                return true;
            }
        }
        return x;
    }

    function validateTambahAssetProduksi(){
        var sub = document.tambahAssetProduksi.subclass.value;
        var nama = document.tambahAssetProduksi.nama.value;
        var tgl = document.tambahAssetProduksi.tgl.value;
        var hrg = document.tambahAssetProduksi.hrg.value;
        var umr = document.tambahAssetProduksi.umr.value;
        var x = confirm('Yakin ingin menyimpan data?');
        if(x == true){
            if(sub == 0){
                document.getElementById("subclassP").className = "form-control is-invalid";
                document.getElementById("namaproduksi").className = "form-control";
                document.getElementById("tglP").className = "form-control";
                document.getElementById("hrgP").className = "form-control";
                document.getElementById("umrP").className = "form-control";
                alert('Harap pilih SubClass!');
                return false;
            }else if(nama == '' || nama == null || nama == ' '){
                document.getElementById("subclassP").className = "form-control";
                document.getElementById("namaproduksi").className = "form-control is-invalid";
                document.getElementById("tglP").className = "form-control";
                document.getElementById("hrgP").className = "form-control";
                document.getElementById("umrP").className = "form-control";
                alert('Harap Generate Nama Asset!');
                return false;
            }else if(tgl == '' || tgl == null){
                document.getElementById("subclassP").className = "form-control";
                document.getElementById("namaproduksi").className = "form-control";
                document.getElementById("tglP").className = "form-control is-invalid";
                document.getElementById("hrgP").className = "form-control";
                document.getElementById("umrP").className = "form-control";
                alert('Tanggal Peroleh harus diisi!');
                return false;
            }else if(hrg == '' || hrg == null){
                document.getElementById("subclassP").className = "form-control";
                document.getElementById("namaproduksi").className = "form-control";
                document.getElementById("tglP").className = "form-control";
                document.getElementById("hrgP").className = "form-control is-invalid";
                document.getElementById("umrP").className = "form-control";
                alert('Harga Peroleh harus diisi!');
                return false;
            }else if(umr == '' || umr == null){
                document.getElementById("subclassP").className = "form-control";
                document.getElementById("namaproduksi").className = "form-control";
                document.getElementById("tglP").className = "form-control";
                document.getElementById("hrgP").className = "form-control";
                document.getElementById("umrP").className = "form-control is-invalid";
                alert('Umur Manfaat harus diisi!');
                return false;
            }else{                
                loader();
                return true;
            }
        }
        return x;
    }

    function validateTambahAssetLainnya(){
        var sub = document.tambahAssetLainnya.subclass.value;
        var nama = document.tambahAssetLainnya.nama.value;
        var tgl = document.tambahAssetLainnya.tgl.value;
        var hrg = document.tambahAssetLainnya.hrg.value;
        var umr = document.tambahAssetLainnya.umr.value;
        var x = confirm('Yakin ingin menyimpan data?');
        if(x == true){
            if(sub == 0){
                document.getElementById("subclassX").className = "form-control is-invalid";
                document.getElementById("namalainnya").className = "form-control";
                document.getElementById("tglX").className = "form-control";
                document.getElementById("hrgX").className = "form-control";
                document.getElementById("umrX").className = "form-control";
                alert('Harap pilih SubClass!');
                return false;
            }else if(nama == '' || nama == null || nama == ' '){
                document.getElementById("subclassX").className = "form-control";
                document.getElementById("namalainnya").className = "form-control is-invalid";
                document.getElementById("tglX").className = "form-control";
                document.getElementById("hrgX").className = "form-control";
                document.getElementById("umrX").className = "form-control";
                alert('Harap Generate Nama Asset!');
                return false;
            }else if(tgl == '' || tgl == null){
                document.getElementById("subclassX").className = "form-control";
                document.getElementById("namalainnya").className = "form-control";
                document.getElementById("tglX").className = "form-control is-invalid";
                document.getElementById("hrgX").className = "form-control";
                document.getElementById("umrX").className = "form-control";
                alert('Tanggal Peroleh harus diisi!');
                return false;
            }else if(hrg == '' || hrg == null){
                document.getElementById("subclassX").className = "form-control";
                document.getElementById("namalainnya").className = "form-control";
                document.getElementById("tglX").className = "form-control";
                document.getElementById("hrgX").className = "form-control is-invalid";
                document.getElementById("umrX").className = "form-control";
                alert('Harga Peroleh harus diisi!');
                return false;
            }else if(umr == '' || umr == null){
                document.getElementById("subclassX").className = "form-control";
                document.getElementById("namalainnya").className = "form-control";
                document.getElementById("tglX").className = "form-control";
                document.getElementById("hrgX").className = "form-control";
                document.getElementById("umrX").className = "form-control is-invalid";
                alert('Umur Manfaat harus diisi!');
                return false;
            }else{                
                loader();
                return true;
            }
        }
        return x;
    }

    function validateUbahAsset(){
        var nama = document.ubahAsset.nama.value;
        var tgl = document.ubahAsset.tgl.value;
        var hrg = document.ubahAsset.hrg.value;
        var umr = document.ubahAsset.umr.value;
        var x = confirm('Yakin ingin menyimpan data?');
        if(x == true){ 
            if(nama == '' || nama == null){
                document.getElementById("nama").className = "form-control is-invalid";
                document.getElementById("tgl").className = "form-control";
                document.getElementById("hrg").className = "form-control";
                document.getElementById("umr").className = "form-control";
                alert('Harap isi Nama Asset!');
                return false;
            }else if(tgl == '' || tgl == null){
                document.getElementById("nama").className = "form-control";
                document.getElementById("tgl").className = "form-control is-invalid";
                document.getElementById("hrg").className = "form-control";
                document.getElementById("umr").className = "form-control";
                alert('Tanggal Peroleh harus diisi!');
                return false;
            }else if(hrg == '' || hrg == null){
                document.getElementById("nama").className = "form-control";
                document.getElementById("tgl").className = "form-control";
                document.getElementById("hrg").className = "form-control is-invalid";
                document.getElementById("umr").className = "form-control";
                alert('Harga Peroleh harus diisi!');
                return false;
            }else if(umr == '' || umr == null){
                document.getElementById("nama").className = "form-control";
                document.getElementById("tgl").className = "form-control";
                document.getElementById("hrg").className = "form-control";
                document.getElementById("umr").className = "form-control is-invalid";
                alert('Umur Manfaat harus diisi!');
                return false;
            }else{                
                loader();
                return true;
            }
        }
        return x;
    }

    //START TAB INPUT

    function showBangunan(){
        document.getElementById('nav-bangunan').className = "nav-link active";
        document.getElementById('tambah-bangunan').style.display = "block";
        document.getElementById('nav-kendaraan').className = "nav-link border";
        document.getElementById('tambah-kendaraan').style.display = "none";
        document.getElementById('nav-komputer').className = "nav-link border";
        document.getElementById('nav-gadget').className = "nav-link border";
        document.getElementById('nav-produksi').className = "nav-link border";
        document.getElementById('nav-lainnya').className = "nav-link border";
        document.getElementById('tambah-komputer').style.display = "none";
        document.getElementById('tambah-gadget').style.display = "none";
        document.getElementById('tambah-produksi').style.display = "none";
        document.getElementById('tambah-lainnya').style.display = "none";
    }

    function showKendaraan(){        
        document.getElementById('nav-bangunan').className = "nav-link border";
        document.getElementById('tambah-bangunan').style.display = "none";
        document.getElementById('nav-kendaraan').className = "nav-link active";
        document.getElementById('tambah-kendaraan').style.display = "block";
        document.getElementById('nav-komputer').className = "nav-link border";
        document.getElementById('nav-gadget').className = "nav-link border";
        document.getElementById('nav-produksi').className = "nav-link border";
        document.getElementById('nav-lainnya').className = "nav-link border";
        document.getElementById('tambah-komputer').style.display = "none";
        document.getElementById('tambah-gadget').style.display = "none";
        document.getElementById('tambah-produksi').style.display = "none";
        document.getElementById('tambah-lainnya').style.display = "none";
    }

    function showKomputer(){        
        document.getElementById('nav-bangunan').className = "nav-link border";
        document.getElementById('tambah-bangunan').style.display = "none";
        document.getElementById('nav-kendaraan').className = "nav-link border";
        document.getElementById('tambah-kendaraan').style.display = "none";
        document.getElementById('nav-komputer').className = "nav-link active";
        document.getElementById('tambah-komputer').style.display = "block";
        document.getElementById('nav-gadget').className = "nav-link border";
        document.getElementById('nav-produksi').className = "nav-link border";
        document.getElementById('nav-lainnya').className = "nav-link border";
        document.getElementById('tambah-gadget').style.display = "none";
        document.getElementById('tambah-produksi').style.display = "none";
        document.getElementById('tambah-lainnya').style.display = "none";
    }

    function showGadget(){        
        document.getElementById('nav-bangunan').className = "nav-link border";
        document.getElementById('tambah-bangunan').style.display = "none";
        document.getElementById('nav-kendaraan').className = "nav-link border";
        document.getElementById('tambah-kendaraan').style.display = "none";
        document.getElementById('nav-komputer').className = "nav-link border";
        document.getElementById('tambah-komputer').style.display = "none";
        document.getElementById('nav-gadget').className = "nav-link active";
        document.getElementById('tambah-gadget').style.display = "block";
        document.getElementById('nav-produksi').className = "nav-link border";
        document.getElementById('nav-lainnya').className = "nav-link border";
        document.getElementById('tambah-produksi').style.display = "none";
        document.getElementById('tambah-lainnya').style.display = "none";
    }

    function showProduksi(){        
        document.getElementById('nav-bangunan').className = "nav-link border";
        document.getElementById('tambah-bangunan').style.display = "none";
        document.getElementById('nav-kendaraan').className = "nav-link border";
        document.getElementById('tambah-kendaraan').style.display = "none";
        document.getElementById('nav-komputer').className = "nav-link border";
        document.getElementById('tambah-komputer').style.display = "none";
        document.getElementById('nav-gadget').className = "nav-link border";
        document.getElementById('tambah-gadget').style.display = "none";
        document.getElementById('nav-produksi').className = "nav-link active";
        document.getElementById('tambah-produksi').style.display = "block";
        document.getElementById('nav-lainnya').className = "nav-link border";
        document.getElementById('tambah-lainnya').style.display = "none";
    }

    function showLainnya(){        
        document.getElementById('nav-bangunan').className = "nav-link border";
        document.getElementById('tambah-bangunan').style.display = "none";
        document.getElementById('nav-kendaraan').className = "nav-link border";
        document.getElementById('tambah-kendaraan').style.display = "none";
        document.getElementById('nav-komputer').className = "nav-link border";
        document.getElementById('tambah-komputer').style.display = "none";
        document.getElementById('nav-gadget').className = "nav-link border";
        document.getElementById('tambah-gadget').style.display = "none";
        document.getElementById('nav-produksi').className = "nav-link border";
        document.getElementById('tambah-produksi').style.display = "none";
        document.getElementById('nav-lainnya').className = "nav-link active";
        document.getElementById('tambah-lainnya').style.display = "block";
    }

    //END TAB INPUT

