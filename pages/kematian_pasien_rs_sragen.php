<?php
// FILE: pages/kematian_pasien_rs_sragen.php

// Ambil data kematian pasien RS (Variabel $conn otomatis terbaca dari index.php)
$sql = "SELECT * FROM kematian_pasien_rs_sragen ORDER BY no ASC";
$result = mysqli_query($conn, $sql);
?>

<style>
    .table-custom-wrap { max-height: 70vh; overflow-y: auto; overflow-x: auto; }
    .table-custom-wrap thead th { top: 0; z-index: 2; box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.2); }
    .bg-keluar { background-color: #38455f !important; color: white !important;}
    .bg-mati { background-color: #b45f68 !important; color: white !important; }
    .bg-mati-48 { background-color: #b1434e !important; color: white !important; }
    .bg-gdr { background-color: #7b6b35 !important; color: white !important; }
    .bg-ndr { background-color: #4aa1b4 !important; color: white !important; }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold text-dark m-0">Laporan Kematian Pasien & Indikator RS</h3>
      <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle shadow-sm fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-download me-2"></i> Export Data
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0">
              <li><h6 class="dropdown-header text-uppercase">Pilih Format</h6></li>
              <li><a class="dropdown-item py-2" href="exports/export_kematian_rs.php?type=excel"><i class="bi bi-file-earmark-excel-fill text-success me-2"></i> Export Excel</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_kematian_rs.php?type=csv"><i class="bi bi-filetype-csv text-secondary me-2"></i> Export CSV</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_kematian_rs.php?type=pdf" target="_blank"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i> Export PDF</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_kematian_rs.php?type=json" target="_blank"><i class="bi bi-filetype-json text-warning me-2"></i> Export JSON</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item py-2" href="javascript:window.print()"><i class="bi bi-printer-fill text-dark me-2"></i> Cetak Halaman</a></li>
          </ul>
      </div>
</div>

<div class="row justify-content-center mb-5">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 rounded-4">
            
            <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <h5 class="fw-bold text-dark m-0 mb-2 mb-md-0">
                    <i class="bi bi-heart-pulse-fill text-danger me-2"></i> Kabupaten Sragen 2025
                </h5>
            </div>

            <div class="card-body p-0 pb-4">
                <div class="table-custom-wrap mx-4 border rounded">
                    <table class="table table-hover table-bordered align-middle mb-0 text-nowrap" style="font-size: 0.85rem;">
                        <thead class="text-center align-middle">
                            <tr>
                                <th rowspan="2" width="4%" class="bg-dark text-white">No</th>
                                <th rowspan="2" class="bg-dark text-white">Nama Rumah Sakit</th>
                                <th colspan="3" class="bg-keluar">Pasien Keluar (Hidup & Mati)</th>
                                <th colspan="3" class="bg-mati">Pasien Keluar Mati</th>
                                <th colspan="3" class="bg-mati-48">Mati &ge; 48 Jam</th>
                                <th colspan="3" class="bg-gdr">GDR (‰) <br><small class="fw-normal">Gross Death Rate</small></th>
                                <th colspan="3" class="bg-ndr">NDR (‰) <br><small class="fw-normal">Net Death Rate</small></th>
                            </tr>
                            <tr>
                                <th class="bg-keluar"><small>Laki-laki</small></th><th class="bg-keluar"><small>Perempuan</small></th><th class="bg-keluar"><small>Total</small></th>
                                <th class="bg-mati"><small>Laki-laki</small></th><th class="bg-mati"><small>Perempuan</small></th><th class="bg-mati"><small>Total</small></th>
                                <th class="bg-mati-48"><small>Laki-laki</small></th><th class="bg-mati-48"><small>Perempuan</small></th><th class="bg-mati-48"><small>Total</small></th>
                                <th class="bg-gdr"><small>Laki-laki</small></th><th class="bg-gdr"><small>Perempuan</small></th><th class="bg-gdr"><small>Total</small></th>
                                <th class="bg-ndr"><small>Laki-laki</small></th><th class="bg-ndr"><small>Perempuan</small></th><th class="bg-ndr"><small>Total</small></th>
                            </tr>
                        </thead>
                        <tbody class="text-center bg-white">
                            <?php
                            // Variabel Penampung Akumulasi Total Jiwa
                            $t_keluar_l = 0; $t_keluar_p = 0; $t_keluar_tot = 0;
                            $t_mati_l = 0;   $t_mati_p = 0;   $t_mati_tot = 0;
                            $t_m48_l = 0;    $t_m48_p = 0;    $t_m48_tot = 0;

                            if ($result && mysqli_num_rows($result) > 0) {
                                $no = 1;
                                while($row = mysqli_fetch_assoc($result)) {
                                    
                                    // Format angka dengan fungsi number_format agar ada titik ribuan
                                    $khm_l = number_format($row['keluar_hidup_mati_l'], 0, ',', '.');
                                    $khm_p = number_format($row['keluar_hidup_mati_p'], 0, ',', '.');
                                    $khm_t = number_format($row['keluar_hidup_mati_total'], 0, ',', '.');

                                    $km_l = number_format($row['keluar_mati_l'], 0, ',', '.');
                                    $km_p = number_format($row['keluar_mati_p'], 0, ',', '.');
                                    $km_t = number_format($row['keluar_mati_total'], 0, ',', '.');

                                    $m48_l = number_format($row['keluar_mati_lebih_48_jam_l'], 0, ',', '.');
                                    $m48_p = number_format($row['keluar_mati_lebih_48_jam_p'], 0, ',', '.');
                                    $m48_t = number_format($row['keluar_mati_lebih_48_jam_total'], 0, ',', '.');

                                    // Persentase (biarkan sesuai database)
                                    $gdr_l = $row['gdr_l']; $gdr_p = $row['gdr_p']; $gdr_t = $row['gdr_total'];
                                    $ndr_l = $row['ndr_l']; $ndr_p = $row['ndr_p']; $ndr_t = $row['ndr_total'];

                                    // Akumulasi Total Kabupaten
                                    $t_keluar_l += $row['keluar_hidup_mati_l'];
                                    $t_keluar_p += $row['keluar_hidup_mati_p'];
                                    $t_keluar_tot += $row['keluar_hidup_mati_total'];

                                    $t_mati_l += $row['keluar_mati_l'];
                                    $t_mati_p += $row['keluar_mati_p'];
                                    $t_mati_tot += $row['keluar_mati_total'];

                                    $t_m48_l += $row['keluar_mati_lebih_48_jam_l'];
                                    $t_m48_p += $row['keluar_mati_lebih_48_jam_p'];
                                    $t_m48_tot += $row['keluar_mati_lebih_48_jam_total'];

                                    echo "<tr>";
                                    echo "<td class='text-muted fw-bold'>" . $no++ . "</td>";
                                    echo "<td class='text-start fw-bold text-dark'>" . htmlspecialchars($row["nama_rumah_sakit"]) . "</td>";
                                    
                                    echo "<td>{$khm_l}</td> <td>{$khm_p}</td> <td class='fw-bold bg-light'>{$khm_t}</td>";
                                    echo "<td>{$km_l}</td> <td>{$km_p}</td> <td class='fw-bold text-danger bg-danger bg-opacity-10'>{$km_t}</td>";
                                    echo "<td>{$m48_l}</td> <td>{$m48_p}</td> <td class='fw-bold text-danger bg-danger bg-opacity-10'>{$m48_t}</td>";
                                    
                                    echo "<td>{$gdr_l}</td> <td>{$gdr_p}</td> <td class='fw-bold text-warning-emphasis bg-warning bg-opacity-10'>{$gdr_t}</td>";
                                    echo "<td>{$ndr_l}</td> <td>{$ndr_p}</td> <td class='fw-bold text-info-emphasis bg-info bg-opacity-10'>{$ndr_t}</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='17' class='text-center py-5 text-muted fst-italic'>Data Rumah Sakit tidak ditemukan.</td></tr>";
                            }
                            
                            // Hitung Akurat Total GDR & NDR (Kematian / Keluar * 1000)
                            $tot_gdr_l = ($t_keluar_l > 0) ? round(($t_mati_l / $t_keluar_l) * 1000, 1) : 0;
                            $tot_gdr_p = ($t_keluar_p > 0) ? round(($t_mati_p / $t_keluar_p) * 1000, 1) : 0;
                            $tot_gdr_t = ($t_keluar_tot > 0) ? round(($t_mati_tot / $t_keluar_tot) * 1000, 1) : 0;

                            $tot_ndr_l = ($t_keluar_l > 0) ? round(($t_m48_l / $t_keluar_l) * 1000, 1) : 0;
                            $tot_ndr_p = ($t_keluar_p > 0) ? round(($t_m48_p / $t_keluar_p) * 1000, 1) : 0;
                            $tot_ndr_t = ($t_keluar_tot > 0) ? round(($t_m48_tot / $t_keluar_tot) * 1000, 1) : 0;
                            ?>
                        </tbody>
                        
                        <tfoot>
                            <tr class="table-dark text-center fw-bold align-middle">
                                <td colspan="2" class="py-3 text-end pe-4 bg-dark text-white border-end-0">TOTAL KABUPATEN</td>
                                
                                <td><?= number_format($t_keluar_l, 0, ',', '.') ?></td>
                                <td><?= number_format($t_keluar_p, 0, ',', '.') ?></td>
                                <td class="text-info"><?= number_format($t_keluar_tot, 0, ',', '.') ?></td>
                                
                                <td class="text-danger"><?= number_format($t_mati_l, 0, ',', '.') ?></td>
                                <td class="text-danger"><?= number_format($t_mati_p, 0, ',', '.') ?></td>
                                <td class="text-danger fs-6"><?= number_format($t_mati_tot, 0, ',', '.') ?></td>
                                
                                <td class="text-warning"><?= number_format($t_m48_l, 0, ',', '.') ?></td>
                                <td class="text-warning"><?= number_format($t_m48_p, 0, ',', '.') ?></td>
                                <td class="text-warning fs-6"><?= number_format($t_m48_tot, 0, ',', '.') ?></td>

                                <td><?= number_format($tot_gdr_l, 1, ',', '.') ?></td>
                                <td><?= number_format($tot_gdr_p, 1, ',', '.') ?></td>
                                <td class="bg-warning text-dark"><?= number_format($tot_gdr_t, 1, ',', '.') ?></td>

                                <td><?= number_format($tot_ndr_l, 1, ',', '.') ?></td>
                                <td><?= number_format($tot_ndr_p, 1, ',', '.') ?></td>
                                <td class="bg-info text-dark"><?= number_format($tot_ndr_t, 1, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="px-4 mt-3 text-muted small">
                    <i class="bi bi-info-circle-fill me-1"></i> <strong>Keterangan:</strong> 
                    GDR (Gross Death Rate) adalah angka kematian umum. NDR (Net Death Rate) adalah angka kematian murni (&ge; 48 jam dirawat).
                </div>
            </div>
            
        </div>
    </div>
</div>