<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";

//notifys silex exists
    $app = new Silex\Application();

//calls database
    $server = 'mysql:host=localhost;dbname=to_do';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app['debug'] = true;
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'));

    $app->get('/', function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->post('/', function() use ($app) {

        return $app['twig']->render('results.html.twig');
    });

    return $app;
?>
