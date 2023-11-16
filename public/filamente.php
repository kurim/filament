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
        ->leftJoin('f', 'filament_basecolors', 'b', 'f.colorgroup = b.c_id')
        ->orderBy('f.vendor', 'ASC');
    $data = $queryBuilder->executeQuery()->fetchAllAssociative();

    $queryMaterial = $connection->createQueryBuilder();
    $queryMaterial
        ->select(['ft.*', 'COUNT(f.type) AS filament_count'])
        ->from('filament_type', 'ft')
        ->leftJoin('ft', 'filament', 'f', 'ft.id = f.type')
        ->groupBy('ft.id')
        ->orderBy('ft.type_name', 'ASC');
    $material = $queryMaterial->executeQuery()->fetchAllAssociative();

    $queryColor = $connection->createQueryBuilder();
    $queryColor
        ->select(['fb.*', 'COUNT(f.colorgroup) AS color_count'])
        ->from('filament_basecolors', 'fb')
        ->leftJoin('fb', 'filament', 'f', 'fb.c_id = f.colorgroup')
        ->groupBy('fb.c_id')
        ->orderBy('fb.basecolor', 'ASC');
    $color = $queryColor->executeQuery()->fetchAllAssociative();

    $queryVendors = $connection->createQueryBuilder();
    $queryVendors
        ->select(['v.*', 'COUNT(f.vendor) AS vendor_count'])
        ->from('vendors', 'v')
        ->leftJoin('v', 'filament', 'f', 'v.v_id = f.vendor')
        ->groupBy('v.v_id')
        ->orderBy('v.name', 'ASC');
    $vendors = $queryVendors->executeQuery()->fetchAllAssociative();

// Render the template
echo $template->render([
    'basefolder' => $helper->escape($host),
    'breadcrumb' => $breadcrumb ?? null,
    'target' => $target ?? null,
    'data' => $data ?? null,
    'material' => $material ?? null,
    'color' => $color ?? null,
    'vendors' => $vendors ?? null,
]);