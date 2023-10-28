<?php
require "vendor/autoload.php";
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Functions\Helper;

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);