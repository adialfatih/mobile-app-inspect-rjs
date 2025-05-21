<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Barang Dari Finishing</title>
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
    <h1>Terima Barang Dari Finishing</h1>
    <small class="sm"><?=$newToday;?>, <strong><?=$prinTgl;?></strong> Operator : <strong id="nmoptid">Nur Hikmah</strong></small>
    <!-- <div class="container" id="contenerPalsu">
        Halaman ini tidak bisa di akses oleh anda.!!
    </div> -->
    <div class="container" id="contenerAsli">
        <div class="form-label">
            <label for="autoComplete">Kode Roll</label>
            <div class="autoComplete_wrapper">
                <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" autocapitalize="off">
            </div>
            <!-- <input type="text" class="ipt" name="kons" id="kons" autofocus> -->
            <input type="hidden" id="id_username" value="0">
            <input type="hidden" id="id_tgl" value="<?=$tgl;?>">
        </div>
        <div class="form-label">
            <label for="tgl">Tanggal Terima</label>
            <input type="date" class="ipt" onchange="loadData(this.value)">
        </div>
        
        <div class="fortable">
            <table id="fortable" style="font-size:12px;">
            </table>
        </div>
        
        <a href="<?=base_url();?>usersrjs/insfinish" id="btnSelesaisc2" class="btn-save2">Kembali</a>
    </div>
    <?php
        $ig = $this->db->query("SELECT ig.kode_roll, ig.loc_now FROM data_ig ig LEFT JOIN data_if di ON ig.kode_roll = di.kode_roll COLLATE utf8mb4_unicode_ci LEFT JOIN data_fol df ON ig.kode_roll = df.kode_roll COLLATE utf8mb4_unicode_ci LEFT JOIN data_if_before dib ON ig.kode_roll = dib.kode_roll COLLATE utf8mb4_unicode_ci WHERE di.kode_roll IS NULL AND df.kode_roll IS NULL AND dib.kode_roll IS NULL");
        $ar_ig = array();
        foreach($ig->result() as $val){
            $ar_ig[] = '"'.$val->kode_roll.'"';
        }
        $im_kons = implode(',', $ar_ig);
        
    ?>
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

        document.getElementById('nmoptid').innerHTML = ''+personName;
        document.getElementById('id_username').value = ''+personName;
        function teschange(kode){
            console.log(kode);
            if(kode == "AR7901"){
                Swal.fire('Gagal','Kain ini serahkan ke Pak David', 'error');
            } else {
                if(kode == "AR8205"){
                    Swal.fire('Gagal','Kain ini serahkan ke Pak David', 'error');
                } else {
                    $.ajax({
                        url:"<?=base_url();?>users/cariInsgrey345",
                        type: "POST",
                        data: {"kode" : kode, "kodeuser" : personName},
                        cache: false,
                        success: function(dataResult){
                            console.log(dataResult);
                            var dataResult = JSON.parse(dataResult);
                            if(dataResult.statusCode==200){
                                Swal.fire('Berhasil',''+dataResult.psn+'', 'success');
                                autoCompleteJS.input.value = '';
                                loadData('null');
                            } else {
                                Swal.fire('Gagal',''+dataResult.psn+'', 'error');
                            }
                        },
                        error: function(dataResult){
                            console.log(dataResult);
                        }
                    });
                }
            }
            
        }
        const autoCompleteJS = new autoComplete({
            placeHolder: "Ketik & Pilih Kode Roll...",
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
                        teschange(selection);
                    }
                }
            }
        });
        
        //document.getElementById('btnSelesai').href = "<=base_url();?>users/laporaninsfinish/"+personName+"";
        function loadData(tgl){
            $.ajax({
                url:"<?=base_url();?>users/loaddata",
                type: "POST",
                data: {"username" : personName, "proses" : "insfinishbefore", "tgl" : tgl},
                cache: false,
                success: function(dataResult){
                    $('#fortable').html(dataResult);
                }
            });
        }
        loadData('null');
        function owek(id){
            $.ajax({
                url:"<?=base_url();?>users/delbefore",
                type: "POST",
                data: {"id" : id},
                cache: false,
                success: function(dataResult){
                    loadData('null');
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