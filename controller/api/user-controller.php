<?php
class UserController extends BaseController
{
    /**
     * "/users/list" Endpoint - Create user
     */
    public function listAllUsers()
    {
        $responseData = '';
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        // $arrQueryStringParams = $this->getQueryStringParams();
 
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $userModel = new UserModel();
                $arrDonations = $userModel->listAllUsers();
                $responseData = json_encode($arrDonations);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
 
        // send output
        if (!$strErrorDesc) {
            // print_r($responseData);
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')              
            );
            // echo('The data from the donations table are');
            // echo($responseData);
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    /**
     * "/users/create" Endpoint - create new user
     */
    public function createUser()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
 
        if (strtoupper($requestMethod) == 'POST') {
            try {
                $userModel = new UserModel();
 
                $userModel->createUser();
                
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
 
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(json_encode(array('message'=>'User created successfully')),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')              
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

     /**
     * "/users/update" Endpoint - update user details
     */
    public function updateUserDetails()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
 
        if (strtoupper($requestMethod) == 'POST') {
            try {
                $userModel = new UserModel();
 
                $userModel->updateUserDetails();
                
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
 
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(json_encode(array('message'=>'User details updated successfully')),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')              
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}
