<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $apps['judul_login'] ?></title>
    <?php $this->load->view('template/css'); ?>
</head>
<?php $this->load->view('template/js'); ?>
<style>
    .elevation-4 {
        box-shadow: 0 5px 40px -10px rgba(124, 58, 237, 0.33) !important;
    }

    .main-header.navbar {
        background-color: #4c1d95;
        border-bottom: 1px solid #3b0764 !important;
    }

    .main-header.navbar .nav-link {
        color: #ffffff;
    }

    .main-header.navbar .nav-link:hover,
    .main-header.navbar .nav-link:focus {
        color: #f5f3ff;
    }

    a {
        color: #4c1d95;
    }

    a:hover,
    a:focus {
        color: #7c3aed;
    }

    .page-link {
        color: #4c1d95;
    }

    .page-link:hover,
    .page-link:focus {
        color: #4c1d95;
        background-color: #f5f3ff;
        border-color: #c4b5fd;
        box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, .18);
    }

    .page-item.active .page-link {
        background-color: #4c1d95;
        border-color: #4c1d95;
        color: #ffffff;
    }

    .dt-buttons.btn-group.flex-wrap .btn,
    .dt-buttons .btn {
        background-color: #4c1d95;
        border-color: #4c1d95;
        color: #ffffff;
    }

    .dt-buttons.btn-group.flex-wrap .btn:hover,
    .dt-buttons.btn-group.flex-wrap .btn:focus,
    .dt-buttons .btn:hover,
    .dt-buttons .btn:focus {
        background-color: #3b0764;
        border-color: #3b0764;
        color: #ffffff;
        box-shadow: 0 0 0 0.2rem rgba(76, 29, 149, .22);
    }

    .card.card-secondary>.card-header {
        background-color: #4c1d95;
        border-color: #4c1d95;
        color: #ffffff;
    }

    .card.card-secondary>.card-header .card-title,
    .card.card-secondary>.card-header .btn-tool {
        color: #ffffff;
    }

    .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active,
    .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active:hover {
        background-color: #7c3aed;
        color: #ffffff;
    }

    .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active .nav-icon {
        color: #ffffff;
    }

    .nav-header-approval {
        color: #f97316 !important;
        font-weight: 700;
        letter-spacing: 0;
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed text-sm" id="colapse">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= base_url('assets/dist/img/recycle.png') ?>" alt="recycle" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom-0">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">

                    <a href="<?= base_url('dashboard') ?>" class="nav-link">Hai, <?= $this->session->userdata('name') ?></a>
                </li>
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> -->
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('auth/logout') ?>" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link border-bottom-0">
                <img src="<?= base_url('assets/dist/img/' . $apps['logo']) ?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?= $apps['judul_login'] ?></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-header">DASHBOARD</li>
                        <?php if (in_array($this->session->userdata('role_id'), [1, 2, 3, 4, 5])) : ?>
                            <li class="nav-item">
                                <a href="<?= base_url('dashboard') ?>" class="nav-link <?= ($sess_menu == "dashboard") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                        <span class="right badge badge-danger total-pesan-open"></span>
                                    </p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (in_array($this->session->userdata('role_id'), [1, 2, 3, 4, 5])) : ?>
                            <li class="nav-item">
                                <a href="<?= base_url('dashboard/kotak_masuk') ?>" class="nav-link <?= ($sess_menu == "kotak_masuk") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-inbox"></i>
                                    <p>
                                        Kotak Masuk
                                    </p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (in_array($this->session->userdata('role_id'), [1, 2, 4])) : ?>
                            <li class="nav-item">
                                <a href="<?= base_url('dashboard/agenda_surat') ?>" class="nav-link <?= ($sess_menu == "agenda_surat") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-calendar-week"></i>
                                    <p>
                                        Agenda Naskah<span class="badge badge-danger angka_agenda right">2</span>
                                    </p>
                                </a>
                            </li>
                        <?php endif; ?>


                        <?php if (in_array($this->session->userdata('role_id'), [1, 2, 3, 4, 5])) : ?>
                            <li class="nav-item">
                                <a href="<?= base_url('dashboard/disposisi') ?>" class="nav-link <?= ($sess_menu == "disposisi") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-paper-plane"></i>
                                    <p>
                                        List Disposisi
                                    </p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (in_array($this->session->userdata('role_id'), [1, 2, 3, 4, 5])) : ?>
                            <li class="nav-item">
                                <a href="<?= base_url('dashboard/monitoring_naskah') ?>" class="nav-link <?= ($sess_menu == "monitoring_naskah") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-search"></i>
                                    <p>
                                        Monitoring Naskah
                                    </p>
                                </a>
                            </li>
                        <?php endif; ?>

                        

                        <?php if (in_array($this->session->userdata('role_id'), [1, 2, 4])) : ?>
                            <li class="nav-header">MASTER</li>
                            <li class="nav-item">
                                <a href="<?= base_url('dashboard/indeks') ?>" class="nav-link  <?= ($sess_menu == "indeks") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Indeks Naskah
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= base_url('dashboard/unit') ?>" class="nav-link  <?= ($sess_menu == "unit") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-briefcase"></i>
                                    <p>
                                        Unit Kerja
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= base_url('dashboard/user') ?>" class="nav-link  <?= ($sess_menu == "user") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Users
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= base_url('dashboard/user_role') ?>" class="nav-link  <?= ($sess_menu == "user_role") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-user-tag"></i>
                                    <p>
                                        User Role
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= base_url('dashboard/template_approval') ?>" class="nav-link  <?= ($sess_menu == "template_approval") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-user-check"></i>
                                    <p>
                                        Template Approval
                                    </p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (in_array($this->session->userdata('role_id'), [1, 2, 4])) : ?>
                            <li class="nav-header">REGISTRASI</li>
                            <li class="nav-item">
                                <a href="<?= base_url('dashboard/surat_masuk') ?>" class="nav-link  <?= ($sess_menu == "surat_masuk") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-envelope-open-text"></i>
                                    <p>
                                        Naskah Masuk
                                    </p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (in_array($this->session->userdata('role_id'), [1, 2, 4])) : ?>
                            <li class="nav-item">
                                <a href="<?= base_url('dashboard/surat_keluar') ?>" class="nav-link  <?= ($sess_menu == "surat_keluar") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-envelope"></i>
                                    <p>
                                        Naskah Keluar
                                    </p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (in_array($this->session->userdata('role_id'), [1, 2, 3, 4, 5])) : ?>
                            <li class="nav-item">
                                <a href="<?= base_url('dashboard/approval_naskah_keluar') ?>" class="nav-link  <?= ($sess_menu == "approval_naskah_keluar") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-check-circle"></i>
                                    <p>
                                        Approval Naskah Keluar
                                    </p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-header nav-header-approval">Dokumen Approval</li>
                        <?php if (in_array($this->session->userdata('role_id'), [1, 2, 4])) : ?>
                            <li class="nav-item">
                                <a href="<?= base_url('dashboard/dokumen_approval_pengajuan') ?>" class="nav-link  <?= ($sess_menu == "dokumen_approval_pengajuan") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-file-signature"></i>
                                    <p>Pengajuan Dokumen</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= base_url('dashboard/dokumen_approval_flow') ?>" class="nav-link  <?= ($sess_menu == "dokumen_approval_flow") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-project-diagram"></i>
                                    <p>Setting Flow Approval</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= base_url('dashboard/dokumen_approval_report') ?>" class="nav-link  <?= ($sess_menu == "dokumen_approval_report") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-chart-bar"></i>
                                    <p>Report Approval</p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (in_array($this->session->userdata('role_id'), [1, 2, 3, 4, 5])) : ?>
                            <li class="nav-item">
                                <a href="<?= base_url('dashboard/dokumen_approval_saya') ?>" class="nav-link  <?= ($sess_menu == "dokumen_approval_saya") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-clipboard-check"></i>
                                    <p>Approval Saya</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= base_url('dashboard/dokumen_approval_scan') ?>" class="nav-link  <?= ($sess_menu == "dokumen_approval_scan") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-qrcode"></i>
                                    <p>Scan QR Approval</p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- <?php if (in_array($this->session->userdata('role_id'), [1, 2, 4])) : ?>
                            <li class="nav-header">DISPOSISI</li>
                            <li class="nav-item">
                                <a href="<?= base_url('dashboard/setorsampah') ?>" class="nav-link  <?= ($sess_menu == "setorsampah") ? "active" : ""; ?>">
                                    <i class="nav-icon fas fa-mail-bulk"></i>
                                    <p>
                                        Surat Masuk
                                    </p>
                                </a>
                            </li>
                        <?php endif; ?> -->


                        <li class="nav-header">SETTING</li>
                        <li class="nav-item">
                            <a href="<?= base_url('dashboard/change') ?>" class="nav-link <?= ($sess_menu == "change") ? "active" : ""; ?>">
                                <i class="nav-icon fas fa-user-lock"></i>
                                <p>
                                    Ubah Password
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('auth/logout') ?>" class="nav-link">
                                <i class="nav-icon fas fa-power-off"></i>
                                <p>
                                    Keluar
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <script>
            $(function() {
                $.ajax({
                    url: '<?= base_url('dashboard/getcountagenda') ?>',
                    dataType: 'json',
                    success: function(result) {
                        console.log(result)
                        html = result;
                        $('.angka_agenda').html(html)
                    }
                });
            });

            function get_total_pesan_open() {
                $.ajax({
                    url: '',
                    data: {},
                    type: 'post',
                    dataType: 'json',
                    success: function(result) {}
                })
            }
        </script>
