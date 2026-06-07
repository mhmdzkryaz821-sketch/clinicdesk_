<?php require_once __DIR__ . '/../../config/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>403 Access Denied</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
    <div class="text-center">
        <h1 class="display-1 text-danger font-weight-bold">403</h1>
        <h2>Access Denied!</h2>
        <p class="lead">You do not have permission to access this page.</p>
        <a href="<?php echo BASE_URL; ?>views/auth/login.php" class="btn btn-primary">Back to Login</a>
    </div>
</body>
</html>