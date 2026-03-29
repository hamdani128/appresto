<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo base_url() ?>public/assets/images/kafe.png" type="image/png" />
    <link href="<?php echo base_url() ?>public/assets/css/pace.min.css" rel="stylesheet" />
    <script src="<?php echo base_url() ?>public/assets/js/pace.min.js"></script>
    <link href="<?php echo base_url() ?>public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>public/assets/css/bootstrap-extended.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="<?php echo base_url() ?>public/assets/css/app.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>public/assets/css/icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url() ?>public/assets/sweetalert/sweetalert2.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>public/assets/sweetalert/sweetalert2.min.css">
    <title>Coffe Login App</title>

    <style>
    body.login-body {
        min-height: 100vh;
        margin: 0;
        font-family: "DM Sans", sans-serif;
        background:
            radial-gradient(circle at top left, rgba(255, 214, 153, 0.28), transparent 28%),
            radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.18), transparent 30%),
            linear-gradient(135deg, #f6efe8 0%, #f7f3ee 45%, #eef4ff 100%);
        color: #172033;
        overflow-x: hidden;
    }

    .login-shell {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }

    .login-stage {
        width: 100%;
        max-width: 1140px;
        display: grid;
        grid-template-columns: 1.08fr 0.92fr;
        background: rgba(255, 255, 255, 0.78);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.72);
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 24px 70px rgba(15, 23, 42, 0.12);
    }

    .login-brand-panel {
        position: relative;
        padding: 42px;
        background:
            linear-gradient(160deg, rgba(17, 24, 39, 0.96) 0%, rgba(30, 64, 175, 0.92) 100%);
        color: #fff;
        overflow: hidden;
    }

    .login-brand-panel::before,
    .login-brand-panel::after {
        content: "";
        position: absolute;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
    }

    .login-brand-panel::before {
        width: 220px;
        height: 220px;
        top: -60px;
        right: -70px;
    }

    .login-brand-panel::after {
        width: 180px;
        height: 180px;
        left: -40px;
        bottom: -70px;
    }

    .login-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
        font-size: 12px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 24px;
        position: relative;
        z-index: 2;
    }

    .login-brand-panel h1 {
        font-size: clamp(32px, 4vw, 50px);
        line-height: 1.02;
        font-weight: 700;
        margin-bottom: 14px;
        position: relative;
        z-index: 2;
        color: #ffffff;
    }

    .login-brand-panel p {
        max-width: 440px;
        color: rgba(255, 255, 255, 0.88);
        font-size: 15px;
        line-height: 1.75;
        position: relative;
        z-index: 2;
    }

    .login-meta-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
        margin-top: 34px;
        position: relative;
        z-index: 2;
    }

    .login-meta-card {
        padding: 18px 18px 16px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.12);
    }

    .login-meta-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: rgba(255, 255, 255, 0.66);
        margin-bottom: 8px;
    }

    .login-meta-value {
        font-size: 20px;
        font-weight: 700;
        color: #fff;
    }

    .login-form-panel {
        padding: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 250, 252, 0.94) 100%);
    }

    .login-form-wrap {
        width: 100%;
        max-width: 380px;
    }

    .login-logo-box {
        width: 92px;
        height: 92px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 24px;
        background: linear-gradient(135deg, #ffffff 0%, #f3f6fb 100%);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        margin-bottom: 18px;
    }

    .login-logo-box img {
        width: 64px;
        height: 64px;
        object-fit: contain;
    }

    .login-eyebrow {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #2563eb;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .login-form-title {
        font-size: 32px;
        line-height: 1.1;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 10px;
    }

    .login-form-subtitle {
        color: #64748b;
        margin-bottom: 28px;
        line-height: 1.7;
    }

    .login-clock-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 16px 18px;
        border-radius: 18px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        margin-bottom: 24px;
    }

    .login-clock-time {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .login-clock-date {
        color: #64748b;
        font-size: 13px;
    }

    .login-clock-icon {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1d4ed8;
        font-size: 24px;
        flex: 0 0 auto;
    }

    .login-field {
        margin-bottom: 18px;
    }

    .login-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 10px;
    }

    .login-input-wrap {
        position: relative;
    }

    .login-input-icon {
        position: absolute;
        top: 50%;
        left: 16px;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 19px;
        pointer-events: none;
    }

    .login-input {
        width: 100%;
        height: 54px;
        border-radius: 16px;
        border: 1px solid #dbe3ee;
        background: #fff;
        padding: 0 16px 0 48px;
        font-size: 14px;
        color: #0f172a;
        transition: all 0.2s ease;
    }

    .login-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    .login-submit {
        width: 100%;
        height: 54px;
        border: 0;
        border-radius: 16px;
        background: linear-gradient(135deg, #0f172a 0%, #2563eb 100%);
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 0.01em;
        box-shadow: 0 16px 34px rgba(37, 99, 235, 0.22);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .login-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 18px 36px rgba(37, 99, 235, 0.26);
    }

    .login-helper {
        margin-top: 16px;
        font-size: 13px;
        color: #64748b;
        text-align: center;
    }

    @media (max-width: 991.98px) {
        .login-stage {
            grid-template-columns: 1fr;
            max-width: 720px;
        }

        .login-brand-panel,
        .login-form-panel {
            padding: 28px;
        }

        .login-brand-panel h1 {
            font-size: 34px;
        }

        .login-meta-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 767.98px) {
        .login-shell {
            padding: 14px;
        }

        .login-stage {
            border-radius: 22px;
        }

        .login-brand-panel,
        .login-form-panel {
            padding: 22px 18px;
        }

        .login-brand-panel {
            min-height: auto;
        }

        .login-brand-panel h1 {
            font-size: 28px;
        }

        .login-form-title {
            font-size: 28px;
        }

        .login-logo-box {
            width: 78px;
            height: 78px;
            border-radius: 20px;
        }

        .login-logo-box img {
            width: 54px;
            height: 54px;
        }

        .login-meta-grid {
            grid-template-columns: 1fr;
        }

        .login-clock-card {
            padding: 14px;
        }

        .login-clock-time {
            font-size: 20px;
        }
    }
    </style>
</head>

<body class="login-body">
    <div class="login-shell">
        <div class="login-stage">
            <section class="login-brand-panel">
                <div class="login-badge">
                    <i class="bx bx-coffee-togo"></i>
                    Coffee Admin
                </div>
                <h1>Kelola operasional cafe dengan dashboard yang lebih tertata.</h1>
                <p>Masuk ke sistem untuk memantau kasir, takeaway, laporan, dan master data dalam satu alur kerja yang ringkas dan nyaman dipakai setiap hari.</p>

                <div class="login-meta-grid">
                    <div class="login-meta-card">
                        <div class="login-meta-label">Mode</div>
                        <div class="login-meta-value">Kasir & Admin</div>
                    </div>
                    <div class="login-meta-card">
                        <div class="login-meta-label">Akses</div>
                        <div class="login-meta-value">Secure Login</div>
                    </div>
                </div>
            </section>

            <section class="login-form-panel">
                <div class="login-form-wrap">
                    <div class="login-logo-box">
                        <img src="<?php echo base_url() ?>public/assets/images/kafe.png" alt="Cafe Logo">
                    </div>

                    <div class="login-eyebrow">Welcome Back</div>
                    <div class="login-form-title">Masuk ke sistem</div>
                    <div class="login-form-subtitle">Gunakan akun yang sudah terdaftar untuk melanjutkan ke dashboard operasional.</div>

                    <div class="login-clock-card">
                        <div>
                            <div class="login-clock-time" id="jam">10:53 AM</div>
                            <div class="login-clock-date" id="hari">Tuesday, January 14, 2021</div>
                        </div>
                        <div class="login-clock-icon">
                            <i class="bx bx-time-five"></i>
                        </div>
                    </div>

                    <div class="login-field">
                        <label class="login-label" for="username">Username</label>
                        <div class="login-input-wrap">
                            <span class="login-input-icon"><i class="bx bx-user"></i></span>
                            <input type="text" name="username" id="username" class="login-input" placeholder="Masukkan username">
                        </div>
                    </div>

                    <div class="login-field">
                        <label class="login-label" for="password">Password</label>
                        <div class="login-input-wrap">
                            <span class="login-input-icon"><i class="bx bx-lock-alt"></i></span>
                            <input type="password" name="password" id="password" class="login-input" placeholder="Masukkan password">
                        </div>
                    </div>

                    <button type="button" class="login-submit" onclick="login_administrasi()">Login Sekarang</button>

                    <div class="login-helper">Tampilan ini sudah disesuaikan agar lebih nyaman dipakai di desktop, tablet, dan HP.</div>
                </div>
            </section>
        </div>
    </div>
</body>

<script src="<?php echo base_url() ?>public/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url() ?>public/assets/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>public/assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="<?php echo base_url() ?>public/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="<?php echo base_url() ?>public/assets/custom/login.js"></script>
<script src="<?php echo base_url() ?>public/assets/sweetalert/sweetalert2.js"></script>
<script src="<?php echo base_url() ?>public/assets/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo base_url() ?>public/assets/sweetalert/sweetalert2.all.js"></script>
<script src="<?php echo base_url() ?>public/assets/sweetalert/sweetalert2.all.min.js"></script>
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
document.getElementById("hari").innerHTML = thisDay + ', ' + day + ' ' + months[month] + ' ' + year;

document.addEventListener("DOMContentLoaded", function() {
    showTime();

    var usernameInput = document.getElementById("username");
    var passwordInput = document.getElementById("password");

    [usernameInput, passwordInput].forEach(function(input) {
        if (!input) {
            return;
        }

        input.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                login_administrasi();
            }
        });
    });
});
</script>

</html>
