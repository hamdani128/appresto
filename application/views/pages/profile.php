<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Account</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>

        <style>
            .profile-hero-card {
                border: 0;
                border-radius: 20px;
                background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 100%);
                color: #fff;
                overflow: hidden;
                box-shadow: 0 18px 40px rgba(15, 23, 42, 0.14);
            }

            .profile-panel-card {
                border: 1px solid #e2e8f0;
                border-radius: 20px;
                box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
            }

            .profile-avatar {
                width: 120px;
                height: 120px;
                object-fit: cover;
                border-radius: 24px;
                border: 4px solid rgba(255, 255, 255, 0.35);
                background: #fff;
            }

            .profile-mini-label {
                font-size: 0.78rem;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: #94a3b8;
                margin-bottom: 0.35rem;
            }

            .profile-stat-box {
                border-radius: 16px;
                background: #f8fafc;
                padding: 1rem;
                height: 100%;
            }

            .profile-preview-avatar {
                width: 150px;
                height: 150px;
                object-fit: cover;
                border-radius: 28px;
                border: 4px solid #fff;
                box-shadow: 0 14px 30px rgba(15, 23, 42, 0.12);
                background: #fff;
            }
        </style>

        <?php if ($this->session->flashdata('profile_success')): ?>
        <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success">
            <?php echo $this->session->flashdata('profile_success'); ?>
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('profile_error')): ?>
        <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger">
            <?php echo $this->session->flashdata('profile_error'); ?>
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('password_success')): ?>
        <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success">
            <?php echo $this->session->flashdata('password_success'); ?>
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('password_error')): ?>
        <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger">
            <?php echo $this->session->flashdata('password_error'); ?>
        </div>
        <?php endif; ?>

        <div class="card profile-hero-card mb-4">
            <div class="card-body p-4 p-lg-5">
                <div class="row align-items-center g-4">
                    <div class="col-lg-2 text-center text-lg-start">
                        <img src="<?php echo $profile_image_url; ?>" alt="Profile Image" class="profile-avatar">
                    </div>
                    <div class="col-lg-6">
                        <div class="text-uppercase small fw-semibold opacity-75 mb-2">Profile Pengguna</div>
                        <h3 class="fw-bold mb-2"><?php echo html_escape($profile_user->fullname ?? '-'); ?></h3>
                        <p class="mb-0 opacity-75">Halaman ini dipakai untuk update foto profile dan ganti password akun tanpa perlu buka data user di master terpisah.</p>
                    </div>
                    <div class="col-lg-4">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="profile-stat-box">
                                    <div class="profile-mini-label">Username</div>
                                    <div class="fw-semibold text-dark"><?php echo html_escape($profile_user->username ?? '-'); ?></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="profile-stat-box">
                                    <div class="profile-mini-label">Level</div>
                                    <div class="fw-semibold text-dark"><?php echo html_escape($profile_user->level ?? '-'); ?></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="profile-stat-box">
                                    <div class="profile-mini-label">Email</div>
                                    <div class="fw-semibold text-dark"><?php echo html_escape($profile_user->email ?? '-'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card profile-panel-card mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="rounded-4 bg-info bg-opacity-10 text-info d-inline-flex align-items-center justify-content-center"
                                style="width: 54px; height: 54px;">
                                <i class="bx bx-user-circle fs-3"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">Informasi Profile</h5>
                                <p class="text-muted mb-0">Ubah nama lengkap dan email akun aktif.</p>
                            </div>
                        </div>

                        <form action="<?php echo base_url('profile/update-info'); ?>" method="post">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Username</label>
                                    <input type="text" class="form-control" value="<?php echo html_escape($profile_user->username ?? '-'); ?>" readonly>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="fullname" value="<?php echo html_escape($profile_user->fullname ?? ''); ?>" placeholder="Masukkan nama lengkap">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="text" class="form-control" name="email" value="<?php echo html_escape($profile_user->email ?? ''); ?>" placeholder="Masukkan email">
                                </div>
                                <div class="col-12 d-grid">
                                    <button type="submit" class="btn btn-info text-white">
                                        <i class="bx bx-save"></i>
                                        Simpan Informasi Profile
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card profile-panel-card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="rounded-4 bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center"
                                style="width: 54px; height: 54px;">
                                <i class="bx bx-image-add fs-3"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">Update Foto Profile</h5>
                                <p class="text-muted mb-0">Upload foto baru untuk tampil di header akun.</p>
                            </div>
                        </div>

                        <form action="<?php echo base_url('profile/update-photo'); ?>" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Preview Foto Saat Ini</label>
                                <div class="border rounded-4 p-3 text-center bg-light">
                                    <img src="<?php echo $profile_image_url; ?>" alt="Current Profile" class="profile-preview-avatar" id="profileImagePreview">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Pilih Image Baru</label>
                                <input type="file" class="form-control" name="profile_image" id="profileImageInput" accept=".jpg,.jpeg,.png,.webp">
                                <small class="text-muted">Format: JPG, PNG, WEBP. Maksimal 2 MB.</small>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-upload"></i>
                                    Simpan Foto Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card profile-panel-card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="rounded-4 bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center"
                                style="width: 54px; height: 54px;">
                                <i class="bx bx-lock-alt fs-3"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">Update Password</h5>
                                <p class="text-muted mb-0">Perubahan password akan disimpan juga ke tabel history password.</p>
                            </div>
                        </div>

                        <form action="<?php echo base_url('profile/update-password'); ?>" method="post">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Username</label>
                                    <input type="text" class="form-control" value="<?php echo html_escape($profile_user->username ?? '-'); ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama Lengkap</label>
                                    <input type="text" class="form-control" value="<?php echo html_escape($profile_user->fullname ?? '-'); ?>" readonly>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Password Saat Ini</label>
                                    <input type="password" class="form-control" name="current_password" placeholder="Masukkan password saat ini">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Password Baru</label>
                                    <input type="password" class="form-control" name="new_password" placeholder="Masukkan password baru">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" name="confirm_password" placeholder="Ulangi password baru">
                                </div>
                                <div class="col-12">
                                    <div class="alert alert-light border rounded-4 mb-0">
                                        <strong>Catatan:</strong> Login aplikasi saat ini masih membaca password `md5`, jadi update password akan menyesuaikan sistem yang sudah berjalan dan sekaligus menyimpan riwayat ke `history_password`.
                                    </div>
                                </div>
                                <div class="col-12 d-grid d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-dark px-4">
                                        <i class="bx bx-save"></i>
                                        Simpan Password Baru
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const input = document.getElementById("profileImageInput");
    const preview = document.getElementById("profileImagePreview");

    if (!input || !preview) {
        return;
    }

    input.addEventListener("change", function(event) {
        const file = event.target.files && event.target.files[0];
        if (!file) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
});
</script>
