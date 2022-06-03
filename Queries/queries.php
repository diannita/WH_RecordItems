<?php
    // Include config conection file
    include ('../Configuration/config.php');

    // Check if debugging is necessary
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // $error = '';
    // $output = '';

    // if(isset($_POST['submit'])) {
    //     $owner_code = $_POST['dropdown_owner'];  
    //     $jobNumber = $_POST['jobNumber'];
    //     $product_code=$_POST['lista2'];
    //     $text_items = $_POST['items'];
        
    //     $inset = "INSERT INTO Item (Code, ProductCode, StatusCode, Product.Owner, ReceiptNumber, ReceiptLineNumber, SerialNumber) VALUES (584017, '$product_code', '1', '$owner_code', $jobNumber, '1', '$text_items' )"; 
    //     $result = sqlsrv_query ($conn, $inset);
    // }
 
?>