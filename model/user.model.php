<?php
require_once PROJECT_ROOT_PATH . "\model\database.class.php";

class UserModel extends Database
{

    public function listAllUsers()
    {
        return $this->select("SELECT * FROM users");
    }

    public function createUser()
    {
        $body = file_get_contents("php://input");

        // Decode the JSON object
        $object = json_decode($body, true);
        // print_r ($object);
        // print_r ($object['donor_name']);
        // echo ($_POST['donor_name']);
        $data = array(
            'user_type'=>$object['user_type'],
            'name' => $object['name'],
            'email' => $object['email'],
            'pass' => $object['pass'],
            'phone' => $object['phone'],
            'added_on' => $object['added_on'],
            'status' => $object['status'],
        );

        return $this->insert('users', $data);
    }
    public function updateUser(){}
    public function deleteUser(){}

}
