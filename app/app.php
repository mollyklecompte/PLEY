<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Cuisine.php";

//notifys silex exists
    $app = new Silex\Application();

//calls database
    $server = 'mysql:host=localhost;dbname=restaurant_database';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app['debug'] = true;
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'));

    $app->get('/', function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->post('/addRestaurant', function() use ($app) {
        $restaurant_name = $_POST['restaurant_name'];
        $id = null;
        $cuisine_id = $_POST['cuisine'];
        $new_restaurant = new Restaurant($restaurant_name, $id, $cuisine_id);
        $new_restaurant->save();

        return $app['twig']->render('restaurants.html.twig', array('restaurant' => $restaurant_name));
    });

    $app->post('/search_cuisine', function() use ($app) {
        $cuisine = $_POST['cuisine'];
        $new_cuisine = new Cuisine($cuisine, $id = null);
        $search_cuisine = $new_cuisine->findMatch($cuisine);
        $matching_restaurants = $search_cuisine->getRestaurants();

        return var_dump($matching_restaurants);

        // return $app['twig']->render('search_cuisine.html.twig', array('cuisine' => $search_cuisine, 'restaurants' => $matching_restaurants));
    });

    $app->post('/search_name', function() use ($app) {
        $restaurant = $_POST['restaurant_name'];
        $new_restaurant = new Restaurant($restaurant, $id = null, $cuisine_id = null);
        $search_restaurant = $new_restaurant->findMatch($restaurant);

        return $app['twig']->render('search_name.html.twig', array('restaurant' => $search_restaurant));
    });
    return $app;
?>
