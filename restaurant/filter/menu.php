<?php 
require("../connect.php");
require("../validate.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try{
    if(isset($_GET["type"])){
       $headers = apache_request_headers();
        if(!empty($headers["Authorization"])){
            $token=$headers["Authorization"];
            if(validateToken($token)){
               $type= $_GET["type"];
            
                
    $stmt = $conn->query("SELECT * FROM menu WHERE type='$type'");
    $data=array();
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
      array_push($data,json_encode([
      "id"=>$row["id"],
      "name"=>$row["name"],
      "price"=>$row["price"],
      "image"=>"http://localhost/restaurant/add/images/".$row["image"],
      "type"=>$row["type"]
    ]));
  
  }
  print_r($data);
     }
       
       
   }
}


}catch(PDOException $e) {
    echo  $e->getMessage();
  }

//$sql = "UPDATE users SET name='".$_POST["name"]."',email='".$_POST["email"]."',hashpassword='".$hashpassword."' WHERE id=".$_GET["id"];
?>