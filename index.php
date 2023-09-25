<?php
require_once('connectPDO.php');

// Initialize the session
session_start();

?>
<?php require('templates/header.php') ?>
<div class="d-flex mt-4 mx-4">
    <h3>Welcome to Online Shoes Store,
        <b>
            <?php // check user login and output username
            if ($user_logged) {
                $user_id = $_SESSION['id'];
                $select_sql = "SELECT name FROM `users` WHERE id=?";
                $stmt = $pdo->prepare($select_sql);
                $stmt->execute([$user_id]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo $row["name"] ?? "Guest";
            } else {
                echo "Guest";
            }
            ?>
        </b>
    </h3>
</div>

<div class="d-flex my-2">
    <?php // output success or failed message.
    if (isset($smsg)) { ?><div class="alert alert-success" role="alert"><?php echo $smsg; ?></div><?php } ?>
    <?php if (isset($fmsg)) { ?><div class="alert alert-danger" role="alert"><?php echo $fmsg; ?></div><?php } ?>
</div>

<div class="row main-section">
    <?php
    $SelSql = "SELECT * FROM `products`";
    $stmt = $pdo->query($SelSql);
    $num_of_rows = $stmt->rowCount();
    if ($num_of_rows > 0) {
        // output data of each row
        while ($num_of_rows > 0) {
            $num_of_rows--;
            $r = $stmt->fetch(PDO::FETCH_ASSOC);
            include('templates/product.php');
        }
    } else {
        echo "<p>No Products Available</p>";
    }
    ?>
</div>

<?php require('templates/footer.php') ?>
