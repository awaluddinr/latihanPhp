<?php

session_start();

if (!isset($_SESSION["login"])) {
    header('Location: login.php');
    exit;
}


require 'functions.php';

if (isset($_POST["submit"])) {
    if (empty($_POST["nama"]) || (empty($_POST["harga"]))) {
        $error  = "Lengkapi Data";
    } else {
        if (tambah($_POST) > 0) {
            $_SESSION['sukses'] = "Data berhasil ditambahkan";
            header('Location: index.php');
        } else {
            echo "<script>
        alert('data gagal ditambahkan');
        document.location.href = 'index.php';
            </script>";
        }
    }
}



?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tambah data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="css/sweetalert2.min.css"> -->
</head>

<body>
    <div class="container d-flex justify-content-center bg-light py-3 col-lg-6 col-md-10 col-sm-11" style="min-height: 100vh;">
        <div class="col-lg-12 col-md-10 col-sm-9">
            <h3 class="text-center bg-primary py-3 text-white">Tambah Data Mobil</h3>

            <?php if (isset($error)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= $error; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="border p-3 border-secondary" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Mobil :</label>
                    <input type="text" name="nama" id="nama" autocomplete="off" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga :</label>
                    <input type="text" name="harga" id="harga" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar :</label>
                    <input type="file" name="gambar" id="gambar" class="form-control">
                </div>

                <div class="mb-3 mt-5 text-lg-center">

                    <button type="submit" name="submit" class="btn btn-primary ">Tambah Data</button>
                </div>


            </form>

        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <!-- <script src="js/sweetalert.min.js"></script> -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- <script src="js/sweetalert2.min.js"></script> -->
</body>

</html>