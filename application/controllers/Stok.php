<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok extends CI_Controller
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

  function gudang(){
        $dep = $this->session->userdata('departement');
        if($dep=="Samatex"){$newDep = "newSamatex"; }
        if($dep=="RJS"){$newDep = "newRJS"; }
        if($dep=="Pusatex"){$newDep = "newPusatex"; }
        $data = array(
            'title' => 'Stok Gudang',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'sess_dep' => $this->session->userdata('departement'),
            'tbdata' => $this->db->query("SELECT * FROM data_stok WHERE dep='$newDep'"),
            'tbdata2' => $this->db->query("SELECT * FROM data_stok_lama_total")
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        if($dep=='Samatex'){
            $this->load->view('baru/stok_gudang', $data);
        } elseif ($dep=='RJS') {
            $this->load->view('baru/stok_gudang_rjs', $data);
        } elseif ($dep=='Pusatex') {
            $this->load->view('baru/stok_gudang_pst', $data);
        }
        
        $this->load->view('part/main_js_dttable');
  } //end


}
?>