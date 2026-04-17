<div class="card">
    <h2 class="title">Авторизация</h2>

    <?php if (isset($message) && $message): ?>
        <div class="message-error"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (app()->auth::check()): ?>
        <div class="user-info">
            Вы уже вошли как: <?= htmlspecialchars(app()->auth::user()->first_name . ' ' . app()->auth::user()->last_name) ?>
        </div>
    <?php endif; ?>

    <?php if (!app()->auth::check()): ?>
        <form method="post" class="form-group">
            <div class="form">
                <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">
                <input type="text" name="login" placeholder="логин">
                <input type="password" name="password" placeholder="пароль">
            </div>
            <button type="submit" class="btn-submit">Войти</button>
        </form>
    <?php endif; ?>
</div>
