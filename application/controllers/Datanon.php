<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datanon extends CI_Controller
{
    function __construct()
    {
            parent::__construct();
            $this->load->model('data_model');
            date_default_timezone_set("Asia/Jakarta");
    }
    
    function index(){ 
        $this->load->view('block');
    } //end

    function pertama(){
        ?>
        <h3>Menampilkan Data di Gudang Pusatex : <br></h3>
        <a href="<?=base_url('data-non-ori/bp');?>">Data BP</a><br>
        <a href="<?=base_url('data-non-ori/bc');?>">Data BC</a><br>
        <a href="<?=base_url('data-non-ori/aval');?>">Data Aval</a>
        <?php
    }

    function kedua(){
        $this->load->view('data_nonori/bp_view');
    }
    function ketiga(){
        $this->load->view('data_nonori/bc_view');
    }

}