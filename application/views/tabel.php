<html>
	<head>
		<title>DATA MAHASISWA</title>
	</head>
	<body>
		<table border="1" style="border-collapse:collapse; width:50%;">
			<tr style="background:gray;">
				<th>NPM</th>
				<th>Nama</th>
				<th>Jenis Kelamin</th>
				<th>Alamat</th>
				<th>Action</th>
			</tr>
		<?php foreach($data as $d){ ?>
			<tr align="center">
				<td><?php echo $d['npm']; ?></td>
				<td><?php echo $d['namamhs']; ?></td>
				<td><?php echo $d['jeniskelamin']; ?></td>
				<td><?php echo $d['alamatmhs']; ?></td>
				<td>
					<a class="btn btn-warning" href="<?php echo base_url()."index.php/crud/pdf/".$d['npm']; ?>"> <i class="fa fa-file"></i>PRINT PDF</a> ||
					<a href="<?php echo base_url()."index.php/crud/do_delete/".$d['npm']; ?>">Delete</a>
				</td>
			</tr>
		<?php } ?>
		</table>
		</br>
		<a href="<?php echo base_url()."index.php/crud/add_data"; ?>">Tambah Data</a>
	</body>
</html>