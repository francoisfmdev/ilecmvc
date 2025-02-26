    <?php
    session_start();
    require 'vendor/autoload.php';

    use Controllers\HomeController;
    use Controllers\UserController;
    use Controllers\TaskController;
    use Database\Database;

    // Créer une instance du routeur
    $router = new AltoRouter();

    // Définir le chemin de base
    $router->setBasePath('/ilecmvc');




    // Définir les routes
    $router->map('GET', '/', function () {
        $db = Database::getInstance();
        $homeController = new HomeController($db);
        $homeController->index();
    });

   
 
   
    // inscription
    $router->map('GET', '/inscription', function () {
        
        $db = Database::getInstance();
        $userController = new UserController($db);
        $userController->inscription();
    });
    $router->map('POST', '/inscription', function () {
        
        $db = Database::getInstance();
        $userController = new UserController($db);
        $userController->inscription(); 
    });

    // connection
    $router->map('GET', '/connection', function () {
        
        $db = Database::getInstance();
        $userController = new UserController($db);
        $userController->index();
    });
    $router->map('POST', '/connection', function () {
        
        $db = Database::getInstance();
        $userController = new UserController($db);
        $userController->connection();   
    });
    $router->map('GET', '/deconnection', function () {
        
        $db = Database::getInstance();
        $userController = new UserController($db);
        $userController->deconnection();
    });

    // route Admin
    
    $router->map('GET', '/admin', function () {
        
        $db = Database::getInstance();
        $userController = new UserController($db);
        $userController->admin();
    });

    $router->map('POST', '/add_task', function () {
        
        $db = Database::getInstance();
        $taskController = new TaskController($db);
        $taskController->addtask();
    });
    $router->map('POST', '/change_status', function () {
        
        $db = Database::getInstance();
      
        $taskController = new TaskController($db);
        $taskController->change_status();
    });
    $router->map('POST', '/delete_task', function () {
        
        $db = Database::getInstance();
        $taskController = new TaskController($db);
        $taskController->deletetask();
    });

    // Matcher et gérer la requête
    $match = $router->match();

    if (is_array($match) && is_callable($match['target'])) {
        // Débogage des paramètres de la route
        

        // Appeler la fonction cible
        call_user_func_array($match['target'], $match['params']);
    } else {
        // Aucun chemin correspondant, renvoyer une erreur 404
         ($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
        echo 'Page introuvable.';
    }
