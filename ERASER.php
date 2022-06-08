
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-700 dark:text-gray-400">
                        <thead class="text-xs text-white uppercase bg-gray-700 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Serial Number(s)
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">
                                    <?php for ($i=0; count($items_array) > $i;){ ?>
                                        <tr>
                                            <td> 
                                                <?php echo(json_encode($items_array[$i]));
                                                    $i++; 
                                                    } ?> 
                                            </td>
                                        </tr> 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-700 dark:text-gray-400">
        <thead class="text-xs text-white uppercase bg-gray-700 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Serial Number(s)
                </th>
            </tr>
        </thead>

        <div class="grid-container">
        <?php for ($i=0; count($items_array) > $i;){?>
            <div class="grid-item">
                <?php echo (json_encode ($items_array[$i]) );
                    $i++; 
                    } 
                ?> 
            </div>
        </div>
    </table>
</div>


// // Display information from table Items
    // $displayTable_query = " SELECT SerialNumber FROM Item ORDER BY Code DESC ";
    // $result = sqlsrv_query ($conn, $displayTable_query);
    // $num_rows = sqlsrv_num_rows($result);

    // // if($num_rows > 0){
    //     while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    //         $displayTable .=' 
    //         <tr>
    //             <td>'.$row["SerialNumber"].'</td>
    //         </tr>
    //         ';
    //     }
        
    //  }
//     else{
//         $displayTable .= '
//             <tr>
//                 <td>There are not entry(s)</td>
//            </tr>
//          ';
//    }


<table class="border-collapse w-full">
                        <thead>
                            <tr>
                                <th class="p-3 font-bold text-xs uppercase bg-gray-700 dark:bg-gray-700 dark:text-gray-400 text-white border border-gray-300 hidden lg:table-cell">Serial Number(s)</th>
                            </tr>
                        </thead>
                    
                        <tbody>
                            <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <?php for ($i=0; count($items_array) > $i;){
                                            echo (json_encode ($items_array[$i]) );
                                            $i++; 
                                            } 
                                        ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>