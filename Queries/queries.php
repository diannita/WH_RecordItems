<?php

//Shows Php errors
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);

// Include config conection file
include_once ('../Configuration/config.php');

// Get the latest Code Number from Table Item and increment
$latestCode_query = "SELECT TOP 1 Code FROM Item ORDER BY Code DESC";
$result = sqlsrv_query ($conn, $latestCode_query);
$latestCode = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC); 
$latestCodePlus =  $latestCode["Code"];
$latestCodePlus += 1;

//initialization of varable for quantity
$quantity_enter = 0;

if(isset($_POST['submit'])) {
    //values to post from the form
    $owner_code = $_POST['dropdown_owner'];  
    $jobNumber = $_POST['jobNumber'];
    $product_code=$_POST['lista2'];
    $text_items = $_POST['items'];
    $warehouse_code = $_POST['lista1'];
    $dropdown_location = $_POST['lista4'];

    //Getting ReceiptLineNumber from Item table
    $ReceiptLineNumber_query = "SELECT TOP 1 ReceiptLineNumber FROM Item where Item.Owner = $owner_code AND ReceiptNumber = $jobNumber ORDER by code desc";
    $result = sqlsrv_query ($conn, $ReceiptLineNumber_query); 
    $ReceiptLineNumber = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    $ReceiptLineNumberOrig =  $ReceiptLineNumber["ReceiptLineNumber"];

    //Getting Reference for ReceiptLine table
    $ReceiptHeaderReference_query = "SELECT TOP 1 OwnerReference FROM ReceiptHeader where ReceiptHeader.Owner = $owner_code AND ReceiptHeader.Number = $jobNumber";
    $result = sqlsrv_query ($conn, $ReceiptHeaderReference_query); 
    $ReceiptHeaderReference = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    $jobNumber_reference =  $ReceiptHeaderReference["OwnerReference"];

    //Get the lastest ProductCode in BD from Item table
    $productCode_query = "SELECT TOP 1 ProductCode FROM Item where ReceiptNumber = $jobNumber ORDER by Code desc";
    $result = sqlsrv_query ($conn, $productCode_query);
    $checkProductCode = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    $latestProductCode = $checkProductCode["ProductCode"];

    //Get the Quantity from ReceiptLine table
    $quantityReceiptLine_query = "SELECT ReceviedQuantity FROM ReceiptLine where ReceiptLine.Number = $jobNumber AND ReceiptLine.Owner = $owner_code AND LineNumber = $ReceiptLineNumberOrig";
    $result = sqlsrv_query ($conn, $quantityReceiptLine_query);
    $quantityReceiptLine = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    $quantity = $quantityReceiptLine["ReceviedQuantity"];

    //Get the latest JobNumber in BD from Item table
    $jobNumber_query = "SELECT TOP 1 ReceiptNumber FROM Item ORDER by Code desc";
    $result = sqlsrv_query ($conn, $jobNumber_query);
    $GetReceiptNumber = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    $latestReceiptNumber = $GetReceiptNumber["ReceiptNumber"];
    
    //This conditional checks and adds the ReceiptLineNumber with the productCode (Item table)
    if($latestProductCode == $product_code){
        $ReceiptLineNumberPlus = $ReceiptLineNumberOrig;
    }else{
        $ReceiptLineNumberPlus = $ReceiptLineNumberOrig + 1;
    }
    
    //Array for items of textarea (takes the multiples items inside of textarea)
    $array = explode("\r\n", trim($_POST["items"]));
    //This array checks that is going to be unique item what you insert into the BD
    $items_array = array_unique($array);
    //This varable counts the number inserted (quantity) 
    $quantity_enter = count($items_array);

    //Update the ReceiptLine agains $ReceiptLineNumberPlus - Table ReceiptLine
    if($ReceiptLineNumberPlus == $ReceiptLineNumberOrig){
        $newQuantity = $quantity_enter + $quantity;
        $ReceiptLineNumberEntry = "UPDATE ReceiptLine SET DeclaredQuantity = $newQuantity, ReceviedQuantity = $newQuantity WHERE ReceiptLine.Number = $jobNumber AND ReceiptLine.Owner = $owner_code AND LineNumber = $ReceiptLineNumberPlus";
        $result = sqlsrv_query ($conn, $ReceiptLineNumberEntry);
    }else{
        $ReceiptLineNumberEntry = "INSERT INTO ReceiptLine (ReceiptLine.Number, ReceiptLine.Owner, LineNumber, ProductCode, DeclaredQuantity, ReceviedQuantity, Reference) 
        VALUES ('$jobNumber', '$owner_code', '$ReceiptLineNumberPlus', '$product_code', '$quantity_enter', '$quantity_enter', '$jobNumber_reference')";
        $result = sqlsrv_query ($conn, $ReceiptLineNumberEntry);
    }

    //This For exploits in multiple rows the number or items to save into the DB. 
    for($i=0; $i < $quantity_enter;){
        $inset = "INSERT INTO Item (Code, ProductCode, StatusCode, WarehouseCode, LocationCode, Product.Owner, ReceiptNumber, ReceiptLineNumber, SerialNumber) 
        VALUES ('$latestCodePlus', '$product_code', '1', '$warehouse_code', '$dropdown_location', '$owner_code', '$jobNumber', '$ReceiptLineNumberPlus', '$items_array[$i]')";
        $result = sqlsrv_query ($conn, $inset);
        $i++;
        $latestCodePlus++;
    }
}

?>
