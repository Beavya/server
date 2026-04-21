<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/assets/css/main.css">
    <title>Library</title>
</head>
<body>
    <div class="wrapper">
        <header>
            <nav>
                <p class="logo">Библиотека</p>

                <div class="link">
                    <?php if (!app()->auth::check()): ?>
                        <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
                    <?php else: ?>
                        <?php if (app()->auth::user()->id_role == 2): ?>
                            <a href="<?= app()->route->getUrl('/loans/add') ?>">Выдать книгу</a>
                            <a href="<?= app()->route->getUrl('/books') ?>">Библиотека</a>
                            <a href="<?= app()->route->getUrl('/readers') ?>">Читатели</a>
                        <?php endif; ?>
                        <a href="<?= app()->route->getUrl('/logout') ?>">
                            Выход (<?= app()->auth::user()->first_name . ' ' . app()->auth::user()->last_name ?>)
                        </a>
                    <?php endif; ?>
                </div>
            </nav>
        </header>

        <div class="container">
            <?= $content ?? ''; ?>
        </div>
    </div>
</body>
</html>