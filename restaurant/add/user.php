<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include("../connect.php");
include("../validate.php");
if(!(isset($_POST["name"])&&isset($_POST["email"])&&isset($_POST["password"]))){
die("Please Fill All Inputs");
}
if(! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    die("Not Valid Email");
}
if((!((preg_match('/[a-z]/',$_POST["password"]))&&(preg_match('/[A-Z]/',$_POST["password"]))&&(preg_match('/[0-9]/',$_POST["password"]))))||strlen($_POST["password"]<=8)){
die("password must have small and capital letters and numbers and must be more than 8 characters");
}
$hashPass=password_hash($_POST["password"],PASSWORD_DEFAULT);
   try{
    $headers = apache_request_headers();
    if(!empty($headers["Authorization"])){
        $token=$headers["Authorization"];
        if(validateToken($token)){
 $sql = "INSERT INTO users (name, email, hashpassword,rule)
    VALUES (:name, :email, :password,:rule)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
    ':name' =>secure( $_POST['name']),
    ':email' => secure($_POST['email']),
    ':password' =>secure($hashPass),
    ':rule'=> secure($_POST["rule"])
)
    
);

$EMAIL=$_POST["email"];
$query = "SELECT * FROM users WHERE email='$EMAIL'" ;
$stmt = $conn->query($query);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if(!empty($row) ){
  $userId=$row["id"];
  $token= generateToken($userId);
  $new_time  =date("Y-m-d H:i:s", strtotime('+2 hours', time())); 
 $sql2 = "INSERT INTO tokens (user_id , token,expires)
  VALUES (:user, :token , :expires)";
  $stmt = $conn->prepare($sql2);
  $stmt->execute(array(
  ':user' =>$userId,
  ':token' =>$token ,
  ':expires'=>$new_time
  )
  
  );}}
}else{echo "not found";}


echo "user added succesfully";
}catch (PDOException $e) {
    if(    $stmt->errorInfo()[1]==1062){
    print_r(json_encode(["Error"=>"Email address already taken"]));
    echo http_response_code(409);
      } else{  print_r($e->getMessage());
       }
    }