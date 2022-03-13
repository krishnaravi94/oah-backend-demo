<?php
define("PROJECT_ROOT_PATH", "E:/OAH project files/oah-backend-demo");
 
// include main configuration file
require_once PROJECT_ROOT_PATH . "/inc/config.php";
 
// include the base controller file
require_once PROJECT_ROOT_PATH . "/controller/api/base-controller.php";
 
// include the use model file
require_once PROJECT_ROOT_PATH . "/model/donation.model.php";

require_once PROJECT_ROOT_PATH . "/model/user.model.php";

require_once PROJECT_ROOT_PATH . "/model/auth.model.php";
?>