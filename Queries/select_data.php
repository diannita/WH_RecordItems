<?php
    // Include config conection file
    include_once ('../Configuration/config.php');

        $owner = $_POST['owner'];

        $query_list = "SELECT Code, WarehouseName FROM warehouse WHERE Warehouse.Owner = '$owner' and disabled = 0";
        $result = sqlsrv_query ($conn, $query_list);

        $cadena_warehouse="<label class='text-gray-700 text-base'>Select Warehouse</label>        
             <select class='mt-3 p-2 form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300
             transition ease-in-out m-0 focus:text-gray-600 focus:bg-white focus:border-blue-600 focus:outline-none bg-gray-100' 
             id='lista1' name='lista1'>";

             while ($data = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        $cadena_warehouse = $cadena_warehouse.
                        '<option value='.$data['Code'].'>'.utf8_encode($data['WarehouseName']).'</option>';
              }
              echo  $cadena_warehouse.
              "</select> <br>";

        $query_list = "SELECT product.Code, product.ProductName FROM dbo.Owner LEFT JOIN Product ON (dbo.Owner.Code = Product.owner) WHERE dbo.Owner.Code =  $owner AND product.disabled = 0";
        $result = sqlsrv_query ($conn, $query_list);

        $cadena_product="<label class='text-gray-700 text-base'>Select Owner Product</label>        
            <select class='mt-3 p-2 form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300
            transition ease-in-out m-0 focus:text-gray-600 focus:bg-white focus:border-blue-600 focus:outline-none bg-gray-100' 
            id='lista2' name='lista2'>";
    
            while ($data = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                    $cadena_product = $cadena_product.
                    '<option value='.$data['Code'].'>'.utf8_encode($data['ProductName']).'</option>';
            }
            echo  $cadena_product.
            "</select>";
?>