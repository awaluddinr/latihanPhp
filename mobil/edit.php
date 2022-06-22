<?php

session_start();

if (!isset($_SESSION["login"])) {
    header('Location: login.php');
    exit;
}

require 'functions.php';

$id = $_GET['id'];

$car = tampil("SELECT * FROM mobil WHERE id = $id");

if (isset($_POST["submit"])) {
    if (empty($_POST["nama"]) || (empty($_POST["harga"]))) {
        echo "<h4>Lengkapi data anda</h4>";
    }
    if (edit($_POST) > 0) {
        $_SESSION['edit'] = 'Data berhasil Diupdate';
        header('Location: index.php');
    } else {
        echo "<script>
        alert('data gagal diubah');
        document.location.href = 'index.php';
            </script>";
    }
}




?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sweetalert2.min.css">
</head>

<body>
    <div class="container d-flex justify-content-center bg-light py-3">
        <div class="col-8">
            <h3 class="text-center bg-primary py-3 text-white">Edit Data <?= $car['nama_mobil']; ?></h3>

            <form action="" method="POST" class="border p-3 border-secondary" enctype="multipart/form-data">

                <input type="hidden" name="id" value="<?= $car['id']; ?>">

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Mobil :</label>
                    <input type="text" name="nama" id="nama" autocomplete="off" class="form-control" value="<?= $car['nama_mobil']; ?>">
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga :</label>
                    <input type="text" name="harga" id="harga" class="form-control" value="<?= $car['harga']; ?>">
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar :</label> <br>
                    <img src="img/<?= $car['gambar']; ?>" alt="" width="200">
                    <input type="hidden" name="gambarlama" id="gambarlama" value="<?= $car['gambar']; ?>">
                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/png, image/gif, image/jpeg">
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Edit Data</button>


            </form>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="js/sweetalert2.min.js"></script>
</body>

</html>