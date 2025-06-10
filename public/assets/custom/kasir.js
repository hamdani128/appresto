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

var app = angular.module("KasirApp", ["datatables"]);
app.controller("KasirAppController", function ($scope, $http) {
	$scope.LoadData = [];
	$scope.LoadDataPesananList = [];
	$scope.LoadDatMenuAll = [];
	$scope.LoadDataPesananDetail = [];
	$scope.keywordMenu = "";
	$scope.global_no_booking = "";
	$scope.global_no_meja = "";
	$scope.global_makanan = "";
	$scope.global_minuman = "";

	$scope.DataMeja = function () {
		$http
			.get(base_url("opr/kasir/getdata_meja"))
			.then(function (response) {
				$scope.LoadData = response.data;
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan:", error);
			});
	};
	$scope.DataMeja();

	$scope.SelectedMeja = function (elementId, dt) {
		$scope.data = angular.copy(dt);
		var btn1 = document.getElementById("btn_booking");
		var btn2 = document.getElementById("btn_pindah_meja");
		var btn3 = document.getElementById("btn_tambah_pesanan");
		var btn4 = document.getElementById("btn_gabung_bill");
		var show1 = document.getElementById("row_no_meja");
		var show2 = document.getElementById("row_count_pesanan");
		var show3 = document.getElementById("row_list_pesanan");

		btn1.style.display = "block";
		btn2.style.display = "none";
		btn3.style.display = "none";
		btn4.style.display = "none";
		show1.style.display = "block";
		show2.style.display = "none";
		show3.style.display = "none";

		var x = document.getElementById(elementId);
		if (x.classList.contains("bg-secondary")) {
			x.classList.remove("bg-secondary");
			x.classList.add("bg-warning");
			$http
				.get(base_url("opr/kasir/get_number_order"))
				.then(function (response) {
					document.getElementById("no_booking").innerHTML = response.data;
					document.getElementById("no_meja").innerHTML = dt.no_meja;
				})
				.catch(function (error) {
					console.error("Terjadi kesalahan:", error);
				});
		} else if (x.classList.contains("bg-warning")) {
			x.classList.remove("bg-warning");
			x.classList.add("bg-secondary");
			document.getElementById("no_booking").innerHTML = "";
			document.getElementById("no_meja").innerHTML = "";
		}
	};

	$scope.LoadDataMenu = function () {
		$http
			.get(base_url("opr/kasir/getdata_menu"))
			.then(function (response) {
				$scope.LoadDatMenuAll = response.data;
				$scope.filteredMenu = angular.copy(response.data);
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan:", error);
			});
	};

	$scope.searchMenu = function () {
		$scope.filteredMenu = $scope.LoadDatMenuAll.filter(function (menu) {
			return menu.nama.toLowerCase().includes($scope.keywordMenu.toLowerCase());
		});
	};

	$scope.Create_Booking = function () {
		var no_booking = document.getElementById("no_booking").innerHTML;
		var no_meja = document.getElementById("no_meja").innerHTML;
		if (no_booking === "-" || no_booking == "") {
			Swal.fire({
				icon: "warning",
				title: "Mohon Perhatikan",
				text: "Anda Wajib Memilih Pesanan Meja Terlebih Dahulu !",
			});
		} else {
			$("#my-modal-booking").modal("show");
			document.getElementById("lb_no_booking").innerHTML = no_booking;
			document.getElementById("lb_no_meja").innerHTML = no_meja;
			$scope.LoadDataMenu();
		}
	};

	$scope.PilihMenu = function (dt) {
		var tbody = document.getElementById("tb_pesanan_body");
		var existingRow = findExistingRow(dt);
		if (dt.status_food == "0") {
			Swal.fire({
				icon: "warning",
				title: "Mohon Perhatikan",
				text: "Menu " + dt.nama + " Sudah di Close !",
			});
		} else {
			if (existingRow) {
				// Jika data sudah ada, update qty saja
				updateQty(existingRow, 1);
			} else {
				// Jika data belum ada, tambahkan baris baru
				addNewRow(dt);
			}
		}
	};

	$scope.SimpanDataOrder = function () {
		var tbody = document.getElementById("tb_pesanan_body");
		var rows = tbody.getElementsByTagName("tr");
		if (rows.length === 0) {
			Swal.fire({
				icon: "warning",
				title: "Mohon Perhatikan",
				text: "List Pesanan Anda Kosong !",
			});
		} else {
			Swal.fire({
				title: "Konfirmasi",
				text: "Apakah Anda Yakin Ingin Menyimpan Data Order ini ?",
				icon: "question",
				showCancelButton: true,
				confirmButtonText: "Ya, Simpan",
				cancelButtonText: "Batal",
				reverseButtons: true,
			}).then((result) => {
				if (result.isConfirmed) {
					var OrderDetail = [];
					var no_booking = document.getElementById("no_booking").innerHTML;
					var no_meja = document.getElementById("no_meja").innerHTML;
					// Ada baris di dalam tabel, lanjutkan dengan logika penyimpanan atau tindakan lainnya
					for (var i = 0; i < rows.length; i++) {
						var kategori = rows[i].getElementsByTagName("td")[1].textContent;
						var nama = rows[i].getElementsByTagName("td")[2].textContent;
						var harga = rows[i].getElementsByTagName("td")[3].textContent;
						var qty = rows[i].getElementsByTagName("td")[4].textContent;
						var jenis = rows[i].getElementsByTagName("td")[5].textContent;
						var owner = rows[i].getElementsByTagName("td")[6].textContent;
						var rowData = {
							kategori: kategori,
							nama: nama,
							harga: harga,
							qty: qty,
							jenis: jenis,
							owner: owner,
						};
						OrderDetail.push(rowData);
					}
					var formdata = {
						no_booking: no_booking,
						no_meja: no_meja,
						order_detail: OrderDetail,
					};

					$http
						.post(base_url("opr/kasir/create_order_detail"), formdata)
						.then(function (response) {
							var data = response.data;
							if (data.status == true) {
								Swal.fire({
									icon: "success",
									title: "Berhasil",
									text: "Data Order Berhasil !",
								});
								document.location.reload();
							}
						})
						.catch(function (error) {
							console.error("Terjadi kesalahan saat proses data:", error);
						});
				}
			});
		}
	};

	$scope.ShowListBelanja = function (dt) {
		var btn1 = document.getElementById("btn_booking");
		var btn2 = document.getElementById("btn_pindah_meja");
		var btn3 = document.getElementById("btn_tambah_pesanan");
		var btn4 = document.getElementById("btn_gabung_bill");
		var show1 = document.getElementById("row_no_meja");
		var show2 = document.getElementById("row_count_pesanan");
		var show3 = document.getElementById("row_list_pesanan");

		if (show3.style.display == "none") {
			// masuk cek
			var formdata = {
				no_meja: dt.no_meja,
			};
			$http
				.post(base_url("opr/kasir/list_pesanan"), formdata)
				.then(function (response) {
					btn1.style.display = "none";
					btn2.style.display = "block";
					btn3.style.display = "block";
					btn4.style.display = "block";
					show1.style.display = "none";
					show2.style.display = "block";
					show3.style.display = "block";

					document.getElementById("lb_tambahan_no_meja").innerHTML =
						response.data.no_meja;
					document.getElementById("lb_tambahan_no_order").innerHTML =
						response.data.no_order;
					document.getElementById("lb_tambahan_created_at").innerHTML =
						response.data.created_at;
					$scope.LoadDataPesananList = response.data.detail;
					setTimeout(function () {
						$scope.CalculateTotal();
					}, 100); // beri delay sedikit agar ng-repeat selesai render

					if (
						response.data.count_makanan == 0 ||
						response.data.count_makanan == null
					) {
						document.getElementById("lb_makanan_list_pesanan").innerHTML = 0;
					} else {
						document.getElementById("lb_makanan_list_pesanan").innerHTML =
							response.data.count_makanan;
					}

					if (
						response.data.count_minuman == 0 ||
						response.data.count_minuman == null
					) {
						document.getElementById("lb_minuman_list_pesanan").innerHTML = 0;
					} else {
						document.getElementById("lb_minuman_list_pesanan").innerHTML =
							response.data.count_minuman;
					}
				})
				.catch(function (error) {
					console.error("Terjadi kesalahan saat proses data:", error);
				});
			$scope.LoadDataMenu();
		} else {
			show3.style.display = "none";
		}
	};

	$scope.CalculateTotal = function () {
		var tbody = document.getElementById("tb_pesanan_list_body_menu");
		var rows = tbody.getElementsByTagName("tr");
		var total_harga = 0;
		var qty_total = 0;

		for (var i = 0; i < rows.length; i++) {
			var tds = rows[i].getElementsByTagName("td");
			if (tds.length < 6) continue; // skip jika row bukan data

			var harga = parseInt(tds[3].textContent.trim()) || 0;
			var qty = parseInt(tds[4].textContent.trim()) || 0;
			var subtotal = harga * qty;

			qty_total += qty;
			total_harga += subtotal;
		}

		// Update qty dan subtotal
		document.getElementById("qty-total").value = formatRupiah(qty_total);
		document.getElementById("amount-total").value = formatRupiah(total_harga);

		// Hitung PPN
		var ppn_select = document
			.getElementById("amount-ppn")
			.parentElement.parentElement.querySelector("select");
		var ppn_percent = parseFloat(ppn_select.value) || 0;
		var ppn_amount = Math.floor(total_harga * (ppn_percent / 100));
		document.getElementById("amount-ppn").value = formatRupiah(ppn_amount);

		// Hitung Grand Total
		var grand_total = total_harga + ppn_amount;
		document.getElementById("grand-total").value = formatRupiah(grand_total);
	};

	$scope.TambahPesanan = function () {
		document.getElementById("lb_no_booking_tambahan").innerHTML =
			document.getElementById("lb_tambahan_no_order").innerHTML;
		document.getElementById("lb_no_meja_tambah_pesanan").innerHTML =
			document.getElementById("lb_tambahan_no_meja").innerHTML;
		$("#my-modal-tambah-pesanan").modal("show");
	};
	// Tambahan Menu
	$scope.PilihMenuTambahan = function (dt) {
		var tbody = document.getElementById("tb_pesanan_body_tambahan");
		var existingRow = findExistingRow_tambahan(dt);
		if (dt.status_food == "0") {
			Swal.fire({
				icon: "warning",
				title: "Mohon Perhatikan",
				text: "Menu " + dt.nama + " Sudah di Close !",
			});
		} else {
			if (existingRow) {
				// Jika data sudah ada, update qty saja
				updateQty(existingRow, 1);
			} else {
				// Jika data belum ada, tambahkan baris baru
				addNewRow_tambahan(dt);
			}
		}
	};

	$scope.SimpanDataOrderTambahan = function () {
		var tbody = document.getElementById("tb_pesanan_body_tambahan");
		var rows = tbody.getElementsByTagName("tr");
		if (rows.length === 0) {
			Swal.fire({
				icon: "warning",
				title: "Mohon Perhatikan",
				text: "List Tambahaan Pesanan Anda Kosong !",
			});
		} else {
			Swal.fire({
				title: "Konfirmasi",
				text: "Apakah Anda Yakin Ingin Menyimpan Data Tambahan Pesanan ini ?",
				icon: "question",
				showCancelButton: true,
				confirmButtonText: "Ya, Simpan",
				cancelButtonText: "Batal",
				reverseButtons: true,
			}).then((result) => {
				if (result.isConfirmed) {
					var OrderDetail = [];
					var no_booking = document.getElementById(
						"lb_tambahan_no_order"
					).innerHTML;
					var no_meja = document.getElementById(
						"lb_tambahan_no_meja"
					).innerHTML;
					// Ada baris di dalam tabel, lanjutkan dengan logika penyimpanan atau tindakan lainnya
					for (var i = 0; i < rows.length; i++) {
						var kategori = rows[i].getElementsByTagName("td")[1].textContent;
						var nama = rows[i].getElementsByTagName("td")[2].textContent;
						var harga = rows[i].getElementsByTagName("td")[3].textContent;
						var qty = rows[i].getElementsByTagName("td")[4].textContent;
						var jenis = rows[i].getElementsByTagName("td")[5].textContent;
						var owner = rows[i].getElementsByTagName("td")[6].textContent;
						var rowData = {
							kategori: kategori,
							nama: nama,
							harga: harga,
							qty: qty,
							jenis: jenis,
							owner: owner,
						};
						OrderDetail.push(rowData);
					}
					var formdata = {
						no_booking: no_booking,
						no_meja: no_meja,
						order_detail: OrderDetail,
					};

					$http
						.post(base_url("opr/kasir/create_order_detail"), formdata)
						.then(function (response) {
							var data = response.data;
							if (data.status == true) {
								Swal.fire({
									icon: "success",
									title: "Berhasil",
									text: "Data Order Berhasil !",
								});
								document.location.reload();
							}
						})
						.catch(function (error) {
							console.error("Terjadi kesalahan saat proses data:", error);
						});
				}
			});
		}
	};

	$scope.CetakBill = function () {
		var no_booking = document.getElementById("lb_tambahan_no_order").innerHTML;
		var no_meja = document.getElementById("lb_tambahan_no_meja").innerHTML;
		var created_at = document.getElementById(
			"lb_tambahan_created_at"
		).innerHTML;
		document.getElementById("bill_date").innerHTML = created_at;
		document.getElementById("bill_invoice").innerHTML = no_booking;
		document.getElementById("bill_chasier").innerHTML = "Rizki Hamdani";
		document.getElementById("bill_no_meja").innerHTML = no_meja;

		// $scope.LoadDataPesananDetail = [];
		var formdata = {
			no_meja: no_meja,
		};
		$http
			.post(base_url("opr/kasir/list_pesanan"), formdata)
			.then(function (response) {
				$scope.LoadDataPesananBill = response.data.detail;
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan saat proses data:", error);
			});
		var qty = $("#qty-total").val();
		var subtotal = $("#amount-total").val();
		var ppn_select_text = $("#ppn-select").val();
		var ppn = $("#amount-ppn").val();
		var grandtotal = $("#grand-total").val();
		document.getElementById("bill_qty").innerHTML = formatNumber(qty);
		document.getElementById("bill_subtotal").innerHTML = formatRupiah(subtotal);
		document.getElementById("bill_ppn").innerHTML = formatRupiah(ppn);
		document.getElementById("bill_grand_total").innerHTML =
			formatRupiah(grandtotal);
		$("#my-modal-cetak-bill").modal("show");
	};

	$scope.HapusPesananList = function (dt) {
		Swal.fire({
			title: "Konfirmasi",
			text: "Mau List Pesanan " + dt.nama + " ?",
			icon: "question",
			showCancelButton: true,
			confirmButtonText: "Ya, Hapus",
			cancelButtonText: "Batal",
			reverseButtons: true,
		}).then((result) => {
			if (result.isConfirmed) {
				var formdata = {
					id: dt.id,
				};
				$http
					.post(base_url("opr/kasir/delete_pesanan_list"), formdata)
					.then(function (response) {
						var data = response.data;
						if (data.status == true) {
							Swal.fire({
								icon: "success",
								title: "Berhasil",
								text: "Data Order Berhasil Dihapus !",
							});
							document.location.reload();
						}
					})
					.catch(function (error) {
						console.error("Terjadi kesalahan saat proses data:", error);
					});
			}
		});
	};

	$scope.ShowDetailPesanan = function (dt) {
		document.getElementById("lb_no_booking_list").innerHTML =
			document.getElementById("lb_tambahan_no_order").innerHTML;
		document.getElementById("lb_no_meja_list").innerHTML =
			document.getElementById("lb_tambahan_no_meja").innerHTML;
		var no_booking = document.getElementById("lb_tambahan_no_order").innerHTML;
		var no_meja = document.getElementById("lb_tambahan_no_meja").innerHTML;
		var makanan = dt.nama;
		$scope.global_no_booking = no_booking;
		$scope.global_no_meja = no_meja;
		$scope.global_nama = makanan;
		$("#my-modal-list-detail").modal("show");
		// alert(dt.nama);
		$scope.DetailMenuList(no_booking, no_meja, makanan);
	};

	$scope.DetailMenuList = function (no_booking, no_meja, nama) {
		$scope.LoadDataPesananDetail = [];
		var formdata = {
			no_meja: no_meja,
			no_booking: no_booking,
			nama: nama,
		};
		$http
			.post(base_url("opr/kasir/list_pesanan_detail"), formdata)
			.then(function (response) {
				$scope.LoadDataPesananDetail = response.data;
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan saat proses data:", error);
			});
	};

	$scope.TambahQtyPesananListDetail = function (dt) {
		dt.qty = parseInt(dt.qty) || 0;
		dt.qty += 1;
		var id = dt.id;
		var formdata = {
			id: id,
			qty: dt.qty,
		};
		$http
			.post(base_url("opr/kasir/update_qty_pesanan_list_detail"), formdata)
			.then(function (response) {})
			.catch(function (error) {
				console.error("Terjadi kesalahan saat proses data:", error);
			});
	};

	$scope.KurangQtyPesananListDetail = function (dt) {
		dt.qty = parseInt(dt.qty) || 0;

		if (dt.qty > 1) {
			dt.qty -= 1;

			// Update ke server
			var formdata = {
				id: dt.id,
				qty: dt.qty,
			};

			$http
				.post(base_url("opr/kasir/update_qty_pesanan_list_detail"), formdata)
				.then(function (response) {})
				.catch(function (error) {
					console.error("Terjadi kesalahan saat proses data:", error);
				});
		} else {
			var formdata = {
				id: dt.id,
			};

			$http
				.post(
					base_url("opr/kasir/update_qty_pesanan_list_detail_hapus"),
					formdata
				)
				.then(function (response) {
					console.log("Data dihapus:", response.data);
				})
				.catch(function (error) {
					console.error("Terjadi kesalahan saat proses data:", error);
				});
			// Qty 1 dikurangi -> menjadi 0, maka hapus dari array
			const index = $scope.LoadDataPesananDetail.indexOf(dt);
			if (index !== -1) {
				$scope.LoadDataPesananDetail.splice(index, 1);
			}
			// Kirim permintaan hapus ke server
		}
	};

	$scope.DeleteListDetail = function (dt) {
		var formdata = {
			id: dt.id,
		};
		$http
			.post(
				base_url("opr/kasir/update_qty_pesanan_list_detail_hapus"),
				formdata
			)
			.then(function (response) {
				console.log("Data dihapus:", response.data);
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan saat proses data:", error);
			});
		// Qty 1 dikurangi -> menjadi 0, maka hapus dari array
		const index = $scope.LoadDataPesananDetail.indexOf(dt);
		if (index !== -1) {
			$scope.LoadDataPesananDetail.splice(index, 1);
		}
	};

	$scope.checkAll = false; // state header “Select All”
	$scope.selectedIds = [];

	$scope.toggleAll = function () {
		$scope.selectedIds = []; // Reset dulu
		angular.forEach($scope.LoadDataPesananDetail, function (item) {
			item.checked = $scope.checkAll;
			if ($scope.checkAll) {
				$scope.selectedIds.push(item.id);
			}
		});
	};

	$scope.updateCheckedIds = function () {
		$scope.selectedIds = []; // Reset dahulu
		// Kosongkan dahulu
		// Loop semua LoadDataPesananDetail, jika item.checked==true, push id-nya
		$scope.LoadDataPesananDetail.forEach(function (item) {
			if (item.checked) {
				$scope.selectedIds.push(item.id);
			}
		});
		// Jika jumlah yang ter-check sama dengan total row, biarkan checkAll = true,
		// kalau tidak, set checkAll = false (tujuannya, apabila tiba-tiba user
		// uncheck satu per satu sehingga header harus otomatis unset).
		$scope.checkAll =
			$scope.selectedIds.length === $scope.LoadDataPesananDetail.length;
	};

	$scope.UpdateServed = function () {
		if ($scope.selectedIds.length === 0) {
			Swal.fire({
				icon: "warning",
				title: "Mohon Perhatikan",
				text: "Tidak ada menu yang dipilih !",
			});
			return;
		}
		// Contoh payload-nya berisi array selectedIds
		var payload = {
			ids: $scope.selectedIds,
		};
		// Kirim ke server, misalnya via POST:
		$http
			.post(base_url("opr/kasir/update_served_food"), payload)
			.then(function (response) {
				$scope.DetailMenuList(
					$scope.global_no_booking,
					$scope.global_no_meja,
					$scope.global_makanan
				);
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan saat proses data:", error);
			});
	};

	$scope.UpdateDelivered = function () {
		if ($scope.selectedIds.length === 0) {
			Swal.fire({
				icon: "warning",
				title: "Mohon Perhatikan",
				text: "Tidak ada menu yang dipilih !",
			});
			return;
		}
		// Contoh payload-nya berisi array selectedIds
		var payload = {
			ids: $scope.selectedIds,
		};
		// Kirim ke server, misalnya via POST:
		$http
			.post(base_url("opr/kasir/update_delivered_food"), payload)
			.then(function (response) {
				$scope.DetailMenuList(
					$scope.global_no_booking,
					$scope.global_no_meja,
					$scope.global_makanan
				);
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan saat proses data:", error);
			});
	};

	$scope.UpdateCompleted = function () {
		if ($scope.selectedIds.length === 0) {
			Swal.fire({
				icon: "warning",
				title: "Mohon Perhatikan",
				text: "Tidak ada menu yang dipilih !",
			});
			return;
		}
		// Contoh payload-nya berisi array selectedIds
		var payload = {
			ids: $scope.selectedIds,
		};
		// Kirim ke server, misalnya via POST:
		$http
			.post(base_url("opr/kasir/update_completed_food"), payload)
			.then(function (response) {
				$scope.DetailMenuList(
					$scope.global_no_booking,
					$scope.global_no_meja,
					$scope.global_makanan
				);
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan saat proses data:", error);
			});
	};

	$scope.PindahMeja = function () {
		$scope.global_no_booking = document.getElementById(
			"lb_tambahan_no_order"
		).innerHTML;
		$scope.global_no_meja = document.getElementById(
			"lb_tambahan_no_meja"
		).innerHTML;
		document.getElementById("lb_no_booking_pindah_meja").innerHTML =
			$scope.global_no_booking;
		document.getElementById("lb_no_meja_pindah_meja").innerHTML =
			$scope.global_no_meja;

		$http
			.post(base_url("opr/kasir/get_list_meja_standby"))
			.then(function (response) {
				const optionsData = response.data;
				const select = document.getElementById("combo_pindah_meja");
				select.innerHTML = "";
				const defaultOption = document.createElement("option");
				defaultOption.value = "";
				defaultOption.text = "Pilih";
				select.appendChild(defaultOption);

				optionsData.forEach((option) => {
					const newOption = document.createElement("option");
					newOption.value = option.no_meja;
					newOption.text =
						option.no_meja + " " + "( " + option.nama_meja + " )";
					select.appendChild(newOption);
				});

				$("#my-modal-pindah-meja").modal("show");
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan saat proses data:", error);
			});
	};

	$scope.PindahMejaSubmit = function () {
		$scope.global_no_booking = document.getElementById(
			"lb_tambahan_no_order"
		).innerHTML;
		$scope.global_no_meja = document.getElementById(
			"lb_tambahan_no_meja"
		).innerHTML;
		var no_meja_baru = $("#combo_pindah_meja").val();
		if (no_meja_baru === "") {
			Swal.fire({
				icon: "warning",
				title: "Mohon Perhatikan",
				text: "Meja tidak boleh kosong !",
			});
			return;
		} else {
			var formdata = {
				no_booking: $scope.global_no_booking,
				no_meja_lama: $scope.global_no_meja,
				no_meja_baru: no_meja_baru,
			};
			$http
				.post(base_url("opr/kasir/pindah_meja"), formdata)
				.then(function (response) {
					if (response.data.status == "success") {
						Swal.fire({
							icon: "success",
							title: "Berhasil",
							text: "Meja berhasil dipindahkan !",
						});
						document.location.reload();
					}
				});
		}
	};

	$scope.pay_before_service = function () {
		$scope.global_no_booking = document.getElementById(
			"lb_tambahan_no_order"
		).innerHTML;
		$scope.global_no_meja = document.getElementById(
			"lb_tambahan_no_meja"
		).innerHTML;
		document.getElementById("lb_no_booking_payment_before_service").innerHTML =
			$scope.global_no_booking;
		document.getElementById("lb_no_meja_payment_before_service").innerHTML =
			$scope.global_no_meja;
		var qty = $("#qty-total").val();
		var subtotal = $("#amount-total").val();
		var ppn_text = $("#ppn-select").val();
		var ppn = $("#amount-ppn").val();
		var total = $("#grand-total").val();
		document.getElementById("total-qty-payment-before-service").innerHTML = qty;
		document.getElementById("subtotal-payment-before-service").innerHTML =
			formatRupiah(subtotal);
		if (ppn_text === "") {
			document.getElementById("ppn-text-payment-before-service").innerHTML = 0;
		} else {
			document.getElementById("ppn-text-payment-before-service").innerHTML =
				ppn_text;
		}
		document.getElementById("ppn-payment-before-service").innerHTML =
			formatRupiah(ppn);
		document.getElementById("grand-total-payment-before-service").innerHTML =
			formatRupiah(total);

		$("#my-modal-payment-before-service").modal("show");
	};
});

