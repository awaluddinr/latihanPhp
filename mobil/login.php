<?php

session_start();


require 'functions.php';


if (isset($_COOKIE['nm']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['nm'];
    $key = $_COOKIE['key'];

    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    // cocokan username

    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
        $_SESSION["username"] = $row['username'];
    }
}

if (isset($_SESSION["login"])) {

    header('Location: index.php');
    exit;
}


if (isset($_POST["submit"])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = true;
    }

    $result =  mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    // cek username
    if (mysqli_num_rows($result) === 1) {

        // cek passsword
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {

            // set session

            $_SESSION["login"] = true;

            if (isset($_POST['remember'])) {
                setcookie('nm', $row['id'], time() + 3600);
                setcookie('key', hash('sha256', $row['username']), time() + 3600);
            } elseif (!isset($_POST['remember'])) {
                $_SESSION["username"] = $row['username'];
            }

            header('Location: index.php');
            exit;
        } else {
            $salahpass = true;
        }
    } else {
        $salahuser = true;
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sweetalert2.min.css">
</head>

<body>
    <div class="container d-flex justify-content-center bg-light py-3 col-lg-6 col-md-10 col-sm-11" style="min-height: 100vh;">
        <div class="col-lg-8 col-12 my-lg-auto">
            <h3 class="text-center bg-warning py-3 text-white">Halaman Login</h3>

            <?php if (isset($error)) : ?>

                <div class="alert alert-danger text-center" role="alert">
                    Harap masukan username atau password terlebih dahulu
                </div>
            <?php elseif (isset($salahuser)) : ?>
                <div class="alert alert-danger text-center" role="alert">
                    Username salah
                </div>
            <?php elseif (isset($salahpass)) : ?>
                <div class="alert alert-danger text-center" role="alert">
                    Password Salah
                </div>
            <?php endif; ?>


            <form action="" method="post" class="border p-3 border-secondary">

                <div class="mb-3">
                    <label for="username" class="form-label">Username :</label>
                    <input type="text" name="username" id="username" autocomplete="off" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="pw" class="form-label">Password :</label>
                    <input type="password" name="password" id="pw" class="form-control">
                </div>
                <div class="mb-3 d-flex">
                    <button type="submit" name="submit" class="btn btn-primary me-2">Login</button>
                    <div class="my-auto form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
                        <label class="form-check-label" for="exampleCheck1">Remember Me</label>
                    </div>
                </div>



            </form>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="js/sweetalert2.min.js"></script>
</body>

</html>