<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kain</title>
    <link rel="stylesheet" href="http://localhost:8080/_inspectRjs/new_db/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.02.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .autoComplete_wrapper input{
            width: 95%;
            transform: translateX(10px);
        }
         .table-container {overflow-x: auto;-webkit-overflow-scrolling: touch;}table {width: 100%;border-collapse: collapse;margin: 20px 0;font-family: 'Arial', sans-serif;box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);}th, td {padding: 12px 15px;text-align: left;border: 1px solid #ddd;}th {background-color:rgb(173, 177, 174);color: #000;font-weight: bold;}td {background-color: #f9f9f9;}tr:nth-child(even) td {background-color: #f2f2f2;}tr:hover td {background-color: #e8e8e8;}@media (max-width: 768px) {table {width: 100%;}th, td {font-size: 14px;padding: 8px 10px;}}
         .loader{width:50px;aspect-ratio:1;display:grid;border:4px solid #0000;border-radius:50%;border-right-color:#25b09b;animation:l15 1s infinite linear}.loader::before,.loader::after{content:"";grid-area:1/1;margin:2px;border:inherit;border-radius:50%;animation:l15 2s infinite}.loader::after{margin:8px;animation-duration:3s}@keyframes l15{100%{transform:rotate(1turn)}}
         .rowdobel {
            width: 100%;
            display: flex;
            justify-content: space-between;
         }
         .btndobel {
            width: 49%;
            height: 40px;
            background: #4184f0;
            color: #fff;
            border: none;
            outline: none;
            border-radius: 3px;
         }
    </style>
</head>
<body>
    <h1>Data Kain Non Ori</h1>
    <small class="sm">Jumat, <strong>09 Mei 2025</strong>, Username : <strong id="nmoptid">Nur Hikmah</strong></small>
    <div class="container">
        
        <div class="kotaknewpkg">
            <span style="color:red;font-weight:bold;font-size:16px;">Input Data Kain</span>
            <div style="width:100%;display:flex;flex-direction:column;margin-top:-15px;">
                
                <div class="table-container">
                <table border="1">
                    <tr>
                        <th>No</th>
                        <th>Data</th>
                        <th>Total Roll</th>
                        <th>Total Panjang</th>
                    </tr>
                    <tr>
                        <td>1.</td>
                        <td><a href="javascript:void(0)" onclick="filterData('avalputihan')" style="cursor:pointer;text-decoration:none;font-weight:bold;color:#2759d6;">Aval Putihan</a></td>
                        <td id="tdavl1s">0</td>
                        <td id="tdavl1">0</td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td><a href="javascript:void(0)" onclick="filterData('avalgrey')" style="cursor:pointer;text-decoration:none;font-weight:bold;color:#2759d6;">Aval Grey</a></td>
                        <td id="tdavl2s">0</td>
                        <td id="tdavl2">0</td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td><a href="javascript:void(0)" onclick="filterData('bcputihan')" style="cursor:pointer;text-decoration:none;font-weight:bold;color:#2759d6;">BC Putihan</a></td>
                        <td id="tdbc1s">0</td>
                        <td id="tdbc1">0</td>
                    </tr>
                    <tr>
                        <td>4.</td>
                        <td><a href="javascript:void(0)" onclick="filterData('bcgrey')" style="cursor:pointer;text-decoration:none;font-weight:bold;color:#2759d6;">BC Grey</a></td>
                        <td id="tdbc2s">0</td>
                        <td id="tdbc2">0</td>
                    </tr>
                    <tr>
                        <td>5.</td>
                        <td><a href="javascript:void(0)" onclick="filterData('bsputihan')" style="cursor:pointer;text-decoration:none;font-weight:bold;color:#2759d6;">BS Putihan</a></td>
                        <td id="tdbs1s">0</td>
                        <td id="tdbs1">0</td>
                    </tr>
                    <tr>
                        <td>6.</td>
                        <td><a href="javascript:void(0)" onclick="filterData('bsgrey')" style="cursor:pointer;text-decoration:none;font-weight:bold;color:#2759d6;">BS Grey</a></td>
                        <td id="tdbs2s">0</td>
                        <td id="tdbs2">0</td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Total</strong></td>
                        <td id="ttlids">0</td>
                        <td id="ttlid">0</td>
                    </tr>
                </table></div>
                <a href="<?=base_url('input-nonori');?>" style="margin-top:10px;outline:none;border:none;padding:7px;background:#4184f0;color:#fff;border-radius:3px;text-decoration:none;text-align:center;">Input Data</a>
            </div>
            
        </div>
        <div class="kotaknewpkg">
            <span style="font-weight:bold;font-size:16px;">Menampilkan Data</span>
            <div style="width:100%;display:flex;margin-top:5px;justify-content:center;align-items:center;" id="dataShow">
                Pilih data yang ingin ditampilkan
            </div>
            
        </div>

    </div>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        let personName = sessionStorage.getItem("userName");
        document.getElementById('nmoptid').innerHTML = ''+personName;
        // document.getElementById('id_username').value = ''+personName;
        // document.getElementById('usernnameID').value = ''+personName;
        
        function loadDataStok(){
            $.ajax({
                url:"<?=base_url('databs/showDataStok');?>",
                type: "POST",
                data: {"username" : personName, "tgl" : "null"},
                cache: false,
                success: function(dataResult){
                    var obj = JSON.parse(dataResult);
                    document.getElementById('tdavl1').innerHTML = obj.pjgAvalPutihan;
                    document.getElementById('tdavl2').innerHTML = obj.pjgAvalGrey;
                    document.getElementById('tdbc1').innerHTML = obj.pjgBcPutihan;
                    document.getElementById('tdbc2').innerHTML = obj.pjgBcGrey;
                    document.getElementById('tdbs1').innerHTML = obj.pjgBsPutihan;
                    document.getElementById('tdbs2').innerHTML = obj.pjgBsGrey;
                    document.getElementById('tdavl1s').innerHTML = obj.jmlAvalPutihan;
                    document.getElementById('tdavl2s').innerHTML = obj.jmlAvalGrey;
                    document.getElementById('tdbc1s').innerHTML = obj.jmlBcPutihan;
                    document.getElementById('tdbc2s').innerHTML = obj.jmlBcGrey;
                    document.getElementById('tdbs1s').innerHTML = obj.jmlBsPutihan;
                    document.getElementById('tdbs2s').innerHTML = obj.jmlBsGrey;
                    document.getElementById('ttlids').innerHTML = obj.totalRoll;
                    document.getElementById('ttlid').innerHTML = obj.totalPJG;
                }
            });
        }
        loadDataStok();
        function filterData(proses){
            $('#dataShow').html('<div class="loader"></div>');
            $.ajax({
                url:"<?=base_url('databs/showDataStokByFilter');?>",
                type: "POST",
                data: {"proses" : proses},
                cache: false,
                success: function(dataResult){
                    setTimeout(() => {
                        $('#dataShow').html(dataResult);
                    }, 900);
                }
            });
        }
        function tampilkanDetil(proses,kons,loc,dataProses){
            $('#dataShow').html('<div class="loader"></div>');
            $.ajax({
                url:"<?=base_url('databs/showDataStokByFilterDetil');?>",
                type: "POST",
                data: {"proses" : proses, "kons" : kons, "loc" : loc, "dataProses" : dataProses},
                cache: false,
                success: function(dataResult){
                    setTimeout(() => {
                        $('#dataShow').html(dataResult);
                    }, 900);
                }
            });
        }
        function deleteRollAbs(kd,id){
            Swal.fire({
                title: 'Hapus Data',
                text: "Anda akan menghapus kode "+kd+"?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"<?=base_url('databs/delAbnon');?>",
                        type: "POST",
                        data: {"id" : id},
                        cache: false,
                        success: function(dataResult){
                            $('#rtbl'+id+'').remove();
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>