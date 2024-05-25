<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require("../connect.php");
require("../functions.php");
$EMAIL=$_POST['email'];


try{
    $stmt = $conn->query("SELECT email,hashpassword,name,rule,id FROM users WHERE email='$EMAIL'");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!empty($row) ){
    

      $token=generateToken($row["id"],$row["name"]);
      $rule=$row["rule"];
   
        if( password_verify($_POST["password"],$row['hashpassword'])){
          print_r(json_encode(["token"=>$token,
      "rule"=>$rule]));
          $id=$row["id"];
          $new_time  =date("Y-m-d H:i:s", strtotime('+2 hours', time())); 
    $sql = "UPDATE tokens SET token = :token,
    expires = :expires
    WHERE user_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
    ':token' => $token,
    ':expires' => $new_time,
    ':id' => $id,
    
    ));
    http_response_code(200);
         }else{
            echo "wrong password";
            http_response_code(403);
         }
    }else{
        echo "no user found";
        http_response_code(404);
    }
   
}catch(PDOException $e) {
    echo  $e->getMessage();
  }

?>