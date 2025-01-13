<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Persyaratan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('PersyaratanModel');
    }

    public function index()
    {
        $data['title'] = "Data Persyaratan | SIMDAWA-APP";
        $data['persyaratan'] = $this->PersyaratanModel->get_persyaratan();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('persyaratan/persyaratan_read', $data);
        $this->load->view('template/footer');
    }

    public function tambah()
    {
        if (isset($_POST['create'])) {
            $this->PersyaratanModel->insert_persyaratan();
            redirect('persyaratan');
        } else {
            $data['title'] = "Tambah Data Persyaratan | SIMDAWA-APP";
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('persyaratan/persyaratan_create', $data);
            $this->load->view('template/footer');
        }
    }

    public function ubah($id)
    {
        if (isset($_POST['update'])) {
            $this->PersyaratanModel->update_persyaratan();
            redirect('persyaratan');
        } else {
            $data['title'] = "Perbaharui Data Persyaratan | SIMDAWA-APP";
            $data['persyaratan'] = $this->PersyaratanModel->get_persyaratan_byid($id);
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('persyaratan/persyaratan_update', $data);
            $this->load->view('template/footer');
        }
    }

    public function hapus($id)
    {
        if (isset($id)) {
            $this->PersyaratanModel->delete_persyaratan($id);
            redirect('persyaratan');
        }
    }
}
