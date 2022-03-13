<?php
class AuthController extends BaseController
{
  public function authLogin(){

    // header("Access-Control-Allow-Origin: *");
    // header("Access-Control-Allow-Methods: POST");
    $resultData='';
    $strErrorDesc = '';
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    if (strtoupper($requestMethod) == 'POST') {

        try{
            $authModel = new AuthModel();
            $resultData = $authModel->loginUser();
            // $responseData = json_encode($resultToken);
        }catch (Error $e){
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
        // get posted data


    }else{
        $strErrorDesc = 'Method not supported';
        $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
    }

    if (!$strErrorDesc) {
        $this->sendOutput(json_encode($resultData),
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

  public function authLogout(){

  }
}