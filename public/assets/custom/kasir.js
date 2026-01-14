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
app.controller("KasirAppController", function ($scope, $http, $timeout) {
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

	$scope.BackToHome = function () {
		var btn1 = document.getElementById("btn_booking");
		var btn2 = document.getElementById("btn_pindah_meja");
		var btn3 = document.getElementById("btn_tambah_pesanan");
		var btn4 = document.getElementById("btn_gabung_bill");
		var show1 = document.getElementById("row_no_meja");
		var show2 = document.getElementById("row_count_pesanan");
		var show3 = document.getElementById("row_list_pesanan");
		var show4 = document.getElementById("table_row_order");

		btn1.style.display = "none";
		btn2.style.display = "none";
		btn3.style.display = "none";
		btn4.style.display = "none";
		show1.style.display = "none";
		show2.style.display = "none";
		show3.style.display = "none";
		show4.style.display = "block";
		$scope.DataMeja();
	};

	$scope.LoadDataTransaksi = function () {
		$http
			.get(base_url("opr/kasir/getdata_transaksi_today"))
			.then(function (response) {
				$scope.LoadDataTransaksi = response.data;
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan:", error);
			});
	};

	$scope.LoadDataTransaksi();

	$scope.SelectedMeja = function (elementId, dt) {
		$scope.data = angular.copy(dt);
		var btn1 = document.getElementById("btn_booking");
		var btn2 = document.getElementById("btn_pindah_meja");
		var btn3 = document.getElementById("btn_tambah_pesanan");
		var btn4 = document.getElementById("btn_gabung_bill");
		var show1 = document.getElementById("row_no_meja");
		var show2 = document.getElementById("row_count_pesanan");
		var show3 = document.getElementById("row_list_pesanan");
		var show4 = document.getElementById("table_row_order");

		btn1.style.display = "block";
		btn2.style.display = "none";
		btn3.style.display = "none";
		btn4.style.display = "none";
		show1.style.display = "block";
		show2.style.display = "none";
		show3.style.display = "none";
		show4.style.display = "none";

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

	$scope.categories = []; // inisialisasi array kosong

	$scope.ComboJenisMakanan = function () {
		$http
			.get(base_url("opr/kasir/getdata_kategori"))
			.then(function (response) {
				$scope.categories = response.data; // simpan ke scope
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan:", error);
			});
	};

	$scope.ComboJenisMakanan(); // panggil

	$scope.searchMenu = function () {
		$scope.filteredMenu = $scope.LoadDatMenuAll.filter(function (menu) {
			var keywordMatch = menu.nama
				.toLowerCase()
				.includes($scope.keywordMenu ? $scope.keywordMenu.toLowerCase() : "");

			var categoryMatch = $scope.selectedCategory
				? menu.kategori === $scope.selectedCategory
				: true;

			return keywordMatch && categoryMatch;
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
		var show4 = document.getElementById("table_row_order");

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
					show4.style.display = "none";

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
	$scope.CalculateRowSubtotal = function (item) {
		var harga = parseInt(item.harga) || 0;
		var qty = parseInt(item.qty) || 0;
		var discount_percent = parseFloat(item.discount) || 0;

		var total = harga * qty;
		var discount_value = Math.floor((total * discount_percent) / 100);

		item.potongan = discount_value;

		var subtotal = total - discount_value;
		if (subtotal < 0) subtotal = 0;

		item.subtotal = subtotal;
		var no_order = document.getElementById("lb_tambahan_no_order").innerHTML;
		var no_meja = document.getElementById("lb_tambahan_no_meja").innerHTML;
		// Simpan ke backend (optional)
		var formdata = {
			no_meja: no_meja,
			no_order: no_order,
			menu: item.nama,
			discount: item.discount,
		};

		$http
			.post(base_url("opr/kasir/discount_detail_row"), formdata)
			.then(function (response) {
				// optional: show success
			})
			.catch(function (error) {
				console.error("Terjadi kesalahan saat proses data:", error);
			});

		$scope.CalculateTotal(); // Recalculate global total
	};

	$scope.CalculateTotal = function () {
		var total_harga = 0;
		var qty_total = 0;

		for (var i = 0; i < $scope.LoadDataPesananList.length; i++) {
			var item = $scope.LoadDataPesananList[i];

			var harga = parseInt(item.harga) || 0;
			var qty = parseInt(item.qty) || 0;
			var discount_percent = parseFloat(item.discount) || 0;

			var total = harga * qty;
			var discount_nominal = Math.floor((total * discount_percent) / 100);
			var subtotal = total - discount_nominal;

			if (subtotal < 0) subtotal = 0;

			qty_total += qty;
			total_harga += subtotal;
		}

		// ===== SAFE SET VALUE =====
		function setVal(id, value) {
			var el = document.getElementById(id);
			if (el) el.value = value;
		}

		setVal("qty-total", formatRupiah(qty_total));
		setVal("amount-total", formatRupiah(total_harga));

		// Diskon global
		var discount_input = document.getElementById("discount-nominal");
		var discount_nominal_global = discount_input
			? parseFloat(discount_input.value) || 0
			: 0;

		var discount_value = Math.floor(
			total_harga * (discount_nominal_global / 100)
		);

		var nominal_total = total_harga - discount_value;

		setVal("discount-value", formatRupiah(discount_value));

		// PPN (FIX PALING PENTING)
		var ppn_select = document.getElementById("ppn-select");
		var ppn_percent = ppn_select ? parseFloat(ppn_select.value) || 0 : 0;

		var ppn_amount = Math.floor(nominal_total * (ppn_percent / 100));
		setVal("amount-ppn", formatRupiah(ppn_amount));

		// Grand Total
		var grand_total = nominal_total + ppn_amount;
		setVal("grand-total", formatRupiah(grand_total));
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
						.post(base_url("opr/kasir/create_order_detail_tambahan"), formdata)
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
		var no_booking =
			document.getElementById("lb_tambahan_no_order")?.innerHTML || "";
		var no_meja =
			document.getElementById("lb_tambahan_no_meja")?.innerHTML || "";
		var created_at =
			document.getElementById("lb_tambahan_created_at")?.innerHTML || "";

		document.getElementById("bill_date").innerHTML = created_at;
		document.getElementById("bill_invoice").innerHTML = no_booking;
		document.getElementById("bill_chasier").innerHTML = "Rizki Hamdani";
		document.getElementById("bill_no_meja").innerHTML = no_meja;
		$scope.LoadDataPesananBill = $scope.LoadDataPesananList;
		function getVal(id) {
			var el = document.getElementById(id);
			return el ? el.value : "0";
		}
		// Ambil nilai AMAN
		var qty = getVal("qty-total");
		var subtotal = getVal("amount-total");
		var ppn = getVal("amount-ppn");
		var grandtotal = getVal("grand-total");
		var discount_text = getVal("discount-nominal");
		var discount_value = getVal("discount-value");

		document.getElementById("bill_qty").innerHTML = formatNumber(qty);
		document.getElementById("bill_subtotal").innerHTML = formatRupiah(subtotal);
		document.getElementById("bill_text_discount").innerHTML =
			formatNumber(discount_text);
		document.getElementById("bill_value_discount").innerHTML =
			formatRupiah(discount_value);
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

	$scope.LoadDataPesananSplit = $scope.LoadDataPesananSplit || [];

	$scope.SplitPindahPAy = function (dt) {
		if (!dt || dt.qty <= 0) return;

		// === 1. Kurangi qty di bill utama ===
		dt.qty -= 1;

		var harga = parseInt(dt.harga) || 0;
		var disc = parseFloat(dt.discount) || 0;

		var total = harga * dt.qty;
		var disc_nominal = Math.floor((total * disc) / 100);
		dt.subtotal = total - disc_nominal;

		if (dt.subtotal < 0) dt.subtotal = 0;

		// === 2. Cari item di bill split ===
		var splitItem = $scope.LoadDataPesananSplit.find(function (item) {
			return item.nama === dt.nama;
			// ganti id_menu sesuai primary key item kamu
		});

		if (splitItem) {
			// Jika sudah ada → tambah qty
			splitItem.qty += 1;
		} else {
			// Jika belum ada → clone item
			splitItem = angular.copy(dt);
			splitItem.qty = 1;
			$scope.LoadDataPesananSplit.push(splitItem);
		}

		// === 3. Hitung subtotal split item ===
		var splitTotal = harga * splitItem.qty;
		var splitDiscNominal = Math.floor((splitTotal * disc) / 100);
		splitItem.subtotal = splitTotal - splitDiscNominal;

		if (splitItem.subtotal < 0) splitItem.subtotal = 0;

		// === 4. Hapus item dari bill utama jika qty 0 ===
		if (dt.qty === 0) {
			var index = $scope.LoadDataPesananList.indexOf(dt);
			if (index > -1) {
				$scope.LoadDataPesananList.splice(index, 1);
			}
		}

		// === 5. Update total split (optional) ===
		$scope.HitungTotalSplit();
	};

	$scope.SplitKembali = function (dt) {
		if (!dt || dt.qty <= 0) return;

		var harga = parseInt(dt.harga) || 0;
		var disc = parseFloat(dt.discount) || 0;

		// === 1. Kurangi qty di bill split ===
		dt.qty -= 1;

		var totalSplit = harga * dt.qty;
		var discSplit = Math.floor((totalSplit * disc) / 100);
		dt.subtotal = totalSplit - discSplit;

		if (dt.subtotal < 0) dt.subtotal = 0;

		// === 2. Cari item di bill utama ===
		var mainItem = $scope.LoadDataPesananList.find(function (item) {
			return item.nama === dt.nama;
			// ganti sesuai ID unik item kamu
		});

		if (mainItem) {
			mainItem.qty += 1;
		} else {
			mainItem = angular.copy(dt);
			mainItem.qty = 1;
			$scope.LoadDataPesananList.push(mainItem);
		}

		// === 3. Hitung ulang subtotal bill utama item ===
		var totalMain = harga * mainItem.qty;
		var discMain = Math.floor((totalMain * disc) / 100);
		mainItem.subtotal = totalMain - discMain;

		if (mainItem.subtotal < 0) mainItem.subtotal = 0;

		// === 4. Hapus item dari bill split jika qty 0 ===
		if (dt.qty === 0) {
			var idx = $scope.LoadDataPesananSplit.indexOf(dt);
			if (idx > -1) {
				$scope.LoadDataPesananSplit.splice(idx, 1);
			}
		}

		// === 5. Update total split ===
		$scope.HitungTotalSplit();
	};

	$scope.HitungTotalSplit = function () {
		var total = 0;

		angular.forEach($scope.LoadDataPesananSplit, function (item) {
			total += item.subtotal || 0;
		});

		$scope.TotalSplit = total;
	};

	$scope.HitungSplitBill = function () {
		var totalSplit = parseInt($scope.TotalSplit) || 0;

		var ppnEl = document.getElementById("split-ppn-percent");
		if (!ppnEl) return;

		var ppnPercent = parseFloat(ppnEl.value) || 0;

		var ppnValue = Math.floor((totalSplit * ppnPercent) / 100);
		var grandTotal = totalSplit + ppnValue;

		// tampilkan
		var ppnValueEl = document.getElementById("split-ppn-value");
		if (ppnValueEl) {
			ppnValueEl.value = formatRupiah(ppnValue);
		}

		var grandTotalEl = document.getElementById("split-grand-total");
		if (grandTotalEl) {
			grandTotalEl.innerHTML = "Rp. " + formatRupiah(grandTotal);
		}

		// simpan
		$scope.SplitGrandTotal = grandTotal;

		// update kembalian
		$scope.HitungKembalianSplit();
	};

	$scope.HitungKembalianSplit = function () {
		var bayarEl = document.getElementById("split-paid-amount");
		if (!bayarEl) return;

		var bayar = bayarEl.value.replace(/\D/g, "");
		bayar = parseInt(bayar) || 0;

		var grandTotal = parseInt($scope.SplitGrandTotal) || 0;
		var kembalian = bayar - grandTotal;

		if (kembalian < 0) kembalian = 0;

		document.getElementById("split-change").innerHTML =
			"Rp. " + formatRupiah(kembalian);
	};

	$scope.OnChangePaymentMethod = function () {
		var metode = document.getElementById("split-payment-method").value;
		var paidEl = document.getElementById("split-paid-amount");

		if (!paidEl) return;

		// QRIS & TRANSFER → AUTO LUNAS
		if (metode === "QRIS" || metode === "TRANSFER") {
			var grandTotal = parseInt($scope.SplitGrandTotal) || 0;

			paidEl.value = formatRupiah(grandTotal);
			paidEl.setAttribute("readonly", true);
		} else {
			// CASH → INPUT MANUAL
			paidEl.value = "";
			paidEl.removeAttribute("readonly");
		}

		// update kembalian
		$scope.HitungKembalianSplit();
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
		var discount_text = $("#discount-nominal").val();
		var discount_value = $("#discount-value").val();
		document.getElementById("total-qty-payment-before-service").innerHTML = qty;
		document.getElementById("subtotal-payment-before-service").innerHTML =
			formatRupiah(subtotal);
		if (ppn_text === "") {
			document.getElementById("ppn-text-payment-before-service").innerHTML = 0;
		} else {
			document.getElementById("ppn-text-payment-before-service").innerHTML =
				ppn_text;
		}
		document.getElementById("lb-discount-before-service").innerHTML =
			formatNumber(discount_text);
		document.getElementById("Discount-before-service").innerHTML =
			formatRupiah(discount_value);
		document.getElementById("ppn-payment-before-service").innerHTML =
			formatRupiah(ppn);
		document.getElementById("grand-total-payment-before-service").innerHTML =
			formatRupiah(total);

		$("#my-modal-payment-before-service").modal("show");
	};

	$scope.pay_after_service = function () {
		$scope.global_no_booking = document.getElementById(
			"lb_tambahan_no_order"
		).innerHTML;
		$scope.global_no_meja = document.getElementById(
			"lb_tambahan_no_meja"
		).innerHTML;
		document.getElementById("lb_no_booking_payment_After_service").innerHTML =
			$scope.global_no_booking;
		document.getElementById("lb_no_meja_payment_After_service").innerHTML =
			$scope.global_no_meja;
		var qty = $("#qty-total").val();
		var subtotal = $("#amount-total").val();
		var ppn_text = $("#ppn-select").val();
		var ppn = $("#amount-ppn").val();
		var total = $("#grand-total").val();
		var discount_text = $("#discount-nominal").val();
		var discount_value = $("#discount-value").val();

		document.getElementById("total-qty-payment-After-service").innerHTML = qty;
		document.getElementById("subtotal-payment-After-service").innerHTML =
			formatRupiah(subtotal);
		if (ppn_text === "") {
			document.getElementById("ppn-text-payment-After-service").innerHTML = 0;
		} else {
			document.getElementById("ppn-text-payment-After-service").innerHTML =
				ppn_text;
		}

		document.getElementById("lb-discount-After-service").innerHTML =
			formatNumber(discount_text);
		document.getElementById("Discount-After-service").innerHTML =
			formatNumber(discount_value);
		document.getElementById("ppn-payment-After-service").innerHTML =
			formatRupiah(ppn);
		document.getElementById("grand-total-payment-After-service").innerHTML =
			formatRupiah(total);
		$("#my-modal-payment-After-service").modal("show");
	};

	$scope.LoadDataPesananDetail = [];
	$scope.LoadDataPesananGabungSementara = [];
	$scope.LoadDataPesananDetailAll = [];

	$scope.GabungBill = function () {
		var no_meja = document.getElementById("lb_tambahan_no_meja").innerHTML;
		var no_booking = document.getElementById("lb_tambahan_no_order").innerHTML;
		var fullname = document.getElementById("userdata").dataset.fullname;
		var created_at = document.getElementById(
			"lb_tambahan_created_at"
		).innerHTML;
		$scope.DaftarMejaTerisi(no_meja);
		$scope.DetailPesanan(no_booking, no_meja);
		document.getElementById("bill_no_order_gabungan").innerHTML = no_booking;
		document.getElementById("bill_chasier_gabungan").innerHTML = fullname;
		document.getElementById("bill_date_gabungan").innerHTML = created_at;
		$("#my-modal-gabung-bill").modal("show");
	};

	$scope.DaftarMejaTerisi = function (no_meja) {
		var formdata = { no_meja: no_meja };
		$http
			.post(base_url("opr/kasir/get_list_meja_terisi"), formdata)
			.then(function (response) {
				$scope.listMejaGabung = response.data;
			});
	};

	$scope.UpdateGabungAll = function () {
		$scope.LoadDataPesananDetailAll = $scope.LoadDataPesananDetail.concat(
			$scope.LoadDataPesananGabungSementara
		);

		// FIX PENTING → Pindahin ke $timeout supaya Angular selesai render DOM dulu
		$timeout(function () {
			$scope.CalculateTotalForGabung();
			$scope.groupPesananByOrder();
			$scope.CalculatePaymentGabung();
		}, 0);
	};

	$scope.DetailPesanan = function (no_booking, no_meja) {
		var formdata = { no_booking: no_booking, no_meja: no_meja };
		$scope.LoadDataPesananDetail = [];
		$scope.LoadDataPesananGabungSementara = [];
		$scope.LoadDataPesananDetailAll = [];

		$http
			.post(base_url("opr/kasir/get_pesanan_detail"), formdata)
			.then(function (response) {
				$scope.LoadDataPesananDetail = response.data;
				$scope.UpdateGabungAll();
			});
	};

	$scope.GabungListMeja = function () {
		var selectedMeja = $scope.cmb_gabung;
		if (!selectedMeja) return;

		$http
			.post(base_url("opr/kasir/get_pesanan_detail_no_meja"), {
				no_meja: selectedMeja,
			})
			.then(function (response) {
				$scope.LoadDataPesananGabungSementara =
					$scope.LoadDataPesananGabungSementara.concat(response.data);
				$scope.UpdateGabungAll();
				$scope.CalculateTotalForGabung();
				$scope.CalculatePaymentGabung();
			});
	};

	$scope.ResetGabungPesanan = function () {
		$scope.LoadDataPesananGabungSementara = []; // Kosongkan data gabungan
		$scope.UpdateGabungAll(); // Update tampilan tabel
	};

	$scope.CalculateTotalForGabung = function () {
		var total_harga = 0;
		var qty_total = 0;

		// Loop data pesanan
		var dataGabungan = $scope.LoadDataPesananDetail.concat(
			$scope.LoadDataPesananGabungSementara
		);
		for (var i = 0; i < dataGabungan.length; i++) {
			var item = dataGabungan[i];
			var harga = parseInt(item.harga) || 0;
			var qty = parseInt(item.qty) || 0;
			var potongan = parseInt(item.potongan) || 0;
			var discount_percent = parseFloat(item.discount) || 0;

			var total = harga * qty;
			// var diskon = Math.floor(total * (discount_percent / 100));
			var subtotal = total - potongan;

			if (subtotal < 0) subtotal = 0;

			qty_total += qty;
			total_harga += subtotal;
		}

		// Update Qty dan Subtotal
		document.getElementById("qty-total-gabung").value = formatRupiah(qty_total);
		document.getElementById("bill_qty_gabungan").innerHTML =
			formatRupiah(qty_total);
		document.getElementById("amount-total-gabung").value =
			formatRupiah(total_harga);
		document.getElementById("bill_subtotal_gabungan").innerHTML =
			formatRupiah(total_harga);

		// Diskon tambahan dari input
		var discountInput =
			parseFloat(document.getElementById("discount-nominal-gabung").value) || 0;
		var discountValue = Math.floor(total_harga * (discountInput / 100));
		document.getElementById("discount-value-gabung").value =
			formatRupiah(discountValue);

		var subtotalSetelahDiskon = total_harga - discountValue;

		// Hitung PPN
		var ppn_percent = parseFloat($scope.ppnValue) || 0;
		var ppn_amount = Math.floor(subtotalSetelahDiskon * (ppn_percent / 100));
		document.getElementById("amount-ppn-gabung").value =
			formatRupiah(ppn_amount);
		document.getElementById("bill_ppn_gabungan").innerHTML =
			formatRupiah(ppn_amount);

		// Grand Total
		var grand_total = subtotalSetelahDiskon + ppn_amount;
		document.getElementById("grand-total-gabung").value =
			formatRupiah(grand_total);
		document.getElementById("bill_grand_total_gabungan").innerHTML =
			formatRupiah(grand_total);

		$scope.CalculatePaymentGabung();
	};

	$scope.groupedOrders = [];
	$scope.groupPesananByOrder = function () {
		$scope.groupedOrders = [];
		const dataGabungan = $scope.LoadDataPesananDetail.concat(
			$scope.LoadDataPesananGabungSementara
		);

		dataGabungan.sort((a, b) => a.no_meja.localeCompare(b.no_meja)); // Sort by no_meja

		const grouped = {};

		dataGabungan.forEach(function (item) {
			if (!grouped[item.no_meja]) {
				grouped[item.no_meja] = {
					no_meja: item.no_meja,
					items: [],
				};
			}
			grouped[item.no_meja].items.push(item); // ← ini yang tadi salah, harusnya no_meja
		});

		$scope.groupedOrders = Object.values(grouped);
	};

	$scope.groupPesananByOrder();

	// Payment Before Service
	$scope.PaymentBeforeServiceSubmit = function () {
		var no_booking = document.getElementById(
			"lb_no_booking_payment_before_service"
		).innerHTML;
		var no_meja = document.getElementById(
			"lb_no_meja_payment_before_service"
		).innerHTML;
		var qty = unformatNumber(
			document.getElementById("total-qty-payment-before-service").innerHTML
		);
		var subtotal = unformatNumber(
			document.getElementById("subtotal-payment-before-service").innerHTML
		);
		var discount_text = unformatNumber(
			document.getElementById("lb-discount-before-service").innerHTML
		);
		var discount = unformatNumber(
			document.getElementById("Discount-before-service").innerHTML
		);

		var ppn_text = unformatNumber(
			document.getElementById("ppn-text-payment-before-service").innerHTML
		);
		var ppn = unformatNumber(
			document.getElementById("ppn-payment-before-service").innerHTML
		);
		var grand_total = unformatNumber(
			document.getElementById("grand-total-payment-before-service").innerHTML
		);
		var metode_payment = $("#combo-payment-before-service").val();
		var jumlah_dibayar = unformatNumber(
			$("#jumlah-dibayar-payment-before-service").val()
		);
		var kembalian = unformatNumber(
			document.getElementById("kembalian-payment-before-service").innerHTML
		);
		var refrence_payment = $("#combo-reference-payment-before-service").val();
		var refrence_number = $("#reference-number-payment-before-service").val();
		var Metode_Service = "Pay Before Service";

		var formdata = {
			no_order: no_booking,
			no_meja: no_meja,
			qty: qty,
			subtotal: subtotal,
			discount_text: discount_text,
			discount: discount,
			ppn_text: ppn_text,
			ppn: ppn,
			amount_total: grand_total,
			metode: metode_payment,
			dibayar: jumlah_dibayar,
			kembalian: kembalian,
			refrence_payment: refrence_payment,
			refrence_number: refrence_number,
			metode_service: Metode_Service,
		};

		Swal.fire({
			title: "Apakah anda yakin?",
			text: "Sudahkah Anda melakukan Pengechekan Pembayaran sebelum Layanan Disimpan Kedalam Database !",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Ya, Lanjutkan!",
		}).then((result) => {
			if (result.isConfirmed) {
				$http
					.post(base_url("opr/kasir/payment_before_service"), formdata)
					.then(function (response) {
						if (response.data.status == "success") {
							Swal.fire({
								icon: "success",
								title: "Berhasil",
								text: "Pembayaran sebelum layanan berhasil !",
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

	// Payment After Service
	$scope.PaymentAfterServiceSubmit = function () {
		var no_booking = document.getElementById(
			"lb_no_booking_payment_After_service"
		).innerHTML;
		var no_meja = document.getElementById(
			"lb_no_meja_payment_After_service"
		).innerHTML;
		var qty = unformatNumber(
			document.getElementById("total-qty-payment-After-service").innerHTML
		);
		var subtotal = unformatNumber(
			document.getElementById("subtotal-payment-After-service").innerHTML
		);
		var discount_text = unformatNumber(
			document.getElementById("lb-discount-After-service").innerHTML
		);
		var discount = unformatNumber(
			document.getElementById("Discount-After-service").innerHTML
		);
		var ppn_text = unformatNumber(
			document.getElementById("ppn-text-payment-After-service").innerHTML
		);
		var ppn = unformatNumber(
			document.getElementById("ppn-payment-After-service").innerHTML
		);
		var grand_total = unformatNumber(
			document.getElementById("grand-total-payment-After-service").innerHTML
		);
		var metode_payment = $("#combo-payment-After-service").val();
		var jumlah_dibayar = unformatNumber(
			$("#jumlah-dibayar-payment-After-service").val()
		);
		var kembalian = unformatNumber(
			document.getElementById("kembalian-payment-After-service").innerHTML
		);
		var refrence_payment = $("#combo-reference-payment-After-service").val();
		var refrence_number = $("#reference-number-payment-After-service").val();
		var Metode_Service = "Pay After Service";

		var formdata = {
			no_order: no_booking,
			no_meja: no_meja,
			qty: qty,
			subtotal: subtotal,
			discount_text: discount_text,
			discount: discount,
			ppn_text: ppn_text,
			ppn: ppn,
			amount_total: grand_total,
			metode: metode_payment,
			dibayar: jumlah_dibayar,
			kembalian: kembalian,
			refrence_payment: refrence_payment,
			refrence_number: refrence_number,
			metode_service: Metode_Service,
		};

		Swal.fire({
			title: "Apakah anda yakin?",
			text: "Sudahkah Anda melakukan Pengechekan Pembayaran sebelum Layanan Disimpan Kedalam Database !",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Ya, Lanjutkan!",
		}).then((result) => {
			if (result.isConfirmed) {
				$http
					.post(base_url("opr/kasir/payment_after_service"), formdata)
					.then(function (response) {
						if (response.data.status == "success") {
							Swal.fire({
								icon: "success",
								title: "Berhasil",
								text: "Pembayaran sebelum layanan berhasil !",
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
	//

	$scope.pay_payment_bill_gabung = function () {
		$scope.CalculatePaymentGabung();
		var card = document.getElementById("card-payment-BillGabungan");
		if (card.style.display === "none") {
			card.style.display = "block";
		} else {
			card.style.display = "none";
		}
	};

	$scope.CalculatePaymentGabung = function () {
		var total_qty = unformatNumber(
			document.getElementById("qty-total-gabung").value
		);
		var subtoal = unformatNumber($("#amount-total-gabung").val());
		var ppn_text = unformatNumber($("#ppn-select-gabung").val());
		var ppn_value = unformatNumber(
			document.getElementById("amount-ppn-gabung").value
		);
		var discount_text = unformatNumber(
			document.getElementById("discount-nominal-gabung").value
		);
		var discount_value = unformatNumber(
			document.getElementById("discount-value-gabung").value
		);
		var grand_total = unformatNumber(
			document.getElementById("grand-total-gabung").value
		);
		document.getElementById(
			"total-qty-payment-BillGabungan-service"
		).innerHTML = formatNumber(total_qty);

		document.getElementById("subtotal-payment-BillGabungan-service").innerHTML =
			formatNumber(subtoal);

		// billl
		document.getElementById("bill_discount_text_gabungan").innerHTML =
			formatNumber(discount_text);
		document.getElementById("bill_potongan_value_gabungan").innerHTML =
			formatNumber(discount_value);

		// submit
		document.getElementById("bill_discount_persen_gabungan").innerHTML =
			formatNumber(discount_text);
		document.getElementById("bill_discount_value_gabungan").innerHTML =
			formatNumber(discount_value);

		document.getElementById("ppn-text-payment-BillGabungan-service").innerHTML =
			formatNumber(ppn_text);

		document.getElementById("ppn-payment-BillGabungan-service").innerHTML =
			formatNumber(ppn_value);

		document.getElementById(
			"grand-total-payment-BillGabungan-service"
		).innerHTML = formatNumber(grand_total);
	};

	$scope.PaymentBillGabunganSubmit = function () {
		var qty = unformatNumber(
			document.getElementById("total-qty-payment-BillGabungan-service")
				.innerHTML
		);
		var subtotal = unformatNumber(
			document.getElementById("subtotal-payment-BillGabungan-service").innerHTML
		);

		var discount_text = unformatNumber(
			document.getElementById("bill_discount_persen_gabungan").innerHTML
		);

		var discount_value = unformatNumber(
			document.getElementById("bill_discount_value_gabungan").innerHTML
		);

		var ppn_text = unformatNumber(
			document.getElementById("ppn-text-payment-BillGabungan-service").innerHTML
		);

		var ppn = unformatNumber(
			document.getElementById("ppn-payment-BillGabungan-service").innerHTML
		);

		var grand_total = unformatNumber(
			document.getElementById("grand-total-payment-BillGabungan-service")
				.innerHTML
		);

		var metode_payment = $("#combo-payment-BillGabungan-service").val();
		var jumlah_dibayar = unformatNumber(
			$("#jumlah-dibayar-payment-BillGabungan-service").val()
		);
		var kembalian = unformatNumber(
			document.getElementById("kembalian-payment-BillGabungan-service")
				.innerHTML
		);
		var refrence_payment = $(
			"#combo-reference-payment-BillGabungan-service"
		).val();
		var refrence_number = $(
			"#reference-number-payment-BillGabungan-service"
		).val();
		var Metode_Service = "Pay Gabung Bill";

		var formdata = {
			group: $scope.groupedOrders,
			discount_text: discount_text,
			discount_value: discount_value,
			ppn_text: ppn_text,
			metode: metode_payment,
			dibayar: jumlah_dibayar,
			kembalian: kembalian,
			refrence_payment: refrence_payment,
			refrence_number: refrence_number,
			metode_service: Metode_Service,
		};

		Swal.fire({
			title: "Apakah anda yakin?",
			text: "Sudahkah Anda melakukan Pengechekan Pembayaran sebelum Layanan Disimpan Kedalam Database !",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Ya, Lanjutkan!",
		}).then((result) => {
			if (result.isConfirmed) {
				$http
					.post(base_url("opr/kasir/payment_bill_gabung"), formdata)
					.then(function (response) {
						if (response.data.status == "success") {
							Swal.fire({
								icon: "success",
								title: "Berhasil",
								text: "Pembayaran sebelum layanan berhasil !",
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

	// Bill Billing
	$scope.ShowDetailTransaksi = function (dt) {
		var no_booking = dt.no_order;
		var no_meja = dt.no_meja;
		var no_transaksi = dt.no_transaksi;

		document.getElementById("lb_bill_billing_no_pesanan").innerHTML =
			no_booking;
		document.getElementById("lb_bill_billing_no_meja").innerHTML = no_meja;

		$scope.DetailPesananBilling(no_booking, no_meja, no_transaksi);

		// // Unbind event dulu biar tidak dobel
		// $("#my-modal-bill-billing")
		// 	.off("shown.bs.modal")
		// 	.on("shown.bs.modal", function () {
		// 		// printCard("printArea3");
		// 	});

		// Tampilkan modal
		$("#my-modal-bill-billing").modal("show");
		printEppposAfterPayment();
	};

	//
	$scope.DetailPesananBilling = function (no_booking, no_meja, no_transaksi) {
		var formdata = {
			no_booking: no_booking,
			no_meja: no_meja,
			no_transaksi: no_transaksi,
		};
		$scope.LoadDataPesananDetail = [];
		$scope.LoadDataPesananGabungSementara = [];
		$scope.LoadDataPesananDetailAll = [];

		$http
			.post(base_url("transaksi/invoice/get_detail_transaksi"), formdata)
			.then(function (response) {
				var data = response.data.transaksi;
				document.getElementById("bill_billing_date_show").innerHTML =
					data.created_at;
				document.getElementById("bill_billing_chasier_show").innerHTML =
					data.created_by;
				document.getElementById("bill_billing_no_order_show").innerHTML =
					data.no_order;
				document.getElementById("bill_billing_qty_show").innerHTML =
					formatNumber(data.qty);
				document.getElementById("bill_billing_subtotal_show").innerHTML =
					formatRupiah(data.subtotal);

				document.getElementById("bill_billing_discount_persen").innerHTML =
					formatNumber(data.discount);
				document.getElementById("bill_billing_discount_show").innerHTML =
					formatRupiah(data.potongan);
				document.getElementById("bill_billing_ppn_show").innerHTML =
					formatRupiah(data.ppn);

				document.getElementById("bill_billing_grand_total_show").innerHTML =
					formatRupiah(data.amount_total);
				document.getElementById("bill_billing_metode_show").innerHTML =
					data.metode;
				document.getElementById("bill_billing_jumlah_dibayar_show").innerHTML =
					formatRupiah(data.dibayar);
				document.getElementById("bill_billing_kembalian_show").innerHTML =
					formatRupiah(data.kembalian);
				document.getElementById("bill_billing_service_metode_show").innerHTML =
					data.metode_service;
				$scope.LoadDataPesananDetail = response.data.detail_transaksi;
				$scope.UpdateGabungAll();
			});
	};

	// Split Bill
	$scope.SplitBill = function () {
		var no_booking = document.getElementById("lb_tambahan_no_order").innerHTML;
		var no_meja = document.getElementById("lb_tambahan_no_meja").innerHTML;
		document.getElementById("lb_no_booking_split_bill").innerHTML = no_booking;
		document.getElementById("lb_no_meja_split_bill").innerHTML = no_meja;
		$("#my-modal-split-bill").modal("show");
	};

	$scope.SubmitSplitBill = function () {
		var metode_bayar = $("#split-payment-method").val();
		if ($scope.LoadDataPesananSplit.length == 0) {
			Swal.fire({
				icon: "error",
				title: "Gagal",
				text: "Tidak ada pesanan yang dipilih !",
			});
		} else if (!metode_bayar) {
			Swal.fire({
				icon: "error",
				title: "Gagal",
				text: "Metode pembayaran belum dipilih !",
			});
		} else {
			var no_order = document.getElementById(
				"lb_no_booking_split_bill"
			).innerHTML;
			var no_meja = document.getElementById("lb_no_meja_split_bill").innerHTML;
			var total_qty = 0;
			var subtotal = 0;
			angular.forEach($scope.LoadDataPesananSplit, function (dt) {
				total_qty += dt.qty;
				subtotal += dt.subtotal;
			});
			var ppn_text = $("#split-ppn-percent").val();
			var ppn_value = subtotal * (ppn_text / 100);
			var grant_total = subtotal + ppn_value;
			var metode_payment = $("#split-payment-method").val();
			var jumlah_dibayar = unformatNumber_New($("#split-paid-amount").val());
			var kembalian = jumlah_dibayar - grant_total;

			// form
			var formdata = {
				no_order: no_order,
				no_meja: no_meja,
				qty: total_qty,
				subtotal: subtotal,
				ppn_text: ppn_text,
				ppn: ppn_value,
				amount_total: grant_total,
				metode: metode_payment,
				dibayar: jumlah_dibayar,
				kembalian: kembalian,
				detail: $scope.LoadDataPesananSplit,
			};

			Swal.fire({
				title: "Apakah anda yakin?",
				text: "Sudahkah Anda melakukan Pengechekan Pembayaran sebelum Layanan Disimpan Kedalam Database !",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Ya, Lanjutkan!",
			}).then((result) => {
				if (result.isConfirmed) {
					$http
						.post(base_url("opr/kasir/payment_split_bill"), formdata)
						.then(function (response) {
							if (response.data.status == "success") {
								Swal.fire({
									icon: "success",
									title: "Berhasil",
									text: "Pembayaran split bill berhasil !",
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

	$scope.cancel = {
		no_booking: "",
		no_meja: "",
		reason: "",
		password: "",
		loading: false,
		error: "",
	};
	// camcel order
	$scope.cancel_order = function () {
		$scope.cancel.no_booking = document.getElementById(
			"lb_tambahan_no_order"
		).innerHTML;
		$scope.cancel.no_meja = document.getElementById(
			"lb_tambahan_no_meja"
		).innerHTML;
		$scope.cancel.reason = "";
		$scope.cancel.password = "";
		$scope.cancel.error = "";
		$scope.cancel.loading = false;
		$("#my-modal-cancel-order").modal("show");
	};

	$scope.submitCancelOrder = function () {
		if (!$scope.cancel.reason) {
			$scope.cancel.error = "Alasan pembatalan wajib diisi";
			return;
		}

		if (!$scope.cancel.password) {
			$scope.cancel.error = "Password Super Admin wajib diisi";
			return;
		}

		$scope.cancel.loading = true;
		$scope.cancel.error = "";

		$http
			.post(base_url("opr/kasir/cancel_order"), {
				no_booking: $scope.cancel.no_booking,
				no_meja: $scope.cancel.no_meja,
				reason: $scope.cancel.reason,
				password: $scope.cancel.password,
			})
			.then(function (res) {
				if (res.data.status === "success") {
					$("#my-modal-cancel-order").modal("hide");
					swal.fire({
						icon: "success",
						title: "Berhasil",
						text: "Pesanan berhasil dibatalkan !",
					});
					document.location.reload();
				} else {
					$scope.cancel.error = res.data.message;
				}
			})
			.catch(function () {
				$scope.cancel.error = "Terjadi kesalahan server";
			})
			.finally(function () {
				$scope.cancel.loading = false;
			});
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
	if (angka === undefined || angka === null) return "0";

	angka = angka.toString().replace(/\D/g, "");
	return angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function formatInputRupiah(el) {
	var angka = el.value.replace(/\D/g, "");
	el.value = formatRupiah(angka);
}

// Fungsi format angka: 1000000 => "1.000.000"
function formatNumber(num) {
	return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Fungsi unformat angka: "1.000.000" => 1000000
function unformatNumber(str) {
	return parseInt(str.replace(/\./g, "").replace(/,/g, "")) || 0;
}

function unformatNumber_New(str) {
	if (!str) return 0;

	return parseInt(str.toString().replace(/\./g, "").replace(/,/g, ""), 10) || 0;
}
const inputBayar = document.getElementById(
	"jumlah-dibayar-payment-before-service"
);

inputBayar.addEventListener("input", function (e) {
	let cursorPos = this.selectionStart;
	let originalLength = this.value.length;

	this.value = formatRupiah(this.value);

	let updatedLength = this.value.length;
	this.selectionEnd = cursorPos + (updatedLength - originalLength);
});

inputBayar.addEventListener("keydown", function (e) {
	if (e.key === "Enter") {
		e.preventDefault();

		let grand_Total = document.getElementById(
			"grand-total-payment-before-service"
		).innerHTML;
		let jumlahBayar = unformatNumber(this.value);
		let totalTagihan = unformatNumber(grand_Total);
		let kembalian = jumlahBayar - totalTagihan;

		// ✅ Cek apakah jumlah bayar kurang dari total tagihan
		if (jumlahBayar < totalTagihan) {
			Swal.fire({
				title: "Error",
				text: "Jumlah bayar tidak boleh kurang dari total tagihan",
				icon: "error",
			});
			document.getElementById("jumlah-dibayar-payment-before-service").value =
				"";
			document.getElementById("kembalian-payment-before-service").innerHTML =
				"Rp 0";
			return;
		}

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

		document.getElementById("jumlah-dibayar-payment-before-service").value = "";
		document.getElementById("kembalian-payment-before-service").innerHTML = "0";

		document.getElementById(
			"jumlah-dibayar-payment-before-service"
		).readOnly = false;
		document.getElementById(
			"kembalian-payment-before-service"
		).readOnly = false;
	} else if (combo_methode == "QRIS") {
		$("#display_jumlah_dibayar_payment_before_service").css(
			"display",
			"table-row"
		);
		$("#display_kembalian_payment_before_service").css("display", "table-row");
		$("#display_reference_payment_before_service").css("display", "table-row");

		combo_insert_qr_code("combo-reference-payment-before-service");
		document.getElementById("jumlah-dibayar-payment-before-service").value = "";
		document.getElementById("kembalian-payment-before-service").innerHTML = "0";

		document.getElementById(
			"jumlah-dibayar-payment-before-service"
		).readOnly = true;
		document.getElementById("kembalian-payment-before-service").readOnly = true;
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

		combo_insert_bank_tambahan("combo-reference-payment-before-service");
		document.getElementById("jumlah-dibayar-payment-before-service").value = "";
		document.getElementById("kembalian-payment-before-service").innerHTML = "0";

		document.getElementById(
			"jumlah-dibayar-payment-before-service"
		).readOnly = true;
		document.getElementById("kembalian-payment-before-service").readOnly = true;
	}
}

function combo_insert_qr_code(combo) {
	const select = document.getElementById(combo);
	select.innerHTML = "";
	var data_array = [
		{ value: "Bank Transfer", text: "Bank Transfer" },
		{ value: "E-Wallet", text: "E-Wallet" },
	];
	const defaultOption = document.createElement("option");
	defaultOption.value = "";
	defaultOption.text = "Pilih";
	select.appendChild(defaultOption);
	for (let i = 0; i < data_array.length; i++) {
		const option = document.createElement("option");
		option.value = data_array[i].value;
		option.text = data_array[i].text;
		select.appendChild(option);
	}
}

function combo_insert_bank_tambahan(combo) {
	const select = document.getElementById(combo);
	select.innerHTML = "";
	var data_array = [
		{ value: "BCA", text: "BCA" },
		{ value: "BNI", text: "BNI" },
		{ value: "BRI", text: "BRI" },
		{ value: "MANDIRI", text: "MANDIRI" },
		{ value: "BTN", text: "BTN" },
		{ value: "CIMB Niaga", text: "CIMB Niaga" },
		{ value: "Permata", text: "Permata" },
		{ value: "HSBC", text: "HSBC" },
		{ value: "Jago", text: "Jago" },
		{ value: "Other Bank", text: "Other Bank" },
	];
	const defaultOption = document.createElement("option");
	defaultOption.value = "";
	defaultOption.text = "Pilih";
	select.appendChild(defaultOption);
	for (let i = 0; i < data_array.length; i++) {
		const option = document.createElement("option");
		option.value = data_array[i].value;
		option.text = data_array[i].text;
		select.appendChild(option);
	}
}

function changeReferencePaymentBeforeService() {
	let grand_Total = document.getElementById(
		"grand-total-payment-before-service"
	).innerHTML;
	let totalTagihan = unformatNumber(grand_Total);
	document.getElementById("jumlah-dibayar-payment-before-service").value =
		formatNumber(totalTagihan);
	var jumlahBayar = unformatNumber(
		document.getElementById("jumlah-dibayar-payment-before-service").value
	);
	let kembalian = jumlahBayar - totalTagihan;
	document.getElementById("kembalian-payment-before-service").innerHTML =
		formatRupiah(kembalian.toString());
}

function changePaymentAfterService() {
	var combo_methode = $("#combo-payment-After-service").val();

	$("#display_jumlah_dibayar_payment_After_service").css("display", "none");
	$("#display_kembalian_payment_After_service").css("display", "none");
	$("#display_reference_payment_After_service").css("display", "none");
	$("#display_reference_number_payment_After_service").css("display", "none");

	if (combo_methode == "Cash") {
		$("#display_jumlah_dibayar_payment_After_service").css(
			"display",
			"table-row"
		);
		$("#display_kembalian_payment_After_service").css("display", "table-row");

		document.getElementById("jumlah-dibayar-payment-After-service").value = "";
		document.getElementById("kembalian-payment-After-service").innerHTML = "0";

		document.getElementById(
			"jumlah-dibayar-payment-After-service"
		).readOnly = false;
		document.getElementById("kembalian-payment-After-service").readOnly = false;
	} else if (combo_methode == "QRIS") {
		$("#display_jumlah_dibayar_payment_After_service").css(
			"display",
			"table-row"
		);
		$("#display_kembalian_payment_After_service").css("display", "table-row");
		$("#display_reference_payment_After_service").css("display", "table-row");

		combo_insert_qr_code("combo-reference-payment-After-service");
		document.getElementById("jumlah-dibayar-payment-After-service").value = "";
		document.getElementById("kembalian-payment-After-service").innerHTML = "0";

		document.getElementById(
			"jumlah-dibayar-payment-After-service"
		).readOnly = true;
		document.getElementById("kembalian-payment-After-service").readOnly = true;
	} else if (combo_methode == "Bank Transfer") {
		$("#display_jumlah_dibayar_payment_After_service").css(
			"display",
			"table-row"
		);
		$("#display_kembalian_payment_After_service").css("display", "table-row");
		$("#display_reference_payment_After_service").css("display", "table-row");
		$("#display_reference_number_payment_After_service").css(
			"display",
			"table-row"
		);

		combo_insert_bank_tambahan("combo-reference-payment-After-service");
		document.getElementById("jumlah-dibayar-payment-After-service").value = "";
		document.getElementById("kembalian-payment-After-service").innerHTML = "0";

		document.getElementById(
			"jumlah-dibayar-payment-After-service"
		).readOnly = true;
		document.getElementById("kembalian-payment-After-service").readOnly = true;
	}
}

function changeReferencePaymentAfterService() {
	let grand_Total = document.getElementById(
		"grand-total-payment-After-service"
	).innerHTML;
	let totalTagihan = unformatNumber(grand_Total);
	document.getElementById("jumlah-dibayar-payment-After-service").value =
		formatNumber(totalTagihan);
	var jumlahBayar = unformatNumber(
		document.getElementById("jumlah-dibayar-payment-After-service").value
	);
	let kembalian = jumlahBayar - totalTagihan;
	document.getElementById("kembalian-payment-Ater-service").innerHTML =
		formatRupiah(kembalian.toString());
}

const inputBayar2 = document.getElementById(
	"jumlah-dibayar-payment-After-service"
);

inputBayar2.addEventListener("input", function (e) {
	let cursorPos = this.selectionStart;
	let originalLength = this.value.length;

	this.value = formatRupiah(this.value);

	let updatedLength = this.value.length;
	this.selectionEnd = cursorPos + (updatedLength - originalLength);
});

inputBayar2.addEventListener("keydown", function (e) {
	if (e.key === "Enter") {
		e.preventDefault();

		let grand_Total = document.getElementById(
			"grand-total-payment-After-service"
		).innerHTML;
		let jumlahBayar = unformatNumber(this.value);
		let totalTagihan = unformatNumber(grand_Total);
		let kembalian = jumlahBayar - totalTagihan;

		// ✅ Cek apakah jumlah bayar kurang dari total tagihan
		if (jumlahBayar < totalTagihan) {
			Swal.fire({
				title: "Error",
				text: "Jumlah bayar tidak boleh kurang dari total tagihan",
				icon: "error",
			});
			document.getElementById("jumlah-dibayar-payment-After-service").value =
				"";
			document.getElementById("kembalian-payment-After-service").innerHTML =
				"Rp 0";
			return;
		}

		document.getElementById("kembalian-payment-After-service").innerHTML =
			formatRupiah(kembalian.toString());
	}
});

function changePaymentBillGabunganService() {
	var combo_methode = $("#combo-payment-BillGabungan-service").val();

	$("#display_jumlah_dibayar_payment_BillGabungan_service").css(
		"display",
		"none"
	);
	$("#display_kembalian_payment_BillGabungan_service").css("display", "none");
	$("#display_reference_payment_BillGabungan_service").css("display", "none");
	$("#display_reference_number_payment_BillGabungan_service").css(
		"display",
		"none"
	);

	if (combo_methode == "Cash") {
		$("#display_jumlah_dibayar_payment_BillGabungan_service").css(
			"display",
			"table-row"
		);
		$("#display_kembalian_payment_BillGabungan_service").css(
			"display",
			"table-row"
		);

		document.getElementById(
			"jumlah-dibayar-payment-BillGabungan-service"
		).value = "";
		document.getElementById(
			"kembalian-payment-BillGabungan-service"
		).innerHTML = "0";

		document.getElementById(
			"jumlah-dibayar-payment-BillGabungan-service"
		).readOnly = false;
		document.getElementById(
			"kembalian-payment-BillGabungan-service"
		).readOnly = false;
	} else if (combo_methode == "QRIS") {
		$("#display_jumlah_dibayar_payment_BillGabungan_service").css(
			"display",
			"table-row"
		);
		$("#display_kembalian_payment_BillGabungan_service").css(
			"display",
			"table-row"
		);
		$("#display_reference_payment_BillGabungan_service").css(
			"display",
			"table-row"
		);

		combo_insert_qr_code("combo-reference-payment-BillGabungan-service");
		document.getElementById(
			"jumlah-dibayar-payment-BillGabungan-service"
		).value = "";
		document.getElementById(
			"kembalian-payment-BillGabungan-service"
		).innerHTML = "0";

		document.getElementById(
			"jumlah-dibayar-payment-BillGabungan-service"
		).readOnly = true;
		document.getElementById(
			"kembalian-payment-BillGabungan-service"
		).readOnly = true;
	} else if (combo_methode == "Bank Transfer") {
		$("#display_jumlah_dibayar_payment_BillGabungan_service").css(
			"display",
			"table-row"
		);
		$("#display_kembalian_payment_BillGabungan_service").css(
			"display",
			"table-row"
		);
		$("#display_reference_payment_BillGabungan_service").css(
			"display",
			"table-row"
		);
		$("#display_reference_number_payment_BillGabungan_service").css(
			"display",
			"table-row"
		);

		combo_insert_bank_tambahan("combo-reference-payment-BillGabungan-service");
		document.getElementById(
			"jumlah-dibayar-payment-BillGabungan-service"
		).value = "";
		document.getElementById(
			"kembalian-payment-BillGabungan-service"
		).innerHTML = "0";

		document.getElementById(
			"jumlah-dibayar-payment-BillGabungan-service"
		).readOnly = true;
		document.getElementById(
			"kembalian-payment-BillGabungan-service"
		).readOnly = true;
	}
}

const inputBayar3 = document.getElementById(
	"jumlah-dibayar-payment-BillGabungan-service"
);

inputBayar3.addEventListener("input", function (e) {
	let cursorPos = this.selectionStart;
	let originalLength = this.value.length;

	this.value = formatRupiah(this.value);

	let updatedLength = this.value.length;
	this.selectionEnd = cursorPos + (updatedLength - originalLength);
});

inputBayar3.addEventListener("keydown", function (e) {
	if (e.key === "Enter") {
		e.preventDefault();

		let grand_Total = document.getElementById(
			"grand-total-payment-BillGabungan-service"
		).innerHTML;
		let jumlahBayar = unformatNumber(this.value);
		let totalTagihan = unformatNumber(grand_Total);
		let kembalian = jumlahBayar - totalTagihan;

		// ✅ Cek apakah jumlah bayar kurang dari total tagihan
		if (jumlahBayar < totalTagihan) {
			Swal.fire({
				title: "Error",
				text: "Jumlah bayar tidak boleh kurang dari total tagihan",
				icon: "error",
			});
			document.getElementById(
				"jumlah-dibayar-payment-BillGabungan-service"
			).value = "";
			document.getElementById(
				"kembalian-payment-BillGabungan-service"
			).innerHTML = "Rp 0";
			return;
		}

		document.getElementById(
			"kembalian-payment-BillGabungan-service"
		).innerHTML = formatRupiah(kembalian.toString());
	}
});

function changeReferencePaymentBillGabunganService() {
	let grand_Total = document.getElementById(
		"grand-total-payment-BillGabungan-service"
	).innerHTML;
	let totalTagihan = unformatNumber(grand_Total);
	document.getElementById("jumlah-dibayar-payment-BillGabungan-service").value =
		formatNumber(totalTagihan);
	var jumlahBayar = unformatNumber(
		document.getElementById("jumlah-dibayar-payment-BillGabungan-service").value
	);
	let kembalian = jumlahBayar - totalTagihan;
	document.getElementById("kembalian-payment-BillGabungan-service").innerHTML =
		formatRupiah(kembalian.toString());
}

let savedDevice = null;
let savedChar = null;
async function getPrinterChar() {
	if (savedChar) return savedChar;

	const device = await navigator.bluetooth.requestDevice({
		acceptAllDevices: true,
	});

	const server = await device.gatt.connect();
	const services = await server.getPrimaryServices();

	for (const service of services) {
		const chars = await service.getCharacteristics();
		for (const ch of chars) {
			if (ch.properties.write || ch.properties.writeWithoutResponse) {
				savedDevice = device;
				savedChar = ch;
				return ch;
			}
		}
	}

	throw "Printer tidak ditemukan";
}

// GLOBAL

let BTPrinter = null;

document.addEventListener("DOMContentLoaded", () => {
	BTPrinter = new ThermalPrinter();
	console.log("BTPrinter siap");
});

// async function printEpppos() {
// 	try {
// 		if (!BTPrinter) throw "Bluetooth belum siap";

// 		await BTPrinter.connect();

// 		const text = buildBillText();

// 		// 🔥 FIX UTAMA: encode string → bytes
// 		// const encoder = new TextEncoder();
// 		// const data = encoder.encode(text); // Uint8Array

// 		// // await BTPrinter.print(data); // ✅ sekarang BENAR
// 		// await printChunked(BTPrinter, text);
// 		// 🔥 KIRIM KE ELECTRON
// 		// if (window.btPrinter) {
// 		// 	await window.btPrinter.print(text);
// 		// 	showNotification("Berhasil cetak", "success");
// 		// } else {
// 		// 	throw "Electron printer tidak tersedia";
// 		// }
// 		window.btPrinter.print("TEST");
// 		showNotification("Berhasil cetak", "success");
// 	} catch (err) {
// 		console.error(err);
// 		showNotification("Gagal cetak Bluetooth", "error");
// 	}
// }

async function printEpppos() {
	try {
		if (!BTPrinter) throw "Bluetooth belum siap";

		await BTPrinter.connect();

		const text = buildBillText();

		// 🔥 FIX UTAMA: encode string → bytes
		const encoder = new TextEncoder();
		const data = encoder.encode(text); // Uint8Array
		await printChunked(BTPrinter, text);
		// await BTPrinter.print(data); // ✅ sekarang BENAR

		showNotification("Berhasil cetak", "success");
	} catch (err) {
		console.error(err);
		showNotification("Gagal cetak Bluetooth", "error");
	}
}

function buildBillText() {
	let text = "";

	// ===== HEADER TEXT =====
	text += "        SHAMROCK COFFEE        \n";
	text += "Jl. STM Komplek SBC Block O No.9-12 i\n";
	text += "Suka Maju, Kec. Medan Johor\n";
	text += "Kota Medan - Sumatera Utara\n";
	text += "Telp: 082320103919\n";
	text += "--------------------------------\n";

	// ===== INFO TRANSAKSI =====
	text += "Date     : " + bill_date.innerText + "\n";
	text += "No.Order : " + bill_invoice.innerText + "\n";
	text += "Kasir    : " + bill_chasier.innerText + "\n";
	text += "Meja     : " + bill_no_meja.innerText + "\n";
	text += "--------------------------------\n";

	// ===== ITEM =====
	const scope = angular.element(document.getElementById("printArea")).scope();
	const items = scope.LoadDataPesananBill || [];
	items.forEach((item) => {
		const qty = String(item.qty).padStart(2, " ");
		const name = item.nama.substring(0, 18).padEnd(18, " ");
		const total = (item.qty * item.harga)
			.toLocaleString("id-ID")
			.padStart(8, " ");
		text += `${qty} ${name}${total}\n`;
	});

	// ===== TOTAL =====
	text += "--------------------------------\n";
	text += `Qty      : ${bill_qty.innerText}\n`;
	text += `Subtotal : ${bill_subtotal.innerText}\n`;
	text += `Disc     : ${bill_value_discount.innerText}\n`;
	text += `PPN 10%  : ${bill_ppn.innerText}\n`;
	text += `TOTAL    : ${bill_grand_total.innerText}\n`;
	text += "--------------------------------\n";

	// ===== FOOTER =====
	text += "      -- TERIMA KASIH --      \n";
	text += " Barang yang sudah dibeli\n";
	text += " tidak dapat dikembalikan\n\n\n";

	return text;
}

async function imageToEscPosBytes(imgUrl, options = {}) {
	const { maxWidth = 300, threshold = 180 } = options;

	return new Promise((resolve, reject) => {
		const img = new Image();
		img.crossOrigin = "anonymous";
		img.src = imgUrl;

		img.onload = () => {
			const scale = Math.min(1, maxWidth / img.width);
			const width = Math.floor((img.width * scale) / 8) * 8;
			const height = Math.floor(img.height * scale);

			const canvas = document.createElement("canvas");
			canvas.width = width;
			canvas.height = height;

			const ctx = canvas.getContext("2d");
			ctx.fillStyle = "#FFFFFF";
			ctx.fillRect(0, 0, width, height);
			ctx.drawImage(img, 0, 0, width, height);

			const imgData = ctx.getImageData(0, 0, width, height);
			const bytes = [];

			// GS v 0
			bytes.push(0x1d, 0x76, 0x30, 0x00);
			bytes.push(width / 8, 0x00);
			bytes.push(height & 0xff, (height >> 8) & 0xff);

			for (let y = 0; y < height; y++) {
				for (let x = 0; x < width; x += 8) {
					let byte = 0;
					for (let b = 0; b < 8; b++) {
						const i = (y * width + (x + b)) * 4;
						const avg =
							(imgData.data[i] + imgData.data[i + 1] + imgData.data[i + 2]) / 3;

						// 🔥 INVERT + THRESHOLD
						if (avg > threshold) {
							byte |= 1 << (7 - b);
						}
					}
					bytes.push(byte);
				}
			}

			resolve(new Uint8Array(bytes));
		};

		img.onerror = () => reject("Gagal load image");
	});
}

async function buildBillEscpos() {
	let bytes = [];

	// INIT
	bytes.push(0x1b, 0x40); // ESC @
	bytes.push(0x1b, 0x61, 0x01); // CENTER

	// LOGO
	const logoBytes = await imageToEscPosBytes(
		base_url("public/assets/images/millennialpos.png")
	);
	bytes.push(...logoBytes);

	// FEED
	bytes.push(0x0a, 0x0a);

	// LEFT
	bytes.push(0x1b, 0x61, 0x00);

	// TEXT
	const encoder = new TextEncoder();
	bytes.push(...encoder.encode(buildBillText()));

	// CUT
	bytes.push(0x0a, 0x0a, 0x0a);
	bytes.push(0x1d, 0x56, 0x00);

	return new Uint8Array(bytes);
}

async function printEppposAfterPayment() {
	try {
		if (!BTPrinter) throw "Bluetooth belum siap";

		await BTPrinter.connect();

		const text = buildBillTextAfterPayment();

		// 🔥 FIX UTAMA: encode string → bytes
		const encoder = new TextEncoder();
		const data = encoder.encode(text); // Uint8Array
		await printChunked(BTPrinter, text);
		// await BTPrinter.print(data); // ✅ sekarang BENAR

		showNotification("Berhasil cetak", "success");
	} catch (err) {
		console.error(err);
		showNotification("Gagal cetak Bluetooth", "error");
	}
}

function buildBillTextAfterPayment() {
	let text = "";

	// ===== HEADER =====
	text += "        SHAMROCK COFFEE        \n";
	text += "Jl. STM Komplek SBC Block O No.9-12 i\n";
	text += "Suka Maju, Kec. Medan Johor\n";
	text += "Kota Medan - Sumatera Utara\n";
	text += "Telp: 082320103919\n";
	text += "--------------------------------\n";

	// ===== INFO TRANSAKSI =====
	text += "Tanggal : " + bill_billing_date_show.innerText + "\n";
	text += "Kasir   : " + bill_billing_chasier_show.innerText + "\n";
	text += "No.Order: " + bill_billing_no_order_show.innerText + "\n";
	text += "--------------------------------\n";

	// ===== ITEM PER MEJA =====
	const scope = angular.element(document.getElementById("printArea3")).scope();

	const groupedOrders = scope.groupedOrders || [];

	groupedOrders.forEach((group) => {
		text += `MEJA : ${group.no_meja}\n`;
		text += "--------------------------------\n";

		group.items.forEach((item) => {
			const qty = `[${item.qty}]`.padEnd(5, " ");
			const name = item.nama.substring(0, 16).padEnd(16, " ");
			const total = (item.qty * item.harga - (item.potongan || 0))
				.toLocaleString("id-ID")
				.padStart(8, " ");

			text += `${qty}${name}${total}\n`;
		});

		text += "--------------------------------\n";
	});

	// ===== TOTAL & PAYMENT =====
	text += `Qty        : ${bill_billing_qty_show.innerText}\n`;
	text += `Subtotal   : ${bill_billing_subtotal_show.innerText}\n`;
	text += `Discount   : ${bill_billing_discount_show.innerText}\n`;
	text += `PPN 10%    : ${bill_billing_ppn_show.innerText}\n`;
	text += "--------------------------------\n";

	text += `GRAND TOTAL  : ${bill_billing_grand_total_show.innerText}\n`;
	text += `Metode Bayar : ${bill_billing_metode_show.innerText}\n`;
	text += `Dibayar      : ${bill_billing_jumlah_dibayar_show.innerText}\n`;
	text += `Kembalian    : ${bill_billing_kembalian_show.innerText}\n`;

	// OPTIONAL (kadang kosong)
	const serviceMetode = bill_billing_service_metode_show.innerText.trim();
	if (serviceMetode !== "") {
		text += `Service    : ${serviceMetode}\n`;
	}

	text += "--------------------------------\n";

	// ===== FOOTER =====
	text += "      -- TERIMA KASIH --      \n";
	text += " Barang yang sudah dibeli\n";
	text += " tidak dapat dikembalikan\n\n\n";

	return text;
}

async function printEppposBillGabung() {
	try {
		if (!BTPrinter) throw "Bluetooth belum siap";

		await BTPrinter.connect();

		const text = buildBillTextBillGabung();

		// 🔥 FIX UTAMA: encode string → bytes
		const encoder = new TextEncoder();
		const data = encoder.encode(text); // Uint8Array
		await printChunked(BTPrinter, text);
		// await BTPrinter.print(data); // ✅ sekarang BENAR

		showNotification("Berhasil cetak", "success");
	} catch (err) {
		console.error(err);
		showNotification("Gagal cetak Bluetooth", "error");
	}
}

function buildBillTextBillGabung() {
	let text = "";

	// ===== HEADER =====
	text += "        SHAMROCK COFFEE        \n";
	text += "Jl. STM Komplek SBC Block O No.9-12 i\n";
	text += "Suka Maju, Kec. Medan Johor\n";
	text += "Kota Medan - Sumatera Utara\n";
	text += "Telp: 082320103919\n";
	text += "--------------------------------\n";

	// ===== INFO TRANSAKSI =====
	text += `Tanggal : ${bill_date_gabungan.innerText}\n`;
	text += `Kasir   : ${bill_chasier_gabungan.innerText}\n`;
	text += `No.Order: ${bill_no_order_gabungan.innerText}\n`;
	text += "--------------------------------\n";

	// ===== ITEM PER TABLE =====
	const scope = angular.element(document.getElementById("printArea2")).scope();

	const groupedOrders = scope.groupedOrders || [];

	groupedOrders.forEach((group) => {
		text += `TABLE : ${group.no_meja}\n`;
		text += "--------------------------------\n";

		group.items.forEach((item) => {
			const qty = `[${item.qty}]`.padEnd(5, " ");
			const name = item.nama.substring(0, 16).padEnd(16, " ");
			const total = (item.qty * item.harga - (item.potongan || 0))
				.toLocaleString("id-ID")
				.padStart(8, " ");

			text += `${qty}${name}${total}\n`;
		});

		text += "--------------------------------\n";
	});

	// ===== TOTAL =====
	text += `Qty        : ${bill_qty_gabungan.innerText}\n`;
	text += `Subtotal   : ${bill_subtotal_gabungan.innerText}\n`;
	text += `Disc (${bill_discount_text_gabungan.innerText}%) : ${bill_potongan_value_gabungan.innerText}\n`;
	text += `PPN 10%    : ${bill_ppn_gabungan.innerText}\n`;
	text += "--------------------------------\n";
	text += `GRAND TOTAL: ${bill_grand_total_gabungan.innerText}\n`;
	text += "--------------------------------\n";

	// ===== FOOTER =====
	text += "     -- BILL TRANSAKSI --     \n";
	text += "      -- TERIMA KASIH --      \n\n\n";

	return text;
}

async function printChunked(printer, text, chunkSize = 180) {
	const encoder = new TextEncoder();
	const bytes = encoder.encode(text);

	for (let i = 0; i < bytes.length; i += chunkSize) {
		const chunk = bytes.slice(i, i + chunkSize);
		await printer.print(chunk);
		await new Promise((r) => setTimeout(r, 120)); // ⏱️ WAJIB
	}
}
