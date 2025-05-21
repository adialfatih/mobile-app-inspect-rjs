<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alldashboard extends CI_Controller
{
  function __construct()
  {
      parent::__construct();
      $this->load->model('data_model');
      date_default_timezone_set("Asia/Jakarta");
           
  }
   
  function index(){ 
      $this->load->view('manager/logindashboard');
  } //end

  function proseslogin(){
        $username = $this->data_model->clean($this->input->post('username'));
        $password = $this->input->post('password');
        if($username!="" AND $password!=""){
            $ceklogin = $this->data_model->get_byid('user', ['username'=>$username,'password'=>sha1($password),'hak_akses'=>'Manager']);
            if($ceklogin->num_rows() == 1){
                $dt = $ceklogin->row_array();
                $data_session = array(
                    'nama'  => $dt['nama_user'],
                    'username'=> $dt['username'],
                    'password' => $dt['password'],
                    'hak'     => $dt['hak_akses'],
                    'departement' => $dt['departement'],
                    'mng_dash'=> 'manager_dash'
                );
                $this->session->set_userdata($data_session);
                redirect(base_url('dash-manager'));
            } else {
                echo "Username dan Password anda tidak cocok.";
            }
        } else {
            echo "Anda harus mengisi username dan password.";
        }
  } //end

  function halamanutama(){
        if($this->session->userdata('mng_dash') == "manager_dash"){
            $this->load->view('manager/showdashboard');
        } else {
            echo "<div style='width:100px;height:100vh;display:flex;justify-content:center;align-items:center;'>Akses diblokir</div>";
        }
  } //end

  function penjualangrey(){
        $this->load->view('manager/penjualanGrey');
  } //end

  function penjualanfinish(){
        $this->load->view('manager/penjualanFinish');
  } //end
    
}
?>