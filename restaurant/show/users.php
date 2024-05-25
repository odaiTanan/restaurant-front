<?php 
require("../connect.php");
require("../validate.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try{
    
       $headers = apache_request_headers();
        if(!empty($headers["Authorization"])){
            $token=$headers["Authorization"];
            if(validateToken($token)){
    $stmt = $conn->query("SELECT * FROM users");
    $data=array();
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
      array_push($data,[
      "id"=>$row["id"],
      "name"=>$row["name"],
      "email"=>$row["email"],
      "rule"=>$row["rule"]
    ]);
  
  }
  print_r(json_encode($data));
     }
       
       
   }


}catch(PDOException $e) {
    echo  $e->getMessage();
  }

//$sql = "UPDATE users SET name='".$_POST["name"]."',email='".$_POST["email"]."',hashpassword='".$hashpassword."' WHERE id=".$_GET["id"];
?>