// Fungsi untuk membuat tombol dengan kelas dan ikon
function createButton(text, className, iconClass) {
	var button = document.createElement("button");
	button.textContent = text;

	// Tambahkan kelas Bootstrap
	button.className = className;

	// Tambahkan ikon Font Awesome
	var icon = document.createElement("i");
	icon.className = iconClass;
	button.appendChild(icon);

	return button;
}

// Fungsi untuk mencari baris yang sudah ada berdasarkan nama pesanan
function findExistingRow(dt) {
	var tbody = document.getElementById("tb_pesanan_body");
	var rows = tbody.getElementsByTagName("tr");

	for (var i = 0; i < rows.length; i++) {
		var namaCell = rows[i].getElementsByTagName("td")[2]; // Kolom kedua berisi nama pesanan
		if (namaCell.textContent === dt.nama) {
			return rows[i];
		}
	}

	return null;
}
// Fungsi untuk memperbarui qty
function updateQty(row, qtyChange) {
	var qtyCell = row.querySelector(".qty-cell");
	var currentQty = (parseInt(qtyCell.textContent) || 0) + qtyChange;

	if (currentQty > 0) {
		qtyCell.textContent = currentQty;
	} else {
		// Hapus baris jika qty mencapai 0
		var tbody = document.getElementById("tb_pesanan_body");
		tbody.removeChild(row);

		// Perbarui nomor urut setelah menghapus baris
		updateRowNumbers();
	}
}

