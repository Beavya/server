<div class="container-card">
    <div class="card readers">
        <h2 class="title">Читательский билет: <?= $reader->card_number ?></h2>

        <div class="reader-info">
            <p>ФИО: <?= htmlspecialchars($reader->last_name . ' ' . $reader->first_name . ' ' . $reader->middle_name) ?></p>
            <p>Телефон: <?= htmlspecialchars($reader->phone_number) ?></p>
            <p>Адрес: <?= htmlspecialchars($reader->address) ?></p>
        </div>

        <div class="readers-list">
            <?php if (count($loans) > 0): ?>
                <?php foreach ($loans as $loan): ?>
                    <div class="reader-item">
                        <a href="<?= app()->route->getUrl('/books/' . $loan->id_book) ?>">
                            <?= htmlspecialchars($loan->book->title) ?>
                        </a>

                        <?php if ($loan->id_status_loan == 1): ?>
                            <div class="reader-right">
                                <a href="<?= app()->route->getUrl('/loans/return/' . $loan->id_loan) ?>" class="btn-return">Вернуть</a>

                                <?php if ($loan->return_date < date('Y-m-d')): ?>
                                    <span class="status-overdue">Просрочена</span>
                                <?php else: ?>
                                    <span class="status-active">Активен</span>
                                <?php endif; ?>
                            </div>
                        <?php elseif ($loan->id_status_loan == 2): ?>
                            <span class="status-inactive">Возвращена</span>
                        <?php else: ?>
                            <span class="status-overdue">Просрочена</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="user-info">У читателя нет книг</div>
            <?php endif; ?>
        </div>
    </div>
</div>