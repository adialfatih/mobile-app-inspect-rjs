<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Kain</title>
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
         .rowdobel {
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-top:10px;
         }
         .btndobel {
            width: 49%;
            height: 40px;
            color: #fff;
            border: none;
            background:rgb(213, 210, 210);
            outline: none;
            border-radius: 3px;
            display:flex;
            justify-content:center;
            align-items:center;
            font-weight:bold;
            color:rgb(118, 116, 116);
         }
         .btndobel.active {background: #4184f0;color:#FFFFFF;}
         .loader{width:50px;aspect-ratio:1;display:grid;border:4px solid #0000;border-radius:50%;border-right-color:#25b09b;animation:l15 1s infinite linear}.loader::before,.loader::after{content:"";grid-area:1/1;margin:2px;border:inherit;border-radius:50%;animation:l15 2s infinite}.loader::after{margin:8px;animation-duration:3s}@keyframes l15{100%{transform:rotate(1turn)}}
    </style>
</head>
<body>
    <h1>Input Data Kain Non Ori</h1>
    <small class="sm">Jumat, <strong>09 Mei 2025</strong>, Username : <strong id="nmoptid">Nur Hikmah</strong></small>
    <div class="container">
        <input type="hidden" id="usernnameID" value="0">
        <input type="hidden" id="proses" value="0">
        <div class="kotaknewpkg">
            <span style="color:red;font-weight:bold;font-size:16px;">Input Data Kain</span>
            
            <div style="width:100%;display:flex;flex-direction:column;margin-top:15px;">
                <label>Pilih Kategori Kain</label>
                <div class="rowdobel">
                    <div class="btndobel" id="avl1">Aval Putihan</div>
                    <div class="btndobel" id="avl2">Aval Grey</div>
                </div>
                <div class="rowdobel">
                    <div class="btndobel" id="bc1">BC Putihan</div>
                    <div class="btndobel" id="bc2">BC Grey</div>
                </div>
                <div class="rowdobel">
                    <div class="btndobel" id="bs1">BS Putihan</div>
                    <div class="btndobel" id="bs2">BS Grey</div>
                </div>
                <div style="width:100%;display:flex;margin-top:15px;justify-content:space-between;align-items:center;">
                    <label>Pilih Konstuksi</label>
                    <div class="autoComplete_wrapper">
                        <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" autocapitalize="off">
                    </div>
                </div>
                <div style="width:100%;display:flex;margin-top:15px;justify-content:space-between;align-items:center;">
                    <label>Masukan Kode Roll</label>
                    <input type="text" class="ipt" name="kdroll" id="kdroll" placeholder="Masukan Kode Roll">
                </div>
                <div style="width:100%;display:flex;margin-top:15px;justify-content:space-between;align-items:center;">
                    <label>Masukan Ukuran</label>
                    <input type="text" class="ipt" name="ukr" id="ukr" placeholder="Masukan Ukuran">
                </div>
                <button onclick="simpanData()" style="margin-top:20px;outline:none;border:none;padding:7px;background:#4184f0;color:#fff;border-radius:3px;text-decoration:none;text-align:center;">Simpan Data</button>
                <button onclick="backKeData()" style="margin-top:5px;outline:none;border:none;padding:7px;background:#363c4a;color:#fff;border-radius:3px;text-decoration:none;text-align:center;">Kembali Ke Data</button>
                <div style="width:100%;margin-top:20px;display:none;" id="loading"><div class="loader"></div></div>                
            </div>
            

    </div>
    <div style="width:100%;display:flex;margin-top:15px;justify-content:space-between;align-items:center;">
        <select name="select" id="jnsKain" style="width:48%;padding:3px;outline:none;border:1px solid #000;border-radius:3px;" onchange="filterData()">
            <option value="all">Semua</option>
            <option value="avalputihan">Aval Putihan</option>
            <option value="avalgrey">Aval Grey</option>
            <option value="bcputihan">BC Putihan</option>
            <option value="bcgrey">BC Grey</option>
            <option value="bsputihan">BS Putihan</option>
            <option value="bsgrey">BS Grey</option>
        </select>
        <input type="date" value="<?=date('Y-m-d');?>" style="width:48%;padding:3px;" name="tgl23" id="tgl23" onchange="filterData()">
    </div>
    <div class="table-container" id="idTables">
        <table border="1"><tr><th>No</th><th>Kode Roll</th><th>Konstruksi</th><th>Jenis</th><th>Ukuran</th><th>Del</th></tr><tr><td colspan="6">Loading...</td></tr></table>
    </div>
    <?php
        $kons = $this->data_model->get_record('tb_konstruksi');
        $ar_kons = array();
        foreach($kons->result() as $val){
            $ar_kons[] = '"'.$val->kode_konstruksi.'"';
        }
        $im_kons = implode(',', $ar_kons);
    ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        let personName = sessionStorage.getItem("userName");
        document.getElementById('nmoptid').innerHTML = ''+personName;
        document.getElementById('usernnameID').value = ''+personName;
        
        function simpanData(){
            // $('#loading').css('display', 'flex');
            // $('#loading').css('justify-content', 'center');
            var username = document.getElementById('usernnameID').value;
            var konstruksi = document.getElementById('autoComplete').value;
            var proses = document.getElementById('proses').value;
            var kdroll = document.getElementById('kdroll').value;
            var ukr = document.getElementById('ukr').value;
            if(proses=="0"){
                Swal.fire({ icon: 'error', title: 'Error', text: 'Jenis Kain Belum Dipilih',
                    confirmButtonColor: '#3085d6'
                });
            } else {
                if(konstruksi!="" && kdroll!="" && ukr!=""){
                    $('#loading').css('display', 'flex');
                    $('#loading').css('justify-content', 'center');
                    $.ajax({
                        url:"<?=base_url('databs/simpandata');?>",
                        type: "POST",
                        data: {"username" : username, "konstruksi" : konstruksi, "proses":proses, "kdroll":kdroll, "ukr":ukr},
                        cache: false,
                        success: function(dataResult){
                            console.log(dataResult);
                            var dataResult = JSON.parse(dataResult);
                            if(dataResult.statusCode==200){
                                $('#loading').css('display', 'none');
                                Swal.fire({ icon: 'success', title: 'Success', text: dataResult.psn,
                                    confirmButtonColor: '#3085d6'
                                });
                                document.getElementById('kdroll').value = "";
                                document.getElementById('ukr').value = "";
                                loadData('today','all');
                            } else {
                                $('#loading').css('display', 'none');
                                Swal.fire({ icon: 'error', title: 'Error', text: dataResult.psn,
                                    confirmButtonColor: '#3085d6'
                                });
                            }
                        }
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Isi Data dengan benar.!!',
                        confirmButtonColor: '#3085d6'
                    });
                }
            }
        }
        function filterData(){
            var tgl = document.getElementById('tgl23').value;
            var proses = document.getElementById('jnsKain').value;
            loadData(tgl,proses);
        }
        function loadData(tgl,proses){
            $('#idTables').html('<table border="1"><tr><th>No</th><th>Kode Roll</th><th>Konstruksi</th><th>Jenis</th><th>Ukuran</th><th>Del</th></tr><tr><td colspan="6">Loading...</td></tr></table>');
            $.ajax({
                url:"<?=base_url('databs/loaddata');?>",
                type: "POST",
                data: {"username" : personName, "tgl" : tgl, "proses":proses},
                cache: false,
                success: function(dataResult){
                    $('#idTables').html(dataResult);
                }
            });
        }
        loadData('today','all');
        function backKeData(){
            window.location.href = "<?=base_url('usersrjs/databs');?>";
        }
        function delData(id,kdroll){
            Swal.fire({
            title: "Hapus "+kdroll+"",
            text: "Anda yakin akan menghapus data ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya Hapus",
            cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"<?=base_url('databs/deldata');?>",
                        type: "POST",
                        data: {"id" : id, "kdroll" : kdroll},
                        cache: false,
                        success: function(dataResult){
                            loadData('today','all');
                        }
                    });
                }
            });
        }
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
        var button1 = document.getElementById("avl1");
        var button2 = document.getElementById("avl2");
        var button3 = document.getElementById("bc1");
        var button4 = document.getElementById("bc2");
        var button5 = document.getElementById("bs1");
        var button6 = document.getElementById("bs2");
        button1.addEventListener("click", function() {
            button1.classList.add("active");
            button2.classList.remove("active");
            button3.classList.remove("active");
            button4.classList.remove("active");
            button5.classList.remove("active");
            button6.classList.remove("active");
            document.getElementById("proses").value = 'avalputihan';
        });
        
        button2.addEventListener("click", function() {
            button2.classList.add("active");
            button1.classList.remove("active");
            button3.classList.remove("active");
            button4.classList.remove("active");
            button5.classList.remove("active");
            button6.classList.remove("active");
            document.getElementById("proses").value = 'avalgrey';
        });
        button3.addEventListener("click", function() {
            button3.classList.add("active");
            button1.classList.remove("active");
            button2.classList.remove("active");
            button4.classList.remove("active");
            button5.classList.remove("active");
            button6.classList.remove("active");
            document.getElementById("proses").value = 'bcputihan';
        });
        button4.addEventListener("click", function() {
            button4.classList.add("active");
            button1.classList.remove("active");
            button2.classList.remove("active");
            button3.classList.remove("active");
            button5.classList.remove("active");
            button6.classList.remove("active");
            document.getElementById("proses").value = 'bcgrey';
        });
        button5.addEventListener("click", function() {
            button5.classList.add("active");
            button1.classList.remove("active");
            button2.classList.remove("active");
            button3.classList.remove("active");
            button4.classList.remove("active");
            button6.classList.remove("active");
            document.getElementById("proses").value = 'bsputihan';
        });
        button6.addEventListener("click", function() {
            button6.classList.add("active");
            button1.classList.remove("active");
            button2.classList.remove("active");
            button3.classList.remove("active");
            button4.classList.remove("active");
            button5.classList.remove("active");
            document.getElementById("proses").value = 'bsgrey';
        });

