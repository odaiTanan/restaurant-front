<?php
require("validate.php");
require "vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try{
    $headers = apache_request_headers();
    if(!empty($headers["Authorization"])){
        $token=$headers["Authorization"];
        if(validateToken($token)){
            $decoded = JWT::decode($token, new Key(<<<EOK
            -----BEGIN PUBLIC KEY-----
            MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAkHwzPdohMqy2Ea83ejmB
            QpTWd0fp0ca4TqMd1V2oVW4wkNiSpYtPs65Cg96ixghUMPjv2Q8kekZDFXbJLDcA
            QP0CbwOgA/bgqvcfUlsZeSokDDqiTspQlIT089yv5vxpt2enfqVUdLw4jvF6vHWj
            5vBMg5zmc3XFUzv/IBnmdbutgGxDQd5UUyGuvVD479CtRJykRKISCQiyglYDpIdf
            nIuGKOeo2qvHtYEGyfGQ97UcSaS19cDrXLLAHCEb4ncsuDVvDlXfozdY2URZWmrX
            3lOHECnKT0Ww3dVAmHVoOEI6zPzYQMoUnJj0u+G5Uhss5Z2LSI6V102zLVII3siS
            JwIDAQAB
            -----END PUBLIC KEY-----
            EOK
            , 'RS256'));

  $new_time  =date("Y-m-d H:i:s", strtotime('+2 hours', time())); 
$newToken= generateToken($decoded->id,$decoded->name);

  $sql = "UPDATE tokens SET token = :newtoken,
  expires = :expires WHERE user_id = :user_id";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array(
  ':newtoken' =>$newToken,
  ':expires' => $new_time,
 ':user_id'=>$decoded->id
  ));   
  $query2 = "SELECT * FROM users WHERE id='$decoded->id'" ;
$stmt2 = $conn->query($query2);
$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
if(!empty($row2) ){
 
  $rule=$row2["rule"];
  print_r(json_encode(["token"=>$newToken,"rule"=>$rule]));}
 }
    }
 
}catch(PDOException $e) {
  echo  $e->getMessage();
}
 


?>