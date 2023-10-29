<?php
// Load the Twig template
use Functions\Helper;
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
$twig->addFilter(new \Twig\TwigFilter('trans', [$translator, 'trans']));
$template = $twig->load('home.html.twig');


// Render the template
// Render the template
echo $template->render([
    'basefolder' => $host,
    'breadcrumb' => $breadcrumb ?? null,
]);