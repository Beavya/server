
<div class="card">
    <h2 class="title">Выдача книги</h2>

    <?php if (isset($error)): ?>
        <div class="message-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="message-success">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <form method="post" class="form-group">
        <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">
        <div class="form">
            <input type="date" name="return_date" placeholder="дата возврата">
            <select name="card_number">
                <option value="">выберите читателя</option>
                <?php foreach ($readers as $reader): ?>
                    <option value="<?= $reader->card_number ?>"><?= htmlspecialchars($reader->last_name . ' ' . $reader->first_name . ' ' . $reader->middle_name) ?></option>
                <?php endforeach; ?>
            </select>

            <select name="id_book">
                <option value="">выберите книгу</option>
                <?php foreach ($books as $book): ?>
                    <option value="<?= $book->id_book ?>"><?= htmlspecialchars($book->title) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn-submit">Выдать</button>
    </form>
</div>
