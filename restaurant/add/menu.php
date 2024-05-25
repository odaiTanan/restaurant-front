<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include("../connect.php");
include("../validate.php");
if(!(isset($_POST["name"])&&isset($_POST["price"])&&isset($_FILES["image"]))){
die("Please Fill All Inputs");
}else{
$fileName=$_FILES["image"]["name"];
$tempName=$_FILES["image"]["tmp_name"];
$folder='images/'.$fileName;

}

 try{
    $headers = apache_request_headers();
    if(!empty($headers["Authorization"])){
        $token=$headers["Authorization"];
        if(validateToken($token)){
 $sql = "INSERT INTO menu (name, price, image,type)
    VALUES (:name, :price, :image ,:type)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
    ':name' =>secure($_POST["name"]),
    ':price' => secure($_POST['price']),
    ':image' => $fileName,
    ':type'=>secure($_POST["type"])
)      
);
if(move_uploaded_file($tempName,$folder)){
    echo "item added succesfully";
    http_response_code(200);
}else{
    echo "error";
}
}
    }
}catch (PDOException $e) {
     print_r($e->getMessage());
       
    }
    ?>