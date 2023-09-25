<?php
ob_start(); // Start output buffering

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/shoes/";

require_once($path . 'connectPDO.php');
require_once($path . 'tcpdf/tcpdf.php'); // Include the TCPDF library

$sql = "SELECT * FROM products";
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Products Report');
$pdf->SetSubject('Products Report');
$pdf->SetKeywords('Products, Report');

$pdf->setHeaderData('', 0, 'Products Report', '');

$pdf->setHeaderFont(array('dejavusans', '', 10));
$pdf->setFooterFont(array('dejavusans', '', 10));

$pdf->SetMargins(10, 10, 10, true);
$pdf->SetAutoPageBreak(true, 10);

$pdf->AddPage();

$html = '<h2>Products Report</h2>
<table border="1">
    <tr>
        <th>Prod No.</th>
        <th>Title</th>
        <th>Category</th>
        <th>Price</th>
        <th>Brand</th>
        <th>Image</th>
    </tr>';

foreach ($rows as $row) {
    $html .= '<tr>
        <td>' . $row['id'] . '</td>
        <td>' . $row['title'] . '</td>
        <td>' . $row['category'] . '</td>
        <td>$ ' . $row['price'] . '</td>
        <td>' . $row['brand'] . '</td>
        <td>' . $row['image'] . '</td>
    </tr>';
}

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');

ob_end_clean(); // Clear the output buffer

$pdf->Output('products_report.pdf', 'I'); // I for inline, D for download, F for save in local file
