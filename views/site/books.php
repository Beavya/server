<div class="container-card">
    <div class="card readers">
        <h2 class="title">Книги</h2>

        <form method="get" class="form readers">
            <input type="text" name="search" placeholder="Поиск" value="<?= htmlspecialchars($search ?? '') ?>">
            <a href="<?= app()->route->getUrl('/books') ?>" class="btn-reset">Сбросить</a>
        </form>

        <div class="readers-list">
            <?php if (count($books) > 0): ?>
                <?php foreach ($books as $book): ?>
                    <div class="reader-item">
                        <a href="<?= app()->route->getUrl('/books/' . $book->id_book) ?>">
                            <?= htmlspecialchars($book->title) ?>
                        </a>

                        <div class="book-stats">
                            <span class="<?= $book->id_status_book == 1 ? 'status-active' : 'status-inactive' ?>">
                                <?= $book->id_status_book == 1 ? 'В наличии' : 'Выдана' ?>
                            </span>

                            <?php if ($book->total_loans > 0): ?>
                                <span class="<?= $book->id_status_book == 1 ? 'status-active' : 'status-inactive' ?>">
                                    (бронь: <?= $book->total_loans ?>)
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="user-info">Книги не найдены</p>
            <?php endif; ?>
        </div>
    </div>

    <a href="<?= app()->route->getUrl('/books/add') ?>" class="btn-link">Добавить новую книгу</a>
</div>