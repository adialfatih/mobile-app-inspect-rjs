<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{
    function __construct()
    {
      parent::__construct();
      $this->load->model('data_model');
      date_default_timezone_set("Asia/Jakarta");
    //   if($this->session->userdata('login_form') != "rindangjati_sess"){
	// 	  redirect(base_url("login"));
	//   }
    }
   
  function index(){
        $this->load->view('users/login');
  } //end

  function insgrey(){
        $this->load->view('users/insgrey');
  }
  function insfinish(){
      $this->load->view('users/insfinish');
  }
  function folgrey(){
      $this->load->view('users/folgrey');
  }
    function folfinish(){
      $this->load->view('users/folfinish');
  }
  function joinpieces(){
    $this->load->view('users/folfinishjoin');
  } 
  function penjualan(){
      $this->load->view('users/penjualan');
  }
  function createpenjualan(){
    $this->load->view('users/createpenjualan');
  }
  //ini  dibawah untuk menambahkan stok lama
  function createpenjualan2(){
    $this->load->view('users/createpenjualan2');
  }
  function createkirimpst(){
    $this->load->view('users/createkirimpst');
  }
  function createkirimpst2(){
    $this->load->view('users/createkirimpst2');
  }
  function createkirimpst3(){
    $this->load->view('users/createkirimpst3');
  }
    function kirimpst(){
      $this->load->view('users/kirimpst');
  }
  function terimafrompst(){
    $this->load->view('users/terimabarangfrompst');
  }
  function hapusKirimanPusatex(){
        $kd = $this->input->post('kd');
        $akd = $this->data_model->get_byid('kiriman_pusatex',['kode_roll'=>$kd])->row_array();
        $ukr = $akd['ukuran'];
        $kons = $akd['konstruksi'];
        $tgl = $akd['tanggal'];
        $opt = $akd['operator'];
        $stok = $this->data_model->get_byid('data_stok',['dep'=>'newSamatex','kode_konstruksi'=>$kons])->row_array();
        $ukrNow = floatval($stok['prod_ig']) - floatval($ukr);
        $this->data_model->updatedata('idstok',$stok['idstok'],'data_stok',['prod_ig'=>round($ukrNow,2)]);
        $this->data_model->updatedata('kode_roll',$kd,'data_ig',['loc_now'=>'Pusatex']);
        //$this->data_model->delete('data_ig','kode_roll',$kd);
        $this->data_model->delete('kiriman_pusatex','kode_roll',$kd);
        echo "oke";
  }
  function loadKirimanPusatex(){
        $user = $this->input->post('username');
        $tgl = $this->input->post('tgl');
        //$query = $this->data_model->get_byid('kiriman_pusatex',['tanggal'=>$tgl, 'operator'=>$user]);
        $query = $this->db->query("SELECT * FROM kiriman_pusatex WHERE tanggal='$tgl' AND operator='$user' ORDER BY idterima DESC");
        if($query->num_rows() > 0){
            echo '<tr>
                    <td>Kode Roll</td>
                    <td>Ukuran</td>
                    <td>MC</td>
                    <td>Konstruksi</td>
                    <td>Del</td>
                </tr>';
            foreach($query->result() as $val):
            echo "<tr>";
            echo "<td>".$val->kode_roll."</td>";
            echo "<td>".$val->ukuran."</td>";
            echo "<td>".$val->mc."</td>";
            echo "<td>".$val->konstruksi."</td>";
            ?><td sytle="color:red;">
                <img src="<?=base_url('assets/del.png');?>" alt="Delete" style="width:20px;" onclick="delpkg('<?=$val->kode_roll;?>')">
            </td><?php
            echo "</tr>";
            endforeach;
        } else {
            echo '<tr>
                    <td>Kode Roll</td>
                    <td>Ukuran</td>
                    <td>MC</td>
                    <td>Konstruksi</td>
                </tr>';
            echo "<tr><td colspan='4'>Tidak ada data kiriman hari ini</td></tr>";
        }
  }

  function cekopt(){
      $proses = $this->input->post('proses');
      $namaUser = $this->input->post('namaUser');
      $kecilkan_user = strtolower($namaUser);
      $cek_user = $this->data_model->get_byid('a_operator', ['username'=>$kecilkan_user]);
      if($cek_user->num_rows() == 1){
          $this->data_model->updatedata('username',$kecilkan_user,'a_operator',['produksi'=>$proses]);
          //$proses_user = $cek_user->row("produksi");
          //if($proses_user == $proses){
            echo json_encode(array("statusCode"=>200, "psn"=>"oke"));
          //} else {
            //echo json_encode(array("statusCode"=>200, "psn"=>"null"));
          //}
          
      } else {
          echo json_encode(array("statusCode"=>404, "psn"=>"oke"));
      }
      
  } //end
  function delbefore(){
      $id = $this->input->post('id');
      $this->data_model->delete('data_if_before','idifbfr',$id);
      echo json_encode(array("statusCode"=>200, "psn"=>"oke"));
  }
  function delbefore2(){
      $id = $this->input->post('id');
      $this->data_model->delete('data_if_before','kode_roll',$id);
      echo json_encode(array("statusCode"=>200, "psn"=>"oke"));
  }
  function loaddata(){
      $proses = $this->input->post('proses');
      $username = $this->input->post('username');
      
      $username = strtolower($username);
      $tgl = date('Y-m-d');
      if($proses == "insfinishbefore"){
        $tgl = $this->input->post('tgl');
        if($tgl == "null"){
            $tgl = date('Y-m-d');
        }
        echo '<tr><td colspan="6">Terima Kode Tanggal <strong>'.date('d M Y', strtotime($tgl)).'</strong></td></tr>';
        echo "<tr>
            <td><strong>No.</strong></td>
            <td><strong>Kode Roll</strong></td>
            <td><strong>Konstruksi</strong></td>
            <td><strong>Ukuran</strong></td>
            <td><strong>Penerima</strong></td>
            <td><strong>#</strong></td>
        </tr>";
        $cekData = $this->data_model->get_byid('data_if_before', ['tgl'=>$tgl]);
        if($cekData->num_rows() > 0){
            $_kons = array();
            foreach($cekData->result() as $n => $val):
                echo "<tr>";                
                $nomor = $n+1;
                echo "<td>".$nomor."</td>";
                echo "<td>".$val->kode_roll."</td>";
                echo "<td>".$val->konstruksi."</td>";
                echo "<td>".$val->ukuran."</td>";
                echo "<td>".strtoupper($val->users)."</td>";
                ?><td>
                        <img src="<?=base_url('assets/del.png');?>" alt="Delete" style="width:20px;" onclick="owek('<?=$val->idifbfr;?>')">
                    </td><?php
                echo "</tr>";
                $thisKons = strtoupper($val->konstruksi);
                if(in_array($thisKons, $_kons)){} else {
                    array_push($_kons, $thisKons);
                }
            endforeach;
            foreach($_kons as $val):
                $totalPjg = $this->db->query("SELECT SUM(ukuran) AS jml FROM data_if_before WHERE konstruksi='$val' AND tgl='$tgl'")->row("jml");
                if($totalPjg == floor($totalPjg)){
                    $totalPjg1 = number_format($totalPjg,0,',','.');
                } else {
                    $totalPjg1 = number_format($totalPjg,2,',','.');
                }
                echo '<tr><td colspan="6"><strong>'.$val.' : '.$totalPjg1.'</strong></td></tr>';
            endforeach;
        } else {
            echo '<tr><td colspan="6">Data Kosong</td></tr>';
        }
      }
      if($proses == "insgrey"){
          //$query = $this->data_model->get_byid('data_ig', ['tanggal'=>$tgl, 'operator'=>$username]);
          $query = $this->db->query("SELECT * FROM data_ig WHERE tanggal='$tgl' AND operator='$username' ORDER BY id_data DESC");
          echo "<tr>
                    <td><strong>No.</strong></td>
                    <td><strong>Kode Roll</strong></td>
                    <td><strong>Konstruksi</strong></td>
                    <td><strong>MC</strong></td>
                    <td><strong>Ukuran</strong></td>
                    <td><strong>#</strong></td>
                </tr>";
          if($query->num_rows() > 0){
              $jumlah_data = $query->num_rows();
              foreach($query->result() as $n => $val):
                  echo "<tr>";
                  $nomor = $n+1;
                  echo "<td>".$jumlah_data."</td>";
                  echo "<td>".$val->kode_roll."</td>";
                  echo "<td>".$val->konstruksi."</td>";
                  echo "<td>".$val->no_mesin."</td>";
                  echo "<td>".$val->ukuran_ori."</td>";
                  ?><td>
                        <img src="<?=base_url('assets/del.png');?>" alt="Delete" style="width:20px;" onclick="owek('<?=$val->id_data;?>')">
                    </td><?php
                  echo "</tr>";
                  $jumlah_data--;
              endforeach;
          } else {
              echo '<tr><td colspan="5">Data Inspect Grey Anda Masih Kosong</td></tr>';
          }
      } //end insgrey
      
        if($proses == "insfinish"){
            //$query = $this->data_model->get_byid('data_ig', ['tanggal'=>$tgl, 'operator'=>$username]);
            $query = $this->db->query("SELECT * FROM data_if WHERE tgl_potong='$tgl' AND operator='$username' ORDER BY id_infs DESC");
            echo "<tr>
                      <td><strong>No.</strong></td>
                      <td><strong>Kode Roll</strong></td>
                      <td><strong>Konstruksi</strong></td>
                      <td><strong>Ukr Sblm</strong></td>
                      <td><strong>Ukr (Yrd)</strong></td>
                      <td><strong>Del</strong></td>
                  </tr>";
            if($query->num_rows() > 0){
                $jumlah_data = $query->num_rows();
                foreach($query->result() as $n => $val):
                    echo "<tr>";
                    $nomor = $n+1;
                    echo "<td>".$jumlah_data."</td>";
                    echo "<td>".$val->kode_roll."</td>";
                    echo "<td>".$val->konstruksi."</td>";
                    $nomc = $this->data_model->get_byid('data_ig',['kode_roll'=>$val->kode_roll]);
                    if($nomc->num_rows() == 1){
                        $nomc2 = $nomc->row("no_mesin");
                    } else {
                        $aslikode = substr($val->kode_roll, 0, -1);
                        $nomc2 = $this->data_model->get_byid('data_ig',['kode_roll'=>$aslikode])->row("no_mesin");
                    }
                    echo "<td>".$val->ukuran_sebelum."</td>";
                    $ori_yard = $val->ukuran_ori / 0.9144;
                    $showyard = round($ori_yard,2);
                    echo "<td>".$showyard."</td>";
                    ?><td><a href="#as" onclick="kuyhas('<?=$val->id_infs;?>')">
                            <img src="<?=base_url('assets/del.png');?>" alt="Delete" style="width:20px;" ></a>
                        </td><?php
                    echo "</tr>";
                    $jumlah_data--;
                endforeach;
            } else {
                echo '<tr><td colspan="6">Data Inspect Finish Anda Masih Kosong</td></tr>';
            }
            $query22 = $this->db->query("SELECT * FROM bs_finish_samatex WHERE tgl='$tgl' AND operator='$username' ORDER BY iddataigbs DESC");
            if($query22->num_rows() > 0){
                echo "<tr><td colspan='6'><strong>Data Kode Roll BS</strong></td></tr>";
                foreach($query22->result() as $n => $val){
                    echo "<tr>";
                    echo "<td></td>";
                    echo "<td>BSF".$val->iddataigbs."</td>";
                    echo "<td>".$val->konstruksi_real."</td>";
                    echo "<td></td>";
                    echo "<td>".$val->ukuran_bs."</td>";
                    echo "<td></td>";
                    echo "</tr>";
                }
            }
        } //end insfinsih
    if($proses == "folgrey"){
      $tgl2 = $this->input->post('tgl');
      if($tgl2=="null"){} else { $tgl= $tgl2; }
      //$query = $this->data_model->get_byid('data_ig', ['tanggal'=>$tgl, 'operator'=>$username]);
      if($username=="syafiq" OR $username=="septi"){
        $query = $this->db->query("SELECT * FROM data_fol WHERE tgl='$tgl' ORDER BY id_fol DESC");
      } else {
        $query = $this->db->query("SELECT * FROM data_fol WHERE tgl='$tgl' AND operator='$username' ORDER BY id_fol DESC");
      }
      echo "<tr>
                <td><strong>No.</strong></td>
                <td><strong>Kode Roll</strong></td>
                <td><strong>Konstruksi</strong></td>
                <td><strong>MC</strong></td>
                <td><strong>Ukr Sblm</strong></td>
                <td><strong>Ukuran</strong></td>
                <td><strong>Del</strong></td>
            </tr>";
      if($query->num_rows() > 0){
          $jumlah_data = $query->num_rows();
          $ar1 = array();
          $ar2 = array();
          $ar3 = array();
          $ar4 = array();
          $ar5 = array();
          $ar6 = array();
          $ar7 = array();
          foreach($query->result() as $n => $val):
              $nomor = $n+1;
              $_kd = $val->kode_roll;
              $nomc = $this->data_model->get_byid('data_ig',['kode_roll'=>$val->kode_roll]);
              if($nomc->num_rows() == 1){
                  $nomc2 = $nomc->row("no_mesin");
              } else {
                  $aslikode = substr($val->kode_roll, 0, -1);
                  $nomc2 = $this->data_model->get_byid('data_ig',['kode_roll'=>$aslikode])->row("no_mesin");
              }
              
              if($val->jns_fold=="Finish"){ 
                $_st="Y"; 
                $_ukr1 = $val->ukuran;
                $_ukr = number_format($_ukr1,2,',','.');
                $_sblm2 = $this->data_model->get_byid('data_if',['kode_roll'=>$_kd])->row("ukuran_ori");
                $_sblm1 = floatval($_sblm2) / 0.9144;
                $_sblm = round($_sblm1,1);
              } else { 
                $_st="M"; 
                $_ukr = $val->ukuran;
                $_sblm = $this->data_model->get_byid('data_ig',['kode_roll'=>$_kd])->row("ukuran_ori");
              }
                $ar1[] = $jumlah_data;
                $ar2[] = $val->kode_roll;
                $ar3[] = $val->konstruksi;
                $ar4[] = $nomc2;
                $ar5[] = $_ukr." ".$_st;
                $ar6[] = $val->id_fol;
                $ar7[] = $_sblm;
              $jumlah_data--;
          endforeach;
          for ($i=0; $i <count($ar1) ; $i++) { 
                echo "<tr>";
                echo "<td>".$ar1[$i]."</td>";
                echo "<td>".$ar2[$i]."</td>";
                echo "<td>".$ar3[$i]."</td>";
                echo "<td>".$ar4[$i]."</td>";
                echo "<td>".$ar7[$i]."</td>";
                echo "<td>".$ar5[$i]."</td>";
                ?><td><a href="#del" onclick="kuyhas('<?=$ar6[$i];?>')">
                    <img src="<?=base_url('assets/del.png');?>" alt="Delete" style="width:20px;" ></a>
                </td><?php
                echo "</tr>";
          }
          echo "<tr><td colspan='7' style='font-size:15px;'>";
          if($username=="syafiq" OR $username=="septi"){
            $op = $this->db->query("SELECT DISTINCT operator FROM data_fol WHERE tgl='$tgl'");
            foreach($op->result() as $v){
                $vv = $v->operator;
                $gulung = $this->data_model->get_byid('data_fol',['operator'=>$vv,'tgl'=>$tgl])->num_rows();
                $fns = $this->db->query("SELECT SUM(ukuran) AS jml FROM data_fol WHERE operator='$vv' AND tgl='$tgl' AND jns_fold='Finish'")->row('jml');
                $grey = $this->db->query("SELECT SUM(ukuran) AS jml FROM data_fol WHERE operator='$vv' AND tgl='$tgl' AND jns_fold='Grey'")->row('jml');
                if($fns==floor($fns)){
                    $fns = number_format($fns,0,',','.');
                } else {
                    $fns = number_format($fns,2,',','.');
                }
                if($grey==floor($grey)){
                    $grey = number_format($grey,0,',','.');
                } else {
                    $grey = number_format($grey,2,',','.');
                }
                if(floatval($fns)>0){ $ts = "(Finish $fns yard)"; } else { $ts=""; }
                if(floatval($grey)>0){ $ts2 = "(Grey $grey meter)"; } else { $ts2=""; }
                echo strtoupper($v->operator)." : ".$gulung." Roll $ts $ts2<br>";
            }
          } else {
            $vv = $username;
            $gulung = $this->data_model->get_byid('data_fol',['operator'=>$vv,'tgl'=>$tgl])->num_rows();
                $fns = $this->db->query("SELECT SUM(ukuran) AS jml FROM data_fol WHERE operator='$vv' AND tgl='$tgl' AND jns_fold='Finish'")->row('jml');
                $grey = $this->db->query("SELECT SUM(ukuran) AS jml FROM data_fol WHERE operator='$vv' AND tgl='$tgl' AND jns_fold='Grey'")->row('jml');
                if(floatval($fns)>0){ $ts = "(Finish $fns yard)"; } else { $ts=""; }
                if(floatval($grey)>0){ $ts2 = "(Grey $grey meter)"; } else { $ts2=""; }
                echo strtoupper($vv)." : ".$gulung." Roll $ts $ts2<br>";
          }
          echo "</td></tr>";
      } else {
          echo '<tr><td colspan="6">Data Folding Grey Anda Masih Kosong</td></tr>';
      }
    } //end folgrey
    
      
  } //end

  function prosesInsGrey(){
        $jamSaatIni = date('H');
        if ($jamSaatIni >= 14) {
            $shift = "2";
        } else {
            $shift = "1";
        }
        $tableKode = $this->data_model->get_byid('data_ig_code', ['idcode'=>'1'])->row_array();
        $numSkr = $tableKode['numskr'];
        $newNumber = intval($numSkr) + 1;
        $setKode = $tableKode['alpabet']."".$newNumber;
        // $searchKode = "SF";
        // $pemisah = "F";
        // $cekkode = $this->db->query("SELECT id_data,kode_roll FROM data_ig WHERE kode_roll LIKE '%$searchKode%' ORDER BY id_data DESC LIMIT 1");
        // if($cekkode->num_rows() == 0){
        //     $setKode = "".$searchKode."1";
        // } else {
        //     $ex = explode($pemisah, $cekkode->row('kode_roll'));
        //     $number = intval($ex[1]) + 1;
        //     $setKode = "".$searchKode."".$number."";
        // }
        
        $kons = $this->input->post('kons');
        $mc = $this->input->post('mc');
        $beam = $this->input->post('beam');
        $oka = $this->input->post('oka');
        $ori = $this->input->post('ori');
        $bs = $this->input->post('bs');
        $bp = $this->input->post('bp');
        $tgl = $this->input->post('tgl');
        $operator = $this->input->post('username');
        $opt = strtolower($operator);
        $cek_opt = $this->data_model->get_byid('a_operator',['username'=>$opt]);
        if($cek_opt->num_rows() == 1){
            $cek_kons = $this->data_model->get_byid('tb_konstruksi', ['kode_konstruksi'=>$kons]);
            if($cek_kons->num_rows() == 1){
                $cekKoder = $this->data_model->get_byid('data_ig',['kode_roll'=>$setKode]);
                if($cekKoder->num_rows() == 0){
                    $dtlist = [
                        'kode_roll' => strtoupper($setKode),
                        'konstruksi' => strtoupper($kons),
                        'no_mesin' => $mc,
                        'no_beam' => $beam,
                        'oka' => $oka,
                        'ukuran_ori' => $ori,
                        'ukuran_bs' => $bs,
                        'ukuran_bp' => $bp,
                        'tanggal' => $tgl,
                        'operator' => $opt,
                        'bp_can_join' => $ori<50 ? 'true':'false',
                        'dep' => 'Samatex',
                        'loc_now' => 'Samatex',
                        'yg_input' => 0,
                        'kode_upload' => 'tes'
                    ];
                    $this->data_model->saved('data_ig', $dtlist);
                    $this->data_model->updatedata('idcode',1,'data_ig_code',['numskr'=>$newNumber]);
                } else {
                    $newNumber2 = $newNumber + 1;
                    $setKode = $tableKode['alpabet']."".$newNumber2;
                    //$trueKode = "S1".$pemisah."".$ex[1];
                    $dtlist = [
                        'kode_roll' => strtoupper($setKode),
                        'konstruksi' => strtoupper($kons),
                        'no_mesin' => $mc,
                        'no_beam' => $beam,
                        'oka' => $oka,
                        'ukuran_ori' => $ori,
                        'ukuran_bs' => $bs,
                        'ukuran_bp' => $bp,
                        'tanggal' => $tgl,
                        'operator' => $opt,
                        'bp_can_join' => $ori<50 ? 'true':'false',
                        'dep' => 'Samatex',
                        'loc_now' => 'Samatex',
                        'yg_input' => 0,
                        'kode_upload' => 'tes'
                    ];
                    $this->data_model->saved('data_ig', $dtlist);
                    $this->data_model->updatedata('idcode',1,'data_ig_code',['numskr'=>$newNumber2]);
                }
                //cek produksi per sm harian
                $cek1 = $this->data_model->get_byid('data_produksi', ['kode_konstruksi'=>$kons,'tgl'=>$tgl,'dep'=>'Samatex']);
                if($cek1->num_rows() == 1){
                        $id_produksi = $cek1->row("id_produksi");
                        $new_ig = floatval($cek1->row("prod_ig")) + floatval($ori);
                        $new_bs = floatval($cek1->row("prod_bs1")) + floatval($bs);
                        $new_bp = floatval($cek1->row("prod_bp1")) + floatval($bp);
                        $dtlist1 = [
                            'prod_ig' => round($new_ig,2),
                            'prod_bs1' => round($new_bs,2),
                            'prod_bp1' => round($new_bp,2)
                        ];
                        $this->data_model->updatedata('id_produksi',$id_produksi,'data_produksi',$dtlist1);
                } else {
                    $dtlist1 = [
                        'kode_konstruksi' => $kons,
                        'tgl' => $tgl,
                        'dep' => 'Samatex',
                        'prod_ig' => $ori,
                        'prod_fg' => 0,
                        'prod_if' => 0,
                        'prod_ff' => 0,
                        'prod_bs1' => $bs,
                        'prod_bp1' => $bp,
                        'prod_bs2' => 0,
                        'prod_bp2' => 0,
                        'crt' => 0
                    ];
                    $this->data_model->saved('data_produksi', $dtlist1);
                }
                //end cek 1
                //cek produksi harian total
                $cek2 = $this->data_model->get_byid('data_produksi_harian', ['tgl'=>$tgl,'dep'=>'Samatex']);
                if($cek2->num_rows() == 1){
                        $id_prod_hr = $cek2->row("id_prod_hr");
                        $new_ig = floatval($cek2->row("prod_ig")) + floatval($ori);
                        $new_bs = floatval($cek2->row("prod_bs1")) + floatval($bs);
                        $new_bp = floatval($cek2->row("prod_bp1")) + floatval($bp);
                        $dtlist1 = [
                            'prod_ig' => round($new_ig,2),
                            'prod_bs1' => round($new_bs,2),
                            'prod_bp1' => round($new_bp,2)
                        ];
                        $this->data_model->updatedata('id_prod_hr',$id_prod_hr,'data_produksi_harian',$dtlist1);
                } else {
                    $dtlist1 = [
                        'tgl' => $tgl,
                        'dep' => 'Samatex',
                        'prod_ig' => $ori,
                        'prod_fg' => 0,
                        'prod_if' => 0,
                        'prod_ff' => 0,
                        'prod_bs1' => $bs,
                        'prod_bp1' => $bp,
                        'prod_bs2' => 0,
                        'prod_bp2' => 0,
                        'crt' => 0
                    ];
                    $this->data_model->saved('data_produksi_harian', $dtlist1);
                }
                //end cek 2
                //cek produksi opt
                $cek3 = $this->data_model->get_byid('data_produksi_opt', ['username_opt'=>$opt,'konstruksi'=>$kons,'tgl'=>$tgl,'proses'=>'insgrey']);
                if($cek3->num_rows() == 1){
                    $id_propt = $cek3->row("id_propt");
                    $new_ori = floatval($cek3->row("ukuran")) + floatval($ori);
                    $new_bs = floatval($cek3->row("bs")) + floatval($bs);
                    $new_bp = floatval($cek3->row("bp")) + floatval($bp);
                    $dtlist2 = [
                        'ukuran' => round($new_ori,2),
                        'bs' => round($new_bs,2),
                        'bp' => round($new_bp,2)
                    ];
                    $this->data_model->updatedata('id_propt',$id_propt,'data_produksi_opt',$dtlist2);
                } else {
                    $dtlist2 = [
                        'username_opt' => $opt,
                        'konstruksi' => $kons,
                        'tgl' => $tgl,
                        'proses' => 'insgrey',
                        'ukuran' => $ori, 
                        'bs' => $bs,
                        'bp' => $bp,
                        'crt' => 0,
                        'shift' => $shift
                    ];
                    $this->data_model->saved('data_produksi_opt', $dtlist2);
                }
                //end cek 3
                //cek data stok ke 4
                $cekStok = $this->data_model->get_byid('data_stok', ['dep'=>'newSamatex','kode_konstruksi'=>$kons]);
                if($cekStok->num_rows() == 0){
                    $listStok = [
                        'dep' => 'newSamatex',
                        'kode_konstruksi' => $kons,
                        'prod_ig' => $ori,
                        'prod_fg' => 0,
                        'prod_if' => 0,
                        'prod_ff' => 0,
                        'prod_bs1' => $bs,
                        'prod_bp1' => $bp,
                        'prod_bs2' => 0,
                        'prod_bp2' => 0,
                        'crt' => 0
                    ];
                    $this->data_model->saved('data_stok', $listStok);
                } else {
                    $idstok = $cekStok->row("idstok");
                    $newig = floatval($cekStok->row("prod_ig")) + floatval($ori);
                    $newbs = floatval($cekStok->row("prod_bs1")) + floatval($bs);
                    $newbp = floatval($cekStok->row("prod_bp1")) + floatval($bp);
                    $listStok = [
                        'prod_ig' => round($newig,2),
                        'prod_bs1' => round($newbs,2),
                        'prod_bp1' => round($newbp,2)
                    ];
                    $this->data_model->updatedata('idstok',$idstok,'data_stok',$listStok);
                }
                //end cek 4
                echo json_encode(array("statusCode"=>200, "psn"=>$setKode));
            } else {
                echo json_encode(array("statusCode"=>404, "psn"=>"Konstruksi tidak ditemukan"));
            }
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"Username operator tidak ditemukan"));
        }
        
       
  } //end proses insgrey saved

  function prosesInsFinish(){
    $jamSaatIni = date('H');
    if(intval($jamSaatIni)>=6 AND intval($jamSaatIni)<14){
        $shift = "1";
    }
    if(intval($jamSaatIni)>=14 AND intval($jamSaatIni)<22){
        $shift = "2";
    }
    if(intval($jamSaatIni)>=22 AND intval($jamSaatIni)<24){
        $shift = "3";
    }
    if(intval($jamSaatIni)>=0 AND intval($jamSaatIni)<6){
        $shift = "31";
    }
    $koderoll = $this->input->post('koderoll');
    $ukuran = $this->input->post('ori');
    $bs = $this->input->post('bs');
    $bp = $this->input->post('bp');
    $crt = $this->input->post('crt');
    $tgl = $this->input->post('tgl');
    $masket = $this->input->post('masket');
    $operator = $this->input->post('username');
    $ukrSebelum = $this->input->post('ukrSebelum');
    $kecilkanOperator = strtolower($operator);
    $cekusername = $this->data_model->get_byid('a_operator', ['username'=>$kecilkanOperator]);
    if($cekusername->num_rows() == 1){
    $cekKodeRoll = $this->data_model->get_byid('data_ig', ['kode_roll'=>$koderoll]);
    if($cekKodeRoll->num_rows() == 1){
        $kons = $cekKodeRoll->row("konstruksi");
        $kons2 = $this->getKonstruksiFinish($kons);
        $ukuran_sebelum = $cekKodeRoll->row("ukuran_ori");
        $cekKodeRollFinish = $this->data_model->get_byid('data_if', ['kode_roll'=>$koderoll]);
        if($cekKodeRollFinish->num_rows() == 0){
            $dataBener=0; $totalOri=0; 
            $jadikode = array();
            $alphabet = ['0'=>'','1'=>'A','2'=>'B','3'=>'C','4'=>'D','5'=>'E','6'=>'F','7'=>'G','8'=>'H','9'=>'I','10'=>'J'];
            for ($i=0; $i <count($ukuran) ; $i++) { 
                if($ukuran[$i]!="" AND $ukuran[$i]>0){
                    $ori2 = floatval($ukuran[$i]) * 0.9144;
                    $ori = round($ori2,1);

                    $dataBener+=1;
                    $totalOri+=floatval($ukuran[$i]);
                    $kodeRollInput = $koderoll."".$alphabet[$i];
                    $jadikode[]= $kodeRollInput;

                    if($ori>=50){ $_grade = "ori"; } else {
                        if($ori>=21 AND $ori<50){
                            $_grade = "BP";
                        }
                        if($ori>=11 AND $ori<21){
                            $_grade = "Grade B";
                            $this->data_model->saved('ab_non_ori',[
                                    'kode_roll'=>strtoupper($kodeRollInput),
                                    'konstruksi'=>strtoupper($kons),
                                    'ukuran'=>$ukuran[$i],
                                    'jns_kain'=>'bcputihan',
                                    'operator'=>$kecilkanOperator,
                                    'posisi'=>'Pusatex',
                                    'tgl_input'=>date('Y-m-d'),
                                    'tms'=>date('Y-m-d H:i:s')
                            ]);
                        }
                        if($ori>=4 AND $ori<11){
                            $_grade = "Grade C";
                            $this->data_model->saved('ab_non_ori',[
                                    'kode_roll'=>strtoupper($kodeRollInput),
                                    'konstruksi'=>strtoupper($kons),
                                    'ukuran'=>$ukuran[$i],
                                    'jns_kain'=>'bcputihan',
                                    'operator'=>$kecilkanOperator,
                                    'posisi'=>'Pusatex',
                                    'tgl_input'=>date('Y-m-d'),
                                    'tms'=>date('Y-m-d H:i:s')
                            ]);
                        }
                        if($ori < 4){
                            $_grade = "Aval";
                            $this->data_model->saved('ab_non_ori',[
                                    'kode_roll'=>strtoupper($kodeRollInput),
                                    'konstruksi'=>strtoupper($kons),
                                    'ukuran'=>$ukuran[$i],
                                    'jns_kain'=>'avalputihan',
                                    'operator'=>$kecilkanOperator,
                                    'posisi'=>'Pusatex',
                                    'tgl_input'=>date('Y-m-d'),
                                    'tms'=>date('Y-m-d H:i:s')
                            ]);
                        }
                    }
                    // $dataBener+=1;
                    // $totalOri+=floatval($ukuran[$i]);
                    // $kodeRollInput = $koderoll."".$alphabet[$i];
                    // $jadikode[]= $kodeRollInput;
                    $dtlist = [
                        'kode_roll' => strtoupper($kodeRollInput),
                        'tgl_potong' => $tgl,
                        'ukuran_sebelum' => $ukrSebelum,
                        'ukuran_ori' => $ukuran[$i],
                        'ukuran_bs' => 0,
                        'ukuran_crt' => 0,
                        'ukuran_bp' => 0,
                        'operator' => $kecilkanOperator,
                        'ket' => 'new',
                        'asal' => '0',
                        'bp_canjoin' => $_grade,
                        'konstruksi' => strtoupper($kons),
                        'shift_op' => $shift,
                        'jam_input' => date('Y-m-d H:i:s')
                    ];
                    $this->data_model->saved('data_if',$dtlist);
                    $this->data_model->updatedata('kode_roll',$kodeRollInput,'kiriman_pusatex',['stfol'=>'insfinish']);
                    $this->data_model->updatedata('kode_roll',$kodeRollInput,'data_if_before',['status'=>'insfinish']);
                } 
            } //end for 
            for ($ae=0; $ae <count($bs) ; $ae++){
                if(intval($bs[$ae]) > 0){
                    if(intval($bs[$ae]) < 4){
                        $this->data_model->saved('bs_finish_samatex', [
                            'kode_roll'         => $koderoll,
                            'konstruksi'        => 'AVAL PUTIHAN',
                            'konstruksi_real'   => $kons,
                            'ukuran_bs'         => $bs[$ae],
                            'berat_bs'          => $bp[$ae],
                            'tgl'               => $tgl,
                            'shift_op'          => $shift,
                            'keterangan'        => $masket[$ae],
                            'operator'          => $kecilkanOperator,
                            'dep'               => 'Samatex',
                            'lokasi_now'        => 'Samatex'
                        ]);
                    } else {
                        $this->data_model->saved('data_ig_bs', [
                            'kode_roll' => $koderoll,
                            'ukuran_bs' => $bs[$ae],
                            'tgl' => $tgl,
                            'shift_op' => $shift,
                            'keterangan' => 0,
                            'operator' => $kecilkanOperator,
                            'dep' => 'Samatex',
                            'lokasi_now' => 'Samatex'
                        ]);
                        $this->data_model->saved('bs_finish_samatex', [
                            'kode_roll'         => $koderoll,
                            'konstruksi'        => $kons2,
                            'konstruksi_real'   => $kons,
                            'ukuran_bs'         => $bs[$ae],
                            'berat_bs'          => $bp[$ae],
                            'tgl'               => $tgl,
                            'shift_op'          => $shift,
                            'keterangan'        => $masket[$ae],
                            'operator'          => $kecilkanOperator,
                            'dep'               => 'Samatex',
                            'lokasi_now'        => 'Samatex'
                        ]);
                    }
                }
            }
            //end cek 4
            $imJadi = implode('-', $jadikode);
            $text = "Kode ".$imJadi."";
            $this->data_model->updatedata('kode_roll',$koderoll,'data_ig',['loc_now'=>'iff']);
            echo json_encode(array("statusCode"=>200, "psn"=>$text));
        } else {
            $text = "Kode ".$koderoll." sudah di proses Finish.";
            echo json_encode(array("statusCode"=>404, "psn"=>$text));
        }
    } else {
        $text = "Kode ".$koderoll." tidak ditemukan.";
        echo json_encode(array("statusCode"=>404, "psn"=>$text));
    }
    //$text = implode('-', $ukuran);
    } else {
        $text = "Username tidak ditemukan!!";
        echo json_encode(array("statusCode"=>404, "psn"=>$text));
    }
  } //end proses insfinish saved

  function laporaninsgrey(){
        $this->load->view('users/report_insgrey');
  } //end report insgrey-

  function laporaninsfinish(){
        $this->load->view('users/report_insfinish');
  } //end report insfinish-

  function laporanfolgrey(){
        $this->load->view('users/report_folgrey');
  } //end report laporanfolgrey-

  function laporanfolfinish(){
        $this->load->view('users/report_folfinish');
  } //end report laporanfolfinish-
  function cariInsgrey345(){
        $kode = $this->input->post('kode');
        $kodeuser = $this->input->post('kodeuser');
        //echo $kode;
        $cekkode = $this->data_model->get_byid('data_ig', ['kode_roll'=>$kode]);
        if($cekkode->num_rows() == 1){
            $cekIF = $this->data_model->get_byid('data_if', ['kode_roll'=>$kode]);
            if($cekIF->num_rows() == 0){
                $cekIfBefore = $this->data_model->get_byid('data_if_before', ['kode_roll'=>$kode]);
                if($cekIfBefore->num_rows() == 0){
                    $_kodeRoll = strtoupper($kode); // $kode;
                    $_ukuranRoll = $cekkode->row("ukuran_ori");
                    $_kons = $cekkode->row("konstruksi");
                    $this->data_model->saved('data_if_before', [
                        'kode_roll' => $_kodeRoll,
                        'ukuran' => $_ukuranRoll,
                        'konstruksi' => $_kons,
                        'users' => $kodeuser,
                        'tgl' => date('Y-m-d'),
                        'tgl_tms' => date('Y-m-d H:i:s'),
                        'status' => 'ready'
                    ]);
                    $this->db->query("DELETE FROM data_igtujuan WHERE kode_roll='$_kodeRoll'");
                    echo json_encode(array("statusCode"=>200, "psn"=>"Kode $kode diterima"));
                } else {
                    echo json_encode(array("statusCode"=>404, "psn"=>"Kode sudah pernah di terima"));
                }
            } else {
                echo json_encode(array("statusCode"=>404, "psn"=>"Kode sudah di proses Finish"));
            }
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"Kode tidak ditemukan"));
        }
  }

  function cariInsgrey(){
        $kode = $this->input->post('kode');
        $cekkode = $this->data_model->get_byid('data_if_before', ['kode_roll'=>$kode,'status'=>'ready']);
        $cekkode2 = $this->data_model->get_byid('data_ig', ['kode_roll'=>$kode]);
        if($cekkode->num_rows() == 1){
            // $tglTerima = $cekkode->row("diterima_pusatex");
            // $stfol = $cekkode->row("stfol");
            // if($tglTerima == "null"){
            //     $text = "<span style='color:red;'>".$kode." Belum di validasi berada di Pusatex</span>";
            //     echo json_encode(array("statusCode"=>200, "psn"=>$text));
            // } else {
                $cek_finish = $this->data_model->get_byid('data_if', ['kode_roll'=>$kode]);
                if($cek_finish->num_rows() == 0){
                    $kons = $cekkode2->row("konstruksi");
                    $mc = $cekkode2->row("no_mesin");
                    $opt =strtoupper($cekkode2->row("operator"));
                    $ori = $cekkode2->row("ukuran_ori");
                    
                    $text = "Data Inspect Grey Kode <strong>".$kode."</strong><br>- Konstruksi &nbsp;<strong>".$kons."</strong><br>- Nomor Mesin &nbsp;<strong>".$mc."</strong><br>- Ukuran &nbsp;<strong>".$ori."</strong> Meter<br>- Operator Inspect Grey &nbsp;<strong>$opt</strong><div style='width:100%;display:flex;justify-content:space-between;'><textarea style='opacity:0;' id='teksToCopy'>Data Inspect Grey Kode *".$kode."*\r\n - Konstruksi *".$kons."*\r\n - Nomor Mesin *".$mc."*\r\n- Ukuran *".$ori."* Meter \r\n- Operator Inspect Grey *$opt*</textarea><button onclick='onsalin()' style='padding:10px;font-size:12px;outline:none;border-radius:5px;background:#f3f3f3;border:1px solid #ccc;cursor:pointer;'>Copy</button></div>
                    
                    ";
                    echo json_encode(array("statusCode"=>200, "psn"=>$text, "ukrsblm"=>$ori));
                } else {
                    $text = "<span style='color:red;'>".$kode." telah di proses inspect Finish</span>";
                    echo json_encode(array("statusCode"=>200, "psn"=>$text));
                }
            //}
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"Kode tidak ditemukan"));
        }
  } //end

  function cariInsgrey2(){
        $kode = $this->input->post('kode');
        $jnsFold = $this->input->post('jnsFold');
        if($jnsFold == "Grey"){
            $cekData = $this->data_model->get_byid('data_igtujuan', ['kode_roll'=>$kode]);
            $cekkode = $this->data_model->get_byid('kiriman_pusatex', ['kode_roll'=>$kode]);
            $cekkode2 = $this->data_model->get_byid('data_if', ['kode_roll'=>$kode]);
            $cekkode3 = $this->data_model->get_byid('data_ig', ['kode_roll'=>$kode]);
            if($cekData->num_rows() == 1){
                $proses = $cekData->row("tujuan_proses");
                if($proses == "Grey"){
                    $kons = $cekkode3->row("konstruksi");
                    $mc = $cekkode3->row("no_mesin");
                    $ori = $cekkode3->row("ukuran_ori");
                    $cekFolding = $this->data_model->get_byid('data_fol', ['kode_roll'=>$kode]);
                    if($cekFolding->num_rows() == 1){
                        $text = "<span style='color:red;'>".$kode." Sudah di folding</span>";
                        echo json_encode(array("statusCode"=>200, "psn"=>$text));
                    } else {
                        if($cekkode2->num_rows() == 0){
                            $text = "Data Inspect Grey<br>- Konstruksi &nbsp;<strong>".$kons."</strong><br>- Nomor Mesin &nbsp;<strong>".$mc."</strong><br>- Ukuran &nbsp;<strong>".$ori."</strong> Meter";
                            echo json_encode(array("statusCode"=>200, "psn"=>$text));
                        } else {
                            $text = "<span style='color:red;'>".$kode." Sudah di Inspect Finish</span>";
                            echo json_encode(array("statusCode"=>200, "psn"=>$text));
                        }
                        
                    }
                } else {
                    $text = "<span style='color:red;'>".$kode." Tujuannya adalah di Finish</span>";
                    echo json_encode(array("statusCode"=>200, "psn"=>$text));
                }
            } else {
            
            if($cekkode->num_rows() == 1){
                $kons = $cekkode->row("konstruksi");
                $mc = $cekkode->row("mc");
                $ori = $cekkode->row("ukuran");
                $terimapst = $cekkode->row("diterima_pusatex");
                $stfol = $cekkode->row("stfol");
                if($terimapst != "null"){
                    if($stfol=="fol"){
                        $text = "<span style='color:red;'>".$kode." Sudah di folding</span>";
                        echo json_encode(array("statusCode"=>200, "psn"=>$text));
                    } else {
                        $cekFolding = $this->data_model->get_byid('data_fol', ['kode_roll'=>$kode]);
                        if($cekFolding->num_rows() == 1){
                            $text = "<span style='color:red;'>".$kode." Sudah di folding</span>";
                            echo json_encode(array("statusCode"=>200, "psn"=>$text));
                        } else {
                            if($cekkode2->num_rows() == 0){
                                $text = "Data Inspect Grey<br>- Konstruksi &nbsp;<strong>".$kons."</strong><br>- Nomor Mesin &nbsp;<strong>".$mc."</strong><br>- Ukuran &nbsp;<strong>".$ori."</strong> Meter";
                                echo json_encode(array("statusCode"=>200, "psn"=>$text));
                            } else {
                                $text = "<span style='color:red;'>".$kode." Sudah di Inspect Finish</span>";
                                echo json_encode(array("statusCode"=>200, "psn"=>$text));
                            }
                            
                        }
                    }
                } else {
                    $text = "<span style='color:red;'>".$kode." belum di validasi berada di Pusatex</span>";
                    echo json_encode(array("statusCode"=>200, "psn"=>$text));
                } //
                
            } else {
                if($cekkode3->num_rows() == 1){
                    $kons = $cekkode3->row("konstruksi");
                    $mc = $cekkode3->row("no_mesin");
                    $ori = $cekkode3->row("ukuran_ori");
                    $cekFolding = $this->data_model->get_byid('data_fol', ['kode_roll'=>$kode]);
                    if($cekFolding->num_rows() == 1){
                            $text = "<span style='color:red;'>".$kode." Sudah di folding</span>";
                            echo json_encode(array("statusCode"=>200, "psn"=>$text));
                    } else {
                        if($cekkode2->num_rows() == 0){
                            $text = "Data Inspect Grey<br>- Konstruksi &nbsp;<strong>".$kons."</strong><br>- Nomor Mesin &nbsp;<strong>".$mc."</strong><br>- Ukuran &nbsp;<strong>".$ori."</strong> Meter";
                            echo json_encode(array("statusCode"=>200, "psn"=>$text));
                        } else {
                            $text = "<span style='color:red;'>".$kode." Sudah di Inspect Finish</span>";
                            echo json_encode(array("statusCode"=>200, "psn"=>$text));
                        }
                            
                    }
                } else {
                echo json_encode(array("statusCode"=>404, "psn"=>"Kode tidak ditemukan"));
                }
            }
            }
            //end of grey
        } else {
            if($jnsFold == "Finish"){
                $cekkode = $this->data_model->get_byid('kiriman_pusatex', ['kode_roll'=>$kode]);
                if($cekkode->num_rows() == 1){
                    $terima = $cekkode->row("diterima_pusatex");
                    if($terima == "null"){
                        $text = "<span style='color:red;'>".$kode." Berlum di validasi Pusatex</span>";
                        echo json_encode(array("statusCode"=>200, "psn"=>$text));
                    } else {
                        $cekFinish = $this->data_model->get_byid('data_if', ['kode_roll'=>$kode]);
                        if($cekFinish->num_rows() == 1){
                            $ukuran = $cekFinish->row("ukuran_ori");
                            $konstruksi = $cekFinish->row("konstruksi");
                            $ukuran_yard = floatval($ukuran) / 0.9144;
                            $ukuran_yard = round($ukuran_yard,1);
                            $cekFolding = $this->data_model->get_byid('data_fol', ['kode_roll'=>$kode]);
                            if($cekFolding->num_rows() == 1){
                                $text = "<span style='color:red;'>".$kode." Sudah di folding</span>";
                                echo json_encode(array("statusCode"=>200, "psn"=>$text));
                            } else {
                                $text = "Data Inspect Finish<br>- Konstruksi &nbsp;<strong>".$konstruksi."</strong><br>- Ukuran &nbsp;<strong>".$ukuran_yard."</strong> Yard";
                                echo json_encode(array("statusCode"=>200, "psn"=>$text));
                            }
                        } else {
                            $text = "<span style='color:red;'>".$kode." Belum di inspect Finish</span>";
                            echo json_encode(array("statusCode"=>200, "psn"=>$text));
                        }
                    }
                } else {
                    $cekkode = $this->data_model->get_byid('data_if', ['kode_roll'=>$kode]);
                    if($cekkode->num_rows() == 1){
                        
                            
                                $ukuran = $cekkode->row("ukuran_ori");
                                $konstruksi = $cekkode->row("konstruksi");
                                $ukuran_yard = floatval($ukuran) / 0.9144;
                                $ukuran_yard = round($ukuran_yard,1);
                                $cekFolding = $this->data_model->get_byid('data_fol', ['kode_roll'=>$kode]);
                                if($cekFolding->num_rows() == 1){
                                    $text = "<span style='color:red;'>".$kode." Sudah di folding</span>";
                                    echo json_encode(array("statusCode"=>200, "psn"=>$text));
                                } else {
                                    $text = "Data Inspect Finish<br>- Konstruksi &nbsp;<strong>".$konstruksi."</strong><br>- Ukuran &nbsp;<strong>".$ukuran_yard."</strong> Yard";
                                    echo json_encode(array("statusCode"=>200, "psn"=>$text));
                                }
                            
                        
                    } else {
                    echo json_encode(array("statusCode"=>404, "psn"=>"Kode tidak ditemukan")); }
                }
            } else {
                echo json_encode(array("statusCode"=>404, "psn"=>"Kode tidak ditemukan"));
            }
        }
  } //end
  function loadpaketpst(){
    $bln = ['00'=>'undf', '01'=>'Jan', '02'=>'Feb', '03'=>'Mar', '04'=>'Apr', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Ags', '09'=>'Sep', '10'=>'Okt', '11'=>'Nov', '12'=>'Des'];
    $yr = date('Y');
    $username =strtolower($this->input->post('username'));
    $cekusername = $this->data_model->get_byid('a_operator', ['username'=>$username, 'produksi'=>'kirimpst']);
    if($cekusername->num_rows() == 1){
        $query = $this->data_model->get_byid('new_tb_packinglist', ['lokasi_now'=>'Samatex','siap_jual'=>'n','ygbuat'=>$username]);
        if($query->num_rows() > 0){
            echo '<tr>
                    <td>Kode Pkg</td>
                    <td>Konstruksi</td>
                    <td>Jml Roll</td>
                    <td>Total Panjang</td>
                    <td>Tanggal</td>
                  </tr>'; 
            foreach($query->result() as $val):
                echo "<tr>";
                if($val->kepada=="NULL"){
                echo "<td style='font-weight:bold;color:#4287f5;'><a href='".base_url('users/createkirimpst/'.$val->kd)."'>".$val->kd."</a></td>";
                } else { echo "<td>".$val->kd."</td>"; }
                echo "<td>".$val->kode_konstruksi."</td>";
                echo "<td>".$val->jumlah_roll."</td>";
                if(fmod($val->ttl_panjang, 1) !== 0.00){
                    $pjg = number_format($val->ttl_panjang,2,',','.');
                } else {
                    $pjg = number_format($val->ttl_panjang,0,',','.');
                }
                echo "<td>".$pjg."</td>";
                $ex = explode('-', $val->tanggal_dibuat);
                if($ex[0]==$yr){
                    echo "<td>".$ex[2]." ".$bln[$ex[1]]."</td>";
                } else {
                    echo "<td>".$ex[2]." ".$bln[$ex[1]]." ".$ex[0]."</td>";
                }
                
                echo "</tr>";
            endforeach;
        } else {
            echo '<tr>
                    <td>Kode Pkg</td>
                    <td>Konstruksi</td>
                    <td>Jml Roll</td>
                    <td>Total Panjang</td>
                    <td>Tanggal</td>
                  </tr>'; 
            echo "<tr><td colspan='5'><span style='color:red;'>Anda belum membuat paket</span></td></tr>";
        }
    } else {
        echo "<tr><td colspan='5'><span style='color:red;'>Tidak berhasil mengambil data packing penjualan. Anda perlu login ulang</span></td></tr>";
    }
  } //end
  function loadDataStokGreyKiriman(){
    $ar = array(
        '00' => 'NaN', '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
       );
    $query = $this->data_model->get_byid('new_tb_packinglist', ['kepada'=>'Samatex']);
    if($query->num_rows() > 0){
    echo "<tr><td><strong>No.PKG</strong></td><td><strong>Tanggal</strong></td><td><strong>Dari</strong></td><td><strong>Panjang</strong></td></tr>";
    foreach($query->result() as $val){
        //if($val->prod_ig > 0){
            echo "<tr>";
            echo "<td><a href='".base_url('users/createkirimpst3/'.$val->kd)."'><strong>".$val->kd."</strong></a></td>";
            $ex=explode('-',$val->tanggal_dibuat);
            if($ex[0]==date('Y')){ echo "<td>".$ex[2]." ".$ar[$ex[1]]."</td>"; } else {
            echo "<td>".$ex[2]."/".$ex[1]."/".$ex[0]."</td>";}
            echo "<td>".$val->lokasi_now."</td>";
            if(fmod($val->ttl_panjang, 1) !== 0.00){
                $pjg = number_format($val->ttl_panjang,2,',','.');
            } else {
                $pjg = number_format($val->ttl_panjang,0,',','.');
            }
            echo "<td>".$pjg."</td>";
            echo "</tr>";
        //}
    }
    } else {
        echo "<tr><td><strong>Tidak ada kiriman</strong></td></tr>";
    }
  } //end

  function loadDataStokGrey(){
    $username =strtolower($this->input->post('username'));
    $cekusername = $this->data_model->get_byid('a_operator', ['username'=>$username, 'produksi'=>'kirimpst']);
    if($cekusername->num_rows() == 1){
        $query = $this->data_model->get_byid('data_stok', ['dep'=>'newSamatex']);
        echo "<tr><td><strong>Konstruksi</strong></td><td><strong>Stok</strong></td></tr>";
        foreach($query->result() as $val){
            if($val->prod_ig > 0){
                echo "<tr>";
                echo "<td>".$val->kode_konstruksi."</td>";
                if(fmod($val->prod_ig, 1) !== 0.00){
                    $pjg = number_format($val->prod_ig,2,',','.');
                } else {
                    $pjg = number_format($val->prod_ig,0,',','.');
                }
                echo "<td>".$pjg."</td>";
                echo "</tr>";
            }
        }
    } else {
        echo "<tr><td colspan='2'><span style='color:red;'>Tidak berhasil mengambil data stok. Anda perlu login ulang</span></td></tr>";
    }
  } //end
  
  function inputRollLama(){
        $koderoll = $this->input->post('newKode');
        $ukuran = $this->input->post('newukuran');
        $pkg = $this->input->post('id_pkg');
        if(floatval($ukuran)>0 AND $pkg!=""){
            $thispkg = $this->data_model->get_byid('new_tb_packinglist',['kd'=>$pkg])->row_array();
            $kons = $thispkg['kode_konstruksi'];
            $siapjual = $thispkg['siap_jual'];
            $roll = $thispkg['jumlah_roll'];
            $panjang = $thispkg['ttl_panjang'];
            $satuan = $thispkg['jns_fold']=="Grey" ? "Meter":"Yard";
            if($koderoll==""){
                $dtlis = [
                    'kd' => $pkg,
                    'konstruksi' => $kons,
                    'siap_jual' => $siapjual,
                    'kode' => '',
                    'ukuran' => $ukuran,
                    'status' => 'null',
                    'satuan' => $satuan
                ];
                $this->data_model->saved('new_tb_isi', $dtlis);
                $newRoll = intval($roll) + 1;
                $newpjng = floatval($panjang) + floatval($ukuran);
                $dtlispkg = [
                    'jumlah_roll' => $newRoll,
                    'ttl_panjang' => round($newpjng,2)
                ];
                $this->data_model->updatedata('kd',$pkg,'new_tb_packinglist',$dtlispkg);
                echo json_encode(array("statusCode"=>200, "psn"=>"Added Roll"));
            } else {
                $carikode = $this->data_model->get_byid('new_tb_isi', ['kode'=>$koderoll])->num_rows();
                if($carikode == 0){
                    $dtlis = [
                        'kd' => $pkg,
                        'konstruksi' => $kons,
                        'siap_jual' => $siapjual,
                        'kode' => $koderoll,
                        'ukuran' => $ukuran,
                        'status' => 'null',
                        'satuan' => $satuan
                    ];
                    $this->data_model->saved('new_tb_isi', $dtlis);
                    $newRoll = intval($roll) + 1;
                    $newpjng = floatval($panjang) + floatval($ukuran);
                    $dtlispkg = [
                        'jumlah_roll' => $newRoll,
                        'ttl_panjang' => round($newpjng,2)
                    ];
                    $this->data_model->updatedata('kd',$pkg,'new_tb_packinglist',$dtlispkg);
                    echo json_encode(array("statusCode"=>200, "psn"=>"Added Roll"));
                } else {
                    echo json_encode(array("statusCode"=>404, "psn"=>"Kode Roll sudah di packinglist"));
                }
            }
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"Isi data dengan benar!!"));
        }
  } //end

  function getCodeFromPst(){
        $koderoll = $this->input->post('kode');
        $tgl = $this->input->post('tgl');
        $user = $this->input->post('username');
        $kd1 = $this->data_model->get_byid('data_ig', ['kode_roll'=>$koderoll]);
        $kd = $kd1->row_array();
        $kons = $kd['konstruksi'];
        $ukuran = $kd['ukuran_ori'];
        $mc = $kd['no_mesin'];
        $locAwal = $kd['dep'];
        $locNow = $kd['loc_now'];
        if($locNow == "Samatex"){
            echo "Barang Sudah di Samatex";
        } else {
        if($locAwal=="RJS"){
            $dep = "rjsToPusatex";
        } else {
            $dep = "stxToPusatex";
        }
        $this->data_model->updatedata('kode',$koderoll,'new_tb_isi',['status'=>'fixsend']);
        $this->data_model->updatedata('kode_roll',$koderoll,'data_ig',['loc_now'=>'Samatex']);
        $cekstok = $this->data_model->get_byid('data_stok', ['dep'=>'newSamatex','kode_konstruksi'=>$kons]);
        if($cekstok->num_rows() == 1){
        $idstok = $cekstok->row("idstok");
        $jmlStok = floatval($cekstok->row("prod_ig")) + floatval($ukuran);
        $this->data_model->updatedata('idstok',$idstok,'data_stok',['prod_ig'=>round($jmlStok,2)]);
        } else {
            $dtlis = [
                'dep' => 'newSamatex',
                'kode_konstruksi' => $kons,
                'prod_ig' => $ukuran,
                'prod_fg' => 0,
                'prod_if' => 0,
                'prod_ff' => 0,
                'prod_bs1' => 0,
                'prod_bp1' => 0,
                'prod_bs2' => 0,
                'prod_bp2' => 0,
                'crt' => 0
            ];
            $this->data_model->saved('data_stok', $dtlis);
        }

        $cekstok = $this->data_model->get_byid('data_stok', ['dep'=>$dep,'kode_konstruksi'=>$kons]);
        $idstok = $cekstok->row("idstok");
        $jmlStok = floatval($cekstok->row("prod_ig")) - floatval($ukuran);
        $this->data_model->updatedata('idstok',$idstok,'data_stok',['prod_ig'=>round($jmlStok,2)]);
        $dtlis = [
            'kode_roll' => $koderoll,
            'mc' => $mc,
            'ukuran' => $ukuran,
            'konstruksi' => $kons,
            'tanggal' => $tgl,
            'operator' => strtolower($user)
        ];
        $this->data_model->saved('kiriman_pusatex', $dtlis);
        echo "berhasil";
        }
  }//end

  function getCodeFromPst2(){
        $kode = $this->input->post('kode');
        $ukr = $this->input->post('ukr');
        $mc = $this->input->post('mc');
        $kons = $this->input->post('kons');
        $tgl = $this->input->post('tgl');
        $opt = $this->input->post('username');

        if($kode!="" AND $ukr!="" AND $mc!="" AND $kons!=""){
            $cek_kons = $this->data_model->get_byid('tb_konstruksi', ['kode_konstruksi'=>$kons]);
            if($cek_kons->num_rows() == 1){
            $cekkode = $this->data_model->get_byid('data_ig', ['kode_roll'=>$kode]);
            if($cekkode->num_rows() == 0){
                $dtlist = [
                    'kode_roll' => strtoupper($kode),
                    'konstruksi' => strtoupper($kons),
                    'no_mesin' => $mc,
                    'no_beam' => '',
                    'oka' => '',
                    'ukuran_ori' => $ukr,
                    'ukuran_bs' => 0,
                    'ukuran_bp' => 0,
                    'tanggal' => $tgl,
                    'operator' => $opt,
                    'bp_can_join' => $ukr<50 ? 'true':'false',
                    'dep' => 'Samatex',
                    'loc_now' => 'Samatex',
                    'yg_input' => 0,
                    'kode_upload' => 'tes'
                ];
                $this->data_model->saved('data_ig', $dtlist);
                $dtlis22 = [
                    'kode_roll' => $kode,
                    'mc' => $mc,
                    'ukuran' => $ukr,
                    'konstruksi' => $kons,
                    'tanggal' => $tgl,
                    'operator' => $opt
                ];
                $this->data_model->saved('kiriman_pusatex', $dtlis22);
                $cekStok = $this->data_model->get_byid('data_stok', ['dep'=>'newSamatex','kode_konstruksi'=>$kons]);
                if($cekStok->num_rows() == 0){
                    $listStok = [
                        'dep' => 'newSamatex',
                        'kode_konstruksi' => $kons,
                        'prod_ig' => $ukr,
                        'prod_fg' => 0,
                        'prod_if' => 0,
                        'prod_ff' => 0,
                        'prod_bs1' => 0,
                        'prod_bp1' => 0,
                        'prod_bs2' => 0,
                        'prod_bp2' => 0,
                        'crt' => 0
                    ];
                    $this->data_model->saved('data_stok', $listStok);
                } else {
                    $idstok = $cekStok->row("idstok");
                    $newig = floatval($cekStok->row("prod_ig")) + floatval($ukr);
                    $listStok = [
                        'prod_ig' => round($newig,2)
                    ];
                    $this->data_model->updatedata('idstok',$idstok,'data_stok',$listStok);
                }
                $txt = "$kode diterima Samatex";
                echo json_encode(array("statusCode"=>200, "psn"=>$txt));
            } else {
                echo json_encode(array("statusCode"=>404, "psn"=>"Kode Roll sudah digunakan"));
            }
            
            } else {
                echo json_encode(array("statusCode"=>404, "psn"=>"Salah penulisan konstruksi"));
            }
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"Isi data dengan benar!!"));
        }
  } //end

  function kodetojoin(){
        $kode = $this->input->post('inOldkode');
        $kons = $this->input->post('kons');
        $ukr = $this->input->post('inOllukr');
        $jnsFold = $this->input->post('jnsFold');
        if($jnsFold=="Finish"){
            $cekKode = $this->data_model->get_byid('data_if', ['kode_roll'=>$kode]);
            if($cekKode->num_rows() == 1){
                $kodeRoll = $cekKode->row("kode_roll");
                $ukuran = $cekKode->row("ukuran_ori");
                $konsasli = $cekKode->row("konstruksi");
                if($kons == $konsasli){
                    $st = "fromdata";
                    echo json_encode(array("statusCode"=>200, "koderoll"=>$kodeRoll, "ukuran"=>$ukuran, "kons"=>$kons, "st"=>$st));
                } else {
                    echo json_encode(array("statusCode"=>404, "psn"=>"Beda konstruksi"));
                }
            } else {
                $st = "olddata";
                echo json_encode(array("statusCode"=>200, "koderoll"=>$kode, "ukuran"=>$ukr, "kons"=>$kons, "st"=>$st));
            }
        } else {
            //jika folding grey
            $cekKode = $this->data_model->get_byid('data_igtujuan', ['kode_roll'=>$kode]);
            if($cekKode->num_rows() == 1){
                $kodeRoll = $cekKode->row("kode_roll");
                $konsasli = $cekKode->row("konstruksi");
                $ukuran = $cekKode->row("ukuran");
                if($kons == $konsasli){
                    $st = "fromdata";
                    echo json_encode(array("statusCode"=>200, "koderoll"=>$kodeRoll, "ukuran"=>$ukuran, "kons"=>$kons, "st"=>$st));
                } else {
                    echo json_encode(array("statusCode"=>404, "psn"=>"Beda konstruksi"));
                }
            } else {
                $st = "olddata";
                echo json_encode(array("statusCode"=>200, "koderoll"=>$kode, "ukuran"=>$ukr, "kons"=>$kons, "st"=>$st));
            }
        }
  } //end

  function delinsgrey(){
        $id_data = $this->input->post('iddata');
        $dt = $this->data_model->get_byid('data_ig', ['id_data'=>$id_data])->row_array();
        $konstruksi = $dt['konstruksi'];
        $ukuran = $dt['ukuran_ori'];
        $bs = $dt['ukuran_bs'];
        $bp = $dt['ukuran_bp'];
        $tgl = $dt['tanggal'];
        $operator = $dt['operator'];
        $dep = $dt['dep'];
        $stokdep = "new".$dep."";
        //del produksi 
        $prod = $this->data_model->get_byid('data_produksi', ['kode_konstruksi'=>$konstruksi, 'tgl'=>$tgl, 'dep'=>$dep])->row_array();
        $id_prod = $prod['id_produksi'];
        $thisig = floatval($prod['prod_ig']) - floatval($ukuran);
        $thisbs = floatval($prod['prod_bs1']) - floatval($bs);
        $thisbp = floatval($prod['prod_bp1']) - floatval($bp);
        $this->data_model->updatedata('id_produksi',$id_prod,'data_produksi',['prod_ig'=>round($thisig,2),'prod_bs1'=>round($thisbs,2),'prod_bp1'=>round($thisbp,2)]);
        //del produksi harian
        $prod = $this->data_model->get_byid('data_produksi_harian', ['tgl'=>$tgl, 'dep'=>$dep])->row_array();
        $id_prod = $prod['id_prod_hr'];
        $thisig = floatval($prod['prod_ig']) - floatval($ukuran);
        $thisbs = floatval($prod['prod_bs1']) - floatval($bs);
        $thisbp = floatval($prod['prod_bp1']) - floatval($bp);
        $this->data_model->updatedata('id_prod_hr',$id_prod,'data_produksi_harian',['prod_ig'=>round($thisig,2),'prod_bs1'=>round($thisbs,2),'prod_bp1'=>round($thisbp,2)]);
        //del produksi operator
        $prod = $this->data_model->get_byid('data_produksi_opt', ['username_opt'=>$operator,'konstruksi'=>$konstruksi,'tgl'=>$tgl,'proses'=>'insgrey'])->row_array();
        $id_prod = $prod['id_propt'];
        $thisig = floatval($prod['ukuran']) - floatval($ukuran);
        $thisbs = floatval($prod['bs']) - floatval($bs);
        $thisbp = floatval($prod['bp']) - floatval($bp);
        $this->data_model->updatedata('id_propt',$id_prod,'data_produksi_opt',['ukuran'=>round($thisig,2),'bs'=>round($thisbs,2),'bp'=>round($thisbp,2)]);
        //del stok
        $stok = $this->data_model->get_byid('data_stok', ['dep'=>$stokdep, 'kode_konstruksi'=>$konstruksi])->row_array();
        $idstok = $stok['idstok'];
        $thisig = floatval($stok['prod_ig']) - floatval($ukuran);
        $thisbs = floatval($stok['prod_bs1']) - floatval($bs);
        $thisbp = floatval($stok['prod_bp1']) - floatval($bp);
        $this->data_model->updatedata('idstok',$idstok,'data_stok',['prod_ig'=>round($thisig,2),'prod_bs1'=>round($thisbs,2),'prod_bp1'=>round($thisbp,2)]);
        $this->db->query("DELETE FROM data_ig WHERE id_data='$id_data'");
        echo json_encode(array("statusCode"=>200, "psn"=>"oke"));
  } //end
  function delinsfinish(){
    $id_infs = $this->input->post('iddata');
    //echo $id_infs;
    $dt = $this->data_model->get_byid('data_if',['id_infs'=>$id_infs])->row_array();
    $kode_roll = $dt['kode_roll'];
    $kons = $dt['konstruksi'];
    $tgl = $dt['tgl_potong'];
    $ukuran = $dt['ukuran_ori'];
    $bs = $dt['ukuran_bs'];
    $bp = $dt['ukuran_bp'];
    $crt = $dt['ukuran_crt'];
    $ukr_seblm = $dt['ukuran_sebelum'];
    $operator = $dt['operator'];
    $idfol = $this->input->post('kdroll');
        //hapus dulu data produksi
        $this->data_model->delete('data_if','id_infs',$id_infs);
        $this->data_model->updatedata('kode_roll',$kode_roll,'kiriman_pusatex',['stfol'=>'no']);
        $this->data_model->updatedata('kode_roll',$kode_roll,'data_if_before',['status'=>'ready']);
        echo json_encode(array("statusCode"=>200, "psn"=>$kode_roll));
} //end
function getKonstruksi($konstruksi) {
    // Daftar konstruksi dan mapping-nya
    $mapping = [
        'BS L 120 GREY' => ['SM03', 'SM03A', 'RJ03','RJ03A'],
        'BS L 135 GREY' => ['SM04','RJ04'],
        'BS L 150 GREY' => ['SM15', 'SM15A', 'SM15B', 'SM15C', 'SM15D', 'SM15H', 'SM15J', 'SM15K', 'SM15L','RJ15', 'RJ15A', 'RJ15B', 'RJ15C', 'RJ15D', 'RJ15H', 'RJ15J', 'RJ15K', 'RJ15L'],
        'BS L 90 GREY'  => ['SM16', 'SM16A','RJ16', 'RJ16A']
    ];

    // Cek apakah konstruksi masuk ke salah satu kategori
    foreach ($mapping as $kategori => $konstruksiList) {
        if (in_array($konstruksi, $konstruksiList)) {
            return $kategori;
        }
    }
    // Jika tidak masuk kategori di atas, masuk ke BS Makloon
    return 'BS MAKLOON';
} //GET KONSTRUKSI GREY BS

