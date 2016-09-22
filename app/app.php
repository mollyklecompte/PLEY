<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Cuisine.php";

//notifys silex exists
    $app = new Silex\Application();

//calls database
    $server = 'mysql:host=localhost;dbname=pley_database';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app['debug'] = true;
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get('/', function() use ($app) {
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->post('/cuisines', function() use ($app) {
        $cuisine = new Cuisine($_POST['cuisine']);
        $cuisine->save();
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->get('/cuisines/{id}', function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    $app->post('/restaurants', function() use ($app) {
        $restaurant = $_POST['restaurant'];
        $contact = $_POST['contact'];
        $cuisine_id = $_POST['cuisine_id'];
        $restaurant = new Restaurant($restaurant, $id = null, $cuisine_id, $contact);
        $restaurant->save();
        $cuisine = Cuisine::find($cuisine_id);
        return $app['twig']->render('cuisine.html.twig', array('cuisine'=>$cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    $app->get('/restaurants/{id}', function($id) use ($app) {
        $restaurant = Restaurant::find($id);

        return $app['twig']->render('restaurant.html.twig', array('restaurant' => $restaurant));
    });


// PATCH!!!
    $app->get('/cuisines/{id}/edit', function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine_edit.html.twig', array('cuisine' => $cuisine));
    });

    $app->patch('/cuisines/{id}', function($id) use ($app) {
        $cuisine_type = $_POST['cuisine_type'];
        $cuisine = Cuisine::find($id);
        $cuisine->update($cuisine_type);
        return $app['twig']->render('cuisine.html.twig', array('cuisine'=>$cuisine, 'restaurants'=> $cuisine->getRestaurants()));
    });

    $app->delete("/cuisines/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        $cuisine->delete();

        return $app['twig']->render('delete.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    // restaurant patch

    $app->get('/restaurants/{id}/edit', function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        return $app['twig']->render('restaurant_edit.html.twig', array('restaurant' => $restaurant));
    });


    $app->patch('/restaurants/{id}', function($id) use ($app) {
        $contact = $_POST['contact'];
        $restaurant = Restaurant::find($id);
        $contact->update($contact);
        return $app['twig']->render('restaurant.html.twig', array('cuisine'=>$cuisine, 'restaurants'=> $cuisine->getRestaurants()));
    });

    $app->delete("/restaurants/{id}", function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        $restaurant->delete();

        return $app['twig']->render('delete.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    return $app;
?>
