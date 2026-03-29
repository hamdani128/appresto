<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Master</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Setting Struk</li>
                    </ol>
                </nav>
            </div>
        </div>

        <h6 class="mb-0 text-uppercase">Master Setting Struk Kasir</h6>
        <hr />

        <div class="row">
            <div class="col-12 col-xl-8">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-1"><?php echo isset($setting) && $setting ? 'Update Setting' : 'Input Setting'; ?>
                        </h6>
                        <p class="mb-0 text-muted small">Data ini disiapkan untuk default format cetak struk kasir.
                            Tabel hanya dipakai satu baris data.</p>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo base_url('setting/save'); ?>" method="post"
                            enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="company" class="form-label">Company</label>
                                <input type="text" name="company" id="company" class="form-control"
                                    placeholder="Masukkan nama company"
                                    value="<?php echo isset($setting->company) ? htmlspecialchars($setting->company, ENT_QUOTES, 'UTF-8') : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" id="address" rows="4" class="form-control"
                                    placeholder="Masukkan alamat company"><?php echo isset($setting->address) ? htmlspecialchars($setting->address, ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="logo" class="form-label">Logo</label>
                                <input type="file" name="logo" id="logo" class="form-control"
                                    accept=".jpg,.jpeg,.png,.gif,.svg,.webp">
                                <small class="text-muted d-block mt-2">
                                    <?php echo isset($setting) && $setting ? 'Kosongkan jika tidak ingin mengganti logo.' : 'Upload logo untuk header struk kasir.'; ?>
                                </small>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save"></i>
                                    <?php echo isset($setting) && $setting ? 'Update Setting' : 'Simpan Setting'; ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-1">Preview Data Aktif</h6>
                        <p class="mb-0 text-muted small">Nilai di bawah ini akan dipakai sebagai master default untuk
                            struk kasir.</p>
                    </div>
                    <div class="card-body">
                        <?php if (isset($setting) && $setting) {?>
                        <div class="text-center mb-3">
                            <?php if (! empty($setting->logo)) {?>
                            <img src="<?php echo base_url('public/upload/' . $setting->logo); ?>" alt="Logo Setting"
                                class="img-fluid rounded border p-2" style="max-height: 180px;">
                            <?php } else {?>
                            <div class="border rounded p-4 text-muted">Logo belum diupload</div>
                            <?php }?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Company</label>
                            <div class="fw-semibold">
                                <?php echo htmlspecialchars($setting->company, ENT_QUOTES, 'UTF-8'); ?></div>
                        </div>
                        <div>
                            <label class="form-label text-muted">Address</label>
                            <div><?php echo nl2br(htmlspecialchars($setting->address, ENT_QUOTES, 'UTF-8')); ?></div>
                        </div>
                        <?php } else {?>
                        <div class="alert alert-warning mb-0">
                            Setting belum diinput. Silakan isi form sekali untuk membuat master default struk kasir.
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($this->session->flashdata('setting_message')) {?>
<script>
Swal.fire({
    icon: '<?php echo $this->session->flashdata('setting_status') === 'success' ? 'success' : 'error'; ?>',
    title: '<?php echo $this->session->flashdata('setting_status') === 'success' ? 'Berhasil' : 'Gagal'; ?>',
    text: '<?php echo addslashes($this->session->flashdata('setting_message')); ?>'
});
</script>
<?php }?>
