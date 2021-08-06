<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>

<body>
    <h1>Pengeluaran Bulanan</h>

        <?php
        function input_pengeluaran()
        {
            global $wpdb;
            if (isset($_POST['tambah_pengeluaran'])) {
                $nama_pengeluaran = $_POST['nama_pengeluaran'];
                $tanggal_pengeluaran = $_POST['tanggal_pengeluaran'];
                $jumlah_pengeluaran = $_POST['jumlah_pengeluaran'];
                $jenis_beban = $_POST['jenis_beban'];

                $tablename = 'wp_wc_pengeluaran_bulanan';
                $data = array(
                    'nama_pengeluaran' => $nama_pengeluaran,
                    'tanggal_pengeluaran' => $tanggal_pengeluaran,
                    'jumlah_pengeluaran' => $jumlah_pengeluaran,
                    'jenis_beban' => $jenis_beban
                );
                $wpdb->insert($tablename, $data);
            }

            if (isset($_POST['hapus_pengeluaran'])) {
                $id_pengeluaran = $_POST['id_pengeluaran'];
                $tablename = 'wp_wc_pengeluaran_bulanan';

                $wpdb->DELETE($tablename, array('id_pengeluaran' => $id_pengeluaran));
            }

            if (isset($_POST['pilih_bulan'])) {
                $bulan_laporan = $_POST['bulan_laporan'];

                $allposts = $wpdb->get_results(
                    "SELECT id_pengeluaran, nama_pengeluaran, DATE_FORMAT(tanggal_pengeluaran, '%e %M %Y') AS tanggal, jenis_beban, jumlah_pengeluaran 
                FROM {$wpdb->prefix}wc_pengeluaran_bulanan
                WHERE tanggal_pengeluaran LIKE '$bulan_laporan%' 
                ORDER BY tanggal_pengeluaran ASC"
                );

                $totalpengeluaranbulanan = $wpdb->get_results(
                    "SELECT SUM(jumlah_pengeluaran) AS total_pengeluaran 
                FROM {$wpdb->prefix}wc_pengeluaran_bulanan
                WHERE tanggal_pengeluaran LIKE '$bulan_laporan%'"
                );


                echo "<table class='table'>";
                echo "
                <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Nama</th>
                        <th scope='col'>Tanggal</th>
                        <th scope='col'>Jenis Beban</th>
                        <th scope='col'>Total</th>
                        <th scope='col'>Kelola</th>
                    </tr>
                </thead>
            ";

                $nomor = 1;
                echo "<tbody>";
                foreach ($allposts as $allposts) {

                    echo "
                        <tr>
                            <th scope='row'>$nomor</th>
                            <td>$allposts->nama_pengeluaran</td>
                            <td>$allposts->tanggal</td>
                            <td>$allposts->jenis_beban</td>
                            <td style='text-align:right;'>$allposts->jumlah_pengeluaran</td>
                            <td>
                                <form action='' method='post'>
                                    <input type='hidden' name='id_pengeluaran' value='$allposts->id_pengeluaran'>
                                    <input type='submit' class='btn btn-danger btn-sm' name='hapus_pengeluaran' value='Hapus'>
                                </form>
                            </td>
                        </tr>
                ";
                    $nomor++;
                }

                echo "<tr>
                <th></th>
                <td></td>
                <td></td>
                <td><strong>Total Pengeluaran</strong></td>";
                foreach ($totalpengeluaranbulanan as $totalpengeluaranbulanan) {
                    echo "<td style='text-align:right;'><strong>$totalpengeluaranbulanan->total_pengeluaran</strong></td>";
                };
                echo "<td></td>";
                echo "</tr>";
                echo "</tbody>";
                echo "</table>";
            }
        }
        ?>

        <br>
        <h3>Tambah Pengeluaran</h3>

        <form action="" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nama_pengeluaran">Nama Pengeluaran</label>
                    <input type="text" class="form-control" id="nama_pengeluaran" name="nama_pengeluaran" placeholder='Nama Pengeluaran' required>
                </div>
                <div class="form-group col-md-6">
                    <label for="tanggal_pengeluaran">Tanggal Pengeluaran</label>
                    <input type="date" class="form-control" id="tanggal_pengeluaran" name="tanggal_pengeluaran" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="jumlah_pengeluaran">Total Pengeluaran</label>
                    <input type="text" class="form-control" id="jumlah_pengeluaran" name="jumlah_pengeluaran" placeholder='Total Pengeluaran' required>
                </div>
                <div class="form-group col-md-6">
                    <label for="jenis_beban">Jenis Beban Pengeluaran</label>
                    <select class="custom-select mr-sm-2" id="jenis_beban" name="jenis_beban">
                        <option value="Beban Penjualan">Beban Penjualan</option>
                        <option value="Beban Administrasi">Beban Administrasi</option>
                    </select>
                </div>
            </div>
            <input type="submit" class="btn btn-primary btn-sm" name='tambah_pengeluaran' value="Submit">
        </form>

        <br><br>
        <h3>Daftar Pengeluaran Bulanan</h3><br>
        <form action="" method="post">
            <input type="month" name="bulan_laporan" required>
            <input type="Submit" name="pilih_bulan" value="Tampilkan">
        </form>
        <br>
</body>