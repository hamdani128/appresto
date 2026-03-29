<!doctype html>
<html lang="en" class="color-header headercolor2">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coffe App</title>
    <!--favicon-->
    <link rel="icon" href="<?php echo base_url() ?>public/assets/images/kafe.png" type="image/png" />
    <!--plugins-->
    <!--plugins-->
    <link rel="stylesheet" href="<?php echo base_url() ?>public/assets/plugins/notifications/css/lobibox.min.css" />
    <link href="<?php echo base_url() ?>public/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>public/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>public/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css"
        rel="stylesheet" />
    <!-- loader-->
    <link href="<?php echo base_url() ?>public/assets/css/pace.min.css" rel="stylesheet" />
    <script src="<?php echo base_url() ?>public/assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="<?php echo base_url() ?>public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>public/assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="<?php echo base_url() ?>public/assets/css/app.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>public/assets/css/icons.css" rel="stylesheet">
    <!-- datatable -->
    <link href="<?php echo base_url() ?>public/assets/plugins/datatable/css/dataTables.bootstrap5.min.css"
        rel="stylesheet" />
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo base_url() ?>public/assets/sweetalert/sweetalert2.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>public/assets/sweetalert/sweetalert2.min.css">

    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>public/assets/css/dark-theme.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>public/assets/css/semi-dark.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>public/assets/css/header-colors.css" />

    <style>
    body,
    .dark-theme,
    .header-dark {
        background: #F8F5F2 !important;
    }
    </style>


</head>


