<!--
-- Source Code from My Notes Code (www.mynotescode.com)
--
-- Follow Us on Social Media
-- Facebook : http://facebook.com/mynotescode/
-- Twitter  : http://twitter.com/mynotescode
-- Google+  : http://plus.google.com/118319575543333993544
--
-- Terimakasih telah mengunjungi blog kami.
-- Jangan lupa untuk Like dan Share catatan-catatan yang ada di blog kami.
-->

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Import Data CSV dengan PHP</title>

	<!-- Load File bootstrap.min.css yang ada difolder css -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- Style untuk Loading -->
	<style>
		#loading {
			background: whitesmoke;
			position: absolute;
			top: 140px;
			left: 82px;
			padding: 5px 10px;
			border: 1px solid #ccc;
		}
	</style>

	<!-- Load File jquery.min.js yang ada difolder js -->
	<script src="js/jquery.min.js"></script>

	<script>
		$(document).ready(function() {
			// Sembunyikan alert validasi kosong
			$("#kosong").hide();
		});
	</script>
</head>

<body>
	<!--
		-- START HEADER
		-- Membuat Menu Header / Navbar
		-- Hapus saja jika tidak diperlukan
		-->
	<nav class="navbar navbar-inverse" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#" style="color: white;"><b>Import Data Excel dengan PHP</b></a>
			</div>
			<p class="navbar-text navbar-right hidden-xs" style="color: white;padding-right: 10px;">
				FOLLOW US ON &nbsp;
				<a target="_blank" style="background: #3b5998; padding: 0 5px; border-radius: 4px; color: #f7f7f7; text-decoration: none;" href="https://www.facebook.com/mynotescode">Facebook</a>
				<a target="_blank" style="background: #00aced; padding: 0 5px; border-radius: 4px; color: #ffffff; text-decoration: none;" href="https://twitter.com/mynotescode">Twitter</a>
				<a target="_blank" style="background: #d34836; padding: 0 5px; border-radius: 4px; color: #ffffff; text-decoration: none;" href="https://plus.google.com/118319575543333993544">Google+</a>
			</p>
		</div>
	</nav>
	<!-- END HEADER -->

	<!-- Content -->
	<div style="padding: 0 15px;">
		<!-- Buat sebuah tombol Cancel untuk kemabli ke halaman awal / view data -->
		<a href="index.php" class="btn btn-danger pull-right">
			<span class="glyphicon glyphicon-remove"></span> Cancel
		</a>

		<h3>Form Import Data</h3>
		<hr>

		<!-- Buat sebuah tag form dan arahkan action nya ke file ini lagi -->
		<form method="post" action="" enctype="multipart/form-data">
			<a href="Format.csv" class="btn btn-default">
				<span class="glyphicon glyphicon-download"></span>
				Download Format
			</a><br><br>

			<!--
				-- Buat sebuah input type file
				-- class pull-left berfungsi agar file input berada di sebelah kiri
				-->
			<input type="file" name="file" class="pull-left">

			<button type="submit" name="preview" class="btn btn-success btn-sm">
				<span class="glyphicon glyphicon-eye-open"></span> Preview
			</button>
		</form>

		<hr>

		<!-- Buat Preview Data -->
		<?php
		// Jika user telah mengklik tombol Preview
		if (isset($_POST['preview'])) {
			$nama_file_baru = 'data.csv';

			// Cek apakah terdapat file data.xlsx pada folder tmp
			if (is_file('tmp/' . $nama_file_baru)) // Jika file tersebut ada
				unlink('tmp/' . $nama_file_baru); // Hapus file tersebut

			$nama_file = $_FILES['file']['name']; // Ambil nama file yang akan diupload
			$tmp_file = $_FILES['file']['tmp_name'];
			$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // Ambil ekstensi file yang akan diupload

			// Cek apakah file yang diupload adalah file CSV
			if ($ext == "csv") {
				// Upload file yang dipilih ke folder tmp
				move_uploaded_file($tmp_file, 'tmp/' . $nama_file_baru);

				// Load librari PHPExcel nya
				require_once 'PHPExcel/PHPExcel.php';

				$inputFileType = 'CSV';
				$inputFileName = 'tmp/data.csv';

				$reader = PHPExcel_IOFactory::createReader($inputFileType);
				$excel = $reader->load($inputFileName);

				// Buat sebuah tag form untuk proses import data ke database
				echo "<form method='post' action='import.php'>";

				echo "<button type='submit' name='import' class='btn btn-primary'><span class='glyphicon glyphicon-upload'></span> Import</button>";

				echo "</form>";
			} else { // Jika file yang diupload bukan File CSV
				// Munculkan pesan validasi
				echo "<div class='alert alert-danger'>
					Hanya File CSV (.csv) yang diperbolehkan
					</div>";
			}
		}
		?>
	</div>
</body>

</html>