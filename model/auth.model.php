<?php
require_once PROJECT_ROOT_PATH . "/model/database.class.php";
require_once PROJECT_ROOT_PATH . "/inc/jwt_utils.php";
class AuthModel extends Database
{
    public function loginUser()
    {
              $body = file_get_contents("php://input");
        // Decode the JSON object
        $object = json_decode($body, true);
        // print_r($object);
        // print_r(password_hash($object['password'],PASSWORD_BCRYPT));
        try {
            $savedPasswordHash = $this->select("SELECT pass FROM users WHERE email = '" .  $object['username'] . "'")[0]['pass'];

            if (password_verify($object['password'], $savedPasswordHash)) {
                $authResult = $this->select("SELECT * FROM users WHERE email = '" . $object['username'] . "' LIMIT 1");
                if (count($authResult) < 1) {
                    echo json_encode(array('error' => 'Invalid User'));
                } else {

                    $userAccessLevel = $authResult[0]['user_type'];

                    $headers = array('alg' => 'HS256', 'typ' => 'JWT');
                    $payload = array('accessLevel' => $userAccessLevel, 'exp' => (time() + 7200));

                    $jwt = generateJwt($headers, $payload);
                    return array('token' => $jwt);
                }
            }
        } catch (Error $e) {
            throw new Error('error in data fetch from db');
        // $body = file_get_contents("php://input");
        // // Decode the JSON object
        // $object = json_decode($body, true);
       
        // $savedPasswordHash = $this->select("SELECT pass FROM users WHERE email = '" . $object['username']. "'")[0]['pass'];
 
        // if(password_verify($object['password'],$savedPasswordHash)){
        //     $authResult = $this->select("SELECT * FROM users WHERE email = '" . $object['username']. "' LIMIT 1");
        //     if (count($authResult) < 1) {
        //         echo json_encode(array('error' => 'Invalid User'));
        //     } else {
        //         // $row = $authResult;
    
        //         $userAccessLevel = $authResult[0]['user_type'];
    
        //         $headers = array('alg' => 'HS256', 'typ' => 'JWT');
        //         $payload = array('accessLevel' => $userAccessLevel, 'exp' => (time() + 7200));
    
        //         $jwt = generateJwt($headers, $payload);
        //         return array('token' => $jwt);
        //     }
        // }else{
        //     throw new Error();
        // }
      
    }

}
}
