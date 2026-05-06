<?php

$nama_toko = "Toko Mas Hambali";

function hitungTotal($hargaBarang) {
    global $nama_toko;
    static $jumlah_transaksi = 0;

    $jumlah_transaksi++;

    echo "Selamat Datang di $nama_toko<br>";
    echo "Harga barang: Rp" . $hargaBarang . "<br>";
    echo "Jumlah transaksi: $jumlah_transaksi<br><br>";
}

hitungTotal(10000);
hitungTotal(100000);
hitungTotal(1000000);

?>