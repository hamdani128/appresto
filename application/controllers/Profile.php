<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB $db
 * @property CI_Session $session
 * @property CI_Output $output
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 */
class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(["url", "form"]);
        $this->load->library("upload");
        $this->session->sess_expiration      = '60';
        $this->session->sess_expire_on_close = 'true';
        if ($this->session->userdata('log_in') != "login") {
            redirect(base_url("auth/login"));
        }
    }

    public function index()
    {
        $user = $this->get_current_user();

        $data = [
            'content'             => 'pages/profile',
            'profile_user'        => $user,
            'profile_image_field' => $this->detect_profile_image_field(),
            'profile_image_url'   => $this->build_profile_image_url($this->get_profile_image_name($user)),
        ];

        $this->load->view('layout/index', $data);
    }

    public function update_photo()
    {
        $user = $this->get_current_user();
        $imageField = $this->detect_profile_image_field();

        if (! $user) {
            $this->session->set_flashdata('profile_error', 'Data user tidak ditemukan.');
            return redirect(base_url('profile'));
        }

        if ($imageField === null) {
            $this->session->set_flashdata('profile_error', 'Kolom image profile pada tabel users belum ditemukan.');
            return redirect(base_url('profile'));
        }

        if (empty($_FILES['profile_image']['name'])) {
            $this->session->set_flashdata('profile_error', 'Silakan pilih file image terlebih dahulu.');
            return redirect(base_url('profile'));
        }

        $config['upload_path']   = FCPATH . 'public/upload/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['max_size']      = 2048;
        $config['encrypt_name']  = true;

        $this->upload->initialize($config);

        if (! $this->upload->do_upload('profile_image')) {
            $this->session->set_flashdata('profile_error', strip_tags($this->upload->display_errors('', '')));
            return redirect(base_url('profile'));
        }

        $uploadData = $this->upload->data();
        $fileName   = $uploadData['file_name'];
        $oldImage   = $this->get_profile_image_name($user);

        $this->db->where('id', $user->id)->update('users', [
            $imageField  => $fileName,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if (! empty($oldImage) && $oldImage !== $fileName) {
            $oldPath = FCPATH . 'public/upload/' . $oldImage;
            if (is_file($oldPath)) {
                @unlink($oldPath);
            }
        }

        $this->session->set_flashdata('profile_success', 'Foto profile berhasil diperbarui.');
        return redirect(base_url('profile'));
    }

    public function update_password()
    {
        $user = $this->get_current_user();

        if (! $user) {
            $this->session->set_flashdata('password_error', 'Data user tidak ditemukan.');
            return redirect(base_url('profile'));
        }

        $currentPassword = trim((string) $this->input->post('current_password'));
        $newPassword     = trim((string) $this->input->post('new_password'));
        $confirmPassword = trim((string) $this->input->post('confirm_password'));

        if ($currentPassword === '' || $newPassword === '' || $confirmPassword === '') {
            $this->session->set_flashdata('password_error', 'Semua field password wajib diisi.');
            return redirect(base_url('profile'));
        }

        if (($user->password ?? '') !== md5($currentPassword)) {
            $this->session->set_flashdata('password_error', 'Password saat ini tidak sesuai.');
            return redirect(base_url('profile'));
        }

        if (strlen($newPassword) < 4) {
            $this->session->set_flashdata('password_error', 'Password baru minimal 4 karakter.');
            return redirect(base_url('profile'));
        }

        if ($newPassword !== $confirmPassword) {
            $this->session->set_flashdata('password_error', 'Konfirmasi password baru tidak sama.');
            return redirect(base_url('profile'));
        }

        $newPasswordMd5 = md5($newPassword);

        $this->db->where('id', $user->id)->update('users', [
            'password'   => $newPasswordMd5,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->insert_password_history($user->username, $newPassword, $newPasswordMd5);

        $this->session->set_flashdata('password_success', 'Password berhasil diperbarui.');
        return redirect(base_url('profile'));
    }

    public function update_info()
    {
        $user = $this->get_current_user();

        if (! $user) {
            $this->session->set_flashdata('profile_error', 'Data user tidak ditemukan.');
            return redirect(base_url('profile'));
        }

        $fullname = trim((string) $this->input->post('fullname'));
        $email    = trim((string) $this->input->post('email'));

        if ($fullname === '') {
            $this->session->set_flashdata('profile_error', 'Nama lengkap wajib diisi.');
            return redirect(base_url('profile'));
        }

        if ($email !== '' && $email !== '-' && ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->session->set_flashdata('profile_error', 'Format email tidak valid.');
            return redirect(base_url('profile'));
        }

        $updateData = [
            'fullname'   => $fullname,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($this->db->field_exists('email', 'users')) {
            $updateData['email'] = $email === '' ? '-' : $email;
        }

        $this->db->where('id', $user->id)->update('users', $updateData);

        $this->session->set_userdata([
            'fullname' => $fullname,
            'email'    => $updateData['email'] ?? $this->session->userdata('email'),
        ]);

        $this->session->set_flashdata('profile_success', 'Informasi profile berhasil diperbarui.');
        return redirect(base_url('profile'));
    }

    private function get_current_user()
    {
        $username = $this->session->userdata('username');

        if ($username === null || $username === '') {
            return null;
        }

        return $this->db->where('username', $username)->get('users')->row();
    }

    private function detect_profile_image_field()
    {
        $fields = ['img_profile', 'profile_img', 'avatar', 'image', 'img', 'photo', 'foto'];

        foreach ($fields as $field) {
            if ($this->db->field_exists($field, 'users')) {
                return $field;
            }
        }

        return null;
    }

    private function get_profile_image_name($user)
    {
        if (! $user) {
            return '';
        }

        $imageField = $this->detect_profile_image_field();
        if ($imageField === null || ! isset($user->{$imageField})) {
            return '';
        }

        return trim((string) $user->{$imageField});
    }

    private function build_profile_image_url($fileName)
    {
        if (! empty($fileName)) {
            return base_url('public/upload/' . $fileName);
        }

        return base_url('public/assets/images/avatars/avatar-2.png');
    }

    private function insert_password_history($username, $plainPassword, $passwordHash)
    {
        if (! $this->db->table_exists('history_password')) {
            return;
        }

        $data = [];

        if ($this->db->field_exists('username', 'history_password')) {
            $data['username'] = $username;
        }
        if ($this->db->field_exists('password', 'history_password')) {
            $data['password'] = $plainPassword;
        }
        if ($this->db->field_exists('password_hash', 'history_password')) {
            $data['password_hash'] = $passwordHash;
        }
        if ($this->db->field_exists('created_at', 'history_password')) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        if ($this->db->field_exists('created_by', 'history_password')) {
            $data['created_by'] = $this->session->userdata('username');
        }

        if (! empty($data)) {
            $this->db->insert('history_password', $data);
        }
    }
}
