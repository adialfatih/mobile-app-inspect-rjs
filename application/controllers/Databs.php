<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Databs extends CI_Controller
{
    function __construct()
    {
      parent::__construct();
      $this->load->model('data_model');
      date_default_timezone_set("Asia/Jakarta");
    }
   
  function index(){
        echo "Error 404";
  } //end

  function newbs(){
        $this->load->view('bsdata/input_dataroll');
  }
  function deldata(){
        $id = $this->input->post('id', TRUE);
        $kdroll = $this->input->post('kdroll', TRUE);
        $this->data_model->delete('ab_non_ori', 'id_abnon', $id);
        echo "oke";
  }
  function simpandata(){
        $username = $this->input->post('username', TRUE);
        $konstruksi = $this->input->post('konstruksi', TRUE);
        $proses = $this->input->post('proses', TRUE);
        $kdroll = $this->input->post('kdroll', TRUE);
        $ukr = $this->input->post('ukr', TRUE);
        $konstruksi = strtoupper($konstruksi);
        $kdroll = strtoupper($kdroll);
        $username = strtolower($username);
        if($username == "septi diah"){$posisi="RJS";}else{$posisi="Pusatex";}
        if($proses=="avalputihan"){ $proses2 = "Aval Putihan"; }
        if($proses=="avalgrey"){ $proses2 = "Aval Grey"; }
        if($proses=="bcputihan"){ $proses2 = "BC Putihan"; }
        if($proses=="bcgrey"){ $proses2 = "BC Grey"; }
        if($proses=="bsputihan"){ $proses2 = "BS Putihan"; }
        if($proses=="bsgrey"){ $proses2 = "BS Grey"; }
        if($username!="" && $konstruksi!="" && $proses!="" && $kdroll!="" && $ukr!=""){
            $cekUsername = $this->data_model->get_byid('a_operator', ['username'=>$username])->num_rows();
            if($cekUsername==1){
                $cekKons = $this->data_model->get_byid('tb_konstruksi', ['kode_konstruksi'=>$konstruksi])->num_rows();
                if($cekKons==1){
                    $cekKodeRoll = $this->data_model->get_byid('ab_non_ori', ['kode_roll'=>$kdroll])->num_rows();
                    if($cekKodeRoll==0){
                        $this->data_model->saved('ab_non_ori',[
                            'kode_roll'=>$kdroll,
                            'konstruksi'=>$konstruksi,
                            'ukuran'=>$ukr,
                            'jns_kain'=>$proses,
                            'operator'=>$username,
                            'posisi'=>$posisi,
                            'tgl_input'=>date('Y-m-d'),
                            'tms'=>date('Y-m-d H:i:s')
                        ]);
                        $txt = $kdroll." disimpan sebagai ".$proses2."";
                        echo json_encode(array("statusCode"=>200, "psn"=>$txt));
                    } else {
                        $txt = "Kode Roll ".$kdroll." sudah ada";
                        echo json_encode(array("statusCode"=>404, "psn"=>$txt));
                    }
                } else {
                    $txt = "Konstruksi ".$konstruksi." tidak ditemukan";
                    echo json_encode(array("statusCode"=>404, "psn"=>$txt));
                }
            } else {
                echo json_encode(array("statusCode"=>404, "psn"=>"Anda perlu login ulang..!!"));
            }
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"Isi Data dengan benar"));
        }
  } //end

  function loadData(){
        $tgl1 = $this->input->post('tgl', TRUE);
        $proses = $this->input->post('proses', TRUE);
        if($proses=="avalputihan"){ $proses21 = "Aval Putihan"; }
        if($proses=="avalgrey"){ $proses21 = "Aval Grey"; }
        if($proses=="bcputihan"){ $proses21 = "BC Putihan"; }
        if($proses=="bcgrey"){ $proses21 = "BC Grey"; }
        if($proses=="bsputihan"){ $proses21 = "BS Putihan"; }
        if($proses=="bsgrey"){ $proses21 = "BS Grey"; }
        if($tgl1 == "today"){
            $tgl = date('Y-m-d');
        } else {
            $tgl = $this->input->post('tgl', TRUE);
        }
        if($proses=="all"){
            $qry = $this->data_model->get_byid('ab_non_ori', ['tgl_input'=>$tgl]);
        } else {
            $qry = $this->data_model->get_byid('ab_non_ori', ['jns_kain'=>$proses,'tgl_input'=>$tgl]);
        }
        if($qry->num_rows() > 0){
            ?>
            <table border="1">
                <tr>
                    <th>No</th>
                    <th>Kode Roll</th>
                    <th>Konstruksi</th>
                    <th>Jenis</th>
                    <th>Ukuran</th>
                    <th>Operator</th>
                    <th>Del</th>
                </tr>
                <?php
                $no=1;
                foreach($qry->result() as $val){
                    if($val->jns_kain=="avalputihan"){ $proses2 = "Aval Putihan"; }
                    if($val->jns_kain=="avalgrey"){ $proses2 = "Aval Grey"; }
                    if($val->jns_kain=="bcputihan"){ $proses2 = "BC Putihan"; }
                    if($val->jns_kain=="bcgrey"){ $proses2 = "BC Grey"; }
                    if($val->jns_kain=="bsputihan"){ $proses2 = "BS Putihan"; }
                    if($val->jns_kain=="bsgrey"){ $proses2 = "BS Grey"; }
                    ?>
                <tr>
                    <td><?=$no;?></td>
                    <td><?=$val->kode_roll;?></td>
                    <td><?=$val->konstruksi;?></td>
                    <td><?=$proses2;?></td>
                    <td><?=$val->ukuran;?></td>
                    <td><?=$val->operator;?></td>
                    <td><a href="javascript:;" style="color:red;text-decoration:none;" onclick="delData('<?=$val->id_abnon;?>','<?=$val->kode_roll;?>')">Hapus</a></td>
                </tr>
                    <?php $no++;
                }
                ?>
            </table>
            <?php
        } else {
            ?>
            <table border="1">
                <tr>
                    <th>No</th>
                    <th>Kode Roll</th>
                    <th>Konstruksi</th>
                    <th>Jenis</th>
                    <th>Ukuran</th>
                    <th>Del</th>
                </tr>
                <tr>
                    <td colspan="6" style="color:red;"><?=$proses21;?> Tanggal <?=date('d M Y', strtotime($tgl));?> Tidak ada data</td>
                </tr>
            </table>
            <?php
        }
  } //end

    function showDataStok(){
        $avalputihan = $this->db->query("SELECT COUNT(kode_roll) AS jml FROM ab_non_ori WHERE jns_kain='avalputihan' AND (posisi='Pusatex' OR posisi='RJS')")->row("jml");
        $avalgrey    = $this->db->query("SELECT COUNT(kode_roll) AS jml FROM ab_non_ori WHERE jns_kain='avalgrey' AND (posisi='Pusatex' OR posisi='RJS')")->row("jml");
        $bcputihan   = $this->db->query("SELECT COUNT(kode_roll) AS jml FROM ab_non_ori WHERE jns_kain='bcputihan' AND (posisi='Pusatex' OR posisi='RJS')")->row("jml");
        $bcgrey      = $this->db->query("SELECT COUNT(kode_roll) AS jml FROM ab_non_ori WHERE jns_kain='bcgrey' AND (posisi='Pusatex' OR posisi='RJS')")->row("jml");
        $bsputihan   = $this->db->query("SELECT COUNT(kode_roll) AS jml FROM ab_non_ori WHERE jns_kain='bsputihan' AND (posisi='Pusatex' OR posisi='RJS')")->row("jml");
        $bsgrey      = $this->db->query("SELECT COUNT(kode_roll) AS jml FROM ab_non_ori WHERE jns_kain='bsgrey' AND (posisi='Pusatex' OR posisi='RJS')")->row("jml");

        $total_roll = $avalputihan+$avalgrey+$bcputihan+$bcgrey+$bsputihan+$bsgrey;
        $avalputihanPJG = $this->db->query("SELECT SUM(ukuran) AS pjg FROM ab_non_ori WHERE jns_kain='avalputihan' AND (posisi='Pusatex' OR posisi='RJS')")->row("pjg");
        $avalgreyPJG    = $this->db->query("SELECT SUM(ukuran) AS pjg FROM ab_non_ori WHERE jns_kain='avalgrey' AND (posisi='Pusatex' OR posisi='RJS')")->row("pjg");
        $bcputihanPJG   = $this->db->query("SELECT SUM(ukuran) AS pjg FROM ab_non_ori WHERE jns_kain='bcputihan' AND (posisi='Pusatex' OR posisi='RJS')")->row("pjg");
        $bcgreyPJG      = $this->db->query("SELECT SUM(ukuran) AS pjg FROM ab_non_ori WHERE jns_kain='bcgrey' AND (posisi='Pusatex' OR posisi='RJS')")->row("pjg");
        $bsputihanPJG   = $this->db->query("SELECT SUM(ukuran) AS pjg FROM ab_non_ori WHERE jns_kain='bsputihan' AND (posisi='Pusatex' OR posisi='RJS')")->row("pjg");
        $bsgreyPJG      = $this->db->query("SELECT SUM(ukuran) AS pjg FROM ab_non_ori WHERE jns_kain='bsgrey' AND (posisi='Pusatex' OR posisi='RJS')")->row("pjg");
        $totalPJG = $avalputihanPJG+$avalgreyPJG+$bcputihanPJG+$bcgreyPJG+$bsputihanPJG+$bsgreyPJG;
        if(floor($totalPJG) == $totalPJG){
            $totalPJG2 = number_format($totalPJG,0,',','.');
        } else {
            $totalPJG2 = number_format($totalPJG,2,',','.');
        }
        echo json_encode(array(
            "statusCode"        => 200, 
            "jmlAvalPutihan"    => $avalputihan==""?0:$avalputihan,
            "jmlAvalGrey"       => $avalgrey==""?0:$avalgrey,
            "jmlBcPutihan"      => $bcputihan==""?0:$bcputihan,
            "jmlBcGrey"         => $bcgrey==""?0:$bcgrey,
            "jmlBsPutihan"      => $bsputihan==""?0:$bsputihan,
            "jmlBsGrey"         => $bsgrey==""?0:$bsgrey,
            "totalRoll"         => $total_roll==""?0:$total_roll,
            "pjgAvalPutihan"    => $avalputihanPJG==""?0:$avalputihanPJG,
            "pjgAvalGrey"       => $avalgreyPJG==""?0:$avalgreyPJG,
            "pjgBcPutihan"      => $bcputihanPJG==""?0:$bcputihanPJG,
            "pjgBcGrey"         => $bcgreyPJG==""?0:$bcgreyPJG,
            "pjgBsPutihan"      => $bsputihanPJG==""?0:$bsputihanPJG,
            "pjgBsGrey"         => $bsgreyPJG==""?0:$bsgreyPJG,
            'status'            => 'success',
            'totalPJG'          => $totalPJG2
        ));
    } //end
    function showDataStokByFilter(){
        $proses    = $this->input->post('proses', TRUE);
        if($proses=="avalputihan"){ $proses21 = "Aval Putihan"; }
        if($proses=="avalgrey"){ $proses21 = "Aval Grey"; }
        if($proses=="bcputihan"){ $proses21 = "BC Putihan"; }
        if($proses=="bcgrey"){ $proses21 = "BC Grey"; }
        if($proses=="bsputihan"){ $proses21 = "BS Putihan"; }
        if($proses=="bsgrey"){ $proses21 = "BS Grey"; }
        $prosesRJS = $this->data_model->get_byid('ab_non_ori', ['jns_kain'=>$proses,'posisi'=>'RJS']);
        $prosesPST = $this->data_model->get_byid('ab_non_ori', ['jns_kain'=>$proses,'posisi'=>'Pusatex']);
        echo "<div style='width:100%;display:flex;flex-direction:column;'>";
        if($prosesPST->num_rows() > 0){
            $kons = array();
            foreach($prosesPST->result() as $val){
                if(!in_array($val->konstruksi, $kons)){
                    $kons[] = $val->konstruksi;
                }
            }
            ?>
            <div class="table-container" style="min-width:100%;">
                <table border="1">
                    <tr>
                        <th colspan="4">Data di Pusatex</th>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Konstruksi</th>
                        <th>Total Roll</th>
                        <th>Total Panjang</th>
                    </tr>
            <?php
            $no=1;
            foreach($kons as $val){
                $gulung = $this->data_model->get_byid('ab_non_ori', ['jns_kain'=>$proses,'posisi'=>'Pusatex','konstruksi'=>$val])->num_rows();
                $ttlpjg = $this->db->query("SELECT SUM(ukuran) AS pjg FROM ab_non_ori WHERE jns_kain='$proses' AND posisi='Pusatex' AND konstruksi='$val'")->row("pjg");
                echo "<tr>";
                echo "<td>".$no."</td>";
                ?>
                <td>
                    <a href="javascript:void(0)" onclick="tampilkanDetil('<?=$proses;?>','<?=$val;?>','PST','<?=$proses21;?>')" style="color:red;text-decoration:none;font-weight:bold;"><?=$val;?></a>
                </td>
                <?php
                echo "<td>".$gulung."</td>";
                echo "<td>".$ttlpjg."</td>";
                echo "</tr>";
                $no++;
            }
            echo "</table></div>";
        }
        if($prosesRJS->num_rows() > 0){
            $kons = array();
            foreach($prosesRJS->result() as $val){
                if(!in_array($val->konstruksi, $kons)){
                    $kons[] = $val->konstruksi;
                }
            }
            ?>
            <div class="table-container" style="min-width:100%;">
                <table border="1">
                    <tr>
                        <th colspan="4">Data di Rindang</th>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Konstruksi</th>
                        <th>Total Roll</th>
                        <th>Total Panjang</th>
                    </tr>
            <?php
            $no=1;
            foreach($kons as $val){
                $gulung = $this->data_model->get_byid('ab_non_ori', ['jns_kain'=>$proses,'posisi'=>'RJS','konstruksi'=>$val])->num_rows();
                $ttlpjg = $this->db->query("SELECT SUM(ukuran) AS pjg FROM ab_non_ori WHERE jns_kain='$proses' AND posisi='RJS' AND konstruksi='$val'")->row("pjg");
                echo "<tr>";
                echo "<td>".$no."</td>";
                ?>
                <td>
                    <a href="javascript:void(0)" onclick="tampilkanDetil('<?=$proses;?>','<?=$val;?>','RJS','<?=$proses21;?>')" style="color:red;text-decoration:none;font-weight:bold;"><?=$val;?></a>
                </td>
                <?php
                echo "<td>".$gulung."</td>";
                echo "<td>".$ttlpjg."</td>";
                echo "</tr>";
                $no++;
            }
            echo "</table></div>";
        }
        echo "</div>";
    }

    function showDataStokByFilterDetil(){
        $proses     = $this->input->post('proses');
        $konstruksi = $this->input->post('kons');
        $posisi     = $this->input->post('loc');
        $dataProses = $this->input->post('dataProses');
        if($posisi == 'PST'){
            $loc = "Pusatex";
        } else {
            $loc = "RJS";
        }
        $cekData    = $this->data_model->get_byid('ab_non_ori', ['konstruksi'=>$konstruksi,'jns_kain'=>$proses,'posisi'=>$loc]);
        if($cekData->num_rows() > 0){
            ?>
            <div style='width:100%;display:flex;flex-direction:column;'>
            <div class="table-container" style="min-width:100%;">
                <table border="1">
                    <tr>
                        <th colspan="7"><?=$dataProses;?> konstruksi <font style='color:red;font-weight:bold;'><?=$konstruksi;?></font> di <?=$loc;?></th>
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Ukuran</th>
                        <th>Operator</th>
                        <th>Loc</th>
                        <th>Tms</th>
                        <th>#</th>
                    </tr>
                    <?php $no=1;
                    foreach($cekData->result() as $val){
                        $x = explode(' ', $val->tms);
                        $xx = explode('-', $x[0]);
                        $tms = $xx[2]."/".$xx[1]."/".$xx[0]." ".$x[1];
                        ?><tr id="rtbl<?=$val->id_abnon;?>"><?php
                        echo "<td>".$no."</td>";
                        echo "<td>".$val->kode_roll."</td>";
                        echo "<td>".$val->ukuran."</td>";
                        echo "<td>".ucwords($val->operator)."</td>";
                        echo "<td>".$val->posisi."</td>";
                        echo "<td>".$tms."</td>";
                        ?>
                        <td>
                            <a href="javascript:void(0)" onclick="deleteRollAbs('<?=$val->kode_roll;?>','<?=$val->id_abnon;?>')" style="color:red;text-decoration:none;font-weight:bold;">Delete</a>
                        </td>
                        <?php
                        echo "</tr>";
                        $no++;
                    }
                    ?>
                </table>
            </div>
            </div>
            <?php
        } else {
            echo "<div style='width:100%;>";
            echo "Data $dataProses dengan konstruksi <font style='color:red;font-weight:bold;'>".$konstruksi."</font> tidak ditemukan di $loc";
            echo "</div>";
        }
    }

    function delAbnon(){
        $id = $this->input->post('id');
        $this->db->query("DELETE FROM ab_non_ori WHERE id_abnon='$id'");
        echo "1";
    }
}