<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Ruangan</h1>
</div>
<?php 
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
?>
<div class="container">
    <div class="row">
        <div class="col-2">
            <a href="index.php?p=ruangan&aksi=input" class="btn btn-primary mb-3"><i class="bi bi-file-plus"></i> Input Ruangan</a>
        </div>
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Kode Ruangan</th>
                <th>Nama Ruangan</th>
                <th>Gedung</th>
                <th>Lantai</th>
                <th>Jenis Ruangan</th>
                <th>Kapasitas</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
            <?php
                include 'koneksi.php';
                $stmt = $db->query("SELECT * FROM ruangan");
                $no = 1;
                while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?= htmlspecialchars($data['kode_ruangan']); ?></td>
                <td><?= htmlspecialchars($data['nama_ruangan']); ?></td>
                <td><?= htmlspecialchars($data['gedung']); ?></td>
                <td><?= htmlspecialchars($data['lantai']); ?></td>
                <td><?= htmlspecialchars($data['jenis_ruangan']); ?></td>
                <td><?= htmlspecialchars($data['kapasitas']); ?></td>
                <td><?= htmlspecialchars($data['keterangan']); ?></td>
                <td>
                    <a href="index.php?p=ruangan&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success"><i class="bi bi-pen-fill"></i> Edit</a>
                    <a href="proses_ruangan.php?proses=delete&id=<?= $data['id'] ?>" onclick="return confirm('Apa anda yakin menghapus data?')" class="btn btn-danger"><i class="bi bi-trash"></i> Hapus</a>
                </td>
            </tr>
            <?php 
                $no++;
                } 
            ?>
        </table>
    </div>
</div>
<?php
        break;

    case 'input':
?>
<div class="container">
    <form action="proses_ruangan.php?proses=insert" method="POST">
        <div class="row">
            <div class="col-6">
                <div class="row mb-3">
                    <label for="kode_ruangan" class="col-sm-2 col-form-label">Kode Ruangan</label>
                    <div class="col-sm-10">
                        <input type="text" name="kode_ruangan" id="kode_ruangan" class="form-control" required autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="nama_ruangan" class="col-sm-2 col-form-label">Nama Ruangan</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_ruangan" id="nama_ruangan" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="gedung" class="col-sm-2 col-form-label">Gedung</label>
                    <div class="col-sm-10">
                        <input type="text" name="gedung" id="gedung" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="lantai" class="col-sm-2 col-form-label">Lantai</label>
                    <div class="col-sm-10">
                        <input type="text" name="lantai" id="lantai" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="jenis_ruangan" class="col-sm-2 col-form-label">Jenis Ruangan</label>
                    <div class="col-sm-10">
                        <input type="text" name="jenis_ruangan" id="jenis_ruangan" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="kapasitas" class="col-sm-2 col-form-label">Kapasitas</label>
                    <div class="col-sm-10">
                        <input type="text" name="kapasitas" id="kapasitas" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-10">
                        <input type="text" name="keterangan" id="keterangan" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Proses</button>
            </div>
        </div>
    </form>
</div>
<?php
        break;

    case 'edit':
        include 'koneksi.php';
        $id = $_GET['id'];
        $stmt = $db->prepare("SELECT * FROM ruangan WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data_ruangan = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="container">
    <form action="proses_ruangan.php?proses=update&id=<?= $data_ruangan['id'] ?>" method="POST">
        <div class="row mb-3">
            <label for="kode_ruangan" class="col-sm-2 col-form-label">Kode Ruangan</label>
            <div class="col-sm-10">
                <input type="text" name="kode_ruangan" id="kode_ruangan" class="form-control" value="<?= htmlspecialchars($data_ruangan['kode_ruangan']); ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="nama_ruangan" class="col-sm-2 col-form-label">Nama Ruangan</label>
            <div class="col-sm-10">
                <input type="text" name="nama_ruangan" id="nama_ruangan" class="form-control" value="<?= htmlspecialchars($data_ruangan['nama_ruangan']); ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="gedung" class="col-sm-2 col-form-label">Gedung</label>
            <div class="col-sm-10">
                <input type="text" name="gedung" id="gedung" class="form-control" value="<?= htmlspecialchars($data_ruangan['gedung']); ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="lantai" class="col-sm-2 col-form-label">Lantai</label>
            <div class="col-sm-10">
                <input type="text" name="lantai" id="lantai" class="form-control" value="<?= htmlspecialchars($data_ruangan['lantai']); ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="jenis_ruangan" class="col-sm-2 col-form-label">Jenis Ruangan</label>
            <div class="col-sm-10">
                <input type="text" name="jenis_ruangan" id="jenis_ruangan" class="form-control" value="<?= htmlspecialchars($data_ruangan['jenis_ruangan']); ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="kapasitas" class="col-sm-2 col-form-label">Kapasitas</label>
            <div class="col-sm-10">
                <input type="text" name="kapasitas" id="kapasitas" class="form-control" value="<?= htmlspecialchars($data_ruangan['kapasitas']); ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
            <div class="col-sm-10">
                <input type="text" name="keterangan" id="keterangan" class="form-control" value="<?= htmlspecialchars($data_ruangan['keterangan']); ?>" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Proses</button>
    </form>
</div>
<?php
    break;
}
?>
