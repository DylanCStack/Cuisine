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
    session_start();
    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app['session.storage.options'] = [
    'cookie_lifetime' => 0
    ];
    // $_SESSION['test']= "session is still live";

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
        $restaurant = new Restaurant($_POST['restaurant'], $_POST['address'], $_POST['website'], $_POST['phone'], $id,1);
        $restaurant->save();

        return $app['twig']->render("cuisine.html.twig", array("restaurants" => Restaurant::getAllByCuisine($id), "cuisine"=>$cuisine));
    });

    $app->get("/restaurant/{cuisine}/{name}", function($cuisine, $name) use ($app)
    {
        $restaurant = Restaurant::findByName($name);
        $id = $restaurant->getId();

        $reviews = Review::getAllByRestaurant($id);
        return $app['twig']->render("restaurant.html.twig", array("restaurant" => $restaurant, "reviews"=>$reviews, "cuisine"=>$cuisine));
    });

    $app->post("/restaurant/{cuisine}/{name}", function($cuisine, $name) use ($app)
    {
        $restaurant = Restaurant::findByName($name);
        $id = $restaurant->getId();

        $review = new Review($_POST['review_text'], $_POST['score_input'], $id,1);
        $review->save();

        $reviews = Review::getAllByRestaurant($id);
        return $app['twig']->render("restaurant.html.twig", array("restaurant" => $restaurant, "reviews"=>$reviews, "cuisine"=>$cuisine));
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

    $app->post("/deleteAllReviewByRestaurant/{id}", function($id) use ($app)
    {
        $restaurant = Restaurant::find($id);
        $cuisine = Cuisine::find($restaurant->getCuisineId());
        $reviews = Review::getAllByRestaurant($restaurant->getId());
        Review::deleteAllByRestaurant($id);

        return $app->redirect("/restaurant/{$cuisine->getName()}/{$restaurant->getName()}");
    });

    $app->delete("/delete-review/{id}", function($id) use ($app){

        $review = Review::find($id);
        $review->delete();

        $restaurant = Restaurant::find($review->getRestaurantId());
        $cuisine = Cuisine::find($restaurant->getCuisineId());

        return $app->redirect("/restaurant/{$cuisine->getName()}/{$restaurant->getName()}");
    });

    $app->patch("/edit-review/{id}", function($id) use ($app){

        $review = Review::find($id);
        $review->update($_POST['review_text'], $_POST['score_input'],1);

        $restaurant = Restaurant::find($review->getRestaurantId());
        $cuisine = Cuisine::find($restaurant->getCuisineId());

        return $app->redirect("/restaurant/{$cuisine->getName()}/{$restaurant->getName()}");
    });

    return $app;
?>
