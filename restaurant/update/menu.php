<?php 
require("../connect.php");
require("../validate.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try{
    if(!(isset($_POST["name"])&&isset($_POST["price"])&&isset($_POST["type"]))){
        die("Please Fill All Inputs");
        }
  $headers = apache_request_headers();
  if(!empty($headers["Authorization"])){
      $token=$headers["Authorization"];
      if(validateToken($token)){
        if(isset($_FILES["image"])){
            $fileName=$_FILES["image"]["name"];
            $tempName=$_FILES["image"]["tmp_name"];
            $folder='images/'.$fileName;

    $sql = "UPDATE menu SET name = :name,
    price = :price, image=:image, type = :type
    WHERE id = :menu_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
    ':name' => $_POST['name'],
    ':price' => $_POST['price'],
   
    ':image' =>$fileName,
    ':type'=>$_POST['type'],
    ':menu_id'=>$_GET['id'],
    
    )); 
   if(move_uploaded_file($tempName,$folder)){
        echo "item updeted succesfully";
        http_response_code(200);
   }}else{
    $sql = "UPDATE menu SET name = :name,
    price = :price,  type = :type
    WHERE id = :menu_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
    ':name' => $_POST['name'],
    ':price' => $_POST['price'],
    ':type'=>$_POST['type'],
    ':menu_id'=>$_GET['id'],
    
    )); 
   }
    
  }
  }
   
}catch(PDOException $e) {
    echo  $e->getMessage();
  }

?>