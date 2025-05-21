<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing benarkan</title>
    <link rel="stylesheet" href="<?=base_url('new_db/');?>style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.02.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        .autoComplete_wrapper input{
            width: 95%;
            transform: translateX(10px);
        }
        .box-masket {
            width: 100%;
            display: flex;
            flex-direction: column;
            padding :10px;
            border: 1px solid #000;
            border-radius:4px;
            margin:20px 0px 10px 0px;
            position: relative;
            min-height: 50px;
        }
        .box-masket .lbl {font-weight: bold; color:#cc0b08;background: #ebe8e8;position: absolute;top: -20px;left: 15px;padding:10px;}
        .notes {
            width: 100%;
            background: #ccc;
            color: #000;
            padding: 10px;
            font-size: 12px;
            margin:10px 0px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body style="background: #ebe8e8;">
    <?php
        $hariIni = new DateTime();
        $sf = $hariIni->format('l F Y, H:i');
        $james = $hariIni->format('H:i');
        $james2 = $hariIni->format('H');
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
        $prinTgl = $ex_tgl[2]." ".$ar[$ex_tgl[1]]." ".$ex_tgl[0]." ";
    ?>
    <h1>Update kode</h1>
    <small class="sm"><?=$newToday;?>, <strong><?=$prinTgl;?></strong> Operator : <strong id="nmoptid">Nur Hikmah</strong></small>
    <!-- <div class="container" id="contenerPalsu">
        Halaman ini tidak bisa di akses oleh anda.!!
    </div> -->
    <form action="<?=base_url('usersrjs/simpanbener');?>" method="post">
    <div class="container" id="contenerAsli">
        <div class="form-label">
            <label for="autoComplete">Kode Roll</label>
        </div>
        <textarea name="testing" id="testingkode"></textarea>
        <div class="form-label">
           
        </div>
        <select name="totujuan" id="totujuan">
            <option value="auto">auto</option>
            <option value="Grey">Grey</option>
            <option value="Finish">Finish</option>
        </select>
        <button type="submit" href="javascript:void(0);" id="btnSelesaisc2" class="btn-save2">Simpan</button>
        <div class="fortable">
            <table id="fortable" style="font-size:12px;">
            </table>
        </div>
        
        
    </div>
    </form>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        let personName = sessionStorage.getItem("userName");
        // let now = new Date();
        // let options = { timeZone: "Asia/Bangkok", hour12: false };
        // let hour = new Intl.DateTimeFormat("id-ID", { hour: "2-digit", ...options }).format(now);

        // // Ubah ke integer
        // hour = parseInt(hour, 10);
        // if (hour >= 8 && hour < 16) {
        //     // Hanya tofan dan nifan yang boleh akses
        //     if (personName === "tofan" || personName === "nifan") {
        //         document.body.innerHTML = `<h2>Selamat datang, ${personName}! Anda memiliki akses ke halaman ini.</h2>`;
        //     } else {
        //         document.body.innerHTML = `<h2>Maaf, halaman ini hanya bisa diakses oleh tofan dan nifan antara pukul 08:00 - 16:00.</h2>`;
        //     }
        // } else {
        //     // Di luar jam 08:00 - 16:00, semua user bisa akses
        //     document.body.innerHTML = `<h2>Selamat datang, ${personName}! Halaman ini bisa diakses oleh siapa saja.</h2>`;
        // }

        //document.getElementById('nmoptid').innerHTML = ''+personName;
        //document.getElementById('id_username').value = ''+personName;
        
        
        
        //document.getElementById('btnSelesai').href = "<=base_url();?>users/laporaninsfinish/"+personName+"";
        function loadData(){
            $.ajax({
                url:"<?=base_url();?>users2/loaddatanewPusatex",
                type: "POST",
                data: {},
                cache: false,
                success: function(dataResult){
                    $('#fortable').html(dataResult);
                }
            });
        }
        loadData();
        
        
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