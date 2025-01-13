<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BeasiswaModel extends CI_Model
{
    private $table = 'beasiswa';

    public function get_beasiswa()
    {
        $this->db->select('beasiswa.*, jenis_beasiswa.nama_jenis, jenis_beasiswa.keterangan');
        $this->db->from($this->table);
        $this->db->join('jenis_beasiswa', 'beasiswa.jenis_id = jenis_beasiswa.id');
        return $this->db->get()->result();

        // $q = "SELECT beasiswa.*, jenis_beasiswa.nama_jenis, jenis_beasiswa.keterangan FROM beasiswa INNER JOIN jenis_beasiswa ON beasiswa.jenis_id = jenis_beasiswa.id";

        // return $this->db->query($q)->result();
    }

    public function get_beasiswa_byid($id)
    {
        // $this->db->select('beasiswa.*, jenis_beasiswa.nama_jenis as jenis');
        // $this->db->from($this->table);
        // $this->db->join('jenis_beasiswa', 'beasiswa.jenis_id = jenis_beasiswa.id');
        // $this->db->where('beasiswa.id', $id);
        // return $this->db->get()->row();

        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function insert_beasiswa()
    {
        $data = [
            'nama_beasiswa' => $this->input->post('nama_beasiswa'),
            'tanggal_mulai' => $this->input->post('tanggal_mulai'),
            'tanggal_selesai' => $this->input->post('tanggal_selesai'),
            'jenis_id' => $this->input->post('jenis_id'),
        ];
        $this->db->insert($this->table, $data);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('pesan', 'Data beasiswa berhasil ditambahkan!');
            $this->session->set_flashdata('status', true);
        } else {
            $this->session->set_flashdata('pesan', 'Data beasiswa gagal ditambahkan!');
            $this->session->set_flashdata('status', false);
        }
    }

    public function update_beasiswa($id)
    {
        $data = [
            'nama_beasiswa' => $this->input->post('nama_beasiswa'),
            'tanggal_mulai' => $this->input->post('tanggal_mulai'),
            'tanggal_selesai' => $this->input->post('tanggal_selesai'),
            'jenis_id' => $this->input->post('jenis_id'),
        ];
        //$this->db->where('id', $id);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update($this->table, $data);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('pesan', 'Data beasiswa berhasil diperbaharui!');
            $this->session->set_flashdata('status', true);
        } else {
            $this->session->set_flashdata('pesan', 'Data beasiswa gagal diperbaharui!');
            $this->session->set_flashdata('status', false);
        }
    }

    public function delete_beasiswa($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('pesan', 'Data beasiswa berhasil dihapus!');
            $this->session->set_flashdata('status', true);
        } else {
            $this->session->set_flashdata('pesan', 'Data beasiswa gagal dihapus!');
            $this->session->set_flashdata('status', false);
        }
    }
}
