<?php
require "vendor/autoload.php";
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Functions\Helper;

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
$twig->addFilter(new \Twig\TwigFilter('trans', [$translator, 'trans']));
$config = new Configuration();

// Load the Twig template
$template = $twig->load('add/filament.html.twig');
$connectionParams = require 'config/db-config.php';
$connection = DriverManager::getConnection($connectionParams, $config);
$queryString = $request->getQueryString();

$queryBuilder = $connection->createQueryBuilder();
$queryBuilder
    ->select('v_id, name')
    ->from('vendors')
    ->orderBy('name', 'ASC');
$vendors = $queryBuilder->execute()->fetchAllAssociative();

$queryBuilder = $connection->createQueryBuilder();
$queryBuilder
    ->select('id, type_name')
    ->from('filament_type')
    ->orderBy('type_name', 'ASC');
$filament_type = $queryBuilder->execute()->fetchAllAssociative();

// Render the template
echo $template->render([
    'basefolder' => $host,
    'breadcrumb' => $breadcrumb ?? null,
    'target' => $target ?? null,
    'vendors' => $vendors ?? null,
    'filament_type' => $filament_type ?? null,
]);