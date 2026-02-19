<?php
/**
 * admin/login.php – Admin Login Page
 */

session_start();
require_once '../config/db.php';

// Already logged in?
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']    ?? '');
    $password =      $_POST['password'] ?? '';

    if (!$email || !$password) {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        try {
            $db = getDB();
            $stmt = $db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['admin_id']   = $user['id'];
                $_SESSION['admin_name'] = $user['name'];
                header('Location: dashboard.php');
                exit;
            } else {
                $error = 'Invalid email or password.';
            }
        } catch (PDOException $e) {
            $error = 'Server error. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Saiwak Ram Portfolio</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { min-height: 100vh; display: flex; align-items: center; background: var(--gradient-hero); justify-content: center; }
        .login-card { width: 100%; max-width: 420px; background: var(--glass-bg); border: 1px solid var(--glass-border); backdrop-filter: blur(24px); border-radius: var(--radius); padding: 44px 38px; box-shadow: var(--shadow); }
        .login-brand { text-align: center; margin-bottom: 36px; }
        .login-brand .logo { font-size: 2rem; font-weight: 800; background: var(--gradient-1); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .login-brand p { color: var(--text-secondary); font-size: .88rem; margin-top: 4px; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-brand">
            <div class="logo">SR<span style="-webkit-text-fill-color:var(--accent-2);">.</span></div>
            <p>Admin Panel – Saiwak Ram</p>
        </div>

        <?php if ($error) : ?>
        <div class="alert" style="background:rgba(255,101,132,.15);border:1px solid rgba(255,101,132,.3);color:var(--accent-2);border-radius:10px;padding:12px 16px;font-size:.88rem;margin-bottom:20px;" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="login.php" novalidate>
            <div class="form-group">
                <label class="form-label-custom" for="email">
                    <i class="bi bi-envelope me-1"></i> Email Address
                </label>
                <input type="email" id="email" name="email" class="form-control-custom"
                       placeholder="admin@example.com" required
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
            <div class="form-group mt-3">
                <label class="form-label-custom" for="password">
                    <i class="bi bi-lock me-1"></i> Password
                </label>
                <div style="position:relative;">
                    <input type="password" id="password" name="password" class="form-control-custom"
                           placeholder="••••••••" required style="padding-right:48px;">
                    <button type="button" id="pass-toggle"
                            style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--text-secondary);cursor:pointer;font-size:1rem;"
                            aria-label="Toggle password visibility">
                        <i class="bi bi-eye" id="pass-icon"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn-primary-custom w-100 justify-content-center mt-4">
                <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
            </button>
        </form>

        <p class="text-center mt-4" style="font-size:.8rem;color:var(--text-secondary);">
            <a href="../index.php" style="color:var(--accent);">
                <i class="bi bi-arrow-left me-1"></i>Back to Portfolio
            </a>
        </p>
        <p class="text-center" style="font-size:.75rem;color:var(--text-secondary);margin-top:6px;">
            Default: saiwakram786pur@gmail.com / Admin@1234
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('pass-toggle').addEventListener('click', function(){
            const input = document.getElementById('password');
            const icon  = document.getElementById('pass-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        });
    </script>
</body>
</html>
