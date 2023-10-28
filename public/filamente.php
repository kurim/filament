<?php
use Functions\Helper;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
// Load the Twig template
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
$twig->addFilter(new \Twig\TwigFilter('trans', [$translator, 'trans']));
$template = $twig->load('filamente.html.twig');
$helper = new Helper();
$config = new Configuration();

    // check if filament ID exist
    $connectionParams = require 'config/db-config.php';
    $connection = DriverManager::getConnection($connectionParams, $config);
    $queryBuilder = $connection->createQueryBuilder();
    $queryBuilder
        ->select('*')
        ->from('filament', 'f') // 'f' is an alias for the 'filament' table
        ->leftJoin('f', 'vendors', 'v', 'f.vendor = v.v_id') // 'v' is an alias for the 'vendors' table
        ->leftJoin('f', 'filament_type', 't', 'f.type = t.id')
        ->orderBy('f.vendor', 'ASC');
    $data = $queryBuilder->execute()->fetchAllAssociative();


// Render the template
echo $template->render([
    'basefolder' => $host,
    'target' => $target ?? null,
    'data' => $data ?? null,
]);