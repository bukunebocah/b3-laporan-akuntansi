<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>

<body>
    <h1>Jurnal Penjualan</h1>

    <form action="" method="post">
        <input type="month" name="bulan_laporan" required> 
        <input type="Submit" name="pilih_bulan" value="Tampilkan">
    </form>
    <br>
    
    <?php
        function laporan_penjualan(){
            global $wpdb;         
            $customer_id = 'customer_id';
            $total_penjualan = 0;

            if (isset($_POST['pilih_bulan'])){
                $bulan_laporan = $_POST['bulan_laporan'];
                $daftarpenjualan = $wpdb->get_results(
                    "SELECT order_id, date_format(date_created, '%Y-%m') AS bulan_laporan, date_format(date_created, '%e %M %Y') AS tanggal, CONCAT(first_name, ' ', last_name) as 'full_name', net_total
                    FROM {$wpdb->prefix}wc_customer_lookup cl
                    INNER JOIN {$wpdb->prefix}wc_order_stats os
                        ON os.customer_id = cl.customer_id
                    WHERE status = 'wc-completed' AND date_created LIKE '$bulan_laporan%';
                    ");
                
                echo "<table class='table'>";
                echo "
                    <thead>
                        <tr>
                            <th scope='col'>#</th>
                            <th scope='col'>ID Transaksi</th>
                            <th scope='col'>Tanggal</th>
                            <th scope='col'>Nama Customer</th>
                            <th scope='col'>Total Belanja</th>
                            <th scope='col'>Total Penjualan</th>
                        </tr>
                    </thead>
                ";
                $nomor = 1;
                foreach ($daftarpenjualan as $daftarpenjualan){
                    $net_total = $daftarpenjualan->net_total;
                    $total_penjualan = $total_penjualan + $net_total;
                    echo "
                        <tbody>
                            <tr>
                                <th scope='col'>$nomor</th>
                                <td>$daftarpenjualan->order_id</td>
                                <td>$daftarpenjualan->tanggal</td>
                                <td>$daftarpenjualan->full_name</td>
                                <td>$daftarpenjualan->net_total</td>
                                <td><strong>$total_penjualan</strong></td>
                            </tr>
                        </tbody>
                    ";
                    $nomor++;
                };
                echo "<table>";                  
            }
        }
    ?>
</body>