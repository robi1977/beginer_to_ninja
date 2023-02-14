<p>W bazie znajduje się <?=$totalJokes?> dowcipów.</p>
<?php foreach($jokes as $joke): ?>
    <blockquote>
        <p>
        <?=htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8')?>
        (by <a href="mailto:<?=htmlspecialchars($joke['email'], ENT_QUOTES, 'UTF-8')?>">
            <?=htmlspecialchars($joke['name'], ENT_QUOTES, 'UTF-8')?>
        </a>)

        <form action="deletejoke.php" method="POST">
            <input type="hidden" name="id" value="<?=$joke['id']?>" />
            <input type="submit" value="Usuń" />
        </form>
        </p>
    </blockquote>
<?php endforeach; ?>
