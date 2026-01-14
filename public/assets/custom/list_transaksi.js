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

var app = angular.module("ListTransaksiApp", ["datatables"]);
app.controller(
	"ListTransaksiAppController",
	function ($scope, $http, $timeout) {
		// $scope.data_transaksi = [];
		$scope.LoadDataTransaksi = function () {
			var date_start = $("#start_date").val();
			var date_end = $("#end_date").val();
			var formdata = {
				date_start: date_start,
				date_end: date_end,
			};
			$http
				.post(base_url("transaksi/invoice/get_transaksi"), formdata)
				.then(function (response) {
					$scope.data_transaksi = response.data;
				})
				.catch(function (error) {
					console.log(error);
				});
		};

		$scope.LoadDataTransaksi();

		$scope.ComboMitra = function () {
			$http
				.get(base_url("master/mitra/getdata"))
				.then(function (response) {
					$scope.ComboMitraData = response.data;
				})
				.catch(function (error) {
					console.error("Terjadi kesalahan:", error);
				});
		};

		$scope.ComboMitra();

		$scope.FilterData = function () {
			var date_start = $("#start_date").val();
			var date_end = $("#end_date").val();
			var formdata = {
				date_start: date_start,
				date_end: date_end,
			};
			$http
				.post(base_url("transaksi/invoice/get_transaksi"), formdata)
				.then(function (response) {
					$scope.data_transaksi = response.data;
				})
				.catch(function (error) {
					console.log(error);
				});
		};

		$scope.showDetail = function (dt) {
			var no_booking = dt.no_order;
			var no_meja = dt.no_meja;
			$scope.DetailPesanan(no_booking, no_meja);
			$("#my-modal-show").modal("show");
		};
		$scope.LoadDataPesananDetail = [];
		$scope.LoadDataPesananGabungSementara = [];
		$scope.LoadDataPesananDetailAll = [];

		$scope.DetailPesanan = function (no_booking, no_meja) {
			var formdata = { no_booking: no_booking, no_meja: no_meja };
			$scope.LoadDataPesananDetail = [];
			$scope.LoadDataPesananGabungSementara = [];
			$scope.LoadDataPesananDetailAll = [];

			$http
				.post(base_url("transaksi/invoice/get_detail_transaksi"), formdata)
				.then(function (response) {
					var data = response.data.transaksi;
					document.getElementById("bill_date_show").innerHTML = data.created_at;
					document.getElementById("bill_chasier_show").innerHTML =
						data.created_by;
					document.getElementById("bill_no_order_show").innerHTML =
						data.no_order;
					document.getElementById("bill_qty_show").innerHTML = formatNumber(
						data.qty
					);
					document.getElementById("bill_subtotal_show").innerHTML =
						formatRupiah(data.subtotal);
					document.getElementById("bill_ppn_show").innerHTML = formatRupiah(
						data.ppn
					);
					document.getElementById("bill_grand_total_show").innerHTML =
						formatRupiah(data.amount_total);
					document.getElementById("bill_metode_show").innerHTML = data.metode;
					document.getElementById("bill_jumlah_dibayar_show").innerHTML =
						formatRupiah(data.dibayar);
					document.getElementById("bill_kembalian_show").innerHTML =
						formatRupiah(data.kembalian);
					document.getElementById("bill_service_metode_show").innerHTML =
						data.metode_service;
					$scope.LoadDataPesananDetail = response.data.detail_transaksi;
					$scope.UpdateGabungAll();
				});
		};

		$scope.UpdateGabungAll = function () {
			$scope.LoadDataPesananDetailAll = $scope.LoadDataPesananDetail.concat(
				$scope.LoadDataPesananGabungSementara
			);

			// FIX PENTING → Pindahin ke $timeout supaya Angular selesai render DOM dulu
			$timeout(function () {
				$scope.groupPesananByOrder();
			}, 0);
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

		$scope.printCard = function (dt) {
			var no_booking = dt.no_order;
			var no_meja = dt.no_meja;
			$scope.DetailPesanan(no_booking, no_meja);

			// Tampilkan modal
			$("#my-modal-show").modal("show");

			// Setelah modal selesai muncul, baru cetak
			$("#my-modal-show").on("shown.bs.modal", function () {
				printCard("printArea2");

				// Optional: Unbind event biar tidak dobel
				$(this).off("shown.bs.modal");
			});
		};
	}
);

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

// function printCard(divId) {
// 	const divContents = document.getElementById(divId).innerHTML;
// 	// const printWindow = window.open("", "_blank", "width=800,height=600");

// 	// printWindow.document.write(`
// 	//     <html>
// 	//         <head>
// 	//             <title>Cetak Bill</title>
// 	//             <style>
// 	//                 @page {
// 	//                     size: 80mm auto;
// 	//                     margin: 0;
// 	//                 }
// 	//                 body {
// 	//                     margin: 0;
// 	//                     padding: 0;
// 	//                     font-family: Arial, sans-serif;
// 	//                     width: 80mm;
// 	//                 }
// 	//                 .print-container {
// 	//                     width: 100%;
// 	//                     padding: 5px 10px;
// 	//                     box-sizing: border-box;
// 	//                 }
// 	//                 img {
// 	//                     max-width: 100%;
// 	//                     height: auto;
// 	//                     margin-bottom: 5px;
// 	//                 }
// 	//                 table {
// 	//                     width: 100%;
// 	//                     border-collapse: collapse;
// 	//                     margin-bottom: 5px;
// 	//                     font-size: 13px; /* Naikkan font default tabel */
// 	//                 }
// 	//                 .text-center { text-align: center; }
// 	//                 .bold { font-weight: bold; }
// 	//                 .header-title {
// 	//                     font-size: 10px; /* Naikkan ukuran judul */
// 	//                     font-weight: bold;
// 	//                     margin-bottom: 2px;
// 	//                 }
// 	//                 .sub-title {
// 	//                     font-size: 10px; /* Naikkan subtitle sedikit */
// 	//                     margin-bottom: 2px;
// 	//                 }
// 	//                 .item-row {
// 	//                     font-size: 13px; /* Naikkan size item */
// 	//                 }
// 	//                 .totals {
// 	//                     font-size: 14px; /* Naikkan total biar enak dibaca */
// 	//                     font-weight: bold;
// 	//                 }
// 	//                 hr {
// 	//                     border: none;
// 	//                     border-top: 1px dashed #000;
// 	//                     margin: 4px 0;
// 	//                 }
// 	//             </style>
// 	//         </head>
// 	//         <body onload="window.print(); window.close();">
// 	//             <div class="print-container">
// 	//                 ${divContents}
// 	//             </div>
// 	//         </body>
// 	//     </html>
// 	// `);

// 	// printWindow.document.close();
// }

// function printCard(divId) {
// 	const originalContent = document.body.innerHTML;
// 	const printContent = document.getElementById(divId).innerHTML;

// 	// Simpan halaman asli
// 	const originalPage = document.body.innerHTML;

// 	// Buat halaman khusus untuk print
// 	document.body.innerHTML = `
//         <div class="print-container" style="
//             width: 80mm;
//             margin: 0 auto;
//             padding: 5px 10px;
//             font-family: Arial, sans-serif;
//             font-size: 13px;
//         ">
//             ${printContent}
//         </div>
//     `;

// 	// Tambahkan style khusus untuk print
// 	const style = document.createElement("style");
// 	style.innerHTML = `
//         @media print {
//             @page {
//                 size: 80mm auto;
//                 margin: 0;
//             }
//             body {
//                 margin: 0;
//                 padding: 0;
//                 width: 80mm;
//             }
//             .print-container {
//                 width: 100%;
//                 padding: 5px 10px;
//                 box-sizing: border-box;
//             }
//             img {
//                 max-width: 100%;
//                 height: auto;
//                 margin-bottom: 5px;
//             }
//             table {
//                 width: 100%;
//                 border-collapse: collapse;
//                 margin-bottom: 5px;
//                 font-size: 13px;
//             }
//             .text-center { text-align: center; }
//             .bold { font-weight: bold; }
//             .header-title {
//                 font-size: 10px;
//                 font-weight: bold;
//                 margin-bottom: 2px;
//             }
//             .sub-title {
//                 font-size: 10px;
//                 margin-bottom: 2px;
//             }
//             .item-row {
//                 font-size: 13px;
//             }
//             .totals {
//                 font-size: 14px;
//                 font-weight: bold;
//             }
//             hr {
//                 border: none;
//                 border-top: 1px dashed #000;
//                 margin: 4px 0;
//             }
//         }

//         @media screen {
//             body {
//                 display: flex;
//                 justify-content: center;
//                 align-items: center;
//                 min-height: 100vh;
//                 background: #f0f0f0;
//             }
//             .print-container {
//                 background: white;
//                 box-shadow: 0 0 10px rgba(0,0,0,0.1);
//             }
//         }
//     `;
// 	document.head.appendChild(style);

// 	// Tunggu sebentar agar style diterapkan
// 	setTimeout(() => {
// 		window.print();

// 		// Kembalikan halaman asli setelah 500ms
// 		setTimeout(() => {
// 			document.body.innerHTML = originalPage;
// 		}, 500);
// 	}, 100);
// }

function printCard(divId) {
	// Cek apakah perangkat mobile/tablet
	const isMobile = /Android|iPad|iPhone|iPod|Tablet/i.test(navigator.userAgent);
	const isChrome = /Chrome/.test(navigator.userAgent);

	// Untuk tablet Chrome, coba Bluetooth dulu
	if (isMobile && isChrome && navigator.bluetooth) {
		console.log("Tablet Chrome terdeteksi, coba Bluetooth...");
		return printViaBluetooth(divId);
	} else {
		// Untuk desktop/browser lain, gunakan print biasa
		console.log("Gunakan print biasa...");
		return printViaBrowser(divId);
	}
}

// Fungsi print via Bluetooth (untuk tablet)
async function printViaBluetooth(divId) {
	try {
		// Ambil konten print
		const printContent = document.getElementById(divId).innerHTML;
		const textContent = extractTextFromHTML(printContent);

		console.log("Mencari printer Bluetooth...");

		// Minta user memilih printer
		const device = await navigator.bluetooth.requestDevice({
			filters: [
				{ services: ["00001101-0000-1000-8000-00805f9b34fb"] }, // SPP service
				{ services: ["000018f0-0000-1000-8000-00805f9b34fb"] }, // Printer service
				{ namePrefix: "Blue" },
				{ namePrefix: "BT" },
				{ namePrefix: "Printer" },
				{ namePrefix: "POS" },
			],
			optionalServices: [
				"00001101-0000-1000-8000-00805f9b34fb",
				"000018f0-0000-1000-8000-00805f9b34fb",
				"0000ff00-0000-1000-8000-00805f9b34fb",
			],
		});

		console.log("Printer dipilih:", device.name);

		// Connect ke printer
		const server = await device.gatt.connect();
		console.log("Terhubung ke printer");

		// Cari service dan characteristic untuk menulis
		let characteristic = null;

		// Coba SPP service (umum untuk printer Bluetooth)
		try {
			const service = await server.getPrimaryService(
				"00001101-0000-1000-8000-00805f9b34fb"
			);
			const characteristics = await service.getCharacteristics();

			characteristic = characteristics.find(
				(c) => c.properties.write || c.properties.writeWithoutResponse
			);
		} catch (e) {
			console.log("SPP service tidak ditemukan, cari service lain...");
		}

		// Jika tidak ada, cari semua service yang tersedia
		if (!characteristic) {
			const services = await server.getPrimaryServices();
			for (const service of services) {
				const characteristics = await service.getCharacteristics();
				const writableChar = characteristics.find(
					(c) => c.properties.write || c.properties.writeWithoutResponse
				);
				if (writableChar) {
					characteristic = writableChar;
					break;
				}
			}
		}

		if (!characteristic) {
			throw new Error("Tidak bisa menemukan karakteristik untuk print");
		}

		// Siapkan data ESC/POS
		const escPosData = prepareEscPosData(textContent);

		// Kirim data ke printer
		await characteristic.writeValue(escPosData);
		console.log("Data berhasil dikirim ke printer");

		// Kirim perintah cut paper (jika printer support)
		setTimeout(async () => {
			try {
				const cutCommand = new Uint8Array([0x1d, 0x56, 0x41, 0x00]); // Partial cut
				await characteristic.writeValue(cutCommand);
				console.log("Perintah cut dikirim");
			} catch (e) {
				console.log("Printer tidak support cut atau sudah auto cut");
			}

			// Disconnect dari printer
			device.gatt.disconnect();
			console.log("Disconnected dari printer");
		}, 100);

		// Tampilkan notifikasi sukses
		showNotification(
			"✅ Bill berhasil dikirim ke printer Bluetooth!",
			"success"
		);
	} catch (error) {
		console.error("Error Bluetooth:", error);

		// Tampilkan error dan fallback ke print browser
		if (error.name === "NotFoundError") {
			showNotification(
				"❌ Tidak ada printer Bluetooth ditemukan. Pastikan printer sudah ON dan dalam mode pairing.",
				"error"
			);
		} else if (error.name === "SecurityError") {
			showNotification(
				"❌ Izin Bluetooth ditolak. Izinkan browser untuk mengakses Bluetooth.",
				"error"
			);
		} else if (error.name === "NotAllowedError") {
			showNotification("❌ Pencarian printer dibatalkan.", "info");
		} else {
			showNotification(
				`❌ ${error.message}. Menggunakan print browser...`,
				"warning"
			);
		}

		// Fallback ke print browser biasa
		setTimeout(() => printViaBrowser(divId), 1500);
	}
}

// Fungsi print via browser biasa
function printViaBrowser(divId) {
	const originalContent = document.body.innerHTML;
	const printContent = document.getElementById(divId).innerHTML;

	// Simpan halaman asli
	const originalPage = document.body.innerHTML;

	// Buat halaman khusus untuk print
	document.body.innerHTML = `
        <div class="print-container" style="
            width: 80mm;
            margin: 0 auto;
            padding: 5px 10px;
            font-family: Arial, sans-serif;
            font-size: 13px;
        ">
            ${printContent}
        </div>
    `;

	// Tambahkan style khusus untuk print
	const style = document.createElement("style");
	style.innerHTML = `
        @media print {
            @page {
                size: 80mm auto;
                margin: 0;
            }
            body {
                margin: 0;
                padding: 0;
                width: 80mm;
            }
            .print-container {
                width: 100%;
                padding: 5px 10px;
                box-sizing: border-box;
            }
            img {
                max-width: 100%;
                height: auto;
                margin-bottom: 5px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 5px;
                font-size: 13px;
            }
            .text-center { text-align: center; }
            .bold { font-weight: bold; }
            .header-title {
                font-size: 10px;
                font-weight: bold;
                margin-bottom: 2px;
            }
            .sub-title {
                font-size: 10px;
                margin-bottom: 2px;
            }
            .item-row {
                font-size: 13px;
            }
            .totals {
                font-size: 14px;
                font-weight: bold;
            }
            hr {
                border: none;
                border-top: 1px dashed #000;
                margin: 4px 0;
            }
        }
        
        @media screen {
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                background: #f0f0f0;
            }
            .print-container {
                background: white;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
        }
    `;
	document.head.appendChild(style);

	// Tunggu sebentar agar style diterapkan
	setTimeout(() => {
		window.print();

		// Kembalikan halaman asli setelah 500ms
		setTimeout(() => {
			document.body.innerHTML = originalPage;
		}, 500);
	}, 100);
}

// Helper Functions
function extractTextFromHTML(html) {
	const div = document.createElement("div");
	div.innerHTML = html;
	let text = div.textContent || div.innerText || "";

	// Format untuk struk
	text = text.replace(/\s+/g, " ").trim();
	text = text.replace(/<[^>]*>/g, ""); // Hapus tag HTML jika ada
	text = text.replace(/&nbsp;/g, " "); // Ganti &nbsp; dengan spasi

	// Tambahkan format struk
	const lines = text.split("\n");
	const formattedLines = lines.map((line) => {
		line = line.trim();
		if (line.length > 32) {
			// Potong jika terlalu panjang untuk printer 80mm
			return line.substring(0, 32);
		}
		return line;
	});

	return formattedLines.join("\n");
}

function prepareEscPosData(text) {
	// ESC/POS Commands
	const commands = [];

	// Initialize printer
	commands.push(0x1b, 0x40); // ESC @ - Initialize

	// Set alignment center untuk header
	commands.push(0x1b, 0x61, 0x01); // ESC a 1 - Center align

	// Set font size (double height dan width)
	commands.push(0x1d, 0x21, 0x11); // GS ! 0x11 - Double height and width

	// Tambahkan text (konversi ke bytes)
	const encoder = new TextEncoder("iso-8859-1"); // Encoding untuk printer
	const textBytes = encoder.encode(text);

	// Gabungkan semua commands
	const result = new Uint8Array(commands.length + textBytes.length);
	result.set(new Uint8Array(commands), 0);
	result.set(textBytes, commands.length);

	return result;
}

function showNotification(message, type = "info") {
	// Buat elemen notifikasi
	const notification = document.createElement("div");
	notification.textContent = message;
	notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        background: ${
					type === "success"
						? "#4CAF50"
						: type === "error"
						? "#F44336"
						: type === "warning"
						? "#FF9800"
						: "#2196F3"
				};
        color: white;
        border-radius: 5px;
        z-index: 9999;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        font-family: Arial, sans-serif;
        max-width: 300px;
    `;

	document.body.appendChild(notification);

	// Auto hilang setelah 3 detik
	setTimeout(() => {
		notification.style.opacity = "0";
		notification.style.transition = "opacity 0.5s";
		setTimeout(() => {
			if (notification.parentNode) {
				notification.parentNode.removeChild(notification);
			}
		}, 500);
	}, 3000);
}

// // UI Button dengan opsi Bluetooth
// function createSmartPrintButton() {
// 	const button = document.createElement("button");
// 	button.id = "smartPrintBtn";
// 	button.innerHTML = "🖨️ CETAK STRUK";
// 	button.style.cssText = `
//         position: fixed;
//         bottom: 20px;
//         right: 20px;
//         padding: 15px 30px;
//         background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
//         color: white;
//         border: none;
//         border-radius: 50px;
//         font-size: 16px;
//         font-weight: bold;
//         cursor: pointer;
//         z-index: 1000;
//         box-shadow: 0 4px 15px rgba(0,0,0,0.2);
//         transition: all 0.3s ease;
//     `;

// 	button.onmouseover = function () {
// 		this.style.transform = "translateY(-2px)";
// 		this.style.boxShadow = "0 6px 20px rgba(0,0,0,0.3)";
// 	};

// 	button.onmouseout = function () {
// 		this.style.transform = "translateY(0)";
// 		this.style.boxShadow = "0 4px 15px rgba(0,0,0,0.2)";
// 	};

// 	button.onclick = async function () {
// 		const divId = "printArea"; // Ganti dengan ID div Anda

// 		// Cek apakah support Bluetooth
// 		if (navigator.bluetooth && /Android|Chrome/i.test(navigator.userAgent)) {
// 			// Tampilkan pilihan print method
// 			const choice = confirm(
// 				"Pilih metode print:\n\n" +
// 					"OK - Print via Bluetooth (Tablet/HP)\n" +
// 					"Cancel - Print via Browser (Desktop)"
// 			);

// 			if (choice) {
// 				printViaBluetooth(divId);
// 			} else {
// 				printViaBrowser(divId);
// 			}
// 		} else {
// 			// Tidak support Bluetooth, langsung print browser
// 			printViaBrowser(divId);
// 		}
// 	};

// 	document.body.appendChild(button);
// }

// // Tambahkan button ketika halaman load
// document.addEventListener("DOMContentLoaded", function () {
// 	createSmartPrintButton();

// 	// Cek dan tampilkan info browser
// 	console.log("User Agent:", navigator.userAgent);
// 	console.log("Bluetooth support:", !!navigator.bluetooth);
// 	console.log("Platform:", navigator.platform);
// });
