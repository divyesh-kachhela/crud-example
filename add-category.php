<?php 
	include "header.php";
	include "function.php";

	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_category'])) {
        
        if(!$_POST['categoryname']){

            $response = "<span class='r' >Error: Please Enter Name</span>";

        } elseif (!$_POST['categoryordering']){

            $response = "<span class='r' >Error: Please Enter Ordering</span>";

        } elseif (!isset($_POST['categorystatus'])){

            $response = "<span class='r' >Error: Please Select Status</span>";

        } elseif ($_FILES['categoryimage']['error'] == 4){

            $response = "<span class='r' >Error: Please Select Image</span>";

        } else{

            $categoryName = $_POST['categoryname'];
            $categoryStatus = $_POST['categorystatus'];
            $categoryOrdering = $_POST['categoryordering'];
            $uploadedFile = $_FILES['categoryimage'];

            $directory = "images/category_images/";
            $response = uploadImage($directory, $uploadedFile);


            if (strpos($response, "Error:") === 0) {

                $response = "<span class='r' >$response</span>";
                 
            } else {

                $filelocation = $response;
                unset($response);

                $data = array(
                    "Category_Name" => "$categoryName",
                    "Category_Status" => "$categoryStatus",
                    "Ordering" => "$categoryOrdering",
                    "Category_Image" => "$filelocation"
                );

                $response = insertData("category", $data, $connection);

                if (strpos($response, "Error:") === 0) {

                    $response = "<span class='r' > Failed to add category. </span>";
                     
                } elseif (strpos($response, "Success:") === 0){
        
                    $response = "<span class='g' > Category added successfully. </span>";
        
                    echo '<meta http-equiv="refresh" content="3;url=categories.php">';
                    //header("Location: dashboard.php");
                }
            }
        }
    }


?>

<div class="category-form-wrapper">
	<div class="response-box">
		<?php echo (isset($response)) ? " $response " : "" ?>
	</div>

	<div class="add-category-form">	
		<form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
			<div class="edit-head">
				<h3>add new category</h3>
			</div>

			<div class="form-group">
				<label for="name">name</label>
				<input type="text" name="categoryname" placeholder="Enter Name" >
			</div>

			<div class="form-group">
				<label for="ordering">Ordering</label>
				<input type="number" name="categoryordering" id="ordering" placeholder="Enter Ordering" min="1">
			</div>

			<div class="form-group">
				<label for="status">Status</label>
				<select name="categorystatus">
					<option value="" disabled selected>Select</option>
					<option value="active">Active</option>
					<option value="inactive">Inactive</option>
				</select>
			</div>

			<div class="form-group">
				<label for="image">Image</label>
				<input type="file" name="categoryimage">
			</div>

			<div class="btn-wrapper">
				<div class="add-pro-btn"><a href="categories.php"> <i class="fa-solid fa-arrow-left icon"></i> back</a></div>
				<button type="submit" name="save_category">
					<i class="fas fa-database icon"></i> Save
				</button>
			</div>
		</form>
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
 <script src="script.js" ></script>
</body>
</html>
