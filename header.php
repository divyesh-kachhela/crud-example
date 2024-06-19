<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="header">
        <?php
            session_start();
            if (isset($_SESSION['username'])) {
                #display username
                echo "Welcome, " . $_SESSION['username'] . "!";
                echo "<a href='logout.php' onclick='confirmLogout(event)'>Logout </a>";
            } else {
                #redirect to login page if not logged in
                header('Location: index.php');
                exit();
            }

            $currentUrl = $_SERVER['REQUEST_URI'];
            $currentPage = basename($currentUrl);
            $currentPage = pathinfo($currentPage, PATHINFO_FILENAME);

            $category = ["categories", "update-category", "add-category"];
            $product = ["products", "update-product", "add-product"];
            $products = array_merge($category, $product);

        ?>
    </div>

    <div class="main-section">
        <div class="sidepanel">

            <div class="links">
                <div class="sidebar">
                    <ul>
                        <li><a href="dashboard.php" <?php if($currentPage == 'dashboard') echo 'class="active"'; ?>>dashboard</a></li>
                        <li><a href="products.php" <?php if(in_array($currentPage, $products)) echo 'class="active"'; ?> >products <i class="fa-solid fa-angle-<?php echo ($currentPage == 'dashboard')? "down" : "up" ?>"> </i></a></li>
                        <ul <?php if($currentPage == 'dashboard') echo 'class="hide"'; ?>>
                            <li><a href="products.php" <?php if(in_array($currentPage, $product)) echo 'class="active"'; ?>>- all products</a></li>
                            <li><a href="categories.php" <?php if(in_array($currentPage, $category)) echo 'class="active"'; ?>>- categories</a></li>
                        </ul>
                    </ul>
                </div>  
            </div>
        </div>
        <div class="content-section">

        <!-- </div> content-section
    </div> main-section -->

    <script></script>
</body>
</html> 