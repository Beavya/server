<div class="card">
    <h2 class="title">Возврат книги</h2>

    <?php if (isset($error)): ?>
        <div class="message-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="reader-info">
        <p>Книга: <?= htmlspecialchars($loan->book->title) ?></p>
        <p>Читатель: <?= htmlspecialchars($loan->reader->last_name . ' ' . $loan->reader->first_name) ?></p>
        <p>Дата выдачи: <?= $loan->loan_date ?></p>
        <p>Дата ожидаемого возврата: <?= $loan->return_date ?></p>
    </div>

    <form method="post" class="form-group">
        <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">

        <div class="form">
            <input type="date" name="actual_return_date" value="<?= date('Y-m-d') ?>">
        </div>

        <button type="submit" class="btn-submit">Подтвердить возврат</button>
    </form>
</div>