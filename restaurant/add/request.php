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
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
/*PSOT requist to data base*/
if(!(isset($_POST["address"])&&isset($_POST["phone"])&&isset($_POST["items"])&&isset($_POST["price"]))){
die("Please Fill All Inputs");
}

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

 $sql = "INSERT INTO requests (user_id, address, phone, items,price,status,user_name)
    VALUES (:user_id, :address, :phone ,:items,:price,:status,:user_name)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
    ':user_id' =>$decoded->id,
    ':user_name' =>$decoded->name,
    ':address' => secure($_POST["address"]),
    ':phone' =>secure($_POST["phone"]),
    ':items'=>secure($_POST["items"]),
    ':price'=>secure($_POST["price"]),
    ':status'=>1
)      
);
echo "Request Added";
http_response_code(200);
}
    }
}catch (PDOException $e) {
     print_r($e->getMessage());
     http_response_code(501);
    }
?>