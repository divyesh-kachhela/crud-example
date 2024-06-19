<?php
    include "config.php";
    include "function.php";
    $category_id = $_GET['id'];

    $query = "SELECT Category_Image FROM category WHERE category_id = {$category_id}";
    $result = $connection->query($query);
    $image_location = $result->fetch_assoc();
    $image_location = $image_location['Category_Image'];
    $image_location = trim($image_location);

    if(file_exists($image_location)){
        unlink($image_location);
    }

    $where_clause = "category_id = $category_id";
    deleteData("category", $where_clause, $connection);

    header("Location: categories.php");
    $connection->close();
?>  