function getKonstruksiFinish($kons){
    // Daftar konstruksi dan mapping-nya
    $mapping = [
        'BS L 120' => ['SM03', 'SM03A', 'SM05B','RJ03', 'RJ03A', 'RJ05B'],
        'BS L 135' => ['SM04','RJ04'],
        'BS L 150' => ['SM15', 'SM15A', 'SM15B', 'SM15C', 'SM15D', 'SM15H', 'SM15J', 'SM15K', 'SM15L','RJ15', 'RJ15A', 'RJ15B', 'RJ15C', 'RJ15D', 'RJ15H', 'RJ15J', 'RJ15K', 'RJ15L'],
        'BS L 90'  => ['SM16', 'SM16A','RJ16', 'RJ16A']
    ];

    // Cek apakah konstruksi masuk ke salah satu kategori
    foreach ($mapping as $kategori => $konstruksiList) {
        if (in_array($konstruksi, $konstruksiList)) {
            return $kategori;
        }
    }
    // Jika tidak masuk kategori di atas, masuk ke BS Makloon
    return 'BS MAKLOON PUTIHAN';
}
function showReadyToInsFinish(){
    $kons = $this->input->post('kons');
    if($kons == "all"){
        $query = $this->db->query("SELECT *  FROM `data_if_before` WHERE `status` LIKE 'ready' GROUP BY konstruksi");
        if($query->num_rows() > 0){
            foreach($query->result() as $val){
                $ks = $val->konstruksi;
                //$jm = 0;
                $jm = $this->db->query("SELECT SUM(ukuran) AS jml FROM `data_if_before` WHERE `konstruksi`='$ks' AND `status` LIKE 'ready'")->row("jml");
                $jm2 = $this->db->query("SELECT * FROM `data_if_before` WHERE `konstruksi`='$ks' AND `status` LIKE 'ready'")->num_rows();
                echo "<tr>";
                echo "<td>".$ks."</td>";
                ?>
                <td>
                    <a href="javacript:;" onclick="showReadyToInsFinish('<?=$ks;?>')" style="font-weight:bold;color:red;"> <?=number_format($jm);?></a>
                </td>
                <?php
                echo "<td>".number_format($jm2)." Roll</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr>";
            echo "<td>Tidak ada Kode Roll yang siap di Finish</td>";
            echo "</tr>";
        }
    } else {
        ?>
        <tr>
            <td colspan="3">Konsruksi <?=$kons;?></td>
            <td colspan="3"><a href="javacript:;" onclick="showReadyToInsFinish('all')" style="font-weight:bold;color:blue;">Semua Konstruksi</a></td>
        </tr>
        <tr>
            <td>No.</td>
            <td>Kode Roll</td>
            <td>Ukuran</td>
            <td>Diterima</td>
            <td>Tanggal</td>
            <td></td>
        </tr>
        <?php
        $query = $this->db->query("SELECT *  FROM `data_if_before` WHERE `status` LIKE 'ready' AND konstruksi='$kons'");
        $no=1;
        foreach($query->result() as $val){
            ?>
            <tr>
                <td><?=$no;?></td>
                <td><?=$val->kode_roll;?></td>
                <td><?=$val->ukuran;?></td>
                <td><?=$val->users;?></td>
                <td><?=$val->tgl_tms;?></td>
                <td><a href="javacript:;" onclick="delReadyToInsFinish('<?=$val->kode_roll;?>','<?=$kons;?>')" style="font-weight:bold;color:red;">Hapus</a></td>
            </tr>
            <?php $no++;
        }
    }
    
}

}