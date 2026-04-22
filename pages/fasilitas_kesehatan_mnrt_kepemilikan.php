<?php

// Ambil data fasilitas pelayanan
$sql = "SELECT * FROM fasilitas_peyalanan_menurut_kepemilikan ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
?>

<style>
    /* Perbaikan Scroll dan Sticky Header */
    .table-custom-wrap { 
        max-height: 70vh; 
        overflow-y: auto; 
        overflow-x: auto; 
    }
    
    /* Membuat Header Tetap Di Atas Saat di-Scroll ke Bawah */
    .table-custom-wrap thead tr:first-child th { 
        position: sticky; 
        top: 0; 
        z-index: 2; 
    }
    .table-custom-wrap thead tr:nth-child(2) th { 
        position: sticky; 
        top: 37px; /* Menyesuaikan tinggi baris pertama */
        z-index: 3; 
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold text-dark m-0">Fasilitas Pelayanan Menurut Kepemilikan</h3>
      <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle shadow-sm fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-download me-2"></i> Export Data
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0">
              <li><h6 class="dropdown-header text-uppercase">Pilih Format</h6></li>
              <li><a class="dropdown-item py-2" href="exports/export_fasilitas.php?type=excel"><i class="bi bi-file-earmark-excel-fill text-success me-2"></i> Export Excel</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_fasilitas.php?type=csv"><i class="bi bi-filetype-csv text-secondary me-2"></i> Export CSV</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_fasilitas.php?type=pdf" target="_blank"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i> Export PDF</a></li>
              <li><a class="dropdown-item py-2" href="exports/export_fasilitas.php?type=json" target="_blank"><i class="bi bi-filetype-json text-warning me-2"></i> Export JSON</a></li>
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
                    <i class="bi bi-hospital text-info me-2"></i> Kabupaten Sragen
                </h5>
            </div>

            <div class="card-body p-3 p-md-4">
                <div class="table-responsive table-custom-wrap border rounded shadow-sm mb-3">
                    <table class="table table-hover table-bordered align-middle mb-0 text-nowrap" style="font-size: 0.85rem;">
                        
                        <thead class="table-info text-center align-middle border-dark">
                            <tr>
                                <th rowspan="2" width="3%" class="py-3 border-end">No</th>
                                <th rowspan="2" width="15%" class="border-end">Kategori</th>
                                <th rowspan="2" class="text-start border-end">Fasilitas Kesehatan</th>
                                <th colspan="8" class="border-end border-bottom">Kepemilikan / Instansi</th>
                                <th rowspan="2" class="table-primary border-start">Jumlah<br><small>(Unit)</small></th>
                            </tr>
                            <tr>
                              <th><small>Kemenkes</small></th>
                              <th><small>Pem. Prov</small></th>
                              <th><small>Pem. Kab/Kota</small></th>
                              <th><small>TNI / POLRI</small></th>
                              <th><small>K/L Lainnya</small></th>
                              <th><small>BUMN</small></th>
                              <th><small>Swasta</small></th>
                              <th class="border-end"><small>Ormas</small></th>
                            </tr>
                        </thead>
                        
                        <tbody class="text-center bg-white">
                            <?php
                            // Variabel untuk menampung Grand Total
                            $t_kemenkes = 0; $t_pemprov = 0; $t_pemkab = 0; $t_tni = 0;
                            $t_kl = 0;       $t_bumn = 0;    $t_swasta = 0; $t_ormas = 0;
                            $t_jumlah = 0;

                            if ($result && mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    
                                    // Ambil nilai, jika NULL jadikan 0 untuk perhitungan
                                    $kemenkes = $row['kemenkes'] ?? 0;
                                    $pemprov  = $row['pem_prov'] ?? 0;
                                    $pemkab   = $row['pem_kab_kota'] ?? 0;
                                    $tni      = $row['tni_polri'] ?? 0;
                                    $kl       = $row['kl_lainnya'] ?? 0;
                                    $bumn     = $row['bumn'] ?? 0;
                                    $swasta   = $row['swasta'] ?? 0;
                                    $ormas    = $row['organisasi_kemasyarakatan'] ?? 0;
                                    $jumlah   = $row['jumlah'] ?? 0;

                                    // Akumulasi Total Kabupaten
                                    $t_kemenkes += $kemenkes;
                                    $t_pemprov  += $pemprov;
                                    $t_pemkab   += $pemkab;
                                    $t_tni      += $tni;
                                    $t_kl       += $kl;
                                    $t_bumn     += $bumn;
                                    $t_swasta   += $swasta;
                                    $t_ormas    += $ormas;
                                    $t_jumlah   += $jumlah;

                                    // Fungsi kecil untuk menampilkan angka atau strip jika 0
                                    $v_kemenkes = ($kemenkes > 0) ? number_format($kemenkes, 0, ',', '.') : '-';
                                    $v_pemprov  = ($pemprov > 0) ? number_format($pemprov, 0, ',', '.') : '-';
                                    $v_pemkab   = ($pemkab > 0) ? number_format($pemkab, 0, ',', '.') : '-';
                                    $v_tni      = ($tni > 0) ? number_format($tni, 0, ',', '.') : '-';
                                    $v_kl       = ($kl > 0) ? number_format($kl, 0, ',', '.') : '-';
                                    $v_bumn     = ($bumn > 0) ? number_format($bumn, 0, ',', '.') : '-';
                                    $v_swasta   = ($swasta > 0) ? number_format($swasta, 0, ',', '.') : '-';
                                    $v_ormas    = ($ormas > 0) ? number_format($ormas, 0, ',', '.') : '-';
                                    $v_jumlah   = ($jumlah > 0) ? number_format($jumlah, 0, ',', '.') : '-';

                                    echo "<tr>";
                                    echo "<td class='text-muted border-end'>" . htmlspecialchars($row["no_urut"]) . "</td>";
                                    
                                    // Membuat kategori text-wrap agar tidak terlalu memanjang
                                    echo "<td class='text-start fw-bold text-secondary border-end text-wrap' style='min-width: 150px; font-size: 0.8rem;'>" . htmlspecialchars($row["kategori"]) . "</td>";
                                    
                                    // Kolom Fasilitas Kesehatan
                                    echo "<td class='text-start fw-bold text-dark border-end text-wrap' style='min-width: 250px;'>" . htmlspecialchars($row["fasilitas_kesehatan"]) . "</td>";
                                    
                                    echo "<td>{$v_kemenkes}</td>";
                                    echo "<td>{$v_pemprov}</td>";
                                    echo "<td>{$v_pemkab}</td>";
                                    echo "<td>{$v_tni}</td>";
                                    echo "<td>{$v_kl}</td>";
                                    echo "<td>{$v_bumn}</td>";
                                    echo "<td>{$v_swasta}</td>";
                                    echo "<td class='border-end'>{$v_ormas}</td>";
                                    
                                    echo "<td class='fw-bold text-primary bg-primary bg-opacity-10'>{$v_jumlah}</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='12' class='text-center py-5 text-muted fst-italic'>Data fasilitas pelayanan tidak ditemukan.</td></tr>";
                            }
                            ?>
                        </tbody>
                        
                        <tfoot class="position-sticky bottom-0 z-1">
                            <tr class="table-dark text-center fw-bold align-middle border-top border-2 border-dark">
                                <td colspan="3" class="py-3 text-middle pe-4 bg-dark text-white border-end">TOTAL KESELURUHAN</td>
                                
                                <td class="text-warning"><?= ($t_kemenkes > 0) ? number_format($t_kemenkes, 0, ',', '.') : '-' ?></td>
                                <td class="text-warning"><?= ($t_pemprov > 0) ? number_format($t_pemprov, 0, ',', '.') : '-' ?></td>
                                <td class="text-warning"><?= ($t_pemkab > 0) ? number_format($t_pemkab, 0, ',', '.') : '-' ?></td>
                                <td class="text-warning"><?= ($t_tni > 0) ? number_format($t_tni, 0, ',', '.') : '-' ?></td>
                                <td class="text-warning"><?= ($t_kl > 0) ? number_format($t_kl, 0, ',', '.') : '-' ?></td>
                                <td class="text-warning"><?= ($t_bumn > 0) ? number_format($t_bumn, 0, ',', '.') : '-' ?></td>
                                <td class="text-warning"><?= ($t_swasta > 0) ? number_format($t_swasta, 0, ',', '.') : '-' ?></td>
                                <td class="text-warning border-end"><?= ($t_ormas > 0) ? number_format($t_ormas, 0, ',', '.') : '-' ?></td>
                                
                                <td class="bg-primary text-white fs-6"><?= number_format($t_jumlah, 0, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                        
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>