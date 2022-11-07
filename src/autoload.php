<?php

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
if (file_exists('.env')) {
    $dotenv->load('.env');
} else if (file_exists('../.env')) {
    $dotenv->load('../.env');
} else if (file_exists('../../.env')) {
    $dotenv->load('../../.env');
}


function old($session, $default = null)
{
    if (isset($_SESSION["old"][$session])) {
        return $_SESSION["old"][$session];
    } else if ($default !== null) {
        return $default;
    }
}

function selected($bool)
{
    if ($bool) {
        return "selected";
    }
}

function checked($bool)
{
    if ($bool) {
        return "checked";
    }
}
