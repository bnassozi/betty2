<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
include_once '../config/database.php';
include_once '../objects/product.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
$product = new Product($db);
$product->id = isset($_GET['id']) ? $_GET['id'] : die();
$product->readOne();
  
if($product->name!=null){
    // create array
    $product_arr = array(
        "id" =>  $product->id,
        "name" => $product->name,
    );
 
    http_response_code(200);
    echo json_encode($product_arr);
}
  
else{
    http_response_code(404);
    echo json_encode(array("message" => "profile name or contact does not exist."));
}
?>