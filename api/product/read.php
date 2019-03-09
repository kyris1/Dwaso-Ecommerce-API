<?php
/**
 * Created by PhpStorm.
 * User: Bra Emma
 * Date: 1/19/2019
 * Time: 2:15 PM
 */

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../config/database.php";
include_once "../objects/product.php";
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$stmt = $product->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $products_arr = array();
    $products_arr["products"] = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $product_item = array(
            "product_id"=> $product_id,
            "title"=> $title,
            "price"=> $price,
            "list_price"=> $list_price,
            "quantity"=> $quantity,
            "image"=> $image,
            "category_name"=> $category_name,
            "category_id"=> $category_id,
            "brand_name"=> $brand_name,
            "brand_id"=> $brand_id,
            "description"=> $description,
            "keywords"=> $keywords,
            "sizes"=> $sizes,
            "color"=> $color,
            "memory"=> $memory,
            "tags"=> $tags,
            "included"=> $in_the_box,
            "features"=> $features
        );
        array_push($products_arr["products"], $product_item);
    }
    http_response_code(200);
    echo json_encode($products_arr);
}else{
    http_response_code(400);
    echo json_encode(
        array("message" => "No products found.")
    );
}