<?php

$server = 'http://' . $_SERVER['SERVER_NAME'] . '/shoes/';

$user_logged = false;

?>
<!DOCTYPE html>
<html>

<head>
	<style type="text/css">
		/* ... existing styles ... */

		.filter-tab {
			display: inline-block;
			margin-right: 10px;
			position: relative;
		}

		.filter-toggle {
			padding: 0;
			color: #007bff;
		}

		.filter-content {
			position: absolute;
			z-index: 100;
			background-color: #fff;
			border: 1px solid #ddd;
			border-radius: 3px;
			padding: 10px;
			top: 100%;
			left: 0;
			width: 220px;
			display: none;
		}

		.filter-content.show {
			display: block;
		}

		.filter-section {
			margin-bottom: 10px;
		}

		.filter-apply {
			margin-top: 10px;
		}
	</style>

	<title>Online Shoes Shop</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
		integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

	<link rel="stylesheet" href="<?php echo $server; ?>css/style.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
		integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
		integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
		crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
		integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
		crossorigin="anonymous"></script>
	<style type="text/css">
		body {
			font: 14px sans-serif;
		}

		.wrapper {
			width: 350px;
			padding: 20px;
		}
	</style>
</head>

<body>
	<header class="d-flex w-100">
		<nav class="navbar navbar-expand-lg w-100 bg-light">
			<div class="navbar-collapse collapse justify-content-between">
				<ul class="navbar-nav" id="navbar">
					<li class="nav-item active">
						<a class="nav-link text-dark" href="<?php echo $server; ?>index.php"><i
								class="fa fa-shopping-bag text-dark"></i> Antonie Shoes Shop</a>
					</li>

					<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
						$user_logged = true;
						if ($_SESSION['role'] == 'admin') { ?>
							<li class="nav-item">
								<a class="nav-link text-dark"
									href="<?php echo $server; ?>components/product/view.php">Products</a>
							</li>
						<?php }
					} ?>

				</ul>
				<ul class="navbar-nav">
					<div class="d-flex my-2 my-lg-0">
						<input id="searchInput" class="form-control mr-sm-2" type="search" placeholder="Search"
							aria-label="Search">
						<button id="searchBtn" class="btn btn-outline-light m-2 my-sm-0" type="button">Search</button>
					</div>
					<!-- Filter Tab -->
					<div class="filter-tab">
						<button class="btn btn-link filter-toggle" type="button" data-toggle="collapse"
							data-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
							<i class="fa fa-filter"></i> Filters
						</button>
						<div class="collapse filter-content" id="filterCollapse">
							<div class="filter-section">
								<h5>Price Range</h5>
								<div class="form-group">
									<label for="minPrice">Min:</label>
									<input type="number" class="form-control" id="minPrice" min="0" max="200" value="0">
								</div>
								<div class="form-group">
									<label for="maxPrice">Max:</label>
									<input type="number" class="form-control" id="maxPrice" min="0" max="200"
										value="200">
								</div>
							</div>
							<div class="filter-section">
								<h5>Sort By Price</h5>
								<select class="form-control" id="sortPrice">
									<option value="asc">Price: Low to High</option>
									<option value="desc">Price: High to Low</option>
								</select>
							</div>
							<div class="filter-section">
								<h5>Brand</h5>
								<select class="form-control" id="filterBrand">
									<option value="">All Brands</option>
									<?php
									$brandSql = "SELECT DISTINCT brand FROM products";
									$brandStmt = $pdo->query($brandSql);
									while ($brandRow = $brandStmt->fetch(PDO::FETCH_ASSOC)) {
										$brand = $brandRow['brand'];
										echo "<option value=\"$brand\">$brand</option>";
									}
									?>
								</select>
							</div>
							<button class="btn btn-primary filter-apply" type="button">Apply</button>
						</div>
					</div>

				</ul>
				<ul class="navbar-nav">
					<li class="nav-item cart mr-4">
						<a class="nav-link btn bg-warning" href="<?php echo $server; ?>templates/cart.php">
							<span class="text-white">0 </span>
							<i class="fa fa-shopping-cart text-white" style="font-size: 18px;"></i>
						</a>
					</li>

					<?php
					if ($user_logged) { ?>
						<li class="nav-item mr-sm-2">
							<a class="nav-link btn btn-dark text-white"
								href="<?php echo $server; ?>components/user/logout.php"><span><i
										class="fa fa-sign-out text-white"></i></span>Sign Out</a>
						</li>
					<?php } else { ?>
						<li class="nav-item mr-sm-2">
							<a class="nav-link btn btn-primary text-white"
								href="<?php echo $server; ?>components/user/login.php"><span><i
										class="fa fa-sign-in text-white"></i></span> Sign In</a>
						</li>
					<?php } ?>
				</ul>
			</div>
		</nav>
	</header>
	<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function () {
		const filterToggle = document.querySelector('.filter-toggle');
		const filterContent = document.querySelector('.filter-content');
		const filterApplyBtn = document.querySelector('.filter-apply');
		let isFilterOpen = true;

		filterToggle.addEventListener('click', function () {
			isFilterOpen = !isFilterOpen;
			filterContent.classList.toggle('show', isFilterOpen);
		});

		filterApplyBtn.addEventListener('click', function () {
			applyFilters();
			filterContent.classList.remove('show');
			isFilterOpen = false;
		});

		function applyFilters() {
  const minPrice = parseInt(document.querySelector('#minPrice').value);
  const maxPrice = parseInt(document.querySelector('#maxPrice').value);
  const sortPrice = document.querySelector('#sortPrice').value;
  const filterBrand = document.querySelector('#filterBrand').value;

  // Apply your filtering logic here
  // You can access the filter values (minPrice, maxPrice, sortPrice, filterBrand) and perform the necessary filtering operations on the products

  // Example: Filtering by price range
  // Loop through the products and hide/show based on the price range
  const products = document.querySelectorAll('.product');
  products.forEach(product => {
    const price = parseInt(product.querySelector('.price').textContent);
    if (price >= minPrice && price <= maxPrice) {
      product.style.display = 'block';
    } else {
      product.style.display = 'none';
    }
  });

  // Example: Sorting by price
  // Sort the products based on the selected sorting option (sortPrice)
  const mainSection = document.querySelector('.main-section');
  const sortedProducts = Array.from(products).sort((a, b) => {
    const priceA = parseInt(a.querySelector('.price').textContent);
    const priceB = parseInt(b.querySelector('.price').textContent);
    if (sortPrice === 'asc') {
      return priceA - priceB;
    } else {
      return priceB - priceA;
    }
  });
  mainSection.innerHTML = '';
  sortedProducts.forEach(product => {
    mainSection.appendChild(product);
  });

  // Example: Filtering by brand
  // Hide/show products based on the selected brand (filterBrand)
  products.forEach(product => {
    const brand = product.querySelector('.card-text').textContent;
    if (filterBrand === '' || brand === filterBrand) {
      product.style.display = 'block';
    } else {
      product.style.display = 'none';
    }
  });
}

	});

	// Close filter tab if clicked outside
	window.addEventListener('click', function (event) {
		const filterToggle = document.querySelector('.filter-toggle');
		const filterContent = document.querySelector('.filter-content');
		if (!filterToggle.contains(event.target) && !filterContent.contains(event.target)) {
			filterContent.classList.remove('show');
		}
	});
</script>


	<div class="container-fluid page-container">