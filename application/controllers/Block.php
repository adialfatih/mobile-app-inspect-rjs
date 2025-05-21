<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Block extends CI_Controller
{
  function __construct()
  {
      parent::__construct();
   //    $this->load->model('data_model');
   //    if($this->session->userdata('status') != "login"){
			// redirect(base_url("auth_login"));
	    //}
  }
   
  function index(){
      $this->load->view('blok_view');
  }
   
   function logopt(){
       $this->load->model('data_model');
       $jns = $this->uri->segment(3);
       $nama = $this->uri->segment(4);
       $tgl = $this->uri->segment(5);
       if($jns == "if"){
           if($nama=="kusnita") { $nama = "kusnita2"; }
           $db = $this->data_model->get_byid('data_if',['tgl_potong'=>$tgl,'operator'=>$nama]);
           $no = 1;
           $ar = array();
           ?>
           <table border="1">
               <tr>
                   <th>No</th>
                   <th>Nama</th>
                   <th>Waktu</th>
                   <th>Kode Roll</th>
                   <th>Konstruksi</th>
                   <th>Ukuran Input (Meter)</th>
                   <th>Ukuran Konversi (Yard)</th>
               </tr>
           
           <?php
           $ttlm=0; $ttly=0;
           foreach($db->result() as $val){
               $kons = strtoupper($val->konstruksi);
               $mtr  = $val->ukuran_ori;
               $yrd  = $mtr / 0.9144;
               $yrd  = round($yrd, 1);
               if(in_array($kons, $ar)){}else{$ar[]=$kons;}
               $ttlm+=$mtr;
               $ttly+=$yrd;
               echo "<tr>";
               echo "<td>".$no."</td>";
               echo "<td>".$val->operator."</td>";
               echo "<td>".$val->jam_input."</td>";
               echo "<td>".$val->kode_roll."</td>";
               echo "<td>".$kons."</td>";
               echo "<td>".$mtr." Meter </td>";
               echo "<td>".$yrd." Yard</td>";
               echo "</tr>";
               $no++;
           }
           echo "<tr>";
           echo "<td colspan='5'>Total</td>";
           echo "<td>".number_format($ttlm,0,'.',',')." Meter</td>";
           echo "<td>".number_format($ttly,1,'.',',')." Yard</td>";
           echo "</tr>";
       } else {
           if($jns=="fol"){
               $db = $this->db->query("SELECT *  FROM `data_fol` WHERE `tgl` = '$tgl' AND `operator` = '$nama' AND shift!='31' ORDER BY id_fol ASC");
               $no = 1;
               $ar = array();
               $shift = "";
               ?>
               <table border="1">
                   <tr>
                       <th>No</th>
                       <th>Nama</th>
                       <th>Shift</th>
                       <th>Waktu</th>
                       <th>Kode Roll</th>
                       <th>Konstruksi</th>
                       <th>Ukuran Fol Grey (Meter)</th>
                       <th>Ukuran Fol Finish (Yard)</th>
                   </tr>
               
               <?php
               $ttlm=0; $ttly=0;
               foreach($db->result() as $val){
                   $kons = strtoupper($val->konstruksi);
                   $roll = strtoupper(str_replace(' ', '', $val->kode_roll));
                    if (strpos($roll, 'JP') !== false) {
                        $jam_input = "-";
                    } else {
                        $jam_input = $val->jam_input;
                    }
                   $mtr  = $val->ukuran;
                   $yrd  = $mtr / 0.9144;
                   $yrd  = round($yrd, 1);
                   if(in_array($kons, $ar)){}else{$ar[]=$kons;}
                   if($val->shift != 'nu'){ $shift = $val->shift; }
                   echo "<tr>";
                   echo "<td>".$no."</td>";
                   echo "<td>".$val->operator."</td>";
                   echo "<td>".$shift."</td>";
                   echo "<td>".$jam_input."</td>";
                   echo "<td>".$roll."</td>";
                   echo "<td>".$kons."</td>";
                   if($val->jns_fold == "Finish"){
                       echo "<td></td>";
                       echo "<td>".$yrd." Yard</td>";
                       $ttly+=$yrd;
                   } else {
                       echo "<td>".$mtr." Meter </td>";
                       echo "<td></td>";
                       $ttlm+=$mtr;
                   }
                   echo "</tr>";
                   $no++;
               }
               if($shift == "3"){
                   $tgl_besok = date('Y-m-d', strtotime($tgl . ' +1 day'));
                   $db2 = $this->db->query("SELECT *  FROM `data_fol` WHERE `tgl` = '$tgl_besok' AND `operator` = '$nama' AND `shift`='31' ORDER BY id_fol ASC");
                   foreach($db2->result() as $val){
                       $kons = strtoupper($val->konstruksi);
                       $roll = strtoupper(str_replace(' ', '', $val->kode_roll));
                        if (strpos($roll, 'JP') !== false) {
                            $jam_input = "-";
                        } else {
                            $jam_input = $val->jam_input;
                        }
                       $mtr  = $val->ukuran;
                       $yrd  = $mtr / 0.9144;
                       $yrd  = round($yrd, 1);
                       if(in_array($kons, $ar)){}else{$ar[]=$kons;}
                       if($val->shift != 'nu'){ 
                           if($val->shift == "31"){
                               $shift = "3"; 
                           }
                       }
                       echo "<tr>";
                       echo "<td>".$no."</td>";
                       echo "<td>".$val->operator."</td>";
                       echo "<td>".$shift."</td>";
                       echo "<td>".$jam_input."</td>";
                       echo "<td>".$roll."</td>";
                       echo "<td>".$kons."</td>";
                       if($val->jns_fold == "Finish"){
                           echo "<td></td>";
                           echo "<td>".$yrd." Yard</td>";
                           $ttly+=$yrd;
                       } else {
                           echo "<td>".$mtr." Meter </td>";
                           echo "<td></td>";
                           $ttlm+=$mtr;
                       }
                       echo "</tr>";
                       $no++;
                   }
               }
               echo "<tr>";
               echo "<td colspan='6'>Total</td>";
               echo "<td>".number_format($ttlm,0,'.',',')." Meter</td>";
               echo "<td>".number_format($ttly,1,'.',',')." Yard</td>";
               echo "</tr>";
               //end of tampilan folding
           } else {
               echo "Token Error...!";
           }
       }
   }
}
?>