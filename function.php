<?php 
    include "config.php";

    function overviewData($tableName, $connection){

        $productCount = $connection->query("SELECT COUNT(*) AS 'count' FROM $tableName");
        $totalproduct = $productCount->fetch_assoc();
        return $totalproduct['count'];
    }


    function recentProduct($connection){
        $recentProduct = $connection->query("        
        SELECT P.product_name, P.price, C.Category_Name, P.status 
        FROM product AS P
        JOIN product_categories AS J ON J.product_id = P.product_id
        JOIN category AS C ON J.category_id = C.category_id
        ORDER BY P.product_id DESC LIMIT 1;");

        $tableRows = '';
        if ($recentProduct->num_rows > 0) {
            while ($row = $recentProduct->fetch_assoc()) {
                $tableRows .= "<tr>
                    <td>$row[product_name]</td>
                    <td>$row[price]</td>
                    <td>$row[Category_Name]</td>
                    <td><span class='round " . (($row['status'] == 'active') ? 'green' : 'red') . " '></span>$row[status]</td>
                </tr>";
            }
            return $tableRows;
        } else {
            return "0 recent product found";
        }
    }
 

    #function for calculate total pages
    function total_pages($connection, $query, $row_par_page){
        #total rows exisist in database 
        $rowdata = $connection->Query($query);
        $total_rows = $rowdata->num_rows;

        return ceil($total_rows / $row_par_page);
    }


    #function for generate pagination
    function generatePagination($currentpage, $total_pages) {
        $output = '';

        #check if the current page is set
        if (!isset($currentpage)) {
            $currentpage = 1; #default to page 1 if not set
        }

        if($currentpage > 1){
            $output .= "<a href='#' id='".($currentpage - 1)."' class='next'> <i class='fa-solid fa-angle-left arrow-icons'></i> </a>";
        } else {
            
            $output .= "<span class='disable'> <i class='fa-solid fa-angle-left arrow-icons'></i> </span>";
        }
         
        #generate links for each page
        for ($i = 1; $i <= $total_pages; $i++) {

            $output .= '<a href="#" id="' . $i . '" class="' . ($currentpage == $i ? 'active' : '') . '">' . $i . '</a>';
        }

        if($currentpage < $total_pages){
            $output .= "<a href='#' id='".($currentpage + 1)."' > <i class='fa-solid fa-angle-right arrow-icons'></i> </a>";
        } else {

            $output .= "<span class='disable'> <i class='fa-solid fa-angle-right arrow-icons'></i> </span>";
        }

        #return the generated HTML
        if($total_pages > 1){
            return $output;
        }
    }
 

    #function for upload image
    function uploadImage($directory, $uploadedFile){
        #collect data frome $FILSE array and store in custom variables
		$fileName = $uploadedFile['name'];
		$fileType = $uploadedFile['type'];
		$fileTempName = $uploadedFile['tmp_name'];

        #create filepath
        $filelocation = $directory . $fileName;

        #check file format (allowed file format is JPEG or PNG)
		if ($fileType != "image/png" && $fileType != "image/jpeg") {

            return "Error: Only JPEG or PNG files are allowed.";
		} else{

            if (move_uploaded_file($fileTempName, $filelocation)) {

                return $filelocation;   
            } else {
                
                return "Error: Failed to upload file.";
            }
        }
    }
 

    #function to generate a unique product code
    function generateCode(){
        $prefix = 'PROD';
        $timestamp = mt_rand(1111, 9999); # get the randem four digits  

        #concatenate the parts to form the product code
        $product_code = $prefix . '-' . $timestamp;
        return $product_code;
    }


    #function for preform calculations using aggregate function
    function calculations($connection, $aggregate_function_name, $column_name, $table_name){
        $fun = $aggregate_function_name;
        $Data = $connection->Query("SELECT $fun($column_name) AS 'data' FROM $table_name");
        $row = $Data->fetch_assoc();
        return $row['data'];   
    }


    #function for insert data
    function insertData($table_name, $data, $connection){

        $column_name = implode(",", array_keys($data));
        $placeholders = implode(",", array_fill(0, count($data), "?"));

        $sql = "INSERT INTO $table_name ($column_name) VALUES ($placeholders)";
        $stmt = $connection->prepare($sql);

        if($stmt){

            $values = array_values($data);
            $types = "";
            foreach($values as $value){
                if (is_int($value)) {
                    $types .= "i";
                } else if(is_double($value)){
                    $types .= "d";
                } else if(is_string($value)){
                    $types .= "s";
                } else {
                    $types .= "s";
                }
            }

            $stmt->bind_param($types, ...$values);

            if ($stmt->execute()) {
                return "Success: Data added successfully.";
            }
            
        } else{
            return "Error: Failed to add Data.";
        }
    }


    #function for update data
    function updateData($table_name, $data, $where_clause, $connection){
        $updateQuery = "UPDATE " . $table_name . " SET ";
        
        $setValues = [];
        foreach ($data as $key => $value) {
            $escaped_value = $connection->real_escape_string($value);
            $setValues[] = "$key = '$escaped_value'";
        }
        
        $updateQuery .= implode(", ", $setValues);
        
        $updateQuery .= " WHERE " . $where_clause;
        
        if ($connection->query($updateQuery)) {
            return true; 
        } else {
            return false; 
        }
    }

    #function for delete data
    function deleteData($table_name, $where_clause, $connection) {
        $sql = "DELETE FROM $table_name WHERE $where_clause";
    
        if ($connection->query($sql)) {
            return "Success: Data deleted successfully.";
        } else {
            return "Error: Failed to delete data. " . $connection->error;
        }
    }

?>
