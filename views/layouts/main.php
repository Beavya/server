<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/server/assets/css/main.css">
    <title>Main site</title>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="<?= app()->route->getUrl('/hello') ?>">library</a>
            </div>
            <div class="link">
                <?php if (!app()->auth::check()): ?>
                    <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
                <?php else: ?>
                    <?php if (app()->auth::user()->id_role == 1): ?>
                        <a href="<?= app()->route->getUrl('/add_librarian') ?>">Добавить библиотекаря</a>
                    <?php endif; ?>
                    <?php if (app()->auth::user()->id_role == 2): ?>
                        <a href="<?= app()->route->getUrl('/readers/add') ?>">Добавить читателя</a>
                    <?php endif; ?>
                    <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= app()->auth::user()->first_name . ' ' . app()->auth::user()->last_name ?>)</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <div>
        <?= $content ?? ''; ?>
    </div>
</body>
</html>