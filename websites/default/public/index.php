<?php
    $title = "Internet Jokes Database";

    ob_start();
        include __DIR__.'/../home.html.php';
    $output = ob_get_clean();
    