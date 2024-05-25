<?php 
/*imported files*/
require("../connect.php");
require("../validate.php");
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
    $stmt = $conn->query("SELECT * FROM requests");
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