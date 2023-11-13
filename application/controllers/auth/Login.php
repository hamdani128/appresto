<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $this->load->view('auth/login');
    }

    public function cek_login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $where = array(
            'username' => $username,
            'password' => md5($password)
        );
        $cek = $this->db->where($where)->get("users")->row();
        // $cek = $this->m_login->cek_login("cdpm_users", $where)->num_rows();
        // $value = $this->m_login->cek_login("cdpm_users", $where)->row();
        if (!empty($cek)) {
            $data_session = array(
                'nama' => $username,
                'fullname' => $cek->fullname,
                'email' => $cek->email,
                'log_in' => "login",
                'user_id' => $cek->id,
                'level' => $cek->level,
            );
            $this->session->set_userdata($data_session);
            $response = [
                'status' => 'success',
                'message' => 'Login successful',
            ];
            echo json_encode($response);
            // redirect(base_url("admin"));
        } else {
            // echo "Username dan password salah !";
            $response = [
                'status' => 'gagal',
                'message' => 'Username dan password salah !',
            ];
            echo json_encode($response);
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('auth/login'));
    }
}