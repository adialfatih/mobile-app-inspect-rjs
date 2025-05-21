<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users2 extends CI_Controller
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

  function cariAjaxKode1(){
        $kode = $this->input->post('kode');
        $cari = $this->db->query("SELECT kode_roll,loc_now FROM data_ig WHERE kode_roll LIKE '%$kode%' AND loc_now='Samatex'");
        if($cari->num_rows() == 0){
            //echo json_encode(array("statusCode"=>404, "psn"=>"Kode tidak ditemukan"));
            echo "Kode Tidak Ditemukan";
        } else {
            $ar_ig = array();
            foreach($cari->result() as $val){
                $ar_ig[] = '"'.$val->kode_roll.'"';
            }
            $im_kode = implode(',', $ar_ig);
            //echo json_encode(array("statusCode"=>200, "psn"=>$im_kode));
            echo $im_kode;
        }
  }//end
    function pembulatan($angka) {
        $desimal = $angka - floor($angka);
        if ($desimal >= 0.01 && $desimal <= 0.24) {
            $desimal_baru = 0.25;
        } elseif ($desimal >= 0.26 && $desimal <= 0.49) {
            $desimal_baru = 0.50;
        } elseif ($desimal >= 0.51 && $desimal <= 0.74) {
            $desimal_baru = 0.75;
        } elseif ($desimal >= 0.75) {
            $desimal_baru = 1.00;
        } else {
            $desimal_baru = 0.00;
        }
        //--- 
        if ($desimal_baru == 1.00) {
            $hasil = floor($angka) + 1;
        } else {
            $hasil = floor($angka) + $desimal_baru;
        }
        return number_format($hasil, 2);
    }

  function prosesFolGrey(){
    $koderoll = $this->input->post('koderoll');
    $ukuran = $this->input->post('ori');
    $tgl = $this->input->post('tgl');
    $operator = $this->input->post('username');
    $old_tgl = $this->input->post('old_tgl');
    $old_opt = $this->input->post('old_opt');
    $old_note = $this->input->post('old_note');
    $jnsFold = $this->input->post('jnsFold');
    $tgl_input = date('Y-m-d H:i:s');
    $_jam = (int) date('H', strtotime($tgl_input));
    if ($_jam >= 6 && $_jam < 14) {
        $shift12 = 1;
    } elseif ($_jam >= 14 && $_jam < 22) {
        $shift12 = 2;
    } elseif ($_jam >= 22 && $_jam < 24) {
        $shift12 = 3;
    } else {
        $shift12 = 31;
    }
    if($old_tgl=="null"){

    } else {
        $tgl = $old_tgl;
        $operator = $old_opt;
        $this->data_model->saved('log_program', ['id_user'=>7,'log_text'=>$old_note]);
    }
    $kecilkanOperator = strtolower($operator);
    $cekusername = $this->data_model->get_byid('a_operator', ['username'=>$kecilkanOperator]);
    if($cekusername->num_rows() == 1){
    if($jnsFold=="Grey"){
    $cekKodeRoll = $this->data_model->get_byid('data_ig', ['kode_roll'=>$koderoll]);
    $ukuran_sebelum = $cekKodeRoll->row("ukuran_ori");
    } else {
    $cekKodeRoll = $this->data_model->get_byid('data_if', ['kode_roll'=>$koderoll]);
    $ukuran_sebelum = $cekKodeRoll->row("ukuran");
    }
    if($cekKodeRoll->num_rows() == 1){
        $kons = $cekKodeRoll->row("konstruksi");
        $cekKodeRollFinish = $this->data_model->get_byid('data_fol', ['kode_roll'=>$koderoll,'jns_fold'=>$jnsFold]);
        if($cekKodeRollFinish->num_rows() == 0){
            $dataBener=0; $totalOri=0; 
            $jadikode = array();
            $alphabet = ['0'=>'','1'=>'-A','2'=>'-B','3'=>'-C','4'=>'-D','5'=>'-E','6'=>'-F','7'=>'-G','8'=>'-H','9'=>'-I','10'=>'-J'];
            for ($i=0; $i <count($ukuran) ; $i++) { 
                if($ukuran[$i]!="" AND $ukuran[$i]>0){
                    $dataBener+=1;
                    $totalOri+=floatval($ukuran[$i]);
                    $kodeRollInput = $koderoll."".$alphabet[$i];
                    $jadikode[]= $kodeRollInput;
                    if($jnsFold=="Finish"){
                        $_ukr = floatval($ukuran[$i]);
                        $_ukr = round($_ukr,2);
                    } else {
                        //$_ukr = $ukuran[$i];
                        $_ukr = floatval($ukuran[$i]) * 0.9144;
                        $_ukr = round($_ukr,2);
                    }
                    $thisUkr = $this->pembulatan($_ukr);
                    $dtlist = [
                        'kode_roll' => strtoupper($kodeRollInput),
                        'konstruksi' => strtoupper($kons),
                        'ukuran' => $thisUkr,
                        'jns_fold' => $jnsFold,
                        'tgl' => $tgl,
                        'operator' => $kecilkanOperator,
                        'loc' => 'Pusatex',
                        'posisi' => 'Pusatex',
                        'joinss' => 'false',
                        'jam_input' => $tgl_input,
                        'shift' => $shift12
                    ];
                    $this->data_model->saved('data_fol',$dtlist);
                    $nJnsFold = "fol".$jnsFold;
                    $this->data_model->updatedata('kode_roll',$kodeRollInput,'kiriman_pusatex',['stfol'=>$nJnsFold]);
                    if($jnsFold=="Finish"){
                        $this->data_model->updatedata('kode_roll',$kodeRollInput,'data_if_before',['status'=>'folfinish']); 
                    } else {
                        $this->data_model->updatedata('kode_roll',$kodeRollInput,'data_ig',['loc_now'=>'Pusatex']); 
                        $this->db->query("DELETE FROM data_igtujuan WHERE kode_roll='$kodeRollInput'");
                    }
                } 
            } //end for 
            //cek produksi per sm harian
            
            //end cek 4
            $imJadi = implode('-', $jadikode);
            $text = "Kode ".$imJadi."";
            $this->data_model->updatedata('kode_roll',$koderoll,'data_ig',['loc_now'=>'fg']);
            echo json_encode(array("statusCode"=>200, "psn"=>$text));
        } else {
            $text = "Kode ".$koderoll." sudah di proses Folding.";
            echo json_encode(array("statusCode"=>404, "psn"=>$text));
        }
    } else {
        $text = "Kode ".$koderoll." tidak ditemukan.";
        echo json_encode(array("statusCode"=>404, "psn"=>$text));
    }
    //$text = implode('-', $ukuran);
    } else {
        $text = "Username tidak ditemukan owek!! (".$tgl.")";
        echo json_encode(array("statusCode"=>404, "psn"=>$text));
    }
  } //end

  function prosesFolFinish(){
    $koderoll = $this->input->post('koderoll');
    $ukuran = $this->input->post('ori');
    $tgl = $this->input->post('tgl');
    $operator = $this->input->post('username');
    $kecilkanOperator = strtolower($operator);
    $cekusername = $this->data_model->get_byid('a_operator', ['username'=>$kecilkanOperator, 'produksi'=>'folfinish', 'dep'=>'Samatex']);
    if($cekusername->num_rows() == 1){
    $cekKodeRoll = $this->data_model->get_byid('data_if', ['kode_roll'=>$koderoll]);
    if($cekKodeRoll->num_rows() == 1){
        $kons = $cekKodeRoll->row("konstruksi");
        $ukuran_sebelum = $cekKodeRoll->row("ukuran_ori");
        $cekKodeRollFinish = $this->data_model->get_byid('data_fol', ['kode_roll'=>$koderoll,'jns_fold'=>'Finish']);
        if($cekKodeRollFinish->num_rows() == 0){
            $dataBener=0; $totalOri=0; 
            $jadikode = array();
            $alphabet = ['0'=>'','1'=>'Z','2'=>'X','3'=>'V','4'=>'R','5'=>'T','6'=>'Y','7'=>'U','8'=>'P','9'=>'Q','10'=>'L'];
            for ($i=0; $i <count($ukuran) ; $i++) { 
                if($ukuran[$i]!="" AND $ukuran[$i]>0){
                    $dataBener+=1;
                    $totalOri+=floatval($ukuran[$i]);
                    $kodeRollInput = $koderoll."".$alphabet[$i];
                    $jadikode[]= $kodeRollInput;
                    $dtlist = [
                        'kode_roll' => strtoupper($kodeRollInput),
                        'konstruksi' => strtoupper($kons),
                        'ukuran' => $ukuran[$i],
                        'jns_fold' => 'Finish',
                        'tgl' => $tgl,
                        'operator' => $kecilkanOperator,
                        'loc' => 'Samatex',
                        'posisi' => 'Samatex',
                        'joinss' => 'false'
                    ];
                    $this->data_model->saved('data_fol',$dtlist);
                } 
            } //end for 
            //cek produksi per sm harian
            $cek1 = $this->data_model->get_byid('data_produksi', ['kode_konstruksi'=>$kons,'tgl'=>$tgl,'dep'=>'Samatex']);
            if($cek1->num_rows() == 1){
                    $id_produksi = $cek1->row("id_produksi");
                    $new_fol = floatval($cek1->row("prod_ff")) + floatval($totalOri);
                    $dtlist1 = ['prod_ff' => round($new_fol,2)];
                    $this->data_model->updatedata('id_produksi',$id_produksi,'data_produksi',$dtlist1);
            } else {
                $dtlist1 = [
                    'kode_konstruksi' => $kons,
                    'tgl' => $tgl,
                    'dep' => 'Samatex',
                    'prod_ig' => 0,
                    'prod_fg' => 0,
                    'prod_if' => 0,
                    'prod_ff' => round($totalOri,2),
                    'prod_bs1' => 0,
                    'prod_bp1' => 0,
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
                    $new_fol = floatval($cek2->row("prod_ff")) + floatval($totalOri);
                    $dtlist1 = [ 'prod_ff' => round($new_fol,2) ];
                    $this->data_model->updatedata('id_prod_hr',$id_prod_hr,'data_produksi_harian',$dtlist1);
            } else {
                $dtlist1 = [
                    'tgl' => $tgl,
                    'dep' => 'Samatex',
                    'prod_ig' => 0,
                    'prod_fg' => 0,
                    'prod_if' => 0,
                    'prod_ff' => round($totalOri,2),
                    'prod_bs1' => 0,
                    'prod_bp1' => 0,
                    'prod_bs2' => 0,
                    'prod_bp2' => 0,
                    'crt' => 0
                ];
                $this->data_model->saved('data_produksi_harian', $dtlist1);
            }
            //end cek 2
            //cek produksi opt
            $cek3 = $this->data_model->get_byid('data_produksi_opt', ['username_opt'=>$kecilkanOperator,'konstruksi'=>$kons,'tgl'=>$tgl,'proses'=>'folfinish']);
            if($cek3->num_rows() == 1){
                $id_propt = $cek3->row("id_propt");
                $new_ori = floatval($cek3->row("ukuran")) + floatval($totalOri);
                $dtlist2 = [ 'ukuran' => round($new_ori,2) ];
                $this->data_model->updatedata('id_propt',$id_propt,'data_produksi_opt',$dtlist2);
            } else {
                $jamSaatIni = date('H');
                if ($jamSaatIni >= 14) {
                $shift = "2";
                } else {
                $shift = "1";
                }
                $dtlist2 = [
                    'username_opt' => $kecilkanOperator,
                    'konstruksi' => $kons,
                    'tgl' => $tgl,
                    'proses' => 'folfinish',
                    'ukuran' => round($totalOri,2), 
                    'bs' => 0,
                    'bp' => 0,
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
                    'prod_ig' => 0,
                    'prod_fg' => 0,
                    'prod_if' => 0,
                    'prod_ff' => round($totalOri,2),
                    'prod_bs1' => 0,
                    'prod_bp1' => 0,
                    'prod_bs2' => 0,
                    'prod_bp2' => 0,
                    'crt' => 0
                ];
                $this->data_model->saved('data_stok', $listStok);
            } else {
                $idstok = $cekStok->row("idstok");
                $newig = floatval($cekStok->row("prod_if")) - floatval($ukuran_sebelum);
                $newfg = floatval($cekStok->row("prod_ff")) + floatval($totalOri);
                $listStok = [
                    'prod_if' => round($newig,2),
                    'prod_ff' => round($newfg,2)
                ];
                $this->data_model->updatedata('idstok',$idstok,'data_stok',$listStok);
            }
            //end cek 4
            $imJadi = implode('-', $jadikode);
            $text = "Kode ".$imJadi."";
            echo json_encode(array("statusCode"=>200, "psn"=>$text));
        } else {
            $text = "Kode ".$koderoll." sudah di proses Folding.";
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
  } //end

  function cariInsFinish(){
        $kode = $this->input->post('kode');
        $cekkode = $this->data_model->get_byid('data_ig', ['kode_roll'=>$kode]);
        //if($cekkode->num_rows() == 1){
            $cek_finish = $this->data_model->get_byid('data_if', ['kode_roll'=>$kode]);
            if($cek_finish->num_rows() == 1){
                $kons = $cek_finish->row("konstruksi");
                //$mc = $cekkode->row("no_mesin");
                $ori = $cek_finish->row("ukuran_ori");
                $ori_yard = floatval($ori) / 0.9144;
                $cek_fol = $this->data_model->get_byid('data_fol',['kode_roll'=>$kode]);
                if($cek_fol->num_rows() == 0){
                    $text = "Data Inspect Finish<br>- Konstruksi &nbsp;<strong>".$kons."</strong><br>- Ukuran &nbsp;<strong>".$ori."</strong> Meter / <strong>".round($ori_yard,2)."</strong> Yard";
                    echo json_encode(array("statusCode"=>200, "psn"=>$text));
                } else {
                    $text = "<span style='color:red;'>".$kode." telah di proses folding</code>";
                    echo json_encode(array("statusCode"=>200, "psn"=>$text));
                }
            } else {
                $text = "<span style='color:red;'>".$kode." belum di proses inspect Finish</code>";
                echo json_encode(array("statusCode"=>200, "psn"=>$text));
            }
            
        // } else {
        //     echo json_encode(array("statusCode"=>404, "psn"=>"Kode tidak ditemukan"));
        // }
  } //end
  function prosesCreatepkg(){
        $namacus = strtolower($this->input->post('namacus'));
        $username = strtolower($this->input->post('username'));
        $kodekons = $this->input->post('kodekons');
        //
        $cekkons = $this->data_model->get_byid('tb_konstruksi', ['kode_konstruksi'=>$kodekons]);
        if($cekkons->num_rows() == 1){
            $konstruksi = "true";
        } else {
            $cekkons2 = $this->data_model->get_byid('tb_konstruksi', ['chto'=>$kodekons]);
            if($cekkons2->num_rows() == 1){
                $konstruksi = "true";
            } else {
                $konstruksi = "false";
            }
            
        }
        if($konstruksi=="true"){
        $tgl =$this->input->post('tgl');
         $cekPkg = $this->db->query("SELECT * FROM new_tb_packinglist WHERE lokasi_now='Samatex' ORDER BY id_kdlist DESC LIMIT 1");
        if($cekPkg->num_rows() == 0){
            $kdpkg = "PKG1";
        } else {
            $kode_sebelum = $cekPkg->row("kd");
            $ex = explode('G', $kode_sebelum);
            $num = intval($ex[1]) + 1;
            $kdpkg = "PKG".$num."";
        }
        $dtlist = [
            'kode_konstruksi' => $kodekons,
            'kd' => $kdpkg,
            'tanggal_dibuat' => $tgl,
            'lokasi_now' => 'Samatex',
            'siap_jual' => 'y',
            'jumlah_roll' => 0,
            'ttl_panjang' => 0,
            'kepada' => 'NULL',
            'no_sj' => 'NULL',
            'ygbuat' => $username,
            'jns_fold' => $username=='yusuf' ? 'Finish':'Grey',
            'customer' => $namacus
        ];
        $this->data_model->saved('new_tb_packinglist', $dtlist);
        echo json_encode(array("statusCode"=>200, "psn"=>$kdpkg));
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>'Konstruksi tidak ditemukan'));
        }
        //
  } //end
  function prosesCreatepkg2(){
        $username = strtolower($this->input->post('username'));
        $kodekons = $this->input->post('kodekons');
        //
        $cekkons = $this->data_model->get_byid('tb_konstruksi', ['kode_konstruksi'=>$kodekons]);
        if($cekkons->num_rows() == 1){
            $konstruksi = "true";
        } else {
            $cekkons2 = $this->data_model->get_byid('tb_konstruksi', ['chto'=>$kodekons]);
            if($cekkons2->num_rows() == 1){
                $konstruksi = "true";
            } else {
                $konstruksi = "false";
            }
            
        }
        if($konstruksi=="true"){
        $tgl =$this->input->post('tgl');
         $cekPkg = $this->db->query("SELECT * FROM new_tb_packinglist WHERE lokasi_now='Samatex' ORDER BY id_kdlist DESC LIMIT 1");
        if($cekPkg->num_rows() == 0){
            $kdpkg = "PKG1";
        } else {
            $kode_sebelum = $cekPkg->row("kd");
            $ex = explode('G', $kode_sebelum);
            $num = intval($ex[1]) + 1;
            $kdpkg = "PKG".$num."";
        }
        $dtlist = [
            'kode_konstruksi' => $kodekons,
            'kd' => $kdpkg,
            'tanggal_dibuat' => $tgl,
            'lokasi_now' => 'Samatex',
            'siap_jual' => 'n',
            'jumlah_roll' => 0,
            'ttl_panjang' => 0,
            'kepada' => 'NULL',
            'no_sj' => 'NULL',
            'ygbuat' => $username,
            'jns_fold' => 'null'
        ];
        $this->data_model->saved('new_tb_packinglist', $dtlist);
        echo json_encode(array("statusCode"=>200, "psn"=>$kdpkg));
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>'Konstruksi tidak ditemukan'));
        }
        //
  } //end
  function loadDataStok(){
    $stokAmbil="";
    $username =strtolower($this->input->post('username'));
    $cekusername = $this->data_model->get_byid('a_operator', ['username'=>$username, 'produksi'=>'penjualan']);
    if($cekusername->num_rows() == 1){
        if($username == "yusuf"){ $stokAmbil = "Finish"; }
        if($username == "riziq"){ $stokAmbil = "Grey"; }
        if($username == "rizik"){ $stokAmbil = "Grey"; }
        if($username == "syafiq"){ $stokAmbil = "All"; }
        if($username == "8012"){ $stokAmbil = "All"; }
        if($stokAmbil!=""){
            if($stokAmbil=="All"){
                $query = $this->data_model->get_byid('data_stok', ['dep'=>'newSamatex']);
                echo "<tr><td><strong>Konstruksi</strong></td><td><strong>Stok</strong></td></tr>";
                foreach($query->result() as $val){
                    if($val->prod_ff > 0){
                        echo "<tr>";
                        $cekChto = $this->data_model->get_byid('tb_konstruksi',['kode_konstruksi'=>$val->kode_konstruksi])->row("chto");
                        if($cekChto=="NULL"){
                        echo "<td>".$val->kode_konstruksi."</td>"; } else {
                            echo "<td>".$cekChto."</td>";
                        }
                        if(fmod($val->prod_ff, 1) !== 0.00){
                            $pjg = number_format($val->prod_ff,2,',','.');
                        } else {
                            $pjg = number_format($val->prod_ff,0,',','.');
                        }
                        echo "<td>".$pjg."</td>";
                        echo "</tr>";
                    }
                    if($val->prod_fg > 0){
                        echo "<tr>";
                        echo "<td>".$val->kode_konstruksi."</td>";
                        if(fmod($val->prod_fg, 1) !== 0.00){
                            $pjg = number_format($val->prod_fg,2,',','.');
                        } else {
                            $pjg = number_format($val->prod_fg,0,',','.');
                        }
                        echo "<td>".$pjg."</td>";
                        echo "</tr>";
                    }
                }   
            }
            if($stokAmbil=="Finish"){
                $query = $this->data_model->get_byid('data_stok', ['dep'=>'newSamatex']);
                echo "<tr><td><strong>Konstruksi</strong></td><td><strong>Stok</strong></td></tr>";
                foreach($query->result() as $val){
                    if($val->prod_ff > 0){
                        echo "<tr>";
                        $cekChto = $this->data_model->get_byid('tb_konstruksi',['kode_konstruksi'=>$val->kode_konstruksi])->row("chto");
                        if($cekChto=="NULL"){
                        echo "<td>".$val->kode_konstruksi."</td>"; } else {
                            echo "<td>".$cekChto."</td>";
                        }
                        if(fmod($val->prod_ff, 1) !== 0.00){
                            $pjg = number_format($val->prod_ff,2,',','.');
                        } else {
                            $pjg = number_format($val->prod_ff,0,',','.');
                        }
                        echo "<td>".$pjg."</td>";
                        echo "</tr>";
                    }
                }   
            }
            if($stokAmbil=="Grey"){
                $query = $this->data_model->get_byid('data_stok', ['dep'=>'newSamatex']);
                echo "<tr><td><strong>Konstruksi</strong></td><td><strong>Stok</strong></td></tr>";
                foreach($query->result() as $val){
                    if($val->prod_fg > 0){
                        echo "<tr>";
                        echo "<td>".$val->kode_konstruksi."</td>";
                        if(fmod($val->prod_fg, 1) !== 0.00){
                            $pjg = number_format($val->prod_fg,2,',','.');
                        } else {
                            $pjg = number_format($val->prod_fg,0,',','.');
                        }
                        echo "<td>".$pjg."</td>";
                        echo "</tr>";
                    }
                }   
            }
        } else {
            echo "<tr><td colspan='2'><span style='color:red;'>Tidak berhasil mengambil data stok. Anda perlu login ulang</span></td></tr>";
        }
    } else {
        echo "<tr><td colspan='2'><span style='color:red;'>Tidak berhasil mengambil data stok. Anda perlu login ulang</span></td></tr>";
    }
  } //end
  function loadpenjualan(){
        $bln = ['00'=>'undf', '01'=>'Jan', '02'=>'Feb', '03'=>'Mar', '04'=>'Apr', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Ags', '09'=>'Sep', '10'=>'Okt', '11'=>'Nov', '12'=>'Des'];
        $yr = date('Y');
        $username =strtolower($this->input->post('username'));
        $cekusername = $this->data_model->get_byid('a_operator', ['username'=>$username, 'produksi'=>'penjualan']);
        if($cekusername->num_rows() == 1){
            //$query = $this->data_model->get_byid('new_tb_packinglist', ['lokasi_now'=>'Samatex','siap_jual'=>'y','ygbuat'=>$username]);
            if($username=="syafiq" OR $username=="8012"){
                $query = $this->db->query("SELECT * FROM new_tb_packinglist WHERE lokasi_now='Samatex' AND siap_jual='y' ORDER BY id_kdlist DESC LIMIT 100");
            } else {
            $query = $this->db->query("SELECT * FROM new_tb_packinglist WHERE lokasi_now='Samatex' AND siap_jual='y' AND ygbuat='$username' ORDER BY id_kdlist DESC LIMIT 100"); }
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
                    if($val->kepada!="NULL"){ echo "<td><a href='".base_url('users/createpenjualan/'.$val->kd)."' style='text-decoration:none; color:#000000;'>".$val->kd."</a></td>"; } else {
                    echo "<td style='font-weight:bold;color:#4287f5;'><a href='".base_url('users/createpenjualan/'.$val->kd)."' style='text-decoration:none;'>".$val->kd."</a></td>"; 
                    }
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
                echo "<tr><td colspan='5'><span style='color:red;'>Anda belum membuat paket penjualan</span></td></tr>";
            }
        } else {
            echo "<tr><td colspan='5'><span style='color:red;'>Tidak berhasil mengambil data packing penjualan. Anda perlu login ulang</span></td></tr>";
        }
  } //end

  function delisi(){
        $id_isi = $this->input->post("kode");
        $cekstatus = $this->data_model->get_byid('new_tb_isi', ['id_isi'=>$id_isi]);
        $kode = $cekstatus->row("kode");
        if($cekstatus->row("status") == "oke"){
            $ukuran = $this->data_model->get_byid('data_fol', ['kode_roll'=>$kode])->row("ukuran");
            $kdpkg = $this->data_model->get_byid('new_tb_isi', ['kode'=>$kode])->row("kd");
            $pkglist = $this->data_model->get_byid('new_tb_packinglist', ['kd'=>$kdpkg]);

            $jml_roll = intval($pkglist->row("jumlah_roll")) - 1;
            $ttl_pjg = floatval($pkglist->row("ttl_panjang")) - $ukuran;
            $this->data_model->updatedata('kd',$kdpkg,'new_tb_packinglist',['jumlah_roll'=>$jml_roll, 'ttl_panjang'=>round($ttl_pjg,2)]);
            $this->db->query("DELETE FROM new_tb_isi WHERE kode='$kode'");
            $this->data_model->updatedata('kode_roll',$kode,'data_fol',['posisi'=>'Samatex']);
            
            echo json_encode(array("statusCode"=>200, "psn"=>"oke"));
        } else {
            $ukuran = $cekstatus->row("ukuran");
            $kdpkg = $cekstatus->row("kd");
            $pkglist = $this->data_model->get_byid('new_tb_packinglist', ['kd'=>$kdpkg]);

            $jml_roll = intval($pkglist->row("jumlah_roll")) - 1;
            $ttl_pjg = floatval($pkglist->row("ttl_panjang")) - $ukuran;
            $this->data_model->updatedata('kd',$kdpkg,'new_tb_packinglist',['jumlah_roll'=>$jml_roll, 'ttl_panjang'=>round($ttl_pjg,2)]);
            $this->db->query("DELETE FROM new_tb_isi WHERE id_isi='$id_isi'");
                        
            echo json_encode(array("statusCode"=>200, "psn"=>"oke"));
        }
  } //end
  
  function delisi2(){
    //$kode = $this->input->post("kode");
    $id_isi = $this->input->post("kode");
        $cekstatus = $this->data_model->get_byid('new_tb_isi', ['id_isi'=>$id_isi]);
        $kode = $cekstatus->row("kode");
    $ukuran = $this->data_model->get_byid('data_ig', ['kode_roll'=>$kode])->row("ukuran_ori");
    $kdpkg = $this->data_model->get_byid('new_tb_isi', ['kode'=>$kode])->row("kd");
    $pkglist = $this->data_model->get_byid('new_tb_packinglist', ['kd'=>$kdpkg]);

    $jml_roll = intval($pkglist->row("jumlah_roll")) - 1;
    $ttl_pjg = floatval($pkglist->row("ttl_panjang")) - $ukuran;
    $this->data_model->updatedata('kd',$kdpkg,'new_tb_packinglist',['jumlah_roll'=>$jml_roll, 'ttl_panjang'=>round($ttl_pjg,2)]);
    $this->db->query("DELETE FROM new_tb_isi WHERE kode='$kode'");
    $this->data_model->updatedata('kode_roll',$kode,'data_ig',['loc_now'=>'Samatex']);
    
    echo json_encode(array("statusCode"=>200, "psn"=>"oke"));
} //end
function delisi256(){
    //$kode = $this->input->post("kode");
    $id_isi = $this->input->post("kode");
    $cekstatus = $this->data_model->get_byid('new_tb_isi', ['id_isi'=>$id_isi]);
    $kode_roll = $cekstatus->row("kode");
    
    $this->data_model->updatedata('kode_roll',$kode_roll,'data_ig',['loc_now'=>'RJS']);
    $this->db->query("DELETE FROM new_tb_isi WHERE id_isi='$id_isi'");
    //$this->data_model->updatedata('id_data',$iddata,'data_ig',['loc_now'=>'RJS']);
    
    echo json_encode(array("statusCode"=>200, "psn"=>"oke"));
} //end
function delisi_jual(){
    //$kode = $this->input->post("kode");
    $id_isi = $this->input->post("kode");
    $cekstatus = $this->data_model->get_byid('new_tb_isi', ['id_isi'=>$id_isi]);
    $kode_roll = $cekstatus->row("kode");
    $this->data_model->updatedata('kode_roll',$kode_roll,'data_fol',['posisi'=>'Pusatex']);
    $this->db->query("DELETE FROM new_tb_isi WHERE id_isi='$id_isi'");
    echo json_encode(array("statusCode"=>200, "psn"=>$kode_roll));
} //end
function validasi2(){
    $id = $this->input->post("id");
    $cekstatus = $this->data_model->get_byid('new_tb_isi', ['id_isi'=>$id])->row("validasi");
    if($cekstatus == "valid"){
        $this->data_model->updatedata('id_isi',$id,'new_tb_isi',['validasi'=>'NULL']);
    } else {
        $this->data_model->updatedata('id_isi',$id,'new_tb_isi',['validasi'=>'valid']);
    }
    echo json_encode(array("statusCode"=>200, "psn"=>"oke"));

}

  function loadisipkg(){
        $kd = $this->input->post("pkg");
        $siap_jual = $this->input->post("siap_jual");
        $_pkg = $this->db->query("SELECT * FROM new_tb_packinglist WHERE kd='$kd'"); 
        $kepada = $_pkg->row("kepada"); 
        //$query = $this->data_model->get_byid('new_tb_isi', ['kd'=>$kd]);
        $query = $this->db->query("SELECT * FROM new_tb_isi WHERE kd='$kd' ORDER BY id_isi DESC");
        if($query->num_rows() > 0){
            if($siap_jual == "y"){
                echo '<tr>
                        <td><strong>No</strong></td>
                        <td><strong>Kode Roll</strong></td>
                        <td><strong>Konstruksi</strong></td>
                        <td><strong>Ukuran</strong></td>
                        <td><strong>#</strong></td>
                        <td><strong>Del</strong></td>
                    </tr>';
            } else {
            echo '<tr>
                        <td><strong>No</strong></td>
                        <td><strong>Kode Roll</strong></td>
                        <td><strong>Konstruksi</strong></td>
                        <td><strong>Ukuran</strong></td>
                        <td><strong>Beam</strong></td>
                        <td><strong>Del</strong></td>
                    </tr>'; }
            $total = 0; $jml_roll = 0;
            foreach($query->result() as $no => $val){
                $nos = $no+1;
                $jml_roll+=1;
                $kdrol = $val->kode;
                $_id = $val->id_isi;
                $_ks = $val->konstruksi;
                $total+=floatval($val->ukuran);
                $nobeam = $this->db->query("SELECT id_data,kode_roll,no_beam FROM data_ig WHERE kode_roll='$kdrol' ORDER BY id_data DESC LIMIT 1")->row("no_beam");
                echo "<tr>";
                echo "<td>".$nos."</td>";
                echo "<td>".$kdrol."</td>";
                echo "<td>".$_ks."</td>";
                echo "<td>".$val->ukuran."</td>";
                if($siap_jual == "y"){
                    $_valid = $val->validasi;
                    ?>
                    <td>
                        <input type="checkbox" style="accent-color:#e80202;" <?=$_valid=='valid' ? 'checked':'';?> onclick="validasi('<?=$val->id_isi;?>')">
                    </td>
                    <?php
                } else {
                echo "<td>".$nobeam."</td>"; }
                if($kepada=="NULL") {
                ?><td sytle="color:red;">
                    <img src="<?=base_url('assets/del.png');?>" alt="Delete" style="width:20px;" onclick="delpkg('<?=$_id;?>')">
                </td><?php
                } else {
                    echo "<td></td>";
                }
                echo "</tr>";
            }
            if(fmod($total, 1) !== 0.00){
                $pjg = number_format($total,2,',','.');
            } else {
                $pjg = number_format($total,0,',','.');
            }
            echo "<tr><td colspan='3'><strong>Total</strong></td><td>".$pjg."</td><td colspan='2'></td>";
            $this->data_model->updatedata('kd',$kd,'new_tb_packinglist',['jumlah_roll'=>$jml_roll,'ttl_panjang'=>round($total,1)]);
        } else {
            echo '<tr>
                        <td><strong>No</strong></td>
                        <td><strong>Kode Roll</strong></td>
                        <td><strong>Ukuran</strong></td>
                        <td><strong>#</strong></td>
                    </tr>
                    <tr>
                        <td colspan="4">Paket masih kosong</td>
                    </tr>';
        }

  } //end
  function loadisipkg15(){
        //proses retur barang rjs
        $kode = $this->input->post('kode');
        $cek = $this->data_model->get_byid('new_tb_isi', ['kode'=>$kode])->row_array();
        if($cek['status'] == "delete"){
            $this->data_model->updatedata('kode',$kode,'new_tb_isi',['status'=>'oke']);
            $this->data_model->updatedata('kode_roll',$kode,'data_ig',['loc_now'=>'Samatex']);
        } else {
            $this->data_model->updatedata('kode',$kode,'new_tb_isi',['status'=>'delete']);
            $this->data_model->updatedata('kode_roll',$kode,'data_ig',['loc_now'=>'RJS']);
        }
        echo json_encode(array("statusCode"=>200, "psn"=>"oke"));

  } //end
  function loadisipkg13(){
    $kd = $this->input->post("pkg");
    //$query = $this->data_model->get_byid('new_tb_isi', ['kd'=>$kd]);
    $query = $this->db->query("SELECT * FROM new_tb_isi WHERE kd='$kd' ORDER BY id_isi DESC");
    if($query->num_rows() > 0){
        echo '<tr>
                    <td><strong>No</strong></td>
                    <td><strong>Kode Roll</strong></td>
                    <td><strong>Ukuran</strong></td>
                    <td><strong>#</strong></td>
                    <td><strong>Retur</strong></td>
                </tr>';
        $total = 0; 
        foreach($query->result() as $no => $val){
            $nos = $no+1;
            $total+=floatval($val->ukuran);
            echo "<tr>";
            echo "<td>".$nos."</td>";
            echo "<td>".$val->kode."</td>";
            echo "<td>".$val->ukuran."</td>";
            echo "<td><input type='checkbox'></td>";
            ?>
            <td><input type="checkbox" style="accent-color:#e80202;" onclick="returRjs('<?=$val->kode;?>')"></td>
            <?php
            echo "</tr>";
        }
        if(fmod($total, 1) !== 0.00){
            $pjg = number_format($total,2,',','.');
        } else {
            $pjg = number_format($total,0,',','.');
        }
        echo "<tr><td colspan='2'><strong>Total</strong></td><td>".$pjg."</td><td colspan='2'></td>";
    } else {
        echo '<tr>
                    <td><strong>No</strong></td>
                    <td><strong>Kode Roll</strong></td>
                    <td><strong>Ukuran</strong></td>
                    <td><strong>#</strong></td>
                </tr>
                <tr>
                    <td colspan="4">Paket masih kosong</td>
                </tr>';
    }

} //end
function inputstokrjsjual(){
    $kode = $this->input->post("selection");
    $kons = $this->input->post("kons");
    $pkg = $this->input->post("pkg");
    $_kode = $this->data_model->get_byid('data_fol',['kode_roll'=>$kode]);
    $_pkg = $this->data_model->get_byid('new_tb_packinglist',['kd'=>$pkg])->row_array();
    $_jnsFold = $_pkg['jns_fold'];
    if($_kode->num_rows() == 1){
        $_konsKode = $_kode->row("konstruksi");
        $_thisFold = $_kode->row("jns_fold");
        $_posisi = $_kode->row("posisi");
        $_thisukr = $_kode->row("ukuran");
        if($_thisFold=="Finish") { $st="Yard"; } else { $st="Meter"; }
        if($_konsKode == $kons){
            if($_thisFold == $_jnsFold){
                if (strpos($_posisi, 'PKT') !== false) {
                    $txtx = "Kode ".$kode." berada di packinglist ".$_posisi."";
                    echo json_encode(array("statusCode"=>404, "psn"=>$txtx));
                } elseif ($_posisi == 'Pusatex' OR $_posisi=="pusatex") {
                    //jika berhasil
                    $this->data_model->updatedata('kode_roll',$kode,'data_fol',['posisi'=>$pkg]);
                    $this->data_model->saved('new_tb_isi',[
                        'kd'=>strtoupper($pkg), 'konstruksi'=>$_konsKode, 'siap_jual'=>'y', 'kode'=>$kode, 'ukuran'=>$_thisukr, 'status'=>'oke', 'satuan'=>$st, 'validasi'=>'NULL'
                    ]);
                    echo json_encode(array("statusCode"=>200, "psn"=>$txtx));
                } else {
                    $txtx = "Kode ".$kode." berada di customer atas nama ".$_posisi."";
                    echo json_encode(array("statusCode"=>404, "psn"=>$txtx));
                }                
            } else {
                $txtx = "Kode ".$kode." di proses folding ".$_thisFold;
                echo json_encode(array("statusCode"=>404, "psn"=>$txtx));
            }
        } else {
            $txtx = "Kode ".$kode." konstruksi tidak sama dengan paket.!!";
            echo json_encode(array("statusCode"=>404, "psn"=>$txtx));
        }
    } else {
        echo json_encode(array("statusCode"=>404, "psn"=>"Kode Roll sudah di packinglist"));
    }
}
  function inputstok(){
    $kode = $this->input->post("selection");
    $kons = $this->input->post("kons");
    $pkg = $this->input->post("pkg");
    $cekpkg = $this->data_model->get_byid('new_tb_packinglist', ['kd'=>$pkg])->row_array();
    $jmlroll = $cekpkg['jumlah_roll'];
    $ttlpjg = $cekpkg['ttl_panjang'];
    if($cekpkg['siap_jual']=="y"){
        $cekkode = $this->data_model->get_byid('data_fol', ['kode_roll'=>$kode, 'posisi'=>'Samatex']);
        $siapJual = "y";
        $ukuran = $cekkode->row('ukuran');
    } else {
        $cekkode = $this->data_model->get_byid('data_ig', ['kode_roll'=>$kode, 'loc_now'=>'Samatex']);
        $siapJual = "n";
        $ukuran = $cekkode->row('ukuran_ori');
    }
    
    if($cekkode->num_rows() == 1){
        $cek_isi = $this->data_model->get_byid('new_tb_isi', ['kode'=>$kode, 'status!='=>'fixsend', 'siap_jual'=>$siapJual]);
        if($cek_isi->num_rows() == 0){
            $dtlist = [
                'kd' => $pkg,
                'konstruksi' => $kons,
                'siap_jual' => $siapJual,
                'kode' => $kode,
                'ukuran' => $ukuran,
                'status' => 'oke',
                'satuan' => $cekpkg['jns_fold']=='Finish' ? 'Yard':'Meter'
            ];
            $this->data_model->saved('new_tb_isi', $dtlist);
            if($siapJual=="y"){
            $this->data_model->updatedata('kode_roll',$kode,'data_fol',['posisi'=>$pkg]); } else {
                $this->data_model->updatedata('kode_roll',$kode,'data_ig',['loc_now'=>$pkg]);
            }
            $new_jmlroll = intval($jmlroll) + 1;
            $new_ttlpjg = floatval($ttlpjg) + floatval($ukuran);
            $this->data_model->updatedata('kd',$pkg,'new_tb_packinglist',['jumlah_roll'=>$new_jmlroll, 'ttl_panjang'=>round($new_ttlpjg,2)]);
            echo json_encode(array("statusCode"=>200, "psn"=>"Kode Roll sudah di packinglist lain"));
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"Kode Roll sudah di packinglist"));
        }
    } else {
        echo json_encode(array("statusCode"=>404, "psn"=>"Kode Roll tidak ditemukan"));
    }
} //end

  function inputstokrjs(){
        $kode = $this->input->post("selection");
        $kons = $this->input->post("kons");
        $pkg = $this->input->post("pkg");
        $tipee = $this->input->post("tipee");
        $siap_jual = $this->input->post("siap_jual");
        $cekpkg = $this->data_model->get_byid('new_tb_packinglist', ['kd'=>$pkg])->row_array();
        $jmlroll = $cekpkg['jumlah_roll'];
        $ttlpjg = $cekpkg['ttl_panjang'];
        if($cekpkg['siap_jual']=="y"){
            $cekkode = $this->data_model->get_byid('data_fol', ['kode_roll'=>$kode, 'posisi'=>'Pusatex']);
            $siapJual = "y";
            $ukuran = $cekkode->row('ukuran');
        } else {
            if($tipee == "0"){
            $cekkode = $this->data_model->get_byid('data_ig', ['kode_roll'=>$kode, 'loc_now'=>'RJS']);
            $siapJual = "n";
            $ukuran = $cekkode->row('ukuran_ori');
            } else {
                $cekkode = $this->data_model->get_byid('data_ig', ['kode_roll'=>$kode, 'loc_now'=>'RJS']);
                $siapJual = "n";
                $ukuran = $cekkode->row('ukuran_ori');
            }
        }
        
        if($cekkode->num_rows() == 1){
            if($tipee == "0"){
                $cek_isi = $this->data_model->get_byid('new_tb_isi', ['kode'=>$kode]);
            } else {
                $cek_isi = $this->data_model->get_byid('new_tb_isi', ['kd'=>$pkg,'kode'=>$kode]);
            }
            if($cek_isi->num_rows() == 0){
                $dtlist = [
                    'kd' => $pkg,
                    'konstruksi' => $kons,
                    'siap_jual' => $siapJual,
                    'kode' => $kode,
                    'ukuran' => $ukuran,
                    'status' => 'oke',
                    'satuan' => $cekpkg['jns_fold']=='Finish' ? 'Yard':'Meter'
                ];
                $this->data_model->saved('new_tb_isi', $dtlist);
                if($siapJual=="y"){
                    $this->data_model->updatedata('kode_roll',$kode,'data_fol',['posisi'=>$pkg]); } else {
                    $this->data_model->updatedata('kode_roll',$kode,'data_ig',['loc_now'=>$pkg]);
                }
                $new_jmlroll = intval($jmlroll) + 1;
                $new_ttlpjg = floatval($ttlpjg) + floatval($ukuran);
                $cekisi2 = $this->db->query("SELECT new_tb_isi.id_isi,new_tb_isi.kd,new_tb_isi.kode,data_ig.kode_roll,data_ig.no_beam FROM new_tb_isi,data_ig WHERE new_tb_isi.kode=data_ig.kode_roll AND new_tb_isi.kd='$pkg' AND data_ig.no_beam LIKE '%bsm%' ");
                if($cekisi2->num_rows() > 0){
                    $beamoke = "bsm";
                } else {
                    $beamoke = "brj";
                }
                $this->data_model->updatedata('kd',$pkg,'new_tb_packinglist',['jumlah_roll'=>$new_jmlroll, 'ttl_panjang'=>round($new_ttlpjg,2), 'customer'=>$beamoke]);
                echo json_encode(array("statusCode"=>200, "psn"=>"Kode Roll sudah di packinglist lain"));
            } else {
                echo json_encode(array("statusCode"=>404, "psn"=>"Kode Roll sudah di packinglist"));
            }
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"Kode Roll tidak ditemukan"));
        }
  } //end

  function caristok(){
        $kode = $this->input->post("kode");
        $cek_kode = $this->data_model->get_byid('tb_konstruksi', ['kode_konstruksi'=>$kode]);
        if($cek_kode->num_rows() == 1){
            $jenis = "Grey";
            $jumlah_stok = $this->data_model->get_byid('data_stok', ['dep'=>'newSamatex','kode_konstruksi'=>$kode])->row("prod_fg");
        } else {
            $jenis = "Finish";
            $kodeKons = $this->data_model->get_byid('tb_konstruksi', ['chto'=>$kode])->row("kode_konstruksi");
            $jumlah_stok = $this->data_model->get_byid('data_stok', ['dep'=>'newSamatex','kode_konstruksi'=>$kodeKons])->row("prod_ff");
        }
        echo json_encode(array("statusCode"=>200, "jenis"=>"oke"));
  } //end

  function deletPkg(){
        $kd = $this->input->post("pkg");
        $cekisi_dulu = $this->data_model->get_byid('new_tb_isi', ['kd'=>$kd]);
        if($cekisi_dulu->num_rows() == 0){
            $this->db->query("DELETE FROM new_tb_packinglist WHERE kd='$kd'");
            echo json_encode(array("statusCode"=>200, "psn"=>""));
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"Hapus dulu semua isi paket.!"));
        }
  } //end

  function addRollLama(){
        $kd = $this->input->post("oldKodeRoll");
        $ukr = $this->input->post("oldUkuran");
        $pkg = $this->input->post("pkg");
        $mc = $this->input->post("mc");
        $kons = $this->input->post("kons");
        $tgl = $this->input->post("tgl");
        $user = $this->input->post("user");

        if($kd!="" AND $ukr!=""){
            $cekKodediIg = $this->data_model->get_byid('data_ig', ['kode_roll'=>$kd]);
            if($cekKodediIg->num_rows() == 0){
                $cekDiTableIsi = $this->data_model->get_byid('new_tb_isi', ['kode'=>$kd,'status!='=>'fixsend']);
                if($cekDiTableIsi->num_rows() == 0){
                    $pkgs = $this->data_model->get_byid('new_tb_packinglist', ['kd'=>$pkg])->row_array(); 
                    $dtlist = [
                        'kd' => $pkg,
                        'konstruksi' => $pkgs['kode_konstruksi'],
                        'siap_jual' => $pkgs['siap_jual'],
                        'kode' => $kd,
                        'ukuran' => $ukr,
                        'status' => 'oke',
                        'satuan' => 'Meter'
                    ];
                    $this->data_model->saved('new_tb_isi', $dtlist);
                    $newRoll = intval($pkgs['jumlah_roll']) + 1;
                    $newPanj = floatval($pkgs['ttl_panjang']) + floatval($ukr);
                    $this->data_model->updatedata('kd',$pkg,'new_tb_packinglist',['jumlah_roll'=>$newRoll,'ttl_panjang'=>round($newPanj,2)]);
                    $dtlist2 = [
                        'kode_roll' => $kd,
                        'konstruksi' => $pkgs['kode_konstruksi'],
                        'no_mesin' => $mc,
                        'no_beam' => 'n',
                        'oka' => 'n',
                        'ukuran_ori' => $ukr,
                        'ukuran_bs' => '0',
                        'ukuran_bp' => '0',
                        'tanggal' => $tgl,
                        'operator' => $user,
                        'bp_can_join' => $ukr<50 ? 'true':'false',
                        'dep' => 'Samatex',
                        'loc_now' => $pkg,
                        'yg_input' => 'n',
                        'kode_upload' => 'tes'
                    ];
                    //$this->data_model->saved('data_ig', $dtlist2);
                    $this->data_model->saved('data_ig', $dtlist2);
                    $stok = $this->data_model->get_byid('data_stok', ['dep'=>'newSamatex', 'kode_konstruksi'=>$kons]);
                    $idstok = $stok->row("idstok");
                    $newig = floatval($stok->row("prod_ig")) + floatval($ukr);
                    $this->data_model->updatedata('idstok',$idstok,'data_stok',['prod_ig'=>round($newig,2)]);
                    echo json_encode(array("statusCode"=>200, "psn"=>"oke"));
                } else {
                    echo json_encode(array("statusCode"=>404, "psn"=>"Kode sudah ada dipaket"));
                }
            } else {
                echo json_encode(array("statusCode"=>404, "psn"=>"Kode sudah digunakan"));
            }
            
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"Kode dan Ukuran harus di isi"));
        }
  }

  function prosesJoinPieces(){
        $jnsFold = $this->input->post('jnsFold');
        $ukuranJoin = $this->input->post('ukuranJoin');
        $ukuranJoin2 = $this->input->post('ukuranJoin2');
        $kons = $this->input->post('kons');
        $kode = $this->input->post('koder');
        $ukra = $this->input->post('ukra');
        $str = $this->input->post('st');
        $username = $this->input->post('username');
        $tgl = $this->input->post('tgl');
        $exxr = explode(',',$kode);
        $st = explode(',',$str);
        $thistime = date('Y-m-d H:i:s');
        $jml = count($exxr);
        if($jnsFold=="Finish"){
            $cekKodeJoin = $this->data_model->get_byid('data_fol', ['joinss'=>'true']);
            $cekKodeJoin = $this->db->query("SELECT * FROM data_fol WHERE `kode_roll` LIKE '%JP%' AND joinss='true' ORDER BY id_fol DESC LIMIT 1");
            if($cekKodeJoin->num_rows() == 0){
                $kodeJoin = "JP1";
            } else {
                $ex = explode('P', $cekKodeJoin->row("kode_roll"));
                $num = intval($ex[1]) + 1;
                $kodeJoin = "JP".$num."";
            }
            $dtfol = [
                'kode_roll' => strtoupper($kodeJoin),
                'konstruksi' => strtoupper($kons),
                'ukuran' => round($ukuranJoin2,1),
                'jns_fold' => 'Finish',
                'tgl' => $tgl,
                'operator' => strtolower($username),
                'loc' => 'Pusatex',
                'posisi' => 'Pusatex',
                'joinss' => 'true',
                'joindfrom' => $kode,
                'jam_input' => $thistime,
                'shift' => '0'
            ];
            $this->data_model->saved('data_fol', $dtfol);
            echo json_encode(array("statusCode"=>200, "psn"=>"oke"));
        } else {
            $cekKodeJoin = $this->db->query("SELECT * FROM `data_fol` WHERE `kode_roll` LIKE '%JG%' AND `joinss`='true' ORDER BY `id_fol` DESC LIMIT 1");
            if($cekKodeJoin->num_rows() == 0){
                $kodeJoin = "JG1";
            } else {
                $ex = explode('G', $cekKodeJoin->row("kode_roll"));
                $num = intval($ex[1]) + 1;
                $kodeJoin = "JG".$num."";
            }
            $dtfol = [
                'kode_roll' => strtoupper($kodeJoin),
                'konstruksi' => strtoupper($kons),
                'ukuran' => round($ukuranJoin,1),
                'jns_fold' => 'Grey',
                'tgl' => $tgl,
                'operator' => strtolower($username),
                'loc' => 'Pusatex',
                'posisi' => 'Pusatex',
                'joinss' => 'true',
                'joindfrom' => $kode,
                'jam_input' => $thistime,
                'shift' => '0'
            ];
            $this->data_model->saved('data_fol', $dtfol);
            for($i=0; $i<$jml; $i++){
                $_kd = $exxr[$i];
                $this->db->query("DELETE FROM `data_igtujuan` WHERE `kode_roll` = '$_kd'");
            }
            echo json_encode(array("statusCode"=>200, "psn"=>"oke"));
        }
  } //end
  function loaddatanewPusatex(){
        echo "<tr><td><strong>NO</strong></td><td><strong>KODE ROLL</strong></td><td><strong>UKURAN</strong></td><td><strong>KONSTRUKSI</strong></td><td><strong>TUJUAN</strong></td><td></td></tr>";
        $qr = $this->db->query("SELECT * FROM data_igtujuan ORDER BY kode_roll");
        $no=1;
        foreach($qr->result() as $val){
            ?>
            <tr>
                <td><?=$no;?></td>
                <td><?=$val->kode_roll;?></td>
                <td><?=$val->ukuran;?></td>
                <td><?=$val->konstruksi;?></td>
                <td><?=$val->tujuan_proses;?></td>
                <td><a href="<?=base_url('Usersrjs/hapusbenerkan/'.$val->kode_roll);?>">Delete</a></td>
            </tr>
            <?php
            $no++;
        }
  }

}