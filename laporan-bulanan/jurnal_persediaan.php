<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Jurnal Persediaan</h1>
    <form action="" method="post">
        <input type="month" name="bulan_laporan" required> 
        <input type="Submit" name="pilih_bulan" value="Tampilkan">
    </form>
    <br>

    <?php
        function laporan_persediaan(){
            GLOBAL $wpdb;

            if (isset($_POST['pilih_bulan'])){
                $bulan_laporan = $_POST['bulan_laporan'];

                $jurnalpersediaan = $wpdb->get_results(
                    "SELECT pm.product_id, pm.stock_quantity, ps.post_title, op.order_id, date_format(op.date_created, '%e %M %Y') AS tanggal, op.product_qty, CONCAT(cl.first_name, ' ', cl.last_name) AS full_name
                    FROM {$wpdb->prefix}wc_product_meta_lookup pm
                    INNER JOIN $wpdb->posts ps
                        ON pm.product_id = ps.ID
                    INNER JOIN {$wpdb->prefix}wc_order_product_lookup op
                        ON  pm.product_id = op.product_id
                    INNER JOIN {$wpdb->prefix}wc_customer_lookup cl
                        ON  op.customer_id = cl.customer_id
                    WHERE op.date_created LIKE '$bulan_laporan%'
                    ORDER BY pm.product_id ASC
                ");
                echo "<table class='table'>";
                echo "
                    <thead>
                        <th scope='col'>NAMA CUSTOMER</th>
                        <th scope='col'>ORDER ID</th>
                        <th scope='col'>TANGGAL</th>
                        <th scope='col'>JUMLAH ITEM</th>
                    </thead>
                ";
                foreach ($jurnalpersediaan as $jurnalpersediaan){
                    if($temp != $jurnalpersediaan->post_title) {
                        echo "
                        <tr>
                            <td><strong>$jurnalpersediaan->post_title</strong><td>
                            <td style='border-collapse:colapse;'></td>
                            <td style='border-collapse:colapse;'></td>
                            <td style='border-collapse:colapse;'></td>
                        </tr>";
                    }
                    echo "<td>$jurnalpersediaan->full_name</td>";
                    echo "<td>$jurnalpersediaan->order_id</td>";
                    echo "<td>$jurnalpersediaan->tanggal</td>";
                    echo "<td><strong>$jurnalpersediaan->product_qty</strong></td>";
                    echo "</tr>";
                    $temp = $jurnalpersediaan->post_title;
                };
                echo "</table>";

            }

            // echo "<pre>";
            // print_r ($jurnalpersediaan);
        };
    ?>
</body>