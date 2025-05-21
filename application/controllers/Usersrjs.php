<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usersrjs extends CI_Controller
{
    function __construct()
    {
      parent::__construct();
      $this->load->model('data_model');
     // $this->load->library('curl');
      date_default_timezone_set("Asia/Jakarta");
    //   if($this->session->userdata('login_form') != "rindangjati_sess"){
	// 	  redirect(base_url("login"));
	//   }
    }
   
  function index(){
        $this->load->view('users/loginrjs');
  } //end
  function databs(){
        $this->load->view('users/databcbs');
  } //end
  function benerkan(){
        $this->load->view('users/benake_kode.php');
  }
  function hapusbenerkan(){
        $id = $this->uri->segment(3);
        $this->db->query("DELETE FROM data_igtujuan WHERE kode_roll='$id'");
        redirect(base_url('usersrjs/benerkan'));
  }
  function simpanbener(){
        $testing = $this->input->post('testing');
        $totujuan = $this->input->post('totujuan');
        $x = explode(',', $testing);
        for ($i=0; $i <count($x) ; $i++) { 
            //echo $x[$i]." - $totujuan <br>";
            $rows2 = $this->data_model->get_byid('kiriman_pusatex',['kode_roll'=>$x[$i] ]);
            $rows = $rows2->row_array();
            $_kdrol = $rows['kode_roll'];
            $_ukr = $rows['ukuran'];
            $_kons = $rows['konstruksi'];
            if($totujuan=="auto"){
                $_tuj = $rows['tujuan_proses'];
            } else{
                $_tuj = $totujuan;
            }
            if($rows2->num_rows() == 1){
            $this->data_model->saved('data_igtujuan',[
                'kode_roll'=>$_kdrol,
                'konstruksi'=>$_kons,
                'ukuran'=>$_ukr,
                'tujuan_proses'=>$_tuj
            ]);
            } else {
                //$x[$i] = "tidak ada";
                echo $x[$i]." tidak ditemukan";
            }
        }
        //redirect(base_url('usersrjs/benerkan'));
  }
  function delinsgrey(){
      $id = $this->input->post('iddata');
      $this->db->query("DELETE FROM data_ig WHERE id_data='$id'");
      echo json_encode(array("statusCode"=>200, "psn"=>"oke"));
  }
  function upstok(){
        $this->load->view('users/upstokrjs');
  }
  
  function insgrey(){
        $this->load->view('users/insgreyrjs');
  }
    function insfinish(){
        $this->load->view('users/insfinish');
    }
    function ininsfinish(){
        $this->load->view('users/insfinish_before');
    }
    function folding(){
        $this->load->view('users/folding');
    }
    function penjualan(){
        $this->load->view('users/kirimpscus');
    }
  function terimabarang(){
        $this->load->view('users/terima_barang');
  }
  
  function createkirimpst(){
    $this->load->view('users/createkirimpstrjsrjs');
  }
  function createkirimpstbc(){
    $this->load->view('users/createkirimpstrjsrjsBC');
  }
  function createkirimpst2(){
    $this->load->view('users/createkirimpstrjsrjs2');
  }
    function kirimpst(){
      $this->load->view('users/kirimpstrjs');
  }
  function simpanupdate(){
        $kode = $this->input->post('kode');
        $mc = $this->input->post('mc');
        $beam = $this->input->post('beam');
        $oka = $this->input->post('oka');
        $ori = $this->input->post('ori');
        $bs = $this->input->post('bs');
        $bp = $this->input->post('bp');
        $konst = $this->input->post('konst');
        if($kode!="" AND $mc!="" AND $beam!="" AND $oka!="" AND $ori!="" AND $bs!="" AND $bp!=""){
            $this->data_model->updatedata('kode_roll',$kode,'data_ig', [
                'konstruksi' => strtoupper($konst),
                'no_mesin' => $mc,
                'no_beam' => $beam,
                'oka' => $oka,
                'ukuran_ori' => $ori,
                'ukuran_bs' => $bs,
                'ukuran_bp' => $bp
            ]);
            echo "<div style='width:100%;display:flex;justify-content:center;align-items:center;margin-top:100px;color:green;font-weight:bold;'>Berhasil Menyimpan Update Kode Roll ".$kode."</div>";
        } else {
            echo "<div style='width:100%;display:flex;justify-content:center;align-items:center;margin-top:100px;'>Anda tidak mengisi semua data dengan benar</div>";
        }
  }
  function cekkodestokrjs(){
        $kode = $this->input->post('kode');
        $cekkode = $this->data_model->get_byid('data_ig', ['kode_roll'=>$kode]);
        if($cekkode->num_rows() == 0){
            echo "<div style='width:100%;display:flex;justify-content:center;align-items:center;margin-top:100px;'>Kode&nbsp;<font style='color:red;font-weight:bold;'>".$kode."</font>&nbsp;tidak ditemukan</div>";
        } elseif($cekkode->num_rows() == 1) {
            $n = $cekkode->row_array();
            ?>
            <div class="form-label">
                <label for="konst">Konstruksi</label>
                <input type="text" id="konst" value="<?=$n['konstruksi'];?>">
            </div>
            <div class="form-label">
                <label for="nomesin">No Mesin</label>
                <input type="text" id="nomesin" value="<?=$n['no_mesin'];?>" >
            </div>
            <div class="form-label">
                <label for="nobeam">No Beam</label>
                <input type="text" id="nobeam" value="<?=$n['no_beam'];?>">
            </div>
            <div class="form-label">
                <label for="oka">OK</label>
                <input type="text" id="oka" value="<?=$n['oka'];?>" inputmode="numeric">
            </div>
            <div class="form-label">
                <label for="ori">Ukuran Ori</label>
                <input type="text" id="ori" value="<?=$n['ukuran_ori'];?>" inputmode="numeric">
            </div>
            <div class="form-label">
                <label for="oribs">Ukuran BS</label>
                <input type="text" id="oribs" value="<?=$n['ukuran_bs'];?>" inputmode="numeric">
            </div>
            <div class="form-label">
                <label for="bp">Ukuran BP</label>
                <input type="text" id="bp" value="<?=$n['ukuran_bp'];?>" inputmode="numeric">
            </div>
            <button style="width:100%;background:#2088e8;outline:none;border:none;color:#fff;padding:10px 15px;border-radius:4px;" onclick="btnCarisave()">Simpan Perubahan</button>
            <button style="width:100%;background:red;margin-top:15px;outline:none;border:none;color:#fff;padding:10px 15px;border-radius:4px;" onclick="btnCaridel('<?=$n['kode_roll'];?>')">Hapus Roll</button>
            <?php
        } else {
            echo "<div style='width:100%;display:flex;justify-content:center;align-items:center;margin-top:100px;'>Doble Kode&nbsp;<font style='color:red;font-weight:bold;'>".$kode."</font>&nbsp;hubungi developer</div>";
        }
  }
  function delkoderolls(){
        $kode = $this->input->post('kode');
        $this->db->query("DELETE FROM data_ig WHERE kode_roll='$kode'");
        echo "<div style='width:100%;display:flex;justify-content:center;align-items:center;margin-top:100px;'>Kode&nbsp;<font style='color:red;font-weight:bold;'>".$kode."</font>&nbsp;Telah Dihapus</div>";
  }
  function cekopt(){
      $proses = $this->input->post('proses');
      $namaUser = $this->input->post('namaUser');
      $pinUser = $this->input->post('pinUser');
      $kecilkan_user = strtolower($namaUser);
      $cek_user = $this->data_model->get_byid('a_operator', ['username'=>$kecilkan_user, 'pinuser'=>$pinUser]);
      if($cek_user->num_rows() == 1){
          //$proses_user = $cek_user->row("produksi");
          echo json_encode(array("statusCode"=>200, "psn"=>"oke"));
      } else {
          echo json_encode(array("statusCode"=>404, "psn"=>"Username / PIN Salah"));
      }
      
  } //end
  
  function loaddata(){
      $proses = $this->input->post('proses');
      $username = $this->input->post('username');
      $username = strtolower($username);
      $tgl = date('Y-m-d');
      
      if($proses == "insgrey"){
            $currentTime = date('H:i');
            $tgl_kemarin = date('Y-m-d', strtotime($tgl . ' -1 day'));
            
          //$query = $this->data_model->get_byid('data_ig', ['tanggal'=>$tgl, 'operator'=>$username]);
            if (strtotime($currentTime) >= strtotime('00:00') && strtotime($currentTime) < strtotime('06:00')) { 
                //$query = $this->data_model->get_byid('data_ig', ['tanggal'=>$tgl_kemarin,'operator'=>$username,'shift_op'=>'3']);
                //$query2 = $this->data_model->get_byid('data_ig', ['tanggal'=>$tgl,'operator'=>$username,'shift_op'=>'31']);
                $query = $this->db->query("SELECT * FROM data_ig WHERE tanggal='$tgl_kemarin' AND operator='$username' AND shift_op='3' ORDER BY id_data DESC");
                $query2 = $this->db->query("SELECT * FROM data_ig WHERE tanggal='$tgl' AND operator='$username' AND shift_op='31' ORDER BY id_data DESC");
            } elseif(strtotime($currentTime) >= strtotime('22:00') && strtotime($currentTime) < strtotime('23:59')) {
                //$query = $this->data_model->get_byid('data_ig', ['tanggal'=>$tgl,'operator'=>$username,'shift_op'=>'3']);
                $query = $this->db->query("SELECT * FROM data_ig WHERE tanggal='$tgl' AND operator='$username' AND shift_op='3' ORDER BY id_data DESC");
            } else {
                //$query = $this->data_model->get_byid('data_ig', ['tanggal'=>$tgl,'operator'=>$username]);
                $query = $this->db->query("SELECT * FROM data_ig WHERE tanggal='$tgl' AND operator='$username' ORDER BY id_data DESC");
                
            }
          //$query = $this->db->query("SELECT * FROM data_ig WHERE tanggal='$tgl' AND operator='$username' AND shift_op='3' ORDER BY id_data DESC");
          echo "<tr>
                    <td style='font-size:12px;'><strong>No.</strong></td>
                    <td style='font-size:12px;'><strong>Kode Roll</strong></td>
                    <td style='font-size:12px;'><strong>Konstruksi</strong></td>
                    <td style='font-size:12px;'><strong>MC</strong></td>
                    <td style='font-size:12px;'><strong>Ukuran</strong></td>
                    <td style='font-size:12px;'><strong>Del</strong></td>
                </tr>";
          if (strtotime($currentTime) >= strtotime('00:00') && strtotime($currentTime) < strtotime('06:00')) { 
                $jumlah_data = $query->num_rows() + $query2->num_rows();
          } else {
                $jumlah_data = $query->num_rows();
          }
             if (strtotime($currentTime) >= strtotime('00:00') && strtotime($currentTime) < strtotime('06:00')) { 
                  if($query2->num_rows() > 0){
                      foreach($query2->result() as $vals){
                          echo "<tr>";
                          echo "<td style='font-size:12px;text-align:center;'>".$jumlah_data."</td>";
                          echo "<td style='font-size:12px;'>".$vals->kode_roll."</td>";
                          echo "<td style='font-size:12px;'>".$vals->konstruksi."</td>";
                          echo "<td style='font-size:12px;'>".strtoupper($vals->no_mesin)."</td>";
                          echo "<td style='font-size:12px;'>".$vals->ukuran_ori."</td>";
                          ?><td>
                                <img src="<?=base_url('assets/del.png');?>" alt="Delete" style="width:20px;" onclick="owek('<?=$vals->id_data;?>', '<?=$vals->kode_roll;?>')">
                            </td><?php
                          echo "</tr>";
                          $jumlah_data--;
                      }
                  }
              }
          if($query->num_rows() > 0){
              
              foreach($query->result() as $val){
                  echo "<tr>";
                  echo "<td style='font-size:12px;text-align:center;'>".$jumlah_data."</td>";
                  echo "<td style='font-size:12px;'>".$val->kode_roll."</td>";
                  echo "<td style='font-size:12px;'>".$val->konstruksi."</td>";
                  echo "<td style='font-size:12px;'>".strtoupper($val->no_mesin)."</td>";
                  echo "<td style='font-size:12px;'>".$val->ukuran_ori."</td>";
                  ?><td>
                        <img src="<?=base_url('assets/del.png');?>" alt="Delete" style="width:20px;" onclick="owek('<?=$val->id_data;?>')">
                    </td><?php
                  echo "</tr>";
                  $jumlah_data--;
              }
              
          } 
          $query2=$this->db->query("SELECT * FROM bs_grey_samatex WHERE tgl='$tgl' AND operator='$username' ORDER BY iddataigbs DESC");
          if($query2->num_rows() > 0){
              echo "<tr><td colspan='6'><strong>Kode Roll BS</strong></td></tr>";
              foreach($query2->result() as $n => $val){
                  echo "<tr>";
                  echo "<td></td>";
                  echo "<td style='font-size:12px;'>BSG".$val->iddataigbs."</td>";
                  echo "<td style='font-size:12px;'>".$val->konstruksi_real."</td>";
                  echo "<td></td>";
                  echo "<td style='font-size:12px;'>".$val->ukuran_bs."</td>";
                  echo "<td></td>";
                  echo "</tr>";
              }
          }
      } //end insgrey
      if($proses == "insfinish"){
        //$query = $this->data_model->get_byid('data_ig', ['tanggal'=>$tgl, 'operator'=>$username]);
        $query = $this->db->query("SELECT * FROM data_if WHERE tgl_potong='$tgl' AND operator='$username' ORDER BY id_infs DESC");
        echo "<tr>
                  <td><strong>No.</strong></td>
                  <td><strong>Kode Roll</strong></td>
                  <td><strong>Konstruksi</strong></td>
                  <td><strong>MC</strong></td>
                  <td><strong>Ukuran (Yrd)</strong></td>
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
                echo "<td>".$nomc2."</td>";
                $ori_yard = $val->ukuran_ori / 0.9144;
                $showyard = round($ori_yard,2);
                echo "<td>".$showyard."</td>";
                echo "</tr>";
                $jumlah_data--;
            endforeach;
        } else {
            echo '<tr><td colspan="5">Data Inspect Finish Anda Masih Kosong</td></tr>';
        }
    } //end insfinsih
    if($proses == "folgrey"){
      //$query = $this->data_model->get_byid('data_ig', ['tanggal'=>$tgl, 'operator'=>$username]);
      $query = $this->db->query("SELECT * FROM data_fol WHERE jns_fold='Grey' AND tgl='$tgl' AND operator='$username' ORDER BY id_fol DESC");
      echo "<tr>
                <td><strong>No.</strong></td>
                <td><strong>Kode Roll</strong></td>
                <td><strong>Konstruksi</strong></td>
                <td><strong>MC</strong></td>
                <td><strong>Ukuran (Mtr)</strong></td>
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
              echo "<td>".$nomc2."</td>";
              //$ori_yard = $val->ukuran_ori * 0.9144;
              //$showyard = round($ori_yard,2);
              echo "<td>".$val->ukuran."</td>";
              echo "</tr>";
              $jumlah_data--;
          endforeach;
      } else {
          echo '<tr><td colspan="5">Data Folding Grey Anda Masih Kosong</td></tr>';
      }
    } //end folgrey
    if($proses == "folfinish"){
      //$query = $this->data_model->get_byid('data_ig', ['tanggal'=>$tgl, 'operator'=>$username]);
      $query = $this->db->query("SELECT * FROM data_fol WHERE jns_fold='Finish' AND tgl='$tgl' AND operator='$username' ORDER BY id_fol DESC");
      echo "<tr>
                <td><strong>No.</strong></td>
                <td><strong>Kode Roll</strong></td>
                <td><strong>Konstruksi</strong></td>
                <td><strong>MC</strong></td>
                <td><strong>Ukuran (Yrd)</strong></td>
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
              echo "<td>".$nomc2."</td>";
              //$ori_yard = $val->ukuran_ori * 0.9144;
              //$showyard = round($ori_yard,2);
              echo "<td>".$val->ukuran."</td>";
              echo "</tr>";
              $jumlah_data--;
          endforeach;
      } else {
          echo '<tr><td colspan="5">Data Folding Finish Anda Masih Kosong</td></tr>';
      }
    } //end folfinish
      
  } //end

  function prosesInsGrey(){
    $tableKode = $this->data_model->get_byid('data_ig_code', ['idcode'=>'2'])->row_array();
    $numSkr = $tableKode['numskr'];
    $newNumber = intval($numSkr) + 1;
    $allkode = $tableKode['alpabet']."".$newNumber;
    $cekAllKode = $this->data_model->get_byid('data_ig', ['kode_roll'=>$allkode])->num_rows();
    if($cekAllKode > 0){
        $newNumbera = $newNumber + 1;
        $allkode = $tableKode['alpabet']."".$newNumbera;
        $cekAllKode2 = $this->data_model->get_byid('data_ig', ['kode_roll'=>$allkode])->num_rows();
        if($cekAllKode2 > 0){
            $newNumbera = $newNumber + 2;
            $allkode = $tableKode['alpabet']."".$newNumbera;
        }
    }
    $kons = $this->input->post('kons');
    $kons_rjs = $this->input->post('kons');
    if (strpos($kons_rjs, 'SM') === 0) {
        $kons_rjs = 'RJ' . substr($kons_rjs, 2);
    }
    $konsbs = $this->getKonstruksi($kons);
    $mc = $this->input->post('mc');
    $beam = $this->input->post('beam');
    $oka = $this->input->post('oka');
    $ori = $this->input->post('ori');
    $bs = $this->input->post('bs');
    $bp = $this->input->post('bp');
    $bc = $this->input->post('bc');
    $masket = $this->input->post('masket');
    $fromData = $this->input->post('fromData');
    $idpotid = $this->input->post('idpotid');
    $kdlama = $this->input->post('kdlama');
    if($kdlama!=""){
        if($kdlama!="0"){
            $lokasiLangsung = "Pusatex";
        } else {
            $lokasiLangsung = "RJS";
        }
    } else {
        $lokasiLangsung = "RJS";
    }
    if(intval($fromData) == 0){
        $fromApi = "app";
    } elseif(intval($fromData) == 1){
        $fromApi = "fromApi";
    } else {
        $fromApi = "app";
    }
    //$tgl = $this->input->post('tgl');
    $tgl = date('Y-m-d');
    $currentTime = date('H:i');
    $shift_op = "";
    if (strtotime($currentTime) >= strtotime('06:00') && strtotime($currentTime) < strtotime('14:00')) {
        $shift_op = "1";
    } elseif (strtotime($currentTime) >= strtotime('14:00') && strtotime($currentTime) < strtotime('22:00')) {
        $shift_op = "2";
    } elseif (strtotime($currentTime) >= strtotime('22:00') && strtotime($currentTime) < strtotime('23:59')) {
        $shift_op = "3";
    } elseif (strtotime($currentTime) >= strtotime('00:00') && strtotime($currentTime) < strtotime('06:00')) {
        $shift_op = "31";
    } elseif (strtotime($currentTime) >= strtotime('23:59') && strtotime($currentTime) < strtotime('24:00')) {
        $shift_op = "3";
    } 
    $operator = $this->input->post('username');
    $opt = strtolower($operator);
    $cek_opt = $this->data_model->get_byid('a_operator',['username'=>$opt]);
    if($cek_opt->num_rows() == 1){
        $cek_kons = $this->data_model->get_byid('tb_konstruksi', ['kode_konstruksi'=>$kons_rjs]);
        if($cek_kons->num_rows() == 1){
            if($ori>=50){ $_grade = "ori"; } else {
                if($ori>=21 AND $ori<35){
                    $_grade = "BP";
                }
                if($ori>=11 AND $ori<21){
                    $_grade = "Grade B";
                    $this->data_model->saved('ab_non_ori',[
                            'kode_roll'=>strtoupper($allkode),
                            'konstruksi'=>strtoupper($kons_rjs),
                            'ukuran'=>$ori,
                            'jns_kain'=>'bcgrey',
                            'operator'=>$opt,
                            'posisi'=>'RJS',
                            'tgl_input'=>date('Y-m-d'),
                            'tms'=>date('Y-m-d H:i:s')
                    ]);
                }
                if($ori>=4 AND $ori<11){
                    $_grade = "Grade C";
                    $this->data_model->saved('ab_non_ori',[
                            'kode_roll'=>strtoupper($allkode),
                            'konstruksi'=>strtoupper($kons_rjs),
                            'ukuran'=>$ori,
                            'jns_kain'=>'bcgrey',
                            'operator'=>$opt,
                            'posisi'=>'RJS',
                            'tgl_input'=>date('Y-m-d'),
                            'tms'=>date('Y-m-d H:i:s')
                    ]);
                }
                if($ori < 4){
                    $_grade = "Aval";
                    $this->data_model->saved('ab_non_ori',[
                            'kode_roll'=>strtoupper($allkode),
                            'konstruksi'=>strtoupper($kons_rjs),
                            'ukuran'=>$ori,
                            'jns_kain'=>'avalgrey',
                            'operator'=>$opt,
                            'posisi'=>'RJS',
                            'tgl_input'=>date('Y-m-d'),
                            'tms'=>date('Y-m-d H:i:s')
                    ]);
                }
            }
            $dtlist = [
                'kode_roll' => strtoupper($allkode),
                'konstruksi' => strtoupper($kons_rjs),
                'no_mesin' => strtoupper($mc),
                'no_beam' => $beam,
                'oka' => $oka,
                'ukuran_ori' => $ori,
                'ukuran_bs' => $bs,
                'ukuran_bp' => 0,
                'ukuran_bc' => 0,
                'tanggal' => $tgl,
                'operator' => $opt,
                'bp_can_join' => $_grade,
                'dep' => 'RJS',
                'loc_now' => $lokasiLangsung,
                'yg_input' => 0,
                'kode_upload' => date('Y-m-d H:i:s'),
                'shift_op' => $shift_op,
                'input_from' => $fromApi,
                'kode_potongan' => $idpotid
            ];
            $this->data_model->saved('data_ig', $dtlist);
            if($kdlama!=""){
                if($kdlama!="0"){
                    $this->db->query("DELETE FROM data_ig WHERE kode_roll='$kdlama'");
                    $this->db->query("DELETE FROM kiriman_pusatex WHERE kode_roll='$kdlama'");
                    $this->db->query("DELETE FROM data_igtujuan WHERE kode_roll='$kdlama'");
                    $this->data_model->saved('data_igtujuan',[
                        'kode_roll'=>strtoupper($allkode),
                        'konstruksi'=>strtoupper($kons_rjs),
                        'ukuran'=>$ori,
                        'tujuan_proses'=>'Grey'
                    ]);
                }
            }
            $this->data_model->updatedata('idcode',2,'data_ig_code',['numskr'=>$newNumber]);
            if(floatval($bs) > 0){
                $new_cekbs = $this->data_model->get_byid('bs_grey_samatex',['kode_roll'=>$allkode])->num_rows();
                if($new_cekbs==0){
                    if(intval($bs)>3){
                        $this->data_model->saved('bs_grey_samatex', [
                            'kode_roll'         => $allkode,
                            'konstruksi'        => $konsbs,
                            'konstruksi_real'   => $kons_rjs,
                            'ukuran_bs'         => $bs,
                            'berat_bs'          => 0,
                            'tgl'               => $tgl,
                            'shift_op'          => $shift_op,
                            'keterangan'        => $masket,
                            'operator'          => $opt,
                            'dep'               => 'RJS',
                            'lokasi_now'        => 'RJS'
                        ]);
                    } else {
                        $this->data_model->saved('bs_grey_samatex', [
                            'kode_roll'         => $allkode,
                            'konstruksi'        => 'AVAL GREY',
                            'konstruksi_real'   => $kons_rjs,
                            'ukuran_bs'         => $bs,
                            'berat_bs'          => 0,
                            'tgl'               => $tgl,
                            'shift_op'          => $shift_op,
                            'keterangan'        => $masket,
                            'operator'          => $opt,
                            'dep'               => 'RJS',
                            'lokasi_now'        => 'RJS'
                        ]);
                    }
                }
            }
            
            echo json_encode(array("statusCode"=>200, "psn"=>$allkode));
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"Konstruksi tidak ditemukan"));
        }
    } else {
        echo json_encode(array("statusCode"=>404, "psn"=>"Username operator tidak ditemukan"));
    }
      
       
  } //end proses insgrey saved

  function prosesInsFinish(){
        $koderoll = $this->input->post('koderoll');
        $ukuran = $this->input->post('ori');
        $bs = $this->input->post('bs');
        $bp = $this->input->post('bp');
        $crt = $this->input->post('crt');
        $tgl = $this->input->post('tgl');
        $operator = $this->input->post('username');
        $kecilkanOperator = strtolower($operator);
        $cekusername = $this->data_model->get_byid('a_operator', ['username'=>$kecilkanOperator, 'produksi'=>'insfinish', 'dep'=>'Samatex']);
        if($cekusername->num_rows() == 1){
        $cekKodeRoll = $this->data_model->get_byid('data_ig', ['kode_roll'=>$koderoll]);
        if($cekKodeRoll->num_rows() == 1){
            $kons = $cekKodeRoll->row("konstruksi");
            $ukuran_sebelum = $cekKodeRoll->row("ukuran_ori");
            $cekKodeRollFinish = $this->data_model->get_byid('data_if', ['kode_roll'=>$koderoll]);
            if($cekKodeRollFinish->num_rows() == 0){
                $dataBener=0; $totalOri=0; 
                $jadikode = array();
                $alphabet = ['0'=>'','1'=>'A','2'=>'B','3'=>'C','4'=>'D','5'=>'E','6'=>'F','7'=>'G','8'=>'H','9'=>'I','10'=>'J'];
                for ($i=0; $i <count($ukuran) ; $i++) { 
                    if($ukuran[$i]!="" AND $ukuran[$i]>0){
                        $dataBener+=1;
                        $totalOri+=floatval($ukuran[$i]);
                        $kodeRollInput = $koderoll."".$alphabet[$i];
                        $jadikode[]= $kodeRollInput;
                        $dtlist = [
                            'kode_roll' => strtoupper($kodeRollInput),
                            'tgl_potong' => $tgl,
                            'ukuran_ori' => $ukuran[$i],
                            'ukuran_bs' => $i==0 ? $bs:0,
                            'ukuran_crt' => $i==0 ? $crt:0,
                            'ukuran_bp' => $i==0 ? $bp:0,
                            'operator' => $kecilkanOperator,
                            'ket' => 'new',
                            'asal' => '0',
                            'bp_canjoin' => $ukuran[$i]<50 ? 'true':'false',
                            'konstruksi' => strtoupper($kons)
                        ];
                        $this->data_model->saved('data_if',$dtlist);
                    } 
                } //end for 
                //cek produksi per sm harian
                $cek1 = $this->data_model->get_byid('data_produksi', ['kode_konstruksi'=>$kons,'tgl'=>$tgl,'dep'=>'Samatex']);
                if($cek1->num_rows() == 1){
                        $id_produksi = $cek1->row("id_produksi");
                        $new_if = floatval($cek1->row("prod_if")) + floatval($totalOri);
                        $new_bs = floatval($cek1->row("prod_bs2")) + floatval($bs);
                        $new_bp = floatval($cek1->row("prod_bp2")) + floatval($bp);
                        $new_crt = floatval($cek1->row("crt")) + floatval($crt);
                        $dtlist1 = [
                            'prod_if' => round($new_if,2),
                            'prod_bs2' => round($new_bs,2),
                            'prod_bp2' => round($new_bp,2),
                            'crt' => round($new_crt,2)
                        ];
                        $this->data_model->updatedata('id_produksi',$id_produksi,'data_produksi',$dtlist1);
                } else {
                    $dtlist1 = [
                        'kode_konstruksi' => $kons,
                        'tgl' => $tgl,
                        'dep' => 'Samatex',
                        'prod_ig' => 0,
                        'prod_fg' => 0,
                        'prod_if' => round($totalOri,2),
                        'prod_ff' => 0,
                        'prod_bs1' => 0,
                        'prod_bp1' => 0,
                        'prod_bs2' => $bs,
                        'prod_bp2' => $bp,
                        'crt' => $crt
                    ];
                    $this->data_model->saved('data_produksi', $dtlist1);
                }
                //end cek 1
                //cek produksi harian total
                $cek2 = $this->data_model->get_byid('data_produksi_harian', ['tgl'=>$tgl,'dep'=>'Samatex']);
                if($cek2->num_rows() == 1){
                        $id_prod_hr = $cek2->row("id_prod_hr");
                        $new_if = floatval($cek2->row("prod_if")) + floatval($totalOri);
                        $new_bs = floatval($cek2->row("prod_bs2")) + floatval($bs);
                        $new_bp = floatval($cek2->row("prod_bp2")) + floatval($bp);
                        $new_crt = floatval($cek2->row("crt")) + floatval($crt);
                        $dtlist1 = [
                            'prod_if' => round($new_if,2),
                            'prod_bs2' => round($new_bs,2),
                            'prod_bp2' => round($new_bp,2),
                            'crt' => round($new_crt,2)
                        ];
                        $this->data_model->updatedata('id_prod_hr',$id_prod_hr,'data_produksi_harian',$dtlist1);
                } else {
                    $dtlist1 = [
                        'tgl' => $tgl,
                        'dep' => 'Samatex',
                        'prod_ig' => 0,
                        'prod_fg' => 0,
                        'prod_if' => round($totalOri,2),
                        'prod_ff' => 0,
                        'prod_bs1' => 0,
                        'prod_bp1' => 0,
                        'prod_bs2' => $bs,
                        'prod_bp2' => $bp,
                        'crt' => $crt
                    ];
                    $this->data_model->saved('data_produksi_harian', $dtlist1);
                }
                //end cek 2
                //cek produksi opt
                $cek3 = $this->data_model->get_byid('data_produksi_opt', ['username_opt'=>$kecilkanOperator,'konstruksi'=>$kons,'tgl'=>$tgl,'proses'=>'insfinish']);
                if($cek3->num_rows() == 1){
                    $id_propt = $cek3->row("id_propt");
                    $new_ori = floatval($cek3->row("ukuran")) + floatval($totalOri);
                    $new_bs = floatval($cek3->row("bs")) + floatval($bs);
                    $new_bp = floatval($cek3->row("bp")) + floatval($bp);
                    $new_crt = floatval($cek3->row("crt")) + floatval($crt);
                    $dtlist2 = [
                        'ukuran' => round($new_ori,2),
                        'bs' => round($new_bs,2),
                        'bp' => round($new_bp,2),
                        'crt' => round($new_crt,2)
                    ];
                    $this->data_model->updatedata('id_propt',$id_propt,'data_produksi_opt',$dtlist2);
                } else {
                    $dtlist2 = [
                        'username_opt' => $kecilkanOperator,
                        'konstruksi' => $kons,
                        'tgl' => $tgl,
                        'proses' => 'insfinish',
                        'ukuran' => round($totalOri,2), 
                        'bs' => $bs,
                        'bp' => $bp,
                        'crt' => $crt
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
                        'prod_if' => round($totalOri,2),
                        'prod_ff' => 0,
                        'prod_bs1' => 0,
                        'prod_bp1' => 0,
                        'prod_bs2' => $bs,
                        'prod_bp2' => $bp,
                        'crt' => $crt
                    ];
                    $this->data_model->saved('data_stok', $listStok);
                } else {
                    $idstok = $cekStok->row("idstok");
                    $newig = floatval($cekStok->row("prod_ig")) - floatval($ukuran_sebelum);
                    $newif = floatval($cekStok->row("prod_if")) + floatval($totalOri);
                    $newbs = floatval($cekStok->row("prod_bs2")) + floatval($bs);
                    $newbp = floatval($cekStok->row("prod_bp2")) + floatval($bp);
                    $newcrt = floatval($cekStok->row("crt")) + floatval($crt);
                    $listStok = [
                        'prod_ig' => round($newig,2),
                        'prod_if' => round($newif,2),
                        'prod_bs2' => round($newbs,2),
                        'prod_bp2' => round($newbp,2),
                        'crt' => round($newcrt,2)
                    ];
                    $this->data_model->updatedata('idstok',$idstok,'data_stok',$listStok);
                }
                //end cek 4
                $imJadi = implode('-', $jadikode);
                $text = "Kode ".$imJadi."";
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
        $this->load->view('users/report_insgreyrjs');
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

  function cariInsgrey(){
        $kode = $this->input->post('kode');
        $cekkode = $this->data_model->get_byid('data_ig', ['kode_roll'=>$kode]);
        if($cekkode->num_rows() == 1){
            $cek_finish = $this->data_model->get_byid('data_if', ['kode_roll'=>$kode]);
            if($cek_finish->num_rows() == 0){
                $kons = $cekkode->row("konstruksi");
                $mc = $cekkode->row("no_mesin");
                $ori = $cekkode->row("ukuran_ori");
                $text = "Data Inspect Grey<br>- Konstruksi &nbsp;<strong>".$kons."</strong><br>- Nomor Mesin &nbsp;<strong>".$mc."</strong><br>- Ukuran &nbsp;<strong>".$ori."</strong> Meter";
                echo json_encode(array("statusCode"=>200, "psn"=>$text));
            } else {
                $text = "<span style='color:red;'>".$kode." telah di proses inspect Finish</code>";
                echo json_encode(array("statusCode"=>200, "psn"=>$text));
            }
            
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"Kode tidak ditemukan"));
        }
  } //end

  function cariInsgrey2(){
        $kode = $this->input->post('kode');
        $cekkode = $this->data_model->get_byid('data_ig', ['kode_roll'=>$kode]);
        if($cekkode->num_rows() == 1){
            $cek_fol = $this->data_model->get_byid('data_fol', ['kode_roll'=>$kode]);
            if($cek_fol->num_rows() == 0){
                $kons = $cekkode->row("konstruksi");
                $mc = $cekkode->row("no_mesin");
                $ori = $cekkode->row("ukuran_ori");
                $text = "Data Inspect Grey<br>- Konstruksi &nbsp;<strong>".$kons."</strong><br>- Nomor Mesin &nbsp;<strong>".$mc."</strong><br>- Ukuran &nbsp;<strong>".$ori."</strong> Meter";
                echo json_encode(array("statusCode"=>200, "psn"=>$text));
            } else {
                $text = "<span style='color:red;'>".$kode." telah di proses Folding</code>";
                echo json_encode(array("statusCode"=>200, "psn"=>$text));
            }
            
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"Kode tidak ditemukan"));
        }

  } //end
    function joinpkglist(){
        $txt = $this->input->post('txt');
        $user = $this->input->post('username');
        //$kode = ['RJS123', 'RJS124', 'RJS129', 'RJS111', 'RJS1001', 'RJS912', 'RJS100'];
        $kode = explode(',', $txt);
        $angka = array();
        $konstruksi = array();
        foreach ($kode as $k) {
            $angka[] = intval(substr($k, 3)); // Menghapus awalan 'RJS' dan mengonversi bagian angka ke tipe data integer
            $kons = $this->db->query("SELECT kode_konstruksi,kd FROM new_tb_packinglist WHERE kd='$k'")->row("kode_konstruksi");
            if(in_array($kons, $konstruksi)) {} else {
                $konstruksi[] = $kons;
            }
        }
        $max_angka = max($angka);
        $index_terbesar = array_search($max_angka, $angka);
        $kode_terbesar = $kode[$index_terbesar];
        if(count($konstruksi) == 1){
            foreach($kode as $p){
                if($p == $kode_terbesar){

                } else {
                    $this->data_model->updatedata('kd',$p,'new_tb_isi',['kd'=>$kode_terbesar]);
                    $this->data_model->updatedata('loc_now',$p,'data_ig',['loc_now'=>$kode_terbesar]);
                    $this->db->query("DELETE FROM new_tb_packinglist WHERE kd='$p'");
                }
            }
            $jmlroll = $this->db->query("SELECT COUNT(kd) as jml FROM new_tb_isi WHERE kd='$kode_terbesar'")->row("jml");
            $ukuran = $this->db->query("SELECT SUM(ukuran) as ukr FROM new_tb_isi WHERE kd='$kode_terbesar'")->row("ukr");
            $this->data_model->updatedata('kd',$kode_terbesar,'new_tb_packinglist',['jumlah_roll'=>$jmlroll, 'ttl_panjang'=>$ukuran]);
            echo json_encode(array("statusCode"=>200, "psn"=>$kode_terbesar));
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"Konstruksi ada yang berbeda"));
        }
        
    } //end


  function loadpaketpst(){
    $bln = ['00'=>'undf', '01'=>'Jan', '02'=>'Feb', '03'=>'Mar', '04'=>'Apr', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Ags', '09'=>'Sep', '10'=>'Okt', '11'=>'Nov', '12'=>'Des'];
    $yr = date('Y');
    $username =strtolower($this->input->post('username'));
    $view =strtolower($this->input->post('view'));
    if($view=="pusatex"){ 
        $show_kiriman="yes"; 
        $qr = $this->db->query("SELECT * FROM `surat_jalan` WHERE tujuan_kirim='Pusatex' ORDER BY id_sj DESC LIMIT 500");
        echo '<tr style="background:#454443;color:#fff;">
            <td>Surat Jalan</td>
            <td>Tanggal Kirim</td>
            <td>Jml Roll</td>
            <td>Total Panjang</td>
            <td>Valid</td>
        </tr>';
        if($qr->num_rows() >0){
            foreach($qr->result() as $val){
                $tgl = date('d M Y', strtotime($val->tgl_kirim));
                $sj=$val->no_sj;
                $jmlroll = $this->data_model->get_byid('kiriman_pusatex', ['surat_jalan'=>$sj])->num_rows();
                $jmlroll_valid = $this->data_model->get_byid('kiriman_pusatex', ['surat_jalan'=>$sj,'diterima_pusatex!='=>'null'])->num_rows();
                $ukrroll = $this->db->query("SELECT SUM(ukuran) AS jml FROM kiriman_pusatex WHERE surat_jalan='$sj'")->row("jml");
                echo "<tr>";
                echo "<td>";
                ?><a href="javascript:void(0);" onclick="loadValidasi('<?=$sj;?>')" style="text-decoration:none;color:blue;"><?=$val->no_sj;?></a><?php
                echo "</td>";
                echo "<td>".$tgl."</td>";
                echo "<td>".$jmlroll."</td>";
                echo "<td>".number_format($ukrroll)."</td>";
                if($jmlroll_valid == $jmlroll){
                    echo "<td>".$jmlroll_valid."</td>";
                } else {
                    echo "<td style='color:red;'>".$jmlroll_valid."</td>";
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada kiriman.</td></tr>";
        }
    } else { 
        $show_kiriman="no"; 
    $cekusername = $this->data_model->get_byid('a_operator', ['username'=>$username]);
    if($cekusername->num_rows() == 1){
        if($view=="penjualan"){
        $query = $this->db->query("SELECT * FROM new_tb_packinglist WHERE kd LIKE 'PKT%' AND siap_jual='y' ORDER BY id_kdlist DESC LIMIT 500");
        $_tx = "Tujuan";
        } else {
        $query = $this->db->query("SELECT * FROM new_tb_packinglist WHERE kd LIKE 'RJS%' AND siap_jual='n' ORDER BY id_kdlist DESC LIMIT 500");
        $_tx = "Beam";
        }
        //$query = $this->data_model->get_byid('new_tb_packinglist', ['lokasi_now'=>'RJS','siap_jual'=>'n','ygbuat'=>$username]);
        if($query->num_rows() > 0){
            echo '<tr style="background:#454443;color:#fff;">
                    <td>Kode Pkg</td>
                    <td>Konstruksi</td>
                    <td>Jml Roll</td>
                    <td>Total Panjang</td>
                    <td>Tanggal</td>
                    <td>'.$_tx.'</td>
                  </tr>'; 
            //if($view=="penjualan"){} else {
            $data_view=0;
            foreach($query->result() as $val):
                if($_tx=="Tujuan"){
                    echo "<tr style='background:#ebeced'>";                
                    if($val->kepada=="NULL"){
                    echo "<td style='font-weight:bold;color:#4287f5;'><a href='".base_url('usersrjs/createkirimpst/'.$val->kd)."'>".$val->kd."</a></td>";
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
                        echo "<td>".$ex[2]."/".$bln[$ex[1]]."</td>";
                    } else {
                        echo "<td>".$ex[2]." ".$bln[$ex[1]]." ".$ex[0]."</td>";
                    }
                    echo "<td>";
                    if($val->kepada == "NULL"){
                        echo strtoupper($val->customer);
                    } else {
                        echo strtoupper($val->kepada);
                    }
                    echo "</td>";
                    echo "</tr>";
                    $data_view+=1;
                } else {
                if($val->no_sj == "NULL"){
                    echo "<tr style='background:#ebeced'>";                
                    if($val->kepada=="NULL"){
                    echo "<td style='font-weight:bold;color:#4287f5;'><a href='".base_url('usersrjs/createkirimpst2/'.$val->kd)."'>".$val->kd."</a></td>";
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
                        echo "<td>".$ex[2]."/".$bln[$ex[1]]."</td>";
                    } else {
                        echo "<td>".$ex[2]." ".$bln[$ex[1]]." ".$ex[0]."</td>";
                    }
                    echo "<td>";
                    echo strtoupper($val->customer);
                    echo "</td>";
                    echo "</tr>";
                    $data_view+=1;
                }
                }
            endforeach;
            if($data_view==0){
                echo "<tr><td colspan='6'>Tidak ada packinglist di Rindang</td></tr>";
            }
            //}
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
    }
  } //end
  function joinKodeGrey(){
        $txt   = strtoupper($this->input->post('txt'));
        $username   = strtoupper($this->input->post('username'));
        $x     = explode(',', $txt);
        $salah = 0;
        $notif = "";
        $kons  = array();
        for ($i=0; $i <count($x) ; $i++) { 
            $kode_roll  = $x[$i];
            $cek        = $this->data_model->get_byid('data_ig',['kode_roll'=>$kode_roll]);
            if($cek->num_rows() == 1){
                $_kons      = strtoupper($cek->row("konstruksi"));
                if(in_array($_kons, $kons)){} else { $kons[]=$_kons; }
                if($cek->row("ukuran_ori") > 20 AND $cek->row("ukuran_ori") < 50){
                    if($cek->row("loc_now") == "RJS"){

                    } else {
                        $salah+=1;
                        $notif .= "Pastikan ".$kode_roll." tidak berada di packinglist. ";
                    }
                } else {
                    $salah+=1;
                    $notif .= $kode_roll." tidak masuk ke golongan BP. ";
                }
            } else {
                $salah+=1;
                $notif .= $kode_roll." tidak ditemukan. ";
            }
        }
        if($salah == 0){
            if(count($kons) == 1){
                $ukuran_join = 0;
                $konstruksi_join = "";
                for ($i=0; $i <count($x) ; $i++) { 
                    $kode_roll  = $x[$i];
                    $dtig = $this->data_model->get_byid('data_ig',['kode_roll'=>$kode_roll])->row_array();
                    $ukuran_join += $dtig['ukuran_ori'];
                    $konstruksi_join = $dtig['konstruksi'];
                }
                $cekKode = $this->db->query("SELECT kode_roll FROM data_ig WHERE kode_roll LIKE '%JGR%'");
                if($cekKode->num_rows() == 0){
                    $kodeJG = "JGR1";
                } else {
                    $cekKode = $this->db->query("SELECT id_data,kode_roll FROM data_ig WHERE kode_roll LIKE '%JGR%' ORDER BY id_data DESC LIMIT 1")->row("kode_roll");
                    $m = explode('R', $cekKode);
                    $newnum = intval($m[1]) + 1;
                    $kodeJG = "JGR".$newnum;
                }
                $dtlist = [
                    'kode_roll' => $kodeJG,
                    'konstruksi' => $konstruksi_join,
                    'no_mesin' => 'null',
                    'no_beam' => 'null',
                    'oka' => 'null',
                    'ukuran_ori' => $ukuran_join,
                    'ukuran_bs' => 0,
                    'ukuran_bp' => 0,
                    'tanggal' => date('Y-m-d'),
                    'operator' => $username,
                    'bp_can_join' => 'null',
                    'dep' => 'RJS',
                    'loc_now' => 'RJS',
                    'yg_input' => $username,
                    'kode_upload'=>'null',
                    'shift_op'=>'0',
                ];
                $this->data_model->saved('data_ig', $dtlist);
                for ($i=0; $i <count($x) ; $i++) { 
                    $kode_roll  = $x[$i];
                    
                    $this->data_model->delete('data_ig','kode_roll', $kode_roll);
                }
                $xxt = "Kode baru menjadi $kodeJG";
                echo json_encode(array("statusCode"=>200, "psn"=>$xxt));
            } else {
                echo json_encode(array("statusCode"=>400, "psn"=>'Konstruksi tidak sama.'));
            }
        } else {
            echo json_encode(array("statusCode"=>400, "psn"=>$notif));
        }
        
  }
  function loadDataStokGrey(){
    $username =strtolower($this->input->post('username'));
    $tgl =strtolower($this->input->post('tgl'));
    if($tgl == "null"){
        $_thisTgl = date('Y-m-d');
        $kemarin = date('Y-m-d', strtotime($_thisTgl . ' -1 day'));
        $cekusername = $this->data_model->get_byid('a_operator', ['username'=>$username]);
        if($cekusername->num_rows() == 1){

                $query = $this->db->query("SELECT * FROM `data_ig` WHERE `dep` = 'RJS' AND `loc_now` REGEXP '^RJS[0-9]+$' ");
                $arkons = array();
                foreach($query->result() as $akos){
                    $new_kons = strtoupper($akos->konstruksi);
                    if(in_array($new_kons, $arkons)){} else {
                        $arkons[] = $new_kons;
                    }
                }
                ?>
                <tr style="background:#454443;color:#fff;">
                    <td rowspan="2"><strong>Konstruksi</strong></td>
                    <td colspan="5" style="text-align:center;"><strong>JUMLAH STOK</strong></td>
                    
                </tr>
                <tr style="background:#454443;color:#fff;">
                    <td style="text-align:center;"><strong>Roll</strong></td>
                    <td style="text-align:center;"><strong>ORI</strong></td>
                    <td style="text-align:center;"><strong>BP</strong></td>
                    <td style="text-align:center;"><strong>BC</strong></td>
                    <td style="text-align:center;"><strong>JG</strong></td>
                </tr>
                <?php
                foreach($arkons as $val){
                    //#adishcek
                    echo "<tr style='background:#f0f0f0;'>";
                        echo "<td>".$val."</td>";
                        //jmlroll
                        $_rolbrj = $this->db->query("SELECT COUNT(id_data) as jml FROM data_ig WHERE konstruksi='$val'  AND no_beam NOT LIKE '%bsm%' AND dep='RJS' AND loc_now REGEXP '^RJS[0-9]+$'")->row("jml");
                        
                        //stok ori
                        $_stokbrj  = $this->db->query("SELECT SUM(ukuran_ori) as jml FROM data_ig WHERE konstruksi='$val' AND ukuran_ori>49 AND no_beam NOT LIKE '%bsm%' AND dep='RJS' AND loc_now REGEXP '^RJS[0-9]+$' ")->row("jml");
                        
                        //stok bp
                        $_stokbp  = $this->db->query("SELECT SUM(ukuran_ori) as jml FROM data_ig WHERE konstruksi='$val' AND ukuran_ori>20 AND ukuran_ori<50 AND no_beam NOT LIKE '%bsm%' AND dep='RJS' AND loc_now REGEXP '^RJS[0-9]+$' ")->row("jml");

                        //stok bc
                        $_stokbc  = $this->db->query("SELECT SUM(ukuran_ori) as jml FROM data_ig WHERE konstruksi='$val' AND ukuran_ori>3 AND ukuran_ori<20 AND no_beam NOT LIKE '%bsm%' AND dep='RJS' AND loc_now REGEXP '^RJS[0-9]+$' ")->row("jml");

                        //stok bc
                        $_stokbc  = $this->db->query("SELECT SUM(ukuran_ori) as jml FROM data_ig WHERE konstruksi='$val' AND ukuran_ori>3 AND ukuran_ori<20 AND no_beam NOT LIKE '%bsm%' AND dep='RJS' AND loc_now REGEXP '^RJS[0-9]+$' ")->row("jml");
                        
                        if($_rolbrj > 0){
                            echo "<td style='text-align:center;'>".number_format($_rolbrj,0,',','.')."</td>";
                        } else {
                            echo "<td style='text-align:center;'>-</td>";
                        }
                        if($_stokbrj > 0){
                            echo "<td style='text-align:center;'>".number_format($_stokbrj,0,',','.')."</td>";
                        } else {
                            echo "<td style='text-align:center;'>-</td>";
                        }
                        if($_stokbp > 0){
                            echo "<td style='text-align:center;'>".number_format($_stokbp,0,',','.')."</td>";
                        } else {
                            echo "<td style='text-align:center;'>-</td>";
                        }
                        if($_stokbc > 0){
                            echo "<td style='text-align:center;'>".number_format($_stokbc,0,',','.')."</td>";
                        } else {
                            echo "<td style='text-align:center;'>-</td>";
                        }
                        echo "<td style='text-align:center;'>-</td>";
                        
                    echo "</tr>";
                    
                }
            
        } else {
            echo "<tr><td colspan='2'><span style='color:red;'>Tidak berhasil mengambil data stok. Anda perlu login ulang</span></td></tr>";
        }
    } else {
        ?>
        <tr style="background:#454443;color:#fff;">
            <td rowspan="2"><strong>Konstruksi</strong></td>
            <td colspan="3" style="text-align:center;"><strong>BRJ</strong></td>
            <td colspan="3" style="text-align:center;"><strong>BSM</strong></td>
        </tr>
        <tr style="background:#454443;color:#fff;">
            <td style="text-align:center;"><strong>Roll</strong></td>
            <td style="text-align:center;"><strong>Stok</strong></td>
            <td style="text-align:center;"><strong>BS</strong></td>
            <td style="text-align:center;"><strong>Roll</strong></td>
            <td style="text-align:center;"><strong>Stok</strong></td>
            <td style="text-align:center;"><strong>BS</strong></td>
        </tr>
        <?php
        $dt = $this->db->query("SELECT * FROM lock_stok_rjs WHERE tanggal = '$tgl' AND tipe='in'");
        if($dt->num_rows() > 0){
            foreach($dt->result() as $row){
                echo "<tr>";
                echo "<td>".$row->konstruksi."</td>";
                echo "<td>".$row->rollbrj."</td>";
                echo "<td>".$row->brj."</td>";
                echo "<td>".$row->bsbrj."</td>";
                echo "<td>".$row->rollbsm."</td>";
                echo "<td>".$row->bsm."</td>";
                echo "<td>".$row->bsbsm."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
        }
        
    }
  } //end
  function prosesCreatepkgBC(){
      $username     = strtolower($this->input->post('username'));
      $tesTujuan    = $this->input->post('tesTujuan');
      $cekPkg = $this->db->query("SELECT kd FROM new_tb_packinglist WHERE kd LIKE 'PBC%' ORDER BY id_kdlist DESC LIMIT 1");
        if($cekPkg->num_rows() == 0){
            $kdpkg = "PBC1";
        } else {
            $kode_sebelum = $cekPkg->row("kd");
            $ex = explode('C', $kode_sebelum);
            $num = intval($ex[1]) + 1;
            $kdpkg = "PBC1".$num."";
        }
        $loc_now = "Pusatex";
        $dtlist = [
                'kode_konstruksi' => '',
                'kd' => $kdpkg,
                'tanggal_dibuat' => date('Y-m-d'),
                'tms_tmp' => date('Y-m-d H:i:s'),
                'lokasi_now' => $loc_now,
                'siap_jual' => 'y',
                'jumlah_roll' => 0,
                'ttl_panjang' => 0,
                'kepada' => 'NULL',
                'no_sj' => 'NULL',
                'ygbuat' => $username,
                'jns_fold' => 'null',
                'customer' => $tesTujuan
            ];
            $this->data_model->saved('new_tb_packinglist', $dtlist);
            //$_thisNum2 = intval($cekPaket['numskr']) + 1;
            //$this->data_model->updatedata('idcode','6','data_ig_code',['numskr'=>$_thisNum2]);
            echo json_encode(array("statusCode"=>200, "psn"=>$kdpkg));
  }
  
  function prosesCreatepkg2(){
        $username = strtolower($this->input->post('username'));
        $kodekons = $this->input->post('kodekons');
        $opt = $this->input->post('opt');
        $jual = $this->input->post('jual');
        $tesTujuan = $this->input->post('tesTujuan');
        $jnsFold = $this->input->post('jnsFold');
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
            if($jual=="y"){
                $cekPkg = $this->db->query("SELECT kd FROM new_tb_packinglist WHERE kd LIKE 'PKT%' ORDER BY id_kdlist DESC LIMIT 1");
                if($cekPkg->num_rows() == 0){
                    $kdpkg = "PKT1";
                } else {
                    $kode_sebelum = $cekPkg->row("kd");
                    $ex = explode('T', $kode_sebelum);
                    $num = intval($ex[1]) + 1;
                    $kdpkg = "PKT".$num."";
                }
                $loc_now = "Pusatex";
            } else {
                $cekPkg = $this->db->query("SELECT kd FROM new_tb_packinglist WHERE kd LIKE 'RJS%' ORDER BY id_kdlist DESC LIMIT 1");
                if($cekPkg->num_rows() == 0){
                    $kdpkg = "RJS1";
                } else {
                    $kode_sebelum = $cekPkg->row("kd");
                    $ex = explode('S', $kode_sebelum);
                    $num = intval($ex[1]) + 1;
                    $kdpkg = "RJS".$num."";
                }
                // $cekPaket = $this->data_model->get_byid('data_ig_code',['idcode'=>'6'])->row_array();
                // $_thisKode = $cekPaket['alpabet'];
                // $_thisNum = intval($cekPaket['numskr']) + 1;
                // $_thisNewKode = $_thisKode."".$_thisNum;
                // $kdpkg = $_thisNewKode;
                $loc_now = "RJS";
            }
            $dtlist = [
                'kode_konstruksi' => $kodekons,
                'kd' => $kdpkg,
                'tanggal_dibuat' => $tgl,
                'lokasi_now' => $loc_now,
                'siap_jual' => $jual=='y' ? 'y':'n',
                'jumlah_roll' => 0,
                'ttl_panjang' => 0,
                'kepada' => 'NULL',
                'no_sj' => 'NULL',
                'ygbuat' => $opt,
                'jns_fold' => $jual=='y' ? $jnsFold:'null',
                'customer' => $jual=='y' ? $tesTujuan:'null'
            ];
            $this->data_model->saved('new_tb_packinglist', $dtlist);
            //$_thisNum2 = intval($cekPaket['numskr']) + 1;
            //$this->data_model->updatedata('idcode','6','data_ig_code',['numskr'=>$_thisNum2]);
            echo json_encode(array("statusCode"=>200, "psn"=>$kdpkg));
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>'Konstruksi tidak ditemukan {$kodekons}'));
        }
        //
  } //end

    function lockstok(){
        echo "oke<br>";
        $tgl = date('Y-m-d');
        $tgl_sebelumnya = date('Y-m-d', strtotime($tgl.' -1 days'));
        echo "$tgl <hr>";
        $stok = $this->db->query("SELECT * FROM data_ig WHERE dep='RJS' AND loc_now LIKE '%RJS%'");
        $kons = array();
        foreach($stok->result() as $d){
            $_kons = strtoupper($d->konstruksi);
            if(in_array($_kons, $kons)) {} else {
                $kons[] = $_kons;
            }
        } 
        $cektgl = $this->data_model->get_byid('lock_stok_rjs', ['tanggal'=>$tgl_sebelumnya])->num_rows();
        if($cektgl == 0){
            foreach($kons as $val){
                //jmlroll
                $_rolbrj = $this->db->query("SELECT COUNT(id_data) as jml FROM data_ig WHERE konstruksi='$val' AND no_beam NOT LIKE '%bsm%' AND dep='RJS' AND loc_now LIKE '%RJS%'")->row("jml");
                $_rolbsm = $this->db->query("SELECT COUNT(id_data) as jml FROM data_ig WHERE konstruksi='$val' AND no_beam LIKE '%bsm%' AND dep='RJS' AND loc_now LIKE '%RJS%'")->row("jml");
                //stok 
                $_stokbrj  = $this->db->query("SELECT SUM(ukuran_ori) as jml FROM data_ig WHERE konstruksi='$val' AND no_beam NOT LIKE '%bsm%' AND dep='RJS' AND loc_now LIKE '%RJS%'")->row("jml");
                $_stokbsm  = $this->db->query("SELECT SUM(ukuran_ori) as jml FROM data_ig WHERE konstruksi='$val' AND no_beam LIKE '%bsm%' AND dep='RJS' AND loc_now LIKE '%RJS%'")->row("jml");
                //stok BS
                $_stokBSbrj  = $this->db->query("SELECT SUM(ukuran_bs) as jml FROM data_ig WHERE konstruksi='$val' AND no_beam NOT LIKE '%bsm%' AND dep='RJS' AND loc_now LIKE '%RJS%'")->row("jml");
                $_stokBSbsm  = $this->db->query("SELECT SUM(ukuran_bs) as jml FROM data_ig WHERE konstruksi='$val' AND no_beam LIKE '%bsm%' AND dep='RJS' AND loc_now LIKE '%RJS%'")->row("jml");
                //echo "$val -> $_rolbrj ($_stokbrj / $_stokBSbrj) -> $_rolbsm ($_stokbsm / $_stokBSbsm)<br>";
                
                $this->data_model->saved('lock_stok_rjs', [
                    'tanggal' => $tgl_sebelumnya,
                    'konstruksi' => $val,
                    'bsm' => $_stokbsm > 0 ? $_stokbsm:'0',
                    'brj' => $_stokbrj > 0 ? $_stokbrj:'0',
                    'rollbsm' => $_rolbsm > 0 ? $_rolbsm:'0',
                    'rollbrj' => $_rolbrj > 0 ? $_rolbrj:'0',
                    'bsbsm' => $_stokBSbsm > 0 ? $_stokBSbsm:'0',
                    'bsbrj' => $_stokBSbrj > 0 ? $_stokBSbrj:'0',
                    'tipe' => 'in'
                ]);
            }
        }
    }

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
    function loadpaketvalid(){
        $sj = $this->input->post('sj');
        $cek_sj = $this->data_model->get_byid('kiriman_pusatex', ['surat_jalan'=>$sj]);
        echo '<tr>
                    <td>Konstruksi</td>
                    <td>Kode Roll</td>
                    <td>Ukuran</td>
                    <td>Tujuan Proses</td>
                    <td>#</td>
                </tr>';
        foreach($cek_sj->result() as $val){
            $dd = $val->diterima_pusatex;
            echo "<tr>";
            echo "<td>".$val->konstruksi."</td>";
            echo "<td>".$val->kode_roll."</td>";
            echo "<td>".$val->ukuran."</td>";
            echo "<td>".$val->tujuan_proses."</td>";
            ?>
            <td><input type="checkbox" onclick="updateKode(this,'<?=$val->kode_roll;?>','<?=$sj;?>')" <?=$dd=='null' ? '':'checked';?>></td>
            <?php
            echo "</tr>";
        }
    } //end
    function validasikode(){
        $username = $this->input->post('username');
        $cek = $this->input->post('cek');
        $kode_roll = $this->input->post('kode_roll', TRUE);
        $sj = $this->input->post('sj');
        $dt = date('Y-m-d H:i:s');
        $rows = $this->data_model->get_byid('kiriman_pusatex',['kode_roll'=>$kode_roll])->row_array();
        $_kons = strtoupper($rows['konstruksi']);
        $tujuan_proses = $rows['tujuan_proses'];
        $ukuran = $rows['ukuran'];
        if($cek == "yes"){
            $this->db->query("UPDATE kiriman_pusatex SET operator='$username', diterima_pusatex='$dt' WHERE kode_roll='$kode_roll'");
            $this->data_model->saved('data_igtujuan',['kode_roll'=>$kode_roll,'konstruksi'=>$_kons,'ukuran'=>$ukuran,'tujuan_proses'=>$tujuan_proses]);
            echo "1";
        } else {
            echo "2";
            $this->db->query("UPDATE kiriman_pusatex SET operator='null', diterima_pusatex='null' WHERE kode_roll='$kode_roll'");
            $this->db->query("DELETE FROM data_igtujuan WHERE kode_roll='$kode_roll'");
        }
        echo "oke";
    }
    function loadStokFolding(){
        $kons = $this->db->query("SELECT DISTINCT konstruksi FROM data_fol WHERE posisi='Pusatex' OR posisi LIKE '%PKT%'");
        if($kons->num_rows() > 0){
            echo '<tr>
                        <th>Konstruksi</th>
                        <th>Grey</th>
                        <th>On PKT</th>
                        <th style="color:blue;">Finish</th>
                        <th style="color:blue;">On PKT</th>
                    </tr>';
            foreach($kons->result() as $k){
                $_kons = $k->konstruksi;
                $chto = $this->data_model->get_byid('tb_konstruksi',['kode_konstruksi'=>$_kons])->row("chto");
                if($chto=="null" OR $chto=="NULL"){
                    $_ch = "";
                } else {
                    $_ch = "<font style='color:blue'>".$chto."</font>";;
                }
                $gr = $this->db->query("SELECT SUM(ukuran) AS jml FROM data_fol WHERE konstruksi='$_kons' AND jns_fold='Grey' AND posisi='Pusatex'")->row("jml");
                if(floatval($gr)>0){
                    if(floor($gr) == $gr){
                        $gr = number_format($gr,0,',','.');
                    } else {
                        $gr = number_format($gr,2,',','.');
                    }
                } else {
                    $gr = "0";
                }
                $gr2 = $this->db->query("SELECT SUM(ukuran) AS jml FROM data_fol WHERE konstruksi='$_kons' AND jns_fold='Grey' AND posisi LIKE '%PKT%'")->row("jml");
                if(floatval($gr2)>0){
                    if(floor($gr2) == $gr2){
                        $gr2 = number_format($gr2,0,',','.');
                    } else {
                        $gr2 = number_format($gr2,2,',','.');
                    }
                } else {
                    $gr2 = "0";
                }
                $fn = $this->db->query("SELECT SUM(ukuran) AS jml FROM data_fol WHERE konstruksi='$_kons' AND jns_fold='Finish' AND posisi='Pusatex'")->row("jml");
                if(floatval($fn)>0){
                    if(floor($fn) == $fn){
                        $fn = number_format($fn,0,',','.');
                    } else {
                        $fn = number_format($fn,2,',','.');
                    }
                } else {
                    $fn = "0";
                }
                $fn2 = $this->db->query("SELECT SUM(ukuran) AS jml FROM data_fol WHERE konstruksi='$_kons' AND jns_fold='Finish' AND posisi LIKE '%PKT%'")->row("jml");
                if(floatval($fn2)>0){
                    if(floor($fn2) == $fn2){
                        $fn2 = number_format($fn2,0,',','.');
                    } else {
                        $fn2 = number_format($fn2,2,',','.');
                    }
                } else {
                    $fn2 = "0";
                }
                echo "<tr>";
                echo "<td>$_kons / $_ch</td>";
                echo "<td style='text-align:center;'>$gr</td>";
                echo "<td style='text-align:center;'>$gr2</td>";
                echo "<td style='text-align:center;color:blue;'>$fn</td>";
                echo "<td style='text-align:center;color:blue;'>$fn2</td>";
                echo "</tr>";
            }
        } else {
            echo '<tr>
                        <th>Konstruksi</th>
                        <th>Grey</th>
                        <th style="color:#0657c9;">Finish</th>
                    </tr>
                    <tr>
                        <td colspan="3">Stok Gudang Kosong</td>
                    </tr>';
        }
        
    }

    function carikodeig(){
        $kode = $this->input->post('kode');
        $kode = strtoupper($kode);
        $cekKode = $this->data_model->get_byid('data_ig', ['kode_roll'=>$kode]);
        if($cekKode->num_rows() == 1){
            $kode_roll = $cekKode->row("kode_roll");
            $konstruksi = $cekKode->row("konstruksi");
            $no_mesin = $cekKode->row("no_mesin");
            $ukuran_ori = $cekKode->row("ukuran_ori");
            echo json_encode(array("statusCode"=>200, "kode_roll"=>$kode_roll, "konstruksi"=>$konstruksi, "no_mesin"=>$no_mesin, "ukuran_ori"=>$ukuran_ori));
        } else {
            echo json_encode(array("statusCode"=>500, "psn"=>"Kode tidak ditemukan"));
        }
    }

}