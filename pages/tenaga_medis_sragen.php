<?php
// FILE: pages/tenaga_medis.php

// Ambil data Tenaga Medis
$sql = "SELECT * FROM tenaga_medis_sragen ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>

<style>
    /* Perbaikan Scroll agar mulus untuk layar kecil */
    .table-custom-wrap { 
        max-height: 75vh; 
        overflow-y: auto; 
        overflow-x: auto; 
    }
    
    /* Membuat Header 3 Tingkat Tetap Di Atas (Sticky) */
    .table-custom-wrap thead tr:nth-child(1) th { position: sticky; top: 0; z-index: 4; }
    .table-custom-wrap thead tr:nth-child(2) th { position: sticky; top: 37px; z-index: 3; }
    /* Menambahkan box-shadow pada baris ketiga agar terlihat batas headernya saat di-scroll */
    .table-custom-wrap thead tr:nth-child(3) th { position: sticky; top: 74px; z-index: 2; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold text-dark m-0">Data Tenaga Medis (Dokter & Dokter Gigi)</h3>
      <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle shadow-sm fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-download me-2"></i> Export Data
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0">
              <li><h6 class="dropdown-header text-uppercase">Pilih Format</h6></li>
              <li><a class="dropdown-item py-2" href="exports/export_tenaga_medis.php?type=excel"><i class="bi bi-file-earmark-excel-fill text-success me-2"></i> Export Excel</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_tenaga_medis.php?type=csv"><i class="bi bi-filetype-csv text-secondary me-2"></i> Export CSV</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_tenaga_medis.php?type=pdf" target="_blank"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i> Export PDF</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_tenaga_medis.php?type=json" target="_blank"><i class="bi bi-filetype-json text-warning me-2"></i> Export JSON</a></li>
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
                    <i class="bi bi-person-hearts text-primary me-2"></i> Kabupaten Sragen 2025
                </h5>
            </div>

            <div class="card-body p-3 p-md-4">
                <div class="table-responsive table-custom-wrap border rounded shadow-sm mb-3">
                    <table class="table table-hover table-bordered align-middle mb-0 text-nowrap" style="font-size: 0.85rem;">
                        
                        <thead class="text-center align-middle border-dark">
                            <tr>
                                <th rowspan="3" width="3%" class="bg-dark text-white border-end py-3">No</th>
                                <th rowspan="3" class="bg-dark text-white border-end px-3">Kategori</th>
                                <th rowspan="3" class="text-start bg-dark text-white border-end px-4" style="min-width: 250px;">Unit Kerja / Fasilitas Kesehatan</th>
                                <th colspan="12" class="table-info border-end border-bottom">DOKTER (UMUM & SPESIALIS)</th>
                                <th colspan="12" class="table-success border-bottom">DOKTER GIGI (UMUM & SPESIALIS)</th>
                            </tr>
                            <tr>
                                <th colspan="3" class="table-info border-end border-bottom"><small>Umum</small></th>
                                <th colspan="3" class="table-info border-end border-bottom"><small>Spesialis</small></th>
                                <th colspan="3" class="table-info border-end border-bottom"><small>Sub Spesialis</small></th>
                                <th colspan="3" class="table-primary border-end border-bottom"><small>Total Dokter</small></th>
                                <th colspan="3" class="table-success border-end border-bottom"><small>Umum</small></th>
                                <th colspan="3" class="table-success border-end border-bottom"><small>Spesialis</small></th>
                                <th colspan="3" class="table-success border-end border-bottom"><small>Sub Spesialis</small></th>
                                <th colspan="3" class="table-success border-bottom" style="background-color: #a3cfbb;"><small>Total Drg</small></th>
                            </tr>
                            <tr>
                                <th class="table-info"><small>L</small></th><th class="table-info"><small>P</small></th><th class="table-info border-end fw-bold"><small>L+P</small></th>
                                <th class="table-info"><small>L</small></th><th class="table-info"><small>P</small></th><th class="table-info border-end fw-bold"><small>L+P</small></th>
                                <th class="table-info"><small>L</small></th><th class="table-info"><small>P</small></th><th class="table-info border-end fw-bold"><small>L+P</small></th>
                                <th class="table-primary"><small>L</small></th><th class="table-primary"><small>P</small></th><th class="table-primary border-end fw-bold"><small>L+P</small></th>
                                <th class="table-success"><small>L</small></th><th class="table-success"><small>P</small></th><th class="table-success border-end fw-bold"><small>L+P</small></th>
                                <th class="table-success"><small>L</small></th><th class="table-success"><small>P</small></th><th class="table-success border-end fw-bold"><small>L+P</small></th>
                                <th class="table-success"><small>L</small></th><th class="table-success"><small>P</small></th><th class="table-success border-end fw-bold"><small>L+P</small></th>
                                <th style="background-color: #a3cfbb;"><small>L</small></th><th style="background-color: #a3cfbb;"><small>P</small></th><th style="background-color: #a3cfbb;" class="fw-bold"><small>L+P</small></th>
                            </tr>
                        </thead>
                        
                        <tbody class="text-center bg-white">
                            <?php
                            // Array untuk menampung Grand Total 24 kolom
                            $totals = array_fill(0, 24, 0);

                            if ($result && mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    
                                    // Daftar kolom tanpa underscore saat di-echo (nama variabel tetap sama dengan database)
                                    $cols = [
                                        'dokter_l', 'dokter_p', 'dokter_tot',
                                        'dr_sp_l', 'dr_sp_p', 'dr_sp_tot',
                                        'dr_sub_l', 'dr_sub_p', 'dr_sub_tot',
                                        'total_dr_l', 'total_dr_p', 'total_dr_tot',
                                        'drg_l', 'drg_p', 'drg_tot',
                                        'drg_sp_l', 'drg_sp_p', 'drg_sp_tot',
                                        'drg_sub_l', 'drg_sub_p', 'drg_sub_tot',
                                        'total_drg_l', 'total_drg_p', 'total_drg_tot'
                                    ];

                                    // Styling Badge untuk Kategori (Puskesmas vs Rumah Sakit)
                                    $kategori = strtoupper(trim($row["kategori"]));
                                    if ($kategori == 'PUSKESMAS') {
                                        $badge_kategori = "<span class='badge bg-info text-dark bg-opacity-25 border border-info'>{$row['kategori']}</span>";
                                    } else {
                                        $badge_kategori = "<span class='badge bg-warning text-dark bg-opacity-25 border border-warning'>{$row['kategori']}</span>";
                                    }

                                    echo "<tr>";
                                    echo "<td class='text-muted border-end fw-bold'>" . htmlspecialchars($row["no"]) . "</td>";
                                    echo "<td class='border-end'>{$badge_kategori}</td>";
                                    // Hilangkan underscore jika ada di nama unit_kerja menggunakan str_replace
                                    $nama_unit_bersih = str_replace('_', ' ', $row["unit_kerja"]);
                                    echo "<td class='text-start fw-bold text-dark border-end text-wrap px-4'>" . htmlspecialchars($nama_unit_bersih) . "</td>";
                                    
                                    // Looping untuk menampilkan data dan menambahkan ke Grand Total
                                    foreach ($cols as $index => $col) {
                                        $val = $row[$col] ?? 0;
                                        $totals[$index] += $val; // Tambah ke total
                                        
                                        // Styling visual: Kolom ke-3, 6, 9 (indeks 2, 5, 8...) adalah kolom "Total (L+P)"
                                        $is_total_col = (($index + 1) % 3 == 0);
                                        $class = $is_total_col ? "fw-bold border-end bg-light" : "";
                                        
                                        // Ganti 0 dengan strip (-) agar rapi
                                        $display_val = ($val > 0) ? number_format($val, 0, ',', '.') : '-';
                                        
                                        echo "<td class='{$class} px-3'>{$display_val}</td>";
                                    }
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='26' class='text-center py-5 text-muted fst-italic'>Data tenaga medis tidak ditemukan.</td></tr>";
                            }
                            ?>
                        </tbody>
                        
                        <tfoot class="position-sticky bottom-0 z-1">
                            <tr class="table-dark text-center fw-bold align-middle border-top border-2 border-dark">
                                <td colspan="3" class="py-3 text-middle px-4 bg-dark text-white border-end">TOTAL KESELURUHAN</td>
                                <?php
                                // Menampilkan array Total yang sudah dihitung
                                foreach ($totals as $index => $tot) {
                                    $is_total_col = (($index + 1) % 3 == 0);
                                    
                                    // Pewarnaan khusus kolom total (Kuning/Biru/Hijau)
                                    if ($index == 11) { // Total Dokter Keseluruhan
                                        $class = "bg-primary text-white border-end fs-6";
                                    } else if ($index == 23) { // Total Drg Keseluruhan
                                        $class = "bg-success text-white fs-6";
                                    } else {
                                        $class = $is_total_col ? "text-warning border-end bg-dark" : "text-warning bg-dark";
                                    }

                                    $display_tot = ($tot > 0) ? number_format($tot, 0, ',', '.') : '-';
                                    echo "<td class='{$class}'>{$display_tot}</td>";
                                }
                                ?>
                            </tr>
                        </tfoot>
                        
                    </table>
                </div>
                <div class="mt-3 text-muted small">
                    <i class="bi bi-info-circle-fill me-1"></i> <strong>Keterangan:</strong><br>
                    &bull; Tenaga Kesehatan Termasuk yang Memiliki Ijazah Pasca Sarjana dan Doktor
                </div>
            </div>
            
        </div>
    </div>
</div>