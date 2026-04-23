<?php
// FILE: pages/tenaga_perawat_bidan.php

// Ambil data Tenaga Keperawatan & Kebidanan
$sql = "SELECT * FROM tenaga_keperawatan_kebidanan ORDER BY id ASC";
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
    .table-custom-wrap thead tr:nth-child(2) th { position: sticky; top: 37px; z-index: 2; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold text-dark m-0">Data Tenaga Keperawatan & Kebidanan</h3>
    
      <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle shadow-sm fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-download me-2"></i> Export Data
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0">
              <li><h6 class="dropdown-header text-uppercase">Pilih Format</h6></li>
              <li><a class="dropdown-item py-2" href="exports/export_perawat_bidan.php?type=excel"><i class="bi bi-file-earmark-excel-fill text-success me-2"></i> Export Excel</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_perawat_bidan.php?type=csv"><i class="bi bi-filetype-csv text-secondary me-2"></i> Export CSV</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_perawat_bidan.php?type=pdf" target="_blank"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i> Export PDF</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_perawat_bidan.php?type=json" target="_blank"><i class="bi bi-filetype-json text-warning me-2"></i> Export JSON</a></li>
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
                    <i class="bi bi-bandaid-fill text-danger me-2"></i> Kabupaten Sragen 2025
                </h5>
            </div>

            <div class="card-body p-3 p-md-4">
                <div class="table-responsive table-custom-wrap border rounded shadow-sm mb-3">
                    <table class="table table-hover table-bordered align-middle mb-0 text-nowrap" style="font-size: 0.9rem;">
                        
                        <thead class="text-center align-middle border-dark">
                            <tr>
                                <th rowspan="2" width="4%" class="bg-dark text-white border-end py-3">No</th>
                                <th rowspan="2" class="bg-dark text-white border-end px-3">Kategori</th>
                                <th rowspan="2" class="text-start bg-dark text-white border-end px-4" style="min-width: 250px;">Fasilitas Kesehatan</th>
                                <th colspan="3" class="table-primary border-end border-bottom">Tenaga Keperawatan</th>
                                <th rowspan="2" class="table-success border-bottom">Tenaga Kebidanan<br><small>(Total Jiwa)</small></th>
                            </tr>
                            <tr>
                                <th class="table-primary"><small>Laki-laki</small></th>
                                <th class="table-primary"><small>Perempuan</small></th>
                                <th class="table-primary border-end fw-bold"><small>Total (L+P)</small></th>
                            </tr>
                        </thead>
                        
                        <tbody class="text-center bg-white">
                            <?php
                            // Variabel untuk menampung Grand Total
                            $t_kep_l   = 0;
                            $t_kep_p   = 0;
                            $t_kep_tot = 0;
                            $t_bidan   = 0;

                            if ($result && mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    
                                    // Ambil nilai dan set default 0 jika NULL
                                    $kep_l   = $row['tenaga_keperawatan_l'] ?? 0;
                                    $kep_p   = $row['tenaga_keperawatan_p'] ?? 0;
                                    $kep_tot = $row['tenaga_keperawatan_total'] ?? 0;
                                    $bidan   = $row['tenaga_kebidanan'] ?? 0;

                                    // Akumulasi Total Kabupaten
                                    $t_kep_l   += $kep_l;
                                    $t_kep_p   += $kep_p;
                                    $t_kep_tot += $kep_tot;
                                    $t_bidan   += $bidan;

                                    // Styling Badge untuk Kategori (Puskesmas vs Rumah Sakit)
                                    $kategori = strtoupper(trim($row["kategori"]));
                                    if ($kategori == 'PUSKESMAS') {
                                        $badge_kategori = "<span class='badge bg-info text-dark bg-opacity-25 border border-info'>{$row['kategori']}</span>";
                                    } else {
                                        $badge_kategori = "<span class='badge bg-warning text-dark bg-opacity-25 border border-warning'>{$row['kategori']}</span>";
                                    }

                                    // Format tampilan angka (ganti 0 dengan '-')
                                    $v_kep_l   = ($kep_l > 0) ? number_format($kep_l, 0, ',', '.') : '-';
                                    $v_kep_p   = ($kep_p > 0) ? number_format($kep_p, 0, ',', '.') : '-';
                                    $v_kep_tot = ($kep_tot > 0) ? number_format($kep_tot, 0, ',', '.') : '-';
                                    $v_bidan   = ($bidan > 0) ? number_format($bidan, 0, ',', '.') : '-';

                                    echo "<tr>";
                                    echo "<td class='text-muted border-end fw-bold'>" . htmlspecialchars($row["no_urut"]) . "</td>";
                                    
                                    echo "<td class='border-end'>{$badge_kategori}</td>";
                                    // Hilangkan underscore jika ada
                                    $nama_faskes = str_replace('_', ' ', $row["fasyankes"]);
                                    echo "<td class='text-start fw-bold text-dark border-end text-wrap px-4'>" . htmlspecialchars($nama_faskes) . "</td>";
                                    
                                    
                                    echo "<td class='px-3'>{$v_kep_l}</td>";
                                    echo "<td class='px-3'>{$v_kep_p}</td>";
                                    echo "<td class='fw-bold border-end bg-light px-3'>{$v_kep_tot}</td>";
                                    
                                    echo "<td class='fw-bold text-success bg-success bg-opacity-10 px-3'>{$v_bidan}</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center py-5 text-muted fst-italic'>Data tenaga perawat & bidan tidak ditemukan.</td></tr>";
                            }
                            ?>
                        </tbody>
                        
                        <tfoot class="position-sticky bottom-0 z-1">
                            <tr class="table-dark text-center fw-bold align-middle border-top border-2 border-dark">
                                <td colspan="3" class="py-3 text-end px-4 bg-dark text-white border-end">TOTAL KESELURUHAN</td>
                                
                                <td class="text-warning"><?= ($t_kep_l > 0) ? number_format($t_kep_l, 0, ',', '.') : '-' ?></td>
                                <td class="text-warning"><?= ($t_kep_p > 0) ? number_format($t_kep_p, 0, ',', '.') : '-' ?></td>
                                <td class="bg-primary text-white border-end fs-6"><?= ($t_kep_tot > 0) ? number_format($t_kep_tot, 0, ',', '.') : '-' ?></td>
                                
                                <td class="bg-success text-white fs-6"><?= ($t_bidan > 0) ? number_format($t_bidan, 0, ',', '.') : '-' ?></td>
                            </tr>
                        </tfoot>
                        
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>