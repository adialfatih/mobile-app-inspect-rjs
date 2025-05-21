<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller
{
  function __construct()
  {
      parent::__construct();
      $this->load->model('data_model');
      date_default_timezone_set("Asia/Jakarta");
      if($this->session->userdata('login_form') != "rindangjati_sess"){
        redirect(base_url('login'));
      }
      
  }
   
  function index(){ 
      $this->load->view('block');
  } //end

  function harian(){ 
     $depuser = $this->session->userdata('departement');
     $dep = $this->input->post('dep');
     $tgl = $this->input->post('datesr');
     $access = "false"; $pass="null";
     if($depuser==$dep){
        $access = "true";
     } else {
     if(empty($this->input->post('akspass'))){
        $access = "false";
     } else {
        $password = "Rjs123spinning*";
        if($this->input->post('akspass') == $password){
            $access = "true";
        } else {
            $access = "false";
            $pass = "salah";
        }
     }
     }
     $ex = explode(' - ', $tgl);
     $ex1 = explode('/', $ex[0]);
     $tgl_awal = $ex1[2]."-".$ex1[0]."-".$ex1[1];
     $ex2 = explode('/', $ex[1]);
     $tgl_akhir = $ex2[2]."-".$ex2[0]."-".$ex2[1];
     //echo "Departement : ".$dep."<br>";
     //echo "Tanggal Awal ".$tgl_awal."<br>";
     //echo "Tanggal Akhir ".$tgl_akhir."<br>";
     //$query = "SELECT * FROM report_produksi_harian WHERE lokasi_produksi = '$dep' AND waktu BETWEEN '$tgl_awal' AND '$tgl_akhir'";
     $qr = $this->db->query("SELECT * FROM data_produksi WHERE dep = '$dep' AND tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'");
     if($this->session->userdata('hak') == 'Manager'){
        if($access=="false"){
            $data = array(
                'title' => 'Report Produksi',
                'sess_nama' => $this->session->userdata('nama'),
                'sess_id' => $this->session->userdata('id'),
                'data_table' => $this->data_model->get_record('user'),
                'loti' => 'true',
                'dep' => $dep,
                'tgl' => $tgl,
                'pass' => $pass
            );
            $this->load->view('part/main_head', $data);
            $this->load->view('part/left_sidebar', $data);
            $this->load->view('new_page/report_produksi_lock', $data);
            $this->load->view('part/main_js_dttable');
        } else {
            $data = array(
                'title' => 'Report Produksi',
                'sess_nama' => $this->session->userdata('nama'),
                'sess_id' => $this->session->userdata('id'),
                'data_table' => $this->data_model->get_record('user'),
                'dep' => $dep,
                'tgl' => $tgl,
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir,
                'qrdata' => $qr
            );
            $this->load->view('part/main_head', $data);
            $this->load->view('part/left_sidebar', $data);
            $this->load->view('new_page/report_produksi', $data);
            $this->load->view('part/main_js_dttable');
        }
     } else {
        $this->load->view('blok_view');
     }
     
  } //end

  function mesin(){ 
    $depuser = $this->session->userdata('departement');
    $dep = $this->input->post('dep');
    $tgl = $this->input->post('datesr');
    $access = "false"; $pass="null";
    if($depuser==$dep){
       $access = "true";
    } else {
    if(empty($this->input->post('akspass'))){
       $access = "false";
    } else {
       $password = "Rjs123spinning*";
       if($this->input->post('akspass') == $password){
           $access = "true";
       } else {
           $access = "false";
           $pass = "salah";
       }
    }
    }
    $ex = explode(' - ', $tgl);
    $ex1 = explode('/', $ex[0]);
    $tgl_awal = $ex1[2]."-".$ex1[0]."-".$ex1[1];
    $ex2 = explode('/', $ex[1]);
    $tgl_akhir = $ex2[2]."-".$ex2[0]."-".$ex2[1];
    //echo "Departement : ".$dep."<br>";
    //echo "Tanggal Awal ".$tgl_awal."<br>";
    //echo "Tanggal Akhir ".$tgl_akhir."<br>";
    //$query = "SELECT * FROM report_produksi_harian WHERE lokasi_produksi = '$dep' AND waktu BETWEEN '$tgl_awal' AND '$tgl_akhir'";
    $qr = $this->db->query("SELECT * FROM dt_produksi_mesin WHERE lokasi = '$dep' AND tanggal_produksi BETWEEN '$tgl_awal' AND '$tgl_akhir'");
    if($this->session->userdata('hak') == 'Manager'){
       if($access=="false"){
           $data = array(
               'title' => 'Report Produksi Mesin',
               'sess_nama' => $this->session->userdata('nama'),
               'sess_id' => $this->session->userdata('id'),
               'data_table' => $this->data_model->get_record('user'),
               'loti' => 'true',
               'dep' => $dep,
               'tgl' => $tgl,
               'pass' => $pass
           );
           $this->load->view('part/main_head', $data);
           $this->load->view('part/left_sidebar', $data);
           $this->load->view('new_page/report_produksi_lock2', $data);
           $this->load->view('part/main_js_dttable');
       } else {
           $data = array(
               'title' => 'Report Produksi Mesin',
               'sess_nama' => $this->session->userdata('nama'),
               'sess_id' => $this->session->userdata('id'),
               'data_table' => $this->data_model->get_record('user'),
               'dep' => $dep,
               'tgl' => $tgl,
               'tgl_awal' => $tgl_awal,
               'tgl_akhir' => $tgl_akhir,
               'qrdata' => $qr
           );
           $this->load->view('part/main_head', $data);
           $this->load->view('part/left_sidebar', $data);
           $this->load->view('new_page/report_produksi_mesin', $data);
           $this->load->view('part/main_js_dttable');
       }
    } else {
       $this->load->view('blok_view');
    }

    
    
 } //end

function direksi(){
    $data = array(
        'title' => 'Welcome - Special Report',
        'sess_nama' => $this->session->userdata('nama'),
    );
    $this->load->view('part/main_head', $data);
    $this->load->view('part/left_sidebar2', $data);
    $this->load->view('beranda_view', $data);
    $this->load->view('part/main_js');
} //end

function dasboarddireksi(){
    $dep = $this->input->post('dep');
    $tgl = $this->input->post('datesr');
    if(!empty($dep) AND !empty($tgl)){
        $ex = explode(' - ', $tgl);
        $ex1 = explode('/', $ex[0]);
        $tgl_awal = $ex1[2]."-".$ex1[0]."-".$ex1[1];
        $ex2 = explode('/', $ex[1]);
        $tgl_akhir = $ex2[2]."-".$ex2[0]."-".$ex2[1];
        $tgl1 = $tgl_awal;
        $tgl2 = $tgl_akhir;
    } else {
        $dep = "null";
        $tgl1 = "null";
        $tgl2 = "null";
    }
    $data = array(
        'title' => 'Management Report',
        'sess_nama' => $this->session->userdata('nama'),
        'daterange' => 'true',
        'frmdep' => $dep,
        'frmtgl1' => $tgl1,
        'frmtgl2' => $tgl2
    );
    $this->load->view('part/main_head', $data);
    $this->load->view('part/left_sidebar2', $data);
    $this->load->view('new_page/direksi_report', $data);
    $this->load->view('part/main_js_dttable');
} //end

    function dashboardwa(){
        $data = array(
            'title' => 'Laporan-Harian-Produksi-',
            'sess_nama' => $this->session->userdata('nama'),
            'daterange' => 'true'
        );
        $this->load->view('part/main_head_toprint', $data);
        //$this->load->view('part/left_sidebar2', $data);
        $this->load->view('baru/laporan_wa', $data);
        $this->load->view('part/main_js_toprint', $data);
    } //end

    function dashboardwa2(){
        $data = array(
            'title' => 'Laporan-Harian-Produksi-dan-Penjualan-',
            'sess_nama' => $this->session->userdata('nama'),
            'daterange' => 'true'
        );
        $this->load->view('part/main_head_toprint', $data);
        //$this->load->view('part/left_sidebar2', $data);
        $this->load->view('baru/laporan_wa2', $data);
        $this->load->view('part/main_js_toprint', $data);
    } //end
    function inspect(){
        $uri = $this->uri->segment(3);
        $tgl1 = $this->uri->segment(4);
        $tgl2 = $this->uri->segment(5);
        $shift3 = $this->uri->segment(6);
        if($shift3 == "true"){
            $shift = "AND shift_op='31'";
        } else {
            $shift = "";
        }
        // echo $uri;
        // echo "<br> $tgl1";
        // echo "<br> $tgl2";
        if($uri == "grey"){
            $all = $this->db->query("SELECT * FROM data_ig WHERE tanggal BETWEEN '$tgl1' AND '$tgl2' $shift")->result();
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>No</th>";
            echo "<th>KODE ROLL</th>";
            echo "<th>KONSTRUKSI</th>";
            echo "<th>UKURAN</th>";
            echo "<th>JENIS</th>";
            echo "<th>TANGGAL</th>";
            echo "</tr>";
            $no=1;
            $total_ori_roll = "";
            $total_ori_jumlah = "";
            $total_bp_roll = "";
            $total_bp_jumlah = "";
            $total_b_roll = "";
            $total_b_jumlah = "";
            $total_c_roll = "";
            $total_c_jumlah = "";
            $total_aval_roll = "";
            $total_aval_jumlah = "";
            $total_null_roll = "";
            $total_null_jumlah = "";
            $kons = array();
            foreach($all as $val){
                $ukuran = floatval($val->ukuran_ori);
                if($ukuran > 0){
                    if($ukuran > 49){
                        $jenis = "ORI";
                        $total_ori_roll+=1;
                        $total_ori_jumlah+=$ukuran;
                    } else {
                        if($ukuran>=21 AND $ukuran<=49){
                            $jenis = "BP";
                            $total_bp_roll+=1;
                            $total_bp_jumlah+=$ukuran;
                        } elseif($ukuran>=11 AND $ukuran<=20){
                            $jenis = "Grade B";
                            $total_b_roll+=1;
                            $total_b_jumlah+=$ukuran;
                        } elseif($ukuran>=4 AND $ukuran<=10){
                            $jenis = "Grade C";
                            $total_c_roll+=1;
                            $total_c_jumlah+=$ukuran;
                        } else {
                            $jenis = "Aval";
                            $total_aval_roll+=1;
                            $total_aval_jumlah+=$ukuran;
                        }
                    }
                } else {
                    $jenis = "null";
                    $total_null_roll+=1;
                    $total_null_jumlah+=$ukuran;
                }
                echo "<tr>";
                echo "<td>".$no."</td>";
                echo "<td>".$val->kode_roll."</td>";
                echo "<td>".$val->konstruksi."</td>";
                echo "<td>".$val->ukuran_ori."</td>";
                echo "<td>$jenis</td>";
                echo "<td>".$val->tanggal."</td>";
                echo "</tr>";
                $_kons = strtoupper($val->konstruksi);
                if(in_array($_kons, $kons)){} else {
                    array_push($kons, $_kons);
                }
                $no++;
            }
            echo "<tr><td colspan='6'>Jumlah ORI ".$total_ori_roll." Roll (".$total_ori_jumlah." Meter) </td></tr>";
            echo "<tr><td colspan='6'>Jumlah BP ".$total_bp_roll." Roll (".$total_bp_jumlah." Meter)  </td></tr>";
            echo "<tr><td colspan='6'>Jumlah Grade B ".$total_b_roll." Roll (".$total_b_jumlah." Meter)  </td></tr>";
            echo "<tr><td colspan='6'>Jumlah Grade C ".$total_c_roll." Roll (".$total_c_jumlah." Meter)  </td></tr>";
            echo "<tr><td colspan='6'>Jumlah Aval ".$total_aval_roll." Roll (".$total_aval_jumlah." Meter)  </td></tr>";
            echo "<tr><td colspan='6'>Jumlah Null ".$total_null_roll." Roll (".$total_null_jumlah." Meter)  </td></tr>";
            echo "<tr><td colspan='6'>";
                    echo "<table border='1'>";
                    echo "<tr>";
                        echo "<th>KONSTRUKSI</th>";
                        echo "<th>JUMLAH ROLL</th>";
                        echo "<th>TOTAL METER</th>";
                        echo "<th>JUMLAH ORI</th>";
                        echo "<th>JUMLAH BP</th>";
                        echo "<th>JUMLAH GRADE B</th>";
                        echo "<th>JUMLAH GRADE C</th>";
                        echo "<th>JUMLAH AVAL</th>";
                    echo "</tr>";
                    foreach($kons as $k){
                        $_roll = $this->db->query("SELECT * FROM data_ig WHERE konstruksi='$k' AND ukuran_ori > 0 AND tanggal BETWEEN '$tgl1' AND '$tgl2' $shift")->num_rows();

                        $_rollmeter = $this->db->query("SELECT SUM(ukuran_ori) AS jml FROM data_ig WHERE konstruksi='$k' AND ukuran_ori > 0 AND tanggal BETWEEN '$tgl1' AND '$tgl2' $shift")->row("jml");

                        $_ori = $this->db->query("SELECT * FROM data_ig WHERE konstruksi='$k' AND ukuran_ori > 49 AND tanggal BETWEEN '$tgl1' AND '$tgl2' $shift")->num_rows();

                        $_orimETER = $this->db->query("SELECT SUM(ukuran_ori) AS jml FROM data_ig WHERE konstruksi='$k' AND ukuran_ori > 49 AND tanggal BETWEEN '$tgl1' AND '$tgl2' $shift")->row("jml");

                        $_bp = $this->db->query("SELECT * FROM data_ig WHERE konstruksi='$k' AND ukuran_ori > 20 AND ukuran_ori < 50 AND tanggal BETWEEN '$tgl1' AND '$tgl2' $shift")->num_rows();

                        $_bpMeter = $this->db->query("SELECT SUM(ukuran_ori) AS jml FROM data_ig WHERE konstruksi='$k' AND ukuran_ori > 20 AND ukuran_ori < 50 AND tanggal BETWEEN '$tgl1' AND '$tgl2' $shift")->row("jml");

                        $_b = $this->db->query("SELECT * FROM data_ig WHERE konstruksi='$k' AND ukuran_ori > 10 AND ukuran_ori < 21 AND tanggal BETWEEN '$tgl1' AND '$tgl2' $shift")->num_rows();

                        $_bMeter = $this->db->query("SELECT SUM(ukuran_ori) AS jml FROM data_ig WHERE konstruksi='$k' AND ukuran_ori > 10 AND ukuran_ori < 21 AND tanggal BETWEEN '$tgl1' AND '$tgl2' $shift")->row("jml");

                        $_c = $this->db->query("SELECT * FROM data_ig WHERE konstruksi='$k' AND ukuran_ori > 3 AND ukuran_ori < 11 AND tanggal BETWEEN '$tgl1' AND '$tgl2' $shift")->num_rows();

                        $_cMeter = $this->db->query("SELECT SUM(ukuran_ori) AS jml FROM data_ig WHERE konstruksi='$k' AND ukuran_ori > 3 AND ukuran_ori < 11 AND tanggal BETWEEN '$tgl1' AND '$tgl2' $shift")->row("jml");

                        $_aval = $this->db->query("SELECT * FROM data_ig WHERE konstruksi='$k' AND ukuran_ori > 0 AND ukuran_ori < 4 AND tanggal BETWEEN '$tgl1' AND '$tgl2' $shift")->num_rows();

                        $_avalMeter = $this->db->query("SELECT SUM(ukuran_ori) AS jml FROM data_ig WHERE konstruksi='$k' AND ukuran_ori > 0 AND ukuran_ori < 4 AND tanggal BETWEEN '$tgl1' AND '$tgl2' $shift")->row("jml");

                        echo "<tr>";
                        echo "<td>".$k."</td>";
                        echo "<td>".$_roll."</td>";
                        echo "<td>".$_rollmeter."</td>";
                        echo "<td>".$_orimETER."</td>";
                        //echo "<td>".$_ori."</td>";
                        echo "<td>".$_bpMeter."</td>";
                        echo "<td>".$_bMeter."</td>";
                        echo "<td>".$_cMeter."</td>";
                        echo "<td>".$_avalMeter."</td>";
                        echo "</tr>";
                    }
            echo "</td></tr>";
            echo "</table>";
        }
        if($uri == "finish"){
            $all = $this->db->query("SELECT * FROM data_if WHERE tgl_potong BETWEEN '$tgl1' AND '$tgl2' $shift")->result();
            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>No</th>";
            echo "<th>KODE ROLL</th>";
            echo "<th>KONSTRUKSI</th>";
            echo "<th>UKURAN</th>";
            echo "<th>JENIS</th>";
            echo "<th>TANGGAL</th>";
            echo "</tr>";
            $no=1;
            $total_ori_roll = "";
            $total_ori_jumlah = "";
            $total_bp_roll = "";
            $total_bp_jumlah = "";
            $total_b_roll = "";
            $total_b_jumlah = "";
            $total_c_roll = "";
            $total_c_jumlah = "";
            $total_aval_roll = "";
            $total_aval_jumlah = "";
            $total_null_roll = "";
            $total_null_jumlah = "";
            $kons = array();
            foreach($all as $val){
                $ukuran_meter = floatval($val->ukuran_ori);
                $ukuran = $ukuran_meter / 0.9144;
                if($ukuran > 0){
                    if($ukuran > 49){
                        $jenis = "ORI";
                        $total_ori_roll+=1;
                        $total_ori_jumlah+=$ukuran;
                    } else {
                        if($ukuran>=21 AND $ukuran<=49){
                            $jenis = "BP";
                            $total_bp_roll+=1;
                            $total_bp_jumlah+=$ukuran;
                        } elseif($ukuran>=11 AND $ukuran<=20){
                            $jenis = "Grade B";
                            $total_b_roll+=1;
                            $total_b_jumlah+=$ukuran;
                        } elseif($ukuran>=4 AND $ukuran<=10){
                            $jenis = "Grade C";
                            $total_c_roll+=1;
                            $total_c_jumlah+=$ukuran;
                        } else {
                            $jenis = "Aval";
                            $total_aval_roll+=1;
                            $total_aval_jumlah+=$ukuran;
                        }
                    }
                } else {
                    $jenis = "null";
                    $total_null_roll+=1;
                    $total_null_jumlah+=$ukuran;
                }
                echo "<tr>";
                echo "<td>".$no."</td>";
                echo "<td>".$val->kode_roll."</td>";
                echo "<td>".$val->konstruksi."</td>";
                echo "<td>".$ukuran."</td>";
                echo "<td>$jenis</td>";
                echo "<td>".$val->tgl_potong."</td>";
                echo "</tr>";
                $_kons = strtoupper($val->konstruksi);
                if(in_array($_kons, $kons)){} else {
                    array_push($kons, $_kons);
                }
                $no++;
            }
            echo "<tr><td colspan='6'>Jumlah ORI ".$total_ori_roll." Roll (".$total_ori_jumlah." Meter) </td></tr>";
            echo "<tr><td colspan='6'>Jumlah BP ".$total_bp_roll." Roll (".$total_bp_jumlah." Meter)  </td></tr>";
            echo "<tr><td colspan='6'>Jumlah Grade B ".$total_b_roll." Roll (".$total_b_jumlah." Meter)  </td></tr>";
            echo "<tr><td colspan='6'>Jumlah Grade C ".$total_c_roll." Roll (".$total_c_jumlah." Meter)  </td></tr>";
            echo "<tr><td colspan='6'>Jumlah Aval ".$total_aval_roll." Roll (".$total_aval_jumlah." Meter)  </td></tr>";
            echo "<tr><td colspan='6'>Jumlah Null ".$total_null_roll." Roll (".$total_null_jumlah." Meter)  </td></tr>";
            echo "<tr><td colspan='6'>";
                    echo "<table border='1'>";
                    echo "<tr>";
                        echo "<th>KONSTRUKSI</th>";
                        echo "<th>JUMLAH ROLL</th>";
                        echo "<th>TOTAL METER</th>";
                        echo "<th>JUMLAH ORI</th>";
                        echo "<th>JUMLAH BP</th>";
                        echo "<th>JUMLAH GRADE B</th>";
                        echo "<th>JUMLAH GRADE C</th>";
                        echo "<th>JUMLAH AVAL</th>";
                    echo "</tr>";
                    foreach($kons as $k){
                        $_roll = $this->db->query("SELECT * FROM data_if WHERE konstruksi='$k' AND ukuran_ori > 0 AND tgl_potong BETWEEN '$tgl1' AND '$tgl2' $shift")->num_rows();

                        $_rollmeter = $this->db->query("SELECT SUM(ukuran_ori) AS jml FROM data_if WHERE konstruksi='$k' AND ukuran_ori > 0 AND tgl_potong BETWEEN '$tgl1' AND '$tgl2' $shift")->row("jml");

                        $_ori = $this->db->query("SELECT * FROM data_if WHERE konstruksi='$k' AND ukuran_ori > 44.80 AND tgl_potong BETWEEN '$tgl1' AND '$tgl2' $shift")->num_rows();

                        $_orimETER = $this->db->query("SELECT SUM(ukuran_ori) AS jml FROM data_if WHERE konstruksi='$k' AND ukuran_ori > 44.80 AND tgl_potong BETWEEN '$tgl1' AND '$tgl2' $shift")->row("jml");

                        $_bp = $this->db->query("SELECT * FROM data_if WHERE konstruksi='$k' AND ukuran_ori > 18.28 AND ukuran_ori < 45.72 AND tgl_potong BETWEEN '$tgl1' AND '$tgl2' $shift")->num_rows();

                        $_bpMeter = $this->db->query("SELECT SUM(ukuran_ori) AS jml FROM data_if WHERE konstruksi='$k' AND ukuran_ori > 18.28 AND ukuran_ori < 45.72 AND tgl_potong BETWEEN '$tgl1' AND '$tgl2' $shift")->row("jml");

                        $_b = $this->db->query("SELECT * FROM data_if WHERE konstruksi='$k' AND ukuran_ori > 9.14 AND ukuran_ori < 19.20 AND tgl_potong BETWEEN '$tgl1' AND '$tgl2' $shift")->num_rows();

                        $_bMeter = $this->db->query("SELECT SUM(ukuran_ori) AS jml FROM data_if WHERE konstruksi='$k' AND ukuran_ori > 9.14 AND ukuran_ori < 19.20 AND tgl_potong BETWEEN '$tgl1' AND '$tgl2' $shift")->row("jml");

                        $_c = $this->db->query("SELECT * FROM data_if WHERE konstruksi='$k' AND ukuran_ori > 2.74 AND ukuran_ori < 10.05 AND tgl_potong BETWEEN '$tgl1' AND '$tgl2' $shift")->num_rows();

                        $_cMeter = $this->db->query("SELECT SUM(ukuran_ori) AS jml FROM data_if WHERE konstruksi='$k' AND ukuran_ori > 2.74 AND ukuran_ori < 10.05 AND tgl_potong BETWEEN '$tgl1' AND '$tgl2' $shift")->row("jml");

                        $_aval = $this->db->query("SELECT * FROM data_if WHERE konstruksi='$k' AND ukuran_ori > 0 AND ukuran_ori < 3.65 AND tgl_potong BETWEEN '$tgl1' AND '$tgl2' $shift")->num_rows();

                        $_avalMeter = $this->db->query("SELECT SUM(ukuran_ori) AS jml FROM data_if WHERE konstruksi='$k' AND ukuran_ori > 0 AND ukuran_ori < 3.65 AND tgl_potong BETWEEN '$tgl1' AND '$tgl2' $shift")->row("jml");

                        echo "<tr>";
                        echo "<td>".$k."</td>";
                        echo "<td>".$_roll."</td>";
                        echo "<td>".$_rollmeter."</td>";
                        echo "<td>".$_orimETER."</td>";
                        //echo "<td>".$_ori."</td>";
                        echo "<td>".$_bpMeter."</td>";
                        echo "<td>".$_bMeter."</td>";
                        echo "<td>".$_cMeter."</td>";
                        echo "<td>".$_avalMeter."</td>";
                        echo "</tr>";
                    }
            echo "</td></tr>";
            echo "</table>";
        }
    }

}