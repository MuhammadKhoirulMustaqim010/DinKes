<?php

$sql = "SELECT * FROM penyebab_kematian_ibu_sragen ORDER BY no ASC";
$result = mysqli_query($conn, $sql);
?>

<style>
    /* Perbaikan Scroll dan Sticky Header 2 Tingkat */
    .table-custom-wrap { 
        max-height: 75vh; 
        overflow-y: auto; 
        overflow-x: auto; 
    }
    
    /* Membuat Header Tetap Di Atas Saat di-Scroll ke Bawah */
    .table-custom-wrap thead tr:nth-child(1) th { position: sticky; top: 0; z-index: 3; }
    .table-custom-wrap thead tr:nth-child(2) th { position: sticky; top: 48px; z-index: 2; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
    
    /* Membantu teks header yang panjang agar turun ke bawah */
    .header-wrap { white-space: normal !important; min-width: 100px; max-width: 150px; font-size: 0.8rem; }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold text-dark m-0">Data Penyebab Kematian Ibu</h3>
      <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle shadow-sm fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-download me-2"></i> Export Data
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0">
              <li><h6 class="dropdown-header text-uppercase">Pilih Format</h6></li>
              <li><a class="dropdown-item py-2" href="exports/export_kematian_ibu.php?type=excel"><i class="bi bi-file-earmark-excel-fill text-success me-2"></i> Export Excel</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_kematian_ibu.php?type=csv"><i class="bi bi-filetype-csv text-secondary me-2"></i> Export CSV</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_kematian_ibu.php?type=pdf" target="_blank"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i> Export PDF</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_kematian_ibu.php?type=json" target="_blank"><i class="bi bi-filetype-json text-warning me-2"></i> Export JSON</a></li>
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
                    <i class="bi bi-person-x-fill text-danger me-2"></i> Kabupaten Sragen 2025
                </h5>
            </div>

            <div class="card-body p-3 p-md-4">
                <div class="table-responsive table-custom-wrap border rounded shadow-sm mb-3">
                    <table class="table table-hover table-bordered align-middle mb-0 text-nowrap" style="font-size: 0.85rem;">
                        
                        <thead class="text-center align-middle border-dark">
                            <tr>
                                <th rowspan="2" width="3%" class="bg-dark text-white border-end py-3">No</th>
                                <th rowspan="2" class="text-start bg-dark text-white border-end px-3">Kecamatan</th>
                                <th rowspan="2" class="text-start bg-dark text-white border-end px-3" style="min-width: 180px;">Nama Puskesmas</th>
                                <th colspan="7" class="table-danger border-end border-bottom">Penyebab Kematian (Jiwa)</th>
                                <th rowspan="2" class="bg-danger text-white border-start">Jumlah<br>Kematian Ibu</th>
                            </tr>
                            <tr>
                                <th class="table-danger header-wrap">Komplikasi Abortus</th>
                                <th class="table-danger header-wrap">Hipertensi Kehamilan</th>
                                <th class="table-danger header-wrap">Perdarahan Obstetrik</th>
                                <th class="table-danger header-wrap">Infeksi Terkait Kehamilan</th>
                                <th class="table-danger header-wrap">Komplikasi Obstetrik Lain</th>
                                <th class="table-danger header-wrap">Komp. Manajemen Tdk Terantisipasi</th>
                                <th class="table-danger header-wrap border-end">Komplikasi Non Obstetrik</th>
                            </tr>
                        </thead>
                        
                        <tbody class="text-center bg-white">
                            <?php
                            // Array untuk menampung Grand Total
                            $t_abortus = 0; $t_hipertensi = 0; $t_perdarahan = 0; 
                            $t_infeksi = 0; $t_lain = 0; $t_manajemen = 0; 
                            $t_non_obs = 0; $t_jumlah = 0;

                            if ($result && mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    
                                    // Ambil nilai, jadikan 0 jika NULL
                                    $abortus    = $row['komplikasi_abortus'] ?? 0;
                                    $hipertensi = $row['hipertensi_kehamilan'] ?? 0;
                                    $perdarahan = $row['perdarahan_obstetrik'] ?? 0;
                                    $infeksi    = $row['infeksi_terkait_kehamilan'] ?? 0;
                                    $lain       = $row['komplikasi_obstetrik_lain'] ?? 0;
                                    $manajemen  = $row['komplikasi_manajemen_tidak_terantisipasi'] ?? 0;
                                    $non_obs    = $row['komplikasi_non_obstetrik'] ?? 0;
                                    $jumlah     = $row['jumlah_kematian_ibu'] ?? 0;

                                    // Akumulasi Total
                                    $t_abortus    += $abortus;
                                    $t_hipertensi += $hipertensi;
                                    $t_perdarahan += $perdarahan;
                                    $t_infeksi    += $infeksi;
                                    $t_lain       += $lain;
                                    $t_manajemen  += $manajemen;
                                    $t_non_obs    += $non_obs;
                                    $t_jumlah     += $jumlah;

                                    // Format angka (ganti 0 dengan strip)
                                    $v_abortus    = ($abortus > 0) ? number_format($abortus, 0, ',', '.') : '-';
                                    $v_hipertensi = ($hipertensi > 0) ? number_format($hipertensi, 0, ',', '.') : '-';
                                    $v_perdarahan = ($perdarahan > 0) ? number_format($perdarahan, 0, ',', '.') : '-';
                                    $v_infeksi    = ($infeksi > 0) ? number_format($infeksi, 0, ',', '.') : '-';
                                    $v_lain       = ($lain > 0) ? number_format($lain, 0, ',', '.') : '-';
                                    $v_manajemen  = ($manajemen > 0) ? number_format($manajemen, 0, ',', '.') : '-';
                                    $v_non_obs    = ($non_obs > 0) ? number_format($non_obs, 0, ',', '.') : '-';
                                    $v_jumlah     = ($jumlah > 0) ? number_format($jumlah, 0, ',', '.') : '-';

                                    echo "<tr>";
                                    echo "<td class='text-muted border-end fw-bold'>" . htmlspecialchars($row["no"]) . "</td>";
                                    echo "<td class='text-start text-secondary border-end px-3'>" . htmlspecialchars($row["kecamatan"]) . "</td>";
                                    echo "<td class='text-start fw-bold text-dark border-end px-3'>" . htmlspecialchars($row["nama_puskesmas"]) . "</td>";
                                    
                                    echo "<td>{$v_abortus}</td>";
                                    echo "<td>{$v_hipertensi}</td>";
                                    echo "<td>{$v_perdarahan}</td>";
                                    echo "<td>{$v_infeksi}</td>";
                                    echo "<td>{$v_lain}</td>";
                                    echo "<td>{$v_manajemen}</td>";
                                    echo "<td class='border-end'>{$v_non_obs}</td>";
                                    
                                    // Highlight khusus jika ada kematian ibu di fasyankes tersebut
                                    $kematian_class = ($jumlah > 0) ? "text-danger fw-bold bg-danger bg-opacity-10" : "text-muted";
                                    echo "<td class='{$kematian_class} fs-6'>{$v_jumlah}</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='11' class='text-center py-5 text-muted fst-italic'>Data kematian ibu tidak ditemukan.</td></tr>";
                            }
                            ?>
                        </tbody>
                        
                        <tfoot class="position-sticky bottom-0 z-1">
                            <tr class="table-dark text-center fw-bold align-middle border-top border-2 border-dark">
                                <td colspan="3" class="py-3 text-end px-4 bg-dark text-white border-end">TOTAL KESELURUHAN</td>
                                
                                <td class="text-warning"><?= ($t_abortus > 0) ? number_format($t_abortus, 0, ',', '.') : '-' ?></td>
                                <td class="text-warning"><?= ($t_hipertensi > 0) ? number_format($t_hipertensi, 0, ',', '.') : '-' ?></td>
                                <td class="text-warning"><?= ($t_perdarahan > 0) ? number_format($t_perdarahan, 0, ',', '.') : '-' ?></td>
                                <td class="text-warning"><?= ($t_infeksi > 0) ? number_format($t_infeksi, 0, ',', '.') : '-' ?></td>
                                <td class="text-warning"><?= ($t_lain > 0) ? number_format($t_lain, 0, ',', '.') : '-' ?></td>
                                <td class="text-warning"><?= ($t_manajemen > 0) ? number_format($t_manajemen, 0, ',', '.') : '-' ?></td>
                                <td class="text-warning border-end"><?= ($t_non_obs > 0) ? number_format($t_non_obs, 0, ',', '.') : '-' ?></td>
                                
                                <td class="bg-danger text-white fs-5"><?= number_format($t_jumlah, 0, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                        
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>