<?php
// pages/demografi.php

// 1. QUERY UNTUK MENAMPILKAN DATA PER KECAMATAN
$sql = "SELECT * FROM sragen_demografi_2025 ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

// 2. QUERY MYSQL UNTUK MENGHITUNG TOTAL KESELURUHAN (SUM)
$sql_total = "SELECT 
                SUM(luas_wilayah_km2) as total_luas, 
                SUM(total_desa_kelurahan) as total_desa, 
                SUM(jumlah_penduduk) as total_penduduk, 
                SUM(jumlah_rumah_tangga) as total_rt 
              FROM sragen_demografi_2025";
$result_total = mysqli_query($conn, $sql_total);
$row_total = mysqli_fetch_assoc($result_total);

// Simpan hasil SUM ke variabel (Beri nilai default 0 jika kosong)
$total_luas     = $row_total['total_luas'] ?? 0;
$total_desa     = $row_total['total_desa'] ?? 0;
$total_penduduk = $row_total['total_penduduk'] ?? 0;
$total_rt       = $row_total['total_rt'] ?? 0;

// Menghitung Rata-rata dan Kepadatan keseluruhan secara matematis
$rata_jiwa_total = ($total_rt > 0) ? ($total_penduduk / $total_rt) : 0;
$kepadatan_total = ($total_luas > 0) ? ($total_penduduk / $total_luas) : 0;
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold text-dark m-0">Data Luas Wilayah & Kepadatan Penduduk</h3> 
    <div class="dropdown">
      <button class="btn btn-primary dropdown-toggle shadow-sm fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-download me-2"></i> Export Data
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow border-0">
        <li><h6 class="dropdown-header text-uppercase">Pilih Format</h6></li>
        <li><a class="dropdown-item py-2" href="exports/export_demografi_sragen_2025.php?type=excel"><i class="bi bi-file-earmark-excel-fill text-success me-2"></i> Export Excel</a></li>
        <li><a class="dropdown-item py-2" href="exports/export_demografi_sragen_2025.php?type=csv"><i class="bi bi-filetype-csv text-secondary me-2"></i> Export CSV</a></li>
        <li><a class="dropdown-item py-2" href="exports/export_demografi_sragen_2025.php?type=pdf"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i> Export PDF</a></li>
        <li><a class="dropdown-item py-2" href="exports/export_demografi_sragen_2025.php?type=json" target="_blank"><i class="bi bi-filetype-json text-warning me-2"></i> Export JSON</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item py-2" href="javascript:window.print()"><i class="bi bi-printer-fill text-dark me-2"></i> Cetak Halaman</a></li>
      </ul>
    </div>
</div>

<div class="row justify-content-center mb-5">
    <div class="col-md-12"> 
        <div class="card shadow-sm border-0 rounded-4">
            
            <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark m-0">
                    <i class="bi bi-table text-info me-2"></i> Kabupaten Sragen 2025
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive rounded border">
                    <table class="table table-hover table-striped align-middle mb-0" style="font-size: 0.9rem;">
                        
                        <thead class="table-light text-center align-middle border-bottom">
                            <tr>
                                <th width="5%" class="py-3">No</th>
                                <th class="text-start">Kecamatan</th>
                                <th>Luas Wilayah<br><small class="text-muted">(km²)</small></th>
                                <th>Jml Desa / Kel</th>
                                <th>Jumlah Penduduk</th>
                                <th>Jumlah RT</th>
                                <th>Rata-Rata<br><small class="text-muted">(Jiwa / Rt)</small></th>
                                <th class="table-danger">Kepadatan<br><small class="text-danger">(Jiwa / km²)</small></th>
                            </tr>
                        </thead>

                        <tbody class="text-center bg-white">
                            <?php
                            if ($result && mysqli_num_rows($result) > 0) {
                                $no = 1;
                                while($row = mysqli_fetch_assoc($result)) {
                                    $luas = $row["luas_wilayah_km2"] ? number_format($row["luas_wilayah_km2"], 2, ',', '.') : '-';
                                    $desa_kel = $row["total_desa_kelurahan"] ? number_format($row["total_desa_kelurahan"], 0, ',', '.') : '-';
                                    $penduduk = $row["jumlah_penduduk"] ? number_format($row["jumlah_penduduk"], 0, ',', '.') : '-';
                                    $rt = $row["jumlah_rumah_tangga"] ? number_format($row["jumlah_rumah_tangga"], 0, ',', '.') : '-';
                                    $rata_rata = $row["rata_rata_jiwa_per_rt"] ? number_format($row["rata_rata_jiwa_per_rt"], 1, ',', '.') : '-';
                                    $kepadatan = $row["kepadatan_penduduk_per_km2"] ? number_format($row["kepadatan_penduduk_per_km2"], 1, ',', '.') : '-';

                                    echo "<tr>";
                                    echo "<td class='text-secondary border-end-0'>" . $no++ . "</td>";
                                    echo "<td class='text-start fw-bold text-dark text-uppercase'>" . htmlspecialchars($row["kecamatan"]) . "</td>";
                                    echo "<td>{$luas}</td>";
                                    echo "<td>{$desa_kel}</td>";
                                    echo "<td class='text-primary fw-bold'>{$penduduk}</td>";
                                    echo "<td class='text-success fw-bold'>{$rt}</td>";
                                    echo "<td>{$rata_rata}</td>";
                                    echo "<td class='text-danger fw-bold bg-danger bg-opacity-10'>{$kepadatan}</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center py-4 text-muted fst-italic'>Data demografi tidak ditemukan.</td></tr>";
                            }
                            ?>
                        </tbody>

                        <tfoot class="table-secondary fw-bold text-center align-middle border-top border-2 border-dark">
                            <tr>
                                <td colspan="2" class="text-end pe-4 text-uppercase py-3">Total Kabupaten / Kota</td>
                                <td><?= number_format($total_luas, 2, ',', '.') ?></td>
                                <td><?= number_format($total_desa, 0, ',', '.') ?></td>
                                <td class="text-primary fs-6"><?= number_format($total_penduduk, 0, ',', '.') ?></td>
                                <td class="text-success fs-6"><?= number_format($total_rt, 0, ',', '.') ?></td>
                                <td><?= number_format($rata_jiwa_total, 1, ',', '.') ?></td>
                                <td class="text-danger fs-6"><?= number_format($kepadatan_total, 1, ',', '.') ?></td>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>