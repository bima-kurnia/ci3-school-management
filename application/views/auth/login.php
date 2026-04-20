<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — School Management System</title>

    <!-- Bootstrap 3 (AdminLTE uses Bootstrap 3) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.8/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            background: #1a1a2e;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-box {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }
        .login-logo {
            text-align: center;
            margin-bottom: 25px;
        }
        .login-logo h2 {
            color: #1a1a2e;
            font-weight: 700;
        }
        .login-logo span {
            color: #e94560;
        }
        .btn-login {
            background: #e94560;
            color: #fff;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn-login:hover {
            background: #c73652;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="login-box">
    <div class="login-logo">
        <i class="fa fa-graduation-cap fa-3x" style="color:#e94560;"></i>
        <h2>School<span>MS</span></h2>
        <p class="text-muted">School Management System</p>
    </div>

    <!-- Flash Message -->
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <i class="fa fa-warning"></i>
            <?= $this->session->flashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Login Form -->
    <?= form_open('auth/login') ?>

        <div class="form-group <?= form_error('username') ? 'has-error' : '' ?>">
            <label>Username</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text"
                       name="username"
                       class="form-control"
                       placeholder="Enter username"
                       value="<?= set_value('username') ?>">
            </div>
            
            <?php if (form_error('username')): ?>
                <span class="help-block"><?= form_error('username') ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group <?= form_error('password') ? 'has-error' : '' ?>">
            <label>Password</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Enter password">
            </div>

            <?php if (form_error('password')): ?>
                <span class="help-block"><?= form_error('password') ?></span>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-login">
            <i class="fa fa-sign-in"></i> Login
        </button>

    <?= form_close() ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>