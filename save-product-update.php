<?php 
    include "config.php";
    include "function.php";

    $product_id = $_POST['productID'];
    $product_name = $_POST['productName'];
    $product_price = $_POST['productPrice'];
    $product_sale_price = $_POST['productSalePrice'];
    $product_quantity = $_POST['productQuantity'];
    $product_ordering = $_POST['productOrdering'];
    $product_status = $_POST['productStatus'];

    $uploadOK = 1;

    if(trim($_POST['productName']) == ""){  
        $response = "<span class='r' >  Error: Please Enter Name  </span>";
        $uploadOK = 0;
    }


    if ($uploadOK) {  
        
        $result = $connection->query("SELECT image_id FROM product_images WHERE product_id = '{$product_id}' AND  is_main_image = 1");
        $row = $result->fetch_assoc();
        $current_img_id = $row['image_id'];


        if (!empty($_POST['newMainImg'] && $_POST['newMainImg'] !== $current_img_id)) {
            
            $new_img_id = $_POST['newMainImg'];
    
            $data = array(
                "is_main_image" => 0
            );
            $where_clause = "image_id = $current_img_id";
            updateData("product_images", $data, $where_clause, $connection);


            $data = array(
                "is_main_image" => 1
            );
            $where_clause = "image_id = $new_img_id";
            updateData("product_images", $data, $where_clause, $connection);
        }


        $data = array(
            "product_name" => "$product_name",
            "price" => "$product_price",
            "sale_price" => "$product_sale_price",
            "quantity" => "$product_quantity",
            "ordering" => "$product_ordering",
            "status" => "$product_status"
        );
        $where_clause = "product_id = $product_id";

        if (updateData("product", $data, $where_clause, $connection)) {
            header("Location: products.php");
            exit();
            $connection->close();
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update category</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .response-wrapper{
            width: fit-content;
            margin-inline: auto;
            margin-top: 100px;
        }
        .add-pro-btn{
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="response-wrapper">
        <div class="response-box">
            <?php echo (isset($response)) ? " $response " : "" ?>
        </div> 
        <div class="add-pro-btn">
            <a href="update-product.php?id=<?php echo $product_id ?>"> <i class="fa-solid fa-arrow-left icon"></i> back</a>
        </div>
    </div>
</body>
</html>