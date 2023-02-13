<?php foreach($jokes as $joke): ?>
    <blockquote>
        <p>
        <?=htmlspecialchars($joke['id'], ENT_QUOTES, 'UTF-8')?>
        &nbsp;-&nbsp;
        <?=htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8')?>
        <form action="deletejoke.php" method="POST">
            <input type="hidden" name="id" value="<?=$joke['id']?>" />
            <input type="submit" value="Usuń" />
        </form>
        </p>
    </blockquote>
<?php endforeach; ?>
