<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Input extends CI_Controller
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

  function produksi(){ 
      $url = $this->uri->segment(3);
      //echo $url;
      $dep = $this->session->userdata('departement');
      $data = array(
        'title' => 'Data Produksi',
        'sess_nama' => $this->session->userdata('nama'),
        'sess_id' => $this->session->userdata('id'),
        'dtkons2' => $this->db->query("SELECT * FROM data_produksi WHERE dep='$dep' AND tgl='$url'"),
        'uri_tgl' => $url,
        'depuser' => $dep,
        'tgl' => $url
      );
      $this->load->view('part/main_head', $data);
      $this->load->view('part/left_sidebar', $data);
      $this->load->view('new_page/new_input_produksi2', $data);
      $this->load->view('part/main_js_dttable');
  } //end


}
?>