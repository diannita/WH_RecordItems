<body>
        <!-- Component Start -->
        <div class="flex flex-col items-center justify-center min-h-screen  text-gray-700 bg-gray-100 md:p-20">
            <h2 class="text-2xl font-medium">Warehouse Web Registration Tool </h2>

                <div class="flex flex-wrap items-center justify-center w-full max-w-4xl mt-8">
                    <form method="POST" class="form bg-white p-6 my-10 relative "> 
               
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

                        <!-- <div class="flex space-x-2 mt-3">
                            <select class="border p-2 w-full focus:text-gray-600 focus:bg-white focus:border-blue-600 bg-gray-100" name="dropdown_location" id="dropdown_location" required>
                            </select>
                        </div> -->

                        <div id="lines" class="text-orange-700 pt-5"></div>
                        <textarea name="items" id='output' rows="10" placeholder="Add your item(s) here!" class="resize-none border p-2 mt-3 w-full bg-gray-100" required autofocus></textarea>
                    
                        <p class="font-bold text-sm mt-3">Quantity saved..</p>
                        <div class="flex items-baseline mt-2">
                            <p>Hey! congratulations.. you saved today <strong><?php echo $quantity_enter ?></strong> </p>
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

                <div align="center" style="padding-top:20px;">
                    <div class="text-black text-lg"><strong> Serial Number(s)</strong></div>
                        <div class="grid-container border p-2 mt-3 w-full bg-gray-200">
                            <?php for ($i=0; count($items_array) > $i;){?>
                                <div class="grid-item">
                                    <?php echo($items_array[$i]) ;
                                        $i++; 
                                    ?> 
                        </div>
                        <?php } ?>
                    </div>
                </div>
        </div>
        <!-- Component End  -->
</body>