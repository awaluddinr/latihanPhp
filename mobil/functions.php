<?php

// koneksi
$conn = mysqli_connect('localhost', 'root', '', 'phpdasar');


function tampil($mobil)
{
    global $conn;
    $result = mysqli_query($conn, $mobil);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    }
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function tambah($data)
{

    global $conn;

    $nama = htmlspecialchars($data['nama']);
    $harga = htmlspecialchars($data['harga']);
    $gambar = upload();

    if ($gambar === false) {
        return false;
    }

    $query = "INSERT INTO mobil VALUES
                ('','$nama','$harga','$gambar')
                ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload()
{

    $nama = $_FILES['gambar']['name'];
    $ukuran = $_FILES['gambar']['size'];
    $error  = $_FILES['gambar']['error'];
    $tmp  = $_FILES['gambar']['tmp_name'];

    // cek apakah gambar sudah dipilih

    if ($error === 4) {

        return 'nophoto.png';
    }

    // cek ukuran file
    if ($ukuran > 5000000) {
        echo "<script>
        alert('ukuran gambar terlalu besar');
            </script>";

        return false;
    }

    // cek ekstensi file gambar

    $ekstensiValid = ['jpg', 'jpeg', 'png'];
    $ekstensi = explode('.', $nama);
    $ekstensi = strtolower(end($ekstensi));

    if (!in_array($ekstensi, $ekstensiValid)) {
        echo "<script>
        alert('Yang dipilih Bukan Gambar');
            </script>";

        return false;
    }

    $namabaru = uniqid();
    $namabaru .= '.';
    $namabaru .= $ekstensi;

    // jika lolos

    move_uploaded_file($tmp, 'img/' . $namabaru);

    return $namabaru;
}

function edit($data)
{
    global $conn;

    $id = $data['id'];
    $nama = htmlspecialchars($data['nama']);
    $harga = htmlspecialchars($data['harga']);
    $gambarlama = htmlspecialchars($data['gambarlama']);

    if ($_FILES['gambar']['error'] == 4) {
        $gambar = $gambarlama;
    } else {
        $gambar = upload();
    }

    $query = "UPDATE mobil SET
            nama_mobil = '$nama',
            harga = '$harga',
            gambar = '$gambar'

            WHERE id = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapus($id)
{
    global $conn;

    $tampil = "SELECT * FROM mobil WHERE id = $id";
    $result = mysqli_query($conn, $tampil);
    $file = mysqli_fetch_assoc($result);
    $foto = $file['gambar'];
    if (file_exists('img/$foto') && ($foto != 'nophoto.png')) {
        unlink('img/$foto');
    }

    $query = "DELETE FROM mobil WHERE id = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function cari($cari)
{

    global $conn;
    $query = "SELECT * FROM mobil WHERE
              nama_mobil like '%$cari%'  
                ";
    $result = mysqli_query($conn, $query);

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function registrasi($data)
{
    global $conn;

    $username = strtolower(stripslashes($data['username']));
    $password = mysqli_real_escape_string($conn, $data['password']);
    $password2 = mysqli_real_escape_string($conn, $data['password2']);


    // cek username sudah ada atau belum

    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        echo "<script>
        alert('Username sudah terdaftar');
            </script>";

        return false;
    }


    // cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
        alert('Password Tidak Sesuai');
            </script>";
        return false;
    }

    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // // insert

    mysqli_query($conn, "INSERT INTO user VALUES('','$username','$password')");

    return mysqli_affected_rows($conn);
}
