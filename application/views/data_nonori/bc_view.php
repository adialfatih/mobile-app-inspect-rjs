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
            <strong>Grade B Grey</strong>
            <table border="1" style="border-collapse:collapse;">
                <tr>
                    <th colspan="5" style="background:#ccc;">GRADE B GREY</th>
                </tr>
                <tr>
                    <th>No</th>
                    <th>Kode Roll</th>
                    <th>Konstruksi</th>
                    <th>Ukuran</th>
                    <th>Ket</th>
                </tr>
                <?php
                $qr = $this->db->query("SELECT * FROM `data_ig` WHERE bp_can_join='Grade B' AND loc_now='Pusatex'");
                $no=1;
                $ukuran_total1=0;
                $kons1 = array();
                foreach($qr->result() as $val){
                    $kode_roll = $val->kode_roll;
                    $kons = strtoupper($val->konstruksi);
                    $kd = $val->kode_roll;
                    $ukuran_total1+=$val->ukuran_ori;
                    if(in_array($kons, $kons1)){}else{ $kons1 []= $kons; }
                ?>
                <tr>
                    <td><?=$no;?></td>
                    <td><?=$kd;?></td>
                    <td><?=$kons;?></td>
                    <td><?=$val->ukuran_ori;?></td>
                    <td><?=$val->loc_now;?></td>
                </tr>
                <?php $no++; } ?>
                <tr>
                    <td>#</td>
                    <td>TOTAL</td>
                    <td></td>
                    <td><?=$ukuran_total1;?></td>
                    <td></td>
                </tr>
                
            </table>
            <strong>Grade C Grey</strong>
            <table border="1" style="border-collapse:collapse;">
                <tr>
                    <th colspan="5" style="background:#ccc;">GRADE C GREY</th>
                </tr>
                <tr>
                    <th>No</th>
                    <th>Kode Roll</th>
                    <th>Konstruksi</th>
                    <th>Ukuran</th>
                    <th>Ket</th>
                </tr>
                <?php
                $qr = $this->db->query("SELECT * FROM `data_ig` WHERE bp_can_join='Grade C' AND loc_now='Pusatex'");
                $no=1;
                $ukuran_total1=0;
                $kons1 = array();
                foreach($qr->result() as $val){
                    $kode_roll = $val->kode_roll;
                    $kons = strtoupper($val->konstruksi);
                    $kd = $val->kode_roll;
                    $ukuran_total1+=$val->ukuran_ori;
                    if(in_array($kons, $kons1)){}else{ $kons1 []= $kons; }
                ?>
                <tr>
                    <td><?=$no;?></td>
                    <td><?=$kd;?></td>
                    <td><?=$kons;?></td>
                    <td><?=$val->ukuran_ori;?></td>
                    <td><?=$val->loc_now;?></td>
                </tr>
                <?php $no++; } ?>
                <tr>
                    <td>#</td>
                    <td>TOTAL</td>
                    <td></td>
                    <td><?=$ukuran_total1;?></td>
                    <td></td>
                </tr>
                
            </table>
            <strong>Aval Grey</strong>
            <table border="1" style="border-collapse:collapse;">
                <tr>
                    <th colspan="6" style="background:#ccc;">AVAL GREY</th>
                </tr>
                <tr>
                    <th>No</th>
                    <th>Kode Roll</th>
                    <th>Konstruksi</th>
                    <th>Ukuran ORI</th>
                    <th>Ukuran BS</th>
                    <th>Ket</th>
                </tr>
                <?php
                $qr = $this->db->query("SELECT * FROM `data_ig` WHERE bp_can_join='Aval' AND loc_now='Pusatex'");
                $no=1;
                $ukuran_total1=0;
                $kons1 = array();
                foreach($qr->result() as $val){
                    $kode_roll = $val->kode_roll;
                    $kons = strtoupper($val->konstruksi);
                    $kd = $val->kode_roll;
                    $ukuran_total1+=$val->ukuran_ori;
                    if(in_array($kons, $kons1)){}else{ $kons1 []= $kons; }
                ?>
                <tr>
                    <td><?=$no;?></td>
                    <td><?=$kd;?></td>
                    <td><?=$kons;?></td>
                    <td><?=$val->ukuran_ori;?></td>
                    <td><?=$val->ukuran_bs;?></td>
                    <td><?=$val->loc_now;?></td>
                </tr>
                <?php $no++; } ?>
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
            <strong>Grade B Finish</strong>
            <table border="1" style="border-collapse:collapse;">
                <tr>
                    <th colspan="5" style="background:#ccc;">GRADE B Finish</th>
                </tr>
                <tr>
                    <th>No</th>
                    <th>Kode Roll</th>
                    <th>Konstruksi</th>
                    <th>Ukuran</th>
                    <th>Ket</th>
                </tr>
                <?php
                $qr = $this->db->query("SELECT * FROM `data_if` WHERE bp_canjoin='Grade B'");
                $no=1;
                $ukuran_total1=0;
                $kons1 = array();
                foreach($qr->result() as $val){
                    $kode_roll = $val->kode_roll;
                    $kons = strtoupper($val->konstruksi);
                    $kd = $val->kode_roll;
                    $fol = $this->data_model->get_byid('data_fol', ['kode_roll'=>$kd]);
                    $ukuran_total1+=$val->ukuran_ori;
                    $ukuran_yard = $ukuran_total1 / 0.9144;
                    $ukuran_yard = round($ukuran_yard,1);
                    if(in_array($kons, $kons1)){}else{ $kons1 []= $kons; }
                ?>
                <tr>
                    <td><?=$no;?></td>
                    <td><?=$kd;?></td>
                    <td><?=$kons;?></td>
                    <td><?=$val->ukuran_ori;?> Meter ( <?=$ukuran_yard;?> Yard )</td>
                    <td><?=$fol->num_rows()==0 ? 'Pusatex':'';?></td>
                </tr>
                <?php $no++; } ?>
                <tr>
                    <td>#</td>
                    <td>TOTAL</td>
                    <td></td>
                    <td><?=$ukuran_total1;?></td>
                    <td></td>
                </tr>
            </table>
            <strong>Grade C Finish</strong>
            <table border="1" style="border-collapse:collapse;">
                <tr>
                    <th colspan="5" style="background:#ccc;">GRADE C Finish</th>
                </tr>
                <tr>
                    <th>No</th>
                    <th>Kode Roll</th>
                    <th>Konstruksi</th>
                    <th>Ukuran</th>
                    <th>Ket</th>
                </tr>
                <?php
                $qr = $this->db->query("SELECT * FROM `data_if` WHERE bp_canjoin='Grade C'");
                $no=1;
                $ukuran_total1=0;
                $kons1 = array();
                foreach($qr->result() as $val){
                    $kode_roll = $val->kode_roll;
                    $kons = strtoupper($val->konstruksi);
                    $kd = $val->kode_roll;
                    $fol = $this->data_model->get_byid('data_fol', ['kode_roll'=>$kd]);
                    $ukuran_total1+=$val->ukuran_ori;
                    $ukuran_yard = $ukuran_total1 / 0.9144;
                    $ukuran_yard = round($ukuran_yard,1);
                    if(in_array($kons, $kons1)){}else{ $kons1 []= $kons; }
                ?>
                <tr>
                    <td><?=$no;?></td>
                    <td><?=$kd;?></td>
                    <td><?=$kons;?></td>
                    <td><?=$val->ukuran_ori;?> Meter ( <?=$ukuran_yard;?> Yard )</td>
                    <td><?=$fol->num_rows()==0 ? 'Pusatex':'';?></td>
                </tr>
                <?php $no++; } ?>
                <tr>
                    <td>#</td>
                    <td>TOTAL</td>
                    <td></td>
                    <td><?=$ukuran_total1;?></td>
                    <td></td>
                </tr>
            </table>
            <strong>Aval Finish</strong>
            <table border="1" style="border-collapse:collapse;">
                <tr>
                    <th colspan="5" style="background:#ccc;">Aval  Finish</th>
                </tr>
                <tr>
                    <th>No</th>
                    <th>Kode Roll</th>
                    <th>Konstruksi</th>
                    <th>Ukuran ori</th>
                    <th>Ket</th>
                </tr>
                <?php
                $qr = $this->db->query("SELECT * FROM `data_if` WHERE bp_canjoin='Aval'");
                $no=1;
                $ukuran_total1=0;
                $kons1 = array();
                foreach($qr->result() as $val){
                    $kode_roll = $val->kode_roll;
                    $kons = strtoupper($val->konstruksi);
                    $kd = $val->kode_roll;
                    $fol = $this->data_model->get_byid('data_fol', ['kode_roll'=>$kd]);
                    $ukuran_total1+=$val->ukuran_ori;
                    $ukuran_yard = $ukuran_total1 / 0.9144;
                    $ukuran_yard = round($ukuran_yard,1);
                    if(in_array($kons, $kons1)){}else{ $kons1 []= $kons; }
                ?>
                <tr>
                    <td><?=$no;?></td>
                    <td><?=$kd;?></td>
                    <td><?=$kons;?></td>
                    <td><?=$val->ukuran_ori;?> Meter ( <?=$ukuran_yard;?> Yard )</td>
                    <td><?=$fol->num_rows()==0 ? 'Pusatex':'';?></td>
                </tr>
                <?php $no++; } ?>
                <tr>
                    <td>#</td>
                    <td>TOTAL</td>
                    <td></td>
                    <td><?=$ukuran_total1;?></td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>