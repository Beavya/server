<div class="card">
    <h2 class="title">Добавить читателя</h2>

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
            <input type="text" name="last_name" placeholder="фамилия">
            <input type="text" name="first_name" placeholder="имя">
            <input type="text" name="middle_name" placeholder="отчество">
            <input type="text" name="address" placeholder="адрес">
            <input type="tel" name="phone_number" placeholder="номер телефона">
        </div>

        <button type="submit" class="btn-submit">Добавить</button>
    </form>
</div>