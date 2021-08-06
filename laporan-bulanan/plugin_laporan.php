<?php
/**
 * Plugin Name: Laporan Bulanan Woocommerce
 * Description: Plugin laporan bulanan yang meliputi jurnal penjualan, jurnal persedian, dan laporan laba-rugi.
 * Version: 1.0.0
 * Author: Estu Ramadian Wiharto
 */

add_action( 'admin_menu', 'menu_laporan_bulanan' );
add_action( 'admin_menu', 'submenu_pengeluaran_bulanan');
add_action( 'admin_menu', 'submenu_jurnal_penjualan');
add_action( 'admin_menu', 'submenu_jurnal_persediaan');

function menu_laporan_bulanan() {
    add_menu_page(
        'Laporan Bulanan',
        'Laporan Bulanan',
        'manage_options',
        'laporan_bulanan',
        'fungsi_laporan_labarugi',
        '',
        25
    );
}

function submenu_pengeluaran_bulanan(){
    add_submenu_page(
        'laporan_bulanan',
        'Pengeluaran Bulanan',
        'Pengeluaran Bulanan',
        'manage_options',
        'pengeluaran_bulanan',
        'fungsi_pengeluaran_bulanan'
    );
}

function submenu_jurnal_penjualan(){
    add_submenu_page(
        'laporan_bulanan',
        'Jurnal Penjualan',
        'Jurnal Penjualan',
        'manage_options',
        'jurnal_penjualan',
        'fungsi_jurnal_penjualan'
    );
}

function submenu_jurnal_persediaan(){
    add_submenu_page(
        'laporan_bulanan',
        'Jurnal Persediaan',
        'Jurnal Persediaan',
        'manage_options',
        'jurnal_persediaan',
        'fungsi_jurnal_persediaan'
    );
}

function fungsi_laporan_labarugi(){
    include('laporan_labarugi.php');
    laporan_labarugi();    
}

function fungsi_pengeluaran_bulanan(){
    include('pengeluaran_bulanan.php');
    input_pengeluaran();    
}

function fungsi_jurnal_penjualan(){
    include('jurnal_penjualan.php');
    laporan_penjualan();    
}

function fungsi_jurnal_persediaan(){
    include('jurnal_persediaan.php');
    laporan_persediaan();    
}

?>