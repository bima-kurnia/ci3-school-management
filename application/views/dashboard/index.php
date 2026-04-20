<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard — SchoolMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body { background: #f4f6f9; }
        .navbar { background: #1a1a2e; border: none; border-radius: 0; }
        .navbar-brand, .navbar-nav > li > a { color: #fff !important; }
        .navbar-nav > li > a:hover { background: #e94560 !important; }
        .welcome-box {
            background: #fff;
            border-radius: 8px;
            padding: 40px;
            margin-top: 30px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .role-badge {
            background: #e94560;
            color: #fff;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 13px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <span class="navbar-brand">
                <i class="fa fa-graduation-cap"></i> SchoolMS
            </span>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="<?= site_url('auth/logout') ?>">
                    <i class="fa fa-sign-out"></i> Logout (<?= $current_user->username ?>)
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- Content -->
<div class="container">
    <div class="welcome-box">
        <i class="fa fa-check-circle fa-4x" style="color:#27ae60;"></i>
        <h2>Login Successful!</h2>
        <p>Welcome back, <strong><?= $current_user->username ?></strong></p>
        <span class="role-badge"><?= $current_user->role ?></span>
        <p class="text-muted" style="margin-top:15px;">
            More modules coming in the next steps...
        </p>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>