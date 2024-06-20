<?php 
    include "config.php";
    include "function.php";

    $category_id = $_POST['categoryID'];
    $category_name = $_POST['categoryName'];
    $category_ordering = $_POST['categoryOrdering'];
    $category_status = $_POST['categoryStatus'];
    $img_data = $_FILES['newImage'];

    $uploadOK = 1;


    if(trim($_POST['categoryName']) == ""){
        $response = "<span class='r' >  Error: Please Enter Name  </span>";
        $uploadOK = 0;
    }

    if ($uploadOK) {

        if ($img_data['error'] == 4) {

            $category_image = $_POST['categoryImage'];
            $uploadOK = 1;

        } else {

            $response = uploadImage("images/category_images/", $img_data);

            if (strpos($response, "Error:") === 0) {
                $response = "<span class='r' >$response</span>";
                $uploadOK = 0;
            } else {

                $location = trim($_POST['categoryImage']);
                if (file_exists($location)) {
                    unlink($location);
                }

                $category_image = $response;
                unset($response);
                $uploadOK = 1;
            }
        }

        if ($uploadOK == 1) {

            $data = array(
                "Category_Name" => "$category_name",
                "Category_Status" => "$category_status",
                "Ordering" => "$category_ordering",
                "Category_Image" => "$category_image"
            );
            $where_clause = "category_id = $category_id";

            if (updateData("category", $data, $where_clause, $connection)) {
                header("Location: categories.php");
                exit();
            }
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
            <a href="update-category.php?id=<?php echo $category_id ?>"> <i class="fa-solid fa-arrow-left icon"></i> back</a>
        </div>
    </div>
</body>
</html>
