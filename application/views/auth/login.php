<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="<?= base_url() ?>public/assets/images/favicon-32x32.png" type="image/png" />
    <!-- loader-->
    <link href="<?= base_url() ?>public/assets/css/pace.min.css" rel="stylesheet" />
    <script src="<?= base_url() ?>public/assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="<?= base_url() ?>public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>public/assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="<?= base_url() ?>public/assets/css/app.css" rel="stylesheet">
    <link href="<?= base_url() ?>public/assets/css/icons.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url() ?>public/assets/sweetalert/sweetalert2.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/assets/sweetalert/sweetalert2.min.css">
    <title>App Resto - Login Administrasi</title>
</head>

<body class="bg-lock-screen">
    <!-- wrapper -->
    <div class="wrapper">
        <div class="authentication-lock-screen d-flex align-items-center justify-content-center">
            <div class="card shadow-none">
                <div class="card-body p-md-5 text-center">
                    <h2 class="" id="jam">10:53 AM</h2>
                    <h5 class="" id="hari">Tuesday, January 14, 2021</h5>
                    <div class="">
                        <img src="<?= base_url() ?>public/assets/images/icons/user.png" class="my-4" width="120"
                            alt="" />
                    </div>
                    <p class="mt-2">Administrator</p>
                    <div class="mb-3 mt-3">
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username" />
                    </div>
                    <div class="mb-3 mt-3">
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Password" />
                    </div>
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary" onclick="login_administrasi()">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end wrapper -->
</body>
<!-- Bootstrap JS -->
<script src="<?= base_url() ?>public/assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="<?= base_url() ?>public/assets/js/jquery.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/simplebar/js/simplebar.min.js"></script>

<script src="<?= base_url() ?>public/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="<?= base_url() ?>public/assets/custom/login.js"></script>
<!-- SweetAlert -->
<script src="<?= base_url() ?>public/assets/sweetalert/sweetalert2.js"></script>
<script src="<?= base_url() ?>public/assets/sweetalert/sweetalert2.min.js"></script>
<script src="<?= base_url() ?>public/assets/sweetalert/sweetalert2.all.js"></script>
<script src="<?= base_url() ?>public/assets/sweetalert/sweetalert2.all.min.js"></script>
<script>
function showTime() {
    var a_p = "";
    var today = new Date();
    var curr_hour = today.getHours();
    var curr_minute = today.getMinutes();
    var curr_second = today.getSeconds();
    if (curr_hour < 12) {
        a_p = "AM";
    } else {
        a_p = "PM";
    }
    if (curr_hour == 0) {
        curr_hour = 12;
    }
    if (curr_hour > 12) {
        curr_hour = curr_hour - 12;
    }
    curr_hour = checkTime(curr_hour);
    curr_minute = checkTime(curr_minute);
    curr_second = checkTime(curr_second);
    document.getElementById('jam').innerHTML = curr_hour + ":" + curr_minute + ":" + curr_second + " " + a_p;
}

function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
setInterval(showTime, 500);
//-->

var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
    'November', 'Desember'
];
var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
var date = new Date();
var day = date.getDate();
var month = date.getMonth();
var thisDay = date.getDay(),
    thisDay = myDays[thisDay];
var yy = date.getYear();
var year = (yy < 1000) ? yy + 1900 : yy;
// var dt = document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
document.getElementById("hari").innerHTML = thisDay + ', ' + day + ' ' + months[month] + ' ' + year;
</script>

</html>