<?php

include_once "vendor/autoload.php";
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Templating\EscapeEscaper;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Functions\Helper;

$helper = new Helper();
$translator = new Translator('en');
$translator->addLoader('yaml', new YamlFileLoader());
$translator->addResource('yaml', 'i18n/messages.en.yaml', 'en');
$translator->addResource('yaml', 'i18n/messages.de.yaml', 'de');
$translator->setLocale($helper->getBrowserLanguage());
$request = Request::createFromGlobals();
$filesystem = new Filesystem();
$path = $request->getPathInfo();
$target = ltrim($path, '/');
$host = 'https://' . $request->getHost();
$root = __DIR__ ;
if ($path == '/') {
    $path = '/home';
}
$queryString = $request->getQueryString();
if (!empty($queryString)) {
    $parameter = explode('&', $queryString)[0];
    $para = rtrim($parameter, '=');
}

if (str_contains($path, 'api')) {
    require $root . '/' . $path . '.php';
} else {
    if (str_contains($target, '/')) {
        $breadcrumb = explode('/', $target);
    } else {
        if (empty($breadcrumb)) {
            $breadcrumb = array($target);
        } else {
            array_push($breadcrumb, $target);
        }
    }

    if ($filesystem->exists('public' . $path . '.php')) {
        require $root . '/public' . $path . '.php';
    } else {
        require $root . '/public/404.php';
    }
}
