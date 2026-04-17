<div class="container-card">
    <div class="card readers">
        <h2 class="title">Читатели</h2>

        <form method="get" class="form readers">
            <input type="text" name="search" placeholder="Поиск" value="<?= htmlspecialchars($search) ?>">
            <a href="<?= app()->route->getUrl('/readers') ?>" class="btn-reset">Сбросить</a>
        </form>

        <div class="readers-list">
            <?php if (count($readers) > 0): ?>
                <?php foreach ($readers as $reader): ?>
                    <div class="reader-item">
                        <a href="<?= app()->route->getUrl('/readers/' . $reader->card_number) ?>">
                            <?= htmlspecialchars($reader->last_name . ' ' . $reader->first_name . ' ' . $reader->middle_name) ?>
                        </a>

                        <span class="<?= $reader->isActive() ? 'status-active' : 'status-inactive' ?>">
                            <?= $reader->isActive() ? 'Активен' : 'Не активен' ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="user-info">Читатели не найдены</p>
            <?php endif; ?>
        </div>
    </div>

    <a href="<?= app()->route->getUrl('/readers/add') ?>" class="btn-link">Добавить нового читателя</a>
</div>