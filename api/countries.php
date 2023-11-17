<?php

require 'vendor/autoload.php'; // Adjust the path to the autoloader as needed

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Functions\Helper;

$request = Request::createFromGlobals();

if ($request->isMethod('POST')) {
    $language = $request->request->get('language');
    $continent_code = $request->request->get('regions');
    $config = new Configuration();
    $connectionParams = require 'config/db-config.php';
    $connection = DriverManager::getConnection($connectionParams, $config);

    $queryBuilder = $connection->createQueryBuilder();
    $queryBuilder
        ->select('code, ' . ($language === 'de' ? 'name_de' : 'name') . ' AS selected_name')
        ->from('countries')
        ->where('continent_code = :continent_code')
        ->setParameter('continent_code', $continent_code)
        ->orderBy('selected_name', 'ASC');

    $countries = $queryBuilder->executeQuery()->fetchAllAssociative();

    $response = new Response(json_encode($countries), Response::HTTP_OK);
} else {
    // Invalid request method
    $response = new Response('Invalid request method', Response::HTTP_METHOD_NOT_ALLOWED);
}

$response->send();
