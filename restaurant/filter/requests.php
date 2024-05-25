<?php 
/*imported files*/
require("../connect.php");
require("../validate.php");
require "../vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/*headers*/
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
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
    $stmt = $conn->query("SELECT * FROM requests WHERE user_id='$decoded->id'");
    $data=array();
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
      array_push($data,[
      "id"=>$row["id"],
      "user_id"=>$row["user_id"],
      "address"=>$row["address"],
      "phone"=>$row["phone"],
      "items"=>$row["items"],
      "price"=>$row["price"],
      "status"=>$row["status"],
      "user_name"=>$row["user_name"],
      
    ]);
  
  }
  print_r(json_encode($data));
     
    
        }
    }
}catch(PDOException $e) {
    echo  $e->getMessage();
  }

?>