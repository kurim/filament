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

function hexToRgb($hex) {
    // Remove the hash symbol if it's present
    $hex = ltrim($hex, '#');

    // Make sure the hex color code is valid
    if (preg_match('/^([A-Fa-f0-9]{3}){1,2}$/', $hex)) {
        // If it's a 3-character hex code, expand it to 6 characters
        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex, 0, 1), 2) .
                   str_repeat(substr($hex, 1, 1), 2) .
                   str_repeat(substr($hex, 2, 1), 2);
        }

        // Convert hex to RGB
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return "RGB ($r, $g, $b)";
    } else {
        return "Invalid hex color code";
    }
}

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
    $data['colorrgb'] = hexToRgb($data['colorhex']);
} else {
    
}

// Render the template
echo $template->render([
    'basefolder' => $host,
    'target' => $target ?? null,
    'filament' => $data ?? null
]);