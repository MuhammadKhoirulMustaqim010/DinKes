<?php
// FILE: pages/tenaga_farmasi_psikologis.php

// Ambil data Tenaga Kefarmasian, Psikologis, & Tradisional
$sql = "SELECT * FROM tenaga_psikologis_tradisional ORDER BY id ASC";
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
    <h3 class="fw-bold text-dark m-0">Data Tenaga Kefarmasian, Psikologi Klinis & Tradisional</h3>
    
      <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle shadow-sm fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-download me-2"></i> Export Data
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0">
              <li><h6 class="dropdown-header text-uppercase">Pilih Format</h6></li>
              <li><a class="dropdown-item py-2" href="exports/export_farmasi_psikologis.php?type=excel"><i class="bi bi-file-earmark-excel-fill text-success me-2"></i> Export Excel</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_farmasi_psikologis.php?type=csv"><i class="bi bi-filetype-csv text-secondary me-2"></i> Export CSV</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_farmasi_psikologis.php?type=pdf" target="_blank"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i> Export PDF</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_farmasi_psikologis.php?type=json" target="_blank"><i class="bi bi-filetype-json text-warning me-2"></i> Export JSON</a></li>
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
                    <i class="bi bi-capsule text-success me-2"></i> Kabupaten Sragen 2025
                </h5>
            </div>

            <div class="card-body p-3 p-md-4">
                <div class="table-responsive table-custom-wrap border rounded shadow-sm mb-3">
                    <table class="table table-hover table-bordered align-middle mb-0 text-nowrap" style="font-size: 0.85rem;">
                        
                        <thead class="text-center align-middle border-dark">
                            <tr>
                                <th rowspan="2" width="4%" class="bg-dark text-white border-end py-3">No</th>
                                <th rowspan="2" class="text-start bg-dark text-white border-end px-4" style="min-width: 250px;">Fasilitas Kesehatan</th>
                                <th colspan="3" class="table-success border-end border-bottom">Tenaga Kefarmasian</th>
                                <th colspan="3" class="table-info border-end border-bottom">Tenaga Psikologi Klinis</th>
                                <th colspan="3" class="table-warning border-bottom">Tenaga Kes. Tradisional</th>
                            </tr>
                            <tr>
                                <th class="table-success"><small>Laki-laki</small></th>
                                <th class="table-success"><small>Perempuan</small></th>
                                <th class="table-success border-end fw-bold"><small>Total (L+P)</small></th>
                                <th class="table-info"><small>Laki-laki</small></th>
                                <th class="table-info"><small>Perempuan</small></th>
                                <th class="table-info border-end fw-bold"><small>Total (L+P)</small></th>
                                <th class="table-warning"><small>Laki-laki</small></th>
                                <th class="table-warning"><small>Perempuan</small></th>
                                <th class="table-warning fw-bold"><small>Total (L+P)</small></th>
                            </tr>
                        </thead>
                        
                        <tbody class="text-center bg-white">
                            <?php
                            // Variabel untuk menampung Grand Total
                            $t_far_l = 0; $t_far_p = 0; $t_far_tot = 0;
                            $t_psi_l = 0; $t_psi_p = 0; $t_psi_tot = 0;
                            $t_tra_l = 0; $t_tra_p = 0; $t_tra_tot = 0;

                            if ($result && mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    
                                    // Ambil nilai dan set default 0 jika NULL
                                    $far_l = $row['farmasi_l'] ?? 0;
                                    $far_p = $row['farmasi_p'] ?? 0;
                                    $far_t = $row['farmasi_total'] ?? 0;
                                    
                                    $psi_l = $row['psikologis_l'] ?? 0;
                                    $psi_p = $row['psikologis_p'] ?? 0;
                                    $psi_t = $row['psikologis_total'] ?? 0;
                                    
                                    $tra_l = $row['tradisional_l'] ?? 0;
                                    $tra_p = $row['tradisional_p'] ?? 0;
                                    $tra_t = $row['tradisional_total'] ?? 0;

                                    // Akumulasi Total
                                    $t_far_l += $far_l; $t_far_p += $far_p; $t_far_tot += $far_t;
                                    $t_psi_l += $psi_l; $t_psi_p += $psi_p; $t_psi_tot += $psi_t;
                                    $t_tra_l += $tra_l; $t_tra_p += $tra_p; $t_tra_tot += $tra_t;

                                    // Fungsi format tampilan angka (ganti 0 dengan '-')
                                    $v_far_l = ($far_l > 0) ? number_format($far_l, 0, ',', '.') : '-';
                                    $v_far_p = ($far_p > 0) ? number_format($far_p, 0, ',', '.') : '-';
                                    $v_far_t = ($far_t > 0) ? number_format($far_t, 0, ',', '.') : '-';
                                    
                                    $v_psi_l = ($psi_l > 0) ? number_format($psi_l, 0, ',', '.') : '-';
                                    $v_psi_p = ($psi_p > 0) ? number_format($psi_p, 0, ',', '.') : '-';
                                    $v_psi_t = ($psi_t > 0) ? number_format($psi_t, 0, ',', '.') : '-';
                                    
                                    $v_tra_l = ($tra_l > 0) ? number_format($tra_l, 0, ',', '.') : '-';
                                    $v_tra_p = ($tra_p > 0) ? number_format($tra_p, 0, ',', '.') : '-';
                                    $v_tra_t = ($tra_t > 0) ? number_format($tra_t, 0, ',', '.') : '-';

                                    echo "<tr>";
                                    echo "<td class='text-muted border-end fw-bold'>" . htmlspecialchars($row["no"]) . "</td>";
                                    
                                    // Hilangkan underscore pada nama fasyankes jika ada
                                    $nama_faskes = str_replace('_', ' ', $row["fasyankes"]);
                                    echo "<td class='text-start fw-bold text-dark border-end text-wrap px-4'>" . htmlspecialchars($nama_faskes) . "</td>";
                                    
                                    // Farmasi
                                    echo "<td class='px-3'>{$v_far_l}</td>";
                                    echo "<td class='px-3'>{$v_far_p}</td>";
                                    echo "<td class='fw-bold border-end text-success bg-success bg-opacity-10 px-3'>{$v_far_t}</td>";
                                    
                                    // Psikologis
                                    echo "<td class='px-3'>{$v_psi_l}</td>";
                                    echo "<td class='px-3'>{$v_psi_p}</td>";
                                    echo "<td class='fw-bold border-end text-primary bg-primary bg-opacity-10 px-3'>{$v_psi_t}</td>";
                                    
                                    // Tradisional
                                    echo "<td class='px-3'>{$v_tra_l}</td>";
                                    echo "<td class='px-3'>{$v_tra_p}</td>";
                                    echo "<td class='fw-bold text-warning-emphasis bg-warning bg-opacity-10 px-3'>{$v_tra_t}</td>";
                                    
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='11' class='text-center py-5 text-muted fst-italic'>Data tenaga medis tidak ditemukan.</td></tr>";
                            }
                            ?>
                        </tbody>
                        
                        <tfoot class="position-sticky bottom-0 z-1">
                            <tr class="table-dark text-center fw-bold align-middle border-top border-2 border-dark">
                                <td colspan="2" class="py-3 text-end px-4 bg-dark text-white border-end">TOTAL KESELURUHAN</td>
                                
                                <td class="text-white"><?= ($t_far_l > 0) ? number_format($t_far_l, 0, ',', '.') : '-' ?></td>
                                <td class="text-white"><?= ($t_far_p > 0) ? number_format($t_far_p, 0, ',', '.') : '-' ?></td>
                                <td class="bg-success text-white border-end fs-6"><?= ($t_far_tot > 0) ? number_format($t_far_tot, 0, ',', '.') : '-' ?></td>
                                
                                <td class="text-white"><?= ($t_psi_l > 0) ? number_format($t_psi_l, 0, ',', '.') : '-' ?></td>
                                <td class="text-white"><?= ($t_psi_p > 0) ? number_format($t_psi_p, 0, ',', '.') : '-' ?></td>
                                <td class="bg-primary text-white border-end fs-6"><?= ($t_psi_tot > 0) ? number_format($t_psi_tot, 0, ',', '.') : '-' ?></td>
                                
                                <td class="text-white"><?= ($t_tra_l > 0) ? number_format($t_tra_l, 0, ',', '.') : '-' ?></td>
                                <td class="text-white"><?= ($t_tra_p > 0) ? number_format($t_tra_p, 0, ',', '.') : '-' ?></td>
                                <td class="text-dark bg-warning fs-6"><?= ($t_tra_tot > 0) ? number_format($t_tra_tot, 0, ',', '.') : '-' ?></td>
                            </tr>
                        </tfoot>
                        
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>