<?php

require 'vendor/autoload.php'; // Adjust the path to the autoloader as needed

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

$request = Request::createFromGlobals();

if ($request->isMethod('POST')) {
    $config = new Configuration();
    $connectionParams = require 'config/db-config.php';
    $connection = DriverManager::getConnection($connectionParams, $config);

    $f_id = $request->request->get('f_id');
    $websitename = $request->request->get('websitename');
    $region = $request->request->get('region');
    $country = $request->request->get('country');
    $websiteurl = $request->request->get('websiteurl');

    $queryBuilder = $connection->createQueryBuilder();
    // Define the data to insert
    $data = [
        'f_id' => $f_id, // Replace with your f_id value
        'website' => $websitename,
        'region' => $region,
        'country' => $country,
        'url' => $websiteurl, // Replace with your URL
    ];
    // Insert data into the "filament_urls" table
    $queryBuilder
        ->insert('filament_urls') // Replace 'filament_urls' with your table name if different
        ->values([
            'f_id' => ':f_id',
            'website' => ':website',
            'region' => ':region',
            'country' => ':country',
            'url' => ':url'
        ]);
    $queryBuilder->setParameters($data);
    // Execute the query
    $queryBuilder->executeQuery();

    $response = new Response('OK', Response::HTTP_OK);
} else {
    // Invalid request method
    $response = new Response('Invalid request method', Response::HTTP_METHOD_NOT_ALLOWED);
}

$response->send();
