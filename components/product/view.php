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

$ReadSql = "SELECT * FROM `products`";
$res = $pdo->query($ReadSql);

?>

<?php require($path . 'templates/header.php') ?>
<div class="container-fluid my-4">
    <div class="row my-2">
        <h2>Antonie Shoes Shop - Products</h2>
        <a href="add.php"><button type="button" class="btn btn-primary ml-4 pl-2">Add New</button></a>
    </div>
    <table class="table ">
        <thead>
            <tr>
                <th>Prod No.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Brand</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($r = $res->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <th scope="row">
                        <?php echo $r['id']; ?>
                    </th>
                    <td>
                        <?php echo $r['title']; ?>
                    </td>
                    <td>$
                        <?php echo $r['price']; ?>
                    </td>
                    <td>
                        <?php echo $r['brand']; ?>
                    </td>
                    <td>
                        <a href="update.php?id=<?php echo $r['id']; ?>"><button type="button"
                                class="btn btn-info">Edit</button></a>

                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                            data-target="#myModal<?php echo $r['id']; ?>">Delete</button>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal<?php echo $r['id']; ?>" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete Product</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <a href="delete.php?id=<?php echo $r['id']; ?>"><button type="button"
                                                class="btn btn-danger"> Yes, Delete</button></a>
                                    </div>
                                </div>
                                <!-- Other parts of your code -->


                            </div>
                        </div>

                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Add buttons here -->
<div class="container-fluid my-4">
    <div class="row justify-content-center">
        <a href="log.php" class="btn btn-primary m-2">LOG</a>
        <a href="reports.php" class="btn btn-secondary m-2">Reports</a>
        <a href="export_pdf.php" class="btn btn-danger m-2">Export to PDF</a>
        <a href="export_excel.php" class="btn btn-success m-2">Export to Excel</a>
        <a href="import_excel.php" class="btn btn-info m-2">Import from Excel</a>
    </div>
</div>

<!-- Footer here -->
<?php require($path . 'templates/footer.php') ?>
