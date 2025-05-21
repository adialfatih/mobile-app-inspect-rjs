<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data BP</title>
</head>
<body>
    <h3>Menampilkan Data di Gudang Pusatex : <br></h3>
    <div style="width:100%;display:flex;justify-content:space-between;">
        <div style="width:49%;display:flex;flex-direction:column;">
            <strong>BP Grey</strong>
            <table border="1" style="border-collapse:collapse;">
                <tr>
                    <th>No</th>
                    <th>Kode Roll</th>
                    <th>Konstruksi</th>
                    <th>Ukuran</th>
                    <th>Ket</th>
                </tr>
                <?php
                $qr = $this->db->query("SELECT * FROM `kiriman_pusatex` WHERE ukuran>20 AND ukuran<50");
                $no=1;
                $ket = "";
                $idSudahInspect = array();
                $ukuran_total1 = 0;
                $kons1 = array();
                foreach($qr->result() as $val){
                    $idterima = $val->idterima;
                    $kons = strtoupper($val->konstruksi);
                    $kd = $val->kode_roll;
                    $dataif = $this->db->query("SELECT * FROM data_if WHERE kode_roll = '$kd' ")->num_rows();
                    $datafol = $this->db->query("SELECT * FROM data_fol WHERE kode_roll = '$kd' ")->num_rows();
                    if($dataif>0){
                        $idSudahInspect[] = $kd;
                        $ket .= "Sudah di inspect Finish. ";
                    }
                    if($datafol>0){
                        $ket .= "Sudah di Folding. ";
                    }
                    if($datafol == 0 AND $dataif==0){
                        $ukuran_total1+=$val->ukuran;
                        if(in_array($kons, $kons1)){}else{ $kons1 []= $kons; }
                ?>
                <tr>
                    <td><?=$no;?></td>
                    <td><?=$kd;?></td>
                    <td><?=$kons;?></td>
                    <td><?=$val->ukuran;?></td>
                    <td><?=$ket;?></td>
                </tr>
                <?php $no++; }
                    $ket = "";
                }
                ?>
                <tr>
                    <td>#</td>
                    <td>TOTAL</td>
                    <td></td>
                    <td><?=$ukuran_total1;?></td>
                    <td></td>
                </tr>
                
            </table>
        </div>
        <div style="width:49%;display:flex;flex-direction:column;">
            <strong>BP Finish</strong>
            <table border="1" style="border-collapse:collapse;">
                <tr>
                    <th>No</th>
                    <th>Kode Roll</th>
                    <th>Konstruksi</th>
                    <th>Ukuran</th>
                    <th>Ket</th>
                </tr>
                <?php
                $na = 1;
                $ukuran_total2 = 0;
                for ($i=0; $i <count($idSudahInspect) ; $i++) { 
                    $kode_roll = $idSudahInspect[$i];
                    $cek = $this->db->query("SELECT * FROM data_fol WHERE kode_roll = '$kode_roll' ")->num_rows();
                    if($cek == 0){
                    $dtrow = $this->data_model->get_byid('kiriman_pusatex',['kode_roll'=>$kode_roll])->row_array();
                    $ukuran_total2 += $dtrow['ukuran'];
                    ?>
                <tr>
                    <td><?=$na;?></td>
                    <td><?=$kode_roll;?></td>
                    <td><?=$dtrow['konstruksi'];?></td>
                    <td><?=$dtrow['ukuran'];?></td>
                    <td></td>
                </tr>
                    <?php $na++; }
                }
                ?>
                <tr>
                    <td>#</td>
                    <td>TOTAL</td>
                    <td></td>
                    <td><?=$ukuran_total2;?></td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>