// Fungsi untuk menambahkan baris baru
function addNewRow(dt) {
	var tbody = document.getElementById("tb_pesanan_body");
	var newRow = document.createElement("tr");

	var cellNumber = document.createElement("td");
	cellNumber.appendChild(document.createTextNode(tbody.rows.length + 1));
	newRow.appendChild(cellNumber);

	var cellcat = document.createElement("td");
	cellcat.appendChild(document.createTextNode(dt.kategori));
	newRow.appendChild(cellcat);

	var cellNama = document.createElement("td");
	cellNama.appendChild(document.createTextNode(dt.nama));
	newRow.appendChild(cellNama);

	var cellHarga = document.createElement("td");
	cellHarga.appendChild(document.createTextNode(dt.harga));
	newRow.appendChild(cellHarga);

	var cellQty = document.createElement("td");
	cellQty.className = "qty-cell"; // Tambahkan kelas untuk mengidentifikasi sel qty
	cellQty.appendChild(document.createTextNode(1));
	newRow.appendChild(cellQty);

	var cellJenis = document.createElement("td");
	cellJenis.appendChild(document.createTextNode(dt.jenis));
	newRow.appendChild(cellJenis);

	var cellOwner = document.createElement("td");
	cellOwner.appendChild(document.createTextNode(dt.owner));
	newRow.appendChild(cellOwner);

	var cellAction = document.createElement("td");

	var btnPlus = createButton("", "btn btn-dark", "bx bx-plus");
	btnPlus.addEventListener("click", function () {
		updateQty(newRow, 1);
	});
	cellAction.appendChild(btnPlus);

	var btnMinus = createButton("", "btn btn-dark", "bx bx-minus");
	btnMinus.addEventListener("click", function () {
		updateQty(newRow, -1);
	});
	cellAction.appendChild(btnMinus);

	var btnDelete = createButton("", "btn btn-danger", "bx bx-trash");
	btnDelete.addEventListener("click", function () {
		tbody.removeChild(newRow);
		updateRowNumbers(); // Perbarui nomor urut setelah menghapus baris
	});
	cellAction.appendChild(btnDelete);

	newRow.appendChild(cellAction);
	tbody.appendChild(newRow);
	// Perbarui nomor urut setiap kali menambahkan baris baru
	updateRowNumbers();
}

