<?php
require __DIR__ . "\inc\bootstrap.php";
// require __DIR__ . "/inc/jwt_utils.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
// echo($_SERVER['REQUEST_URI']);
// echo($uri[3]);
// echo( !isset($uri[3]));
if (!isset($uri[2])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

require PROJECT_ROOT_PATH . "/controller/api/donation-controller.php";
require PROJECT_ROOT_PATH . "/controller/api/user-controller.php";
require PROJECT_ROOT_PATH . "/controller/api/auth-controller.php";

$body = file_get_contents("php://input");
// Decode the JSON object
$object = json_decode($body, true);

switch ($uri[2]) {
    case 'donation': {
            if (is_jwt_valid($object['token'])) {
                switch ($uri[3]) {
                    case 'list': {
                            $objFeedController = new DonationController();
                            $objFeedController->listAction();
                            break;
                        }
                    case 'create': {
                            $objFeedController = new DonationController();
                            $objFeedController->createAction();
                            break;
                        }
                    case 'update': {
                            $objFeedController = new DonationController();
                            $objFeedController->updateAction();
                            break;
                        }
                    case 'delete': {
                            $objFeedController = new DonationController();
                            $objFeedController->deleteAction();
                            break;
                        }
                    default:
                        return;
                }
                break;
            } {
                header('HTTP/1.1 403 Unauthorized User');
                exit();
            }
        }
    case 'user': { {
                switch ($uri[3]) {
                    case 'list': {
                            $objFeedController = new UserController();
                            $objFeedController->listAllUsers();
                            break;
                        }
                    case 'create': {
                            $objFeedController = new UserController();
                            $objFeedController->createUser();
                            break;
                        }
                    case 'update': {
                            $objFeedController = new UserController();
                            $objFeedController->updateUser();
                            break;
                        }
                    case 'delete': {
                            $objFeedController = new UserController();
                            $objFeedController->deleteUser();
                            break;
                        }
                    default:
                        return;
                }
                break;
            }
        }
    case 'auth': {
            switch ($uri[3]) {
                case 'login': {
                        $objFeedController = new AuthController();
                        $objFeedController->authLogin();
                        break;
                    }
                case 'logout': {
                        $objFeedController = new AuthController();
                        $objFeedController->authLogout();
                        break;
                    }
            }
            break;
        }
    default:
        return;
}
