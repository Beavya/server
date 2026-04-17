<div class="container-card">
    <div class="card readers">
        <h2 class="title"><?= htmlspecialchars($book->title) ?></h2>

        <div class="book-group">
            <img class="cover" src="<?= $book->cover ?>" alt="Обложка">

            <div class="reader-info">
                <p>Автор: <?= htmlspecialchars($book->author->last_name . ' ' . $book->author->first_name . ' ' . $book->author->middle_name) ?></p>
                <p>Год публикации: <?= $book->publication_year ?></p>
                <p>Цена: <?= $book->price ?> руб.</p>
                <p>Книга новая? <?= $book->is_new ? 'Да' : 'Нет' ?></p>
                <p>Краткое описание: <?= htmlspecialchars($book->summary) ?></p>
            </div>
        </div>

        <div class="readers-list">
            <?php if (count($loans) > 0): ?>
                <?php foreach ($loans as $loan): ?>
                    <div class="reader-item">
                        <a href="<?= app()->route->getUrl('/readers/' . $loan->card_number) ?>">
                            <?= htmlspecialchars($loan->reader->last_name . ' ' . $loan->reader->first_name . ' ' . $loan->reader->middle_name) ?>
                        </a>

                        <div class="loan-dates">
                            <span class="<?= $loan->actual_return_date ? '' : 'status-not-returned' ?>">
                                Выдана: <?= $loan->loan_date ?>
                            </span>

                            <?php if ($loan->actual_return_date): ?>
                                <span>Сдана: <?= $loan->actual_return_date ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="user-info">История выдач пуста</div>
            <?php endif; ?>
        </div>
    </div>
</div>