<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller
{
  function __construct()
  {
      parent::__construct();
      $this->load->model('data_model');
      if($this->session->userdata('login_form') != "rindangjati_sess"){
        redirect(base_url('login'));
      }
  }
   
  function index(){ 
      $data = array(
          'title' => 'Welcome - PPC Weaving',
          'sess_nama' => $this->session->userdata('nama'),
      );
      $this->load->view('part/main_head', $data);
      $this->load->view('part/left_sidebar', $data);
      $this->load->view('beranda_view', $data);
      $this->load->view('part/main_js');
  } //end

  function managerdashboard(){
        $hak_akses = $this->session->userdata('hak');
        if($hak_akses == "Manager"){
            $data = array(
                'title' => 'Welcome Manager - PPC Weaving',
                'sess_nama' => $this->session->userdata('nama'),
                'sess_hak' => $this->session->userdata('hak')
            );
            $this->load->view('part/main_head', $data);
            $this->load->view('part/left_sidebar2', $data);
            $this->load->view('beranda_view', $data);
            $this->load->view('part/main_js');
        } else {
            $this->load->view('block');
        }   
  }
  function rekappiutang(){
    $hak_akses = $this->session->userdata('hak');
    if($hak_akses == "Manager"){
        $data = array(
            'title' => 'Rekap Penjualan',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_hak' => $this->session->userdata('hak'),
            'qrdata' => $this->db->query("SELECT * FROM a_nota WHERE no_sj NOT LIKE '%SLD%' ORDER BY tgl_nota DESC"),
            'qrdata_txt' => "SELECT * FROM a_nota WHERE no_sj NOT LIKE '%SLD%' ORDER BY tgl_nota DESC",
            'daterange' => 'true',
            'tanggalRange' => 'none'
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar2', $data);
        $this->load->view('manager/rekap_piutang', $data);
        $this->load->view('part/main_js_dttable');
    } else {
        $this->load->view('block');
    }   
  } //end

  function rekappenjualan(){
    $rangetgl = $this->input->post('datesr');
    $ex = explode(' - ', $rangetgl);
    $tgl1 = explode('/', $ex[0]);
    $formatTgl1 = $tgl1[2]."-".$tgl1[0]."-".$tgl1[1];
    $tgl2 = explode('/', $ex[1]);
    $formatTgl2 = $tgl2[2]."-".$tgl2[0]."-".$tgl2[1];
    $hak_akses = $this->session->userdata('hak');
    $txt = "SELECT * FROM a_nota WHERE no_sj NOT LIKE '%SLD%' AND tgl_nota BETWEEN '$formatTgl1' AND '$formatTgl2' ORDER BY tgl_nota ASC";
    if($hak_akses == "Manager"){
        $data = array(
            'title' => 'Rekap Penjualan',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_hak' => $this->session->userdata('hak'),
            'qrdata' => $this->db->query("SELECT * FROM a_nota WHERE no_sj NOT LIKE '%SLD%' AND tgl_nota BETWEEN '$formatTgl1' AND '$formatTgl2' ORDER BY tgl_nota ASC"),
            'qrdata_txt' => $txt,
            'daterange' => 'true',
            'tanggalRange' => 'yes',
            'tanggal1' => $formatTgl1,
            'tanggal2' => $formatTgl2
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar2', $data);
        $this->load->view('manager/rekap_piutang', $data);
        $this->load->view('part/main_js_dttable');
    } else {
        $this->load->view('block');
    }   
  } //end

  function saldopiutang(){
    $hak_akses = $this->session->userdata('hak');
    if($hak_akses == "Manager"){
        $data = array(
            'title' => 'Saldo Piutang',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_hak' => $this->session->userdata('hak')
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar2', $data);
        $this->load->view('manager/saldo_piutang2kolom', $data);
        $this->load->view('part/main_js_dttable3');
    } else {
        $this->load->view('block');
    }   
  } //end

  function dsbmng(){ 
    $data = array(
        'title' => 'Manager Dashboard - PPC Weaving',
        'sess_nama' => $this->session->userdata('nama'),
    );
    $this->load->view('part/main_head', $data);
    $this->load->view('part/left_sidebar', $data);
    $this->load->view('beranda_view2', $data);
    $this->load->view('part/main_js');
} //end

    function dsbopt(){ 
        $data = array(
            'title' => 'Operator Dashboard - PPC Weaving',
            'sess_nama' => $this->session->userdata('nama'),
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('beranda_view2', $data);
        $this->load->view('part/main_js');
    } //end

    function generatekode(){ 
        $nomore = $this->uri->segment(2);
        if($nomore==""){ $n=0; } else { $n=$nomore; }
        $data = array(
            'title' => 'Generate Kode',
            'sess_nama' => $this->session->userdata('nama'),
            'loc' => $this->session->userdata('departement'),
            'nomor' => $n
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('new_page/generate_kode', $data);
        $this->load->view('part/main_js');
        //echo 'Sistem generate kode sedang diperbaiki';
    } //end

    function pkglist(){ 
        $dep = $this->session->userdata('departement');
        //$cennotif = $this->data_model->get_byid('new_tb_trackpaket', ['kirim_ke'=>$dep,'verf_penerima'=>'n']);
        $data = array(
            'title' => 'Data Packaging List',
            'sess_nama' => $this->session->userdata('nama'),
            'loc' => $this->session->userdata('departement'),
            'notif' => 0,
            'dep' => $dep,
            'dt_list' => $this->db->query("SELECT * FROM new_tb_packinglist WHERE lokasi_now='$dep' ORDER BY id_kdlist DESC")
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('new_page/packaging_list_data', $data);
        $this->load->view('part/main_js_dttable');
    } //end

    function pkg_pengiriman(){
        $dep = $this->session->userdata('departement');
        $data = array(
            'title' => 'Data Pengiriman Packaging List',
            'sess_nama' => $this->session->userdata('nama'),
            'loc' => $this->session->userdata('departement'),
            'dt_list' => $this->db->query("SELECT * FROM new_tb_trackpaket WHERE kirim_dari='$dep' OR kirim_ke='$dep' ORDER BY id_pengiriman DESC")
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('new_page/packaging_list_data_pengiriman', $data);
        $this->load->view('part/main_js_dttable');
    } //end

    function chTanggal(){
        $kd = $this->input->post('kd');
        $tgl = $this->input->post('tgl');
        $this->data_model->updatedata('kd',$kd,'new_tb_packinglist',['tanggal_dibuat'=>$tgl]);
        redirect(base_url('packing-list'));
    }

    
}
?>