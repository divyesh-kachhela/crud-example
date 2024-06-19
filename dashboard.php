<?php 
	include "header.php";
	include "config.php";
	include "function.php";

	$recentCategory = $connection->query("        
	SELECT C.Category_Name, C.Category_Status, COUNT(PC.product_id) AS 'no_of_product'
	FROM category AS C 
	LEFT JOIN product_categories AS PC ON C.category_id = PC.category_id
	GROUP BY C.Category_Name
	ORDER BY C.category_id DESC LIMIT 1;");
?>

<div class="overview-body">
	<div class="overview-section">
		<div class="card">
			<div class="card-header">
				<h3>overview</h3>
			</div>
			<div class="card-body">
				<div class="overview-items">
					<div class="overview-item">

						<div class="img-wrapper">
							<img src="images/additional_images/box.png" alt="box img">
						</div>
						<div class="item-details">
							<h4>total products</h4>
							<span><?php echo overviewData("product", $connection); ?></span>
						</div>
					</div>
					<div class="overview-item">

						<div class="img-wrapper">
							<img src="images/additional_images/tags.png" alt="tags img">
						</div>
						<div class="item-details">
							<h4>total categories</h4>
							<span><?php echo overviewData("category", $connection); ?></span>
						</div>
					</div>
					<div class="overview-item">

						<div class="img-wrapper">
							<img src="images/additional_images/user.png" alt="user img">
						</div>
						<div class="item-details">
							<h4>total users</h4>
							<span><?php echo calculations($connection, "COUNT", "id", "Users") ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="recent-products">
		<div class="card">
			<div class="card-header">
				<h3>recent product</h3>
			</div>
			<div class="card-body">
				<table>
					<thead>
						<tr>
							<th>product</th>
							<th>price</th>
							<th>category</th>
							<th>status</th>
						</tr>
					</thead>
					<tbody>
						<?php echo recentProduct($connection); ?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<h3>recent category</h3>
			</div>
			<div class="card-body">
				<table>
					<thead>
						<tr>
							<th>name</th>
							<th>no. of products</th>
							<th>status</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if($recentCategory->num_rows > 0){
								while($row = $recentCategory->fetch_assoc()){?>
									<tr>
										<td><?php echo $row['Category_Name'] ?></td>
										<td><?php echo $row['no_of_product'] ?></td>
										<td> <span class="round <?php echo (($row['Category_Status'] == 'active') ? 'green' : 'red') ?>"></span> <?php echo $row['Category_Status'] ?></td>
									</tr>
								<?php
								}
							}	
							?>
					</tbody>
				</table>
			</div>
		</div>

	</div>
</div>

	<!-- </div> content-section
</div> main-section -->

<?php include "footer.php"; ?>

<script src="script.js"></script>
</body>
</html> 
