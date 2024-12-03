<?php
session_start();
$target_dir = "uploads/";
$nama_file = rand() . '-' . basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . $nama_file;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

include 'koneksi.php'; // Pastikan menggunakan koneksi PDO

if ($_GET['proses'] == 'insert') {
    // Validasi file upload
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        try {
            $stmt = $db->prepare("INSERT INTO berita (user_id, kategori_id, judul, file_upload, isi_berita) 
                                  VALUES (:user_id, :kategori_id, :judul, :file_upload, :isi_berita)");
            $stmt->execute([
                ':user_id' => $_SESSION['user_id'],
                ':kategori_id' => $_POST['kategori_id'],
                ':judul' => $_POST['judul'],
                ':file_upload' => $nama_file,
                ':isi_berita' => $_POST['isi_berita']
            ]);
            echo "<script>window.location='index.php?p=berita'</script>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Sorry, your file was not uploaded.";
    }
}

if ($_GET['proses'] == 'update') {
    if (isset($_POST['Proses'])) {
        $id = $_POST['id'];
        $judul = $_POST['judul'];
        $kategori_id = $_POST['kategori_id'];
        $isi_berita = $_POST['isi_berita'];

        try {
            if ($_FILES['fileToUpload']['name'] != "") {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $stmt = $db->prepare("UPDATE berita SET 
                        judul = :judul, 
                        kategori_id = :kategori_id, 
                        isi_berita = :isi_berita, 
                        file_upload = :file_upload 
                        WHERE id = :id");
                    $stmt->execute([
                        ':judul' => $judul,
                        ':kategori_id' => $kategori_id,
                        ':isi_berita' => $isi_berita,
                        ':file_upload' => $nama_file,
                        ':id' => $id
                    ]);
                }
            } else {
                $stmt = $db->prepare("UPDATE berita SET 
                    judul = :judul, 
                    kategori_id = :kategori_id, 
                    isi_berita = :isi_berita 
                    WHERE id = :id");
                $stmt->execute([
                    ':judul' => $judul,
                    ':kategori_id' => $kategori_id,
                    ':isi_berita' => $isi_berita,
                    ':id' => $id
                ]);
            }
            echo "<script>window.location='index.php?p=berita'</script>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

if ($_GET['proses'] == 'delete') {
    try {
        unlink($target_dir . $_GET['img']); // Hapus file
        $stmt = $db->prepare("DELETE FROM berita WHERE id = :id");
        $stmt->execute([':id' => $_GET['id']]);
        header("Location:index.php?p=berita");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
