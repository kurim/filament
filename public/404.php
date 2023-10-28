<?php
// Load the Twig template
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
$template = $twig->load('404.html.twig');

// Render the template
echo $template->render();