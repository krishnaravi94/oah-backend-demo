<?php
require_once PROJECT_ROOT_PATH . "\model\database.class.php";

class UserModel extends Database
{

    public function listAllUsers()
    {
        return $this->select("SELECT name, email, phone, users_type_md.type, status FROM users join users_type_md on users.user_type = users_type_md.id");
    }

    public function createUser()
    {
        $body = file_get_contents("php://input");

        // Decode the JSON object
        $object = json_decode($body, true);
        // print_r ($object);
        $hashed_password = password_hash($object['pass'],PASSWORD_BCRYPT);
        // print_r ($object['donor_name']);
        // echo ($_POST['donor_name']);
        $data = array(
            'user_type'=>$object['user_type'],
            'name' => $object['name'],
            'email' => $object['email'],
            'pass' => $hashed_password,
            'phone' => $object['phone'],
            'added_on' => date("Y-m-d"),
            'status' => 'A',
        );

        return $this->insert('users', $data);
    }
    public function updateUserDetails(){
        $body = file_get_contents("php://input");

        // Decode the JSON object
        $object = json_decode($body, true);
        print_r ($object);
        // print_r ($object['donor_name']);
        // echo ($_POST['donor_name']);
        $data = array(
            'user_type'=>$object['user_type'],
            'name' => $object['name'],
            'email' => $object['email'],
            'pass' => password_hash($object['pass'],PASSWORD_BCRYPT),
            'phone' => $object['phone'],
            'added_on' => date("Y-m-d"),
            'status' => $object['status'],
        );

        return $this->insert('users', $data);
    }

}
