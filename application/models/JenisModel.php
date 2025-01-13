<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JenisModel extends CI_Model
{

    private $table = 'jenis_beasiswa';

    public function get_jenis()
    {
        return $this->db->get($this->table)->result();
    }

    public function insert_jenis()
    {
        $data = [
            'nama_jenis' => $this->input->post('nama_jenis'),
            'keterangan' => $this->input->post('keterangan'),
        ];

        $this->db->insert($this->table, $data);
    }

    public function update_jenis()
    {
        $data = [
            'nama_jenis' => $this->input->post('nama_jenis'),
            'keterangan' => $this->input->post('keterangan')
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update($this->table, $data);
    }

    public function get_jenis_byid($id)
    {
        return $this->db->get_where($this->table, ['id=>$id'])->row();
    }

    public function delete_jenis($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }
}
