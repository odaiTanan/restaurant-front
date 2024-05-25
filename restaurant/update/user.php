<?php 
require("../connect.php");
require("../validate.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try{
  $headers = apache_request_headers();
  if(!empty($headers["Authorization"])){
      $token=$headers["Authorization"];
      if(validateToken($token)){
    $hashPass=password_hash($_POST["password"],PASSWORD_DEFAULT);

    $sql = "UPDATE users SET name = :name,
    email = :email, hashpassword = :password, rule=:rule
    WHERE id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
    ':name' => $_POST['name'],
    ':email' => $_POST['email'],
    ':password' => $hashPass,
    ':user_id'=>$_GET['id'],
    ':rule'=>$_POST["rule"]
    )); 
    http_response_code(200);
    echo "user updated";
  }
  }
   
}catch(PDOException $e) {
    echo  $e->getMessage();
  }

?>