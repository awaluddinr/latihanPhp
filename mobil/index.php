<?php


session_start();

if (!isset($_SESSION["login"])) {
    header('Location: login.php');
    exit;
}
require 'functions.php';



$cars = tampil("SELECT * FROM mobil");

if (isset($_POST["cari"])) {
    $cars = cari($_POST["search"]);
}

if (!$cars) {
    $error = true;
}

if (isset($_COOKIE['nm'])) {
    $id = $_COOKIE['nm'];
    $query = "SELECT * FROM user WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
} else {
    $_SESSION['username'];
}


?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css"> -->
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="css/sweetalert2.min.css">

    <title>Daftar Kendaraan</title>
</head>

<!-- style -->
<style>
    .image {
        overflow: hidden;
        position: relative;
    }

    .overlaya {
        position: absolute;
        right: 0;
        left: 0;
        top: 0;
        bottom: 0;
    }

    .image:hover .overlaya {
        background-color: rgba(0, 0, 0, 0.5) !important;
        transition: .5s;
    }

    .image:hover img {
        transform: scale(1.1);
        transition: .5s;
    }

    li {
        text-decoration: none;
        list-style: none;
    }

    .fa-user-plus {
        display: none;
    }

    .tambah-data {
        width: 150px;
        height: 40px;
    }

    .src {
        border-top-left-radius: 2px;
        border-bottom-left-radius: 2px;
    }

    @media only screen and (max-width: 750px) {
        .overlaya {
            background-color: rgba(0, 0, 0, 0.4);
            ;
        }
    }



    @media only screen and (max-width: 576px) {
        .overlaya {
            background-color: rgba(0, 0, 0, 0.4);
            ;
        }

        .tambah-data p {
            display: none;
        }

        .tambah-data .fa-plus {
            display: none;
        }

        .fa-user-plus {
            display: block;
        }

        .tambah-data {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .pCari {
            display: none;
        }

        /* .src {
            width: 80%;
        } */

    }
</style>

<body>



    <div class="container bg-light shadow-lg py-4">
        <div class="dropdown d-flex justify-content-end">
            <?php if (!isset($_COOKIE['nm'])) : ?>
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $_SESSION['username']; ?>
                </a>
            <?php elseif (isset($_COOKIE['nm'])) : ?>
                <?php if ($row['id'] = $_COOKIE['nm']) ?>
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $row['username']; ?>
                </a>
            <?php endif; ?>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item" href="#">Profil</a></li>
                <li><a class="dropdown-item" href="logout.php" onclick="return confirm('Yakin Ingin Keluar ?')">Logout</a></li>
            </ul>
        </div>
        <header>
            <h1 class="text-center mt-4">Daftar Kendaraan</h1>
        </header>
        <div class="row  mt-4 mb-3">
            <div class="mb-1 d-flex justify-content-between">
                <div class="mb-0 mt-1 col-4">
                    <div class="tambah">
                        <a href="tambah.php" class="btn btn-primary tambah-data d-flex justify-content-center"><i class="fa fa-plus me-2 my-auto"></i>
                            <p class="m-0 p-0 my-auto">Tambah Data</p> <i class="fa fa-user-plus my-auto"></i>
                        </a>
                    </div>
                </div>
                <div class="mb-0 my-auto col-8">
                    <form action="" method="POST" class="d-block">
                        <div class="cari d-flex justify-content-end">
                            <input type="text" name="search" class="form-control me-2 src " aria-describedby="button-addon2">
                            <button class="btn btn-outline-primary d-flex" name="cari" id="button-addon2">
                                <p class="m-0 p-0 me-2 pCari">Cari</p> <i class="fa fa-search my-auto"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p class="text-center mb-0" style="font-size: 19px;"><?= $_POST['search']; ?> Tidak Ditemukan !!!!</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="col-lg-12 d-flex justify-content-center flex-wrap">
                <?php foreach ($cars as $car) : ?>
                    <div class="card col-xl-2 col-lg-4 col-md-5 col-sm-10 col-xs-8 m-2 p-0 position-relative">
                        <div class="dropdown dropstart">
                            <a class="btn position-absolute text-white shadow-none p-0" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" style="right:13px; z-index: 999; top: 8px;">
                                <i class="fa fa-ellipsis-v" style="font-size:18px ;"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="edit.php?id=<?= $car['id']; ?>">Edit <i class="fa fa-pencil ms-2 text-warning"></i></a></li>
                                <li><a class="dropdown-item" href="hapus.php?id=<?= $car['id']; ?>" onclick="return confirm('Yakin Ingin Menghapus Data ?')">Delete <i class="fa fa-trash ms-2 text-danger"></i></a></li>
                            </ul>
                        </div>
                        <?php $ext = explode('.', $car['gambar']);
                        $ext = end($ext);
                        ?>
                        <a href="" class="image" style="text-decoration: none;">
                            <img src="img/<?= $car['gambar']; ?>" class="card-img-top" alt="..." height="200" width="180">
                            <div class="overlaya"></div>
                        </a>
                        <?php if ($ext == 'jpg') : ?>
                            <div class="card-body bg-secondary">
                                <h5 class="card-title text-white"><?= $car['nama_mobil']; ?></h5>
                                <p class="card-text text-white"><?= $car['harga']; ?></p>
                            </div>
                        <?php elseif ($ext == 'png') : ?>
                            <div class="card-body bg-danger">
                                <h5 class="card-title text-white"><?= $car['nama_mobil']; ?></h5>
                                <p class="card-text text-white"><?= $car['harga']; ?></p>
                            </div>
                        <?php else : ?>
                            <div class="card-body bg-primary">
                                <h5 class="card-title text-white"><?= $car['nama_mobil']; ?></h5>
                                <p class="card-text text-white"><?= $car['harga']; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>


            <!-- <div class="rumah-jpg d-flex">
                <p>JPG</p>
                <?php foreach ($cars as $row) : ?>
                    <?php
                    $ext = explode('.', $row['gambar']);
                    $ext = end($ext);
                    ?>
                    <div class="dropdown dropstart">
                        <a class="btn position-absolute text-white shadow-none p-0" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" style="right:13px; z-index: 999; top: 8px;">
                            <i class="fa fa-ellipsis-v" style="font-size:18px ;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="edit.php?id=<?= $car['id']; ?>">Edit <i class="fa fa-pencil ms-2 text-warning"></i></a></li>
                            <li><a class="dropdown-item" href="hapus.php?id=<?= $car['id']; ?>" onclick="return confirm('Yakin Ingin Menghapus Data ?')">Delete <i class="fa fa-trash ms-2 text-danger"></i></a></li>
                        </ul>
                    </div>
                    <?php if ($ext == 'jpg') : ?>
                        <div class="jpg col-3 bg-primary">
                            <a href="" class="image" style="text-decoration: none;">
                                <img src="img/<?= $row["gambar"]; ?> ?>" class="card-img-top" alt="..." height="200" width="180">
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="rumah-png d-flex">
                <p>PNG</p>
                <?php foreach ($cars as $png) : ?>
                    <?php
                    $ext = explode('.', $png['gambar']);
                    $ext = end($ext);
                    ?>
                    <div class="dropdown dropstart">
                        <a class="btn position-absolute text-white shadow-none p-0" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" style="right:13px; z-index: 999; top: 8px;">
                            <i class="fa fa-ellipsis-v" style="font-size:18px ;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="edit.php?id=<?= $car['id']; ?>">Edit <i class="fa fa-pencil ms-2 text-warning"></i></a></li>
                            <li><a class="dropdown-item" href="hapus.php?id=<?= $car['id']; ?>" onclick="return confirm('Yakin Ingin Menghapus Data ?')">Delete <i class="fa fa-trash ms-2 text-danger"></i></a></li>
                        </ul>
                    </div>
                    <?php if ($ext == 'png') : ?>
                        <div class="jpg col-3 bg-warning">
                            <a href="" class="image d-flex" style="text-decoration: none;">
                                <img src="img/<?= $png["gambar"]; ?> ?>" class="card-img-top" alt="..." height="200" width="180">
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="rumah-jpeg d-flex">
                <p>JPEG</p>
                <?php foreach ($cars as $jpeg) : ?>
                    <?php
                    $ext = explode('.', $jpeg['gambar']);
                    $ext = end($ext);
                    ?>
                    <div class="dropdown dropstart">
                        <a class="btn position-absolute text-white shadow-none p-0" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" style="right:13px; z-index: 999; top: 8px;">
                            <i class="fa fa-ellipsis-v" style="font-size:18px ;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="edit.php?id=<?= $car['id']; ?>">Edit <i class="fa fa-pencil ms-2 text-warning"></i></a></li>
                            <li><a class="dropdown-item" href="hapus.php?id=<?= $car['id']; ?>" onclick="return confirm('Yakin Ingin Menghapus Data ?')">Delete <i class="fa fa-trash ms-2 text-danger"></i></a></li>
                        </ul>
                    </div>
                    <?php if ($ext == 'jpeg') : ?>
                        <div class="jpg col-3 bg-danger d-flex">
                            <a href="" class="image d-flex" style="text-decoration: none;">
                                <img src="img/<?= $jpeg["gambar"]; ?> ?>" class="card-img-top" alt="..." height="200" width="180">
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div> -->


            <div class="col-12">
                <h4 class="mt-5 ">Pengelompokkan gambar berdasarkan extensi</h4>
                <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-content-above-home-tab" data-toggle="pill" href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home" aria-selected="true">Semua File</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-content-above-profile-tab" data-toggle="pill" href="#custom-content-above-profile" role="tab" aria-controls="custom-content-above-profile" aria-selected="false">JPG</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-content-above-messages-tab" data-toggle="pill" href="#custom-content-above-messages" role="tab" aria-controls="custom-content-above-messages" aria-selected="false">PNG</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-content-above-jpeg-tab" data-toggle="pill" href="#custom-content-above-jpeg" role="tab" aria-controls="custom-content-above-jpeg" aria-selected="false">JPEG</a>
                    </li>
                </ul>
                <div class="tab-custom-content">
                    <p class="lead mb-0">Custom Content goes here</p>
                </div>
                <div class="tab-content" id="custom-content-above-tabContent">
                    <div class="tab-pane fade show active" id="custom-content-above-home" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                        <div class="mb-0 d-flex flex-wrap ">
                            <?php foreach ($cars as $car) : ?>
                                <div class="jpg col-xl-3 col-lg-4 col-md-6 col-sm-10">
                                    <a data-fancybox="gallery" href="img/<?= $car['gambar']; ?>" class="image" style="text-decoration: none;">
                                        <img src="img/<?= $car["gambar"]; ?> ?>" class="card-img-top" alt="..." height="200" width="180">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-content-above-profile" role="tabpanel" aria-labelledby="custom-content-above-profile-tab">
                        <div class="mb-0 d-flex flex-wrap">
                            <?php foreach ($cars as $jpg) : ?>
                                <?php
                                $ext = explode('.', $jpg['gambar']);
                                $ext = end($ext);
                                ?>
                                <?php if ($ext == 'jpg') : ?>
                                    <div class="jpg col-xl-3 col-lg-4 col-md-6 col-sm-10">
                                        <a data-fancybox="galleryjpg" href="img/<?= $jpg["gambar"]; ?>" class="image" style="text-decoration: none;">
                                            <img src="img/<?= $jpg["gambar"]; ?> ?>" class="card-img-top" alt="..." height="200" width="180">
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-content-above-messages" role="tabpanel" aria-labelledby="custom-content-above-messages-tab">
                        <div class="mb-0 d-flex flex-wrap">
                            <?php foreach ($cars as $png) : ?>
                                <?php
                                $ext = explode('.', $png['gambar']);
                                $ext = end($ext);
                                ?>
                                <?php if ($ext == 'png') : ?>
                                    <div class="jpg col-xl-3 col-lg-4 col-md-6 col-sm-10">
                                        <a data-fancybox="gallerypng" href="img/<?= $png["gambar"]; ?>" class="image" style="text-decoration: none;">
                                            <img src="img/<?= $png["gambar"]; ?> ?>" class="card-img-top" alt="..." height="200" width="180">
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-content-above-jpeg" role="tabpanel" aria-labelledby="custom-content-above-jpeg-tab">
                        <div class="mb-0 d-flex flex-wrap">
                            <?php foreach ($cars as $jpeg) : ?>
                                <?php
                                $ext = explode('.', $jpeg['gambar']);
                                $ext = end($ext);
                                ?>
                                <?php if ($ext == 'jpeg') : ?>
                                    <div class="jpg col-xl-3 col-lg-4 col-md-6 col-sm-10">
                                        <a data-fancybox="galleryjpeg" href="img/<?= $jpeg["gambar"]; ?>" class="image" style="text-decoration: none;">
                                            <img src="img/<?= $jpeg["gambar"]; ?> ?>" class="card-img-top" alt="..." height="200" width="180">
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="dist/js/demo.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="js/sweetalert2.min.js"></script>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->


    <?php if (isset($_SESSION['sukses'])) : ?>
        <script>
            Swal.fire({
                title: "<?php echo $_SESSION['sukses']; ?>",
                icon: "success",
                butt0n: "OK",
            });
        </script>
        <?php unset($_SESSION['sukses']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['edit'])) : ?>
        <script>
            Swal.fire({
                title: "<?php echo $_SESSION['edit']; ?>",
                icon: "success",
                butt0n: "OK",
            });
        </script>
        <?php unset($_SESSION['edit']); ?>
    <?php endif; ?>


</body>

</html>