
<?php 

session_start();

if(isset($_SESSION["login"])){
    header('Location: index.php');
    exit;
}

require 'functions.php';

if(isset($_POST["submit"])){
    if(registrasi($_POST) > 0){
        echo "<script>
        alert('User baru berhasil ditambahkan');
        document.location.href = 'login.php';
            </script>";
    }else{
        echo "<script>
        alert('User baru gagal ditambahkan');
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
    <title>Form Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="container d-flex justify-content-center bg-light py-3">
        <div class="col-8">
            <h3 class="text-center bg-danger py-3 text-white">Registrasi</h3>

            <form action="" method="post" class="border p-3 border-secondary">

                <div class="mb-3">
                    <label for="username" class="form-label">Username :</label>
                    <input type="text" name="username" id="username" autocomplete="off" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="pw" class="form-label">Password :</label>
                    <input type="password" name="password" id="pw" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="pw2" class="form-label">Konfirmasi Password :</label>
                    <input type="password" name="password2" id="pw2" class="form-control">
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Submit</button>


            </form>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>