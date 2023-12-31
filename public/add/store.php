<?php
require "vendor/autoload.php";
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Functions\Helper;

$loader = new \Twig\Loader\FilesystemLoader('templates');
$config = new Configuration();
$helper = new Helper();
$twig = new \Twig\Environment($loader);
$twig->addFilter(new \Twig\TwigFilter('trans', [$translator, 'trans']));
$queryString = $request->getQueryString();

$connectionParams = require 'config/db-config.php';
$connection = DriverManager::getConnection($connectionParams, $config);
// Load the Twig template

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
    $template = $twig->load('add/store.html.twig');
} else {
    $template = $twig->load('404.html.twig');
}
$queryBuilder = $connection->createQueryBuilder();
$queryBuilder
    ->select('f.f_id, f.color, v.name, t.type_name')
    ->from('filament', 'f') // 'f' is an alias for the 'filament' table
    ->leftJoin('f', 'vendors', 'v', 'f.vendor = v.v_id') // 'v' is an alias for the 'vendors' table
    ->leftJoin('f', 'filament_type', 't', 'f.type = t.id') // 't' is an alias for the 'filament_type' table
    ->where('f.f_id = :f_id')
    ->setParameter('f_id', $filament_id);
$data = $queryBuilder->executeQuery()->fetchAssociative();

$language = $helper->getBrowserLanguage();
$queryBuilder = $connection->createQueryBuilder();
    $queryBuilder
        ->select('f.*, ' . ($language === 'de' ? 'c.name_de' : 'c.name') . ' AS countryname')
        ->from('filament_urls', 'f')
        ->leftJoin('f', 'countries', 'c', 'f.country = c.code') // 'v' is an alias for the 'vendors' table
        ->where('f_id = :f_id')
        ->setParameter('f_id', $filament_id);
    $stores = $queryBuilder->executeQuery()->fetchAllAssociative();

$queryBuilder = $connection->createQueryBuilder();
$language = $helper->getBrowserLanguage();
$queryBuilder
    ->select('code, ' . ($language === 'de' ? 'name_de' : 'name') . ' AS selected_name')
    ->from('continents')
    ->orderBy('selected_name', 'ASC');

$countries = $queryBuilder->executeQuery()->fetchAllAssociative();

// Render the template
echo $template->render([
    'basefolder' => $helper->escape($host),
    'breadcrumb' => $breadcrumb ?? null,
    'target' => $target ?? null,
    'filament' => $data ?? null,
    'stores' => $stores ?? null,
    'language' => $language ?? null,
    'countries' => $countries ?? null
]);