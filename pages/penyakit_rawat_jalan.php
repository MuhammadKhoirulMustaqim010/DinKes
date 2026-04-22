<?php
// FILE: pages/top10_penyakit_rajal.php

// Ambil data Top 10 Penyakit Rawat Jalan
$sql = "SELECT * FROM top10_penyakit_rawat_jalan_sragen ORDER BY no ASC";
$result = mysqli_query($conn, $sql);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold text-dark m-0">Top 10 Penyakit Rawat Jalan</h3>
      <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle shadow-sm fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-download me-2"></i> Export Data
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0">
              <li><h6 class="dropdown-header text-uppercase">Pilih Format</h6></li>
              <li><a class="dropdown-item py-2" href="exports/export_top10_rajal.php?type=excel"><i class="bi bi-file-earmark-excel-fill text-success me-2"></i> Export Excel</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_top10_rajal.php?type=csv"><i class="bi bi-filetype-csv text-secondary me-2"></i> Export CSV</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_top10_rajal.php?type=pdf" target="_blank"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i> Export PDF</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_top10_rajal.php?type=json" target="_blank"><i class="bi bi-filetype-json text-warning me-2"></i> Export JSON</a></li>
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
                    <i class="bi bi-clipboard2-pulse-fill text-danger me-2"></i> Kabupaten Sragen 2025
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive border rounded shadow-sm">
                    <table class="table table-hover table-bordered align-middle mb-0 text-nowrap" style="font-size: 0.9rem;">
                        
                        <thead class="table-danger text-center align-middle">
                            <tr>
                                <th rowspan="2" width="5%" class="py-3 border-end">No</th>
                                <th rowspan="2" class="border-end">Kode<br>ICD-X</th>
                                <th rowspan="2" class="text-start border-end">Golongan / Sebab Sakit</th>
                                <th colspan="2" class="border-end">Pasien Baru</th>
                                <th rowspan="2" class="border-end">Kasus Lama<br><small>(Jiwa)</small></th>
                                <th rowspan="2" class="table-success">Total Kunjungan<br><small>(Jiwa)</small></th>
                            </tr>
                            <tr>
                                <th>Laki-laki</th>
                                <th class="border-end">Perempuan</th>
                            </tr>
                        </thead>
                        
                        <tbody class="text-center bg-white">
                            <?php
                            // Variabel untuk menampung Grand Total
                            $tot_baru_l = 0;
                            $tot_baru_p = 0;
                            $tot_lama   = 0;
                            $tot_all    = 0;

                            if ($result && mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    
                                    // Format angka ribuan
                                    $baru_l = $row["pasien_baru_laki_laki"] ? number_format($row["pasien_baru_laki_laki"], 0, ',', '.') : '0';
                                    $baru_p = $row["pasien_baru_perempuan"] ? number_format($row["pasien_baru_perempuan"], 0, ',', '.') : '0';
                                    $lama   = $row["kasus_lama_atau_jumlah"] ? number_format($row["kasus_lama_atau_jumlah"], 0, ',', '.') : '0';
                                    $total  = $row["total_kunjungan"] ? number_format($row["total_kunjungan"], 0, ',', '.') : '0';

                                    // Akumulasi Total
                                    $tot_baru_l += $row["pasien_baru_laki_laki"];
                                    $tot_baru_p += $row["pasien_baru_perempuan"];
                                    $tot_lama   += $row["kasus_lama_atau_jumlah"];
                                    $tot_all    += $row["total_kunjungan"];

                                    echo "<tr>";
                                    echo "<td class='text-secondary border-end fw-bold'>" . $row['no'] . "</td>";
                                    echo "<td class='border-end'><span class='badge bg-secondary bg-opacity-10 text-dark border'>" . htmlspecialchars($row["icd_x"]) . "</span></td>";
                                    echo "<td class='text-start fw-bold text-dark border-end text-wrap' style='min-width: 250px;'>" . $rank_badge . htmlspecialchars($row["golongan_sebab_sakit"]) . "</td>";
                                    
                                    echo "<td>{$baru_l}</td>";
                                    echo "<td class='border-end'>{$baru_p}</td>";
                                    
                                    echo "<td class='text-primary fw-bold border-end'>{$lama}</td>";
                                    echo "<td class='text-success fw-bold bg-success bg-opacity-10'>{$total}</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center py-4 text-muted fst-italic'>Data penyakit rawat jalan tidak ditemukan.</td></tr>";
                            }
                            ?>
                        </tbody>
                        
                        <tfoot>
                            <tr class="table-dark text-center fw-bold align-middle">
                                <td colspan="3" class="py-3 text-end pe-4 border-end">TOTAL KESELURUHAN (TOP 10)</td>
                                <td class="text-warning"><?= number_format($tot_baru_l, 0, ',', '.') ?></td>
                                <td class="text-warning border-end"><?= number_format($tot_baru_p, 0, ',', '.') ?></td>
                                <td class="text-info border-end"><?= number_format($tot_lama, 0, ',', '.') ?></td>
                                <td class="bg-success text-white fs-6"><?= number_format($tot_all, 0, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                        
                    </table>
                </div>
                
                <div class="mt-3 text-muted small">
                    <i class="bi bi-info-circle-fill me-1"></i> <strong>Keterangan:</strong> 
                    Data diambil berdasarkan standar klasifikasi penyakit internasional <strong>(ICD-X)</strong>.
                </div>
            </div>
            
        </div>
    </div>
</div>