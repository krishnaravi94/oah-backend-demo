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
try {
    $token = getBearerToken();
} catch (Error $e) {
    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
    $strErrorHeader = 'HTTP/1.1 403 Unauthorized user. Please login with valid credentials.';
}

switch ($uri[2]) {
    case 'donation': {

            // header("Authorization: Bearer $object['token']");
            if (checkJwtValidity($token)) {
                switch ($uri[3]) {
                    case 'list': {
                            $objFeedController = new DonationController();
                            $objFeedController->getAllDonations();
                            break;
                        }
                    case 'create': {
                            $objFeedController = new DonationController();
                            $objFeedController->createDonation();
                            break;
                        }
                    case 'cancel': {
                            $objFeedController = new DonationController();
                            $objFeedController->cancelDonation();
                            break;
                        }
                    default:
                        return;
                }
                break;
            } else {
                header('HTTP/1.1 403 Unauthorized User');
                exit();
            }
        }
    case 'user': {
            if (checkJwtValidity($token)) {
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
                            $objFeedController->updateUserDetails();
                            break;
                        }
                    default:
                        return;
                }
                break;
            } else {
                header('HTTP/1.1 403 Unauthorized User');
                exit();
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
