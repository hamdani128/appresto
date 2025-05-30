function base_url(string_url) {
	var pathparts = location.pathname.split("/");
	if (
		location.host == "localhost:8080" ||
		location.host == "localhost" ||
		location.host == "10.32.18.206"
	) {
		var url = location.origin + "/" + pathparts[1].trim("/") + "/" + string_url; // http://localhost/myproject/
	} else {
		var url = location.origin + "/" + string_url; // http://stackoverflow.com
	}
	return url;
}

function login_administrasi() {
	var username = $("#username").val();
	var password = $("#password").val();
	if (username == "" && password == "") {
		Swal.fire({
			icon: "warning",
			title: "Notification",
			text: "Username dan Password Terisi  !",
		});
	} else {
		$.ajax({
			url: base_url("auth/login/cek_login"),
			method: "POST",
			data: {
				username: username,
				password: password,
			},
			dataType: "JSON",
			success: function (data) {
				if (data.status === "success") {
					Swal.fire({
						icon: "success",
						title: "Berhasil",
						text: "Anda Berhasil Login !",
					});
					document.location.href = base_url("home");
				} else if (data.status === "gagal") {
					Swal.fire({
						icon: "warning",
						title: "Error",
						text: "Username dan password salah !",
					});
				}
			},
		});
	}
}
