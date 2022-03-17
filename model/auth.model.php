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
        // print_r($object);
        // print_r(password_hash($object['password'],PASSWORD_BCRYPT));
        $savedPasswordHash = $this->select("SELECT pass FROM users WHERE email = '" . mysqli_real_escape_string($this->connection, $object['username']) . "'")[0]['pass'];
        // print_r($savedPasswordHash."\n");
        // print_r($object['password']."\n");
        // echo('checking password '."\n");
 
        if(password_verify($object['password'],$savedPasswordHash)){
            $authResult = $this->select("SELECT * FROM users WHERE email = '" . mysqli_real_escape_string($this->connection, $object['username']) . "' LIMIT 1");
            if (count($authResult) < 1) {
                echo json_encode(array('error' => 'Invalid User'));
            } else {
                // $row = $authResult;
    
                $username = $authResult[0]['email'];
    
                $headers = array('alg' => 'HS256', 'typ' => 'JWT');
                $payload = array('email' => $username, 'exp' => (time() + 7200));
    
                $jwt = generateJwt($headers, $payload);
                return array('jwt_token' => $jwt);
            }
        }else{
            throw new Error();
        }
      
    }
    public function logoutUser()
    {
    }
}
