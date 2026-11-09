<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - REGISTRASI SEMINAR</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/style.css">
</head>
<body class="login-page">
    <main class="login-card">
        <div class="brand-mark">RS</div>

        <h1>Registrasi Seminar</h1>
        <p class="muted">Silakan masuk untuk mengelola peserta.</p>

        <?php if (!empty($error)): ?>
            <div class="alert error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= BASE_URL ?>/login">
            <label for="username">Username</label>
            <input
                id="username"
                name="username"
                required
                autocomplete="username"
                value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
            >

            <label for="password">Your Password</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            >

            <button class="btn primary full" type="submit">Go</button>
        </form>

    </main>
</body>
</html>
