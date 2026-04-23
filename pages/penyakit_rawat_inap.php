<?php

// Ambil data Top 10 Penyakit Rawat Inap
$sql = "SELECT * FROM top10_penyakit_rawat_inap_sragen ORDER BY no ASC";
$result = mysqli_query($conn, $sql);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold text-dark m-0">Top 10 Penyakit Rawat Inap & CFR</h3>
      <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle shadow-sm fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-download me-2"></i> Export Data
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0">
              <li><h6 class="dropdown-header text-uppercase">Pilih Format</h6></li>
              <li><a class="dropdown-item py-2" href="exports/export_top10_ranap.php?type=excel"><i class="bi bi-file-earmark-excel-fill text-success me-2"></i> Export Excel</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_top10_ranap.php?type=csv"><i class="bi bi-filetype-csv text-secondary me-2"></i> Export CSV</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_top10_ranap.php?type=pdf" target="_blank"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i> Export PDF</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_top10_ranap.php?type=json" target="_blank"><i class="bi bi-filetype-json text-warning me-2"></i> Export JSON</a></li>
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
                    <i class="bi bi-hospital-fill text-primary me-2"></i> Kabupaten Sragen 2025
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive border rounded shadow-sm">
                    <table class="table table-hover table-bordered align-middle mb-0 text-nowrap" style="font-size: 0.9rem;">
                        
                        <thead class="table-primary text-center align-middle">
                            <tr>
                                <th rowspan="2" width="5%" class="py-3 border-end">No</th>
                                <th rowspan="2" class="border-end">Kode<br>ICD-X</th>
                                <th rowspan="2" class="text-start border-end">Golongan / Sebab Sakit</th>
                                <th colspan="2" class="border-end">Jumlah Pasien</th>
                                <th rowspan="2" class="table-success border-end">Total Pasien<br><small>(Jiwa)</small></th>
                                <th rowspan="2" class="table-danger border-end">Pasien Mati<br><small>(Jiwa)</small></th>
                                <th rowspan="2" class="table-danger text-danger">CFR<br><small>(%)</small></th>
                            </tr>
                            <tr>
                                <th>Laki-laki</th>
                                <th class="border-end">Perempuan</th>
                            </tr>
                        </thead>
                        
                        <tbody class="text-center bg-white">
                            <?php
                            // Variabel untuk menampung Grand Total
                            $tot_l      = 0;
                            $tot_p      = 0;
                            $tot_pasien = 0;
                            $tot_mati   = 0;

                            if ($result && mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    
                                    // Format angka ribuan
                                    $jml_l  = $row["pasien_laki_laki"] ? number_format($row["pasien_laki_laki"], 0, ',', '.') : '0';
                                    $jml_p  = $row["pasien_perempuan"] ? number_format($row["pasien_perempuan"], 0, ',', '.') : '0';
                                    $pasien = $row["jumlah_pasien"] ? number_format($row["jumlah_pasien"], 0, ',', '.') : '0';
                                    $mati   = $row["pasien_mati"] ? number_format($row["pasien_mati"], 0, ',', '.') : '0';
                                    $cfr    = $row["cfr_persen"] ? number_format($row["cfr_persen"], 2, ',', '.') : '0,00';

                                    // Akumulasi Total
                                    $tot_l      += $row["pasien_laki_laki"];
                                    $tot_p      += $row["pasien_perempuan"];
                                    $tot_pasien += $row["jumlah_pasien"];
                                    $tot_mati   += $row["pasien_mati"];

                                    echo "<tr>";
                                    echo "<td class='text-secondary border-end fw-bold'>" . $row['no'] . "</td>";
                                    echo "<td class='border-end'><span class='badge bg-secondary bg-opacity-10 text-dark border'>" . htmlspecialchars($row["icd_x"]) . "</span></td>";
                                    echo "<td class='text-start fw-bold text-dark border-end text-wrap' style='min-width: 250px;'>" . $rank_badge . htmlspecialchars($row["golongan_sebab_sakit"]) . "</td>";
                                    
                                    echo "<td>{$jml_l}</td>";
                                    echo "<td class='border-end'>{$jml_p}</td>";
                                    
                                    echo "<td class='text-success fw-bold bg-success bg-opacity-10 border-end'>{$pasien}</td>";
                                    echo "<td class='text-danger fw-bold bg-danger bg-opacity-10 border-end'>{$mati}</td>";
                                    echo "<td class='text-danger fw-bold'>{$cfr}</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center py-4 text-muted fst-italic'>Data penyakit rawat inap tidak ditemukan.</td></tr>";
                            }
                            
                            // Hitung CFR Grand Total Secara Akurat
                            $tot_cfr = ($tot_pasien > 0) ? round(($tot_mati / $tot_pasien) * 100, 2) : 0;
                            ?>
                        </tbody>
                        
                        <tfoot>
                            <tr class="table-dark text-center fw-bold align-middle">
                                <td colspan="3" class="py-3 text-end pe-4 border-end">TOTAL KESELURUHAN (TOP 10)</td>
                                <td class="text-warning"><?= number_format($tot_l, 0, ',', '.') ?></td>
                                <td class="text-warning border-end"><?= number_format($tot_p, 0, ',', '.') ?></td>
                                <td class="bg-success text-white fs-6 border-end"><?= number_format($tot_pasien, 0, ',', '.') ?></td>
                                <td class="bg-danger text-white fs-6 border-end"><?= number_format($tot_mati, 0, ',', '.') ?></td>
                                <td class="text-danger bg-white"><?= number_format($tot_cfr, 2, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                        
                    </table>
                </div>
                
                <div class="mt-3 text-muted small">
                    <i class="bi bi-info-circle-fill me-1"></i> <strong>Keterangan:</strong><br>
                    &bull; <strong>CFR (Case Fatality Rate):</strong> Persentase tingkat kematian akibat penyakit tertentu (Pasien Mati / Total Pasien &times; 100%).<br>
                    &bull; Data diambil berdasarkan standar klasifikasi penyakit internasional <strong>(ICD-X)</strong>.
                </div>
            </div>
            
        </div>
    </div>
</div>