// Fungsi untuk memperbarui nomor urut setiap kali baris dihapus
function updateRowNumbers() {
	var tbody = document.getElementById("tb_pesanan_body");
	var rows = tbody.getElementsByTagName("tr");

	for (var i = 0; i < rows.length; i++) {
		var cellNumber = rows[i].getElementsByTagName("td")[0]; // Kolom pertama berisi nomor urut
		cellNumber.textContent = i + 1;
	}
}

// Tambahah Menu

// Fungsi untuk membuat tombol dengan kelas dan ikon
function createButton_tambahan(text, className, iconClass) {
	var button = document.createElement("button");
	button.textContent = text;

	// Tambahkan kelas Bootstrap
	button.className = className;

	// Tambahkan ikon Font Awesome
	var icon = document.createElement("i");
	icon.className = iconClass;
	button.appendChild(icon);

	return button;
}

// Fungsi untuk mencari baris yang sudah ada berdasarkan nama pesanan
function findExistingRow_tambahan(dt) {
	var tbody = document.getElementById("tb_pesanan_body_tambahan");
	var rows = tbody.getElementsByTagName("tr");

	for (var i = 0; i < rows.length; i++) {
		var namaCell = rows[i].getElementsByTagName("td")[2]; // Kolom kedua berisi nama pesanan
		if (namaCell.textContent === dt.nama) {
			return rows[i];
		}
	}

	return null;
}
// Fungsi untuk memperbarui qty
function updateQty_tambahan(row, qtyChange) {
	var qtyCell = row.querySelector(".qty-cell");
	var currentQty = (parseInt(qtyCell.textContent) || 0) + qtyChange;

	if (currentQty > 0) {
		qtyCell.textContent = currentQty;
	} else {
		// Hapus baris jika qty mencapai 0
		var tbody = document.getElementById("tb_pesanan_body_tambahan");
		tbody.removeChild(row);

		// Perbarui nomor urut setelah menghapus baris
		updateRowNumbers_tambahan();
	}
}

