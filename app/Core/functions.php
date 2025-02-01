<?php

function base_path($path): string
{
    return BASE_PATH . $path;
}

function dd(mixed ...$value): void
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function view(string $path)
{
    require base_path('resources/views/' . $path . '.blade.php');
}