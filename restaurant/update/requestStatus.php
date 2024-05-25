<?php 
require("../connect.php");
require("../validate.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try{
    if(!(isset($_POST["status"])||isset($_GET["id"]))){
        die("MISSED INPUT OR ID");
        http_response_code(403);
    }
  $headers = apache_request_headers();
  if(!empty($headers["Authorization"])){
      $token=$headers["Authorization"];
      if(validateToken($token)){

    $sql = "UPDATE requests SET status = :status WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
    ':status' => $_POST['status'],
    ':id'=>$_GET["id"]
    )); 
    http_response_code(200);
    echo "user updated";
  }
  }
   
}catch(PDOException $e) {
    echo  $e->getMessage();
  }

?>