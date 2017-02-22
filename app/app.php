<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Cuisine.php";
    require_once __DIR__."/../src/Review.php";

    $server = 'mysql:host=localhost:8889;dbname=cuisine_finder';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app['debug'] = true;

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/" , function() use ($app)
    {
        return $app['twig']->render("index.html.twig", array("cuisines" => Cuisine::getAll()));
    });

    $app->post("/", function() use ($app)
    {
        $new_cuisine = new Cuisine($_POST['cuisine']);
        $new_cuisine->save();

        return $app['twig']->render("index.html.twig", array("cuisines" => Cuisine::getAll()));
    });

    $app->get("/cuisine/{name}", function($name) use ($app)
    {
        $cuisine = Cuisine::findByName($name);
        $id = $cuisine->getId();
        return $app['twig']->render("cuisine.html.twig", array("restaurants" => Restaurant::getAllByCuisine($id), "cuisine"=>$cuisine));
    });

    $app->post("/cuisine/{name}", function($name) use ($app)
    {
        $cuisine= Cuisine::findByName($name);
        $id = $cuisine->getId();
        $restaurant = new Restaurant($_POST['restaurant'], $_POST['address'], $_POST['website'], $_POST['phone'], $id);
        $restaurant->save();
        
        return $app['twig']->render("cuisine.html.twig", array("restaurants" => Restaurant::getAllByCuisine($id), "cuisine"=>$cuisine));
    });

    $app->post("/deleteAll", function() use ($app)
    {
        Cuisine::deleteAll();

        return $app['twig']->render("index.html.twig", array("cuisines" => Cuisine::getAll()));
    });
    $app->post("/deleteAllByCuisine/{name}", function($name) use ($app)
    {
        $cuisine= Cuisine::findByName($name);
        $id = $cuisine->getId();
        Restaurant::deleteAllByCuisine($id);

        return $app['twig']->render("cuisine.html.twig", array("restaurants" => Restaurant::getAllByCuisine($id), "cuisine"=>$cuisine));
    });


    return $app;
?>
