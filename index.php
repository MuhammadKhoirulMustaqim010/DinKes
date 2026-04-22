<?php
// index.php
session_start();

// Panggil koneksi database
include "config/koneksi.php";

// Default halaman langsung ke demografi_sragen_2025
$halaman = isset($_GET['page']) ? $_GET['page'] : 'demografi_sragen_2025';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Data Kesehatan - Dinkes Sragen</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="assets/style.css?v=<?= time(); ?>">
</head>
<body>

    <div class="wrapper">
        
        <nav id="sidebar">
            <div class="sidebar-header">
                <h5 class="fw-bold m-0 d-flex align-items-center text-white">
                    <i class="bi bi-plus-square-fill text-primary me-2 fs-4"></i> Dinkes Sragen
                </h5>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="index.php?page=demografi_sragen_2025" class="<?= ($halaman == 'demografi_sragen_2025') ? 'active' : ''; ?>">
                        <i class="bi bi-graph-up me-3"></i>Demografi Sragen
                    </a>
                </li>
                <li>
                    <a href="index.php?page=demografi_umur_sragen" class="<?= ($halaman == 'demografi_umur_sragen') ? 'active' : ''; ?>">
                        <i class="bi bi-hospital me-3"></i>Demografi Umur
                    </a>
                </li>
                <li>
                    <a href="index.php?page=melek_huruf_pend_sragen" class="<?= ($halaman == 'melek_huruf_pend_sragen') ? 'active' : ''; ?>">
                        <i class="bi bi-journal-text me-3"></i>Melek Huruf & Pendidikan
                    </a>
                </li>
                <li>
                    <a href="index.php?page=fasilitas_mnrt_kepemilikan" class="<?= ($halaman == 'fasilitas_mnrt_kepemilikan') ? 'active' : ''; ?>">
                        <i class="bi bi-building me-3"></i>Fasilitas Kesehatan
                    </a>
                </li>
                <li>
                    <a href="index.php?page=kematian_pasien_rs_sragen" class="<?= ($halaman == 'kematian_pasien_rs_sragen') ? 'active' : ''; ?>">
                        <i class="bi bi-emoji-frown-fill me-3"></i>Kematian Pasien RS
                    </a>
                </li>
                <li>
                    <a href="index.php?page=indikator_kinerja_rs_sragen" class="<?= ($halaman == 'indikator_kinerja_rs_sragen') ? 'active' : ''; ?>">
                        <i class="bi bi-people-fill me-3"></i>Indikator Kinerja RS
                    </a>
                </li>
                <li>
                    <a href="index.php?page=penyakit_rawat_jalan" class="<?= ($halaman == 'penyakit_rawat_jalan') ? 'active' : ''; ?>">
                        <i class="bi bi-clipboard2-pulse-fill me-3"></i>Penyakit Rawat Jalan
                    </a>
                </li>
                <li>
                    <a href="index.php?page=penyakit_rawat_inap" class="<?= ($halaman == 'penyakit_rawat_inap') ? 'active' : ''; ?>">
                        <i class="bi bi-hospital-fill me-3"></i>Penyakit Rawat Inap
                    </a>
                </li>
                <li>
                    <a href="index.php?page=fatalitas_rawat_inap" class="<?= ($halaman == 'fatalitas_rawat_inap') ? 'active' : ''; ?>">
                        <i class="bi bi-exclamation-triangle-fill me-3"></i>Fatalitas Rawat Inap
                    </a>
                </li>
            </ul>
        </nav>

        <div id="content">
            <div class="top-navbar mb-4">
                <div class="d-flex align-items-center">
                    <span class="me-4 text-muted fw-medium">
                        <i class="bi bi-calendar3 me-2"></i> <?= date('d M Y'); ?>
                    </span>
                </div>
            </div>

            <div class="container-fluid px-4">
                <?php
                switch ($halaman) {
                    case 'demografi_sragen_2025':
                        include "pages/demografi_sragen_2025.php";
                        break;

                    case 'demografi_umur_sragen':
                        include "pages/demografi_umur_sragen.php";
                        break;

                    case 'melek_huruf_pend_sragen':
                        include "pages/melek_huruf_pend_sragen.php";
                        break;

                    case 'fasilitas_mnrt_kepemilikan':
                        include "pages/fasilitas_kesehatan_mnrt_kepemilikan.php";
                        break;

                    case 'kematian_pasien_rs_sragen':
                        include "pages/kematian_pasien_rs_sragen.php";
                        break;

                    case 'indikator_kinerja_rs_sragen':
                        include "pages/indikator_kinerja_rs_sragen.php";
                        break;

                    case 'penyakit_rawat_jalan':
                        include "pages/penyakit_rawat_jalan.php";
                        break;

                    case 'penyakit_rawat_inap':
                        include "pages/penyakit_rawat_inap.php";
                        break;
                    
                    case 'fatalitas_rawat_inap':
                        include "pages/fatalitas_rawat_inap.php";
                        break;

                    default:
                        include "pages/demografi_sragen_2025.php"; // Default ke halaman demografi
                        break;
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>