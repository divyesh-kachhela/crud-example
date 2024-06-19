<?php
    include "header.php";
    include "config.php";
    $product_id = $_GET['id'];

    $query = "SELECT P.product_id, P.product_name, P.price, P.sale_price, P.quantity, P.ordering, P.status, PI.image_url
    FROM product AS P
    JOIN product_images AS PI ON P.product_id = PI.product_id
    WHERE P.product_id = {$product_id} AND PI.is_main_image = 1";
    $result = $connection->query($query);

    $imgQuery = "SELECT image_url, is_main_image, image_id FROM product_images WHERE product_id = {$product_id}";
    $iamge_location = $connection->query($imgQuery);

    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()){
        ?>  <div class="edit-form-rwapper">
                <div class="edit-form">
                    <form action="save-product-update.php" method="POST" enctype="multipart/form-data">
                        <div class="edit-head">
                            <h3>update product</h3>
                            
                        </div>
                        <div class="form-group">
                            <label for="">name</label>
                            <input type="hidden" name="productID" value="<?php echo $row['product_id'] ?>">
                            <input type="hidden" name="productImage" value="<?php echo $row['image_url'] ?>">
                            <input type="hidden" name="newMainImg" id="dataIn">
                            <input type="text" name="productName" value="<?php echo $row['product_name'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="price">price</label>
                            <input type="number" name="productPrice"  value="<?php echo $row['price'] ?>" id="price" min="0" step="0.01" oninput="validity.valid||(value='');" required>
                        </div>

                        <div class="form-group">
                            <label for="price">sale price</label>
                            <input type="number" name="productSalePrice" value="<?php echo $row['sale_price'] ?>" id="price" min="0" step="0.01" oninput="validity.valid||(value='');" required>
                        </div>

                        <div class="form-group">
                            <label for="price">quantity</label>
                            <input type="number" name="productQuantity" id="price" value="<?php echo $row['quantity'] ?>" min="0"  oninput="validity.valid||(value='');" required>
                        </div>

                        <div class="form-group">
                            <label for="">ordering</label>
                            <input type="number" name="productOrdering" value="<?php echo $row['ordering'] ?>" min="0" required>
                        </div>

                        <div class="form-group">
                            <label for="">status</label> 
                            <select name="productStatus" id="">
                                <option value="<?php echo $row['status'] ?>"> <?php echo $row['status'] ?> </option>
                                <?php ($row['status'] == "active")? $status = "inactive" : $status = "active"; ?>
                                <option value="<?php echo $status;?>"> <?php echo $status;?> </option>
                            </select>
                        </div>

                        <label for="">images</label>

                        <div class="all-imgs">
                            <?php 
                                if ($iamge_location->num_rows > 0) { 
                                    while($img_row = $iamge_location->fetch_assoc()){ ?>

                                        <div class="imgbox <?php echo ($img_row['is_main_image'] == 1)? "selected" : ""; ?>">

                                            <img src="<?php echo $img_row['image_url'] ?>" alt="img" data-id="<?php echo $img_row['image_id'] ?>">
                                        </div> <?php 
                                    } 
                                } ?>
                        </div>



                        <div class="btn-wrapper">
                            <div class="add-pro-btn"><a href="products.php"> <i class="fa-solid fa-arrow-left icon"></i> back</a></div>
                            <button type="submit" name="update_product">
                                update  
                            </button>
                        </div>
                    </form>
                </div>
                <div class="notes-wrapper">
                    <div class="note-head">
                        <h3>note:</h3>
                    </div>
                    <div class="notes">
                        <span>leave the field unchanged for any values you do not wish to modify.</span>
                    </div> 
                </div>

                

       

            </div>
        <?php
        }


    }
    #Close the database connection
	$connection->close();
?>

<!-- </div>  content-section 
</div>  main-section -->

<?php include "footer.php"; ?>

<script src="script.js"></script>
</body>
</html> 