// Fungsi untuk menambahkan baris baru
function addNewRow_tambahan(dt) {
	var tbody = document.getElementById("tb_pesanan_body_tambahan");
	var newRow = document.createElement("tr");

	var cellNumber = document.createElement("td");
	cellNumber.appendChild(document.createTextNode(tbody.rows.length + 1));
	newRow.appendChild(cellNumber);

	var cellcat = document.createElement("td");
	cellcat.appendChild(document.createTextNode(dt.kategori));
	newRow.appendChild(cellcat);

	var cellNama = document.createElement("td");
	cellNama.appendChild(document.createTextNode(dt.nama));
	newRow.appendChild(cellNama);

	var cellHarga = document.createElement("td");
	cellHarga.appendChild(document.createTextNode(dt.harga));
	newRow.appendChild(cellHarga);

	var cellQty = document.createElement("td");
	cellQty.className = "qty-cell"; // Tambahkan kelas untuk mengidentifikasi sel qty
	cellQty.appendChild(document.createTextNode(1));
	newRow.appendChild(cellQty);

	var cellJenis = document.createElement("td");
	cellJenis.appendChild(document.createTextNode(dt.jenis));
	newRow.appendChild(cellJenis);

	var cellOwner = document.createElement("td");
	cellOwner.appendChild(document.createTextNode(dt.owner));
	newRow.appendChild(cellOwner);

	var cellAction = document.createElement("td");

	var btnPlus = createButton("", "btn btn-dark", "bx bx-plus");
	btnPlus.addEventListener("click", function () {
		updateQty_tambahan(newRow, 1);
	});
	cellAction.appendChild(btnPlus);

	var btnMinus = createButton("", "btn btn-dark", "bx bx-minus");
	btnMinus.addEventListener("click", function () {
		updateQty_tambahan(newRow, -1);
	});
	cellAction.appendChild(btnMinus);

	var btnDelete = createButton("", "btn btn-danger", "bx bx-trash");
	btnDelete.addEventListener("click", function () {
		tbody.removeChild(newRow);
		updateRowNumbers_tambahan(); // Perbarui nomor urut setelah menghapus baris
	});
	cellAction.appendChild(btnDelete);

	newRow.appendChild(cellAction);
	tbody.appendChild(newRow);

	// Perbarui nomor urut setiap kali menambahkan baris baru
	updateRowNumbers_tambahan();
}

