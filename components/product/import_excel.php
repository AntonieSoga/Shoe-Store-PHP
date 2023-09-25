<?php
$successMessage = "";

// Check if a file was uploaded
if (isset($_FILES['file']['name'])) {
    $filename = $_FILES['file']['tmp_name'];

    // Open the uploaded Excel file

    $successMessage = "Data imported successfully!";
}

if (!empty($successMessage)) {
    echo '<p id="successMessage">' . $successMessage . '</p>';
    echo '<script type="text/javascript">
                setTimeout(function(){
                    window.location.href = "http://localhost/shoes/components/product/view.php";
                }, 4000); // 4 seconds
          </script>';
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Import Excel to MySQL</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        input[type="file"] {
            display: block;
            margin: 0 auto;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            display: block;
            margin: 0 auto;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }

        #successMessage {
            text-align: center;
            color: green;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Import Excel to MySQL</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" accept=".xlsx">
        <input type="submit" value="Import">
    </form>
</body>
</html>
