<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penjualan Manager</title>
    <link rel="stylesheet" href="<?=base_url('new_db/');?>style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Vithkuqi&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.02.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .autoComplete_wrapper input{
            width: 110%;
            transform: translateX(-10%);
        }
    </style>
</head>
<body>
    <div class="topbar">
       Penjualan
    </div>
    <div class="konten-mobile2">
        <div class="kotaknewpkg">
            <span>Filter Penjualan</span>
            <div style="width: 100%;display: flex;flex-direction: column;">
                <div class="form-label">
                    <label for="mc">Tanggal</label>
                    <input type="text" class="ipt" name="dates">
                </div>
                <div class="form-label">
                    <label for="autoComplete">Konsumen</label>
                    <div class="autoComplete_wrapper">
                        <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" autocapitalize="off">
                    </div>
                </div>
            </div>
        </div>
        <div class="fortable" style="margin-bottom: 25px;">
            <table>
                <tr>
                    <td><strong>No</strong></td>
                    <td><strong>Konsumen</strong></td>
                    <td><strong>Konstruksi</strong></td>
                    <td><strong>Jumlah</strong></td>
                </tr>
                <tr>
                    <td>Tes</td>
                    <td>Tes</td>
                    <td>Tes</td>
                    <td>Tes</td>
                </tr>
            </table>
        </div>
        <div class="card-kons">
            <div>SM03</div>
            <div>192.901</div>
        </div>
        <div class="card-kons">
            <div>SM03</div>
            <div>192.901</div>
        </div>
        <div class="card-kons">
            <div>SM03</div>
            <div>192.901</div>
        </div>
        <div class="card-kons">
            <div>SM03</div>
            <div>192.901</div>
        </div>
        <div class="card-kons">
            <div>SM03</div>
            <div>192.901</div>
        </div>
        <div class="card-kons">
            <div>SM03</div>
            <div>192.901</div>
        </div>
        <div class="card-kons">
            <div>SM03</div>
            <div>192.901</div>
        </div>
        <div class="card-kons">
            <div>SM03</div>
            <div>192.901</div>
        </div>
        <div class="card-kons">
            <div>SM03</div>
            <div>192.901</div>
        </div>
        <div class="card-kons">
            <div>SM03</div>
            <div>192.901</div>
        </div>       
        <div class="card-kons">
            <div>SM03</div>
            <div>192.901</div>
        </div>
        <div class="card-kons">
            <div>SM03</div>
            <div>192.901</div>
        </div>
        <div class="card-kons">
            <div>SM03</div>
            <div>192.901</div>
        </div>
        <div class="card-kons">
            <div>SM03</div>
            <div>192.901</div>
        </div>
        <div class="card-kons">
            <div>SM03</div>
            <div>192.901</div>
        </div>       
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $('input[name="dates"]').daterangepicker();
        const autoCompleteJS = new autoComplete({
            placeHolder: "Ketik Nama Konsumen...",
            data: {
                src: ["Sauce - Thousand Island", "Wild Boar - Tenderloin", "Goat - Whole Cut"],
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
    </script>
</body>
</html>