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

$id = $_GET['id'];

$SelSql = "SELECT * FROM `products` WHERE id=?";
$stmt = $pdo->prepare($SelSql);
$stmt->execute([$id]);
$r = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST) && !empty($_POST)) {
    $title = ($_POST['title']);
    $price = ($_POST['price']);
    $brand = ($_POST['brand']);

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
    } else {
        $image = $r['image'];
    }

    // Execute query
    $query = "UPDATE `products` SET title=?, price=?, brand=?, image=? WHERE id=?";

    $stmt = $pdo->prepare($query);
    $res = $stmt->execute([$title, $price, $brand, $image, $id]);

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
    <?php if (isset($fmsg)) { ?>
        <div class="alert alert-danger" role="alert"><?php echo $fmsg; ?></div><?php } ?>
    <h2 class="my-4">Edit Product</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control" name="title" value="<?php echo $r['title']; ?>" required/>
        </div>
        <div class="form-group">
            <label>New Price</label>
            <input type="text" class="form-control" name="price" value="<?php echo $r['price']; ?>" required/>
        </div>
        <div class="form-group">
            <label>Brand</label>
            <input type="text" class="form-control" name="brand" value="<?php echo $r['brand']; ?>"/>
        </div>
        <div class="form-group">
            <label>New Image</label>
            <input type="file" class="form-control" name="image" accept=".png,.gif,.jpg,.webp"/>
        </div>
        <input type="submit" class="btn btn-primary" value="Update"/>
    </form>
</div>

<?php require_once($path . 'templates/footer.php') ?>
