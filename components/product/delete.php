<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/shoes/";

require_once($path . 'connectPDO.php');

$id = $_GET['id'];
$DelSql = "DELETE FROM `products` WHERE id=?";
$stmt = $pdo->prepare($DelSql);
$res = $stmt->execute([$id]);
if($res){
    header('location: view.php');
}else{
    echo "Failed to delete";
}
?>