// Fungsi untuk memperbarui nomor urut setiap kali baris dihapus
function updateRowNumbers_tambahan() {
	var tbody = document.getElementById("tb_pesanan_body_tambahan");
	var rows = tbody.getElementsByTagName("tr");

	for (var i = 0; i < rows.length; i++) {
		var cellNumber = rows[i].getElementsByTagName("td")[0]; // Kolom pertama berisi nomor urut
		cellNumber.textContent = i + 1;
	}
}

function formatRupiah(angka) {
	// Hapus semua karakter selain angka
	angka = angka.toString().replace(/\D/g, "");
	// Tambah titik ribuan
	return angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Fungsi format angka: 1000000 => "1.000.000"
function formatNumber(num) {
	return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Fungsi unformat angka: "1.000.000" => 1000000
function unformatNumber(str) {
	return parseInt(str.replace(/\./g, "").replace(/,/g, "")) || 0;
}

const inputBayar = document.getElementById(
	"jumlah-dibayar-payment-before-service"
);

// Format saat diketik
inputBayar.addEventListener("input", function (e) {
	let cursorPos = this.selectionStart;
	let originalLength = this.value.length;

	this.value = formatRupiah(this.value);

	let updatedLength = this.value.length;
	this.selectionEnd = cursorPos + (updatedLength - originalLength);
});

// Kalkulasi saat tekan Enter
inputBayar.addEventListener("keydown", function (e) {
	if (e.key === "Enter") {
		e.preventDefault();

		let grand_Total = document.getElementById(
			"grand-total-payment-before-service"
		).innerHTML;
		let jumlahBayar = unformatNumber(this.value);
		let totalTagihan = unformatNumber(grand_Total);
		let kembalian = jumlahBayar - totalTagihan;

		document.getElementById("kembalian-payment-before-service").innerHTML =
			formatRupiah(kembalian.toString());
	}
});

function changePaymentBeforeService() {
	var combo_methode = $("#combo-payment-before-service").val();

	$("#display_jumlah_dibayar_payment_before_service").css("display", "none");
	$("#display_kembalian_payment_before_service").css("display", "none");
	$("#display_reference_payment_before_service").css("display", "none");
	$("#display_reference_number_payment_before_service").css("display", "none");

	if (combo_methode == "Cash") {
		$("#display_jumlah_dibayar_payment_before_service").css(
			"display",
			"table-row"
		);
		$("#display_kembalian_payment_before_service").css("display", "table-row");
	} else if (combo_methode == "QRIS") {
		$("#display_jumlah_dibayar_payment_before_service").css(
			"display",
			"table-row"
		);
		$("#display_kembalian_payment_before_service").css("display", "table-row");
		$("#display_reference_payment_before_service").css("display", "table-row");
	} else if (combo_methode == "Bank Transfer") {
		$("#display_jumlah_dibayar_payment_before_service").css(
			"display",
			"table-row"
		);
		$("#display_kembalian_payment_before_service").css("display", "table-row");
		$("#display_reference_payment_before_service").css("display", "table-row");
		$("#display_reference_number_payment_before_service").css(
			"display",
			"table-row"
		);
	}
}
