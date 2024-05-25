<?php 
require "vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
require "functions.php";
function validateToken($tokens){
$token=$tokens;

    $servername = "localhost";
$username = "root";
$password = "";

try {

  $conn = new PDO("mysql:host=$servername;dbname=restaurant", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
  try {
    
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
      $stmt = $conn->query("SELECT * FROM tokens WHERE token='$token'");
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if(!empty($row) ){
         if($row["user_id"]==$decoded->id){
          return true;
         }
      }else{
          http_response_code(401);
          echo "unAuthorized";
          return false;
      }
     
  
  } catch (\Exception $e) {
    
    http_response_code(401);
    echo "unauthorized";
  }
  }
?>