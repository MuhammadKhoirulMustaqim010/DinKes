<?php
// exports/export_demografi.php
session_start();
include "../config/koneksi.php"; // Sesuaikan path koneksi

$type = isset($_GET['type']) ? $_GET['type'] : '';
$filename = "Data_Demografi_Sragen_" . date('Y-m-d_H-i-s');

// Ambil data dari database
$query = "SELECT * FROM sragen_demografi_2025 ORDER BY id ASC";
$result = mysqli_query($conn, $query);
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// LOGIK EXPORT BERDASARKAN TYPE
switch ($type) {
    case 'json':
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="' . $filename . '.json"');
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;

    case 'csv':
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
        $output = fopen('php://output', 'w');
        // Header kolom CSV
        fputcsv($output, ['No', 'Kecamatan', 'Luas Wilayah', 'Desa/Kel', 'Penduduk', 'RT', 'Rata-rata', 'Kepadatan']);
        $no = 1;
        foreach ($data as $row) {
            fputcsv($output, [
                $no++, 
                $row['kecamatan'], 
                $row['luas_wilayah_km2'], 
                $row['total_desa_kelurahan'], 
                $row['jumlah_penduduk'],
                $row['jumlah_rumah_tangga'],
                $row['rata_rata_jiwa_per_rt'],
                $row['kepadatan_penduduk_per_km2']
            ]);
        }
        fclose($output);
        exit;

    case 'excel':
        // Format Excel Sederhana menggunakan HTML Table Header
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"" . $filename . ".xls\"");
        echo "<h3>Data Demografi Kabupaten Sragen 2025</h3>";
        echo "<table border='1'>
                <tr>
                    <th>No</th>
                    <th>Kecamatan</th>
                    <th>Luas Wilayah (km2)</th>
                    <th>Desa/Kel</th>
                    <th>Jumlah Penduduk</th>
                    <th>Kepadatan</th>
                </tr>";
        $no = 1;
        foreach ($data as $row) {
            echo "<tr>
                    <td>" . $no++ . "</td>
                    <td>" . strtoupper($row['kecamatan']) . "</td>
                    <td>" . $row['luas_wilayah_km2'] . "</td>
                    <td>" . $row['total_desa_kelurahan'] . "</td>
                    <td>" . $row['jumlah_penduduk'] . "</td>
                    <td>" . $row['kepadatan_penduduk_per_km2'] . "</td>
                  </tr>";
        }
        echo "</table>";  
        exit;

    case 'pdf':
        // Untuk PDF Native paling stabil menggunakan window.print() 
        // atau library seperti Dompdf. 
        // Sementara kita arahkan ke halaman khusus cetak rapi:
        echo "<script>window.print();</script>";
        // (Saran: Gunakan library Dompdf untuk hasil profesional)
        exit;

    default:
        header("Location: ../index.php");
        break;
}