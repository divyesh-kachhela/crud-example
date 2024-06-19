<?php 
	include "header.php";
	include "config.php";
	include "function.php";

	#initialize sorting variables
	$COLUMN_NAME = isset($_SESSION['COLUMN_NAME']) ? $_SESSION['COLUMN_NAME'] : 'category_id';
	$SORT_ORDER = isset($_SESSION['SORT_ORDER']) ? $_SESSION['SORT_ORDER'] : 'DESC';

	#update sorting variables
	if (isset($_POST['sendData']) && isset($_POST['sortOrder'])) {
		$COLUMN_NAME = $_POST['sendData'];
		$SORT_ORDER = $_POST['sortOrder'];

		#store sorting variables in session
		$_SESSION['COLUMN_NAME'] = $COLUMN_NAME;
		$_SESSION['SORT_ORDER'] = $SORT_ORDER;
	}

	#unset sessions 
	if (isset($_POST['resetOrder']) || $_SERVER['REQUEST_METHOD'] == 'GET') {
		
		unset($_SESSION['COLUMN_NAME']);
		unset($_SESSION['SORT_ORDER']);

		$SORT_ORDER = "DESC";
		$COLUMN_NAME = "category_id";
	}

	#initialize pagination variable 
	$row_par_page = 10;
	$currentpage = isset($_POST['pagesend']) ? $_POST['pagesend'] : 1;
	$offset = ($currentpage - 1) * $row_par_page;

	#initialize SQL query
	$Squery =
	"SELECT C.*, COUNT(PC.product_id) AS 'no_of_product'
	FROM product_categories AS PC 
	RIGHT JOIN category AS C ON C.category_id = PC.category_id
	WHERE 1=1";

	#filter by category name
	if (!empty($_POST['cateName'])) {
		$cateName = $connection->real_escape_string($_POST['cateName']);
		$Squery .= " AND C.Category_Name LIKE '%$cateName%'";
	}

	#filter by category status
    if (!empty($_POST['cateStatus'])) {

        if ($_POST['cateStatus'] !== 'all') {
            $cateStatus = $connection->real_escape_string($_POST['cateStatus']);
            $Squery .= " AND C.Category_Status = '$cateStatus'";
        }
    }

	$Squery .= " GROUP BY C.Category_Name
	ORDER BY $COLUMN_NAME $SORT_ORDER";

	#calculates total pages
	$total_pages = total_pages($connection, $Squery, $row_par_page);

	$Squery .= " LIMIT $row_par_page OFFSET $offset";
	$result = $connection->Query($Squery);
?>

		<div class="table-section">
			<div class="category-table">
				<div class="heading f-case">
					<h2>all category</h2>
                    <div class="add-btn">
                        <a href="add-category.php" class="blue-btn"><i class="fa-solid fa-plus"></i></a>
                    </div>
				</div>
					<div class="filters f-case">
						<div class="inputs">
							<div class="filter-form-group">
								<label for="searchCategory">name</label>
								<input type="text" name="inputName" id="searchCategory" placeholder="Search By Name">
							</div>

							<div class="filter-form-group ">
								<label for="searchCategoryStatus">status</label>
								<select id="searchCategoryStatus" name="inputStatus">
									<option value="all">All</option>
									<option value="active">Active</option>
									<option value="inactive">Inactive</option>
								</select>
							</div>
						</div>
						<div class="filters-btns">
							<button class="blue-btn" id="filterCategory"><i class="fa-solid fa-filter icon"></i> filter</button>
							<button class="black-btn" id="clear-filter"></i> clear</button>
						</div>
					</div>
				<div class="DOM">
					<table> 
						<thead>
							<tr>
                                <th>image</th>
                                <th onclick="sort('Category_Name')" class="btn">name <i class="fa-solid fa-sort"></i></th>
                                <th>no. of products</th>
								<th onclick="sort('Ordering')" class="btn">ordering <i class="fa-solid fa-sort"></i></th>
								<th onclick="sort('Category_Status')" class="btn">status <i class="fa-solid fa-sort"></i></th>
								<th>created at</th> 
								<th>updated at</th>
								<th>action</th>
							</tr>
						</thead>
						<tbody id="categoryTable">
							<?php
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
								?>
									<tr>
										<td>
											<div class="img-container"><img src="<?php echo $row['Category_Image'] ?>" alt="img"></div>
										</td>
										<td class="Cname"><?php echo $row['Category_Name'] ?></td>
										<td> <?php echo $row['no_of_product'] ?> </td>
										<td><?php echo $row['Ordering'] ?></td>
										<td><span class="round <?php echo ($row['Category_Status'] == 'active') ? 'green' : 'red'; ?> "></span><?php echo $row['Category_Status'] ?></td>
										<td><?php echo date('d/m/Y - h:ia', strtotime($row['Created_at'])) ?></td>
										<td><?php echo date('d/m/Y - h:ia', strtotime($row['Updated_at'])) ?></td>
										<td>
											<div class="action-btns">
												<a href="update-category.php?id=<?php echo $row['category_id'] ?>" class="action">
													<i class="fa-solid fa-pencil icons"></i>
												</a>

												<a href="delete-category-inline.php?id=<?php echo $row['category_id'] ?>" onclick='confirmDelete(event)' class="action">
													<i class="fa-solid fa-trash icons"></i>
												</a>
											</div>
										</td>
									</tr>
								<?php } 
							} else {
								echo "<tr><td class='empty-row' colspan='11'>No data available in table</td></tr>";													
							}
							?>
						</tbody>
					</table>

					<div class="pagination">
						<div class="pages">
							<?php 
								echo generatePagination($currentpage, $total_pages);
								#Close the database connection
								$connection->close();
							?>
						</div>
					</div>

				</div>
			</div>
		</div>

<!-- </div>  content-section 
</div>  main-section -->

<?php include "footer.php"; ?>
<script src="script.js"></script>
</body>
</html>	
