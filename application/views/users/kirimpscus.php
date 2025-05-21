<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packing List Penjualan</title>
    <link rel="stylesheet" href="<?=base_url('new_db/');?>style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.02.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        .autoComplete_wrapper input{
            width: 95%;
            transform: translateX(10px);
        }
    </style>
</head>
<body>
    <?php
        $hariIni = new DateTime();
        $sf = $hariIni->format('l F Y, H:i');
        $ex = explode(' ', $sf);
        $nToday = $ex[0];
        //echo $nToday;
        $hariIndo = ["Sunday"=>"Minggu", "Monday"=>"Senin", "Tuesday"=>"Selasa", "Wednesday"=>"Rabu", "Thursday"=>"Kamis", "Friday"=>"Jumat", "Saturday"=>"Sabtu"];
        $newToday = $hariIndo[$nToday];
        //echo $newToday;
        $tgl = date('Y-m-d');
        $ex_tgl = explode('-', $tgl);
        //echo $tgl;
        $ar = array(
            '00' => 'NaN', '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        );
        $prinTgl = $ex_tgl[2]." ".$ar[$ex_tgl[1]]." ".$ex_tgl[0];
    ?>
    <h1>Penjualan</h1>
    <small class="sm"><?=$newToday;?>, <strong><?=$prinTgl;?></strong>, Username : <strong id="nmoptid">Nur Hikmah</strong></small>
    <div class="container">
        <div class="fortable has" style="font-size: 13px;">
            <table id="idtable">
                <tr><td>Loading...</td></tr>
            </table>
        </div>
        <div class="kotaknewpkg">
            <span>Buat Paket Penjualan Baru</span>
            <div style="width:100%;display:flex;flex-direction:column;">
                <div class="newpkg" >
                    <div class="autoComplete_wrapper">
                        <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" autocapitalize="off">
                        <input type="hidden" id="id_username" value="0">
                        <input type="hidden" id="usernnameID" value="0">
                        <input type="hidden" id="id_tgl" value="<?=$tgl;?>">
                    </div>
                    
                    <button id="createPkg">Buat Paket</button>
                </div>
                <input type="text" style="width:90%;margin-top:10px;padding:8px;border:1px solid #ccc;border-radius:5px;margin-left:10px;margin-right:20px;" placeholder="Masukan tujuan" id="tesTujuan">
                <select name="jnsFold" id="jnsFold" style="width:90%;margin-top:10px;padding:8px;border:1px solid #ccc;border-radius:5px;margin-left:10px;margin-right:20px;">
                    <option value="">Grey / Finish ?</option>
                    <option value="Grey">Grey</option>
                    <option value="Finish">Finish</option>
                </select>
            </div>
        </div>
        <div class="kotaknewpkg">
            <span>Buat Paket BC</span>
            <div style="width:100%;display:flex;flex-direction:column;">
                <div class="newpkg">
                    <input type="text" style="width:60%;padding:8px;border:1px solid #ccc;border-radius:5px;margin-left:10px;" placeholder="Masukan tujuan" id="tesTujuan21">
                    
                    <button id="createPkg22" style="width:40%;margin-left:5px;">Buat Paket BC</button>
                </div>
                
            </div>
        </div>
        <div class="kotaknewpkg">
            <span style="font-weight:bold;color:blue;">STOK GUDANG</span>
            <div class="fortable has" style="font-size: 14px;">
                <table id="idtable23">
                    <tr>
                        <th>Konstruksi</th>
                        <th>Grey</th>
                        <th style="color:#0657c9;">Finish</th>
                    </tr>
                    <tr>
                        <td colspan="3">Loading...</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <button class="btn-save" style="background:red;border:1px solid #FFF;" id="btn-logout">Logout</button>
    </div>
    <?php
        $kons = $this->data_model->get_record('tb_konstruksi');
        $kons2 = $this->data_model->get_byid('tb_konstruksi',['chto!='=>'null']);
        $ar_kons = array();
        foreach($kons->result() as $val){
            $ar_kons[] = '"'.$val->kode_konstruksi.'"';
        }
        foreach($kons->result() as $val){
            $xx = '"'.$val->chto.'"';
            if(in_array($xx, $ar_kons)){} else {
            $ar_kons[] = '"'.$val->chto.'"'; }
        }
        $im_kons = implode(',', $ar_kons);
        
    ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        let personName = sessionStorage.getItem("userName");
        document.getElementById('nmoptid').innerHTML = ''+personName;
        document.getElementById('id_username').value = ''+personName;
        document.getElementById('usernnameID').value = ''+personName;
        function loadData(){
            $.ajax({
                url:"<?=base_url();?>usersrjs/loadpaketpst",
                type: "POST",
                data: {"username" : personName, 'view':'penjualan'},
                cache: false,
                success: function(dataResult){
                    $('#idtable').html(dataResult);
                }
            });
        }
        function loadDataStok(){
            $.ajax({
                url:"<?=base_url();?>usersrjs/loadStokFolding",
                type: "POST",
                data: {"username" : personName, 'view':'penjualan'},
                cache: false,
                success: function(dataResult){
                    $('#idtable23').html(dataResult);
                }
            });
        }
        function joinpk(){
            var txt = document.getElementById('joinpck').value;
            if(txt!=""){
                $.ajax({
                    url:"<?=base_url();?>usersrjs/joinpkglist",
                    type: "POST",
                    data: {"username" : personName, "txt" : txt},
                    cache: false,
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode==200){
                            suksestoast('Join Ke Kode '+dataResult.psn);
                        } else {
                            peringatan(''+dataResult.psn);
                        }
                    }
                });
            } else {
                peringatan('isi kode packinglist');
            }
        }
        loadData();
        loadDataStok();
        
        const autoCompleteJS = new autoComplete({
            placeHolder: "Ketik Konstruksi...",
            data: {
                src: [<?=$im_kons;?>],
                cache: true,
            },
            resultItem: {
                highlight: true
            },
            events: {
                input: {
                    selection: (event) => {
                        const selection = event.detail.selection.value;
                        autoCompleteJS.input.value = selection;
                    }
                }
            }
        });
       
        $( "#btn-logout" ).on( "click", function() {
            window.location.href = "<?=base_url('usersrjs/');?>";
        });
        
        $( "#createPkgshjow" ).on( "click", function() {
            var tgl = document.getElementById('idtgloke').value;
            var tglreal = document.getElementById('idtgloke').value;
            var tgl_obj = new Date(tgl);
            var tgl_bulan = tgl_obj.toLocaleString('default', { month: 'long' });
            var tgl_tahun = tgl_obj.getFullYear();
            tgl = tgl_bulan + " " + tgl_tahun;
            tgl = ""+tgl_obj.getDate()+ " " +tgl_bulan + " " + tgl_tahun;
            if(tglreal!=""){
                $.ajax({
                    url:"<?=base_url();?>usersrjs/loadDataStokGrey",
                    type: "POST",
                    data: {"username" : personName, "tgl" : tglreal},
                    cache: false,
                    success: function(dataResult){
                        $('#diddatastok').html('Data Stok Per '+tgl+'');
                        $('#tableStok').html(dataResult);
                    }
                });
            } else {
                peringatan('Anda belum memilih tanggal');
            }
        });
        $( "#createPkg" ).on( "click", function() {
            suksestoast('Loading...');
            var kodekons = document.getElementById('autoComplete').value;
            var username = document.getElementById('id_username').value;
            var namaopt = document.getElementById('usernnameID').value;
            var tesTujuan = document.getElementById('tesTujuan').value;
            var tgl = document.getElementById('id_tgl').value;
            var jnsFold = document.getElementById('jnsFold').value;
            if(kodekons!="" && username!="" && tgl!="" && namaopt!="" && tesTujuan!="" && jnsFold!=""){
                $.ajax({
                    url:"<?=base_url();?>usersrjs/prosesCreatepkg2",
                    type: "POST",
                    data: {"kodekons" : kodekons, "tgl":tgl, "username":username, "opt":namaopt,"jual":"y","tesTujuan":tesTujuan,"jnsFold":jnsFold},
                        cache: false,
                        success: function(dataResult){
                            var dataResult = JSON.parse(dataResult);
                            if(dataResult.statusCode==200){
                                setTimeout(() => {
                                    window.location.href = "<?=base_url('usersrjs/createkirimpst/');?>"+dataResult.psn+"";
                                }, "500");
                            }
                        }
                });
            } else {
                peringatan('Anda perlu mengisi semua data');
            }                    
        });
        $( "#createPkg22" ).on( "click", function() {
            suksestoast('Loading...');
            var tesTujuan = document.getElementById('tesTujuan21').value;
            if(tesTujuan!="" ){
                $.ajax({
                    url:"<?=base_url();?>usersrjs/prosesCreatepkgBC",
                    type: "POST",
                    data: {"tesTujuan" : tesTujuan},
                        cache: false,
                        success: function(dataResult){
                            var dataResult = JSON.parse(dataResult);
                            if(dataResult.statusCode==200){
                                setTimeout(() => {
                                    window.location.href = "<?=base_url('usersrjs/createkirimpstbc/');?>"+dataResult.psn+"";
                                }, "500");
                            }
                        }
                });
            } else {
                peringatan('Anda perlu mengisi tujuan');
            }                    
        });
            function peringatan(txt) {
                Toastify({
                    text: ""+txt+"",
                    duration: 4000,
                    close:true,
                    gravity:"top",
                    position: "right",
                    backgroundColor: "#cc214e",
                }).showToast();
            }
            function suksestoast(txt){
                Toastify({
                    text: ""+txt+"",
                    duration: 5000,
                    close:true,
                    gravity:"top",
                    position: "right",
                    backgroundColor: "#4fbe87",
                }).showToast();
            } 
            
    </script>
</body>
</html>