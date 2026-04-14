<h1>Список статей</h1>

<ol>
    <?php foreach ($posts as $post): ?>
        <li><?= $post->title ?></li>
    <?php endforeach; ?>
</ol>