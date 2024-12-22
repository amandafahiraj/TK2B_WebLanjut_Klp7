<?php 
include 'koneksi.php';

if ($_GET['proses'] == 'insert') {
    if (isset($_POST['Proses'])) {
        $nama_prodi = $_POST['nama_prodi'];
        $jenjang_studi = $_POST['jenjang_studi'];

        // Query untuk insert data
        $sql = "INSERT INTO prodi (nama_prodi, jenjang_studi) VALUES (:nama_prodi, :jenjang_studi)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nama_prodi', $nama_prodi);
        $stmt->bindParam(':jenjang_studi', $jenjang_studi);

        // Eksekusi query dan redirect jika berhasil
        if ($stmt->execute()) {
            echo "<script>window.location='index.php?p=prodi'</script>";
        } else {
            echo "Data gagal disimpan!";
        }
    }
}

if ($_GET['proses'] == 'update') {
    if (isset($_POST['Proses'])) {
        // Mengambil data dari form
        $id = $_GET['id']; // ID diambil dari URL
        $nama_prodi = $_POST['nama_prodi'];
        $jenjang_studi = $_POST['jenjang_studi'];

        // Query untuk update data berdasarkan ID
        $sql = "UPDATE prodi SET nama_prodi = :nama_prodi, jenjang_studi = :jenjang_studi WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nama_prodi', $nama_prodi);
        $stmt->bindParam(':jenjang_studi', $jenjang_studi);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Eksekusi query dan redirect jika berhasil
        if ($stmt->execute()) {
            echo "<script>window.location='index.php?p=prodi'</script>";
        } else {
            echo "Gagal memperbarui data!";
        }
    }
}

if ($_GET['proses'] == 'delete') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Query untuk menghapus data berdasarkan ID
        $sql = "DELETE FROM prodi WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Eksekusi query dan redirect jika berhasil
        if ($stmt->execute()) {
            header("Location:index.php?p=prodi");
        } else {
            echo "Gagal menghapus data!";
        }
    }
}
?>