<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PersyaratanModel extends CI_Model
{

    private $table = 'persyaratan';

    public function get_persyaratan()
    {
        return $this->db->get($this->table)->result();
    }

    public function insert_persyaratan()
    {
        $data = [
            'nama_persyaratan' => $this->input->post('nama_persyaratan'),
            'keterangan' => $this->input->post('keterangan'),
        ];

        $this->db->insert($this->table, $data);
    }

    public function update_persyaratan()
    {
        $data = [
            'nama_persyaratan' => $this->input->post('nama_persyaratan'),
            'keterangan' => $this->input->post('keterangan')
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update($this->table, $data);
    }

    public function get_persyaratan_byid($id)
    {
        return $this->db->get_where($this->table, ['id=>$id'])->row();
    }

    public function delete_persyaratan($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }
}
