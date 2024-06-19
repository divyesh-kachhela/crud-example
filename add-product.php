<?php
	include "header.php";
    include "config.php";
	include "function.php";

    $upload_token = null;
    $fileLocations = [];

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_product'])) {
        $upload_token = 1;

        if(!$_POST['productname']){

            $response = "<span class='r' > Error: Please Enter Name </span>";
            $upload_token = 0;
        } elseif (($_POST['productsaleprice'] == "")){

            $response = "<span class='r' > Error: Please Enter price </span>";
            $upload_token = 0;
        } elseif ($_POST['productsaleprice'] == ""){

            $response = "<span class='r' > Error: Please Enter sale price </span>";
            $upload_token = 0;
        } elseif ($_POST['productquantity'] == ""){

            $response = "<span class='r' > Error: Please Enter quantity </span>";
            $upload_token = 0;
        } elseif (!isset($_POST['productstatus'])){

            $response = "<span class='r' > Error: Please select status </span>";
            $upload_token = 0;
        } elseif (($_POST['productordering'] == "")){

            $response = "<span class='r' > Error: Please Enter ordering </span>";
            $upload_token = 0;
        } else {

            // Collect data from the form
            $productName = $_POST['productname'];
            $productOrdering = $_POST['productordering'];
            $productCategories = $_POST['productcategories'];
            $productPrice = $_POST['productprice'];
            $productSalePrice = $_POST['productsaleprice'];
            $quantity = $_POST['productquantity'];
            $productStatus = $_POST['productstatus'];
            $productCode = generateCode();
        }

        if ($upload_token) {

            $mainImage = $_POST['mainImage'];


            #create filepath
            $directory = "images/product_images/";
            $pos = strrpos($directory, "/");

            #file data
            $productAdditionalFile = $_FILES['productImages'];
            $fileNames = $productAdditionalFile['name'];
            $fileType = $productAdditionalFile['type'];
            $fileTempNames = $productAdditionalFile['tmp_name'];

            foreach ($fileNames as $index => $fileName) {
                $fileLocation = $directory . $fileName;
                $fileTempName = $fileTempNames[$index];
                
                #check file format (allowed file format is JPEG or PNG)
                if ($fileType[$index] != "image/png" && $fileType[$index] != "image/jpeg") {
                    $response = "<span class='r' > Invalid format for image: ".trim($fileName).". Only JPG or PNG files are accepted. </span>";
                    $upload_token = 0;
                    
                } else {

                    if (!move_uploaded_file($fileTempName, $fileLocation)) {
                        $response = "<span class='r' > An error occurred while uploading images. </span>";
                        $upload_token = 0;
                    } else {
                        $fileLocations[] = $fileLocation;
                    }
                }
            }
        }
    }

    if ($upload_token) {

        $data = array(
            "product_name" => "$productName",
            "product_code" => "$productCode",
            "ordering" => "$productOrdering",
            "price" => "$productPrice",
            "sale_price" => "$productSalePrice",
            "quantity" => "$quantity",
            "status" => "$productStatus"
        );
        $query_response = insertData("product", $data, $connection);

        if(strpos($query_response, "Success:") === 0){
            $product_last_id = $connection->insert_id;

            foreach ($fileLocations as $index => $location) {

                $sub_name = substr($location,($pos+1));
                if ($sub_name == $mainImage) {
                    $isMainImage = 1;
                } else{
                    $isMainImage = 0;
                }

                $data = array(
                    "product_id" => "$product_last_id",
                    "image_url" => "$location",
                    "is_main_image" => "$isMainImage"
                );    
                insertData("product_images", $data, $connection);                                               
            }

            foreach ($productCategories as $category) {

                $data = array(
                    "product_id" => "$product_last_id",
                    "category_id" => "$category"
                );    
                insertData("product_categories", $data, $connection); 
            }

            $response = "<span class='g' > product added successfully. </span>";    
            echo '<meta http-equiv="refresh" content="3;url=products.php">';
        }
    } 

    $Squery = "SELECT category_id, Category_Name FROM category";
    $CategoryData = $connection->Query($Squery);  

?>

<!-- product form -->
<div class="product-form-wrapper">

        <div class="response-box">
            <?php  echo (isset($response)) ? " $response " : "" ?>
        </div>

    <div class="add-product-form">
        <div class="product-form">
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="edit-head">
				    <h3>add new product</h3>
			    </div>
                <div class="form-group">
                    <label for="productname">name</label>
                    <input type="text" name="productname" id="productname" placeholder="Enter Name" >
                </div>
                <div class="form-group">
                    <label for="price">price</label>
                    <input type="number" name="productprice" placeholder="Enter Price" id="price" min="0" step="0.01" oninput="validity.valid||(value='');">
                </div>
                <div class="form-group">
                    <label for="price">sale price</label>
                    <input type="number" name="productsaleprice" placeholder="Enter Sale Price" id="price" min="0" step="0.01" oninput="validity.valid||(value='');">
                </div>
                <div class="form-group">
                    <label for="price">quantity</label>
                    <input type="number" name="productquantity" placeholder="Enter Quantity" id="price" min="0" oninput="validity.valid||(value='');">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="productstatus">
                        <option value="" disabled selected>Select</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">ordering</label>
                    <input type="number" name="productordering" placeholder="Enter Ordering" min="0" oninput="validity.valid||(value='');">
                </div>
                <div class="form-group">
                    <label for="status">categories </label>
                    <select name="productcategories[]" multiple required>
                        <?php  while ($c_row = $CategoryData->fetch_assoc()) { ?>
                            <option value="<?php echo $c_row['category_id'] ?>"> <?php echo $c_row['Category_Name'] ?> </option>
                        <?php  } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="productImages">images</label>
                    <input type="file" id="productImages" name="productImages[]" multiple >
                    <input type="hidden" id="storeName" name="mainImage">
                </div>

                <div class="images-group">
                    <div></div>
                    <div id="imageNames"></div>
                    <div id="responseContainer"></div>
                </div>

                <div class="btn-wrapper">
                    <div class="add-pro-btn"><a href="products.php"> <i class="fa-solid fa-arrow-left icon"></i> back</a></div>
                    <button type="submit" id="upBtn" name="save_product"><i class="fas fa-database icon"></i> save</button>
                </div>
            </form>
        </div>

    </div>

    <div class="notes-wrapper">
		<div class="note-head">
			<h3>note:</h3>
		</div>
		<div class="notes">
			<span>Accepted file formats: JPEG and PNG only. </span>
		</div> 
	</div>

</div>

<!-- </div>  content-section 
</div>  main-section -->

<?php include "footer.php"; ?>

<script src="script.js"></script>

</body>
</html>


                                