<?php
    require "header.php";
    include "config.php";
    include "function.php";

    #initialize sorting variables
	$COLUMN_NAME = isset($_SESSION['COLUMN_NAME']) ? $_SESSION['COLUMN_NAME'] : 'product_id';
	$SORT_ORDER = isset($_SESSION['SORT_ORDER']) ? $_SESSION['SORT_ORDER'] : 'DESC';

	#update sorting variables
	if (isset($_POST['ProductData']) && isset($_POST['ProductOrder'])) {
		$COLUMN_NAME = $_POST['ProductData'];
		$SORT_ORDER = $_POST['ProductOrder'];

		#store sorting variables in session
		$_SESSION['COLUMN_NAME'] = $COLUMN_NAME;
		$_SESSION['SORT_ORDER'] = $SORT_ORDER;
	}

	#unset sessions 
	if (isset($_POST['resetOrder']) || $_SERVER['REQUEST_METHOD'] == 'GET') {
		
		unset($_SESSION['COLUMN_NAME']);
		unset($_SESSION['SORT_ORDER']);

		$SORT_ORDER = "DESC";
		$COLUMN_NAME = "product_id";
	}

	#pagination variable 
	$row_par_page = 10;
	$currentpage = isset($_POST['productPageSend']) ? $_POST['productPageSend'] : 1;
	$offset = ($currentpage - 1) * $row_par_page;

    // Initialize SQL query
    $productQuery = "SELECT P.*, PI.image_url, GROUP_CONCAT(C.Category_Name SEPARATOR ', ') AS Categories
    FROM product AS P 
    JOIN product_images AS PI ON PI.product_id = P.product_id
    LEFT JOIN product_categories AS PC ON PC.product_id = P.product_id
    LEFT JOIN category AS C ON C.category_id = PC.category_id
    WHERE PI.is_main_image = 1";


    // Filter by product price
    if (!empty($_POST['proMinP'])) {

        $min = $_POST['proMinP'];
        $productQuery .= " AND price >= $min";
    }

    if (!empty($_POST['proMaxP'])) {

        $max = $_POST['proMaxP'];
        $productQuery .= " AND price <= $max";
    }

    // Filter by product name
    if (!empty($_POST['proName'])) {
        $proName = $connection->real_escape_string($_POST['proName']);
        $productQuery .= " AND P.product_name LIKE '%$proName%'";
    }

    // Filter by product code
    if (!empty($_POST['proCode'])) {
        $proCode = $connection->real_escape_string($_POST['proCode']);
        $productQuery .= " AND P.product_code LIKE '%$proCode%'";
    }

    // Filter by product status
    if (!empty($_POST['proStatus'])) {

        if ($_POST['proStatus'] !== 'all') {
            $proStatus = $connection->real_escape_string($_POST['proStatus']);
            $productQuery .= " AND P.status = '$proStatus'";
        }
    }

    $productQuery .= " GROUP BY P.product_id, P.product_name, PI.image_url
    ORDER BY $COLUMN_NAME $SORT_ORDER";

    #calculates total pages
    $total_product_pages = total_pages($connection, $productQuery, $row_par_page);

    $productQuery .= " LIMIT $offset, $row_par_page";
    $productData = $connection->query($productQuery);
?>

<div class="product-section">
    <div class="heading f-case">
        <h2>all products</h2> 
        <div class="add-btn">
            <a href="add-product.php" class="blue-btn"><i class="fa-solid fa-plus"></i></a>
        </div>
    </div>

    <!-- product table code -->
    <div class="table-section">
        <div class="product-table">

            <div class="filters f-case">
                <div class="inputs">
                    <div class="filter-form-group">
                        <label for="search name">name</label>
                        <input type="text" id="searchProductName" placeholder="Search By Name">
                    </div>
                    <div class="filter-form-group">
                        <label for="search code">code</label>
                        <input type="text" id="searchProductCode" placeholder="Search By Code">
                    </div>
                </div>

                <div class="filter-form-group">
                    <label for="">status</label>
                    <select id="searchProductStatus">
                        <option value="all">All</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="filter-form-group">
                    <div class="price-label">
                        <label for="">min price</label>
                        <label for="">max price</label>
                    </div>
                    <div class="range-box">
                        <input type="number" id="minPrice" placeholder="Min Price" min="1" oninput="validity.valid||(value='');">
                        <input type="number" id="maxPrice" placeholder="Max Price" min="0" oninput="validity.valid||(value='');">
                    </div>
                </div>

                <div class="filters-btns">  
                    <button class="blue-btn" id="filterProduct"><i class="fa-solid fa-filter icon"></i> filter</button>
                    <button class="black-btn" id="clear-product-filter"></i> clear</button>
                </div>
            </div>

            <div id="product-order">
                <table id="tg">
                    <thead>
                        <tr>
                            <th>image</th>
                            <th onclick="sortProduct('product_name', 'true')" class="btn">name <i class="fa-solid fa-sort"></i></th>
                            <th>code</th>

                            <th onclick="sortProduct('price')" class="btn">price <i class="fa-solid fa-sort"></i></th>
                            <th onclick="sortProduct('sale_price')" class="btn">sale price <i class="fa-solid fa-sort"></i></th>
                            <th onclick="sortProduct('quantity')" class="btn">quantity <i class="fa-solid fa-sort"></i></th>
                            <th onclick="sortProduct('status')" class="btn">status <i class="fa-solid fa-sort"></i></th>
                            <th>categories</th>
                            <th>created at</th>
                            <th>updated at</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody id="productTable">
                        <?php 
                            if ($productData->num_rows > 0) { 
                                while ($product_row = $productData->fetch_assoc()) { ?>
                                    
                                    <tr>
                                        <td><div class='img-container' ><img src="<?php echo $product_row['image_url'] ?>" alt='img'></div></td>
                                        <td><?php echo $product_row['product_name'] ?></td>
                                        <td><?php echo $product_row['product_code'] ?></td>
                                        <td><?php echo $product_row['price'] ?></td>
                                        <td><?php echo $product_row['sale_price'] ?></td>
                                        <td><?php echo $product_row['quantity'] ?></td>
                                        <td><span class="round <?php echo ($product_row['status'] == 'active') ? 'green' : 'red' ?>"></span><?php echo $product_row['status']?></td>
                                        <td><?php echo $product_row['Categories'] ?></td>
                                        <td><?php echo date('d/m/Y - h:ia', strtotime($product_row['created_at'])) ?></td>
                                        <td><?php echo date('d/m/Y - h:ia', strtotime($product_row['updated_at'])) ?></td>

                                        <td>
                                            <div class="action-btns">
                                                <a href="update-product.php?id=<?php echo $product_row['product_id']?>" class="action">
                                                    <i class="fa-solid fa-pencil icons"></i>
                                                </a>

                                                <a href="delete-product-inline.php?id=<?php echo $product_row['product_id']?>" onclick='confirmDelete(event)' class="action">
                                                    <i class="fa-solid fa-trash icons"></i>
                                                </a>
                                            </div>  
									    </td>

                                    </tr>

                                    <?php 
                                }
                            } else {
                                echo "<tr><td class='empty-row' colspan='11'>No data available in table</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>

                <div class="product-pagination">
                    <div class="pages">
                        <?php
                            echo generatePagination($currentpage, $total_product_pages); 
                            #Close the database connection
                            $connection->close();
                        ?> 
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

</div> <!-- content-section -->
</div> <!-- main-section -->

<?php include "footer.php"; ?>

<script src="script.js"></script>
</body>
</html>