// Get the input element
const inputElement = document.getElementById('ukr');

// Add event listeners
inputElement.addEventListener('keypress', validateKeyPress);
inputElement.addEventListener('input', formatNumber);
inputElement.addEventListener('paste', handlePaste);

/**
 * Validates keypress events to only allow numbers and decimal points
 * @param {KeyboardEvent} event - The keypress event
 */
function validateKeyPress(event) {
  // Allow only numbers and decimal point
  if (!/[\d.]/.test(event.key)) {
    event.preventDefault();
    
    // Show error for comma
    if (event.key === ',') {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Gunakan titik untuk koma',
        confirmButtonColor: '#3085d6'
      });
    }
  }
  
  // Prevent multiple decimal points
  if (event.key === '.' && this.value.includes('.')) {
    event.preventDefault();
  }
}

/**
 * Formats the number with thousand separators and limits decimal places
 */
function formatNumber() {
  // Get the cursor position before formatting
  const cursorPos = this.selectionStart;
  const originalLength = this.value.length;
  
  // Remove any non-numeric characters except decimal point
  let value = this.value.replace(/[^\d.]/g, '');
  
  // Handle decimal places - limit to 2
  const parts = value.split('.');
  if (parts.length > 1) {
    parts[1] = parts[1].slice(0, 2); // Limit decimal to 2 places
    value = parts.join('.');
  }
  
  // Format with thousand separators
  const beforeDecimal = parts[0];
  const afterDecimal = parts.length > 1 ? '.' + parts[1] : '';
  
  // Add thousand separators
  const formattedBeforeDecimal = beforeDecimal.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  
  // Set the formatted value
  this.value = formattedBeforeDecimal + afterDecimal;
  
  // Adjust cursor position
  const newLength = this.value.length;
  const diff = newLength - originalLength;
  this.setSelectionRange(cursorPos + diff, cursorPos + diff);
}

/**
 * Handles paste events to validate and format pasted content
 * @param {ClipboardEvent} event - The paste event
 */
function handlePaste(event) {
  event.preventDefault();
  
  // Get pasted content
  const pastedText = (event.clipboardData || window.clipboardData).getData('text');
  
  // Check if it contains commas
  if (pastedText.includes(',')) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Gunakan titik untuk koma',
      confirmButtonColor: '#3085d6'
    });
    return;
  }
  
  // Filter out non-numeric and non-decimal characters
  const filteredText = pastedText.replace(/[^\d.]/g, '');
  
  // Insert filtered text at cursor position
  const start = this.selectionStart;
  const end = this.selectionEnd;
  const currentValue = this.value;
  
  this.value = currentValue.substring(0, start) + filteredText + currentValue.substring(end);
  
  // Update cursor position
  this.setSelectionRange(start + filteredText.length, start + filteredText.length);
  
  // Format the input
  formatNumber.call(this);
}

// Initialize SweetAlert2 if not already included
if (typeof Swal === 'undefined') {
  const sweetAlertScript = document.createElement('script');
  sweetAlertScript.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
  document.head.appendChild(sweetAlertScript);
}
    </script>
</body>
</html>