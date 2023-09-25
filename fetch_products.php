<?php
require_once('connectPDO.php');

$lowPrice = $_POST['lowPrice'] ?? 0;
$highPrice = $_POST['highPrice'] ?? 200;
$sortOrder = $_POST['sortOrder'] ?? 'asc';
$brandFilter = $_POST['brandFilter'] ?? '';

$SelSql = "SELECT * FROM `products` WHERE price BETWEEN ? AND ?";
if($brandFilter) {
    $SelSql .= " AND brand = ?";
}
$SelSql .= " ORDER BY price " . ($sortOrder === 'desc' ? 'DESC' : 'ASC');

$stmt = $pdo->prepare($SelSql);
$params = [$lowPrice, $highPrice];
if($brandFilter) {
    $params[] = $brandFilter;
}
$stmt->execute($params);
while($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
    include('templates/product.php');
}
?>

