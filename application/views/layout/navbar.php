<div class="nav-container primary-menu">
    <div class="mobile-topbar-header">
        <div>
            <img src="<?=base_url()?>public/assets/images/millennialpos.png" alt="logo icon">
        </div>
        <div>
            <!-- <h4 class="logo-text">App The'Coffe</h4> -->
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <nav class="navbar navbar-expand-xl w-100">
        <ul class="navbar-nav justify-content-start flex-grow-1 gap-1">
            <li class="nav-item">
                <a class="nav-link <?=uri_string() == 'home' ? 'active text-white' : ''?>" href="<?=base_url('home')?>">
                    <div class="parent-icon">
                        <i class='bx bx-home-circle'></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="javascript:;"
                    class="nav-link dropdown-toggle dropdown-toggle-nocaret <?=uri_string() == 'master/makanan' || uri_string() == 'master/minuman' || uri_string() == 'master/meja' ? 'active text-white' : ''?>"
                    data-bs-toggle="dropdown">
                    <div class="parent-icon"><i class="bx bx-category"></i>
                    </div>
                    <div class="menu-title">Master Data</div>
                </a>
                <ul class="dropdown-menu">
                    <?php if ($this->session->userdata('level') !== 'Mitra') {?>
                    <li>
                        <a class="dropdown-item" href="<?=base_url('master/meja')?>"><i
                                class="bx bx-right-arrow-alt"></i>
                            Data Meja
                        </a>
                    </li>
                    <?php }?>
                    <li>
                        <a class="dropdown-item" href="<?=base_url('master/makanan')?>">
                            <i class="bx bx-right-arrow-alt"></i>
                            Data Makanan
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?=base_url('master/minuman')?>"><i
                                class="bx bx-right-arrow-alt"></i>
                            Data Minuman
                        </a>
                    </li>
                    <?php if ($this->session->userdata('level') != 'Kasir') {?>
                    <li>
                        <a class="dropdown-item" href="<?=base_url('master/sdm')?>">
                            <i class="bx bx-right-arrow-alt"></i>
                            Data SDM
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?=base_url('master/mitra')?>">
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
                    class="nav-link dropdown-toggle dropdown-toggle-nocaret <?=uri_string() == 'transaksi/pesanan' ? 'active text-white' : ''?>"
                    data-bs-toggle="dropdown">
                    <div class="parent-icon"><i class='bx bx-cart'></i>
                    </div>
                    <div class="menu-title">Transaksi</div>
                </a>
                <ul class="dropdown-menu">
                    <?php if ($this->session->userdata('level') == 'Kasir') {?>
                    <li>
                        <a class="dropdown-item" href="<?=base_url('transaksi/pesanan')?>">
                            <i class="bx bx-right-arrow-alt"></i>
                            Pesanan
                        </a>
                    </li>
                    <?php }?>
                    <li>
                        <a class="dropdown-item" href="ecommerce-products.html">
                            <i class="bx bx-right-arrow-alt"></i>
                            List Transaksi
                        </a>
                    </li>
                </ul>
            </li>
            <?php }?>
            <?php if ($this->session->userdata('level') !== 'Mitra') {?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;"
                    data-bs-toggle="dropdown">
                    <div class="parent-icon"><i class="bx bx-line-chart"></i>
                    </div>
                    <div class="menu-title">Report</div>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="charts-apex-chart.html">
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