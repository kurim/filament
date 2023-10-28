<?php

namespace Functions;

require "vendor/autoload.php";
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Intl\Locale;
use Symfony\Component\HttpFoundation\Request;

class Helper {

    public function generateUniqueRandomCode($length = 11) {
        $config = new Configuration();
        $connectionParams = require 'config/db-config.php';
        $connection = DriverManager::getConnection($connectionParams, $config);
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characterCount = strlen($characters);
        $maxAttempts = 10; // Maximum number of attempts to generate a unique code
    
        // Attempt to generate a unique code
        for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
            $code = '';
    
            // Generate a random code
            for ($i = 0; $i < $length; $i++) {
                $randomIndex = mt_rand(0, $characterCount - 1);
                $code .= $characters[$randomIndex];
            }
    
            $queryBuilder = $connection->createQueryBuilder();
            $queryBuilder
                ->select('COUNT(*)')
                ->from('filament')
                ->where('f_id = :f_id')
                ->setParameter('f_id', $code);
            // Check if the generated code already exists in the database
            $count = $queryBuilder->execute()->fetchOne();
            if ($count > 0) {
                $codeExistsInDatabase = true; // Replace with your database query
            } else {
                $codeExistsInDatabase = false;
            }
    
            if (!$codeExistsInDatabase) {
                return $code; // The code is unique, return it
            }
        }
    
        // If we reach here, we couldn't generate a unique code after maximum attempts
        return false;
    }

    public function getBrowserLanguage()
    {
        $request = Request::createFromGlobals();
        // Get the preferred languages from the Accept-Language header
        $preferredLanguages = $request->getLanguages();

        // Extract the primary language code from the first preferred language
        $primaryLanguage = null;
        if (!empty($preferredLanguages)) {
            $primaryLanguage = Locale::getPrimaryLanguage($preferredLanguages[0]);
        }

        return $primaryLanguage;
    }

}