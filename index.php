<?php
	//Koneksi Database
	$server = "localhost";
	$user = "root";
	$pass = "";
	$database = "pijarcamp";

	$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

	//jika tombol simpan diklik
	if(isset($_POST['bsimpan']))
	{
		//Pengujian Apakah data akan diedit atau disimpan baru
		if($_GET['hal'] == "edit")
		{
			//Data akan di edit
			$edit = mysqli_query($koneksi, "UPDATE produk set
											 	nama_produk = '$_POST[tproduk]',
												harga = '$_POST[tharga]',
											 	jumlah = '$_POST[tjumlah]'
											 WHERE id_brng = '$_GET[id]'
										   ");
			if($edit) //jika edit sukses
			{
				echo "<script>
						alert('Edit data suksess!');
						document.location='index.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Edit data GAGAL!!');
						document.location='index.php';
				     </script>";
			}
		}
		else
		{
			//Data akan disimpan Baru
			$simpan = mysqli_query($koneksi, "INSERT INTO produk (nama_produk,harga,jumlah)
										  VALUES ('$_POST[tproduk]', 
										  		 '$_POST[tharga]', 
										  		 '$_POST[tjumlah]')
										 ");
			if($simpan) //jika simpan sukses
			{
				echo "<script>
						alert('Simpan data suksess!');
						document.location='index.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Simpan data GAGAL!!');
						document.location='index.php';
				     </script>";
			}
		}


		
	}


	//Pengujian jika tombol Edit / Hapus di klik
	if(isset($_GET['hal']))
	{
		//Pengujian jika edit Data
		if($_GET['hal'] == "edit")
		{
			//Tampilkan Data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_brng = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//Jika data ditemukan, maka data ditampung ke dalam variabel
				$vproduk = $data['nama_produk'];
				$vharga = $data['harga'];
				$vjumlah = $data['jumlah'];
			}
		}
		else if ($_GET['hal'] == "hapus")
		{
			//Persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM produk WHERE id_brng = '$_GET[id]' ");
			if($hapus){
				echo "<script>
						alert('Hapus Data Suksess!!');
						document.location='index.php';
				     </script>";
			}
		}
	}
    ?>
<!DOCTYPE html>
<html>
  <head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Tabel Produk</title>
  </head>
  <body>
  <div class="container">

	<h1 class="text-center">Rangga DB PIjarCamp</h1>

	<!-- Awal Card Form -->
	<div class="card mt-3">
	  <div class="card-header bg-primary text-white">
	    Form Input Data Produk
	  </div>
	  <div class="card-body">
	    <form method="post" action="">
	    	<div class="form-group">
	    		<label>Produk</label>
	    		<input type="text" name="tproduk" value="<?=@$vproduk?>" class="form-control" placeholder="Input Produk anda disini!" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Harga</label>
	    		<input type="text" name="tharga" value="<?=@$vharga?>" class="form-control" placeholder="Input Harga anda disini!" required>
	    	</div>
            <div class="form-group">
	    		<label>Jumlah</label>
	    		<input type="text" name="tjumlah" value="<?=@$vjumlah?>" class="form-control" placeholder="Input jumlah anda disini!" required>
	    	</div
	    	
            <button type="reset" class="btn btn-danger" name="breset"></button>
	    	<button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
	    	<button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

	    </form>
	  </div>
	</div>
	<!-- Akhir Card Form -->

	<!-- Awal Card Tabel -->
	<div class="card mt-3">
	  <div class="card-header bg-success text-white">
	    Daftar Produk
	  </div>
	  <div class="card-body">
	    
	    <table class="table table-bordered table-striped">
	    	<tr>
	    		<th>No.</th>
	    		<th>Produk</th>
	    		<th>Harga</th>
	    		<th>Jumlah</th>
                <th>Aksi</th>

	    	</tr>
            <?php
	    		$no = 1;
	    		$tampil = mysqli_query($koneksi, "SELECT * from produk order by id_brng desc");
	    		while($data = mysqli_fetch_array($tampil)) :

	    	?>
<tr>
	    		<td><?=$no++;?></td>
	    		<td><?=$data['nama_produk']?></td>
	    		<td><?=$data['harga']?></td>
	    		<td><?=$data['jumlah']?></td>

	    		<td>
	    			<a href="index.php?hal=edit&id=<?=$data['id_brng']?>" class="btn btn-warning"> Edit </a>
	    			<a href="index.php?hal=hapus&id=<?=$data['id_brng']?>" 
	    			   onclick="return confirm('Apakah yakin ingin menghapus produk ini?')" class="btn btn-danger"> Hapus </a>
	    		</td>
	    	</tr>


<?php endwhile; //penutup perulangan while ?>
	    	<!--  -->
	    </table>

	  </div>
	</div>
	<!-- Akhir Card Tabel -->

</div>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </body>
</html>
