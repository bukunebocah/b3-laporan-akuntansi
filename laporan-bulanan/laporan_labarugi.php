<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Laporan Bulanan</h1>

    <form action="" method="post">
        <input type="month" name="bulan_laporan" required> 
        <input type="Submit" name="pilih_bulan" value="Tampilkan">
    </form>
    

    <?php
        function laporan_labarugi(){
            global $wpdb;
            $nomor = 1;
            $nomorA = 1;

            if (isset($_POST['pilih_bulan'])){
                $bulan_laporan = $_POST['bulan_laporan'];

                $penjualanbulanan = $wpdb->get_results(
                    "SELECT SUM(total_sales) as 'total_penjualan' 
                    FROM {$wpdb->prefix}wc_order_stats 
                    WHERE status = 'wc-completed' AND date_created LIKE '$bulan_laporan%'"
                );
    
                $totaldiskon = $wpdb->get_results(
                    "SELECT SUM(discount_amount) as 'total_diskon' 
                    FROM {$wpdb->prefix}wc_order_coupon_lookup
                    WHERE date_created LIKE '$bulan_laporan%'"
                );
    
                $bebanpenjualan = $wpdb->get_results(
                    "SELECT * 
                    FROM {$wpdb->prefix}wc_pengeluaran_bulanan 
                    WHERE jenis_beban = 'Beban Penjualan' AND tanggal_pengeluaran LIKE '$bulan_laporan%'"
                );
    
                $bebanadministrasi = $wpdb->get_results(
                    "SELECT * 
                    FROM {$wpdb->prefix}wc_pengeluaran_bulanan 
                    WHERE jenis_beban = 'Beban Administrasi' AND tanggal_pengeluaran LIKE '$bulan_laporan%'"
                );
                
                $bebanoperasional = $wpdb->get_results(
                    "SELECT SUM(jumlah_pengeluaran) AS total_beban_operasional 
                    FROM {$wpdb->prefix}wc_pengeluaran_bulanan 
                    WHERE tanggal_pengeluaran LIKE '$bulan_laporan%'"
                );
                
                $totalbebanpenjualan = $wpdb->get_results(
                    "SELECT SUM(jumlah_pengeluaran) as 'total_beban_penjualan' 
                    FROM {$wpdb->prefix}wc_pengeluaran_bulanan 
                    WHERE jenis_beban = 'Beban Penjualan' AND tanggal_pengeluaran LIKE '$bulan_laporan%'"
                );
                
                $totalbebanadministrasi = $wpdb->get_results(
                    "SELECT SUM(jumlah_pengeluaran) as 'total_beban_administrasi' 
                    FROM {$wpdb->prefix}wc_pengeluaran_bulanan 
                    WHERE jenis_beban = 'Beban Administrasi' AND tanggal_pengeluaran LIKE '$bulan_laporan%'");
    
                foreach ($totaldiskon as $totaldiskon){
                    $diskon = $totaldiskon->total_diskon;
                };
    
                foreach ($penjualanbulanan as $penjualanbulanan){
                    $penjualanbersih = $penjualanbulanan->total_penjualan;
                };
                $totalpenjualan = $diskon + $penjualanbersih;
    
                echo "<table class='table'>";
                    echo "<tr>";
                        echo "<td><h4>Pendapatan Penjualan</h4></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td>Penjualan</td>";
                        echo "<td></td>";
                        echo "<td style='text-align:right;'>$totalpenjualan</td>";
                    echo "</tr>";
    
                    echo "<tr>";
                        echo "<td>Potongan Harga</td>";
                        echo "<td style='text-align:right;'>$diskon</td>";
                        echo "<td></td>";
                    echo "</tr>";
    
                    echo "<tr>";
                        echo "<td><strong>Penjualan Bersih</strong></td>";
                        echo "<td></td>";
                        echo "<td  style='text-align:right;'><strong>$penjualanbersih</strong></td>";
                    echo "</tr>";
    
                    echo "<tr>";
                        echo "<td><h4>Beban Operasional</h4></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                    echo "</tr>";
    
                    echo "<tr>";
                        echo "<td><strong>A. Beban Penjualan</strong></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                    echo "</tr>";
    
                    foreach ($bebanpenjualan as $bebanpenjualan){
                        echo "
                            <tr>
                                <td>$nomor. $bebanpenjualan->nama_pengeluaran</td>
                                <td style='text-align:right;'>$bebanpenjualan->jumlah_pengeluaran</td>
                                <td></td>
                            </tr>
                        ";
                        $nomor++;   
                    };
    
                    echo "<tr>";
                        echo "<td>Jumlah Beban Penjualan</td>";
                        foreach ($totalbebanpenjualan as $totalbebanpenjualan){
                            echo "<td style='text-align:right;'>$totalbebanpenjualan->total_beban_penjualan</td>";
                        };
                        echo "<td></td>";
                        echo "<td></td>";
                    echo "</tr>";
    
                    echo "<tr>";
                        echo "<td><strong>B. Beban Administrasi</strong></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                    echo "</tr>";
    
                    foreach ($bebanadministrasi as $bebanadministrasi){
                        echo "
                            <tr>
                                <td>$nomorA. $bebanadministrasi->nama_pengeluaran</td>
                                <td style='text-align:right;'>$bebanadministrasi->jumlah_pengeluaran</td><br>
                                <td></td>
                            </tr>
                        ";
                        $nomorA++;   
                    };
    
                    echo "<tr>";
                        echo "<td><strong>Jumlah Beban Administrasi</strong></td>";
                        foreach ($totalbebanadministrasi as $totalbebanadministrasi){
                            echo "<td style='text-align:right;'><strong>$totalbebanadministrasi->total_beban_administrasi</strong></td>";
                        };
                        echo "<td></td>";
                    echo "</tr>";
                    
                    echo "<tr>";
                        echo "<td><strong>Jumlah Beban Operasional</strong></td>";
                        foreach ($bebanoperasional as $bebanoperasional){
                            $totalbeban = $bebanoperasional->total_beban_operasional;
                            echo "<td style='text-align:right;'><strong>$totalbeban</strong></td>";
                        };
                        echo "<td></td>"; 
                    echo "</tr>";
                    
                    echo "<tr>";
                    $lababersih = $penjualanbersih - $totalbeban;
                    echo "<td><strong>Laba Sebelum Pajak</strong></td>";
                    echo "<td></td>"; 
                    if ($lababersih >= 0){
                        echo "<td style='color:green; text-align:right;'><strong>$lababersih</strong></td>";
                    }
                    else {
                        echo "<td style='color:red; text-align:right;'><strong>$lababersih</strong></td>";
                    };
    
                    echo "</tr>";
                    
                echo "</table>";

            }
            
        }
    ?>
</body>