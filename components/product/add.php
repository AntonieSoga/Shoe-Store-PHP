<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/shoes/";

require_once($path . 'connectPDO.php');

// Initialize the session
session_start();

if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['role'] == 'admin')) {
    echo "Unauthorized Access";
    return;
}

if (isset($_POST) && !empty($_POST)) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $brand = $_POST['brand'];

    // store and upload image
    $image = $_FILES['image']['name'];
    $dir = "../img/products/";
    $temp_name = $_FILES['image']['tmp_name'];
    if ($image != "") {
        if (file_exists($dir . $image)) {
            $image = time() . '_' . $image;
        }
        $fdir = $dir . $image;
        move_uploaded_file($temp_name, $fdir);
    }

    // Execute query
    $query = "INSERT INTO `products` (title, category, price, brand, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $res = $stmt->execute([$title, $category, $price, $brand, $image]);
    if ($res) {
        header('location: view.php');
    } else {
        $fmsg = "Failed to Insert data.";
        print_r($stmt->errorInfo());
    }
}
?>

<?php require_once($path . 'templates/header.php') ?>

<div class="container">
    <?php if (isset($fmsg)) { ?><div class="alert alert-danger" role="alert"><?php echo $fmsg; ?></div><?php } ?>
    <h2 class="my-4">Add New Product</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control" name="title" value="" required/>
        </div>
        <div class="form-group">
            <label>Category</label>
            <input type="text" class="form-control" name="category" value="" required/>
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="number" class="form-control" name="price" value="" required/>
        </div>
        <div class="form-group">
            <label>Brand</label>
            <input type="text" class="form-control" name="brand" value=""/>
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" class="form-control" name="image" accept=".png,.gif,.jpg,.webp" required/>
        </div>
        <input type="submit" class="btn btn-primary" value="Add Product"/>
    </form>
</div>

<?php require_once($path . 'templates/footer.php') ?>
