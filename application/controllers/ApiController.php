<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class ApiController extends REST_Controller {
    
    public function get_data($id1, $id2) {
        // Load database
        $this->load->database();

        // Query data berdasarkan dua ID
        $this->db->where_in('id_kdlist', [$id1, $id2]);
        $query = $this->db->get('new_tb_isi'); // Ganti dengan nama tabel di database

        // Cek apakah ada data
        if ($query->num_rows() > 0) {
            $response = [
                "status" => true,
                "jumlahData" => $query->num_rows(),
                "data" => $query->result()
            ];
        } else {
            $response = [
                "status" => false,
                "message" => "Data tidak ditemukan"
            ];
        }

        // Output dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
?>
