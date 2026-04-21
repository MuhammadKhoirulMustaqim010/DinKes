<?php

$sql = "SELECT * FROM demografi_umur_sragen ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold text-dark m-0">Data Penduduk Berdasarkan Kelompok Umur</h3>
    
    <?php if(isset($_SESSION['role']) && ($_SESSION['role'] == 1 || $_SESSION['role'] == 2)): ?>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle shadow-sm fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-download me-2"></i> Export Data
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li><h6 class="dropdown-header text-uppercase">Pilih Format</h6></li>
                <li><a class="dropdown-item py-2" href="exports/export_umur.php?type=excel"><i class="bi bi-file-earmark-excel-fill text-success me-2"></i> Export Excel</a></li>
                <li><a class="dropdown-item py-2" href="exports/export_umur.php?type=csv"><i class="bi bi-filetype-csv text-secondary me-2"></i> Export CSV</a></li>
                <li><a class="dropdown-item py-2" href="exports/export_umur.php?type=pdf" target="_blank"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i> Export PDF</a></li>
                <li><a class="dropdown-item py-2" href="exports/export_umur.php?type=json" target="_blank"><i class="bi bi-filetype-json text-warning me-2"></i> Export JSON</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item py-2" href="javascript:window.print()"><i class="bi bi-printer-fill text-dark me-2"></i> Cetak Halaman</a></li>
            </ul>
        </div>
    <?php endif; ?>
</div>

<div class="row justify-content-center mb-5">
    <div class="col-md-12"> 
        <div class="card shadow-sm border-0 rounded-4">
            
            <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <h5 class="fw-bold text-dark m-0 mb-2 mb-md-0">
                    <i class="bi bi-bar-chart-steps text-primary me-2"></i> Kabupaten Sragen 2025
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive rounded border">
                    <table class="table table-hover table-striped align-middle mb-0" style="font-size: 0.95rem;">
                        <thead class="table-primary text-center align-middle">
                            <tr>
                                <th width="5%" class="py-3">No</th>
                                <th>Kelompok Umur<br><small class="fw-normal text-muted">(Tahun)</small></th>
                                <th>Laki-laki<br><small class="fw-normal text-muted">(Jiwa)</small></th>
                                <th>Perempuan<br><small class="fw-normal text-muted">(Jiwa)</small></th>
                                <th class="table-success">Total Penduduk<br><small class="fw-normal text-success">(Jiwa)</small></th>
                                <th>Rasio Jenis<br>Kelamin</th>
                            </tr>
                        </thead>
                        <tbody class="text-center bg-white">
                            <?php
                            // Variabel untuk menampung total
                            $tot_l = 0; 
                            $tot_p = 0; 
                            $tot_all = 0;

                            if ($result && mysqli_num_rows($result) > 0) {
                                $no = 1;
                                while($row = mysqli_fetch_assoc($result)) {
                                    
                                    // Format angka ribuan
                                    $jml_l = $row["jumlah_laki_laki"] ? number_format($row["jumlah_laki_laki"], 0, ',', '.') : '0';
                                    $jml_p = $row["jumlah_perempuan"] ? number_format($row["jumlah_perempuan"], 0, ',', '.') : '0';
                                    $tot_penduduk = $row["total_penduduk"] ? number_format($row["total_penduduk"], 0, ',', '.') : '0';
                                    $rasio = $row["rasio_jenis_kelamin"] ? number_format($row["rasio_jenis_kelamin"], 1, ',', '.') : '-';

                                    // Hitung Akumulasi Total
                                    $tot_l += $row["jumlah_laki_laki"];
                                    $tot_p += $row["jumlah_perempuan"];
                                    $tot_all += $row["total_penduduk"];

                                    echo "<tr>";
                                    echo "<td class='text-secondary border-end-0'>" . $no++ . "</td>";
                                    echo "<td class='fw-bold text-dark text-start ps-4'><i class='bi bi-person-bounding-box text-secondary me-2'></i>" . htmlspecialchars($row["kelompok_umur"]) . "</td>";
                                    echo "<td>{$jml_l}</td>";
                                    echo "<td>{$jml_p}</td>";
                                    echo "<td class='text-success fw-bold bg-success bg-opacity-10'>{$tot_penduduk}</td>";
                                    echo "<td class='text-primary fw-bold'>{$rasio}</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center py-4 text-muted fst-italic'>Data kelompok umur tidak ditemukan.</td></tr>";
                            }
                            ?>
                        </tbody>
                        
                        <tfoot>
                            <tr class="table-dark text-center fw-bold align-middle">
                                <td colspan="2" class="py-3 text-end pe-4">GRAND TOTAL KABUPATEN</td>
                                <td class="text-warning"><?= number_format($tot_l, 0, ',', '.') ?></td>
                                <td class="text-warning"><?= number_format($tot_p, 0, ',', '.') ?></td>
                                <td class="bg-success text-white fs-6"><?= number_format($tot_all, 0, ',', '.') ?></td>
                                <td>-</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>