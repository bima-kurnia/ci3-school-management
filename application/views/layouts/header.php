<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' — SchoolMS' : 'SchoolMS' ?></title>

    <!-- Bootstrap 3 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.6/sweetalert2.min.css">

    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', sans-serif; }

        /* Sidebar */
        .sidebar { background: #1a1a2e; min-height: 100vh; width: 240px;
                   position: fixed; top: 0; left: 0; z-index: 999; padding-top: 0; }
        .sidebar-brand { background: #e94560; padding: 18px 20px; display: block;
                         color: #fff; font-size: 20px; font-weight: 700; text-decoration: none; }
        .sidebar-brand:hover { color: #fff; text-decoration: none; }
        .sidebar ul { list-style: none; padding: 10px 0; margin: 0; }
        .sidebar ul li a { display: block; padding: 12px 20px; color: #adb5bd;
                           text-decoration: none; font-size: 14px; transition: all .2s; }
        .sidebar ul li a:hover, .sidebar ul li a.active {
            background: #e94560; color: #fff; padding-left: 28px; }
        .sidebar ul li a i { margin-right: 10px; width: 16px; }
        .sidebar-section { color: #6c757d; font-size: 11px; text-transform: uppercase;
                           padding: 15px 20px 5px; letter-spacing: 1px; }

        /* Main content */
        .main-wrapper { margin-left: 240px; }
        .top-navbar { background: #fff; padding: 12px 25px; border-bottom: 1px solid #e9ecef;
                      display: flex; justify-content: space-between; align-items: center; }
        .top-navbar .page-title { font-size: 18px; font-weight: 600; color: #1a1a2e; margin: 0; }
        .top-navbar .user-info { display: flex; align-items: center; gap: 15px; }
        .top-navbar .user-info span { color: #6c757d; font-size: 14px; }
        .top-navbar .btn-logout { background: #e94560; color: #fff; border: none;
                                   padding: 6px 15px; border-radius: 4px; font-size: 13px; }
        .top-navbar .btn-logout:hover { background: #c73652; }
        .content-area { padding: 25px; }

        /* Cards */
        .stat-card { background: #fff; border-radius: 8px; padding: 20px;
                     box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid; }
        .stat-card.red { border-color: #e94560; }
        .stat-card.blue { border-color: #3498db; }
        .stat-card.green { border-color: #27ae60; }
        .stat-card.orange { border-color: #f39c12; }
        .stat-card .stat-number { font-size: 32px; font-weight: 700; color: #1a1a2e; }
        .stat-card .stat-label { color: #6c757d; font-size: 13px; margin-top: 5px; }
        .stat-card .stat-icon { font-size: 36px; opacity: 0.15; float: right; margin-top: -10px; }

        /* Table card */
        .card { background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);
                margin-bottom: 25px; }
        .card-header { padding: 15px 20px; border-bottom: 1px solid #f0f0f0;
                       display: flex; justify-content: space-between; align-items: center; }
        .card-header h4 { margin: 0; font-size: 16px; font-weight: 600; color: #1a1a2e; }
        .card-body { padding: 20px; }

        /* Buttons */
        .btn-add { background: #e94560; color: #fff; border: none; border-radius: 5px; padding: 8px 18px; }
        .btn-add:hover { background: #c73652; color: #fff; }

        /* Alert flash */
        .flash-message { margin-bottom: 20px; }

        /* 1. Reset Total Pembungkus Luar */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
        }

        /* 2. Styling Hanya untuk Tombol/Link di Dalamnya */
        .dataTables_wrapper .dataTables_paginate .paginate_button a, 
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            display: inline-block !important;
            padding: 6px 12px !important;
            border: 1px solid #dee2e6 !important;
            color: #0d6efd !important;
            background-color: #fff !important;
            text-decoration: none !important;
            border-radius: 4px; /* Opsional: beri radius */
            margin: 0 2px; /* Memberi jarak antar kotak agar tidak menempel */
        }

        /* 3. Warna saat Halaman Aktif (Current) */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #0d6efd !important;
            color: white !important;
            border-color: #0d6efd !important;
        }

        /* 4. Hover Effect */
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover a,
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #e9ecef !important;
            color: #0a58ca !important;
        }

        /* 5. Hilangkan efek hover biru bawaan DataTables yang sering bikin garis double */
        .dataTables_wrapper .dataTables_paginate .paginate_button:active {
            background: none !important;
            box-shadow: none !important;
        }

        /* Menargetkan wrapper yang membungkus informasi (kiri) dan pagination (kanan) */
        .dataTables_wrapper .dataTables_paginate {
            display: flex !important;
            justify-content: flex-end !important;
            float: none !important; /* Menghapus float lama jika ada */
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <a href="<?= site_url('dashboard') ?>" class="sidebar-brand">
        <i class="fa fa-graduation-cap"></i> SchoolMS
    </a>

    <ul>
        <li><a href="<?= site_url('dashboard') ?>"
               class="<?= ($this->uri->segment(1) === 'dashboard') ? 'active' : '' ?>">
            <i class="fa fa-dashboard"></i> Dashboard
        </a></li>

        <?php if ($current_user->role === 'admin'): ?>
        <div class="sidebar-section">Academic</div>
        <li><a href="<?= site_url('students') ?>"
               class="<?= ($this->uri->segment(1) === 'students') ? 'active' : '' ?>">
            <i class="fa fa-user-circle"></i> Students
        </a></li>
        
        <li><a href="<?= site_url('teachers') ?>"
               class="<?= ($this->uri->segment(1) === 'teachers') ? 'active' : '' ?>">
            <i class="fa fa-user"></i> Teachers
        </a></li>

        <li><a href="<?= site_url('classes') ?>"
               class="<?= ($this->uri->segment(1) === 'classes') ? 'active' : '' ?>">
            <i class="fa fa-building"></i> Classes
        </a></li>

        <li><a href="<?= site_url('subjects') ?>"
       class="<?= ($this->uri->segment(1) === 'subjects') ? 'active' : '' ?>">
            <i class="fa fa-book"></i> Subjects
        </a></li>

        <li><a href="<?= site_url('class_subjects') ?>"
               class="<?= ($this->uri->segment(1) === 'class_subjects') ? 'active' : '' ?>">
            <i class="fa fa-sitemap"></i> Class Subjects
        </a></li>

        <div class="sidebar-section">Attendance</div>
        <li><a href="<?= site_url('attendance') ?>"
               class="<?= ($this->uri->segment(1) === 'attendance') ? 'active' : '' ?>">
            <i class="fa fa-calendar"></i> Attendance
        </a></li>
        <?php endif; ?>
    </ul>
</div>

<!-- Main Wrapper -->
<div class="main-wrapper">
    <!-- Top Navbar -->
    <div class="top-navbar">
        <h4 class="page-title">
            <i class="fa fa-<?= isset($icon) ? $icon : 'dashboard' ?>"></i>
            <?= isset($title) ? $title : 'Dashboard' ?>
        </h4>
        <div class="user-info">
            <span><i class="fa fa-user-circle"></i>
                <?= $current_user->username ?>
                |
                <span class="label label-danger"><?= $current_user->role ?></span>
            </span>
            <a href="<?= site_url('auth/logout') ?>" class="btn-logout">
                <i class="fa fa-sign-out"></i> Logout
            </a>
        </div>
    </div>

    <!-- Content Area -->
    <div class="content-area">

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible flash-message" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <i class="fa fa-check-circle"></i> <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible flash-message" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <i class="fa fa-warning"></i> <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>