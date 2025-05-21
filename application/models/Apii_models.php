<?php

class Apii_models extends CI_model
{
    public function getAllPotongan($id = null)
    {
        return $this->db->get_where('new_tb_isi', ['kd'=>$id]);
    }
    public function getAllPotongan2($id = null)
    {
        return $this->db->get_where('data_fol', ['kode_roll'=>$id]);
    }
    public function deletePotongan($id){
        $this->db->delete('produksi_mesin_ajl_potongan', ['id_potongan'=>$id]);
        return $this->db->affected_rows();
    } //end
    public function deleteInspect($id){
        $this->db->delete('produksi_inspect', ['kode_roll'=>$id]);
        return $this->db->affected_rows();
    } //end

    public function createPotongan($data){
        $this->db->insert('produksi_mesin_ajl_potongan', $data);
        return $this->db->affected_rows();

    } //end
    public function updatePotongan($data, $id){
        $this->db->update('produksi_mesin_ajl_potongan', $data, ['id_potongan'=>$id]);
        return $this->db->affected_rows();
    } //end
    public function createInspect($data){
        $this->db->insert('produksi_inspect', $data);
        return $this->db->affected_rows();

    } //end


}
