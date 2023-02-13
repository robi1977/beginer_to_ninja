<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <header>
        <h1>Internetowa baza dowcipów</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="jokes.php">Jokes list</a></li>
        </ul>
    </nav>
    <main>
        <?=$output?>
    </main>
    <footer>
        &copy; IBD 2023
    </footer>
</body>
</html>