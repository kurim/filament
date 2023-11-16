<?php
// Load the Twig template
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
$twig->addFilter(new \Twig\TwigFilter('trans', [$translator, 'trans']));
$template = $twig->load('404.html.twig');

// Render the template
echo $template->render();