<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--start header wrapper-->
        <div class="header-wrapper">
            <!--start header -->
            <?php require_once "header.php"?>
            <!--end header -->
            <!--navigation-->
            <?php require_once "navbar.php"?>
            <!--end navigation-->
        </div>
        <!--end header wrapper-->
        <!--start page wrapper -->
        <?php if ($content) {?>
        <?php $this->load->view($content); ?>
        <?php }?>
        <!--end page wrapper -->
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        <footer class="page-footer">
            <p class="mb-0">Copyright © <?php date_default_timezone_set('Asia/Jakarta');
                                         echo date('Y')?>. All right
                reserved.</p>
        </footer>
    </div>
    <!--end wrapper-->
    <!--start switcher-->
    <div class="switcher-wrapper">
        <div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
        </div>
        <div class="switcher-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 text-uppercase">Theme Customizer</h5>
                <button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
            </div>
            <hr />
            <h6 class="mb-0">Theme Styles</h6>
            <hr />
            <div class="d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode" checked>
                    <label class="form-check-label" for="lightmode">Light</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode">
                    <label class="form-check-label" for="darkmode">Dark</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark">
                    <label class="form-check-label" for="semidark">Semi Dark</label>
                </div>
            </div>
            <hr />
            <div class="form-check">
                <input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault">
                <label class="form-check-label" for="minimaltheme">Minimal Theme</label>
            </div>
            <hr />
            <h6 class="mb-0">Header Colors</h6>
            <hr />
            <div class="header-colors-indigators">
                <div class="row row-cols-auto g-3">
                    <div class="col">
                        <div class="indigator headercolor1" id="headercolor1"></div>
                    </div>
                    <div class="col">
                        <div class="indigator headercolor2" id="headercolor2"></div>
                    </div>
                    <div class="col">
                        <div class="indigator headercolor3" id="headercolor3"></div>
                    </div>
                    <div class="col">
                        <div class="indigator headercolor4" id="headercolor4"></div>
                    </div>
                    <div class="col">
                        <div class="indigator headercolor5" id="headercolor5"></div>
                    </div>
                    <div class="col">
                        <div class="indigator headercolor6" id="headercolor6"></div>
                    </div>
                    <div class="col">
                        <div class="indigator headercolor7" id="headercolor7"></div>
                    </div>
                    <div class="col">
                        <div class="indigator headercolor8" id="headercolor8"></div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- Script Connect Bluetooth -->
    <script src="<?php echo base_url() ?>public/assets/custom/dom-to-image.min.js"></script>
    <script src="<?php echo base_url() ?>public/assets/custom/bluetooth-printer.js"></script>
    <!--end switcher-->
    <!-- Bootstrap JS -->
    <script src="<?php echo base_url() ?>public/assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="<?php echo base_url() ?>public/assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>public/assets/plugins/simplebar/js/simplebar.min.js"></script>

    <script src="<?php echo base_url() ?>public/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="<?php echo base_url() ?>public/assets/plugins/chartjs/chart.min.js"></script>
    <script src="<?php echo base_url() ?>public/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="<?php echo base_url() ?>public/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="<?php echo base_url() ?>public/assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js">
    </script>
    <script src="<?php echo base_url() ?>public/assets/plugins/sparkline-charts/jquery.sparkline.min.js"></script>
    <script src="<?php echo base_url() ?>public/assets/plugins/jquery-knob/excanvas.js"></script>
    <script src="<?php echo base_url() ?>public/assets/plugins/jquery-knob/jquery.knob.js"></script>

    <!--notification js -->
    <script src="<?php echo base_url() ?>public/assets/plugins/notifications/js/lobibox.min.js"></script>
    <script src="<?php echo base_url() ?>public/assets/plugins/notifications/js/notifications.min.js"></script>
    <script src="<?php echo base_url() ?>public/assets/plugins/notifications/js/notification-custom-script.js"></script>
    <!-- SweetAlert -->
    <script src="<?php echo base_url() ?>public/assets/sweetalert/sweetalert2.js"></script>
    <script src="<?php echo base_url() ?>public/assets/sweetalert/sweetalert2.min.js"></script>
    <script src="<?php echo base_url() ?>public/assets/sweetalert/sweetalert2.all.js"></script>
    <script src="<?php echo base_url() ?>public/assets/sweetalert/sweetalert2.all.min.js"></script>
    <!-- datatable -->
    <script src="<?php echo base_url() ?>public/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url() ?>public/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <!-- Angular -->
    <script src="<?php echo base_url() ?>public/assets/angular/angular.min.js"></script>
    <script src="<?php echo base_url() ?>public/assets/angular/angular-datatables.min.js"></script>
    <!-- csutom -->
    <script src="<?php echo base_url() ?>public/assets/custom/makanan.js"></script>
    <script src="<?php echo base_url() ?>public/assets/custom/minuman.js"></script>
    <script src="<?php echo base_url() ?>public/assets/custom/meja.js"></script>
    <script src="<?php echo base_url() ?>public/assets/custom/sdm.js"></script>
    <script src="<?php echo base_url() ?>public/assets/custom/kasir.js"></script>
    <script src="<?php echo base_url() ?>public/assets/custom/kasir_takeaway.js"></script>
    <script src="<?php echo base_url() ?>public/assets/custom/mitra.js"></script>
    <script src="<?php echo base_url() ?>public/assets/custom/report.js"></script>
    <script src="<?php echo base_url() ?>public/assets/custom/list_transaksi.js"></script>
    <script src="<?php echo base_url() ?>public/assets/custom/home-kasir.js"></script>
    <script src="<?php echo base_url() ?>public/assets/custom/home-mitra.js"></script>
    <script src="<?php echo base_url() ?>public/assets/custom/notify-mitra.js"></script>

    <script src="<?php echo base_url() ?>public/assets/js/index.js"></script>
    <!--app JS-->
    <script src="<?php echo base_url() ?>public/assets/js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qz-tray/qz-tray.js"></script>
    <!-- JS -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleBtn = document.querySelector(".mobile-toggle-menu");
        const sidebar = document.querySelector(".nav-container");
        const closeBtn = document.querySelector(".toggle-icon");

        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener("click", function() {
                sidebar.classList.toggle("menu-open");
            });
        }

        if (closeBtn && sidebar) {
            closeBtn.addEventListener("click", function() {
                sidebar.classList.remove("menu-open");
            });
        }
    });
    </script>


</body>

</html>
