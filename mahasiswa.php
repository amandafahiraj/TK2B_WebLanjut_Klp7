<?php
include 'koneksi.php';

if ($_GET['proses'] == 'insert') {
    if (isset($_POST['Proses'])) {
        try {
            $tgl_lahir = $_POST['tahun'] . '-' . $_POST['bulan'] . '-' . $_POST['tgl_lahir'];
            $hobi = implode(",", $_POST['hobi']);

            $sql = "INSERT INTO mahasiswa (nim, nama_mhs, tgl_lahir, jenis_kelamin, email, prodi_id, nohp, hobi, alamat)
                    VALUES (:nim, :nama_mhs, :tgl_lahir, :jenis_kelamin, :email, :prodi_id, :nohp, :hobi, :alamat)";
            
            $stmt = $dbh->prepare($sql);
            $stmt->execute([
                ':nim' => $_POST['nim'],
                ':nama_mhs' => $_POST['nama_mhs'],
                ':tgl_lahir' => $tgl_lahir,
                ':jenis_kelamin' => $_POST['jenis_kelamin'],
                ':email' => $_POST['email'],
                ':prodi_id' => $_POST['prodi_id'],
                ':nohp' => $_POST['nohp'],
                ':hobi' => $hobi,
                ':alamat' => $_POST['alamat']
            ]);

            echo "<script>window.location='index.php?p=mhs'</script>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

if ($_GET['proses'] == 'update') {
    if (isset($_POST['Proses'])) {
        try {
            $tgl_lahir = $_POST['tahun'] . '-' . $_POST['bulan'] . '-' . $_POST['tgl_lahir'];
            $hobi = implode(",", $_POST['hobi']);

            $sql = "UPDATE mahasiswa SET 
                    nama_mhs = :nama_mhs,
                    tgl_lahir = :tgl_lahir,
                    jenis_kelamin = :jenis_kelamin,
                    email = :email,
                    prodi_id = :prodi_id,
                    nohp = :nohp,
                    hobi = :hobi,
                    alamat = :alamat 
                    WHERE nim = :nim";
            
            $stmt = $dbh->prepare($sql);
            $stmt->execute([
                ':nim' => $_POST['nim'],
                ':nama_mhs' => $_POST['nama_mhs'],
                ':tgl_lahir' => $tgl_lahir,
                ':jenis_kelamin' => $_POST['jenis_kelamin'],
                ':email' => $_POST['email'],
                ':prodi_id' => $_POST['prodi_id'],
                ':nohp' => $_POST['nohp'],
                ':hobi' => $hobi,
                ':alamat' => $_POST['alamat']
            ]);

            echo "<script>window.location='index.php?p=mhs'</script>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

if ($_GET['proses'] == 'delete') {
    try {
        $sql = "DELETE FROM mahasiswa WHERE nim = :nim";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([':nim' => $_GET['nim']]);

        header("Location: index.php?p=mhs");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
