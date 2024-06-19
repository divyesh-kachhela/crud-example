<?php
    include "config.php";
    include "function.php";
    $product_id = $_GET['id'];

    $query = "SELECT GROUP_CONCAT(image_url SEPARATOR ',.') AS urls FROM product_images WHERE product_id = {$product_id}";
    $result = $connection->query($query);
    $image_location = $result->fetch_assoc();
    $image_locations = $image_location['urls'];
    
    if (!empty($image_locations)) {
        $location_array = explode(",.", $image_locations);
    
        foreach ($location_array as $value) {
            $value = trim($value);

            if (file_exists($value)) {
                unlink($value);
            }
        }
    }
    
    $where_clause = "product_id = $product_id";
    deleteData("product", $where_clause, $connection);

    header("Location: products.php");
    $connection->close();
?>