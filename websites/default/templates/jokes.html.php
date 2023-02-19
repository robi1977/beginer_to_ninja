<p>W bazie znajduje się <?=$totalJokes?> dowcipów.</p>
<?php foreach($jokes as $joke): ?>
    <blockquote>
        <p>
        <?=htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8')?>
        (by <a href="mailto:<?=htmlspecialchars($joke['email'], ENT_QUOTES, 'UTF-8')?>">
            <?=htmlspecialchars($joke['name'], ENT_QUOTES, 'UTF-8')?>
        </a>) on 
        <?php
            $date = new DateTime($joke['jokedate']); //utworzenie obiektu DateTime z datą ustawioną na tą pobraną z bazy danych
            echo $date->format('jS F Y'); //przeformatowanie daty aby wygladala na 4th August 1997
        ?> 
        <a href="/joke/edit/<?=$joke['id']?>">Edytuj</a>
        
        <form action="/joke/delete" method="POST">
            <input type="hidden" name="id" value="<?=$joke['id']?>" />
            <input type="submit" value="Usuń" />
        </form>
        </p>
    </blockquote>
<?php endforeach; ?>
