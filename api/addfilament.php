<?php
require 'vendor/autoload.php'; // Adjust the path to the autoloader as needed

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Functions\Helper;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

$request = Request::createFromGlobals();

if ($request->isMethod('POST')) {
    $file = $request->files->get('filament_image');

    if ($file) {
        try {
        $helper = new Helper();
        $filament_id = $helper->generateUniqueRandomCode();
        // Create a database connection
        $config = new Configuration();
        $connectionParams = require 'config/db-config.php';
        $connection = DriverManager::getConnection($connectionParams, $config);
        $connection->beginTransaction();

        // Define the upload directory (make sure it exists)
        $uploadDirectory = 'images/filaments/';
        // Create a unique filename for the uploaded file
        $fileExtension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        
        $filename = $filament_id . '.' . $fileExtension;

        // Move the uploaded file to the destination path
        $file->move($uploadDirectory, $filename);


        $filePath = 'images/qrcodes/'.$filament_id.'png';
        if (!$filesystem->exists($filePath)) {
            // Create QR code
            $result = Builder::create()
            ->writer(new PngWriter())
            ->data('https://filament.kurim.de/filament?'.$filament_id)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(1000)
            ->validateResult(false)
            ->build();
            $result->saveToFile('/home/kurim/public_html/filament.kurim.de/src/images/qrcodes/'.$filament_id.'.png');
        }
        
        $shorthandColor = ltrim($request->request->get('colorhex'), '#');

        // Check the length of the shorthand color code
        if (strlen($shorthandColor) == 3) {
            // Expand shorthand color to 6 characters
            $fullColor = $shorthandColor[0] . $shorthandColor[0] . $shorthandColor[1] . $shorthandColor[1] . $shorthandColor[2] . $shorthandColor[2];
        } elseif (strlen($shorthandColor) == 6) {
            // The color code is already in the full 6-character format
            $fullColor = $shorthandColor;
        } else {
            // Invalid color code
            $fullColor = false;
        }

        // Insert data into your database table
        // Define the data to be inserted
        $data = [
            'f_id' => $filament_id,
            'vendor' => $request->request->get('vendor'),
            'filament_type' => $request->request->get('filament_type'),
            'colorname' => $request->request->get('colorname'),
            'colorhex' => $fullColor,
            // 'kfactor' => $request->request->get('kfactor'),
            'diameter' => $request->request->get('diameter'),
            'diameter_variance' => $request->request->get('diameter_variance'),
            'nozzletemp_low' => $request->request->get('nozzletemp_low'),
            'nozzletemp_high' => $request->request->get('nozzletemp_high'),
            'nozzletemp_sug' => $request->request->get('nozzletemp_sug'),
            'platetemp_low' => $request->request->get('platetemp_low'),
            'platetemp_high' => $request->request->get('platetemp_high'),
            'platetemp_sug' => $request->request->get('platetemp_sug'),
            'printspeed_low' => $request->request->get('printspeed_low'),
            'printspeed_high' => $request->request->get('printspeed_high'),
            'filament_image' => $filename,
            'productlink' => empty($request->request->get('productlink')) ? $request->request->get('productlink') : '',
        ];

        // Create a query builder instance
        $qb = $connection->createQueryBuilder();

        // Build the SQL INSERT statement with placeholders and named parameters
        $qb->insert('filament') // Replace with your actual table name
        ->values([
             'f_id' => ':f_id',
             'vendor' => ':vendor',
             'type' => ':filament_type',
             'color' => ':colorname',
             'colorhex' => ':colorhex',
             //'kfactor' => ':kfactor',
             'diameter' => ':diameter',
             'diameter_variance' => ':diameter_variance',
             'nozzletemp_low' => ':nozzletemp_low',
             'nozzletemp_high' => ':nozzletemp_high',
             'nozzletemp_sug' => ':nozzletemp_sug',
             'platetemp_low' => ':platetemp_low',
             'platetemp_high' => ':platetemp_high',
             'platetemp_sug' => ':platetemp_sug',
             'printspeed_low' => ':printspeed_low',
             'printspeed_high' => ':printspeed_high',
             'filament_image' => ':filament_image',
             'productlink' => ':productlink',
        ]);

        // Bind the parameters
        $qb->setParameters($data);

        $qb->executeQuery();
        // Commit the database transaction
        $connection->commit();
        
        // File upload was successful
        $response = new Response($filament_id, Response::HTTP_OK);
        } catch (Exception $e) {
            // Rollback the database transaction
            $connection->rollBack();

            // Delete the uploaded image if an exception occurs
            if (file_exists($uploadDirectory . $filename)) {
                unlink($uploadDirectory . $filename);
            }
            if (file_exists('images/qrcodes/'.$filament_id.'.png')) {
                unlink('images/qrcodes/'.$filament_id.'.png');
            }
            // Handle the exception (you can log or display an error message)
            $response = new Response("An error occurred: " . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    } else {
        // File upload error
        $response = new Response('File upload error', Response::HTTP_BAD_REQUEST);
    }
} else {
    // Invalid request method
    $response = new Response('Invalid request method', Response::HTTP_METHOD_NOT_ALLOWED);
}

$response->send();
