<?php
class PendaftaranModel extends CI_Model
{
    private $tabel = 'pendaftaran_pengguna';

    public function get_pendaftaran()
    {
        return $this->db->get($this->table)->result();
    }

    // Mengecek apakah nomor pendaftaran sudah ada
    public function cek_nopendaftaran()
    {
        $no_pendaftaran = $this->input->post('no_pendaftaran', true); // Validasi input
        if (!$no_pendaftaran) {
            return false; // Jika input kosong, langsung return false
        }

        $cek = $this->db->get_where($this->tabel, ['no_pendaftaran' => $no_pendaftaran]);
        return $cek->num_rows() > 0; // Return true jika ada data
    }

    // Fungsi untuk upload bukti pendaftaran
    public function upload_bukti($file)
    {
        $upload_dir = './upload/bukti_daftar/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true); // Buat folder jika belum ada
        }

        $config['upload_path'] = $upload_dir;
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '1024'; // Ukuran maksimal 1MB
        $config['remove_space'] = true;

        $this->load->library('upload', $config);
        if ($this->upload->do_upload($file)) {
            return ['result' => 'success', 'file' => $this->upload->data(), 'error' => ''];
        } else {
            return ['result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors()];
        }
    }

    // Menambahkan data pendaftaran
    public function insert_pendaftaran($file)
    {
        $this->db->trans_start(); // Mulai transaksi

        $data = [
            'no_pendaftaran' => $this->input->post('no_pendaftaran', true),
            'nama_lengkap' => $this->input->post('nama_lengkap', true),
            'no_handphone' => $this->input->post('no_handphone', true),
            'bukti_daftar' => $file['file']['file_name'], // Nama file upload
            'keterangan' => 'Belum Diverifikasi'
        ];
        $this->db->insert($this->tabel, $data);

        if ($this->db->affected_rows() > 0) {
            $id = $this->db->insert_id();
            $this->insert_pengguna($id); // Masukkan data pengguna
        }

        $this->db->trans_complete(); // Selesaikan transaksi
        if ($this->db->trans_status() === false) {
            $this->session->set_flashdata("pesan", "Terjadi kesalahan saat menyimpan data!");
            $this->session->set_flashdata("status", false);
        }
    }

    // Menambahkan data pengguna terkait pendaftaran
    public function insert_pengguna($id)
    {
        $data = [
            'username' => $this->input->post('no_pendaftaran', true),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT), // Hash password
            'peran' => 'user',
            'pendaftaran_id' => $id
        ];
        $this->db->insert('pengguna', $data);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("pesan", "Data pendaftaran berhasil ditambahkan! Akun akan diverifikasi dalam 1 x 24 jam.");
            $this->session->set_flashdata("status", true);
        } else {
            $this->session->set_flashdata("pesan", "Data pendaftaran gagal ditambahkan!");
            $this->session->set_flashdata("status", false);
        }
    }

    // Verifikasi akun pengguna
    public function verifikasi_akun($status, $id)
    {
        $this->db->where('id', $id);
        $this->db->update($this->tabel, ['keterangan' => $status]);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("pesan", "Verifikasi akun berhasil.");
            $this->session->set_flashdata("status", true);
        } else {
            $this->session->set_flashdata("pesan", "Verifikasi akun gagal atau ID tidak ditemukan!");
            $this->session->set_flashdata("status", false);
        }
    }
}
