<?php
// FILE: pages/indikator_kinerja_rs_sragen.php

// Ambil data indikator kinerja RS (Variabel $conn otomatis terbaca dari index.php)
$sql = "SELECT * FROM indikator_kinerja_rs_sragen ORDER BY no ASC";
$result = mysqli_query($conn, $sql);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold text-dark m-0">Indikator Kinerja Rumah Sakit (BOR, BTO, TOI, ALOS)</h3>
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle shadow-sm fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-download me-2"></i> Export Data
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
            <li><h6 class="dropdown-header text-uppercase">Pilih Format</h6></li>
            <li><a class="dropdown-item py-2" href="exports/export_indikator_rs.php?type=excel"><i class="bi bi-file-earmark-excel-fill text-success me-2"></i> Export Excel</a></li>
            <li><a class="dropdown-item py-2" href="exports/export_indikator_rs.php?type=csv"><i class="bi bi-filetype-csv text-secondary me-2"></i> Export CSV</a></li>
            <li><a class="dropdown-item py-2" href="exports/export_indikator_rs.php?type=pdf" target="_blank"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i> Export PDF</a></li>
            <li><a class="dropdown-item py-2" href="exports/export_indikator_rs.php?type=json" target="_blank"><i class="bi bi-filetype-json text-warning me-2"></i> Export JSON</a></li>
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
                    <i class="bi bi-activity text-success me-2"></i> Kabupaten Sragen 2025
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive rounded border">
                    <table class="table table-hover table-striped table-bordered align-middle mb-0" style="font-size: 0.9rem;">
                        
                        <thead class="text-center align-middle">
                            <tr>
                                <th rowspan="2" width="4%" class="bg-primary text-white">No</th>
                                <th rowspan="2" class="bg-primary text-white text-start">Nama Rumah Sakit</th>
                                <th colspan="4" class="bg-light">Data Dasar Rawat Inap</th>
                                <th colspan="4" class="bg-success text-white">Indikator Kinerja Pelayanan</th>
                            </tr>
                            <tr>
                                <th class="bg-light"><small>Jml Tempat Tidur</small></th>
                                <th class="bg-light"><small>Pasien Keluar</small></th>
                                <th class="bg-light"><small>Hari Perawatan</small></th>
                                <th class="bg-light"><small>Lama Dirawat</small></th>
                                
                                <th class="table-success"><small>BOR (%)</small></th>
                                <th class="table-success"><small>BTO (Kali)</small></th>
                                <th class="table-success"><small>TOI (Hari)</small></th>
                                <th class="table-success"><small>ALOS (Hari)</small></th>
                            </tr>
                        </thead>
                        
                        <tbody class="text-center bg-white">
                            <?php
                            // Variabel Penampung Akumulasi Total
                            $t_tt = 0; // Tempat Tidur
                            $t_pk = 0; // Pasien Keluar
                            $t_hp = 0; // Hari Perawatan
                            $t_ld = 0; // Lama Dirawat

                            if ($result && mysqli_num_rows($result) > 0) {
                                $no = 1;
                                while($row = mysqli_fetch_assoc($result)) {
                                    
                                    // Format angka dengan titik ribuan
                                    $tt = number_format($row['jumlah_tempat_tidur'], 0, ',', '.');
                                    $pk = number_format($row['jumlah_pasien_keluar'], 0, ',', '.');
                                    $hp = number_format($row['jumlah_hari_perawatan'], 0, ',', '.');
                                    $ld = number_format($row['jumlah_lama_dirawat'], 0, ',', '.');

                                    // Akumulasi Total Kabupaten
                                    $t_tt += $row['jumlah_tempat_tidur'];
                                    $t_pk += $row['jumlah_pasien_keluar'];
                                    $t_hp += $row['jumlah_hari_perawatan'];
                                    $t_ld += $row['jumlah_lama_dirawat'];

                                    echo "<tr>";
                                    echo "<td class='text-muted fw-bold'>" . $no++ . "</td>";
                                    echo "<td class='text-start fw-bold text-dark'>" . htmlspecialchars($row["nama_rumah_sakit"]) . "</td>";
                                    
                                    echo "<td>{$tt}</td>";
                                    echo "<td>{$pk}</td>";
                                    echo "<td>{$hp}</td>";
                                    echo "<td>{$ld}</td>";
                                    
                                    echo "<td class='fw-bold text-success'>{$row['bor']}</td>";
                                    echo "<td class='fw-bold text-success'>{$row['bto']}</td>";
                                    echo "<td class='fw-bold text-success'>{$row['toi']}</td>";
                                    echo "<td class='fw-bold text-success'>{$row['alos']}</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='10' class='text-center py-5 text-muted fst-italic'>Data Indikator Kinerja RS tidak ditemukan.</td></tr>";
                            }
                            
                            // Hitung Akurat Rata-rata Indikator Kabupaten (Asumsi 1 Tahun = 365 Hari)
                            $tot_bor = ($t_tt > 0) ? round(($t_hp / ($t_tt * 365)) * 100, 2) : 0;
                            $tot_bto = ($t_tt > 0) ? round($t_pk / $t_tt, 0) : 0;
                            $tot_toi = ($t_pk > 0) ? round((($t_tt * 365) - $t_hp) / $t_pk, 0) : 0;
                            $tot_alos = ($t_pk > 0) ? round($t_ld / $t_pk, 0) : 0;
                            ?>
                        </tbody>
                        
                        <tfoot>
                            <tr class="table-dark text-center fw-bold align-middle">
                                <td colspan="2" class="py-3 text-end pe-4 bg-dark text-white border-end-0">TOTAL KABUPATEN</td>
                                
                                <td class="text-warning"><?= number_format($t_tt, 0, ',', '.') ?></td>
                                <td class="text-warning"><?= number_format($t_pk, 0, ',', '.') ?></td>
                                <td class="text-warning"><?= number_format($t_hp, 0, ',', '.') ?></td>
                                <td class="text-warning"><?= number_format($t_ld, 0, ',', '.') ?></td>

                                <td class="bg-success text-white fs-6"><?= number_format($tot_bor, 2, ',', '.') ?></td>
                                <td class="bg-success text-white fs-6"><?= number_format($tot_bto, 0, ',', '.') ?></td>
                                <td class="bg-success text-white fs-6"><?= number_format($tot_toi, 0, ',', '.') ?></td>
                                <td class="bg-success text-white fs-6"><?= number_format($tot_alos, 0, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="px-4 mt-3 text-muted small lh-lg">
                    <i class="bi bi-info-circle-fill me-1"></i> <strong>Keterangan Indikator (Standar Kemenkes RI):</strong><br>
                    &bull; <strong>BOR</strong> <em>(Bed Occupancy Rate)</em>: Angka penggunaan tempat tidur.<br>
                    &bull; <strong>BTO</strong> <em>(Bed Turn Over)</em>: Frekuensi pemakaian tempat tidur dalam setahun.<br>
                    &bull; <strong>TOI</strong> <em>(Turn Over Interval)</em>: Rata-rata hari tempat tidur kosong/tidak terisi.<br>
                    &bull; <strong>ALOS</strong> <em>(Average Length of Stay)</em>: Rata-rata lama perawatan seorang pasien.
                </div>
            </div>
            
        </div>
    </div>
</div>