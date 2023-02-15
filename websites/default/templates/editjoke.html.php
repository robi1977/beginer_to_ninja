<form action="" method="post">
    <input type="hidden" name="jokeid" value="
        <?php if (isset($joke)): ?>
        <?=$joke['id']?>
        <?php endif; ?>
        " />
    <label for="joketext">Wpisz tekst Twojego dowcipu:</label>
    <textarea id="joketext" name="joketext" rows="3" cols="40">
        <?php if (isset($joke)): ?>
        <?=htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8')?>
        <?php endif; ?>
    </textarea>
    <input type="submit" name="submit" value="<?php isset($joke)?'Aktualizuj':'Dodaj' ?>"/>
</form>