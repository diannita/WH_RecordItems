<?php
    // Include config conection file
    include ('Configuration/config.php');
    // include ('Queries/queries.php');
   
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Get the latest Code Number from Table Item and increment
    $latestCode_query = "SELECT TOP 1 Code FROM Item ORDER BY Code DESC";
    $result = sqlsrv_query ($conn, $latestCode_query);
    $latestCode = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC); 
    $latestCodePlus =  $latestCode["Code"];
    $latestCodePlus += 1;

    $quantity_enter = 0;

    if(isset($_POST['submit'])) {
        //values to post from the form
        $owner_code = $_POST['dropdown_owner'];  
        $jobNumber = $_POST['jobNumber'];
        $product_code=$_POST['lista2'];
        $text_items = $_POST['items'];
        $warehouse_code = $_POST['lista1'];

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
        $productCode_query = "SELECT TOP 1 ProductCode FROM Item ORDER by Code desc";
        $result = sqlsrv_query ($conn, $productCode_query);
        $checkProductCode = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        $latestProductCode = $checkProductCode["ProductCode"];

        //Get the Quantity from ReceiptLine table
        $quantityReceiptLine_query = "SELECT ReceviedQuantity FROM ReceiptLine where ReceiptLine.Number = $jobNumber AND ReceiptLine.Owner = $owner_code AND LineNumber = $ReceiptLineNumberPlus";
        $result = sqlsrv_query ($conn, $quantityReceiptLine_query);
        $quantityReceiptLine = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        $quantity = $checkProductCode["ReceviedQuantity"];

        //Get the latest JobNumber in BD from Item table
        $jobNumber_query = "SELECT TOP 1 ReceiptNumber FROM Item ORDER by Code desc";
        $result = sqlsrv_query ($conn, $jobNumber_query);
        $GetReceiptNumber = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        $latestReceiptNumber = $GetReceiptNumber["ReceiptNumber"];
            
            if($latestProductCode == $product_code){
                $ReceiptLineNumberPlus = $ReceiptLineNumberOrig;
            }else{
                $ReceiptLineNumberPlus = $ReceiptLineNumberOrig + 1;
            }
            
        $array = explode("\r\n", $_POST["items"]);
        $items_array = array_unique($array);
        $quantity_enter = count($items_array);

        if($ReceiptLineNumberPlus = $ReceiptLineNumberOrig){

            $ReceiptLineNumberEntry = "UPDATE ReceiptLine SET DeclaredQuantity = $newQuantity, ReceviedQuantity = $newQuantity WHERE ReceiptLine.Number = $jobNumber AND ReceiptLine.Owner = $owner_code AND LineNumber = $ReceiptLineNumberPlus";
            echo (json_encode($ReceiptLineNumberEntry));
            $result = sqlsrv_query ($conn, $ReceiptLineNumberEntry);
        }else{
            $ReceiptLineNumberEntry = "INSERT INTO ReceiptLine (ReceiptLine.Number, ReceiptLine.Owner, LineNumber, ProductCode, DeclaredQuantity, ReceviedQuantity, Reference) 
            VALUES ('$jobNumber', '$owner_code', '$ReceiptLineNumberPlus', '$product_code', '$quantity_enter', '$quantity_enter', '$jobNumber_reference')";
            echo (json_encode($ReceiptLineNumberEntry));
            $result = sqlsrv_query ($conn, $ReceiptLineNumberEntry);
        }

        for($i=0; $i < $quantity_enter;){
            $inset = "INSERT INTO Item (Code, ProductCode, StatusCode, WarehouseCode, LocationCode, Product.Owner, ReceiptNumber, ReceiptLineNumber, SerialNumber) 
            VALUES ('$latestCodePlus', '$product_code', '$warehouse_code', '1', 2317, '$owner_code', '$jobNumber', '$ReceiptLineNumberPlus', ' $items_array[$i]')";
            $result = sqlsrv_query ($conn, $inset);
            $i++;
            $latestCodePlus++;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="title" content="DG-WH Web Registration Tool">
        <meta name="description" content="Web Application to register items to DB with the purpose of scanning items easily into the system">
        <meta name="keywords" content="warehouse, lazy, scan">
        <meta name="robots" content="index, follow">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="language" content="English">
        <meta name="author" content="Diana Rodriguez - Happy Cat">

        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        
        <title>DG-WH Web Registration Tool</title>
    </head>
    
    <body>

        <!-- Component Start -->
        <div class="flex flex-col items-center justify-center min-h-screen  text-gray-700 bg-gray-100 md:p-20">
            <h2 class="text-2xl font-medium">Warehouse Web Registration Tool </h2>

                <div class="flex flex-wrap items-center justify-center w-full max-w-4xl mt-8">
                    <form method="POST" class="form bg-white p-6 my-10 relative "> 

                        <div class="form-group center-div"> <!-- sucessful or error message -->
                            <label><?php echo $error; ?></label>
                        </div>
                
                        <div class="icon bg-blue-600 text-white w-6 h-6 absolute flex items-center justify-center p-5" style="left:-40px"><i class="fal fa-phone-volume fa-fw text-2xl transform -rotate-45"></i></div>
                        <h3 class="text-2xl text-gray-900 font-semibold">Let scan and save your Item(s)!</h3>
                        <p class="text-gray-600"> Please fill the following form</p>
                        
                        <div class="flex space-x-2 mt-3">
                            <select class="border p-2 w-8/12 focus:text-gray-600 focus:bg-white focus:border-blue-600 bg-gray-100" name="dropdown_owner" id="dropdown_owner" required>
                               <option value="">Owner</option>   
                               <option value="1">Test Owner</option>
                               <option value="16">Gunz Dental Supply Co (NZ)</option>
                               <option value="20">Fonterra</option>
                               <option value="25">Air New Zealand</option>
                               <option value="47">Quantum Corporation</option>
                               <option value="50">TomTom</option>
                               <option value="77">Fletcher Building</option>
                               <option value="78">Steel and Tube</option>
                               <option value="80">New Zealand Secret</option>
                               <option value="81">eCommerce</option>
                               <option value="82">IT Factory</option>
                               <option value="83">Datacom</option>
                            </select>
                            <input type="text" name="jobNumber" id="jobNumber" placeholder="Job Number" class="border p-2 w-4/12 bg-gray-100" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" required autofocus>
                        </div>
                        <br>
			            <div id="select_list"></div>
                       
                        <textarea name="items" id='output' cols="10" rows="10" placeholder="Add your item(s) here!" class="resize-none border p-2 mt-3 w-full bg-gray-100" required autofocus></textarea>
                        
                        <p class="font-bold text-sm mt-3">Quantity saved..</p>
                        <div class="flex items-baseline mt-2">
                            <p>Hey! congratulations.. you saved today <?php echo $quantity_enter ?> </p>
                        </div>
                        

                        <div class="inline-flex rounded-md shadow-sm mt-10" role="group">
                            <input type="submit" value="Save All Item(s)" name="submit" class="py-2 px-4 text-sm font-medium text-white bg-teal-600 rounded-l-lg border border-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 
                            focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                        
                            <button type="button" class="py-2 px-4 text-sm font-medium text-white bg-red-600 border-t border-b border-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 
                            focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white"
                            onclick="javascript:eraseText();">
                                Clear All Item(s)
                            </button>
                            
                            <button type="button" class="py-2 px-4 text-sm font-medium text-white bg-purple-600 rounded-r-md border border-gray-500 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 
                            focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white"
                            onclick="delete_last_value()">
                                Delete Last Item
                            </button>
                        </div>

                    </form>
                </div>

                <div align="center" style="padding-top:50px;">
                <!-- <table class="table table-hover w-50">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Item(s) Scanned</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <th scope="row"><?php echo $output; ?></th>
                        </tr>
                    </tbody>
                </table> -->
            </div>
        </div>
        <!-- Component End  -->
        

            <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
            <script>
            // empty the textarea complely
            function eraseText() {
                document.getElementById("output").value = "";
            }
            
            // This javascript method is quite easy and blocks the pop up asking for form resubmission on refresh once the form is submitted
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }

            // this jquery removes all tabs, spaces that we dont need 
            $(document).ready(function () {
                $('#output').focusout(function () {
                    var text = $('#output').val();
                    text = text.replace(/(?:(?:\r\n|\r|\n)\s*){2}/gm, "");
                    $(this).val(text);
                });
            });

            //This function deletes the last item inside the textarea
            function delete_last_value() {
                var lines = $('#output').val().split('\n');
                $("#output").val(lines.slice(0, -1).join('\n'));
            }

            //select list that shows warehouse and product from respective owner
            $(document).ready(function(e){
                $('#dropdown_owner').change(function(){
                    $.ajax({
                    type:"POST",
                    url:"Queries/select_data.php",
                    data:"owner=" + $('#dropdown_owner').val(),
                    beforeSend: function () { },
                    success:function(owner){
                        $('#select_list').html(owner);
                    }
                    });
                });
            })
        </script>

    </body>

</html>