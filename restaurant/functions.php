<?php 
require("connect.php");
require "vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

 class getKeys{
   public function __construct(){
    $this->generateKes();
   } 
   private function generateKes(){
    $confing=[
        'private_key_bits'=>2048,
        'private_key_type'=>OPENSSL_KEYTYPE_RSA
    ];
    $privateKey=openssl_pkey_new($confing);
    openssl_pkey_export($privateKey,$privateKeyPEM);
    $publicKeyDetails=openssl_pkey_get_details($privateKey);
    $publicKeyPEM=$publicKeyDetails["key"];
    file_put_contents('www/keys/privatekey.pem',$privateKeyPEM); 
    file_put_contents('www/keys/publicKey.pem',$publicKeyPEM); 
   }
   
}
function secure($inp){
  

return htmlspecialchars(strip_tags($inp));
}

function generateToken($id,$name){
  
  
  $payload = [
 
    'iat' => time(),
    'exp'=>time() + 3600,
    'id'=>$id,
    'name'=>$name
    
];
$jwt = JWT::encode($payload,<<<EOK
-----BEGIN PRIVATE KEY-----
MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCQfDM92iEyrLYR
rzd6OYFClNZ3R+nRxrhOox3VXahVbjCQ2JKli0+zrkKD3qLGCFQw+O/ZDyR6RkMV
dsksNwBA/QJvA6AD9uCq9x9SWxl5KiQMOqJOylCUhPTz3K/m/Gm3Z6d+pVR0vDiO
8Xq8daPm8EyDnOZzdcVTO/8gGeZ1u62AbENB3lRTIa69UPjv0K1EnKREohIJCLKC
VgOkh1+ci4Yo56jaq8e1gQbJ8ZD3tRxJpLX1wOtcssAcIRvidyy4NW8OVd+jN1jZ
RFlaatfeU4cQKcpPRbDd1UCYdWg4QjrM/NhAyhScmPS74blSGyzlnYtIjpXXTbMt
UgjeyJInAgMBAAECggEAEX4f/BCRLV/wqSJ0DoWwyx1W+9kGi4HKJaclAQSWUUWG
drrpwkYkD6Z84hdN0LkIbGdvLnHhYjZof8xCXeqIytV2+nbPZDt7BuflcGScKGm8
NIjSxsRCzkBsoaup1kbgC7budexRVdLF7DR7Ph7mCZs1QEf6NKdhDQs5/6pzFvTD
1h3pQEh9EkQhl1B3URDeWsq7H3Ap/RHLiQrM8Tjd2DU8jEhbeLq7twELlJ01QAQr
CyyYZfy7GE/x89LzW5yG7FB7iDo60S6OzVKCWnb+Z6OBZl4pyyNBFQku8CrsEhCV
xqRtsb6QdDmvVDc4E99NSlXoz2ghEJTOQFSPJJJgQQKBgQC3wluo2/8It2d0AmfI
tEFPfcqP1YhZMQ3PrmYjXWvaMtmOGLVv3E0XgZk4SGnPEcBwi/EXRoVy4G6iuACe
t4nxhtpZMhvXOKV2BoSQDyEqTji8+2iknUMm/FRdqgtGSM1+5uQSAdLpldhQBvMd
mv32YO+xY+CZ6O/dqp75oPvFwQKBgQDJSUbX61+lmdl/fJ+CS6djuWVeVGBiB4c7
VW89R0qHIvgzJ4rYFd4iLzPiASh0FgQPFmQu4vKVT+KrIpG685jsgXBBcT8UrfUl
sdBEgwNQZVdleCiIVVRemvMFklpxyiMxAqj7/hLsy6wfIuclUanQn6U/f8JgP+88
5Yv9Dmth5wKBgQCWhNtzu5Bx4VkaS4Ybfpsos88idjRTarz3atE7EqDvgEt3+4FS
+U8kfAG3eolBFjddeSOofxl8eZ3mJ3ZKi+iwMFfWTBdF+Z5+yOP45Iu0DZKoKf8T
J8YDvxiUCF9n2OaKljInFdtffmBLXQXzMCvqjoiH81nceFNSbRn/PAA/gQKBgGSL
FbgE+mHd16a2uXZ8E8DceqYDv6E34XTh2A7j7XZTIWdr+Q623Z51tZTOv0Y9OQnQ
RXqmIkYzASY6vlCEHX8FqO0HhFrwCeQqTb3rM1yVQnKM8rIm7V3USFAgKs1sCugQ
TBiTcSCXHALxjEQ35nsvQ3vUdWNejEH+504gRcNBAoGAffmRo0P4VBuQ905r8OQw
jlQQ/grEk6MuL3M1Q5K0JZNZeLeitEUjrH9mUOxqNoorIlEp+y77W8VSmtnw7o52
NgahSgKY5buRyBI+NLSnTX0e6NRROAUluaZwiU3QpTJG3JLlV117yYT3R7rtyyka
14FtYYVgndAzQbZwyaXYuBY=
-----END PRIVATE KEY-----
EOK
 , 'RS256');
return $jwt;
 }


?>