<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/server/assets/css/form.css">
    <title>Добавить книгу</title>
</head>
<body>
    <div class="card">
        <h2 class="title">Добавить книгу</h2>

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
                <input type="text" name="title" placeholder="название">
                <select name="id_author">
                    <option value="">выберите автора</option>
                    <?php foreach ($authors as $author): ?>
                        <option value="<?= $author->id_author ?>"><?= htmlspecialchars($author->last_name . ' ' . $author->first_name . ' ' . $author->middle_name) ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="form-row">
                    <input type="number" name="publication_year" placeholder="год издания">
                    <input type="text" name="price" placeholder="цена">
                </div>
                
                <div class="form-row">
                    <label class="checkbox-label">новое издание?</label>
                    <input type="checkbox" name="is_new" value="1"> 
                </div>
                    
                <textarea name="summary" placeholder="аннотация" rows="3"></textarea>
            </div>
            <button type="submit" class="btn-submit">Добавить</button>
        </form>
    </div>
</body>
</html>