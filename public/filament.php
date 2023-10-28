<?php
require "vendor/autoload.php";
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Functions\Helper;
use Symfony\Component\Filesystem\Filesystem;

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
$twig->addFilter(new \Twig\TwigFilter('trans', [$translator, 'trans']));
$helper = new Helper();
$config = new Configuration();
$filesystem = new Filesystem();

// Load the Twig template
$template = $twig->load('filament.html.twig');
$connectionParams = require 'config/db-config.php';
$connection = DriverManager::getConnection($connectionParams, $config);
$queryString = $request->getQueryString();

// get filament ID
if ($queryString !== null) {
    // Split the query string by '&' to get individual parameters
    $parameter = explode('&', $queryString)[0];
    $regex = "/^[A-Za-z0-9]+=$/";
    // Check if the parameter matches the desired format (e.g., 8ImnkWJKHCm)
    if (preg_match($regex, $parameter)) {
        // Use the value for your purpose
        $filament_id = rtrim($parameter, '=');
    } else {
        $filament_id = $request->query->get('id');
    }
    // check if filament ID exist
    $queryBuilder = $connection->createQueryBuilder();
    $queryBuilder
        ->select('*')
        ->from('filament', 'f') // 'f' is an alias for the 'filament' table
        ->leftJoin('f', 'vendors', 'v', 'f.vendor = v.v_id') // 'v' is an alias for the 'vendors' table
        ->leftJoin('f', 'filament_type', 't', 'f.type = t.id') // 'v' is an alias for the 'vendors' table
        ->where('f.f_id = :f_id')
        ->setParameter('f_id', $filament_id);
    $data = $queryBuilder->execute()->fetchAssociative();
    $data['colorrgb'] = $helper->hexToRgb($data['colorhex']);

    $queryBuilder = $connection->createQueryBuilder();
    $queryBuilder
        ->select('*')
        ->from('filament_urls')
        ->where('f_id = :f_id')
        ->setParameter('f_id', $filament_id);
    $stores = $queryBuilder->execute()->fetchAllAssociative();
} else {
    $template = $twig->load('404.html.twig');
}

// Render the template
echo $template->render([
    'basefolder' => $host,
    'target' => $target ?? null,
    'filament' => $data ?? null,
    'stores' => $stores ?? null
]);