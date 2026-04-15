<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/server/assets/css/login.css">
    <title>Авторизация - Library</title>
</head>
<body>
    <div class="wrapper">
        <div class="auth-card">
            <h2 class="auth-title">Авторизация</h2>

            <?php if (isset($message) && $message): ?>
                <div class="message message-error"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <?php if (app()->auth->user()): ?>
                <div class="user-info">
                    <?= htmlspecialchars(app()->auth->user()->name) ?>
                </div>
            <?php endif; ?>

            <?php if (!app()->auth::check()): ?>
                <form method="post" class="form-group">
                    <div class="form">
                        <input type="text" name="login" placeholder="логин" required autocomplete="username">
                        <input type="password" name="password" placeholder="пароль" required autocomplete="current-password">
                    </div>
                    <button type="submit" class="btn-submit">Войти</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>