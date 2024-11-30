<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Berita</h1>
</div>
<?php
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':

?>

        <div class="container">
            <div class="row">
                <div class="col-2">
                    <a href="index.php?p=berita&aksi=input" class="btn btn-primary mb-3"> Input berita </a>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>User ID</th>
                        <th>Kategori</th>
                        <th>Date Created</th>
                        <th>Aksi</th>

                    </tr>
                    <?php
                    include 'koneksi.php';
                    $ambil = mysqli_query($db, "SELECT berita.*, kategori.nama_kategori FROM berita JOIN kategori ON berita.kategori_id = kategori.id");
                    $no = 1;
                    while ($data = mysqli_fetch_array($ambil)) {
                    ?>

                        <tr>
                            <td><?php echo $no ?></td>
                            <td><?= $data['judul'] ?></td>
                            <td><?= $data['user_id'] ?></td>
                            <td><?= $data['nama_kategori'] ?></td>
                            <td><?= $data['date_created'] ?></td>
                            <td>
                                <a href="index.php?p=berita&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success">Edit</a>
                                <a href="proses_berita.php?proses=delete&id=<?= $data['id'] ?>&img=<?= $data['file_upload'] ?>" onclick="return confirm('Apa anda yakin menghapus data?')" class="btn btn-danger">Hapus</a>
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
            <form action="proses_berita.php?proses=insert" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-6">
                        <form>
                            <div class="row mb-3">
                                <label for="nama_berita" class="col-sm-2 col-form-label">Judul</label>
                                <div class="col-sm-10">
                                    <input type="text" name="judul" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="nama_berita" class="col-sm-2 col-form-label">Kategori</label>
                                <div class="col-sm-10">
                                    <select name="kategori_id" class="form-select">
                                        <option value="">--Pilih Kategori--</option>
                                        <?php
                                        include 'koneksi.php';
                                        $sql = mysqli_query($db, "SELECT * FROM kategori");
                                        while ($data_kategori = mysqli_fetch_array($sql)) {
                                            echo "<option value=" . $data_kategori['id'] . ">" . $data_kategori['nama_kategori'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="nama_berita" class="col-sm-2 col-form-label">File Upload</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="fileToUpload" id="file-upload">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="nama_berita" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <img src="#" alt="Preview Uploaded Image" id="file-preview" width="200px">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="keterangan" class="col-sm-2 col-form-label">Isi Berita</label>
                                <div class="col-sm-10">
                                    <textarea type="text" name="isi_berita" class="form-control" rows="10"></textarea>
                                </div>
                            </div>
                            <button type="submit" name="Proses" value="Proses" class="btn btn-primary">Proses</button>
                        </form>


                    </div>

                </div>
        </div>

    <?php
        break;
    case 'edit':

        include 'koneksi.php';
        // Mengambil data prodi berdasarkan ID yang dikirimkan melalui URL
        $id = $_GET['id']; // Mengambil ID dari URL
        $ambil = mysqli_query($db, "SELECT * FROM berita WHERE id = '$id'");
        $data_berita = mysqli_fetch_array($ambil);
    ?>
        <div class="container">
            <h1 class="mt-4 mb-4">Edit Data berita</h1>
            <form action="proses_berita.php?proses=update" method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <label for="nama_berita" class="col-sm-2 col-form-label">Judul</label>
                    <div class="col-sm-10">
                        <input type="text" name="judul" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="nama_berita" class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-10">
                        <select name="kategori_id" class="form-select">
                            <option value="">--Pilih Kategori--</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="nama_berita" class="col-sm-2 col-form-label">File Upload</label>
                    <div class="col-sm-10">
                        <input type="file" name="fileToUpload" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="keterangan" class="col-sm-2 col-form-label">Isi Berita</label>
                    <div class="col-sm-10">
                        <textarea name="isi_berita" class="form-control" rows="10"></textarea>
                    </div>
                </div>

                <button type="submit" name="Proses" value="Proses" class="btn btn-primary">Update</button>

            </form>
        </div>


<?php
        break;
}
?>

<script>
    const input = document.getElementById('file-upload');
    const previewPhoto = () => {
        const file = input.files;
        if (file) {
            const fileReader = new FileReader();
            const preview = document.getElementById('file-preview');
            fileReader.onload = function(event) {
                preview.setAttribute('src', event.target.result);
            }
            fileReader.readAsDataURL(file[0]);
        }
    }
    input.addEventListener("change", previewPhoto);
</script>