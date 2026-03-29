<div class="nav-container primary-menu">
    <div class="mobile-topbar-header">
        <div>
            <img src="<?php echo base_url() ?>public/assets/images/kafe.png" alt="logo icon" width="80">
        </div>
        <div>
            <!-- <h4 class="logo-text">App Coffe</h4> -->
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <nav class="navbar navbar-expand-xl w-100">
        <ul class="navbar-nav justify-content-start flex-grow-1 gap-1">
            <li class="nav-item">
                <a class="nav-link                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php echo uri_string() == 'home' ? 'active text-white' : '' ?>"
                    href="<?php echo base_url('home') ?>">
                    <div class="parent-icon">
                        <i class='bx bx-home-circle'></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="javascript:;"
                    class="nav-link dropdown-toggle dropdown-toggle-nocaret                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php echo uri_string() == 'master/makanan' || uri_string() == 'master/minuman' || uri_string() == 'master/meja' || uri_string() == 'master/setting' || uri_string() == 'setting' ? 'active text-white' : '' ?>"
                    data-bs-toggle="dropdown">
                    <div class="parent-icon"><i class="bx bx-category"></i>
                    </div>
                    <div class="menu-title">Master Data</div>
                </a>
                <ul class="dropdown-menu">
                    <?php if ($this->session->userdata('level') !== 'Mitra') {?>
                    <li>
                        <a class="dropdown-item" href="<?php echo base_url('master/meja') ?>"><i
                                class="bx bx-right-arrow-alt"></i>
                            Data Meja
                        </a>
                    </li>
                    <?php }?>
                    <li>
                        <a class="dropdown-item" href="<?php echo base_url('master/makanan') ?>">
                            <i class="bx bx-right-arrow-alt"></i>
                            Data Makanan
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?php echo base_url('master/minuman') ?>"><i
                                class="bx bx-right-arrow-alt"></i>
                            Data Minuman
                        </a>
                    </li>
                    <?php if ($this->session->userdata('level') != 'Kasir' && $this->session->userdata('level') != 'Mitra') {?>
                    <li>
                        <a class="dropdown-item" href="<?php echo base_url('setting') ?>">
                            <i class="bx bx-right-arrow-alt"></i>
                            Setting Struk
                        </a>
                    </li>
                    <?php }?>
                    <?php if ($this->session->userdata('level') != 'Kasir' && $this->session->userdata('level') != 'Mitra') {?>
                    <li>
                        <a class="dropdown-item" href="<?php echo base_url('master/sdm') ?>">
                            <i class="bx bx-right-arrow-alt"></i>
                            Data SDM
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?php echo base_url('master/mitra') ?>">
                            <i class="bx bx-right-arrow-alt"></i>
                            Data Mitra
                        </a>
                    </li>
                    <?php }?>
                </ul>
            </li>
            <?php if ($this->session->userdata('level') !== 'Mitra') {?>
            <li class="nav-item dropdown">
                <a href="javascript:;"
                    class="nav-link dropdown-toggle dropdown-toggle-nocaret
					<?php echo uri_string() == 'transaksi/pesanan' || uri_string() == 'transaksi/invoice' || uri_string() == 'transaksi/takeaway' ? 'active text-white' : '' ?>"
                    data-bs-toggle="dropdown">
                    <div class="parent-icon"><i class='bx bx-cart'></i>
                    </div>
                    <div class="menu-title">Transaksi</div>
                </a>
                <ul class="dropdown-menu">
                    <?php if ($this->session->userdata('level') == 'Kasir') {?>
                    <li>
                        <a class="dropdown-item" href="<?php echo base_url('transaksi/pesanan') ?>">
                            <i class="bx bx-right-arrow-alt"></i>
                            Dine-in POS
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?php echo base_url('transaksi/takeaway') ?>">
                            <i class="bx bx-right-arrow-alt"></i>
                            Takeaway POS
                        </a>
                    </li>
                    <?php }?>
                    <li>
                        <a class="dropdown-item" href="<?php echo base_url('transaksi/invoice') ?>">
                            <i class="bx bx-right-arrow-alt"></i>
                            Dine-in List Transaksi
                        </a>
                    </li>
                </ul>
            </li>
            <?php }?>
            <?php if ($this->session->userdata('level') !== 'Mitra') {?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret
        <?php echo uri_string() == 'report/periode' ? 'active text-white' : '' ?>" href="javascript:;"
                    data-bs-toggle="dropdown">
                    <div class="parent-icon"><i class="bx bx-line-chart"></i>
                    </div>
                    <div class="menu-title">Report</div>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="<?php echo base_url("report/periode"); ?>">
                            <i class="bx bx-right-arrow-alt"></i>
                            Transaksi Periode
                        </a>
                    </li>
                </ul>
            </li>
            <?php }?>
        </ul>
    </nav>
</div>
