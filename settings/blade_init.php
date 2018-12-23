<?php
use Jenssegers\Blade\Blade;

$views = __DIR__ . '/../views';
$cache = __DIR__ . '/../cache';
$blade = new Blade($views, $cache);

function render_view($view, $args = []) {
    global $views, $cache, $blade;
    echo $blade->make($view, $args);
}
