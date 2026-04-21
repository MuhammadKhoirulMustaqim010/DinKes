<?php
// FILE: pages/melek_huruf_pend_sragen.php

// Ambil data melek huruf & pendidikan (Variabel $conn otomatis terbaca dari index.php)
$sql = "SELECT * FROM melek_huruf_pend_sragen ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold text-dark m-0">Data Melek Huruf & Tingkat Pendidikan</h3>
    <div class="dropdown">
      <button class="btn btn-primary dropdown-toggle shadow-sm fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-download me-2"></i> Export Data
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow border-0">
          <li><h6 class="dropdown-header text-uppercase">Pilih Format</h6></li>
          <li><a class="dropdown-item py-2" href="exports/export_pendidikan.php?type=excel"><i class="bi bi-file-earmark-excel-fill text-success me-2"></i> Export Excel</a></li>
          <li><a class="dropdown-item py-2" href="exports/export_pendidikan.php?type=csv"><i class="bi bi-filetype-csv text-secondary me-2"></i> Export CSV</a></li>
          <li><a class="dropdown-item py-2" href="exports/export_pendidikan.php?type=pdf" target="_blank"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i> Export PDF</a></li>
          <li><a class="dropdown-item py-2" href="exports/export_pendidikan.php?type=json" target="_blank"><i class="bi bi-filetype-json text-warning me-2"></i> Export JSON</a></li>
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
                    <i class="bi bi-mortarboard-fill text-primary me-2"></i> Kabupaten Sragen 2025
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive border rounded shadow-sm">
                    <table class="table table-hover table-bordered align-middle mb-0 text-nowrap" style="font-size: 0.9rem;">
                        <thead class="table-primary text-center align-middle">
                            <tr>
                                <th rowspan="2" width="5%" class="py-3 border-end">No</th>
                                <th rowspan="2" class="text-start border-end">Variabel / Tingkat Pendidikan</th>
                                <th colspan="2" class="border-end">Laki-laki</th>
                                <th colspan="2" class="border-end">Perempuan</th>
                                <th colspan="2" class="table-success">Total Penduduk</th>
                            </tr>
                            <tr>
                                <th><small>Jiwa</small></th>
                                <th class="border-end"><small>(%)</small></th>
                                <th><small>Jiwa</small></th>
                                <th class="border-end"><small>(%)</small></th>
                                <th class="table-success"><small>Jiwa</small></th>
                                <th class="table-success"><small>(%)</small></th>
                            </tr>
                        </thead>
                        <tbody class="text-center bg-white">
                            <?php
                            if ($result && mysqli_num_rows($result) > 0) {
                                $no = 1;
                                while($row = mysqli_fetch_assoc($result)) {
                                    
                                    // Highlight untuk baris 1 dan 2 (Kesimpulan/Total Usia 15+)
                                    $is_highlight = ($row['id'] == 1 || $row['id'] == 2) ? 'bg-light fw-bold text-dark' : '';
                                    $text_start_class = ($row['id'] == 1 || $row['id'] == 2) ? 'text-primary' : 'text-secondary';
                                    
                                    // Format angka ribuan
                                    $jml_l = $row["jumlah_laki_laki"] ? number_format($row["jumlah_laki_laki"], 0, ',', '.') : '0';
                                    $jml_p = $row["jumlah_perempuan"] ? number_format($row["jumlah_perempuan"], 0, ',', '.') : '0';
                                    $tot_penduduk = $row["jumlah_total"] ? number_format($row["jumlah_total"], 0, ',', '.') : '0';
                                    
                                    // Format desimal persentase
                                    $persen_l = $row["persentase_laki_laki"] ? number_format($row["persentase_laki_laki"], 2, ',', '.') : '0,00';
                                    $persen_p = $row["persentase_perempuan"] ? number_format($row["persentase_perempuan"], 2, ',', '.') : '0,00';
                                    $persen_tot = $row["persentase_total"] ? number_format($row["persentase_total"], 2, ',', '.') : '0,00';

                                    echo "<tr class='{$is_highlight}'>";
                                    echo "<td class='text-secondary border-end'>" . $no++ . "</td>";
                                    echo "<td class='fw-bold {$text_start_class} text-start ps-3 border-end'>" . htmlspecialchars($row["variabel"]) . "</td>";
                                    
                                    // Laki-laki
                                    echo "<td>{$jml_l}</td>";
                                    echo "<td class='text-muted small border-end'>{$persen_l}%</td>";
                                    
                                    // Perempuan
                                    echo "<td>{$jml_p}</td>";
                                    echo "<td class='text-muted small border-end'>{$persen_p}%</td>";
                                    
                                    // Total
                                    echo "<td class='text-success fw-bold bg-success bg-opacity-10'>{$tot_penduduk}</td>";
                                    echo "<td class='text-success fw-bold bg-success bg-opacity-10 small'>{$persen_tot}%</td>";
                                    
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center py-4 text-muted fst-italic'>Data melek huruf & pendidikan tidak ditemukan.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 text-muted small fst-italic">
                    * Persentase dihitung berdasarkan total populasi penduduk berumur 15 tahun ke atas.
                </div>
            </div>
            
        </div>
    </div>
</div>