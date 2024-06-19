<?php
    include "header.php";
    include "config.php";
    $category_id = $_GET['id'];

    $query = "SELECT * FROM category WHERE category_id = {$category_id}";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()){
        ?>  <div class="edit-form-rwapper">
                <div class="edit-form">
                    <form action="save-category-update.php" method="POST" enctype="multipart/form-data">
                        <div class="edit-head">
                            <h3>update category</h3>
                            
                        </div>
                        <div class="form-group">
                            <label for="">name</label>
                            <input type="hidden" name="categoryID" value="<?php echo $row['category_id'] ?>" >
                            <input type="hidden" name="categoryImage" value="<?php echo $row['Category_Image'] ?>">
                            <input type="text" name="categoryName" value="<?php echo $row['Category_Name'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="">ordering</label>
                            <input type="number" name="categoryOrdering" value="<?php echo $row['Ordering'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="">status</label> 
                            <select name="categoryStatus" id="">
                                <option value="<?php echo $row['Category_Status'] ?>"> <?php echo $row['Category_Status'] ?> </option>
                                <?php ($row['Category_Status'] == "active")? $status = "inactive" : $status = "active"; ?>
                                <option value="<?php echo $status;?>"> <?php echo $status;?> </option>
                            </select>
                        </div>

                        <div class="preview-wrapper">
                            <label for="">image</label>
                            <label for="fileInput" >
                                <div id="imagePreview"> 
                                    <img src="<?php echo $row['Category_Image'] ?>" alt="img" > 
                                </div> 
                            </label>
                            <input type="file" name="newImage" id="fileInput">
                        </div>

                        <div class="btn-wrapper">
                        <div class="add-pro-btn"><a href="categories.php"> <i class="fa-solid fa-arrow-left icon"></i> back</a></div>
                        <button type="submit" name="update_category">
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
                        <span>leave the field unchanged for any values you do not wish to modify. </span>
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
