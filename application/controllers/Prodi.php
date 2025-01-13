<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Prodi extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('ProdiModel');
    }

    public function index()
    {
        $data['title'] = "Halaman Program Studi | SIMDAWA-APP";
        $data['prodi'] = $this->ProdiModel->get_prodi();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('prodi/prodi_read', $data);
        $this->load->view('template/footer');
    }

    public function tambah()
    {
        if (isset($_POST['create'])) {
            $this->ProdiModel->insert_prodi();
            redirect('prodi');
        } else {
            $data['title'] = "Tambah Data Program Studi | SIMDAWA-APP";
            $data['prodi'] = $this->ProdiModel->get_prodi();
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('prodi/prodi_create', $data);
            $this->load->view('template/footer');
        }
    }

    public function ubah($id)
    {
        if (isset($_POST['update'])) {
            $this->ProdiModel->update_prodi();
            redirect('prodi');
        } else {
            $data['title'] = "Perbaharui Data Program Studi | SIMDAWA-APP";
            $data['prodi'] = $this->ProdiModel->get_prodi_byid($id);
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('prodi/prodi_update', $data);
            $this->load->view('template/footer');
        }
    }

    public function hapus($id)
    {
        if (isset($id)) {
            $this->ProdiModel->delete_prodi($id);
            redirect('prodi');
        }
    }
}
