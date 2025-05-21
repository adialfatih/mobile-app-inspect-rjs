<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Pusatex</title>
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
    <h1>Kiriman Rindang</h1>
    <small class="sm"><?=$newToday;?>, <strong><?=$prinTgl;?></strong>, Username : <strong id="nmoptid">Nur Hikmah</strong><br></small>
    <!-- <small class="sm">Klik surat jalan untuk memvalidasi kiriman dari Rindang.</small> -->
    <div class="container">
        <div class="fortable has" style="font-size: 13px;">
            <table id="idtable">
                <tr><td>Loading...</td></tr>
            </table>
        </div>
        <div class="fortable has" style="font-size: 13px;">
            <div style="padding:5px;">Pilih surat jalan untuk memvalidasi kiriaman dari Rindang.</div>
            <table id="validasiTable">
                <tr>
                    <td>Konstruksi</td>
                    <td>Kode Roll</td>
                    <td>Ukuran</td>
                    <td>#</td>
                </tr>
            </table>
        </div>
        <input type="hidden" id="id_username" value="0">
        <input type="hidden" id="usernnameID" value="0">
        <button class="btn-save" style="background:#575757;border:1px solid #FFF;" id="btn-receive">Kembali</button>
        <button class="btn-save" style="background:red;border:1px solid #FFF;" id="btn-logout">Logout</button>
    </div>
    
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
                data: {"username" : personName, "view":"pusatex"},
                cache: false,
                success: function(dataResult){
                    $('#idtable').html(dataResult);
                }
            });
        }
        
        loadData();
        function loadValidasi(sj){
            $.ajax({
                url:"<?=base_url();?>usersrjs/loadpaketvalid",
                type: "POST",
                data: {"sj" : sj},
                cache: false,
                success: function(dataResult){
                    $('#validasiTable').html(dataResult);
                }
            });
        }
        $( "#btn-receive" ).on( "click", function() {
            window.location.href = "<?=base_url('usersrjs/kirimpst');?>";
        });
        $( "#btn-logout" ).on( "click", function() {
            window.location.href = "<?=base_url('usersrjs/');?>";
        });

        function updateKode(checkbox, kode_roll, sj) {
            var isChecked = checkbox.checked;
            if(isChecked == true){ var cek = "yes";
            } else { var cek = "no"; }
            $.ajax({
                url:"<?=base_url();?>usersrjs/validasikode",
                type: "POST",
                data: {"username" : personName, "cek":cek, "kode_roll":kode_roll, "sj":sj},
                cache: false,
                success: function(dataResult){
                    loadData();
                }
            });
        }
        
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