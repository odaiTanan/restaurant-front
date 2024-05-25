<?php

require("../connect.php");
require("../validate.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


try{
    if(!isset($_GET["id"])){
        die("fill all inputs");
    }
    $headers = apache_request_headers();
    if(!empty($headers["Authorization"])){
        $token=$headers["Authorization"];
        if(validateToken($token)){
            $sql = "DELETE FROM requests WHERE id = :zip1";
             $stmt = $conn->prepare($sql);
             $stmt->execute(array(':zip1' => $_GET['id']));
            echo "request deleted";
            http_response_code(200);
            
            }
    }
  
  
}catch (PDOException $e) {
    print_r($e->getMessage());
       
    }
?>