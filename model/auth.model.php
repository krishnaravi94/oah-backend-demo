<?php
require_once PROJECT_ROOT_PATH . "\model\database.class.php";
require_once PROJECT_ROOT_PATH . "\inc\jwt_utils.php";
class AuthModel extends Database
{
    public function loginUser()
    {
        $body = file_get_contents("php://input");
        // Decode the JSON object
        $object = json_decode($body, true);
        $authResult = $this->select("SELECT * FROM users WHERE email = '" . mysqli_real_escape_string($this->connection, $object['username']) . "' AND pass = '" . mysqli_real_escape_string($this->connection, $object['password']) . "' LIMIT 1");
        if (count($authResult) < 1) {
            echo json_encode(array('error' => 'Invalid User'));
        } else {
            // $row = $authResult;

            $username = $authResult[0]['email'];

            $headers = array('alg' => 'HS256', 'typ' => 'JWT');
            $payload = array('email' => $username, 'exp' => (time() + 300));

            $jwt = generate_jwt($headers, $payload);
            return array('jwt_token' => $jwt);
        }
    }
    public function logoutUser()
    {
    }
}
