<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->load->library('form_validation');
    // }

    public function index()
    {
        //ambil data dulu dari tabel
        $data['apps'] = $this->db->get('mst_apps')->row_array();
        $this->form_validation->set_rules('userid', 'Userid', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('auth/login', $data);
        } else {
            $this->_login();
        }
    }



    private function _login()
    {
        $userid = $this->input->post('userid');
        $password = $this->input->post('password');

        //ambil data dari model
        $table = 'user';
        $where = array(
            'userid' => $userid,
        );
        $user = $this->Crud->get_where($table, $where)->row_array();
        // $user = $this->db->get_where('user', ['email' => $email])->row_array();
        // var_dump($user);
        // die;
        if ($user) {
            //cek dulu member aktive atau tidak
            if ($user['is_active'] == 1) {
                //cek password
                if (password_verify($password, $user['password'])) {
                    //jika sukses
                    $data = array(
                        'userid' => $user['userid'],
                        'role_id' => $user['role_id'],
                        'name' => $user['name'],
                        'nomor_induk' => $user['nomor_induk'],
                    );
                    //buat session
                    $this->session->set_userdata($data);
                    //cek role_id karyawan atau admin ?
                    if ($user['role_id'] == 1) {
                        redirect('dashboard');
                    } else if ($user['role_id'] == 2) {
                        redirect('dashboard');
                    } else if ($user['role_id'] == 3) {
                        redirect('dashboard');
                    } else if ($user['role_id'] == 4) {
                        redirect('dashboard');
                    } else if ($user['role_id'] == 5) {
                        redirect('dashboard');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Salah Password</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Userid belum aktif</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Userid tidak terdaftar</div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('nomor_induk');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Anda sudah keluar.</div>');
        redirect('auth');
    }
}
