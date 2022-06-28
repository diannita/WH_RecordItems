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


        $query_list = "SELECT product.Code, product.ProductName FROM dbo.Owner LEFT JOIN Product ON (dbo.Owner.Code = Product.owner) WHERE dbo.Owner.Code =  $owner AND product.disabled = 0 ORDER BY ProductName ASC";
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
            "</select> <br>";


        $query_list = "SELECT product.Code, product.AlphaCode FROM dbo.Owner LEFT JOIN Product ON (dbo.Owner.Code = Product.owner) WHERE dbo.Owner.Code =  $owner AND product.disabled = 0 ORDER BY AlphaCode ASC";
        $result = sqlsrv_query ($conn, $query_list);

        $cadena_product_alphaCode = "<label class='text-gray-700 text-base'>Product Part #</label>
        <select class='mt-3 p-2 form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300
        transition ease-in-out m-0 focus:text-gray-600 focus:bg-white focus:border-blue-600 focus:outline-none bg-gray-100' 
        id='lista3' name='lista3'>";
        
        while ($data = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $cadena_product_alphaCode = $cadena_product_alphaCode.
            '<option value='.$data['Code'].'>'.utf8_encode($data['AlphaCode']).'</option>';
        }
        echo  $cadena_product_alphaCode.
        "</select> <br>";


        $query_list = "SELECT Location.Code, LocationName FROM Location LEFT JOIN Warehouse ON Location.Warehouse = Warehouse.Code WHERE location.Disabled = '0' AND Warehouse.Owner = $owner ORDER BY LocationName ASC";
        $result = sqlsrv_query ($conn, $query_list);

        $cadena_location="<label class='text-gray-700 text-base'>Select Location</label>        
             <select class='mt-3 p-2 form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300
             transition ease-in-out m-0 focus:text-gray-600 focus:bg-white focus:border-blue-600 focus:outline-none bg-gray-100' 
             id='lista4' name='lista4'>";

             while ($data = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        $cadena_location = $cadena_location.
                        '<option value='.$data['Code'].'>'.utf8_encode($data['LocationName']).'</option>';
              }
              echo  $cadena_location.
              "</select>";


?>