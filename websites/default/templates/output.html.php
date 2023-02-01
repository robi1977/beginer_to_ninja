<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IJDB</title>
</head>
<body>
    <?php if(isset($error)) { echo '<p style="color: red;">'.$error.'</p>'; } ?>
    <?php if(isset($jokes)) {
        foreach ($jokes as $joke) {
            echo '<p>'.$joke.'</p>';
        }
    }
    ?>
</body>
</html>