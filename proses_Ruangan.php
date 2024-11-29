<?php
include 'koneksi.php';

if ($_GET['proses'] == 'insert') {
    if (isset($_POST['Proses'])) {
        $kode_ruangan = $_POST['kode_ruangan'];
        $nama_ruangan = $_POST['nama_ruangan'];
        $gedung = $_POST['gedung'];
        $lantai = $_POST['lantai'];
        $jenis_ruangan = $_POST['jenis_ruangan'];
        $kapasitas = $_POST['kapasitas'];
        $keterangan = $_POST['keterangan'];

        try {
            $stmt = $db->prepare("INSERT INTO ruangan (kode_ruangan, nama_ruangan, gedung, lantai, jenis_ruangan, kapasitas, keterangan) 
                                  VALUES (:kode_ruangan, :nama_ruangan, :gedung, :lantai, :jenis_ruangan, :kapasitas, :keterangan)");
            $stmt->bindParam(':kode_ruangan', $kode_ruangan);
            $stmt->bindParam(':nama_ruangan', $nama_ruangan);
            $stmt->bindParam(':gedung', $gedung);
            $stmt->bindParam(':lantai', $lantai);
            $stmt->bindParam(':jenis_ruangan', $jenis_ruangan);
            $stmt->bindParam(':kapasitas', $kapasitas);
            $stmt->bindParam(':keterangan', $keterangan);

            $stmt->execute();

            echo "<script>window.location='index.php?p=ruangan'</script>";
        } catch (PDOException $e) {
            echo "Data gagal disimpan: " . $e->getMessage();
        }
    }
}

if ($_GET['proses'] == 'update') {
    if (isset($_POST['Proses'])) {
        $id = $_GET['id'];
        $kode_ruangan = $_POST['kode_ruangan'];
        $nama_ruangan = $_POST['nama_ruangan'];
        $gedung = $_POST['gedung'];
        $lantai = $_POST['lantai'];
        $jenis_ruangan = $_POST['jenis_ruangan'];
        $kapasitas = $_POST['kapasitas'];
        $keterangan = $_POST['keterangan'];

        try {
            $stmt = $db->prepare("UPDATE ruangan SET 
                                  kode_ruangan = :kode_ruangan, 
                                  nama_ruangan = :nama_ruangan, 
                                  gedung = :gedung, 
                                  lantai = :lantai, 
                                  jenis_ruangan = :jenis_ruangan, 
                                  kapasitas = :kapasitas, 
                                  keterangan = :keterangan 
                                  WHERE id = :id");
            $stmt->bindParam(':kode_ruangan', $kode_ruangan);
            $stmt->bindParam(':nama_ruangan', $nama_ruangan);
            $stmt->bindParam(':gedung', $gedung);
            $stmt->bindParam(':lantai', $lantai);
            $stmt->bindParam(':jenis_ruangan', $jenis_ruangan);
            $stmt->bindParam(':kapasitas', $kapasitas);
            $stmt->bindParam(':keterangan', $keterangan);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            echo "<script>window.location='index.php?p=ruangan'</script>";
        } catch (PDOException $e) {
            echo "Gagal memperbarui data: " . $e->getMessage();
        }
    }
}

if ($_GET['proses'] == 'delete') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        try {
            $stmt = $db->prepare("DELETE FROM ruangan WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            header("Location:index.php?p=ruangan");
        } catch (PDOException $e) {
            echo "Gagal menghapus data: " . $e->getMessage();
        }
    }
}
?>
