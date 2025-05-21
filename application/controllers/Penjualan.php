<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends CI_Controller
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
      echo "Token erorr..";
  } //end

  function id(){
        $id = $this->uri->segment(3);
        $hak = $this->session->userdata('hak');
        $dep = $this->session->userdata('departement');
        $cek_id = $this->data_model->get_byid('v_penjualan', ['sha1(id_penjualan)'=>$id]);
        if($cek_id->num_rows() == 1){
            $data = array(
                'title' => 'Data Penjualan',
                'sess_nama' => $this->session->userdata('nama'),
                'sess_id' => $this->session->userdata('id'),
                'nomor' => $cek_id->row("id_penjualan"),
                'dt_all' => $cek_id->row_array(),
                'dep_user' => $dep,
                'kons' => $this->data_model->get_record('dt_konsumen'),
                'dt_terjual' => $this->data_model->sort_record('id_penjualan', 'tb_penjualan')
            );
            $this->load->view('part/main_head', $data);
            $this->load->view('part/left_sidebar', $data);
            $this->load->view('page/data_penjualan', $data);
            $this->load->view('part/main_js_dttable');
        } else {
            $this->session->set_flashdata('gagal', 'Token tidak ditemukan / kadaluarsa.');
            redirect(base_url('input-penjualan'));
        }
  } //end 

  function kd(){
    $id = $this->uri->segment(3);
    $hak = $this->session->userdata('hak');
    $dep = $this->session->userdata('departement');
    $cek_id = $this->data_model->get_byid('v_penjualan', ['sha1(id_penjualan)'=>$id]);
    if($cek_id->num_rows() == 1){
        $data = array(
            'title' => 'Data Penjualan',
            'sess_nama' => $this->session->userdata('nama'),
            'sess_id' => $this->session->userdata('id'),
            'nomor' => $cek_id->row("id_penjualan"),
            'dt_all' => $cek_id->row_array(),
            'dep_user' => $dep,
            'kons' => $this->data_model->get_record('dt_konsumen'),
            'dt_terjual' => $this->data_model->sort_record('id_penjualan', 'tb_penjualan')
        );
        $this->load->view('part/main_head', $data);
        $this->load->view('part/left_sidebar', $data);
        $this->load->view('page/data_penjualan2', $data);
        $this->load->view('part/main_js_dttable');
    } else {
        $this->session->set_flashdata('gagal', 'Token tidak ditemukan / kadaluarsa.');
        redirect(base_url('input-penjualan'));
    }
} //end 

}