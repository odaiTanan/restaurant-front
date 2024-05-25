<?php 
require("../connect.php");
require("../validate.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try{
    
        $headers = apache_request_headers();
        if(!empty($headers["Authorization"])){
            $token=$headers["Authorization"];
            if(validateToken($token)){
    $stmt = $conn->query("SELECT * FROM menu WHERE id=".$_GET['id']);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!empty($row) ){
    print_r(json_encode(["menuInformation"=>["name"=>$row["name"],"price"=>$row["price"],"type"=>$row["type"],"image"=>'http://localhost/restaurant/add/images/'.$row["image"]]]));
    }else{
        echo "no menu found";
        http_response_code(404);
    }}else{
        http_response_code(401);
        print_r(json_encode(["Error"=>"unauthorized"]));
    }

}
   
}catch(PDOException $e) {
    echo  $e->getMessage();
  }

//$sql = "UPDATE users SET name='".$_POST["name"]."',email='".$_POST["email"]."',hashpassword='".$hashpassword."' WHERE id=".$_GET["id"];
?>